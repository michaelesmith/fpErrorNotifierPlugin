<style>
dd, dt{
	height: 12px;
}
dl{
	padding-bottom: 10px;
}
</style>

<h1>#<?php echo $error->id ?> <?php echo $error->exception_class ?></h1>
<span class="message"><?php echo $error->exception_message ?></span>

<dl>
	<dt>Archived</dt>
	<dd>
		<?php if($error->is_archived){ ?>
			Archived
		<?php }else{ ?>
			Not archived
			<a href="<?php echo url_for('fp_error_object', array('sf_subject' => $error, 'action' => 'ListArchive')) ?>">Archive Now</a>
		<?php } ?>
	</dd>

	<dt>Similar</dt>
	<dd>
		<form method="post" action="<?php echo url_for('fp_error_collection', array('action' => 'filter')) ?>">
			<?php echo $count_similar ?> + <?php echo $count_similar_archived ?> archived
			<input type="hidden" name="fp_error_filters[exception_class][text]" value="<?php echo $error->exception_class ?>" />
			<input type="hidden" name="fp_error_filters[file][text]" value="<?php echo $error->file ?>" />
			<input type="hidden" name="fp_error_filters[line][text]" value="<?php echo $error->line ?>" />
			<?php $csrf_form = new fpErrorFormFilter()?>
			<?php if($csrf_form->isCSRFProtected()){ ?>
				<input type="hidden" name ="fp_error_filters[<?php echo $csrf_form->getCSRFFieldName() ?>]" value="<?php echo $csrf_form->getCSRFToken() ?>" />
			<?php } ?>
			<input type="submit" value="view" />
		</form>
	</dd>

	<dt>Identical</dt>
	<dd>
		<form method="post" action="<?php echo url_for('fp_error_collection', array('action' => 'filter')) ?>">
			<?php echo $count_identical ?> + <?php echo $count_identical_archived ?> archived
			<input type="hidden" name="fp_error_filters[exception_class][text]" value="<?php echo $error->exception_class ?>" />
			<input type="hidden" name="fp_error_filters[file][text]" value="<?php echo $error->file ?>" />
			<input type="hidden" name="fp_error_filters[line][text]" value="<?php echo $error->line ?>" />
			<input type="hidden" name="fp_error_filters[exception_message][text]" value="<?php echo $error->exception_message ?>" />
			<?php $csrf_form = new fpErrorFormFilter()?>
			<?php if($csrf_form->isCSRFProtected()){ ?>
				<input type="hidden" name ="fp_error_filters[<?php echo $csrf_form->getCSRFFieldName() ?>]" value="<?php echo $csrf_form->getCSRFToken() ?>" />
			<?php } ?>
			<input type="submit" value="view" />
			<?php if($count_identical){ ?>
				<a href="<?php echo url_for('fp_error_object', array('sf_subject' => $error, 'action' => 'archiveIdentical')) ?>">Archive Now</a>
			<?php } ?>
		</form>
	</dd>

	<dt>Date</dt>
	<dd>
		<form method="post" action="<?php echo url_for('fp_error_collection', array('action' => 'filter')) ?>">
			<?php echo format_datetime($error->created_at, 'EEEE yyyy-MM-dd HH:mm:ss z') ?> or <?php echo time_ago_in_words($to_ts = strtotime($error->created_at)) ?> ago
			<?php $from_ts = $to_ts ?>
			<input type="hidden" name="fp_error_filters[created_at][from][month]" value="<?php echo date('n', $from_ts) ?>" />
			<input type="hidden" name="fp_error_filters[created_at][from][day]" value="<?php echo date('j', $from_ts) ?>" />
			<input type="hidden" name="fp_error_filters[created_at][from][year]" value="<?php echo date('Y', $from_ts) ?>" />
			<input type="hidden" name="fp_error_filters[created_at][to][month]" value="<?php echo date('n', $to_ts) ?>" />
			<input type="hidden" name="fp_error_filters[created_at][to][day]" value="<?php echo date('j', $to_ts) ?>" />
			<input type="hidden" name="fp_error_filters[created_at][to][year]" value="<?php echo date('Y', $to_ts) ?>" />
			<?php $csrf_form = new fpErrorFormFilter()?>
			<?php if($csrf_form->isCSRFProtected()){ ?>
				<input type="hidden" name ="fp_error_filters[<?php echo $csrf_form->getCSRFFieldName() ?>]" value="<?php echo $csrf_form->getCSRFToken() ?>" />
			<?php } ?>
			<input type="submit" value="this day" />
		</form>
	</dd>

	<dt>User</dt>
	<dd>
		<?php if($error->user_authenticated){ ?>
			<form method="post" action="<?php echo url_for('fp_error_collection', array('action' => 'filter')) ?>">
				<?php echo $error->user_name ?> (id: <?php echo $error->user_id ?>)
				<input type="hidden" name="fp_error_filters[user_name][text]" value="<?php echo $error->user_name ?>" />
				<?php $csrf_form = new fpErrorFormFilter()?>
				<?php if($csrf_form->isCSRFProtected()){ ?>
					<input type="hidden" name ="fp_error_filters[<?php echo $csrf_form->getCSRFFieldName() ?>]" value="<?php echo $csrf_form->getCSRFToken() ?>" />
				<?php } ?>
				<input type="submit" value="other by user" />
			</form>
		<?php }else{ ?>
			Not authenticated
		<?php } ?>
	</dd>

	<dt>Environment</dt>
	<dd><?php echo $error->environment ?></dd>

	<dt>Module</dt>
	<dd><?php echo $error->module ?></dd>

	<dt>Action</dt>
	<dd><?php echo $error->action ?></dd>

	<dt>Uri</dt>
	<dd><a href="<?php echo $error->uri ?>"><?php echo $error->uri ?></a></dd>

	<dt>Referer</dt>
	<dd><a href="<?php echo $error->referer ?>"><?php echo $error->referer ?></a></dd>

	<dt>File</dt>
	<dd><?php echo $error->file ?></dd>

	<dt>Line</dt>
	<dd><?php echo $error->line ?></dd>

	<dt>Exception Code</dt>
	<dd><?php echo $error->exception_code ?></dd>

	<dt>Exception Severity</dt>
	<dd><?php echo $error->exception_severity ?></dd>
</dl>

<div class="clear"></div>

<div>
	<h3>Trace</h3>
	<div>
		<pre><?php echo $error->trace ?></pre>
	</div>
</div>

<div>
	<h3>Session</h3>
	<div>
		<pre><?php echo $error->session ?></pre>
	</div>
</div>

<div>
	<h3>Server</h3>
	<div>
		<pre><?php echo $error->server ?></pre>
	</div>
</div>
