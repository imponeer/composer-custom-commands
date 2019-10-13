<?php

namespace Imponeer\ComposerCustomCommands;

use Composer\Command\BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * ProxyCommand is used because ComposerCommands needs to define Commands from BaseCommand
 * but all SymfonyCommands doesn't have such functionality so we use proxy class
 *
 * @package Imponeer\ComposerCustomCommands
 */
class ProxyCommand extends BaseCommand
{

	/**
	 * Linked command
	 *
	 * @var string
	 */
	protected $realCommandClass;

	/**
	 * Set real command class
	 *
	 * @param string $command Command to set
	 *
	 * @return $this
	 */
	public function setRealCommandClass(string $command)
	{
		$this->realCommandClass = $command;

		return $this;
	}

	/**
	 * Execute command
	 *
	 * @param InputInterface $input Input
	 * @param OutputInterface $output Output
	 *
	 * @return int|null
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		require_once(dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . "autoload.php");

		foreach (DumpReader::getInstance()->getBootScripts() as $something) {
			require_once $something;
		}

		$_SERVER['HTTP_HOST'] = null;

		$class = $this->realCommandClass;
		$instance = new $class();

		return $instance->execute($input, $output);
	}

}