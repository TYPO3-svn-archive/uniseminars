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
<?php $form = $this->form; ?>
<h5><?php $this->printSemester(); ?></h5>
<h2><?php $this->printSeminarTitle(); ?></h2>
<?php
    if($this->get('type') != 0){
		$stdwert = 'checked';
	}

	if($this->get('_errorCount') > 0){
		$errorList = $this->get('_errorList');
		print '<h3 class="error">%%%error%%%:</h3>';
		foreach($errorList as $key=>$error){
			print '<p class="error">'.$error['message'].'</p>';
		}
	}
 ?>

<?php $form->printBegin('uniseminarsRegisterForm'); ?>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
	<td><?php $form->printLabel('type', NULL, '%%%iam%%%:'); ?></td>
	<td>
		<?php $form->printRadio('type2', array('name' => 'type', 'value' => '0' )); ?>%%%trainingcenter%%% <br />
        <?php $form->printRadio('type1', array('name' => 'type', 'value' => '1', 'checked' => $stdwert)); ?>%%%guest%%%
    </td>
  </tr>
  <tr>
	<td><?php $form->printLabel('firstname', NULL, '%%%firstname%%%:'); ?></td>
	<td><?php $form->printInput('firstname', array('size'=>'30')); ?></td>
  </tr>
  <tr>
	<td class="kurz"><?php $form->printLabel('lastname', NULL, '%%%lastname%%%:'); ?></td>
	<td><?php $form->printInput('lastname', array('size'=>'30')); ?></td>
  </tr>
  <tr>
	<td class="kurz"><?php $form->printLabel('email', NULL, '%%%email%%%:'); ?></td>
	<td><?php $form->printInput('email', array('size'=>'30')); ?></td>
  </tr>
  <tr>
	<td class="kurz"><?php $form->printLabel('subject', NULL, '%%%subject%%%:'); ?></td>
	<td><?php $form->printInput('subject', array('size'=>'30')); ?></td>
  </tr>

  <tr>
	<td>&nbsp;</td>
	<td>
        <?php $form->printHidden('courseid', array('value'=>$this->controller->parameters->get('courseid'))); ?>
        <?php $form->printHidden('semester', array('value'=>$this->controller->parameters->get('semester'))); ?>
        <?php $form->printHidden('year', array('value'=>$this->controller->parameters->get('year'))); ?>
		<input type="submit" value="%%%preview%%%" name="uniseminars[action][preview]" />
		<?php
		//<input type="submit" value="%%%save%%%" name="uniseminars[action][insert]" />
		?>
		<input type="submit" value="%%%clear%%%" name="uniseminars[action][clear]" />
	</td>
  </tr>
</table>
<?php $form->printEnd(); ?>

