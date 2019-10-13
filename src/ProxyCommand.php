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
	protected $realCommand = null;

	/**
	 * ProxyCommand constructor.
	 *
	 * @param string $composerCommandClass Composer command class
	 */
	public function __construct($composerCommandClass)
	{
		parent::__construct(null);

		$this->realCommand = new $composerCommandClass();

		$this->setAliases(
			$this->realCommand->getAliases()
		);
		$this->setDescription(
			$this->realCommand->getDescription()
		);
		$this->setDefinition(
			$this->realCommand->getDefinition()
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