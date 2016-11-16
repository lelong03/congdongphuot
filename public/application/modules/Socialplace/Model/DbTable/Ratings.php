<?php
class Socialplace_Model_DbTable_Ratings extends Engine_Db_Table
{
	protected $_rowClass = "Socialplace_Model_Rating";
	public function checkRated($place, $user)
	{
		$rName = $this -> info('name');
		$select = $this -> select() 
		-> setIntegrityCheck(false) 
		-> where('place_id = ?', $place->getIdentity()) 
		-> where('user_id = ?', $user->getIdentity()) 
		-> limit(1);
		
		$row = $this -> fetchAll($select);
		if (count($row) > 0)
		{
			return true;
		}
		return false;
	}

	public function ratingCount($place)
	{
		if (is_object($place))
		{
			$place_id = $place->getIdentity();
		}
		else 
		{
			$place_id = $place;
		}
		$rName = $this -> info('name');
		$select = $this -> select() 
		-> from($rName) 
		-> where($rName . '.place_id = ?', $place_id);
		$row = $this -> fetchAll($select);
		$total = count($row);
		return $total;
	}
	
	public function setRating($place_id, $user_id, $rating)
	{
		$rName = $this -> info('name');
		$select = $this -> select() -> from($rName) -> where($rName . '.place_id = ?', $place_id) -> where($rName . '.user_id = ?', $user_id);
		$row = $this -> fetchRow($select);
		if (empty($row))
		{
			// create rating
			$this -> insert(array(
				'place_id' => $place_id,
				'user_id' => $user_id,
				'rating' => $rating
			));
		}
	}
	
	public function getRating($place_id)
	{
		$rating_sum = $this -> select() 
		-> from($this -> info('name'), new Zend_Db_Expr('SUM(rating)')) 
		-> group('place_id') 
		-> where('place_id = ?', $place_id) 
		-> query() 
		-> fetchColumn(0);

		$total = $this -> ratingCount($place_id);
		if ($total)
			$rating = $rating_sum / $this -> ratingCount($place_id);
		else
			$rating = 0;

		return $rating;
	}
	
	public function getRatings($place_id)
	{
		$rName = $this -> info('name');
		$select = $this -> select() 
		-> from($rName) 
		-> where($rName . '.place_id = ?', $place_id);
		
		$row = $this -> fetchAll($select);
		return $row;
	}
}