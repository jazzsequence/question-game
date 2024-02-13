#!/usr/bin/env bash

set -euo pipefail

# Ensure src/data directory exists or create it
mkdir -p src/data
cd src/data || exit

generate_manifest_json() {
  read -rp "Enter the name of the game: " game_name
  declare -A levels_questions

  # Collect levels and their question counts
  while :; do
    read -rp "Enter the level name (or leave empty to stop): " level_name
    [[ -z "$level_name" ]] && break
    read -rp "Enter the number of questions for level $level_name: " question_count

    levels_questions["$level_name"]=$question_count

    # Prepare an empty array for the level's questions
    echo "[]" > "${level_name}.json"
  done

  # Start building the JSON
  json="{\"name\": \"$game_name\", \"levels\": {"
  levels_json=""
  questions_json=""

  for level in "${!levels_questions[@]}"; do
    levels_json="$levels_json\"$level\": ${levels_questions[$level]},"
    questions_json="$questions_json\"$level\": ${levels_questions[$level]},"
  done

  # Remove trailing commas
  levels_json=${levels_json%,}
  questions_json=${questions_json%,}

  # Complete the JSON structure
  json="$json $levels_json }, \"questions\": { $questions_json }}"

  echo $json | jq '.' > manifest.json

  echo "Generated manifest.json with levels and questions."
}

generate_manifest_json
