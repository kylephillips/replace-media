<?php
namespace ReplaceMedia\Services;

/**
* Get Media Attributes
*/
class MediaAttributes
{
	/**
	* Get the file type
	* @param int $attachment_id
	* @return array
	*/
	public function fileType($attachment_id)
	{
		$type = get_post_mime_type($attachment_id);
		if ( !$type ) return [];
		if ( $type == 'application/pdf' ) return [__('Document', 'replace-media'), 'pdf'];
		if ( $type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ) return [__('Word Document', 'replace-media'), 'docx'];
		if ( $type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' ) return [__('Excel Document', 'replace-media'), 'xlsx'];
		$type = explode('/', $type);
		$type[0] = ucfirst($type[0]);
		return $type;
	}
}