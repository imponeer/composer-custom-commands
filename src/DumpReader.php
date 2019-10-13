<?php

namespace Imponeer\ComposerCustomCommands;

/**
 * Class that reads generated dump
 *
 * @package Imponeer\ComposerCustomCommands
 */
class DumpReader
{

	/**
	 * Prevents autoload.php from automatic inclusion
	 *
	 * @var bool
	 */
	public $preventAutoloadFromInclusion = false;
	/**
	 * Scripts to include before commands execution
	 *
	 * @var string[]
	 */
	protected $boot = [];
	/**
	 * Commands classes
	 *
	 * @var ProxyCommand[]
	 */
	protected $commands = [];

	/**
	 * DumpReader constructor.
	 *
	 * @param string $filename File to read
	 */
	public function __construct(string $filename)
	{
		if (file_exists($filename)) {
			$data = include($filename);
			$this->boot = $data['boot'];
			$this->commands = $data['commands'];
		}
	}

	/**
	 * Create instance of dump reader
	 *
	 * @return DumpReader
	 */
	static public function getInstance(): DumpReader
	{
		static $instance = null;
		if ($instance === null) {
			$instance = new DumpReader(
				dirname(__DIR__) . DIRECTORY_SEPARATOR . 'generated' . DIRECTORY_SEPARATOR . 'data.php'
			);
		}
		return $instance;
	}

	/**
	 * Get command classes list
	 *
	 * @return ProxyCommand[]
	 */
	public function getCommands(): array
	{
		return $this->commands;
	}

	/**
	 * Get boot scripts
	 *
	 * @return string[]
	 */
	public function getBootScripts(): array
	{
		return $this->boot;
	}

}