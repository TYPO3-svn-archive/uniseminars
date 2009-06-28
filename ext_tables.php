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

$TCA["tx_uniseminars_guests"] = array (
    "ctrl" => array (
        'title'     => 'LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_guests',
        'label'     => 'lastname',
        'tstamp'    => 'tstamp',
        'crdate'    => 'crdate',
        'cruser_id' => 'cruser_id',
        'default_sortby' => "ORDER BY crdate",
        'delete' => 'deleted',
        'enablecolumns' => array (
            'disabled' => 'hidden',
        ),
        'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
        'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_uniseminars_guests.gif',
    ),
    "feInterface" => array (
        "fe_admin_fieldList" => "hidden, courseid, firstname, lastname, email, subject, type, semester, year",
    )
);
//t3lib_extMgm::allowTableOnStandardPages('tx_uniseminars_guests');
if (TYPO3_MODE == 'BE') {
	t3lib_extMgm::addModulePath('user_txuniseminarsM1', t3lib_extMgm::extPath($_EXTKEY) . 'mod1/');

	t3lib_extMgm::addModule('user', 'txuniseminarsM1', '', t3lib_extMgm::extPath($_EXTKEY) . 'mod1/');
}

t3lib_extMgm::addStaticFile('uniseminars', 'configuration', 'Uni-Seminars'); // ($extKey, $path, $title)
t3lib_extMgm::addPlugin(array('Uni-Seminars', 'tx_uniseminars_controllers_example'),'list_type');  // array($title, $pluginKey)
t3lib_extMgm::addPlugin(array('Uni-Seminar-Details', 'tx_uniseminars_controllers_details'),'list_type');
t3lib_extMgm::addPlugin(array('Uni-Seminar-Register', 'tx_uniseminars_controllers_register'),'list_type');
// some cosmetic of the view
$TCA['tt_content']['types']['list']['subtypes_excludelist']['tx_uniseminars_controllers_example']='layout,select_key,pages,recurs';
$TCA['tt_content']['types']['list']['subtypes_excludelist']['tx_uniseminars_controllers_details']='layout,select_key,pages,recurs';
$TCA['tt_content']['types']['list']['subtypes_excludelist']['tx_uniseminars_controllers_register']='layout,select_key,pages,recurs';
// flexforms
$TCA['tt_content']['types']['list']['subtypes_addlist']['tx_uniseminars_controllers_example']='pi_flexform';
t3lib_extMgm::addPiFlexFormValue('tx_uniseminars_controllers_example', 'FILE:EXT:uniseminars/configuration/flexform_courses.xml');
$TCA['tt_content']['types']['list']['subtypes_addlist']['tx_uniseminars_controllers_register']='pi_flexform';
t3lib_extMgm::addPiFlexFormValue('tx_uniseminars_controllers_register', 'FILE:EXT:uniseminars/configuration/flexform_register.xml');
?>
