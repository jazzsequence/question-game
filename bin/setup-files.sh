#!/usr/bin/env bash

set -euo pipefail

# Ensure src/data directory exists or create it
mkdir -p src/data
cd src/data || exit

generate_manifest_json() {
  read -rp "Enter the name of the game: " game_name
  declare -a levels_order
  declare -A levels_questions

  # Collect levels and their question counts
  while :; do
    read -rp "Enter the level name (or leave empty to stop): " level_name
    [[ -z "$level_name" ]] && break
    read -rp "Enter the number of questions for level $level_name: " question_count

    levels_order+=("$level_name")
    levels_questions["$level_name"]=$question_count

    # Prepare an empty array for the level's questions
    echo "[]" > "${level_name}.json"
  done

  # Build the JSON parts for levels and questions
  levels_json=""
  questions_json=""
  level_index=1
  for level in "${levels_order[@]}"; do
    levels_json+="\"$level\": $level_index,"
    questions_json+="\"$level\": ${levels_questions[$level]},"
    ((level_index++))
  done
  levels_json=${levels_json%,}
  questions_json=${questions_json%,}

  # Combine the parts into the final JSON
  json="{\"name\": \"$game_name\", \"levels\": {${levels_json}}, \"questions\": {${questions_json}}}"

  echo "$json" | jq '.' > manifest.json

  echo "Generated manifest.json with levels and questions."
}

generate_manifest_json
