<?php
set_time_limit(0);
$application -> getBootstrap() -> bootstrap('translate');
$application -> getBootstrap() -> bootstrap('locale');
$application -> getBootstrap() -> bootstrap('hooks');

$itemArr = array('blog', 'place', 'event', 'group');
foreach ($itemArr as $it)
{
	$itemTbl = Engine_Api::_()->getItemTable($it);
	$limit = 500;
	$select = $itemTbl -> select() -> where ("title_search = ''") -> limit($limit);
	$items = $itemTbl -> fetchAll($select);
	$i = 0;
	if (count($items))
	{
		foreach ($items as $item)
		{
			$item -> title_search = Engine_Api::_()->socialplace()->vnFilter($item->title);
			$item -> save();
			$i++;
		}
	}

	echo "DONE - $i $it(s) <br />";
}


