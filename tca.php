<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA["tx_uniseminars_courses"] = array (
	"ctrl" => $TCA["tx_uniseminars_courses"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "sys_language_uid,l18n_parent,l18n_diffsource,hidden,starttime,endtime,fe_group,title,type,department,coursetype,semester,year,lecturer,credits,objective,targets,prerequisites,reading,datelocation,start,grading,examdate,closed,contact,email"
	),
	"feInterface" => $TCA["tx_uniseminars_courses"]["feInterface"],
	"columns" => array (
		'sys_language_uid' => array (		
			'exclude' => 1,
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array (
				'type'                => 'select',
				'foreign_table'       => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				)
			)
		),
		'l18n_parent' => array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude'     => 1,
			'label'       => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config'      => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_uniseminars_courses',
				'foreign_table_where' => 'AND tx_uniseminars_courses.pid=###CURRENT_PID### AND tx_uniseminars_courses.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => array (		
			'config' => array (
				'type' => 'passthrough'
			)
		),
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'starttime' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
			'config'  => array (
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'eval'     => 'date',
				'default'  => '0',
				'checkbox' => '0'
			)
		),
		'endtime' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
			'config'  => array (
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'eval'     => 'date',
				'checkbox' => '0',
				'default'  => '0',
				'range'    => array (
					'upper' => mktime(0, 0, 0, 12, 31, 2020),
					'lower' => mktime(0, 0, 0, date('m')-1, date('d'), date('Y'))
				)
			)
		),
		'fe_group' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.fe_group',
			'config'  => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
					array('LLL:EXT:lang/locallang_general.xml:LGL.hide_at_login', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.any_login', -2),
					array('LLL:EXT:lang/locallang_general.xml:LGL.usergroups', '--div--')
				),
				'foreign_table' => 'fe_groups'
			)
		),
		"title" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.title",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required",
			)
		),
		"type" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.type",		
			"config" => Array (
				"type" => "radio",
				"items" => Array (
					Array("LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.type.I.0", "0"),
					Array("LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.type.I.1", "1"),
				),
			)
		),
		"department" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.department",		
			"config" => Array (
				"type" => "group",	
				"internal_type" => "db",	
				"allowed" => "tx_uniseminars_department",	
				"size" => 3,	
				"minitems" => 0,
				"maxitems" => 5,
			)
		),
		"coursetype" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.coursetype",		
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.coursetype.I.0", "0"),
					Array("LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.coursetype.I.1", "1"),
					Array("LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.coursetype.I.2", "2"),
					Array("LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.coursetype.I.3", "3"),
					Array("LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.coursetype.I.4", "4"),
					Array("LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.coursetype.I.5", "5"),
					Array("LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.coursetype.I.6", "6"),
					Array("LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.coursetype.I.7", "7"),
					Array("LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.coursetype.I.8", "8"),
				),
				"size" => 1,	
				"maxitems" => 1,
			)
		),
		"semester" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.semester",		
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.semester.I.0", "0"),
					Array("LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.semester.I.1", "1"),
				),
				"size" => 1,	
				"maxitems" => 1,
			)
		),
		"year" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.year",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required",
			)
		),
		"lecturer" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.lecturer",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
		"credits" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.credits",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "double2",
			)
		),
		"objective" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.objective",		
			"config" => Array (
				"type" => "text",
				"cols" => "30",
				"rows" => "5",
				"wizards" => Array(
					"_PADDING" => 2,
					"RTE" => array(
						"notNewRecords" => 1,
						"RTEonly" => 1,
						"type" => "script",
						"title" => "Full screen Rich Text Editing|Formatteret redigering i hele vinduet",
						"icon" => "wizard_rte2.gif",
						"script" => "wizard_rte.php",
					),
				),
			)
		),
		"targets" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.targets",		
			"config" => Array (
				"type" => "text",
				"cols" => "30",
				"rows" => "5",
				"wizards" => Array(
					"_PADDING" => 2,
					"RTE" => array(
						"notNewRecords" => 1,
						"RTEonly" => 1,
						"type" => "script",
						"title" => "Full screen Rich Text Editing|Formatteret redigering i hele vinduet",
						"icon" => "wizard_rte2.gif",
						"script" => "wizard_rte.php",
					),
				),
			)
		),
		"prerequisites" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.prerequisites",		
			"config" => Array (
				"type" => "text",
				"cols" => "30",
				"rows" => "5",
				"wizards" => Array(
					"_PADDING" => 2,
					"RTE" => array(
						"notNewRecords" => 1,
						"RTEonly" => 1,
						"type" => "script",
						"title" => "Full screen Rich Text Editing|Formatteret redigering i hele vinduet",
						"icon" => "wizard_rte2.gif",
						"script" => "wizard_rte.php",
					),
				),
			)
		),
		"reading" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.reading",		
			"config" => Array (
				"type" => "text",
				"cols" => "30",
				"rows" => "5",
				"wizards" => Array(
					"_PADDING" => 2,
					"RTE" => array(
						"notNewRecords" => 1,
						"RTEonly" => 1,
						"type" => "script",
						"title" => "Full screen Rich Text Editing|Formatteret redigering i hele vinduet",
						"icon" => "wizard_rte2.gif",
						"script" => "wizard_rte.php",
					),
				),
			)
		),
		"datelocation" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.datelocation",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
		"start" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.start",		
			"config" => Array (
				"type"     => "input",
				"size"     => "8",
				"max"      => "20",
				"eval"     => "date",
				"checkbox" => "0",
				"default"  => "0"
			)
		),
		"grading" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.grading",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
		"examdate" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.examdate",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
		"closed" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.closed",		
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.closed.I.0", "0"),
					Array("LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.closed.I.1", "1"),
					Array("LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.closed.I.2", "2"),
					Array("LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.closed.I.3", "3"),
				),
				"size" => 1,	
				"maxitems" => 1,
			)
		),
		"contact" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.contact",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
		"email" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_courses.email",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"wizards" => Array(
					"_PADDING" => 2,
					"link" => Array(
						"type" => "popup",
						"title" => "Link",
						"icon" => "link_popup.gif",
						"script" => "browse_links.php?mode=wizard",
						"JSopenParams" => "height=300,width=500,status=0,menubar=0,scrollbars=1"
					),
				),
			)
		),
	),
	"types" => array (
		"0" => array("showitem" => "sys_language_uid;;;;1-1-1, l18n_parent, l18n_diffsource, hidden;;1, title;;;;2-2-2, type;;;;3-3-3, department, coursetype, semester, year, lecturer, credits, objective;;;richtext[paste|bold|italic|underline|formatblock|class|left|center|right|orderedlist|unorderedlist|outdent|indent|link|image]:rte_transform[mode=ts], targets;;;richtext[paste|bold|italic|underline|formatblock|class|left|center|right|orderedlist|unorderedlist|outdent|indent|link|image]:rte_transform[mode=ts], prerequisites;;;richtext[paste|bold|italic|underline|formatblock|class|left|center|right|orderedlist|unorderedlist|outdent|indent|link|image]:rte_transform[mode=ts], reading;;;richtext[paste|bold|italic|underline|formatblock|class|left|center|right|orderedlist|unorderedlist|outdent|indent|link|image]:rte_transform[mode=ts], datelocation, start, grading, examdate, closed, contact, email")
	),
	"palettes" => array (
		"1" => array("showitem" => "starttime, endtime, fe_group")
	)
);



