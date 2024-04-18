# Arise by Sentgine

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE.md)
[![Latest Stable Version](https://img.shields.io/packagist/v/sentgine/arise.svg)](https://packagist.org/sentgine/arise)
[![Total Downloads](https://img.shields.io/packagist/dt/sentgine/arise.svg)](https://packagist.org/packages/sentgine/arise)

A simple and lightweight wrapper for creating console commands using PHP. This package is built on top of the Symfony Console component.

## Requirements
- PHP 8.1.17 or higher.

## Installation & Usage

(1) You can install the package via Composer to your existing PHP project by running the following command:

```bash
composer require sentgine/arise:^2.0.0
```

(2) Then, open your composer.json file and make sure to add the "Console\\\Commands\\\\": "console/Commands" to your autoload.

```composer
"autoload": {
    "psr-4": {
        "App\\": "src/",
        "Console\\Commands\\": "console/Commands"
    }
},
```

(3) Run this command to regenerate your autoload files:
```bash
composer dump-autoload
```

(4) In your project's root directory, run the following command:
```bash
php vendor/sentgine/arise/initialize
```
This will create the "arise" file.

(5) Run this command in your terminal and you will see the list of commands:
```bash
php arise
```

(6) Finally, you can start creating a new command by running:
```bash
php arise make:command
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