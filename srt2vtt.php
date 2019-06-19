<?php

$source_dir = $dest_dir = '.';
$flags = [];

// If we have arguments, process them
if($argc > 1)
{
	// Check if there are any flags set
	foreach($argv as $k => $arg)
	{
		if($arg[0] == '-')
		{
			unset($argv[$k]);
			$argc--;
			$f = str_split(substr($arg, 1));
			foreach($f as $flag)
				$flags[$flag] = true;
		}		
	}

	// Reset argument keys, after any flags have been removed
	$argv = array_values($argv);

	switch($argc)
	{
		case 2:
			$source_dir = $dest_dir = rtrim($argv[1], DIRECTORY_SEPARATOR);
		break;
		case 3:
			$source_dir = rtrim($argv[1], DIRECTORY_SEPARATOR);
			$dest_dir = rtrim($argv[2], DIRECTORY_SEPARATOR);
		break;
	
	}
}

if( !is_dir($source_dir) || !is_readable($source_dir))
{
	printf('Make sure your source dir (%s) exists and is readable.'.PHP_EOL, $source_dir);
	exit(1);
}

if($source_dir !== $dest_dir && (!is_dir($dest_dir) || !is_writable($dest_dir)) )
{
	printf('Make sure your destination dir (%s) exists and is writable.'.PHP_EOL, $dest_dir);
	exit(1);
}

// Loop over all files in $source_dir
foreach (new DirectoryIterator($source_dir) as $fileInfo) {

	// Check if it's the dot-files or extention other than .srt and move on to next file if so
	if ($fileInfo->isDot() || $fileInfo->getExtension() !== 'srt') 
		continue;

	$target_file = $dest_dir.DIRECTORY_SEPARATOR.$fileInfo->getBasename('.srt').'.vtt';

	// Check if .vtt file already exists and has newer modification time and the -f is not set. If so, move on to next file
	if( ( $file_existed = file_exists( $target_file)) && !isset($flags['f']) && filemtime($target_file) > $fileInfo->getMTime() )
	{
		// printf('%s exists and is newer than .srt file. Continue.'.PHP_EOL, $target_file);
		continue;
	}

	$original = file_get_contents($source_dir.DIRECTORY_SEPARATOR.$fileInfo->getFileName());

	// Add WEBVTT header	
	$vtt = 'WEBVTT'.PHP_EOL.PHP_EOL.$original;
	// Replace microseconds separator: 00,000 -> 00.000
	$vtt = preg_replace('#(\d{2}),(\d{3})#','${1}.${2}',$vtt);
	
	// Write the .vtt file
	file_put_contents($target_file, $vtt);
	
	if( ! $file_existed )
		printf('%s.vtt has been created.'.PHP_EOL, $fileInfo->getBasename('.srt') );
	else
		printf('%s.vtt has been updated.'.PHP_EOL, $fileInfo->getBasename('.srt') );
	
}

exit(0);
