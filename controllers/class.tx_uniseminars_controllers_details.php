<?php

/**
 * A most minimalistic controller of the lib/div type
 *
 * This is just a hello world example.
 * For a minimal practical example see the extension Bananas (bananas).
 * For a bigger practical example see the extension Elmar's FAQ (efaq).
 */ 
class tx_uniseminars_controllers_details extends tx_lib_controller{

	var $defaultAction = 'showAction';

	function showAction() {
		//----------------------------------------------------------------------
		// IMPORTANT: Always set the controller ($this) to controlled objects!!!
		//            Please have a look at the constructor of tx_lib_object.
		//----------------------------------------------------------------------
		$modelClassName = tx_div::makeInstanceClassName('tx_uniseminars_models_seminars');
		$viewClassName = tx_div::makeInstanceClassName('tx_uniseminars_views_seminar');
		$translatorClassName = tx_div::makeInstanceClassName('tx_lib_translator');
		$model = $this->makeInstance('tx_uniseminars_models_seminars',$this);
		$model->controller($this);
		$model->loadSeminarByUid((int) $this->parameters->get('course'));
		$view = new $viewClassName($model->current());
		$view->controller($this);

		$view->render($this->configurations->get('courseDetailTemplate'));
		$translator = new $translatorClassName($view);
		$translator->setPathToLanguageFile($this->configurations->get('pathToLanguageFile'));
		return $translator->translateContent();
	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/uniseminars/controllers/class.tx_uniseminars_controllers_details.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/uniseminars/controllers/class.tx_uniseminars_controllers_details.php']);
}
?>
