#!/bin/bash

root_directory="/home/xxxx.site/public_html/public/drive" # Modify the Path accordingly

# Find all MKV files and loop through them
shopt -s globstar
for mkv_file in "$root_directory"/**/*.mkv; do
    # Check if the file is a regular file
    [ -f "$mkv_file" ] || continue

    # Get the directory of the MKV file
    dir=$(dirname "$mkv_file")

    # Get the filename without extension
    filename=$(basename -- "$mkv_file")
    filename_no_ext="${filename%.*}"

    # Define the output MP4 file with the additional string
    mp4_file="$dir/$filename_no_ext.mp4"

    # Check if the output MP4 file already exists, if yes, skip the conversion
    if [ -e "$mp4_file" ]; then
        echo "Skipped: $mkv_file already converted to $mp4_file"
        continue
    fi

    # Run ffmpeg command to convert MKV to MP4 with re-encoding EAC3 to AAC stereo
    ffmpeg -i "$mkv_file" -c:v copy -c:a aac -ac 2 -strict experimental "$mp4_file"

    echo "Converted: $mkv_file to $mp4_file"
done
