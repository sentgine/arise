<?php

namespace Sentgine\Arise;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Output\NullOutput;

/**
 * Class Command
 *
 * Base class for the Arise console commands.
 */
abstract class Command extends SymfonyCommand
{
    protected string $signature;
    protected string $description;
    protected InputInterface $input;
    protected OutputInterface $output;

    /**
     * Configures the current command.
     */
    protected function configure(): void
    {
        $this
            ->setName($this->signature)
            ->setDescription($this->description);
    }

    /**
     * Executes the current command.
     *
     * @param InputInterface $input  The input interface
     * @param OutputInterface $output  The output interface
     *
     * @return int  The exit code
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->input = $input;
        $this->output = $output;

        return $this->handle();
    }

    /**
     * Handles the command logic.
     *
     * @return int  The exit code
     */
    abstract protected function handle(): int;

    /**
     * Writes a message with specified color to the output.
     *
     * @param string $message  The message to write
     * @param string $color  The color of the message
     */
    protected function writeWithColor(string $message, string $color): void
    {
        $style = new OutputFormatterStyle($color);
        $this->output->getFormatter()->setStyle($color, $style);
        $this->output->writeln("<$color>$message</$color>");
    }

    /**
     * Writes an information message to the output.
     *
     * @param string $message  The message to write
     */
    protected function info(string $message): void
    {
        $this->output->writeln("<info>$message</info>");
    }

    /**
     * Writes a comment message to the output.
     *
     * @param string $message  The message to write
     */
    protected function comment(string $message): void
    {
        $this->output->writeln("<comment>$message</comment>");
    }

    /**
     * Writes an error message to the output.
     *
     * @param string $message  The message to write
     */
    protected function error(string $message): void
    {
        $this->output->writeln("<error>$message</error>");
    }

    /**
     * Writes a line(s) to the output with specified color(s).
     *
     * @param string|array $lines  The line(s) to write. Can be a string or an array of [text, color] pairs.
     */
    protected function writeLine($lines): void
    {
        foreach ((array)$lines as $line) {
            // If it's an array with text and color specified
            if (is_array($line) && count($line) === 2) {
                $text = $line[0];
                $color = $line[1];
                $this->writeWithColor($text, $color);
            } else { // If it's a plain string
                $this->output->writeln($line);
            }
        }
    }

    /**
     * Writes a titled section with specified content and border color.
     *
     * @param string|array $content The content of the title, either a string or an array of lines
     * @param string $borderColor The color of the border
     * @param string $contentColor The color of the content text
     */
    protected function printSection($content, string $borderColor = 'cyan', string $contentColor = 'white', string $sideBorder = "|"): void
    {
        $borderStyle = new OutputFormatterStyle($borderColor);
        $contentStyle = new OutputFormatterStyle($contentColor);

        $this->output->getFormatter()->setStyle($borderColor, $borderStyle);
        $this->output->getFormatter()->setStyle($contentColor, $contentStyle);

        // If content is not an array, convert it to an array with a single element
        $lines = is_array($content) ? $content : [$content];

        // Calculate the length of the longest line
        $maxLineLength = max(array_map('strlen', $lines));

        // Calculate the length of the border line
        $borderLength = $maxLineLength + 4;

        // Construct the border line
        $borderLine = str_repeat('=', $borderLength);

        // Output the top border line
        $this->output->writeln("<$borderColor>$borderLine</$borderColor>");

        // Process each line individually
        foreach ($lines as $line) {
            // Pad each line with spaces on the right side to ensure alignment with the right border
            if (!empty($sideBorder)) {
                $formattedContentLine = "<$borderColor>{$sideBorder} <{$contentColor}>$line</{$contentColor}>" . str_repeat(' ', max(0, $maxLineLength - strlen($line))) . " {$sideBorder}</$borderColor>";
            } else {
                $formattedContentLine = "<$borderColor><{$contentColor}>$line</{$contentColor}></$borderColor>";
            }
            // Output the content line
            $this->output->writeln($formattedContentLine);
        }

        // Output the bottom border line
        $this->output->writeln("<$borderColor>$borderLine</$borderColor>");
    }

    /**
     * Asks a question and returns the user's input.
     *
     * @param string $questionText  The text of the question
     * @param string $defaultAnswer  The default answer
     *
     * @return string  The user's input
     */
    protected function question(string $questionText, string $defaultAnswer = ''): string
    {
        $questionText = "<info>$questionText: </info>";
        $helper = $this->getHelper('question');
        $question = new Question($questionText, $defaultAnswer);
        return $helper->ask($this->input, $this->output, $question);
    }

    /**
     * Asks a choice question and returns the user's choice.
     *
     * @param string $questionText  The text of the question
     * @param array $choices  The available choices
     * @param string $defaultAnswer  The default answer
     *
     * @return string  The user's choice
     */
    protected function choice(string $questionText, array $choices, string $defaultAnswer = ''): string
    {
        $questionText = "<info>$questionText: </info>";
        $helper = $this->getHelper('question');
        $question = new ChoiceQuestion($questionText, $choices, $defaultAnswer);
        return $helper->ask($this->input, $this->output, $question);
    }

    /**
     * Adds an argument to the command.
     *
     * @param string $name  The name of the argument
     * @param string $description  The description of the argument
     * @param string $default  The default value of the argument
     */
    protected function argument(string $name, string $description, $default = ""): void
    {
        $this->addArgument($name, InputArgument::OPTIONAL, $description, $default);
    }

    /**
     * Adds an option to the command.
     *
     * @param string $name  The name of the option
     * @param string $description  The description of the option
     * @param string $default  The default value of the option
     */
    protected function option(string $name, string $description, $default = ""): void
    {
        $this->addOption($name, null, InputOption::VALUE_OPTIONAL, $description, $default);
    }

    /**
     * Retrieves the value of the specified argument.
     *
     * @param string $name The name of the argument
     *
     * @return string|int|null The value of the argument, or null if the argument is not set
     */
    protected function getArgument(string $name): mixed
    {
        return $this->input->getArgument($name);
    }

    /**
     * Retrieves the value of the specified option.
     *
     * @param string $name The name of the option
     *
     * @return string|array|null The value of the option, or null if the option is not set
     */
    protected function getOption(string $name): mixed
    {
        return $this->input->getOption($name);
    }

    /**
     * Calls a console command with provided arguments and options.
     *
     * @param string $commandName The name of the command to call
     * @param array $arguments The arguments for the command
     * @param array $options The options for the command
     * @param OutputInterface|null $output The output interface
     *
     * @return int The exit code
     */
    protected function call(string $commandName, array $arguments = [], array $options = [], ?OutputInterface $output = null): int
    {
        $command = $this->getApplication()->find($commandName);

        // Prepare command input
        $inputArguments = array_merge(['command' => $commandName], $arguments, $options); // Merge options into the input
        $input = new ArrayInput($inputArguments);
        $input->setInteractive(false); // Ensure non-interactive mode

        // Execute command
        return $command->run($input, $output ?? $this->output);
    }
    /**
     * Calls a console command with provided arguments and options, suppressing output.
     *
     * @param string $commandName The name of the command to call
     * @param array $arguments The arguments for the command
     * @param array $options The options for the command
     * @param OutputInterface|null $output The output interface
     *
     * @return int The exit code
     */
    protected function callSilent(string $commandName, array $arguments = [], array $options = [], ?OutputInterface $output = null): int
    {
        // If output is not provided, use null to suppress output
        $output = $output ?? new NullOutput();

        return $this->call($commandName, $arguments, $options, $output);
    }
}
