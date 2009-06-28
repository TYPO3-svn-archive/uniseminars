<?php

/**
 * A most minimalistic view of the lib/div type
 *
 * This is just a hello world example.
 * For a minimal practical example see the extension Bananas (bananas).
 * For a bigger practical example see the extension Elmar's FAQ (efaq).
 */
class tx_uniseminars_views_seminar extends tx_lib_phpTemplateEngine {

    /*
     *  Print the Link to the Detail-Page
     */
	function printDetailLink(){
		$link = tx_div::makeInstance('tx_lib_link');
		$link->label($this->get('title'));
		$link->destination($this->controller->configurations->get('detailPageID'));
		$link->designator($this->getDesignator());
		$link->noHash();
		$link->parameters(array('course' => $this->get('uid'), 'action' => 'show', 'backId' => $this->getDestination()));
		print $link->makeTag();
	}

	/*
	 * Print the Registration-Image
	 */
	function printClosedIcon(){
		$_img = 'lock-'.$this->get('closed').'.gif';
		//t3lib_div::debug($_img,'printClosedIcon');
		$_langSwitch = '%%%closed.I.'.$this->get('closed').'%%%';
		//t3lib_div::debug($_langSwitch,'printClosedIcon');
		$imageClassName = tx_div::makeInstanceClassName('tx_lib_image');
		$image = new $imageClassName();
		$image->alt($_langSwitch);
		$image->width(16);
		$image->path($this->controller->configurations->get('pathToIcons').$_img);
		//$image->path('fileadmin/img/'.$_img);
		//t3lib_div::debug($this->controller->configurations->get('pathToIcons'),'printClosedIcon');
		if($this->get('closed') == '0'){
			$img = $image->make();
	        $link = tx_div::makeInstance('tx_lib_link');
			$link->label($img,true);
			$link->destination($this->controller->configurations->get('registerPID'));
			$link->designator($this->getDesignator());
			$link->noHash();
			$link->parameters(array('courseid' => $this->get('uid'), 'year' => $this->get('year'), 'semester' => $this->get('semester'),));
			print $link->makeTag();
		}else{
			print $image->make();
		}
	}

	/*
	 * Print the Link back to the List-View
	 */
	function printBackLink(){
		$link = tx_div::makeInstance('tx_lib_link');
		$link->label('%%%backToList%%%');
		$link->destination((int) $this->controller->parameters->get('backId'));
		$link->designator($this->getDesignator());
		$link->noHash();
		$link->parameters(array('action' => 'list'));
		print $link->makeTag();
	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/uniseminars/views/class.tx_uniseminars_views_seminar.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/uniseminars/views/class.tx_uniseminars_views_seminar.php']);
}
?>
