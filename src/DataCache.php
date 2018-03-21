<?php

namespace Imponeer\ComposerCustomCommands;

use ReflectionClass;

/**
 * Caches commands information
 *
 * @package Imponeer\ComposerCustomCommands
 */
final class DataCache {

	/**
	 * Cache file
	 *
	 * @var string
	 */
	private $cache_file;

	/**
	 * DataCache constructor.
	 */
	public function __construct() {
		$this->cache_file = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'commands.php';
	}

	/**
	 * Gets instance of data cache
	 *
	 * @return DataCache
	 */
	public static function getInstance() {
		return new self();
	}

	/**
	 * Writes cache
	 *
	 * @param array $classes Classes list
	 */
	public function write(array $classes) {
		require_once dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'autoload.php';

		$includes = empty($classes)?array():$this->getReflectionClassesFromStrings($classes);

		ob_start();
		require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'commands.tpl.php';
		$output = ob_get_contents();
		ob_end_clean();

		file_put_contents($this->cache_file, $output, LOCK_EX);
	}

	/**
	 * Gets reflection classes list from strings
	 *
	 * @param array $classes
	 *
	 * @return array
	 */
	private function getReflectionClassesFromStrings(array $classes) {
		$all_reflection_classes = [];
		foreach ($classes as $class) {
			foreach ($this->getFilesForClasses(new ReflectionClass($class)) as $name => $reflection_class) {
				$all_reflection_classes[$name] = $reflection_class;
			}
		}
		return $all_reflection_classes;
	}

	/**
	 * Gets parent classes and interfaces
	 *
	 * @param ReflectionClass $class
	 */
	private function getFilesForClasses(ReflectionClass $class) {
		$ret = [];
		foreach ($class->getInterfaces() as $interface) {
			foreach ($this->getFilesForClasses($interface) as $class2 => $file) {
				$ret[$class2] = $file;
			}
			$ret[$interface->getName()] = $interface->getFileName();
		}
		foreach ($class->getTraits() as $another_class) {
			$ret[$another_class->getName()] = $another_class->getFileName();
		}
		$parent = $class->getParentClass();
		if ($parent) {
			foreach ($this->getFilesForClasses($parent) as $class2 => $file) {
				$ret[$class2] = $file;
			}
			$ret[$parent->getName()] = $parent->getFileName();
		}
		$ret[$class->getName()] = $class->getFileName();

		return $ret;
	}

	/**
	 * Read commands data from cache
	 *
	 * @return ProxyCommand[]
	 */
	public function read()
	{
		return file_exists($this->cache_file)?include($this->cache_file):array();
	}

}