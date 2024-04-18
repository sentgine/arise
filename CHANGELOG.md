# Changelog

All notable changes to `Arise` will be documented in this file.

## 1.0.0 - 2024-04-17

### What's Changed
Initial release

## 2.0.0 - 2024-04-19

### What's Changed
1. **Initialize Command**: I've introduced the `vendor/sentgine/arise/initialize` command to streamline the setup process. Now, creating the "arise" file is automated, eliminating the need for manual intervention.

2. **Stubs Directory**: I've added the `src/Stubs` directory for stub files. These files serve as templates for generating code. You don't need to worry about this since this will only be used by the **arise** library.

3. **Default MakeCommand**: Included the default `make:command` to streamline command creation. With this command, you can quickly generate new commands with minimal effort.