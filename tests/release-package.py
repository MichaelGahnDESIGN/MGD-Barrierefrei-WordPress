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
            rf"'version'\s*=>\s*'{re.escape(version)}'",
            r"new MGD_WordPress_Plugin_Catalog_V4\(\)",
        ]
        if not all(re.search(pattern, main) for pattern in checks):
            raise ValueError("Version oder Katalogeinstieg stimmt nicht")
        readme = package.read(prefix + "readme.txt").decode("utf-8")
        if not re.search(rf"^Stable tag:\s*{re.escape(version)}$", readme, re.M):
            raise ValueError("Stable-Tag stimmt nicht")
        data = json.loads(package.read(prefix + "includes/plugin-catalog/plugins.json"))
        if len(data) != 7:
            raise ValueError("Sieben lokale Katalogeinträge erwartet")
        for item in data.values():
            stem = Path(item["icon"]).stem
            for path in ["assets/plugin-catalog/icons/" + item["icon"],
                         "assets/plugin-catalog/backgrounds/" + stem + ".webp"]:
                if package.read(prefix + path) != (root / config["runtime"] / path).read_bytes():
                    raise ValueError("Abweichendes Kartenbild im ZIP")
        # Der komplette lokale Katalog muss im Paket stecken, nicht nur seine Einstiegsklasse.
        for folder in ["includes/plugin-catalog", "assets/plugin-catalog"]:
            for source in (root / config["runtime"] / folder).rglob("*"):
                if source.is_file() and source.name != ".DS_Store" and source.suffix != ".map":
                    relative = source.relative_to(root / config["runtime"]).as_posix()
                    if package.read(prefix + relative) != source.read_bytes():
                        raise ValueError("Unvollständiges Katalogpaket")
    digest = hashlib.sha256(Path(archive).read_bytes()).hexdigest()
    return f"PASS ZIP {version}: eine Pluginwurzel, V4, sieben Icons und Motive, keine Entwicklungsdateien; SHA-256 {digest}"


if __name__ == "__main__":
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument("archive")
    args = parser.parse_args()
    print(check(Path(__file__).resolve().parents[1], args.archive))
