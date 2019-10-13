<?php

namespace Imponeer\ComposerCustomCommands;

use Imponeer\ProjectCachedCodeGeneratorFromComposerJSONDataBase\DumpWriterInterface;

class DefaultDumpWriter implements DumpWriterInterface
{

	/**
	 * Filename where to write generated container data
	 *
	 * @var string
	 */
	protected $filename;

	/**
	 * Command classes
	 *
	 * @var string[]
	 */
	protected $commands = [];

	/**
	 * Boot scripts
	 *
	 * @var string[]
	 */
	protected $boot = [];

	/**
	 * Constructor
	 *
	 * @param string $filename Filename to write
	 */
	public function __construct(string $filename)
	{
		$this->filename = $filename;
	}

	/**
	 * Write existing service configuration to file
	 *
	 * @return bool
	 */
	public function writeToFile(): bool
	{
		$ret = $this->source . PHP_EOL;
		$ret .= '<?php return ' . var_export(['commands' => $this->commands, 'boot' => $this->boot], true) . ';';

		return (bool)file_put_contents($this->filename, $ret, LOCK_EX);
	}

	/**
	 * Add classes of commands that should be registered
	 *
	 * @param string[] $commands Commands to add
	 */
	public function addCommands(array $commands): void
	{
		$this->commands = array_merge($this->commands, $commands);
	}

	/**
	 * Add bootscript
	 *
	 * @param string $bootScript Bootscript file that should be executed for commands
	 */
	public function addBootScript(string $bootScript): void
	{
		$this->boot[] = $bootScript;
	}
}