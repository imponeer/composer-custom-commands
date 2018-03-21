<?php

namespace Imponeer\ComposerCustomCommands;

use ReflectionClass;

/**
 * Caches commands information
 *
 * @package Imponeer\ComposerCustomCommands
 */
final class DataCache
{

	/**
	 * Cache path
	 *
	 * @var string
	 */
	private $path;

	/**
	 * DataCache constructor.
	 */
	public function __construct()
	{
		$this->path = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'commands.php';
	}

	/**
	 * Gets instance of data cache
	 *
	 * @return DataCache
	 */
	public static function getInstance()
	{
		return new self();
	}

	/**
	 * Writes cache
	 *
	 * @param array $classes Classes list
	 */
	public function write(array $classes)
	{
		require_once dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'autoload.php';

		$includes = array();
		$instances = array();
		foreach ($classes as $class) {
			$reflector = new ReflectionClass($class);
			$includes[] = 'include_once ' . var_export($reflector->getFileName(), true) . ';';
			$instances[] = 'ProxyCommand::create(new ' . $class . '())';
		}
		$output = '<' . '?php' . PHP_EOL;
		$output .= 'use Imponeer\\ComposerCustomCommands\\ProxyCommand;' . PHP_EOL;
		$output .= implode(PHP_EOL, $includes) . PHP_EOL;
		$output .= 'return array(' . PHP_EOL;
		$output .= "\t" . implode(',' . PHP_EOL . "\t", $instances) . PHP_EOL;
		$output .= ');';

		file_put_contents($this->path, $output, LOCK_EX);
	}

	/**
	 * Read commands data from cache
	 *
	 * @return array|mixed
	 */
	public function read()
	{
		if (!file_exists($this->path)) {
			return array();
		}
		return include($this->path);
	}

}