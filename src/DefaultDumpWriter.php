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
		require_once(dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . "autoload.php");

		$commands_str = '';
		foreach ($this->commands as $command) {
			if (!class_exists($command)) {
				continue;
			}
			$realCommand = new $command();
			$instance = (
			new ProxyCommand(
				$realCommand->getName()
			)
			)
				->setAliases(
					$realCommand->getAliases()
				)
				->setDescription(
					$realCommand->getDescription()
				)
				->setDefinition(
					$realCommand->getDefinition()
				)
				->setRealCommandClass(
					$command
				);
			$commands_str .= '		unserialize(' . var_export(serialize($instance), true) . '),' . PHP_EOL;
		}

		$boot = var_export($this->boot, true);

		$ret = <<<EOF
<?php
return [
	'boot' => $boot,
	'commands' => [
$commands_str
	]
];
EOF;

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