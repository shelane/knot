#!/bin/bash

# Function to copy files if they don't exist
copy_if_not_exists() {
source_file=$1
destination_dir=$2

if [[ ! -f "$destination_dir/$(basename "$source_file")" ]]; then
  cp "$source_file" "$destination_dir/"
fi
}

# Create directories
mkdir -p docroot/assets/bootstrap
mkdir -p docroot/assets/fontawesome/css
mkdir -p docroot/assets/fontawesome/js
mkdir -p docroot/assets/jquery
mkdir -p docroot/assets/js

# Copy files if they don't exist
copy_if_not_exists "starterkit/libraries/bootstrap/dist/css/bootstrap.css" "docroot/assets/bootstrap"
copy_if_not_exists "starterkit/libraries/bootstrap/dist/js/bootstrap.bundle.js" "docroot/assets/bootstrap"
copy_if_not_exists "starterkit/libraries/fontawesome/css/all.css" "docroot/assets/fontawesome/css"
copy_if_not_exists "starterkit/libraries/fontawesome/js/all.js" "docroot/assets/fontawesome/js"
copy_if_not_exists "starterkit/libraries/jquery/dist/jquery.min.js" "docroot/assets/jquery"

# Copy webfonts directory if it doesn't exist
if [[ ! -d "docroot/assets/fontawesome/webfonts" ]]; then
  cp -r "starterkit/libraries/fontawesome/webfonts" "docroot/assets/fontawesome/"
fi

# Copy files if they don't exist
rsync -a --ignore-existing "starterkit/css" "docroot/assets"
rsync -a --ignore-existing "starterkit/js" "docroot/assets"
rsync -a --ignore-existing "starterkit/_templates" "_knot"
