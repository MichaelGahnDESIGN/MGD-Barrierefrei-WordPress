#!/usr/bin/env bash
set -euo pipefail

root="$(cd "$(dirname "$0")/.." && pwd)"
plugin_dir="mgd-barrierefrei-wordpress"
output="$root/release/mgd-barrierefrei-wordpress.zip"

rm -f "$output"
mkdir -p "$(dirname "$output")"
(
  cd "$root"
  zip -Xqr "$output" "$plugin_dir" \
    -x "$plugin_dir/.DS_Store" \
    -x "$plugin_dir/assets/*.map"
)
(
  cd "$(dirname "$output")"
  shasum -a 256 "$(basename "$output")" > "$(basename "$output").sha256"
)
# Kopie mit Version im Namen fuer die Update-Datei auf theme.michael-gahn.de
version="$(sed -n 's/^ \* Version: *//p' "$root/$plugin_dir/$plugin_dir.php" | head -1)"
versioned="$root/release/mgd-barrierefrei-wordpress-$version.zip"
cp "$output" "$versioned"
(
  cd "$(dirname "$versioned")"
  shasum -a 256 "$(basename "$versioned")" > "$(basename "$versioned").sha256"
)
unzip -t "$output" >/dev/null
python3 "$root/scripts/check_plugin_ready.py" "$root" --zip "$output"
python3 "$root/tests/release-package.py" "$output"
printf 'Paket erstellt: %s\n' "$output"
