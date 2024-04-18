# Arise by Sentgine

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE.md)
[![Latest Stable Version](https://img.shields.io/packagist/v/sentgine/arise.svg)](https://packagist.org/sentgine/arise)
[![Total Downloads](https://img.shields.io/packagist/dt/sentgine/arise.svg)](https://packagist.org/packages/sentgine/arise)

A simple and lightweight wrapper for creating console commands using PHP. This package is built on top of the Symfony Console component.

## Requirements
- PHP 8.1.17 or higher.

## Installation

You can install the package via Composer by running the following command:

```bash
composer require sentgine/arise:^1.1.0
```

## Sample Usage of Arise

### Creating the arise command

(1) In your project's root directory, at the same level as your **src/** folder, create a **console/Commands** directory. Note that the console/Commands directory structure is just an example. You can create your own folder however you want. Put your commands there. You can start by copy and pasting this simple command below to your **console/Commands** directory:

```php
<?php

namespace Console\Commands;

use Sentgine\Arise\Command;

class SampleCommand extends Command
{
    protected string $signature = 'sample:command';
    protected string $description = 'A sample command';

    /**
     * Configures the command.
     */
    protected function configure(): void
    {
        parent::configure();
        $this->option('option_name', 'The option', 'default_value');
        $this->argument('argument_name', 'The argument', 'default_value');
    }

    /**
     * Handles the execution of the command.
     *
     * @return int The exit code
     */
    protected function handle(): int
    {
        // Your command logic goes here
        $this->info('This is a sample command.');
        $this->writeLine(['This is a line with color', 'green']);
        $this->printSection('Sample Section', 'cyan', 'white');

        return Command::SUCCESS;
    }
}
```

(2) Create a file either with or without an extension. In our case, just create a file named "arise" and make sure to place it into the root of your project directory.

(3) Open your terminal and make that file executable by running the following command:

```bash
chmod +x filename
```

Replace the filename with "arise" since this is the name of the executable file in our example. For example:

```bash
chmod +x arise
```

(4) After that, add this code to the executable file:
```php
require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Console\Commands\SampleCommand;

$application = new Application();
$application->setName('Name of your application');
$application->setVersion('v1.0.0');

// Register commands one by one
$application->add(new SampleCommand());

// Or you can register all commands from a directory
Command::register(
    appInstance: $application,
    directory: __DIR__ . '/console/Commands', // This expects you to be in the same directory as the executable file
    namespace: 'Console\\Commands\\' // This is the namespace of the commands
);

$application->run();
```

(4) Run this command in our terminal:
```bash
php arise sample:command
```

(4) To get the list of commands, just simply run:
```bash
php arise
```

## Changelog
Please see the [CHANGELOG](https://github.com/sentgine/arise/blob/main/CHANGELOG.md) file for details on what has changed.

## Security
If you discover any security-related issues, please email sentgine@gmail.com instead of using the issue tracker.

## Credits
**Arise** is built and maintained by Adrian Navaja.
- Check out some cool tutorials and stuff on [YouTube](https://www.youtube.com/@sentgine)!
- Catch my latest tweets and updates on [Twitter](https://twitter.com/sentgine) (formerly X)!
- Let's connect on a more professional note over on [LinkedIn](https://www.linkedin.com/in/adrian-navaja/)!
- For more information about me and my work, visit my website: [sentgine.com](https://www.sentgine.com/).

## License
The MIT License (MIT). Please see the [LICENSE](https://github.com/sentgine/arise/blob/main/LICENSE) file for more information.