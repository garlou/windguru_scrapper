#!/usr/bin/php
<?php
/**
 * Telegram test. Send message
 *
 * Usage:
 *   send.php Peer_Name Message
 *
 * This is a demo/test script to be run from the command line.
 *
 * The TelegramClient can be used without Drupal too.
 */
require('vendor/autoload.php');

define('TELEGRAM_PATH', '/home/kae/Documents/workspace/tg/');
define('TELEGRAM_PEER', 'Surf');

if( $argv[1] == 'prod')
	define('CAPTURES_PATH', '/home/kae/Documents/workspace/os_crawler/captures/');
else
	define('CAPTURES_PATH', '/Users/kae/Documents/workspace/php/captures/');

$first=true;
while(!file_exists('/tmp/tg.sck')) {
		
	if(!$first)
	{
		echo "Cannot create /tmp/tg.sck. Quitting...\r\n";
		//die();
	}
	exec(TELEGRAM_PATH.'bin/telegram-cli -dWS /tmp/tg.sck &');
	$first=false;
	sleep(2);
	break;	
}

$telegram = new \Zyberspace\Telegram\Cli\Client('unix:///tmp/tg.sck');

if(!is_dir(CAPTURES_PATH)) die('Not a valid dir: '.CAPTURES_PATH."\r\n");

foreach (new DirectoryIterator(CAPTURES_PATH) as $fileInfo) {
    if($fileInfo->isDot()) continue;
    //	echo $fileInfo->getFilename() . "\n";
    $filename = $fileInfo->getFilename();
    $tokens = explode("_", $filename);

    if(count($tokens) == 3) 
    {
	    $city = str_replace("-", " ", $tokens[1]);
	    echo "processing: ".$city."\r\n";
			$telegram->msg(TELEGRAM_PEER, $city.":");
			echo "sending photo: ".CAPTURES_PATH.$filename."\r\n";
			if ($telegram->send_photo(TELEGRAM_PEER, CAPTURES_PATH.$filename) !== false) //photo sent
			{
				//deletes foto
				echo "delete file: ".CAPTURES_PATH.$filename."\r\n";
				unlink(CAPTURES_PATH.$filename);
			}
    }
}

die();

//$contactList = $telegram->getContactList();
$telegram->msg('Surf', 'Costa da Caparica:');
$telegram->send_photo('Surf', '/home/kae/Pictures/windguru_1426993742355.png');



