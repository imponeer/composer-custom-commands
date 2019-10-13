<?php

namespace Imponeer\ComposerCustomCommands;

use Imponeer\ProjectCachedCodeGeneratorFromComposerJSONDataBase\DumpWriterFactoryInterface;
use Imponeer\ProjectCachedCodeGeneratorFromComposerJSONDataBase\DumpWriterInterface;

class DumpWriterFactory implements DumpWriterFactoryInterface
{
	/**
	 * Place where in extras all config variables are stored
	 */
	const CONFIG_NAMESPACE = 'custom-commands';

	/**
	 * DumpWriter instance
	 *
	 * @var DefaultDumpWriter
	 */
	protected $instance;

	/**
	 * DumpWriterFactory constructor.
	 */
	public function __construct()
	{
		$this->instance = new DefaultDumpWriter(
			dirname(__DIR__) . DIRECTORY_SEPARATOR . 'generated' . DIRECTORY_SEPARATOR . 'data.php'
		);
	}

	/**
	 * Add config
	 *
	 * @param array[] $extra Extra part of config
	 */
	public function addConfig(array $extra): void
	{
		if (!isset($extra[self::CONFIG_NAMESPACE])) {
			return;
		}

		$data = $extra[self::CONFIG_NAMESPACE];
		if (isset($data['boot'])) {
			$this->instance->addBootScript((string)$data['boot']);
		}
		if (isset($data['commands'])) {
			$this->instance->addCommands((array)$data['commands']);
		}
	}

	/**
	 * Create dump writer instance
	 *
	 * @return null|DumpWriterInterface
	 */
	public function create(): ?DumpWriterInterface
	{
		return $this->instance;
	}
}