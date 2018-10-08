<?php
/**
* The primary view for replacing media files
* @see ReplaceMedia\Media\ReplacementView
*/
?>
<div class="wrap">
	<h1><?php _e('Replace Media', 'replace-media'); ?></h1>
	<?php if ( !$this->validator->hasFile() && !isset($_GET['replace_error']) && !isset($_GET['success']) ) : ?>
		<div id="message" class="updated notice notice-error"><p><?php _e('A file has not been provided for replacement.', 'replace-media'); ?></p></div>
		<p><a href="<?php echo admin_url('upload.php'); ?>"><?php _e('Back to Media Library', 'replace-media'); ?></a></p>
	<?php elseif ( isset($_GET['success']) ) : ?>
		<div id="message" class="updated notice notice-success"><p><?php _e('The file was successfully replaced.', 'replace-media'); ?> <a href="<?php echo admin_url('upload.php'); ?>"><?php _e('Back to the media library.', 'replace-media'); ?></a></p></div>
	<?php else :
		$original_attachment_id = intval($_GET['attachment_id']);
		$type = $this->attributes->fileType($original_attachment_id);
		?>
		<form action="<?php echo admin_url('admin-post.php'); ?>" enctype="multipart/form-data" method="post" class="replace-media-form">
			<input type="hidden" name="action" value="replace_media">
			<input type="hidden" name="original_attachment_id" value="<?php echo $original_attachment_id; ?>">
			<div class="warning-message">
				<h3><?php _e('Important', 'replace-media'); ?></h3>
				<p><?php _e('This action will completely remove the old file from the system and replace it with the uploaded file. This is not reversible. Please ensure that a backup has been made before proceeding.', 'replace-media'); ?></p>
			</div>
			<?php if ( isset($_GET['replace_error']) ) : ?>
			<div class="form-error">
				<?php echo $this->validator->getError($_GET['replace_error']); ?>
			</div>
			<?php endif; ?>
			<div class="file-input">
				<p class="instructions"><?php echo __('The uploaded file type must match the file to be replaced', 'replace-media') . ' (' . strtoupper($type[1]) . ')'; ?></p>
				<input type="file" name="file">
			</div>
			<p><button class="button button-primary"><?php echo __('Replace', 'replace-media') . ' ' . $type[0]; ?></button></p>
		</form>
	<?php endif; // ?>
</div><!-- .wrap -->