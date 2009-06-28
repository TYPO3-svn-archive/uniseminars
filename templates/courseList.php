<?php //t3lib_div::debug($this,'template'); ?>

<table width="100%"  border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#EEEEEE">
	<tr valign="top">
		<td class="courses"><strong>Course title</strong><br>Day, time &amp; location</td>
		<td class="courses"><strong>Lecturer</strong><br>Type of course</td>
		<td class="courses">Guests</td>
	</tr>
<?php for($this->rewind(); $this->valid(); $this->next()): $entry = $this->current();	?>
	<tr valign="top">
		<td>
			<h2 class="coursesTitle"><?php $entry->printDetailLink(); ?></h2>
			<p><?php $entry->printAsText('datelocation'); ?></p>
		</td>
		<td>
			<strong><?php $entry->printAsText('lecturer'); ?></strong><br>
			<?php $entry->printAsText('coursetypetext'); ?>
		</td>
		<td align="center" valign="middle" class="courses">
			<?php $entry->printClosedIcon(); ?>
		</td>
	</tr>
<?php endfor; ?>
</table>


