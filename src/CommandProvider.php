<?php

namespace Imponeer\ComposerCustomCommands;

use Composer\Autoload\ClassLoader;
use Composer\Plugin\Capability\CommandProvider as CommandProviderCapability;

/**
 * Defines all commands
 *
 * @package Imponeer\ComposerCustomCommand
 */
class CommandProvider implements CommandProviderCapability
{
    /**
     * Gets registered commands
     *
     * @return array
     */
	public function getCommands()
	{
		if ($this->getLoader() === null) {
			return array();
		}

		return $this->getCommandsFromComposer();
    }

	/**
	 * Gets class loader
	 *
	 * @return ClassLoader|null
	 */
	protected function getLoader()
	{
		$loader_file = $this->getComposer()->get('vendor-dir') . DIRECTORY_SEPARATOR . 'autoload.php';
		if (file_exists($loader_file)) {
			return require_once($loader_file);
		}
		return null;
	}

	/**
	 * Gets composer instance
	 *
	 * @return \Composer\Composer
	 */
	protected function getComposer()
	{
		return Plugin::getComposer();
	}

	/**
	 * Gets commands from composer
	 *
	 * @return ProxyCommand[]
	 */
	protected function getCommandsFromComposer()
	{
		$extra = $this->getComposer()->getPackage()->getExtra();

		if (!isset($extra['commands'])) {
			return array();
		}

		$ret = [];
		foreach ((array)$extra['commands'] as $class) {
			$ret[] = new ProxyCommand(
				new $class()
			);
		}
		return $ret;
	}
}