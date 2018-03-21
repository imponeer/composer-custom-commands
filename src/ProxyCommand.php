<?php

namespace Imponeer\ComposerCustomCommands;

use Composer\Command\BaseCommand;
use Composer\Composer;
use Imponeer\ComposerCustomCommands\Exceptions\NotASymfonyCommandException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProxyCommand extends BaseCommand
{

	/**
	 * Linked command
	 *
	 * @var null|Command
	 */
	protected $command = null;

	/**
	 * Creates new instance
	 *
	 * @param string $class Classname to create
	 * @param Composer $composer Composer instance
	 *
	 * @return ProxyCommand
	 */
	public static function create(Composer &$composer, $class)
	{
		if (!class_exists($class)) {
			var_dump($composer->getPackage());
		}
		$command = new $class();
		if (!($command instanceof Command)) {
			throw new NotASymfonyCommandException();
		}
		$instance = new self(
			$command->getName()
		);
		$instance->command = $command;
		$instance->setAliases(
			$command->getAliases()
		);
		$instance->setDescription(
			$command->getDescription()
		);
		$instance->setDefinition(
			$command->getDefinition()
		);
		return $instance;
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
		return $this->command->execute($input, $output);
	}

}