# Question Game
[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)

A simple game framework with escallating challenge levels

## Description

Did you ever want to write your own game? Now you can!

This project is a very basic game framework that works best as a "Truth or Dare" or "Simon Says" sort of game, where the players take turns performing an action or answering a question. No answers are stored anywhere in the game (so it works better for games that don't have specific answers or where the goal is conversation starting rather than a "pub quiz"-style trivia game) and no database is used at all.

Turn tracking is currently done using cookie data. In a future iteration, I may try to use browser local storage to store turn information, but this is a proof-of-concept.

Your game content (questions/actions/etc.) is stored in custom `.json` files stored in the `/data` directory. See the [`readme.md`](https://github.com/jazzsequence/question-game/blob/master/src/data/readme.md) file in that directory for more information about setting up your own game.

## Installation Requirements

The easiest way to play the game is to use Lando to set up a simple web environment on which to run it. A `.lando.yml` file has been provided to facilitate setting up the environment. Simply run `lando start` in the root project directory to start the game.

Alternately you can use a different virtual machine environment like [Vagrant](https://www.vagrantup.com/), your own [Docker](https://www.docker.com/) box, using a platform like [WAMP](http://www.wampserver.com/en/)/[MAMP](https://www.mamp.info/en/) or local [LAMP](https://www.digitalocean.com/community/tags/lamp-stack?type=tutorials) stack. The game is written in PHP, so it won't work without some server that's able to serve PHP files in a browser.

## External Libraries

This project uses the [nes.css](https://nostalgic-css.github.io/NES.css/) library for a retro game visual design which is the only external library used in the actual game itself.

The following developer libraries are included via Composer or NPM for development:

* [humanmade/coding-standards](https://packagist.org/packages/humanmade/coding-standards) (Composer package)
* [humanmade/stylelint-config](https://www.npmjs.com/package/@humanmade/stylelint-config) (Node package)
* [babel-eslint](https://www.npmjs.com/package/babel-eslint) (Node package)
* [del](https://www.npmjs.com/package/del) (Node package)
* [eslint](https://www.npmjs.com/package/eslint) (Node package)
* [eslint-config-humanmade](https://www.npmjs.com/package/eslint-config-humanmade) (Node package)
* [eslint-config-react-app](https://www.npmjs.com/package/eslint-config-react-app) (Node package)
* [eslint-plugin-flowtype](https://www.npmjs.com/package/eslint-plugin-flowtype) (Node package)
* [eslint-plugin-import](https://www.npmjs.com/package/eslint-plugin-import) (Node package)
* [eslint-plugin-jsx-a11y](https://www.npmjs.com/package/eslint-plugin-jsx-a11y) (Node package)
* [eslint-plugin-react](https://www.npmjs.com/package/eslint-plugin-react) (Node package)
* [gulp](https://www.npmjs.com/package/gulp) (Node package)
* [gulp-sass](https://www.npmjs.com/package/gulp-sass) (Node package)
* [node-sass](https://www.npmjs.com/package/node-sass) (Node package)
* [stylelint](https://www.npmjs.com/package/stylelint) (Node package)