var ReplaceMedia = ReplaceMedia || {};

/**
* Hide/Show the Modal Form within the media library modal
*/
ReplaceMedia.ModalHtml = function()
{
	var self = this;
	var $ = jQuery;

	self.activeAttachmentModal = false;
	self.activeButton;

	self.selectors = {
		modalButton : 'data-replace-media-modal-button',
		closeModalButton : '.media-modal-close',
		cancelButton : 'data-replace-media-modal-cancel',
		replacementModal : '.media-replacement-modal'
	}

	self.bindEvents = function()
	{
		$(document).on('click', '[' + self.selectors.modalButton + ']', function(e){
			e.preventDefault();
			self.replaceModal($(this));
		});

		$(document).on('click', self.selectors.closeModalButton, function(){
			if ( !self.activeAttachmentModal ) return;
			self.revertModal();
		});

		$(document).on('click', '[' + self.selectors.cancelButton + ']', function(e){
			e.preventDefault();
			self.revertModal();
		});
	}

	/**
	* Replace the attachment modal with the form
	*/
	self.replaceModal = function(button)
	{
		self.activeButton = $(button);
		self.activeAttachmentModal = $(button).parents('.media-modal-content');

		// Create and clean up the new modal
		var replaceModal = self.activeAttachmentModal.clone();
		$(replaceModal).find('.attachment-info').remove();
		$(replaceModal).find('.attachment-media-view').remove();
		$(replaceModal).find('.edit-media-header').hide();

		// Hide the default attachment modal and show the replacement content
		$(self.activeAttachmentModal).hide();
		$(replaceModal).insertAfter(self.activeAttachmentModal).addClass('media-replacement-modal');
		self.getForm(replaceModal);
	}

	/**
	* Get the form
	*/
	self.getForm = function(modal)
	{
		var attachment_id = $(self.activeButton).attr('data-attachment-id');
		$.ajax({
			url : ajaxurl,
			type : 'GET',
			datatype : 'jsonp',
			data : {
				action : 'replace_media_modal_html',
				attachment_id : attachment_id
			},
			success : function(data){
				$(modal).find('.media-frame-content').html(data.html);
			},
			error : function(data){
				console.log(data);
			}
		});
	}

	/**
	* Revert back to the original attachment modal
	*/
	self.revertModal = function()
	{
		$(self.selectors.replacementModal).remove();
		$('.media-modal-content').show();
		self.activeAttachmentModal = false;
	}

	return self.bindEvents();
}