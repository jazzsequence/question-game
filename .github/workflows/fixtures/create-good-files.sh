#!/usr/bin/env bash

set -euo pipefail

# Navigate to the data directory or wherever you want these files to be saved
cd $GITHUB_WORKSPACE/src/data

# Create easy.json with valid JSON data
echo '[
    "What is your favorite color?",
    "Describe your first pet.",
    "What is your earliest memory?"
]' > easy.json

# Create medium.json with valid JSON data
echo '[
    "What\'s the most adventurous thing you\'ve ever done?",
    "What\'s your dream vacation destination?",
    "Who do you admire the most?"
]' > medium.json

# Create hard.json with valid JSON data
echo '[
    "What was the last book you read and thoroughly enjoyed?",
    "How do you like to spend a rainy day?",
    "If you could learn one new skill, what would it be?"
]' > hard.json
