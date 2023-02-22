# BuddyPress Stubs Generator

This a crude script to generate stubs for BuddyPress functions and classes. Based on https://github.com/php-stubs/generator

## Usage

To run the generator you will need to have PHP 7.4 or higher installed, with the ZIP extension enabled.

1. Clone this repository
2. Run `$ composer install`
3. Then run `$ php generate.php 11.1.0` (or whatever version you want to generate)
4. This will then generate the stub file called `buddypress-stubs.php` in the root of the project.

A PR can then submitted here, to be included in the next release.