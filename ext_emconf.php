<?php

########################################################################
# Extension Manager/Repository config file for ext: "uniseminars"
#
# Auto generated 30-08-2008 08:09
#
# Manual updates:
# Only the data in the array - anything else is removed by next write.
# "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Uni-Seminars - lib/div',
	'description' => 'A List of Uni-Seminars with register-option',
	'category' => 'plugin',
	'shy' => 0,
	'version' => '0.1.3',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'beta',
	'uploadfolder' => 0,
	'createDirs' => 'fileadmin/export_students/',
	'modify_tables' => '',
	'clearcacheonload' => 0,
	'lockType' => '',
	'author' => 'Sven Kalbhenn',
	'author_email' => 'sven@skom.de',
	'author_company' => 'SKom',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'php' => '5.1.0-0.0.0',
			'lib' => '0.1.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:19:{s:9:"ChangeLog";s:4:"1e64";s:12:"ext_icon.gif";s:4:"95ee";s:17:"ext_localconf.php";s:4:"9fce";s:14:"ext_tables.php";s:4:"22d7";s:24:"doc/uniseminarsController.png";s:4:"65e7";s:27:"doc/uniseminarsEctExtensions.png";s:4:"4dd9";s:22:"doc/uniseminarsFileList.png";s:4:"6b3a";s:26:"doc/uniseminarsFrontendView.png";s:4:"6a06";s:32:"doc/uniseminarsInExtensionManager.png";s:4:"1298";s:34:"doc/uniseminarsIncludStaticTemplate.png";s:4:"27c0";s:19:"doc/uniseminarsModel.png";s:4:"9d61";s:25:"doc/uniseminarsPhpTemplate.png";s:4:"5e2d";s:19:"doc/uniseminarsSetup.png";s:4:"a7a6";s:14:"doc/manual.sxw";s:4:"b386";s:39:"views/class.tx_uniseminars_views_example.php";s:4:"f5a5";s:23:"configuration/setup.txt";s:4:"ca36";s:61:"controllers/class.tx_uniseminars_controllers_registerform.php";s:4:"bc5e";s:51:"controllers/class.tx_uniseminars_controllers_example.php";s:4:"bc5e";s:41:"models/class.tx_uniseminars_models_seminars.php";s:4:"474a";s:21:"templates/example.php";s:4:"1907";}',
);

?>