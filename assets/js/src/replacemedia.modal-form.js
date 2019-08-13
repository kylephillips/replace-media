var ReplaceMedia = ReplaceMedia || {};

/**
* Process the Modal Form
* (The forms is hidden/shown in ModalHtml class)
*/
ReplaceMedia.ModalForm = function()
{
	var self = this;
	var $ = jQuery;

	self.selectors = {
		modal : '.media-replacement-modal',
		button : 'data-replace-media-form-modal',
		error : 'data-replace-media-form-error',
		success : 'data-replace-media-form-success',
		link : 'data-replace-media-link'
	}

	self.bindEvents = function()
	{
		$(document).on('click', '[' + self.selectors.button + ']', function(e){
			e.preventDefault();
			self.submitForm($(this));
		});
	}

	self.submitForm = function(button)
	{
		self.toggleLoading(true);
		self.toggleError(false);
		self.toggleSuccess(false);
		self.refreshLink();

		var form = $(button).parents('form');
		var data = new FormData(form[0]);
		
		$.ajax({
			url : ajaxurl,
			type : 'POST',
			data : data,
			enctype: 'multipart/form-data',
			processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
			success : function(data){
				console.log(data);
				self.toggleLoading(false);
				if ( data.status === 'error' ) return self.toggleError(data.error);
				self.toggleSuccess(true);
			},
			error : function(data){
				self.toggleLoading(false);
				console.log(data);
			}
		});
	}

	self.toggleLoading = function(loading)
	{
		var form = $('.replace-media-form');
		if ( loading ){
			$(form).addClass('loading');
			$(form).find('button').attr('disabled', true);
			return;
		}
		$(form).removeClass('loading');
		$(form).find('button').removeAttr('disabled');
	}

	self.toggleSuccess = function(show)
	{
		var successDiv = $('[' + self.selectors.success + ']');
		if ( show ) {
			$('.replace-media-form').find('input[name="file"]').val('');
			$('')
			$(successDiv).show();
			return;
		}
		$(successDiv).hide();
	}

	self.toggleError = function(error)
	{
		var errorDiv = $('[' + self.selectors.error + ']');
		if ( !error ){
			$(errorDiv).hide();
			return;
		}
		$(errorDiv).text(error).show();
	}

	self.refreshLink = function()
	{
		var link = $('[' + self.selectors.link + ']');
		var baseUrl = $(link).attr('href');
		$(link).attr('href', baseUrl + '?v=' + new Date().getTime());
	}

	return self.bindEvents();
}