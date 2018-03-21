[![License](https://img.shields.io/github/license/imponeer/composer-custom-commands.svg?maxAge=2592000)](LICENSE)
 [![Build Status](https://travis-ci.org/imponeer/composer-custom-commands.svg?branch=master)](https://travis-ci.org/imponeer/composer-custom-commands) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/imponeer/composer-custom-commands/badges/quality-score.png)](https://scrutinizer-ci.com/g/imponeer/composer-custom-commands/) 
[![PHP from Packagist](https://img.shields.io/packagist/php-v/imponeer/composer-custom-commands.svg)](https://php.net) 
[![Packagist](https://img.shields.io/packagist/v/imponeer/composer-custom-commands.svg)](https://packagist.org/packages/imponeer/composer-custom-commands)

# Composer Custom Commands

Composer plugin that adds a possibility to define console commands as composer commands with [Symfony console](https://symfony.com/doc/current/components/console.html) component syntax.

## Usage

To start using this plugin you need just to do 4 easy steps:

### 1. Add plugin into your composer project:
 
Easiest way to do that is to execute composer command from console:

```bash
composer require imponeer/composer-custom-commands
```

### 2. Create class that that implements new command

It should be look something like this:
```php5
namespace My\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

/**
 * Your new command
 */
class DummyCommand extends Command
{

	/**
	 * Here we can configure command name, options and arguments.
	 * We using here Symfony Command syntax.
	 */
	protected function configure()
	{

	}

	/**
	 * Execute command
	 *
	 * @param InputInterface $input STDInput
	 * @param OutputInterface $output SRDOutput
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{

	}

}
```

### 3. Create or edit config section in projects composer.json and add there section `custom-commands` with `commands` key and add there PHP class names of commands that should be added to composer

This should look something like this:
```javascript
{
	"name": "my-project",
	"description": "",
	"type": "project",
	"require": {
		"imponeer/composer-custom-commands": "*"
	},
	"license": "MIT",
	"authors": [
		{
			"name": "SomeBody SomeOne",
			"email": "internet@is.ours.com"
		}
	],
	"autoload": {
		"psr-4": {
			"My\\": "src/"
		}
	},
	"extra": {
		"custom-commands": {
			"commands": [
				"My\\Commands\\DummyCommand"
			]
		}
	}
}
```

If you need that some script should be executed before every command (f.e. you need to define some constants), you can add there `boot` key with value that is filename relative from place where composer.json is. 

In that case your composer.json should look similar to this:
```javascript
{
	"name": "my-project",
	"description": "",
	"type": "project",
	"require": {
		"imponeer/composer-custom-commands": "*"
	},
	"license": "MIT",
	"authors": [
		{
			"name": "SomeBody SomeOne",
			"email": "internet@is.ours.com"
		}
	],
	"autoload": {
		"psr-4": {
			"My\\": "src/"
		}
	},
	"extra": {
		"custom-commands": {
			"commands": [
				"My\\Commands\\DummyCommand"
			],
			"boot": "boot.php"
		}
	}
}
```

### 4. If you did everything correctly, you will be able to use new composer command that is embeded in your project.

## How to contribute?

If you want to add some functionality or fix bugs, you can fork, change and create pull request. If you not sure how this works, try [interactive GitHub tutorial](https://try.github.io).

If you found any bug or have some questions, use [issues tab](https://github.com/imponeer/composer-custom-commands/issues) and write there your questions.
