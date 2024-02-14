#!/usr/bin/env bash

set -e

# Set the directory containing the JSON files
data_dir="./src/data"
errors=0

# Function to validate manifest.json
validate_manifest() {
    local manifest_file="$data_dir/manifest.json"


    # Check existence of manifest.json
    if [[ ! -f "$manifest_file" ]]; then
        echo "manifest.json does not exist." >&2
		errors=$((errors + 1))
    fi

	set +e
    # Validate "levels" to ensure all values are numbers
    if ! jq -e '.levels | map_values(type == "number") | all' "$manifest_file" > /dev/null; then
        echo "Error in manifest.json: All 'levels' values must be numbers." >&2
		errors=$((errors + 1))
    fi

    # Validate "questions" to ensure all values are numbers or strings that can be interpreted as numbers
    if ! jq -e '.questions | map_values(type == "number" or (type == "string" and test("^[0-9]+$"))) | all' "$manifest_file" > /dev/null; then
        echo "Error in manifest.json: All 'questions' values must be numeric or strings representing numeric values." >&2
		errors=$((errors + 1))
    fi
	set -e

	# Return 0 if no errors were found
	if [[ $errors -eq 0 ]]; then
    	echo "manifest.json is valid."
    	return 0
	fi
}

# Validate level JSON files against project-specific requirements
validate_level_files() {
    for file in "$data_dir"/*.json; do
        [[ "$(basename "$file")" == "manifest.json" ]] && continue  # Skip manifest.json

        # Validate file is a JSON array
        if ! jq -e 'type == "array"' "$file" > /dev/null; then
            echo "Error in $file: File is not a valid JSON array." >&2
			errors=$((errors + 1))
            continue
        fi

        # Validate each element in the array is a string
        if ! jq -e 'all(.[]; type == "string")' "$file" > /dev/null; then
            echo "Error in $file: All elements must be strings." >&2
			errors=$((errors + 1))
            continue
        fi

        echo "$file is validated successfully."
    done
}

validate_manifest && validate_level_files

# Exit with an error code if any validation errors were found
if [[ $errors -gt 0 ]]; then
	echo "Validation failed with $errors errors." >&2
	exit 1
fi

echo "Done validating files."
