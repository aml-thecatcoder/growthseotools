<?php

/*
This is a cronjob file!
This file is used to delete stored videos after 24 hours automatically when a cron job is set
*/

$file_dir = "components/storage/app/livewire-tmp"; // folder location where videos are downloaded
$delete_after = 86400; // time in seconds after videos should be deleted

if (file_exists($file_dir)) {
	$files = scandir($file_dir);
	foreach ($files as $idx => $file_name) {
		$create_time = filemtime($file_dir . "/" . $file_name);
		if ((time() - $create_time) > $delete_after)
		{
			unlink($file_dir . "/" . $file_name);
		}
	}
}
