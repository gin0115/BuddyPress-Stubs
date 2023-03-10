<?php

// Get the version from the command line.
$version = $argv[1] ?? null;

// If version is not defined, get the latest from WP Plugin API.
if ( ! $version ) {
	print 'No version defined, getting latest from WP Plugin API...' . PHP_EOL;
	$version = json_decode( file_get_contents( 'https://api.wordpress.org/plugins/info/1.0/buddypress.json' ) )->version;
}

// If version is still not defined, die.
if ( ! $version ) {
	die( 'No version defined.' );
}

print 'Using version: ' . $version . PHP_EOL;

// Download the zip file and unpack in source
$zip_file = __DIR__ . '/source/buddypress-' . $version . '.zip';

if ( ! file_exists( $zip_file ) ) {
	print 'Downloading zip file...' . PHP_EOL;
	file_put_contents( $zip_file, file_get_contents( 'https://downloads.wordpress.org/plugin/buddypress.' . $version . '.zip' ) );
}

// If the zip file doesnt exist, die.
if ( ! file_exists( $zip_file ) ) {
	die( 'Zip file not found after download.' );
}

// Unpack the zip file.
$zip = new \ZipArchive();
if ( $zip->open( $zip_file ) === true ) {
	print 'Unpacking zip file...' . PHP_EOL;
	$zip->extractTo( __DIR__ . '/source/buddypress' );
	$zip->close();
}


// You'll need the Composer Autoloader.
require 'vendor/autoload.php';

$stub_name = __DIR__ . '/buddypress-stubs.php';

// You may alias the classnames for convenience.
use StubsGenerator\{StubsGenerator, Finder};

// First, instantiate a `StubsGenerator\StubsGenerator`.
$generator = new StubsGenerator( StubsGenerator::ALL );

// Then, create a `StubsGenerator\Finder` which contains
// the set of files you wish to generate stubs for.
$finder = Finder::create()
	->in( __DIR__ . '/source/buddypress' )
	->exclude( 'cli' );

// Now you may use the `StubsGenerator::generate()` method,
// which will return a `StubsGenerator\Result` instance.
$result = $generator->generate( $finder );

// You can use the `Result` instance to pretty-print the stubs.
$stub = $result->prettyPrint();

// If we have content, clear the exsting stub and write the new one.
if ( ! $stub ) {
	throw new Exception( 'No stubs generated.' );
}

// Functions to remove.
$remove = array(
	'is_site_admin',
);

// Remove functions.
foreach ( $remove as $function ) {
	$find    = 'function ' . $function . '(';
	$replace = sprintf( 'function IGNORE_%s_%s(', $function, md5( time() ) );
	$stub    = str_replace( $find, $replace, $stub );
}


// Write stub to file.

// Create if it doesnt exist, clear if it does.
if ( file_exists( $stub_name ) ) {
	unlink( $stub_name );
}

touch( $stub_name );

// Remove <?php from the start of the stub.
$stub = str_replace( '<?php', '', $stub );

print 'Writing stubs to file...' . PHP_EOL;

// Add credits.
$credits = <<<CREDITS
<?php

/**
 * This file is generated by the BuddyPress Stubs Generator.
 *
 * @version {$version}
 * @link https://github.com/gin0115/BuddyPress-Stubs
 */

CREDITS;


file_put_contents( $stub_name, $credits . $stub );

print 'Done!' . PHP_EOL;
