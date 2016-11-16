<?php

class Yhweather_Model_DbTable_Locations extends Engine_Db_Table
{
  protected $_rowClass = "Yhweather_Model_Location";

  public function getUserLocation($user_id)
  {
    $select = $this->select()
      ->where('user_id = ?', $user_id);

    return $this->fetchRow($select);
  }

  public function getObjectLocation($object_type, $object_id)
  {
    $select = $this->select()
      ->where('object_type = ?', $object_type)
      ->where('object_id = ?', $object_id);

    return $this->fetchRow($select);
  }
}