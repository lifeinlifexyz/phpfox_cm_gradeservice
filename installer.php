<?php

$oInstaller = new \Core\App\Installer();
$oInstaller->onInstall(function() use ($oInstaller){
//    $oInstaller->db->query('CREATE TABLE IF NOT EXISTS `' . Phpfox::getT('digital_download_rating') . '` (
//      `dd_id` int(10) unsigned NOT NULL,
//      `user_id` int(10) unsigned NOT NULL,
//      `rating` varchar(2) DEFAULT NULL,
//      `time_stamp` int(10) unsigned NOT NULL,
//      `ip_address` varchar(15) DEFAULT NULL,
//      KEY `dd_id` (`dd_id`,`user_id`)
//    )');
});
