<?php

namespace Imponeer\ComposerCustomCommands;

use Composer\Command\BaseCommand;
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
	 * @param Command $command Command instance
	 *
	 * @return ProxyCommand
	 */
	public static function create(Command $command)
	{
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