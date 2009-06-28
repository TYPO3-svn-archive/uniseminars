<?php //t3lib_div::debug($this,'template'); ?>

<table width="100%"  border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#EEEEEE">
	<tr valign="top">
		<td colspan="3">
			<span class="courses">Course title</span><br>
			<h2 class="coursesTitle"><?php $this->printAsText('title'); ?></h2>
		</td>
		<td width="15%" align="center" valign="middle">
			<?php $this->printAsText('semestertext'); ?> <?php $this->printAsText('year'); ?>
			<?php $this->printClosedIcon(); ?>
		</td>
	</tr>
	<tr valign="top">
		<td width="25%">
			<span class="courses">Type of course</span><br>
			<?php $this->printAsText('coursetypetext'); ?>
		</td>
		<td colspan="2" width="25%">
			<span class="courses">Lecturer</span><br>
			<?php $this->printAsText('lecturer'); ?>
		</td>
		<td width="15%">
			<span class="courses">Credits allocated</span><br>
			<?php $this->printAsFloat('credits'); ?>
		</td>
	</tr>
	<tr valign="top">
		<td colspan="4">
			<span class="courses">Objective</span><br>
			<?php $this->printAsRte('objective'); ?>
		</td>
	</tr>
	<tr valign="top">
		<td colspan="4">
			<span class="courses">Learning targets</span><br>
			<?php $this->printAsRte('targets'); ?>
		</td>
	</tr>
	<tr valign="top">
		<td colspan="4">
			<span class="courses">Prerequisites</span><br>
			<?php $this->printAsRte('prerequisites'); ?>
		</td>
	</tr>
	<tr valign="top">
		<td colspan="4">
			<span class="courses">Suggested reading</span><br>
			<?php $this->printAsRte('reading'); ?>
		</td>
	</tr>
	<tr valign="top">
		<td colspan="3">
			<span class="courses">Day, time &amp; location</span><br>
			<?php $this->printAsText('datelocation'); ?>
		</td>
		<td>
			<span class="courses">Start</span><br>
			<?php if($this->get('start') > 0): ?>
				<?php $this->printAsDate('start','%b %d, %Y'); ?>
			<?php else: ?>
				<?php print 'tba'; ?>
			<?php endif; ?>
		</td>
	</tr>
	<tr valign="top">
		<td>
			<span class="courses">Assessment &amp; grading</span><br>
			<?php $this->printAsText('grading'); ?>
		</td>
		<td colspan="3">
			<span class="courses">Exam date &amp; location</span><br>
			<?php $this->printAsText('examdate'); ?>
		</td>
	</tr>
	<tr valign="top">
		<td colspan="4">
			<span class="courses">Course Co-ordinator</span><br>
			<?php $this->printAsText('contact'); ?><br>
			<?php if($this->has('email')): ?>
				<?php $this->printAsEmail('email'); ?>
			<?php endif; ?>
		</td>
	</tr>
</table>
