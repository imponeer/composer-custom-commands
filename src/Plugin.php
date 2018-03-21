<?php

namespace Imponeer\ComposerCustomCommands;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\Capability\CommandProvider;
use Composer\Plugin\Capable;
use Composer\Plugin\PluginInterface;
use Composer\Script\Event;
use Composer\Script\ScriptEvents;
use Imponeer\ComposerCustomCommands\CommandProvider as LocalCommandProvider;

/**
 * Defines plugin
 *
 * @package Imponeer\ComposerCustomCommand
 */
class Plugin implements PluginInterface, Capable, EventSubscriberInterface
{

	/**
	 * Place where in extras all config variables are stored
	 */
	const CONFIG_NAMESPACE = 'custom-commands';

	/**
	 * Gets all subscribed events for plugin
	 *
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return array(
			ScriptEvents::POST_AUTOLOAD_DUMP => array('onPostAutoloadDump', 0)
		);
	}

	/**
	 * Method executed when activating plugin
	 *
	 * @param Composer $composer Composer instance
	 * @param IOInterface $io IO interface
	 */
	public function activate(Composer $composer, IOInterface $io)
	{

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

	/**
	 * Using post autodump event to create cached version of commands
	 *
	 * @param Event $event
	 *
	 * @throws CommandsConfigIsNotArrayException
	 */
	public function onPostAutoloadDump(Event $event)
	{
		$composer = $event->getComposer();
		$extra = $composer->getPackage()->getExtra();

		$event->getIO()->write('<info>Updating commands cache</info>');
		$commands = (isset($extra[self::CONFIG_NAMESPACE]) && isset($extra[self::CONFIG_NAMESPACE]['commands'])) ? $extra[self::CONFIG_NAMESPACE]['commands'] : array();

		DataCache::getInstance()->write($commands);
	}
}