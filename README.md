# Batch srt to vtt converter

A PHP **command line** script that batch converts all SubRip (.srt) files to WebVTT (.vtt) files in a directory. Source and destination directories can be specified.

## Description

There are many versions and code flavors available that more or less do the same. They just didn't do the trick for me.

I needed a script that could batch convert all our .srt files, and one that I can rerun when we update/add subtitles.

This script takes all .srt files in the current (or a specified source) directory and converts them into new .vtt files in the current (or a specified destination) directory.

It only creates a .vtt file if it does not exist or if the .srt source file has been modified after a .vtt had been created.

## Getting Started

### Installing

Simply clone this repo or save the srt2vtt.php file on your machine.

It can go in the directory containing the .srt files, or in any other directory.

## Usage

Just run the following command in your terminal

```
php srt2vtt.php
```
Rerun the command to update any recently changed .srt files.

### Options

Optionally you can specify a source directory, and a destination directory. Omit the last one if source and destination are the same directory.

Use the -f flag to process ALL .srt files, and not only the ones that are newer than the existing .vtt file.

```
php srt2vtt.php [-f] [source-dir [destination-dir]]
```

### Examples

Convert all .srt files to .vtt files in current directory.

```
php srt2vtt.php
```

Convert all .srt files to .vtt files in a different directory.

```
php srt2vtt.php subs
```

Convert all .srt files to .vtt files in a different directory and put generated file in other directory.

```
php srt2vtt.php subs/srt subs/vtt
```

Convert all .srt files to .vtt files in the current directory and put generated file in other directory.

```
php srt2vtt.php . vtt
```

Process ALL .srt files, and not only the ones that are newer than the existing .vtt file. Also specifying a different source and target directory.
```
php srt2vtt.php -f subs/srt subs/vtt
```

## Contributing

Feel free to Fork, update, make pull requests, if you have any suggestions, improvements, etc.
