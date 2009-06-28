<?php if (!defined ('TYPO3_MODE')) 	die ('Access denied.'); ?>
<?php
/*******************************************************************************************
 *  Copyright notice
 *
 *  (c) 2009 Sven Kalbhenn
 *  Contact: sven@skom.de
 *  All rights reserved
 *
 *  If you ar not familiar with php-Templates, you can find a documentation here:
 *  http://typo3.org/documentation/document-library/extension-manuals/lib/0.0.20/view/1/5/
 *******************************************************************************************/
 ?>

<form method="post" action="<?php print $this->form->action(); ?>">
<table width="100%" border="0" cellspacing="2" cellpadding="2">

  <tr>
	<td class="kurz">&nbsp;</td>
	<td>
		<?php print $this->getCaptchaQuestion(); ?><br />
		<?php print $this->getCaptchaInput('uniseminars_captcha'); ?>
	</td>
  </tr>
  <tr>
	<td class="kurz">&nbsp;</td>
	<td>
		<input type="submit" value="%%%save%%%" name="uniseminars[action][insert]" />
		<input type="submit" value="%%%edit%%%" name="uniseminars[action][alter]" />
	</td>
  </tr>
</table>


</form>
