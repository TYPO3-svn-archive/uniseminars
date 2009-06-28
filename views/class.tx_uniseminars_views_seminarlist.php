<?php

/**
 * A most minimalistic view of the lib/div type
 *
 * This is just a hello world example.
 * For a minimal practical example see the extension Bananas (bananas).
 * For a bigger practical example see the extension Elmar's FAQ (efaq).
 */ 
class tx_uniseminars_views_seminarlist extends tx_lib_phpTemplateEngine {
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/uniseminars/views/class.tx_uniseminars_views_seminarlist.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/uniseminars/views/class.tx_uniseminars_views_seminarlist.php']);
}
?>
