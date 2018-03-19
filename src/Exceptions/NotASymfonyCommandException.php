<?php

namespace Imponeer\ComposerCustomCommands\Exceptions;

/**
 * Not a Symfony console command exception
 */
class NotASymfonyCommandException extends \Exception
{

	/**
	 * Error message for such exception
	 *
	 * @var string
	 */
	protected $message = 'Not a Symfony Console command';

}