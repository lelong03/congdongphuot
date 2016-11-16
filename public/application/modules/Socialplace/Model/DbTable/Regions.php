<?php
class Socialplace_Model_DbTable_Regions extends Engine_Db_Table
{
	protected $_rowClass = 'Socialplace_Model_Region';

	public function getRegionsAssoc()
	{
		$stmt = $this->select()
		->from($this, array('region_id', 'region_name'))
		->order('region_name ASC')
		->query();

		$data = array();
		foreach( $stmt->fetchAll() as $region ) {
			$data[$region['region_id']] = $region['region_name'];
		}
		return $data;
	}

    public function getParentRegionsAssoc()
    {
        $stmt = $this->select()
            ->from($this, array('region_id', 'region_name'))
            ->where("parent_id = ?", '0')
            ->order('region_name ASC')
            ->query();

        $data = array('' => Zend_Registry::get("Zend_Translate")->_("All"));
        foreach( $stmt->fetchAll() as $region ) {
            $data[$region['region_id']] = $region['region_name'];
        }
        return $data;
    }

	// NO NEED TO CODE THIS FUNCTION
	public function getRegion($id)
	{
		return Engine_Api::_()->getItem('socialplace_region', $id);
	}
}
