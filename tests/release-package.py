#!/usr/bin/env python3
"""Prüft die gebaute GitHub-ZIP und ihre Versions- und Dateigrenzen."""

import argparse
import hashlib
import json
from pathlib import Path, PurePosixPath
import re
import stat
from zipfile import ZipFile


def check(root, archive):
    root = Path(root).resolve()
    config = json.loads((root / "tests/catalog-config.json").read_text(encoding="utf-8"))
    prefix = config["runtime"] + "/"
    version = config["version"]
    with ZipFile(archive) as package:
        if package.testzip() is not None:
            raise ValueError("Beschädigtes ZIP")
        names = package.namelist()
        if len(names) != len(set(names)):
            raise ValueError("Doppelte ZIP-Einträge")
        for info in package.infolist():
            name = info.filename
            path = PurePosixPath(name)
            if not name.startswith(prefix) or path.is_absolute() or ".." in path.parts or "\\" in name:
                raise ValueError("Datei außerhalb der Pluginwurzel")
            if stat.S_ISLNK(info.external_attr >> 16):
                raise ValueError("Dateiverweise gehören nicht ins Pluginpaket")
            if any(part in {".git", ".github", "tests", "node_modules", ".DS_Store"}
                   or part.startswith(".env") for part in path.parts):
                raise ValueError("Entwicklungs- oder Geheimnisdatei im Paket")
            if path.suffix.lower() in {".pem", ".key", ".sqlite", ".map"}:
                raise ValueError("Unerwünschte Laufzeitdatei im Paket")
            if not info.is_dir() and info.file_size < 2_000_000:
                content = package.read(name)
                if re.search(rb"-----BEGIN (?:RSA |OPENSSH |EC )?PRIVATE KEY-----|ghp_[A-Za-z0-9]{30,}|github_pat_[A-Za-z0-9_]{50,}", content):
                    raise ValueError("Mögliches Geheimnis im Paket")
        main = package.read(prefix + config["main"]).decode("utf-8")
        checks = [
            rf"Version:\s*{re.escape(version)}\s",
            rf"define\('MGD_BARRIEREFREI_VERSION', '{re.escape(version)}'\)",
            r"Setup::updater\(__FILE__, 'mgd-barrierefrei-wordpress'",
        ]
        if not all(re.search(pattern, main) for pattern in checks):
            raise ValueError("Version oder Baukasten-Updater stimmt nicht")
        readme = package.read(prefix + "readme.txt").decode("utf-8")
        if not re.search(rf"^Stable tag:\s*{re.escape(version)}$", readme, re.M):
            raise ValueError("Stable-Tag stimmt nicht")
        # ab MGD Tools: alter Katalog weg, Icons + Baukasten müssen drin sein
        names = set(package.namelist())
        for gone in ["includes/plugin-catalog/plugins.json", "includes/class-mgd-plugin-admin-tools.php", "includes/class-mgd-barrierefrei-updater.php"]:
            if prefix + gone in names:
                raise ValueError("Alter Teil noch im ZIP: " + gone)
        for need in ["assets/icon-128x128.png", "assets/icon-256x256.png", "uninstall.php", "includes/Kit/Platform/WordPress/Tools.php", "includes/Kit/Platform/WordPress/CatalogInstaller.php"]:
            if prefix + need not in names:
                raise ValueError("Fehlt im ZIP: " + need)
        for source in (root / config["runtime"] / "includes/Kit").rglob("*"):
            if source.is_file() and source.name != ".DS_Store":
                relative = source.relative_to(root / config["runtime"]).as_posix()
                if package.read(prefix + relative) != source.read_bytes():
                    raise ValueError("Unvollständiger Baukasten im ZIP")
    digest = hashlib.sha256(Path(archive).read_bytes()).hexdigest()
    return f"PASS ZIP {version}: eine Pluginwurzel, Baukasten, Icons, keine Entwicklungsdateien; SHA-256 {digest}"


if __name__ == "__main__":
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument("archive")
    args = parser.parse_args()
    print(check(Path(__file__).resolve().parents[1], args.archive))
