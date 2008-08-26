<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2008 Sven Kalbhenn <sven@skom.de>
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
 * Class that implements the model for table tx_uniseminars_courses.
 *
 * Get the courses-data from the DB
 *
 *
 * @author	Sven Kalbhenn <sven@skom.de>
 * @package	TYPO3
 * @subpackage	tx_uniseminars
 */

class tx_uniseminars_model_courses extends tx_lib_object {

        function tx_uniseminars_model_courses($controller = null, $parameter = null) {
                parent::tx_lib_object($controller, $parameter);
        }

        function load($parameters = null) {

                // fix settings
                $fields = '*';
                $tables = 'tx_uniseminars_courses';
                $groupBy = null;
                $orderBy = 'sorting';
                $where = 'hidden = 0 AND deleted = 0 ';

                // variable settings
                if($parameters) {
					// do query modifications according to incoming parameters here.
                }

                // query
                $result = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $tables, $where, $groupBy, $orderBy);
                if($result) {
                        while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($result)) {
                                $entry = new tx_lib_object($row);
                                $this->append($entry);
                        }
                }
        }
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/uniseminars/models/class.tx_uniseminars_model_courses.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/uniseminars/models/class.tx_uniseminars_model_courses.php']);
}

?>