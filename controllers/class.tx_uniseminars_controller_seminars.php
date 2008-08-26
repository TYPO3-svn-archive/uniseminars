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
 * Class that implements the controller "seminars" for tx_uniseminars.
 *
 * Provides the seminar-data
 *
 *
 * @author	Sven Kalbhenn <sven@skom.de>
 * @package	TYPO3
 * @subpackage	tx_uniseminars
 */

tx_div::load('tx_lib_controller');

class tx_uniseminars_controller_seminars extends tx_lib_controller {

	var $targetControllers = array();

    function tx_uniseminars_controller_seminars($parameter1 = null, $parameter2 = null) {
        parent::tx_lib_controller($parameter1, $parameter2);
        $this->setDefaultDesignator('tx_uniseminars');
    }


	/**
	 * Implementation of showSeminarListAction()
	 */
    function showSeminarListAction() {
        $modelClassName = tx_div::makeInstanceClassName('tx_uniseminars_model_courses');
        $viewClassName = tx_div::makeInstanceClassName('tx_uniseminars_view_seminar');
        $entryClassName = tx_div::makeInstanceClassName($this->configurations->get('entryClassName'));
		$translatorClassName = tx_div::makeInstanceClassName('tx_lib_translator');
        $view = new $viewClassName($this);
        $model = new $modelClassName($this);
        $model->load($this->parameters);
        for($model->rewind(); $model->valid(); $model->next()) {
            $entry = new $entryClassName($model->current(), $this);
            $view->append($entry);
        }
        $view->setPathToTemplateDirectory($this->configurations->get('templatePath'));
        $view->render('seminarList');
		$translator = new $translatorClassName($this, $view);
		$out = $translator->translateContent();
        return $out;
    }

	/**
	 * Implementation of showSeminarDetailAction()
	 */
    function showSeminarDetailAction() {
        $modelClassName = tx_div::makeInstanceClassName('tx_uniseminars_model_courses');
        $viewClassName = tx_div::makeInstanceClassName('tx_uniseminars_view_seminar');
        $entryClassName = tx_div::makeInstanceClassName($this->configurations->get('entryClassName'));
		$translatorClassName = tx_div::makeInstanceClassName('tx_lib_translator');
        $view = new $viewClassName($this);
        $model = new $modelClassName($this);
        $model->load($this->parameters);
        for($model->rewind(); $model->valid(); $model->next()) {
            $entry = new $entryClassName($model->current(), $this);
            $view->append($entry);
        }
        $view->setPathToTemplateDirectory($this->configurations->get('templatePath'));
        $view->render('seminarDetail');
		$translator = new $translatorClassName($this, $view);
		$out = $translator->translateContent();
        return $out;
    }
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/uniseminars/controllers/class.tx_uniseminars_controller_seminars.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/uniseminars/controllers/class.tx_uniseminars_controller_seminars.php']);
}

?>