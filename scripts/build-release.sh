#!/usr/bin/env bash
set -euo pipefail

root="$(cd "$(dirname "$0")/.." && pwd)"
plugin_dir="mgd-barrierefrei-wordpress"
version="$(sed -n 's/^ \* Version: *//p' "$root/$plugin_dir/$plugin_dir.php" | head -1)"
case "$version" in [0-9]*.[0-9]*.[0-9]*) ;; *) echo "Ungültige Version: $version" >&2; exit 1;; esac
# nur EIN Plugin-ZIP, Version im Namen (Update-Datei auf theme.michael-gahn.de)
output="$root/release/$plugin_dir-$version.zip"

rm -f "$output"
mkdir -p "$(dirname "$output")"
# Staging: Rechte 644/755 setzen (Netzlaufwerk liefert 700, dann 403 bei Icons), keine Punkt-Dateien
stage="$(mktemp -d)"
cp -R "$root/$plugin_dir" "$stage/$plugin_dir"
find "$stage" \( -name '.DS_Store' -o -name '.smbdelete*' -o -name '*.map' \) -delete
find "$stage/$plugin_dir" -type d -exec chmod 755 {} +
find "$stage/$plugin_dir" -type f -exec chmod 644 {} +
(cd "$stage" && zip -Xqr "$output" "$plugin_dir")
rm -rf "$stage"
(
  cd "$(dirname "$output")"
  shasum -a 256 "$(basename "$output")" > "$(basename "$output").sha256"
)
unzip -t "$output" >/dev/null
python3 "$root/scripts/check_plugin_ready.py" "$root" --zip "$output"
python3 "$root/tests/release-package.py" "$output"
