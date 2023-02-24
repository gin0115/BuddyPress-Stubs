# BuddyPress Stubs Generator

This a crude script to generate stubs for BuddyPress functions and classes. Based on https://github.com/php-stubs/generator

## To add to your project.

If you would like access to the stubs in your project, you can add this package as a dev dependency.

`$ composer require --dev gin0115/buddypress-stubs`

Full list of available versions can be found on Packagist: https://packagist.org/packages/gin0115/buddypress-stubs

## Usage

To run the generator you will need to have PHP 7.4 or higher installed, with the ZIP extension enabled.

1. Clone this repository
2. Run `$ composer install`
3. Then run `$ php generate.php xx.xx.x` (or whatever version you want to generate $ php generate.php 11.1.0`)
4. This will then generate the stub file called `buddypress-stubs.php` in the root of the project.
5. Commit the changes in a branch called `vxx.xx.x` (based on the version number you used in step 3)
6. If approved, will be released as a new version on Packagist.
