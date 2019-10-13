<?php

namespace Imponeer\ComposerCustomCommands;

use Composer\Plugin\Capability\CommandProvider as CommandProviderCapability;

/**
 * Defines all commands
 *
 * @package Imponeer\ComposerCustomCommand
 */
class CommandProvider implements CommandProviderCapability {
	/**
	 * Gets registered commands
	 *
	 * @return array
	 */
	public function getCommands() {
		$file = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'generated' . DIRECTORY_SEPARATOR . 'data.php';
		$commands = [];
		if (file_exists($file)) {
			$commands = include($file);
		}
		return $commands;
	}
}