#!/bin/bash

# Go to the project root
cd ../../../

source_directory="vendor/shelane/knot/.docksal/commands"
destination_directory=".docksal/commands"

# Run rsync command
rsync -av --ignore-existing "$source_directory/" "$destination_directory/"

source_directory="vendor/shelane/knot/_knot"
destination_directory="_knot"

# Run rsync command
rsync -av "$source_directory/" "$destination_directory/"

# Create a symbolic link from _knot/index.php to docroot/index.php
cd docroot
ln -sf "../_knot/index.php" "index.php"

