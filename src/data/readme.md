# Question Game Data

This file stores all questions/actions for the game in `.json` files.

A `manifest.json` file must exist and it must contain the structure of additional `.json` files. The `manifest.json` should include the levels used in the game, as JSON key/value pairs in the following format:

```json
{
    "levels": {
        "easy": 1,
        "medium": 2,
        "hard": 3
    }
}
```

Level names can be anything, but they must correspond to the actual `json` files containing that data (e.g. `easy.json`, `medium.json`, `hard.json`). These files will contain `json` arrays of the data that will be used to populate the game (activities or actions).

(Note: Despite the name of this project, questions in the game do not have answers, they are meant more as a "truth or dare" or "have you ever"-style conversation-starter game rather than a trivia game.)

