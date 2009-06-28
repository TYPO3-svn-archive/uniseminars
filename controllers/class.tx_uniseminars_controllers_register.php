<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2007 Sven Kalbhenn
 *  Contact: sven@skom.de
 *  All rights reserved
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 ***************************************************************/

/**
 * This is the controller for the registration-process
 *
 */
class tx_uniseminars_controllers_register extends tx_lib_controller{

	var $defaultAction = 'registerAction';

	public function registerAction() {
		return $this->display('formTemplate');
	}

    public function clearAction() {
        return $this->display('formTemplate');
    }

	protected function display($template, $object = null) {
        // $object contains the data, if any.
		// finding classnames
		$formClassName = tx_div::makeInstanceClassName('tx_lib_phpFormEngine');
		$viewClassName = tx_div::makeInstanceClassName('tx_uniseminars_views_register');
		$translatorClassName = tx_div::makeInstanceClassName('tx_lib_translator');

		// process
		$view = new $viewClassName($this, $object);
		$view->storeToSession($this->getClassName()); // !!!! Store the data into the session. Again the classname is a possible ID. !!!!!!

		$view->form = new $formClassName($this, $object);
		$view->render($this->configurations[$template]);
		$translator = new $translatorClassName($this, $view);
		return $translator->translateContent();
	}

	public function captchaAction() {
		// finding classnames
		$captchaClassName = tx_div::makeInstanceClassName('tx_lib_captcha');

		// process
		$validator = $this->getValidator(); // The data come in as form parameters upon the first call ...
		if(!$validator->ok()) { // If the data is not valid:
			return $this->display('formTemplate', $validator); // Redisplay the form to correct input.
		} else { // If the data is valid:
			$captcha = new $captchaClassName($this, $validator); //The data goes in the captcha. Next a test is prepared.
			$captcha->createTest($this->getClassName()); // !!! We use classname as ID, could be something else that's unique enough.
			return $this->display('captchaTemplate', $captcha); // Now the data migrates to display.
		}
	}

    protected function getValidator() {
		// finding classnames
		$validatorClassName = tx_div::makeInstanceClassName('tx_lib_validator');

		// process
		$validator = new $validatorClassName($this);
		$validator->loadFromSession($this->getClassName());
		$validator->overwriteArray($this->parameters);
		$validator->useRules('validationRules.');
		$validator->validate();
		return $validator;
	}

	public function previewAction() {
		$validator = $this->getValidator(); // Here the data come also in as form parameters.
		if(!$validator->ok()) {
			return $this->display('formTemplate',$validator);
		} else {
			return $this->display('previewTemplate', $validator);
		}
	}

	public function alterAction() {
		$validator = $this->getValidator(); // The data is loaded from the session this call.
		return $this->display('formTemplate',$validator);
	}

	public function editAction(){
		return $this->display('formTemplate');
	}

	public function insertAction() {  // Check captche result first.
		// finding classnames
		//$captchaClassName = tx_div::makeInstanceClassName('tx_lib_captcha');
		$validatorClassName = tx_div::makeInstanceClassName('tx_lib_validator');
		$modelClassName = tx_div::makeInstanceClassName('tx_uniseminars_models_guests');
		$linkClassName = tx_div::makeInstanceClassName('tx_lib_link');

		// Captcha
		// Insert Action "captcha" in forms action as well
		/*$captcha = new $captchaClassName($this); // Get the result from the captcha test.
		if(!$captcha->ok($this->getClassName())) {  // !!! Same ID as in captchaAction. !!!
			return $this->captchaAction(); // Ask another question and another question and ...
		} else { // Captcha test passed:
		*/
			// process
			// Paranoid? Insert a last validity check here.
			$validator = $this->getValidator(); // Load the data from the session.
			//t3lib_div::debug($validator,'insertAction');
			$model = new $modelClassName($this, $validator);
			$model->controller($this);
			//t3lib_div::debug($this->parameters,'insertAction');
            //$model->saveOffer($this->getClassName());
			$model->saveGuest($this->getClassName()); // Finally store it.

			// Redirect. Always a good idea to prevent double entries by reload.
			$link = new $linkClassName();
			$link->destination($this->getDestination());
			$link->destination($this->configurations['redirectRegisterPID']);
			$link->designator($this->getDesignator());
			$link->noHash();
			$link->redirect();

		//}
	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/uniseminars/controllers/class.tx_uniseminars_controllers_register.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/uniseminars/controllers/class.tx_uniseminars_controllers_register.php']);
}
?>
