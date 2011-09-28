<?php use_stylesheet('/fpErrorNotifierPlugin/css/list.css') ?>

<span class="acknowledged" title="<?php echo $fp_error->is_archived ? 'Archived' : 'Not archived' ?>"><?php echo $fp_error->is_archived ? '+' : '-' ?></span>
<span class="date"><?php echo time_ago_in_words(strtotime($fp_error->created_at)) ?> ago</span>
<span class="id"><a href="<?php echo url_for('fp_error_show', $fp_error) ?>">#<?php echo $fp_error->id ?></a></span>
<span class="class"><?php echo $fp_error->exception_class ?></span>
<span class="message"><a href="<?php echo url_for('fp_error_show', $fp_error) ?>"><?php echo $fp_error->exception_message ?></a></span><br />
<?php if($fp_error->user_authenticated){ ?>
	<?php echo $fp_error->user_name ?>(<?php echo $fp_error->user_id ?>)
<?php }else{ ?>
	Not authenticated
<?php } ?>
<span class="environment">Environment: <?php echo $fp_error->environment ?></span>
<span class="module">Module: <?php echo $fp_error->module ?></span>
<span class="action">Action: <?php echo $fp_error->action ?></span><br />
<span class="uri"><a href="<?php echo $fp_error->uri ?>"><?php echo $fp_error->uri ?></a></span>
<span class="file"><?php echo $fp_error->file ?></span>
<span class="line"><?php echo $fp_error->line ?></span>
