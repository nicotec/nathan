#!/usr/bin/php
<?php
/*
Plugin Name: Backup-Manager Email
Plugin URI: https://www.skyminds.net/?p=5315
Description: Sends a recap email to sysadmin after Backup-Manager has backed up the files.
Version: 2.0
Author: Matt Biscay
Author URI: https://www.skyminds.net/
*/
/* --- Changelog ---
v2.0 :
- PHP 7.x compatible
- switch from single recipient to recipient array
- better dir recursion
- fixed undefined variables
- new function to format file sizes
v1.0 : initial release
*/
$dest = array('ADMIN@EXAMPLE.COM');
$archives = '/var/archives';
$host = trim(file_get_contents('/etc/hostname'));
clearstatcache();
$pagetext = '';
$totalsize = 0;
// Function: Format Bytes Into TiB/GiB/MiB/KiB/Bytes
function format_filesize($rawSize)
{
    if ($rawSize / 1099511627776 > 1) {
        return number_format($rawSize / 1099511627776, 1) . ' TiB';
    } elseif ($rawSize / 1073741824 > 1) {
        return number_format($rawSize / 1073741824, 1) . ' GiB';
    } elseif ($rawSize / 1048576 > 1) {
        return number_format($rawSize / 1048576, 1) . ' MiB';
    } elseif ($rawSize / 1024 > 1) {
        return number_format($rawSize / 1024, 1) . ' KiB';
    } elseif ($rawSize > 1) {
        return number_format($rawSize, 0) . ' bytes';
    } else {
        return 'unknown';
    }
}

$dir = opendir($archives);
if ($dir) {
    while (false !== ($filename = readdir($dir))) {
        if ($filename[0] != '.' && $filename[0] != '..' && preg_match('/' . date('Ymd') . '/', $filename)) {
            $thefile = $archives . '/' . $filename;
            $size = exec("ls -l '" . $thefile . "' | awk '{print $5}'");
            if ($size > 0) {
                $pagetext .= $filename . " (" . format_filesize($size) . ")\n";
            } else {
                $pagetext .= $filename . " (" . format_filesize($size) . ")\n";
            }
            $totalsize += $size;
        }
    }
    $pagetext .= "\nTotal : " . format_filesize($totalsize) . "\n";
}
foreach ($dest as $d) {
    mail($d, '[' . $host . '] Backup OK', $pagetext);
}
