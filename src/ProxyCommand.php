<?php

namespace Imponeer\ComposerCustomCommands;

use Composer\Command\BaseCommand;
use Imponeer\ComposerCustomCommands\Exceptions\NotASymfonyCommandException;
use Symfony\Component\Console\Command\Command;

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
	 *
	 * @return ProxyCommand
	 */
	public static function create($class)
	{
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