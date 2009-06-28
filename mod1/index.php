<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Sven Kalbhenn <sven@skom.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */


$LANG->includeLLFile('EXT:uniseminars/mod1/locallang.xml');
require_once(PATH_t3lib . 'class.t3lib_scbase.php');
$BE_USER->modAccess($MCONF,1);	// This checks permissions and exits if the users has no permission for entry.
	// DEFAULT initialization of a module [END]



/**
 * Module 'Course participants' for the 'uniseminars' extension.
 *
 * @author	Sven Kalbhenn <sven@skom.de>
 * @package	TYPO3
 * @subpackage	tx_uniseminars
 */
class  tx_uniseminars_module1 extends t3lib_SCbase {
	var $MCONF = array();
	var $MOD_MENU = array();
	var $MOD_SETTINGS = array();
	var $COURSES = array();
	var $DEPARTMENTS = array();

	/**
	 * Document templat eobject
	 *
	 * @var noDoc
	 */
	var $doc;
	var $content;


				
	/**
	 * Initialize module
	 *
	 * @return	void
	 */
	function init()	{
		global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;
		$this->MCONF = $GLOBALS['MCONF'];

		$this->loadDepartmentArray();
		$this->menuConfig();
		
		$this->doc = t3lib_div::makeInstance('template');
		$this->doc->backPath = $BACK_PATH;
		$this->doc->setModuleTemplate('templates/belog.html');
		$this->doc->docType = 'xhtml_trans';

		// JavaScript
		$this->doc->JScode = '
		<script language="javascript" type="text/javascript">
			script_ended = 0;
			function jumpToUrl(URL)	{
				window.location.href = URL;
			}
		</script>
		';

		$this->doc->tableLayout = Array (
			'0' => Array (
				'0' => Array('<td width="17px" valign="top" class="c-headLineTable"><b>','</b></td><td class="c-headLineTable"><img src="'.$this->doc->backPath.'clear.gif" width="5" height="1"></td>'),
				'1' => Array('<td width="160px" valign="top" class="c-headLineTable"><b>','</b></td><td class="c-headLineTable"><img src="'.$this->doc->backPath.'clear.gif" width="5" height="1"></td>'),
				'2' => Array('<td width="260px" valign="top" class="c-headLineTable"><b>','</b></td><td class="c-headLineTable"><img src="'.$this->doc->backPath.'clear.gif" width="5" height="1"></td>'),
				'3' => Array('<td width="40px" valign="top" class="c-headLineTable"><b>','</b></td><td class="c-headLineTable"><img src="'.$this->doc->backPath.'clear.gif" width="5" height="1"></td>'),
				'4' => Array('<td width="480px" valign="top" class="c-headLineTable"><b>','</b></td><td class="c-headLineTable"><img src="'.$this->doc->backPath.'clear.gif" width="5" height="1"></td>'),
				'5' => Array('<td width="45px" valign="top" class="c-headLineTable"><b>','</b></td><td class="c-headLineTable"><img src="'.$this->doc->backPath.'clear.gif" width="5" height="1"></td>'),
				'defCol' => Array('<td valign="top" class="c-headLineTable"><b>','</b></td><td class="c-headLineTable"><img src="'.$this->doc->backPath.'clear.gif" width="5" height="1"></td>')
			),
			'defRow' => Array (
				'0' => Array('<td valign="top">','</td>'),
				'defCol' => Array('<td><img src="'.$this->doc->backPath.'clear.gif" width="10" height="1"></td><td valign="top">','</td>')
			)
		);
		$this->doc->table_TABLE = '<table border="0" cellspacing="0" cellpadding="0" class="typo3-dblist">';
		$this->doc->form = '<form action="" method="post">';

		$this->be_user_Array = t3lib_BEfunc::getUserNames();
	}


