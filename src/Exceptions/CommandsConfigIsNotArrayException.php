<?php

namespace Imponeer\ComposerCustomCommands\Exceptions;

/**
 * Exception trown when 'commands' is not an array in composer.json
 *
 * @package Imponeer\ComposerCustomCommand
 */
class CommandsConfigIsNotArrayException extends \Exception {

    /**
     * Error message for such exception
     *
     * @var string
     */
    protected $message = 'Commands section in composer.json is not an array';

}