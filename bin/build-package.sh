#!/bin/sh
set -eu

project_dir=$(CDPATH= cd -- "$(dirname -- "$0")/.." && pwd)
build_dir="$project_dir/build"
stage_dir="$build_dir/wp-post-nav"
package_file="$project_dir/wp-post-nav.zip"

# Only these top-level items belong in the WordPress.org package. Everything
# else (development notes, agent and Spec Kit files, tests, tooling and the
# WordPress.org banner images in assets/) stays out. Add a new plugin folder
# or file here on purpose; never switch back to a list of things to leave out.
allowed='admin includes languages public index.php uninstall.php wp-post-nav.php README.txt LICENSE.txt Examples.txt'

# Hidden files the plugin needs at run time. Any other hidden file stops the
# build rather than being dropped quietly.
allowed_hidden='public/css/.htaccess'

rm -rf "$build_dir"
mkdir -p "$stage_dir"

for item in $allowed; do
  if [ ! -e "$project_dir/$item" ]; then
    printf 'Build stopped: allowed item %s is missing.\n' "$item" >&2
    exit 1
  fi
  rsync -a --exclude '.DS_Store' "$project_dir/$item" "$stage_dir/"
done

# Guard: stop if anything unexpected reached the package, naming each file.
unexpected=''
for path in $(cd "$stage_dir" && find . \( -name '.*' ! -name '.' \) -o -name '*.md' | sed 's#^\./##'); do
  case " $allowed_hidden " in
    *" $path "*) ;;
    *) unexpected="$unexpected
$path" ;;
  esac
done
for entry in $(cd "$stage_dir" && ls -A); do
  case " $allowed " in
    *" $entry "*) ;;
    *) unexpected="$unexpected
$entry" ;;
  esac
done
unexpected=$(printf '%s\n' "$unexpected" | sed '/^$/d')

if [ -n "$unexpected" ]; then
  printf 'Build stopped: these files must not be in the plugin package:\n%s\n' "$unexpected" >&2
  rm -rf "$build_dir"
  exit 1
fi

rm -f "$package_file"
(cd "$build_dir" && zip -qr "$package_file" wp-post-nav)
rm -rf "$build_dir"

printf 'Built %s\n' "$package_file"
