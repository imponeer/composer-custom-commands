<?php

namespace Imponeer\ComposerCustomCommands;

use Composer\Command\BaseCommand;
use Symfony\Component\Console\Command\Command;
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
	 * @var null|Command
	 */
	protected $realCommand = null;

	/**
	 * ProxyCommand constructor.
	 *
	 * @param string $composerCommandClass Composer command class
	 */
	public function __construct($composerCommandClass)
	{
		$this->realCommand = new $composerCommandClass();

		$this
			->setAliases(
				$this->realCommand->getAliases()
			)
			->setDescription(
				$this->realCommand->getDescription()
			)
			->setDefinition(
				$this->realCommand->getDefinition()
			);

		parent::__construct(
			$this->realCommand->getName()
		);
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

		$_SERVER['HTTP_HOST'] = null;

		return $this->realCommand->execute($input, $output);
	}

}