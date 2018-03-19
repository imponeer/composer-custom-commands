<?php

namespace Imponeer\ComposerCustomCommands;

use Composer\Composer;
use Composer\IO\IOInterface;
use Imponeer\ComposerCustomCommands\Exceptions\CommandsConfigIsNotArrayException;

/**
 * Defines plugin
 *
 * @package Imponeer\ComposerCustomCommand
 */
class Plugin
{
    /**
     * Array with all commands classes that should be registered
     *
     * @var array
     */
    private static $commands_classes = array();

    /**
     * Gets commands classes for reading outside class
     *
     * @return array
     */
    public static function getCommandsClasses() {
        return self::$commands_classes;
    }

    /**
     * Method executed when activating plugin
     *
     * @param Composer $composer    Composer instance
     * @param IOInterface $io       IO interface
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        if ($composer->getConfig()->has('commands')) {
            self::$commands_classes = $composer->getConfig()->get('commands');
            if (!is_array(self::$commands_classes)) {
                throw new CommandsConfigIsNotArrayException();
            }
        }
    }

    /**
     * Gets capabilities of object
     *
     * @return array
     */
    public function getCapabilities()
    {
        return array(
            'Composer\Plugin\Capability\CommandProvider' => 'Imponeer\ComposerCustomCommand\CommandProvider',
        );
    }
}