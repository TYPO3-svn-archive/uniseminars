<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class.tx_uniseminars_models_guests
 *
 * @author Sven
 */
class tx_uniseminars_models_guests extends tx_lib_object {

	var $insertFields = array('courseid','firstname','lastname','email','subject','type','semester','year');

    /*
     * Constructor
     */
	function tx_uniseminars_models_guests() {
		parent::tx_lib_object();
	}

    /**
	 * Save Guest-Data
	 */
	function saveGuest($para){
    $dataObj = $_SESSION[$para];
		$dataArray = $dataObj->getArrayCopy();
		foreach($dataArray as $key=>$value){
			if(in_array($key, $this->insertFields)){
				$insertArray[$key] = htmlspecialchars($value);
			}
		}
		$insertArray['pid'] = $this->controller->configurations->get('guestFolder');
		$insertArray['tstamp'] = time();
		//t3lib_div::debug($insertArray,'saveOffer');
		$this->insertGuest($insertArray);
        return true;
	}

	/*
	 * Insert a new Guest into the DB
	 *
	 * @param array	The Data-Array
	 */
	function insertGuest($insertArray){
		$insertArray['crdate'] = time();
		$insertArray['deleted'] = 0;
		$insertArray['hidden'] = 0;
		$insertArray['cruser_id'] = $GLOBALS["TSFE"]->fe_user->user["uid"];
		//t3lib_div::debug($insertArray,'insertGuest');
		$GLOBALS['TYPO3_DB']->exec_INSERTquery('tx_uniseminars_guests', $insertArray);
		if($GLOBALS['TYPO3_DB']->sql_error() != ''){
			t3lib_div::debug('Your registration could NOT be saved!','insertGuest');
		}
	}

    /**
	 * Output-Manipulation
	 */
	function _exportRow($row){
		if(is_object($row)){
			//Insert Output-Manipulation
			//*** coursetype ***

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
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/uniseminars/models/class.tx_uniseminars_models_guests.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/uniseminars/models/class.tx_uniseminars_models_guests.php']);
}
?>
