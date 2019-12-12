# Question Game Data

This file stores all questions/actions for the game in `.json` files.

A `manifest.json` file must exist and it must contain the structure of additional `.json` files. The `manifest.json` should include the levels used in the game, as JSON key/value pairs in the following format:

```json
{
    "name": "My Awesome Game",
    "levels": {
        "easy": 1,
        "medium": 2,
        "hard": 3
    },
    "questions": {
        "easy": 20,
        "medium": 10,
        "hard": 5
    }
}
```

## Name
The name parameter defines a game title that appears in the container around the question. If this isn't set, it will simply say "Game". This is also used for the page title in the browser tab.

## Levels
Level names can be anything, but they must correspond to the actual `json` files containing that data (e.g. `easy.json`, `medium.json`, `hard.json`). These files will contain `json` arrays of the data that will be used to populate the game (activities or actions).

## Questions
The questions object stores the number of questions that should be asked for each level. Questions will be randomly selected from the level's `json` file until reaching the value set for that level, then the level will be increased and the cycle continued.

When the last question is asked in the highest level, the game ends.

(Note: Despite the name of this project, questions in the game do not have answers, they are meant more as a "truth or dare" or "have you ever"-style conversation-starter game rather than a trivia game.)

