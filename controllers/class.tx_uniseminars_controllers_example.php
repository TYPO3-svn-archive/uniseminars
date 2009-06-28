<?php

/**
 * A most minimalistic controller of the lib/div type
 *
 * This is just a hello world example.
 * For a minimal practical example see the extension Bananas (bananas).
 * For a bigger practical example see the extension Elmar's FAQ (efaq).
 */ 
class tx_uniseminars_controllers_example extends tx_lib_controller{

	var $defaultAction = 'exampleAction';

	function exampleAction() {
		//----------------------------------------------------------------------
		// IMPORTANT: Always set the controller ($this) to controlled objects!!!
		//            Please have a look at the constructor of tx_lib_object.
		//----------------------------------------------------------------------
		$modelClassName = tx_div::makeInstanceClassName('tx_uniseminars_models_seminars');
		$entryClassName = tx_div::makeInstanceClassName('tx_uniseminars_views_seminar');
		$listClassName = tx_div::makeInstanceClassName('tx_uniseminars_views_seminarlist');
		$translatorClassName = tx_div::makeInstanceClassName('tx_lib_translator');
		$model = $this->makeInstance('tx_uniseminars_models_seminars',$this);
		$model->controller($this);
		$model->loadSeminarList();
		$view = new $listClassName($this);
		$view->controller($this);
		for($model->rewind(); $model->valid(); $model->next()) {
			$entry = new $entryClassName($model->current());
			$entry->controller($this);
			$view->append($entry);
		}
		$view->render($this->configurations->get('courseListTemplate'));
		$translator = new $translatorClassName($view);
		$translator->setPathToLanguageFile($this->configurations->get('pathToLanguageFile'));
		return $translator->translateContent();
	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/uniseminars/controllers/class.tx_uniseminars_controllers_example.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/uniseminars/controllers/class.tx_uniseminars_controllers_example.php']);
}
?>