	/**
	 * Load Department-Array
	 *
	 * @return	void
	 */
	private function loadDepartmentArray(){
		$this->DEPARTMENTS = array();
		$table = 'tx_uniseminars_department';
		$select = '*';
		$where = '(deleted = 0) ';
		//$this->content.= $where;
		$groupBy = '';
		$orderBy = 'uid';
		$limit = '';
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select, $table, $where, $groupBy, $orderBy,	$limit);
		if ($res) {
				while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))	{
						$this->DEPARTMENTS[$row['uid']] = array('name'=>$row['name'],'description'=>$row['description']);
				}
		}
	}

	/**
	 * Load Course-Array of selected year and semester
	 *
	 * @return	void
	 */
	private function loadCourseArray(){
		global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;
		
		$this->COURSES = array();
		//$this->content.=t3lib_div::view_array($this->COURSES);
		$where_part='';
		if(isset($this->MOD_SETTINGS['semester'])){
				$where_part.=' AND semester = '.intval($this->MOD_SETTINGS['semester']);
		}
		if($this->MOD_SETTINGS['year'] > 0){
				$where_part.=' AND (year = "'.intval($this->MOD_SETTINGS['year']).'")';
		}
		if(isset($this->MOD_SETTINGS['departments'])){
				$where_part.=' AND department = '.intval($this->MOD_SETTINGS['departments']);
		}
		$table = 'tx_uniseminars_courses';
		$select = '*';
		$where = '(deleted = 0) '.$where_part;
		//$this->content.= $where;
		$groupBy = '';
		$orderBy = 'uid';
		$limit = '';
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select, $table, $where, $groupBy, $orderBy,	$limit);
		if ($res) {
				while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))	{
						$this->COURSES[$row['uid']] = array('title'=>$row['title'],'lecturer'=>$row['lecturer'],'departmentUid'=>$row['department']);
				}
		}
	}

	/**
	 * Menu configuration
	 *
	 * @return	void
	 */
	function menuConfig()	{
		global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;

			// MENU-ITEMS:
			// If array, then it's a selector box menu
			// If empty string it's just a variable, that'll be saved.
			// Values NOT in this array will not be saved in the settings-array for the module.
		$this->MOD_MENU = array(
			'function' => Array (
				'1' => $LANG->getLL('function1'),
				'2' => $LANG->getLL('function2'),
				'3' => $LANG->getLL('function3'),
			),
			'time' => array(
				20 => $LANG->getLL('noLimit'),
				0 => $LANG->getLL('thisWeek'),
				1 => $LANG->getLL('lastWeek'),
				2 => $LANG->getLL('last7days'),
				10 => $LANG->getLL('thisMonth'),
				11 => $LANG->getLL('lastMonth'),
				12 => $LANG->getLL('last31days')				
			),
			'semester' => array(
				0 => 'Sommersemester',
				1 => 'Wintersemester'
			),
			'year' => array(
				2009 => '2009',
				2010 => '2010',
				2011 => '2011',
				2012 => '2012',
				2013 => '2013',
				2014 => '2014',
				2015 => '2015'
			),
		);
		$this->MOD_MENU['departments'] = array();
		if (is_array($this->DEPARTMENTS))	{
			foreach($this->DEPARTMENTS as $key=>$value){
				$this->MOD_MENU['departments'][$key] = $value['name'];
			}
		}

		$this->loadCourseArray();
		$this->MOD_MENU['courses'] = array();
		$this->MOD_MENU['courses'][0] = 'Alle';
		if (is_array($this->COURSES))	{
			foreach($this->COURSES as $key=>$value){
				$this->MOD_MENU['courses'][$key] = $value['title'];
			}	
		}

		// CLEANSE SETTINGS
		$this->MOD_SETTINGS = t3lib_BEfunc::getModuleData($this->MOD_MENU, t3lib_div::_GP('SET'), $this->MCONF['name']);
	}


	/**
	 * Main function
	 *
	 * @return	void
	 */
	function main()	{
		global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;

		$this->content.=$this->doc->header('Kursteilnehmer');
		$this->content.=$this->doc->spacer(5);

		// Menu compiled:
		$menuTime = t3lib_BEfunc::getFuncMenu(0,'SET[time]',$this->MOD_SETTINGS['time'],$this->MOD_MENU['time']);
		$menuFunction = t3lib_BEfunc::getFuncMenu(0,'SET[function]',$this->MOD_SETTINGS['function'],$this->MOD_MENU['function']);
		$menuSemester = t3lib_BEfunc::getFuncMenu(0,'SET[semester]',$this->MOD_SETTINGS['semester'],$this->MOD_MENU['semester']);
		$menuYear = t3lib_BEfunc::getFuncMenu(0,'SET[year]',$this->MOD_SETTINGS['year'],$this->MOD_MENU['year']);
		$menuDepartments = t3lib_BEfunc::getFuncMenu(0,'SET[departments]',$this->MOD_SETTINGS['departments'],$this->MOD_MENU['departments']);

		$this->content.=$this->doc->section('',$this->doc->menuTable(
			array(
				array($LANG->getLL('function').':',$menuFunction),
				array($LANG->getLL('department').':',$menuDepartments)
			),
			array(
				array($LANG->getLL('registrations').':',$menuTime),
				array($LANG->getLL('semester').':',$menuSemester)
			),
			array(
				array('',''),
				array($LANG->getLL('year').':',$menuYear)
			)
		));
		$this->content.=$this->doc->divider(5);

		$codeArr = $this->initArray();
		$oldHeader='';
		$c=0;
		$this->moduleContent();		

		// Setting up the buttons and markers for docheader
		$docHeaderButtons = $this->getButtons();
		//$markers['CSH'] = $docHeaderButtons['csh'];
		$markers['CONTENT'] = $this->content;

			// Build the <body> for the module
		$this->content = $this->doc->startPage('Kursteilnehmer');
		$this->content.= $this->doc->moduleBody($this->pageinfo, $docHeaderButtons, $markers);
		$this->content.= $this->doc->endPage();
		$this->content = $this->doc->insertStylesAndJS($this->content);
	}

	/**
	 * Generates the module content
	 *
	 * @return	void
	 */
	function moduleContent()	{
		switch((string)$this->MOD_SETTINGS['function'])	{
			case 1:
				$this->printStudentList();
			break;
			case 2:
				$content='<div align="center"><strong>Hello World!</strong></div><br />
					framework for a backend module but apart from that it does nothing useful until you open the script '.substr(t3lib_extMgm::extPath('uniseminars'),strlen(PATH_site)).'mod1/index.php and edit it!
					<hr />
					<br />This is the GET/POST vars sent to the script:<br />'.
					'GET:'.t3lib_div::view_array($_GET).'<br />'.
					'POST:'.t3lib_div::view_array($_POST).'<br />'.
					'';
				$this->content.=$this->doc->section('Message #1:',$content,0,1);
			break;
			case 3:
				$this->showLog();
			break;
		}
	}
				
	/**
	 * Make output for the StudentList
	 */
	protected function printStudentList(){
			global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;
			$this->content.=$this->doc->header($LANG->getLL('registrations'));
			$this->content.=$this->doc->spacer(5);
			// Menu compiled:
			//$this->loadCourseArray();
			$this->menuConfig();
			$menuCourses = t3lib_BEfunc::getFuncMenu(0,'SET[courses]',$this->MOD_SETTINGS['courses'],$this->MOD_MENU['courses']);

			$this->content .= $this->doc->section('',$this->doc->menuTable(
					array(
						array('Courses:',$menuCourses),
						array('','')
					)
			));
			$this->content.=$this->doc->spacer(15);
			$codeArr = $this->initArray();
			$oldHeader='';
			$c=0;
			$content = '';
			$res = $this->getStudentList();
			if ($res) {
				while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))	{
					if($this->COURSES[$row['courseid']]['departmentUid'] == $this->MOD_SETTINGS['departments']){
							$header = $this->COURSES[$row['courseid']]['title'].' ['.$this->COURSES[$row['courseid']]['lecturer'].']';
							if (!$oldHeader)	$oldHeader=$header;
							if ($header != $oldHeader)	{
								$this->content.=$this->doc->spacer(10);
								$this->content.=$this->doc->section($oldHeader,$this->doc->table($codeArr));
								$codeArr=$this->initArray();
								$oldHeader=$header;
								$i = 0;
							}
							$i++;
							$codeArr[$i][] = $i;
							$codeArr[$i][] = $row['lastname'].', '.$row['firstname'];
							$codeArr[$i][] = $row['email'];
							$codeArr[$i][] = $this->getGuestType($row['type']);
							$codeArr[$i][] = $row['subject'];
							$codeArr[$i][] = $this->doc->formatTime($row['tstamp'],10);
					}
				}
				//$this->content.=t3lib_div::view_array($this->MOD_SETTINGS);

				$GLOBALS['TYPO3_DB']->sql_free_result($res);
				$this->content .= $this->doc->spacer(10);
				$this->content .= $this->doc->section($header,$this->doc->table($codeArr));
				$this->content.=$this->doc->spacer(10);
				$this->content .= '<form id="export_form" action="index.php" method="post" enctype="'.$GLOBALS['TYPO3_CONF_VARS']['SYS']['form_enctype'].'">
													 <table cellpadding="0" cellspacing="0">';
				$this->content .= 
                        '<table cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="padding-right: 15px;">'.$LANG->getLL('export_type').':</td>
                                <td style="padding-right: 5px;"><input type="radio" name="export_type" value="xls" /></td>
                                <td style="padding-right: 15px;">'.$LANG->getLL('export_type_xls').'</td>
                                <td style="padding-right: 5px;"><input type="radio" name="export_type" value="csv" /></td>
                                <td style="padding-right: 25px;">'.$LANG->getLL('export_type_csv').'</td>
                                <td><input type="submit" name="submit_form" value="'.$LANG->getLL('export_data').'" /></td>
                            </tr>
                        </table>';

        $this->content .= '</form><br /><br />';
				if (t3lib_div::GPvar('submit_form')){
						$this->content .= $this->writeExportFile();
				}
		}
	}

	/**
	 * Generate the Student-List
	 * 
	 * @return	$res Result-Pointer
	 */
	protected function getStudentList(){
		global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;

		$where_part='';
		$where_part.=' AND year='.intval($this->MOD_SETTINGS['year']);
		$where_part.=' AND semester='.intval($this->MOD_SETTINGS['semester']);
		if($this->MOD_SETTINGS['courses'] > 0){
			$where_part.=' AND courseid='.intval($this->MOD_SETTINGS['courses']);
		}
		$starttime=0;
		$endtime=time();
		// Time:
		switch($this->MOD_SETTINGS['time'])		{
			case 0:
				// This week
				$week = (date('w') ? date('w') : 7)-1;
				$starttime = mktime (0,0,0)-$week*3600*24;
			break;
			case 1:
				// Last week
				$week = (date('w') ? date('w') : 7)-1;
				$starttime = mktime (0,0,0)-($week+7)*3600*24;
				$endtime = mktime (0,0,0)-$week*3600*24;
			break;
			case 2:
				// Last 7 days
				$starttime = mktime (0,0,0)-7*3600*24;
			break;
			case 10:
				// This month
				$starttime = mktime (0,0,0, date('m'),1);
			break;
			case 11:
				// Last month
				$starttime = mktime (0,0,0, date('m')-1,1);
				$endtime = mktime (0,0,0, date('m'),1);
			break;
			case 12:
				// Last 31 days
				$starttime = mktime (0,0,0)-31*3600*24;
			break;
		}
		if ($starttime)	{
			$where_part.=' AND crdate>='.$starttime.' AND crdate<'.$endtime;
		}	
		$table = 'tx_uniseminars_guests';
		$select = '*';
		$where = '(deleted = 0)'.$where_part;
		$groupBy = '';
		$orderBy = 'courseid, lastname ASC';
		$limit = '';
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select, $table, $where, $groupBy, $orderBy,	$limit);
		return $res;
	}

	/**
	 * Initialize the registration table array with header labels.
	 *
	 * @return	array
	 */
	function initArray()	{
		global $LANG;
		$codeArr=Array();
		$codeArr[0][] = $LANG->getLL('number');
		$codeArr[0][] = $LANG->getLL('name');
		$codeArr[0][] = $LANG->getLL('email');
		$codeArr[0][] = $LANG->getLL('type');
		$codeArr[0][] = $LANG->getLL('subject');
		$codeArr[0][] = $LANG->getLL('registration');
		return $codeArr;
	}



		/**
		* write the export-file
		*
		* @return	file data
		*/
		function writeExportFile(){
				global $LANG;

				$colTitles = array(
												$LANG->getLL('number'),
												$LANG->getLL('firstname'),
												$LANG->getLL('lastname'),
												$LANG->getLL('email'),
												$LANG->getLL('type'),
												$LANG->getLL('subject'),
												$LANG->getLL('registration')
											);
				$fileContent = '';
				$i = 0;
				if (count($colTitles) > 0 && t3lib_div::GPvar('export_type') != ''){
						//$res = $this->getSqlQueryData(implode(',', $sSelectCol), 'fe_users', 'usergroup='.implode(',', $sSelectUsg));
						$res = $this->getStudentList();
						if ($res) {
								while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))	{
										//$studentList[] = $row;
										$i++;
										$studentList[$i][] = $i;
										$studentList[$i][] = $row['firstname'];
										$studentList[$i][] = $row['lastname'];
										$studentList[$i][] = $row['email'];
										$studentList[$i][] = $this->getGuestType($row['type']);
										$studentList[$i][] = $row['subject'];
										$studentList[$i][] = $this->doc->formatTime($row['tstamp'],10);
								}
						}
						if (!empty($studentList)){
								if (t3lib_div::GPvar('export_type') == 'csv'){
										foreach ($colTitles as $title){
												$fileContent .= '"'.$title.'";';
										}
										$fileContent .= "\n";
										foreach ($studentList as $student){
												$fileContent .= '"'.implode('";"', array_values($student)).'";'."\n";
										}
										$export_type = 'csv';
								} elseif (t3lib_div::GPvar('export_type') == 'xls'){
										$fileContent .=
												'<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
														<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
														<html>
																<head>
																		<meta http-equiv="Content-type" content="text/html;charset=utf-8" />
																		<style id="Classeur1_16681_Styles">
																		</style>
																</head>
																<body>
																		<div id="Classeur1_16681" align=center x:publishsource="Excel">
																				<table x:str border=0 cellpadding=0 cellspacing=0 width=100% style="border-collapse: collapse"><tr>';

										foreach ($colTitles as $title){
												$fileContent .= '<td class=xl2216681 nowrap>'.$title.'</td>';
										}
										$fileContent .= '</tr>';
										foreach ($studentList as $student){
												$fileContent .= '<tr><td class=xl2216681 nowrap>'.implode('</td><td class=xl2216681 nowrap>', array_values($student)).'</td></tr>';
										}
										$fileContent .= '</table></div></body></html>';
										$export_type = 'xls';
								}

								$error = '<span style="color: red; font-weight: bold; font-size: 14px;">';
								$targedDirName = PATH_site.'fileadmin/export_students/';
								$targedFileName = 'students.'.$export_type;
								unlink($targedDirName.$targedFileName);
								$tmpfileName = t3lib_div::tempnam('students');
								if(!t3lib_div::writeFile($tmpfileName,$fileContent)){
										$error .= 'Fehler beim Schreiben:<br />';
										$error .= 'tmpDirName: '.$tmpDirName.'<br />';
										$error .= 'tmpfileName: '.$tmpfileName.'<br />';
										$error .= '</span>';
										return $error;
								}
								t3lib_div::upload_copy_move($tmpfileName,$targedDirName.$targedFileName);
								t3lib_div::unlink_tempfile($tmpfileName);
								$output =
										'<table cellpadding="0" cellspcing="0">
												<tr>
														<td style="font-size: 14px; font-weight: bold;">'.$LANG->getLL('download_file').':</td>
														<td style="padding-left: 10px;" colspan="2"><a style="text-decoration: underline; font-size: 14px; font-weight: bold;" href="../../../../fileadmin/export_students/students.'.$export_type.'" >students.'.$export_type.'</a></td>
												</tr>
										</table>';
								return $output;								
						} else return '<span style="color: red; font-weight: bold; font-size: 14px;">'.$LANG->getLL('error').': '.$LANG->getLL('error_nofeuser').'</span>';
				} else return '<span style="color: red; font-weight: bold; font-size: 14px;">'.$LANG->getLL('error').': '.$LANG->getLL('error_nodata').'</span>';

		}



	private function showLog(){
		$this->content.='Dies ist ein Test.';
		$this->content.=t3lib_div::view_array($this->MOD_SETTINGS);
		/*
		global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;
		// Action (type):
		$where_part='';
		if ($this->MOD_SETTINGS['action'] > 0)	{
			$where_part.=' AND type='.intval($this->MOD_SETTINGS['action']);
		} elseif ($this->MOD_SETTINGS['action'] == -1)	{
			$where_part.=' AND error';
		}


		$starttime=0;
		$endtime=time();

		// Time:
		switch($this->MOD_SETTINGS['time'])		{
			case 0:
				// This week
				$week = (date('w') ? date('w') : 7)-1;
				$starttime = mktime (0,0,0)-$week*3600*24;
			break;
			case 1:
				// Last week
				$week = (date('w') ? date('w') : 7)-1;
				$starttime = mktime (0,0,0)-($week+7)*3600*24;
				$endtime = mktime (0,0,0)-$week*3600*24;
			break;
			case 2:
				// Last 7 days
				$starttime = mktime (0,0,0)-7*3600*24;
			break;
			case 10:
				// This month
				$starttime = mktime (0,0,0, date('m'),1);
			break;
			case 11:
				// Last month
				$starttime = mktime (0,0,0, date('m')-1,1);
				$endtime = mktime (0,0,0, date('m'),1);
			break;
			case 12:
				// Last 31 days
				$starttime = mktime (0,0,0)-31*3600*24;
			break;
		}
		if ($starttime)	{
			$where_part.=' AND tstamp>='.$starttime.' AND tstamp<'.$endtime;
		}


			// Users
		if ($this->MOD_SETTINGS['users'] > 0)	{	// All users
			$this->be_user_Array = t3lib_BEfunc::blindUserNames($this->be_user_Array,array($this->MOD_SETTINGS['users']),1);
			if (is_array($this->be_user_Array))	{
				while(list(,$val)=each($this->be_user_Array))	{
					if ($val['uid']!=$BE_USER->user['uid'])	{
						$selectUsers[]=$val['uid'];
					}
				}
			}
			$selectUsers[] = 0;
			$where_part.=' AND userid in ('.implode($selectUsers,',').')';
		} elseif ($this->MOD_SETTINGS['users']==-1) {
			$where_part.=' AND userid='.$BE_USER->user['uid'];	// Self user
		}

		if ($GLOBALS['BE_USER']->workspace!==0)	{
			$where_part.=' AND workspace='.intval($GLOBALS['BE_USER']->workspace);
		}




		$log = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', 'sys_log', '1=1'.$where_part, '', 'uid DESC', intval($this->MOD_SETTINGS['max']));

		while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($log))	{
			$header=$this->doc->formatTime($row['tstamp'],10);
			if (!$oldHeader)	$oldHeader=$header;

			if ($header!=$oldHeader)	{
				$this->content.=$this->doc->spacer(10);
				$this->content.=$this->doc->section($oldHeader,$this->doc->table($codeArr));
				$codeArr=$this->lF->initArray();
				$oldHeader=$header;
				$this->lF->reset();
			}

			$i++;
			$codeArr[$i][]=$this->lF->getTimeLabel($row['tstamp']);
			$codeArr[$i][]=$this->lF->getUserLabel($row['userid'],$row['workspace']);
			$codeArr[$i][]=$this->lF->getTypeLabel($row['type']);
			$codeArr[$i][]=$row['error'] ? $this->lF->getErrorFormatting($this->lF->errorSign[$row['error']],$row['error']) : '';
			$codeArr[$i][]=$this->lF->getActionLabel($row['type'].'_'.$row['action']);
			$codeArr[$i][]=$this->lF->formatDetailsForList($row);
		}
		$this->content.=$this->doc->spacer(10);
		$this->content.=$this->doc->section($header,$this->doc->table($codeArr));

		$GLOBALS['TYPO3_DB']->sql_free_result($log);

		 */
	}


		/**
		 * Main function of the module. Write the content to $this->content
		 * If you chose "web" as main module, you will need to consider the $this->id parameter which will contain the uid-number of the page clicked in the page tree
		 *
		 * @return	[type]		...
		 */
		/*
		function main()	{
			global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;

			// Access check!
			// The page will show only if there is a valid page and if this page may be viewed by the user
			$this->pageinfo = t3lib_BEfunc::readPageAccess($this->id,$this->perms_clause);
			$access = is_array($this->pageinfo) ? 1 : 0;

				// initialize doc
			$this->doc = t3lib_div::makeInstance('template');
			$this->doc->setModuleTemplate(t3lib_extMgm::extPath('uniseminars') . 'mod1//mod_template.html');
			$this->doc->backPath = $BACK_PATH;
			$docHeaderButtons = $this->getButtons();

			if (($this->id && $access) || ($BE_USER->user['admin'] && !$this->id))	{

					// Draw the form
				$this->doc->form = '<form action="" method="post" enctype="multipart/form-data">';

					// JavaScript
				$this->doc->JScode = '
					<script language="javascript" type="text/javascript">
						script_ended = 0;
						function jumpToUrl(URL)	{
							document.location = URL;
						}
					</script>
				';
				$this->doc->postCode='
					<script language="javascript" type="text/javascript">
						script_ended = 1;
						if (top.fsMod) top.fsMod.recentIds["web"] = 0;
					</script>
				';
					// Render content:
				$this->moduleContent();
			} else {
					// If no access or if ID == zero
				$docHeaderButtons['save'] = '';
				$this->content.=$this->doc->spacer(10);
			}

				// compile document
			$markers['FUNC_MENU'] = t3lib_BEfunc::getFuncMenu(0, 'SET[function]', $this->MOD_SETTINGS['function'], $this->MOD_MENU['function']);
			$markers['CONTENT'] = $this->content;

					// Build the <body> for the module
			$this->content = $this->doc->startPage($LANG->getLL('title'));
			$this->content.= $this->doc->moduleBody($this->pageinfo, $docHeaderButtons, $markers);
			$this->content.= $this->doc->endPage();
			$this->content = $this->doc->insertStylesAndJS($this->content);

		}
		 * */


		/**
		* Prints out the module HTML
		*
		* @return	void
		*/
		function printContent()	{
				$this->content.=$this->doc->endPage();
				echo $this->content;
		}



		
		protected function getGuestType($guestType){
				if($guestType == 0){
						return 'Guest';
				}else{
						return 'Student';
				}
		}



				

		/**
		 * Create the panel of buttons for submitting the form or otherwise perform operations.
		 *
		 * @return	array	all available buttons as an assoc. array
		 */
		protected function getButtons()	{

			$buttons = array(
				'csh' => '',
				'shortcut' => '',
				'save' => ''
			);
				// CSH
			$buttons['csh'] = t3lib_BEfunc::cshItem('_MOD_web_func', '', $GLOBALS['BACK_PATH']);

				// SAVE button
			$buttons['save'] = '<input type="image" class="c-inputButton" name="submit" value="Update"' . t3lib_iconWorks::skinImg($GLOBALS['BACK_PATH'], 'gfx/savedok.gif', '') . ' title="' . $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.php:rm.saveDoc', 1) . '" />';


				// Shortcut
			if ($GLOBALS['BE_USER']->mayMakeShortcut())	{
				$buttons['shortcut'] = $this->doc->makeShortcutIcon('', 'function', $this->MCONF['name']);
			}

			return $buttons;
		}
				
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/uniseminars/mod1/index.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/uniseminars/mod1/index.php']);
}




// Make instance:
$SOBE = t3lib_div::makeInstance('tx_uniseminars_module1');
$SOBE->init();

// Include files?
foreach($SOBE->include_once as $INC_FILE)	include_once($INC_FILE);

$SOBE->main();
$SOBE->printContent();

?>