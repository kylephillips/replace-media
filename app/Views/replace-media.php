<?php
/**
* The primary view for replacing media files
* @see ReplaceMedia\Media\ReplacementView
*/
?>
<?php if ( !isset($in_modal) ) : ?>
<div class="wrap">
	<h1><?php _e('Replace Media', 'replace-media'); ?></h1>
	<?php endif; ?>

	<?php if ( isset($in_modal) ) echo '<div class="replace-media-modal-form">'; ?>

	<?php if ( !$this->validator->hasFile() && !isset($_GET['replace_error']) && !isset($_GET['success']) ) : ?>
		<div id="message" class="updated notice notice-error"><p><?php _e('A file has not been provided for replacement.', 'replace-media'); ?></p></div>
		<p><a href="<?php echo admin_url('upload.php'); ?>"><?php _e('Back to Media Library', 'replace-media'); ?></a></p>
	<?php elseif ( isset($_GET['success']) ) : ?>
		<div id="message" class="updated notice notice-success"><p><?php _e('The file was successfully replaced.', 'replace-media'); ?> <a href="<?php echo admin_url('upload.php'); ?>"><?php _e('Back to the media library.', 'replace-media'); ?></a></p></div>
	<?php else :
		$original_attachment_id = intval($_GET['attachment_id']);
		$type = $this->attributes->fileType($original_attachment_id);
		?>
		<form action="<?php echo admin_url('admin-post.php'); ?>" enctype="multipart/form-data" method="post" class="replace-media-form" <?php if ( isset($in_modal) ) echo 'data-replace-media-form'; ?>>
			
			<?php if ( !isset($in_modal) ) : ?>
			<input type="hidden" name="action" value="replace_media">
			<?php else : ?>
			<input type="hidden" name="action" value="replace_media_modal_form">
			<?php endif; ?>

			<input type="hidden" name="original_attachment_id" value="<?php echo $original_attachment_id; ?>">
			<div class="warning-message">
				<h3><?php _e('Important', 'replace-media'); ?></h3>
				<p><?php _e('This action will completely remove the old file from the system and replace it with the uploaded file. This is not reversible. Please ensure that a backup has been made before proceeding.', 'replace-media'); ?></p>
				<p class="instructions"><em><?php echo __('The uploaded file type must match the file to be replaced', 'replace-media') . ' (' . strtoupper($type[1]) . ')'; ?></em></p>
			</div>

			<div class="file-input">
				<p class="file-title"><strong><?php _e('Replacing:', 'replace-media'); ?></strong> <?php echo $this->attributes->fileName($original_attachment_id); ?> (<a href="<?php echo $this->attributes->fileLink($original_attachment_id); ?>" target="_blank" data-replace-media-link><?php _e('View', 'replace-media'); ?></a>)</p>

				<?php if ( isset($_GET['replace_error']) ) : ?>
				<div class="form-error">
					<?php echo $this->validator->getError($_GET['replace_error']); ?>
				</div>
				<?php endif; ?>

				<?php if ( isset($in_modal) ) : ?>
				<div class="form-success" data-replace-media-form-success style="display:none;"><?php _e('Attachment successfully replaced.', 'replace-media'); ?></div>
				<div class="form-error" data-replace-media-form-error style="display:none;"></div>
				<?php endif; ?>

				<div class="file-field">
					<input type="file" name="file">
				</div>

				<div class="rename">
					<p><label><input type="checkbox" name="no_rename" value="1" /><?php _e('Do not rename uploaded file', 'replace-media'); ?></label></p>
					<p class="description"><?php _e('If this option is selected, all instances of the link will be updated with the new file name. A redirect will be saved for inbound links to point to the new file.', 'replace-media'); ?></p>
				</div>
			</div>

			<div class="submit-buttons">
				<button class="button button-primary" <?php if ( isset($in_modal) ) echo 'data-replace-media-form-modal'; ?>><?php echo __('Replace', 'replace-media') . ' ' . $type[0]; ?></button> <?php if ( isset($in_modal) ) echo '<button class="button" data-replace-media-modal-cancel>' . __('Cancel Replacement', 'replace-media') . '</button>'; ?>
				
				<?php if ( isset($in_modal) ) : ?>
				<div class="loading-icon">
					<span class="icon-replace-media-spinner">
						<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" class="loading-spinner">
							<path fill="#444" d="M32 16c-0.040-2.089-0.493-4.172-1.331-6.077-0.834-1.906-2.046-3.633-3.533-5.060-1.486-1.428-3.248-2.557-5.156-3.302-1.906-0.748-3.956-1.105-5.981-1.061-2.025 0.040-4.042 0.48-5.885 1.292-1.845 0.809-3.517 1.983-4.898 3.424s-2.474 3.147-3.193 4.994c-0.722 1.846-1.067 3.829-1.023 5.79 0.040 1.961 0.468 3.911 1.254 5.694 0.784 1.784 1.921 3.401 3.316 4.736 1.394 1.336 3.046 2.391 4.832 3.085 1.785 0.697 3.701 1.028 5.598 0.985 1.897-0.040 3.78-0.455 5.502-1.216 1.723-0.759 3.285-1.859 4.574-3.208 1.29-1.348 2.308-2.945 2.977-4.67 0.407-1.046 0.684-2.137 0.829-3.244 0.039 0.002 0.078 0.004 0.118 0.004 1.105 0 2-0.895 2-2 0-0.056-0.003-0.112-0.007-0.167h0.007zM28.822 21.311c-0.733 1.663-1.796 3.169-3.099 4.412s-2.844 2.225-4.508 2.868c-1.663 0.646-3.447 0.952-5.215 0.909-1.769-0.041-3.519-0.429-5.119-1.14-1.602-0.708-3.053-1.734-4.25-2.991s-2.141-2.743-2.76-4.346c-0.621-1.603-0.913-3.319-0.871-5.024 0.041-1.705 0.417-3.388 1.102-4.928 0.683-1.541 1.672-2.937 2.883-4.088s2.642-2.058 4.184-2.652c1.542-0.596 3.192-0.875 4.832-0.833 1.641 0.041 3.257 0.404 4.736 1.064 1.48 0.658 2.82 1.609 3.926 2.774s1.975 2.54 2.543 4.021c0.57 1.481 0.837 3.064 0.794 4.641h0.007c-0.005 0.055-0.007 0.11-0.007 0.167 0 1.032 0.781 1.88 1.784 1.988-0.195 1.088-0.517 2.151-0.962 3.156z"></path>
						</svg>
					</span>
				</div>
				<?php endif; ?>
			</div><!-- .submit-buttons -->

		</form>
	<?php endif; // ?>

	<?php if ( isset($in_modal) ) echo '</div><!-- .replace-media-modal-form -->'; ?>

<?php if ( !isset($in_modal) ) : ?>
</div><!-- .wrap -->
<?php endif; ?>