$TCA["tx_uniseminars_department"] = array (
	"ctrl" => $TCA["tx_uniseminars_department"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "sys_language_uid,l18n_parent,l18n_diffsource,hidden,fe_group,name,description"
	),
	"feInterface" => $TCA["tx_uniseminars_department"]["feInterface"],
	"columns" => array (
		'sys_language_uid' => array (		
			'exclude' => 1,
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array (
				'type'                => 'select',
				'foreign_table'       => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				)
			)
		),
		'l18n_parent' => array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude'     => 1,
			'label'       => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config'      => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_uniseminars_department',
				'foreign_table_where' => 'AND tx_uniseminars_department.pid=###CURRENT_PID### AND tx_uniseminars_department.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => array (		
			'config' => array (
				'type' => 'passthrough'
			)
		),
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'fe_group' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.fe_group',
			'config'  => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
					array('LLL:EXT:lang/locallang_general.xml:LGL.hide_at_login', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.any_login', -2),
					array('LLL:EXT:lang/locallang_general.xml:LGL.usergroups', '--div--')
				),
				'foreign_table' => 'fe_groups'
			)
		),
		"name" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_department.name",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required",
			)
		),
		"description" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:uniseminars/locallang_db.xml:tx_uniseminars_department.description",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
	),
	"types" => array (
		"0" => array("showitem" => "sys_language_uid;;;;1-1-1, l18n_parent, l18n_diffsource, hidden;;1, name, description")
	),
	"palettes" => array (
		"1" => array("showitem" => "fe_group")
	)
);
?>