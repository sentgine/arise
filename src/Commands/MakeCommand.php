<?php

namespace Sentgine\Arise\Commands;

use Sentgine\Arise\Command;
use Sentgine\File\Filesystem;
use Sentgine\Helper\Word;

/**
 * Class MakeCommand
 *
 * Represents a command for creating new commands.
 */
class MakeCommand extends Command
{
    protected string $signature = 'make:command'; // The signature of the command
    protected string $description = 'Creates a new command'; // The description of the command

    /**
     * Configures the command.
     */
    protected function configure(): void
    {
        parent::configure();

        // Define options for the command
        $this->option('name', 'The name of the command', '', true);
        $this->option('class', 'The class file name of the command', '', true);
    }

    /**
     * Handles the execution of the command.
     *
     * @return int The exit code
     */
    protected function handle(): int
    {
        // Get options from command line or prompt user if not provided
        do {
            $name = $this->getOption('name');
            $class = $this->getOption('class');

            if (empty($name)) {
                $name = $this->question('Enter the name of the command', $name);
            }

            if (empty($class)) {
                $class = $this->question('Enter the name of the class file', $class);
            }

            $name = Word::of($name)->toLower();
            $class = Word::of($class)->pascalCase();
        } while (empty($name) && empty($class));

        $this->writeLine('');
        $this->printSection([
            "Creating a new command name: {$name} ",
            "With a class name of: {$class} ",
        ]);

        // Initialize the filesystem
        $filesystem = new Filesystem();

        // Create the Commands directory if it doesn't exist
        $consolePath = getcwd() . "/console";
        $filesystem->createDirectory($consolePath);
        $filesystem->createDirectory($consolePath . "/Commands");

        // Read the stub content
        $content = $filesystem->setSourceFile(dirname(__DIR__) . "/Stubs/Command.stub")->read();

        // Set the destination file and create the new command file
        $filesystem->setDestinationFile($consolePath . "/Commands/{$class}.php");
        $filesystem->create($content);

        // Replace placeholders in the content with actual values
        $filesystem->replaceContent([
            'class_name' => $class,
            'command_name' => $name,
        ]);

        return true;
    }
}
