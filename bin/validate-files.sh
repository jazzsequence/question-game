#!/usr/bin/env bash

set -euo pipefail

# Set the directory containing the JSON files
data_dir="./src/data"

# Function to validate manifest.json
validate_manifest() {
    manifest="$data_dir/manifest.json"
    if [[ ! -f "$manifest" ]]; then
        echo "manifest.json does not exist."
        return 1
    fi

    # Validate structure and types
    jq_errors=$(jq -r '
        if .name | type != "string" then "Invalid name"
        elif .levels | type != "object" then "Invalid levels object"
        elif .questions | type != "object" then "Invalid questions object"
        else empty
        end
    ' "$manifest")
    
    if [[ -n "$jq_errors" ]]; then
        echo "Validation errors in manifest.json:"
        echo "$jq_errors"
        return 1
    fi

    # Initialize expected level value
    expected_level=1

    # Extract levels and validate them
    mapfile -t levels < <(jq -r '.levels | to_entries | sort_by(.value) | .[].value' "$manifest")

    for level in "${levels[@]}"; do
        if [[ "$level" -ne "$expected_level" ]]; then
            echo "Level $level is not sequential or missing. Expected $expected_level."
            return 1
        fi
        ((expected_level++))
    done

    echo "manifest.json is valid."
}

# Validate level JSON files against project-specific requirements
validate_level_files() {
    for file in "$data_dir"/*.json; do
        [[ "$(basename "$file")" == "manifest.json" ]] && continue  # Skip manifest.json

        # Validate file is a JSON array
        if ! jq -e 'type == "array"' "$file" > /dev/null; then
            echo "Error in $file: File is not a valid JSON array." >&2
            continue
        fi

        # Validate each element in the array is a string
        if ! jq -e 'all(.[]; type == "string")' "$file" > /dev/null; then
            echo "Error in $file: All elements must be strings." >&2
            continue
        fi

        echo "$file is validated successfully."
    done
}

validate_manifest && validate_level_files

echo "Done validating files."
