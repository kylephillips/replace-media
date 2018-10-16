/**
* Primary Theme Scripts Initialization
*
*/
var ReplaceMedia = ReplaceMedia || {};

jQuery(document).ready(function(){
	new ReplaceMedia.Factory;
});

/**
* Primary factory class
*/
ReplaceMedia.Factory = function()
{
	var self = this;
	var $ = jQuery;

	self.build = function()
	{
		new ReplaceMedia.ModalHtml;
		new ReplaceMedia.ModalForm;
	}

	return self.build();
}