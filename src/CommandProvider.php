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
		return array_map(
			static function ($class) {
				return new ProxyCommand($class);
			},
			array_filter('class_exists', $commands)
		);
	}
}