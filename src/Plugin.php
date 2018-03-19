<?php

namespace Imponeer\ComposerCustomCommands;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\Capability\CommandProvider;
use Composer\Plugin\Capable;
use Composer\Plugin\PluginInterface;
use Imponeer\ComposerCustomCommands\Exceptions\CommandsConfigIsNotArrayException;

/**
 * Defines plugin
 *
 * @package Imponeer\ComposerCustomCommand
 */
class Plugin implements PluginInterface, Capable
{
	/**
	 * Array with all commands classes that should be registered
	 *
	 * @var array
	 */
	private static $commands_classes = array();

	/**
	 * Gets commands classes for reading outside class
	 *
	 * @return array
	 */
	public static function getCommandsClasses()
	{
		return self::$commands_classes;
	}

	/**
	 * Method executed when activating plugin
	 *
	 * @param Composer $composer Composer instance
	 * @param IOInterface $io IO interface
	 */
	public function activate(Composer $composer, IOInterface $io)
	{
		$extra = $composer->getPackage()->getExtra();
		if (isset($extra['commands'])) {
			if (!is_array($extra['commands'])) {
				throw new CommandsConfigIsNotArrayException();
			}
			self::$commands_classes = $extra['commands'];
		}
	}

	/**
	 * Gets capabilities of object
	 *
	 * @return array
	 */
	public function getCapabilities()
	{
		return array(
			CommandProvider::class => \Imponeer\ComposerCustomCommands\CommandProvider::class
		);
	}
}