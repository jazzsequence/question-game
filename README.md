# Question Game
[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)

A simple game framework written in PHP with escallating challenge levels

## Description

Did you ever want to write your own game? Now you can!

This project is a very basic game framework that works best as a "Truth or Dare" or "Simon Says" sort of game, where the players take turns performing an action or answering a question. No answers are stored anywhere in the game (so it works better for games that don't have specific answers or where the goal is conversation starting rather than a "pub quiz"-style trivia game) and no database is used at all.

Turn tracking is currently done using cookie data. In a future iteration, I may try to use browser local storage to store turn information, but this is a proof-of-concept.

Your game content (questions/actions/etc.) is stored in custom `.json` files stored in the `/data` directory. See the [`readme.md`](https://github.com/jazzsequence/question-game/blob/master/src/data/readme.md) file in that directory for more information about setting up your own game.

## Installation Requirements

The easiest way to play the game is to use Lando to set up a simple web environment on which to run it. A `.lando.yml` file has been provided to facilitate setting up the environment. Simply run `lando start` in the root project directory to start the game.

You will also need to install [jq](https://jqlang.github.io/jq/) if you want to use the helper script to generate your game data files. This can be installed via Homebrew as described below.

Alternately you can use a different virtual machine environment like [Vagrant](https://www.vagrantup.com/), your own [Docker](https://www.docker.com/) box, using a platform like [WAMP](http://www.wampserver.com/en/)/[MAMP](https://www.mamp.info/en/) or local [LAMP](https://www.digitalocean.com/community/tags/lamp-stack?type=tutorials) stack. The game is written in PHP, so it won't work without some server that's able to serve PHP files in a browser.

## Generating Game Data Files

A script has been provided to help you generate your game data. It will create the `manifest.json` file based on a series of prompts that ask the names of the levels you want your game to have and how many questions each level will require. It will then create empty JSON files for your questions to go. It will not add your questions for you, but those should be easy to handle yourself (see the [readme]() for more information).

To run the script, in a terminal window run:

```bash
composer setup-files
```

You can remove generated files you don't want by running `composer clean-files`.

For the best experience, you should install `jq` on your local machine. This can be installed on a Mac via Homebrew:

```bash
brew install jq
```

## External Libraries

This project uses a fork of the [nes.css](https://nostalgic-css.github.io/NES.css/) library for a retro game visual design. Additionally, it uses [jq](https://jqlang.github.io/jq/) to parse JSON data which is used by the helper script to generate data files.

The following developer libraries are included via Composer or NPM for development:

* [nes.css (jazzsequence fork)](https://github.com/jazzsequence/nes.css) (Composer package)
* [pantheon-systems/pantheon-wp-coding-standards](https://packagist.org/packages/pantheon-systems/pantheon-wp-coding-standards) (Composer package)
* [humanmade/eslint-config](https://www.npmjs.com/package/@humanmade/eslint-config) (Node package)
* [humanmade/stylelint-config](https://www.npmjs.com/package/@humanmade/stylelint-config) (Node package)
* [gulp](https://www.npmjs.com/package/gulp) (Node package)
* [node-sass](https://www.npmjs.com/package/node-sass) (Node package)
* [jq](https://jqlang.github.io/jq/) (System library)
* [lando](https://docs.lando.dev/) (System library)

## Ideas for the future

The following are some ideas I have that could be implemented in future iterations:

* Use browser local storage or NoSQL to store data instead of cookies.
* Allow `json` files to be uploaded and parsed to create the game data.
* Create a game-builder interface where the files can be created and edited in the browser.
* Allow multiple games to be installed simultaneously (multiple manifests).
* Add comprehensive unit testing!
* Add autotag action.
* Run entirely in the browser!
