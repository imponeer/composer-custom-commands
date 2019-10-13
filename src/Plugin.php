<?php

namespace Imponeer\ComposerCustomCommands;

use Composer\Plugin\Capability\CommandProvider;
use Imponeer\ComposerCustomCommands\CommandProvider as LocalCommandProvider;
use Imponeer\ProjectCachedCodeGeneratorFromComposerJSONDataBase\ComposerPlugin;

/**
 * Defines plugin
 *
 * @package Imponeer\ComposerCustomCommand
 */
class Plugin extends ComposerPlugin
{

	/**
	 * Gets capabilities of object
	 *
	 * @return array
	 */
	public function getCapabilities() {
		return array(
			CommandProvider::class => LocalCommandProvider::class
		);
	}

	/**
	 * Gets dump writer factory class
	 *
	 * @return string
	 */
	protected function getDumpWriterFactoryClass(): string
	{
		return DumpWriterFactory::class;
	}

	/**
	 * Get message when can't create dump writer instance
	 *
	 * @return string
	 */
	protected function getCannotCreateDumpWriterInstanceMessage(): string
	{
		return 'No commands definitions found in your composer.json project definitions';
	}

	/**
	 * Get message when updating cache
	 *
	 * @return string
	 */
	protected function getUpdatingCacheMessage(): string
	{
		return 'Updating commands cache';
	}

	/**
	 * Get message when can't write cache file
	 *
	 * @return string
	 */
	protected function getFailToWriteDumpMessage(): string
	{
		return 'Failed to update commands cache';
	}
}