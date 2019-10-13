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
	 * Generated source
	 *
	 * @var string
	 */
	protected $source;

	/**
	 * Command classes
	 *
	 * @var string[]
	 */
	protected $commands = [];

	/**
	 * Constructor
	 *
	 * @param string $filename Filename to write
	 */
	public function __construct(string $filename)
	{
		$this->filename = $filename;
		$this->source = sprintf(
			'<?php%1$suse Imponeer\\ComposerCustomCommands\\ProxyCommand;%1$s%1$srequire_once(dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . "autoload.php");%1$s',
			PHP_EOL
		);
	}

	/**
	 * Write existing service configuration to file
	 *
	 * @return bool
	 */
	public function writeToFile(): bool
	{
		$ret = $this->source . PHP_EOL;
		$ret .= '$commands = array_filter([' . PHP_EOL;
		foreach ($this->commands as $command) {
			$ret .= str_repeat(' ', 4) . 'class_exists("' . $command . '") ? ' . ' new ProxyCommand(' . $command . '::class) : null,' . PHP_EOL;
		}
		$ret .= ']);' . PHP_EOL;

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
		$this->source .= sprintf(
			'try {%2$s    file_exists(%1$s) && include_once(%1$s);%2$s} catch (\\Exception $ex) {%2$s}%2$s',
			json_encode($bootScript),
			PHP_EOL
		);
	}
}