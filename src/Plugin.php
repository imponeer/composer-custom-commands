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
use Imponeer\ComposerCustomCommands\Exceptions\CommandsConfigIsNotArrayException;
use Imponeer\ComposerCustomCommands\CommandProvider as LocalCommandProvider;

/**
 * Defines plugin
 *
 * @package Imponeer\ComposerCustomCommand
 */
class Plugin implements PluginInterface, Capable, EventSubscriberInterface
{

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
		if (isset($extra['commands'])) {
			if (!is_array($extra['commands'])) {
				throw new CommandsConfigIsNotArrayException();
			}
			$event->getIO()->write('<info>Updating commands cache...</info>');
			DataCache::getInstance()->write($extra['commands']);
		}
	}
}