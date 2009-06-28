<?php

/**
 * A most minimalistic model of the lib/div type
 *
 * This is just a hello world example.
 * For a minimal practical example see the extension Bananas (bananas).
 * For a bigger practical example see the extension Elmar's FAQ (efaq).
 */
//tx_div::load('tx_lib_object');

class tx_uniseminars_models_seminars extends tx_lib_object {
	// Constructor
	function tx_uniseminars_models_seminars() {
		parent::tx_lib_object();
	}

	function loadSeminarList() {
		$fields = '*';
		$tables = 'tx_uniseminars_courses';
		$groupBy = null;
		$orderBy = 'sorting DESC';
		$where = '(hidden = 0) AND (deleted = 0) ';
		$limit = null;
		//t3lib_div::debug($this->controller->configurations,'loadSeminarList');
		/**** Institutes ****/
		$departments = explode(',',$this->controller->configurations->get('departmentSelection'));
		if(count($departments) > 0){
			$where .= 'AND  (';
			foreach($departments as $department){
				$where .= '(department LIKE "%'.$department.'%") OR ';
			}
			$where = substr($where, 0, count($where)-4);
			$where .= ') ';
		}
		/**** Course-Type ****/
		$courses = explode(',',$this->controller->configurations->get('coursetypeSelection'));
		if(count($courses) > 0){
			$where .= 'AND  (';
			foreach($courses as $course){
				$where .= '(coursetype = '.$course.') OR ';
			}
			$where = substr($where, 0, count($where)-4);
			$where .= ') ';
		}
		/**** Year ****/
		$where .= 'AND (type = '.$this->controller->configurations->get('typeSelection').') ';
		/**** Winter- or Summer-Term ****/
		if($this->controller->configurations->get('termSelection') == 0){
			$where .= 'AND (semester = 0) ';
		}elseif($this->controller->configurations->get('termSelection') == 1){
			$where .= 'AND (semester = 1) ';
		}
		/**** Year ****/
		if($this->controller->configurations->get('yearSelection') > 0){
			$where .= 'AND (year = '.$this->controller->configurations->get('yearSelection').') ';
		}


		$query = $GLOBALS['TYPO3_DB']->SELECTquery($fields, $tables, $where, $groupBy, $orderBy, $limit);
		//$query = $GLOBALS['TYPO3_DB']->SELECTquery('*', 'tx_zeitstadt_categories', $where);
		//t3lib_div::debug($query,'loadSeminarList');
		$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, $query);
		if($res){
			$entries = $this->_exportList($this->_makeList($res));
			for($entries->rewind(); $entries->valid(); $entries->next()){
				$this->append($entries->current());
			}
		}
	}

	function loadSeminarByUid($uid){
		$fields = '*';
		$tables = 'tx_uniseminars_courses';
		$groupBy = null;
		$orderBy = null;
		$where = 'uid = '.(int)$uid;
		$limit = 1;
		$query = $GLOBALS['TYPO3_DB']->SELECTquery($fields, $tables, $where, $groupBy, $orderBy, $limit);
		//t3lib_div::debug($query,'loadSeminarByUid');
		$res = $GLOBALS['TYPO3_DB']->sql_query($query);
		if($res) {
			$entry = $this->_exportRow($this->_makeRow($res));
			//t3lib_div::debug($entry,'loadSeminarByUid');
			$this->append($entry);
		}
	}

	/**
	 * Output-Manipulation
	 */
	function _exportRow($row){
		if(is_object($row)){
			//Insert Output-Manipulation
			//*** coursetype ***
			$_langSwitch = '%%%coursetype.I.'.$row->get('coursetype').'%%%';
			$row->set('coursetypetext', $_langSwitch);
			//*** semester ***
			if($row->get('semester') == 0){
				$row->set('semestertext', '%%%summerterm%%%');
			}else{
				$row->set('semestertext', '%%%winterterm%%%');
			}
			return $row;
		}
	}

	function _makeRow($result){
		if($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($result)){
			return new tx_lib_object($row);
		}
	}

	function _makeList($result){
		$list = new tx_lib_object(array());
		while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($result)){
			$list->append(new tx_lib_object($row));
		}
		return $list;
	}

	function _exportList($list){
		if(is_object($list)){
			for($list->rewind(); $list->valid(); $list->next()){
				$list->set($list->key(), $this->_exportRow($list->current()));
			}
			$list->rewind();
			return $list;
		}
	}


}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/uniseminars/models/class.tx_uniseminars_models_seminars.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/uniseminars/models/class.tx_uniseminars_models_seminars.php']);
}
?>
