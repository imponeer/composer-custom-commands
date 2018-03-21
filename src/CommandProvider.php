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
		return ProxyCommand::produce(
			DataCache::getInstance()->read()
		);
	}
}