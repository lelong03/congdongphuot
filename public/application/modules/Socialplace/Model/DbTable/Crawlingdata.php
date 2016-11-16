<?php
class Socialplace_Model_DbTable_Crawlingdata extends Engine_Db_Table
{
	protected $_name = 'socialplace_crawlingdata';
	protected $_rowClass = 'Socialplace_Model_Crawlingdata';
	protected $_serializedColumns = array('phone', 'guest_reviews', 'landmarks');
}
