#!/usr/bin/env bash
set -euo pipefail

root="$(cd "$(dirname "$0")/.." && pwd)"
plugin_dir="mgd-barrierefrei-wordpress"
output="$root/release/mgd-barrierefrei-wordpress.zip"

rm -f "$output"
mkdir -p "$(dirname "$output")"
(
  cd "$root"
  zip -qr "$output" "$plugin_dir" \
    -x "$plugin_dir/.DS_Store" \
    -x "$plugin_dir/assets/*.map"
)
shasum -a 256 "$output" > "$output.sha256"
unzip -t "$output" >/dev/null
printf 'Paket erstellt: %s\n' "$output"
