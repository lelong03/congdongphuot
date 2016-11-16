<?php
class Seminimenu_Api_Core
{
	public static function partialViewFullPath($partialTemplateFile)
	{
		$ds = DIRECTORY_SEPARATOR;
		return "application{$ds}modules{$ds}Seminimenu{$ds}views{$ds}scripts{$ds}{$partialTemplateFile}";
	}
}
