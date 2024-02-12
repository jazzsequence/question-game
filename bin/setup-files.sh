#!/usr/bin/env bash

set -e

# Navigate to the data directory
cd src/data || exit

# Function to prompt for game details and generate JSON files
generate_game_data() {
  read -rp "Enter the name of the game: " game_name
  echo "Enter the levels (e.g., easy, medium, hard), followed by [ENTER] twice to stop:"

  # Read levels into an array
  while IFS= read -r line; do
    [[ $line ]] || break
    levels+=("$line")
  done

  # Create levels and questions objects
  levels_json="{"
  questions_json="{"
  for level in "${levels[@]}"; do
    read -rp "Enter the number of questions for level $level: " num_questions
    levels_json+="\"$level\": \"$level\","
    questions_json+="\"$level\": $num_questions,"
    echo "[]" > "$level.json" # Create a level file with an empty array
  done
  levels_json="${levels_json%,}}" # Remove trailing comma
  questions_json="${questions_json%,}}"

  # Generate the manifest.json content
  manifest_content=$(jq -n \
    --arg name "$game_name" \
    --argjson levels "$levels_json" \
    --argjson questions "$questions_json" \
    '{name: $name, levels: $levels, questions: $questions}')

  # Check for existing manifest files and create a new one if needed
  file_name="manifest.json"
  counter=1
  while [ -f "$file_name" ]; do
    file_name="manifest-$counter.json"
    ((counter++))
  done

  echo "$manifest_content" > "$file_name"
  echo "Generated $file_name and level JSON files."
}

# Call the function
generate_game_data