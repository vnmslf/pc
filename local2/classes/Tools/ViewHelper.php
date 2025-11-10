<?php
namespace Tools;
/**
 * Class ViewHelper
 */
class ViewHelper
{
	public static function getSvg($file_name)
	{
		return file_get_contents($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/images/'.$file_name.'.svg');
	}
}
