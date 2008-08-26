<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
$TCA["tx_uniseminars_courses"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'languageField'            => 'sys_language_uid',	
		'transOrigPointerField'    => 'l18n_parent',	
		'transOrigDiffSourceField' => 'l18n_diffsource',	
		'sortby' => 'sorting',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',	
			'starttime' => 'starttime',	
			'endtime' => 'endtime',	
			'fe_group' => 'fe_group',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_uniseminars_courses.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "sys_language_uid, l18n_parent, l18n_diffsource, hidden, starttime, endtime, fe_group, title, type, department, coursetype, semester, year, lecturer, credits, objective, targets, prerequisites, reading, datelocation, start, grading, examdate, closed, contact, email",
	)
);

$TCA["tx_uniseminars_department"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_department',		
		'label'     => 'name',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'languageField'            => 'sys_language_uid',	
		'transOrigPointerField'    => 'l18n_parent',	
		'transOrigDiffSourceField' => 'l18n_diffsource',	
		'sortby' => 'sorting',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',	
			'fe_group' => 'fe_group',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_uniseminars_department.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "sys_language_uid, l18n_parent, l18n_diffsource, hidden, fe_group, name, description",
	)
);


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_mvc1']='layout,select_key,pages,recursive';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY.'_mvc1']='pi_flexform';


t3lib_extMgm::addStaticFile('uniseminars', './configurations/mvc1', 'Uni-Seminars');


t3lib_extMgm::addPiFlexFormValue($_EXTKEY.'_mvc1', 'FILE:EXT:uniseminars/configurations/mvc1/flexform.xml');


t3lib_extMgm::addPlugin(array('LLL:EXT:uniseminars/locallang_db.xml:tt_content.list_type_pi1', $_EXTKEY.'_mvc1'),'list_type');
?>