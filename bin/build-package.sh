#!/bin/sh
set -eu

project_dir=$(CDPATH= cd -- "$(dirname -- "$0")/.." && pwd)
build_dir="$project_dir/build"
package_file="$project_dir/wp-post-nav.zip"

rm -rf "$build_dir"
mkdir -p "$build_dir/wp-post-nav"

rsync -a \
  --exclude '.DS_Store' \
  --exclude '.git/' \
  --exclude '.github/' \
  --exclude 'assets/' \
  --exclude 'tags/' \
  --exclude 'build/' \
  --exclude 'bin/' \
  --exclude 'composer.json' \
  --exclude 'phpcs.xml.dist' \
  --exclude 'phpstan.neon.dist' \
  --exclude '*.zip' \
  "$project_dir/" "$build_dir/wp-post-nav/"

rm -f "$package_file"
(cd "$build_dir" && zip -qr "$package_file" wp-post-nav)
rm -rf "$build_dir"

printf 'Built %s\n' "$package_file"

