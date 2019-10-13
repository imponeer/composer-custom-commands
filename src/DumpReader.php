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
	 * Scripts to include before commands execution
	 *
	 * @var string[]
	 */
	protected $boot = [];

	/**
	 * Commands classes
	 *
	 * @var string[]
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
	static public function create(): DumpReader
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
	 * @return \string[]
	 */
	public function getCommands(): array
	{
		return array_filter($this->commands, 'class_exists');
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