<style>
dd, dt{
	height: 12px;
}
</style>

<h1>#<?php echo $error->id ?> <?php echo $error->exception_class ?></h1>
<span class="message"><?php echo $error->exception_message ?></span>

<dl>
	<dt>Archived</dt>
	<dd><?php echo $error->is_archived ? 'Archived' : 'Not archived' ?></dd>

	<dt>Similar</dt>
	<dd>
		<form method="post" action="<?php echo url_for('fp_error_collection', array('action' => 'filter')) ?>">
			<?php echo $count_similar ?>
			<input type="hidden" name ="fp_error_filters[exception_class][text]" value="<?php echo $error->exception_class ?>" />
			<input type="hidden" name ="fp_error_filters[file][text]" value="<?php echo $error->file ?>" />
			<input type="hidden" name ="fp_error_filters[line][text]" value="<?php echo $error->line ?>" />
			<?php $csrf_form = new fpErrorFormFilter()?>
			<?php if($csrf_form->isCSRFProtected()){ ?>
				<input type="hidden" name ="fp_error_filters[<?php echo $csrf_form->getCSRFFieldName() ?>]" value="<?php echo $csrf_form->getCSRFToken() ?>" />
			<?php } ?>
			<input type="submit" value="view" />
		</form>
	</dd>

	<dt>Date</dt>
	<dd><?php echo format_datetime($error->created_at, 'EEEE yyyy-MM-dd HH:mm:ss z') ?> or <?php echo time_ago_in_words(strtotime($error->created_at)) ?> ago</dd>

	<dt>User</dt>
	<dd>
		<?php if($error->user_authenticated){ ?>
			<?php echo $error->user_name ?> (<?php echo $error->user_id ?>)
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
