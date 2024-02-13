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

# Function to validate other JSON files
validate_level_files() {
    # Extract level names from manifest.json
    mapfile -t level_names < <(jq -r '.levels | keys | .[]' "$data_dir/manifest.json")
    
    for level_name in "${level_names[@]}"; do
        file="$data_dir/${level_name}.json"
        if [[ ! -f "$file" ]]; then
            echo "JSON file for level $level_name does not exist."
            return 1
        fi

        # Validate JSON array
        if ! jq -e 'type == "array"' "$file" > /dev/null; then
            echo "$file does not contain a valid JSON array."
            return 1
        fi
    done

    echo "All level JSON files are valid."
}

validate_manifest && validate_level_files
