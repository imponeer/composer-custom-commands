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
		$commands = file_exists($file) ? include($file) : [];
		if (is_array($commands) === false) {
			$commands = [];
		}
		return array_filter((array)$commands);
	}
}