<?php

$oInstaller = new \Core\App\Installer();
$oInstaller->onInstall(function() use ($oInstaller){

    $oInstaller->db->query('CREATE TABLE IF NOT EXISTS `' . Phpfox::getT('gradeservice_questions') . '` (
      `question_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `max_rate` int(2) unsigned NOT NULL,
      `m_connection` varchar(75) NOT NULL DEFAULT \'\',
      `question` varchar(500) NOT NULL,
      `is_active` tinyint(1) NOT NULL DEFAULT \'0\',
      `time_stamp` int(10) unsigned NOT NULL,
      `ip_address` varchar(15) DEFAULT NULL,
      PRIMARY KEY `question_id` (`question_id`),
      KEY `is_active` (`is_active`)
    )');

});
