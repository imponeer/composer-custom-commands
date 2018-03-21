<?php

namespace Imponeer\ComposerCustomCommands;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\Capability\CommandProvider;
use Composer\Plugin\Capable;
use Composer\Plugin\PluginInterface;
use Imponeer\ComposerCustomCommands\CommandProvider as LocalCommandProvider;

/**
 * Defines plugin
 *
 * @package Imponeer\ComposerCustomCommand
 */
class Plugin implements PluginInterface, Capable
{

	/**
	 * Composer instance
	 *
	 * @var Composer
	 */
	protected static $composer;

	/**
	 * Gets composer instance
	 *
	 * @return Composer
	 */
	public static function getComposer()
	{
		return self::$composer;
	}

	/**
	 * Method executed when activating plugin
	 *
	 * @param Composer $composer Composer instance
	 * @param IOInterface $io IO interface
	 */
	public function activate(Composer $composer, IOInterface $io)
	{
		$this->composer = $composer;
	}

	/**
	 * Gets capabilities of object
	 *
	 * @return array
	 */
	public function getCapabilities()
	{
		return array(
			CommandProvider::class => LocalCommandProvider::class
		);
	}
}