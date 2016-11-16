<?php
//wget -O- "http://localhost/se485/?m=lite&name=crawling1&module=socialplace" > /dev/null
//wget -O- "http://congdongphuot.com/?m=lite&name=crawling1&module=socialplace" > /dev/null

set_time_limit(0);
$application -> getBootstrap() -> bootstrap('translate');
$application -> getBootstrap() -> bootstrap('locale');
$application -> getBootstrap() -> bootstrap('hooks');

//Prepare data
/*
$destinationId = '1634382'; // destination id in hotels.com
$destination = 'Hà Nội, Việt Nam'; // destination name in hotels.com
$regionId = 62; //region id in congdongphuot.com
*/
/*
$destinationId = '1637291'; // destination id in hotels.com
$destination = 'Thị xã Châu Đốc, Việt Nam'; // destination name in hotels.com
$regionId = 1; //region id in congdongphuot.com
*/
/*
$destinationId = '1581970'; // destination id in hotels.com
$destination = 'Vũng Tàu, Việt Nam'; // destination name in hotels.com
$regionId = 2; //region id in congdongphuot.com
*/
/*
$destinationId = '1570344'; // destination id in hotels.com
$destination = 'Thị xã Bà Rịa, Việt Nam'; // destination name in hotels.com
$regionId = 2; //region id in congdongphuot.com
*/
/*
$destinationId = '1785921'; // destination id in hotels.com
$destination = 'Đà Nẵng, Việt Nam'; // destination name in hotels.com
$regionId = 60; //region id in congdongphuot.com
*/
/*
$destinationId = '1571307'; // destination id in hotels.com
$destination = 'Quy Nhơn, Việt Nam'; // destination name in hotels.com
$regionId = 8; //region id in congdongphuot.com
*/
/*
$destinationId = '1581241'; // destination id in hotels.com
$destination = 'Phan Thiết, Việt Nam'; // destination name in hotels.com
$regionId = 11; //region id in congdongphuot.com
*/
$destinationId = '1568688'; // destination id in hotels.com
$destination = 'Đồng Hới, Việt Nam'; // destination name in hotels.com
$regionId = 40; //region id in congdongphuot.com


//Starting getting data
$site = "http://vi.hotels.com";
$host = "http://vi.hotels.com/search/listings.json";
$params = array(
	'q-localised-check-in' => '05/03/2015',
	'q-localised-check-out' => '08/03/2015',
	'q-room-0-adults' => '2',
	'destination-id' => $destinationId,
	'q-destination' => $destination,
	'q-room-0-children' => '0',
	'q-rooms' => '1',
	'resolved-location' => "CITY:{$destinationId}:UNKNOWN:UNKNOWN",
	'pn' => '1',
	'start-index' => '0',
);

$viewer = Engine_Api::_()->user()->getViewer();
$crawlTbl = Engine_Api::_()->getDbTable('crawlingdata', 'socialplace'); 
$pn = 1; $start = 0;
$i = 0;
$cookie_jar = APPLICATION_PATH . "/temporary/session/cookie.txt";

while(true)
{
	$params['pn'] = $pn;
	$params['start-index'] = $start;
	$url = $host . "?" . http_build_query($params);
	echo $url . "<br />=====================<br />";
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_REFERER, $host);
	curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_jar);
	curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar);
    curl_setopt($ch, CURLOPT_TIMEOUT, 300);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Requested-With: XMLHttpRequest", "Content-Type: application/javascript; charset=utf-8", "Host:vi.hotels.com"));
	$data=curl_exec($ch);
    if(curl_getinfo($ch, CURLINFO_HTTP_CODE) !== 200)
    {
        echo "<br />time out in page: {$pn}<br />";
        $data=curl_exec($ch);
    }
    curl_close($ch);
	
	$data = Zend_Json::decode($data);
	$data = $data['data'];
	$numerOfItems = count($data['body']['searchResults']['results']);
	
	//print_r($data['body']['searchResults']['results']); exit;
	
	if ($numerOfItems)
	{
		foreach ($data['body']['searchResults']['results'] as $arr)
		{
			/*
			if ($arr['name'])
			{
				$select = $crawlTbl -> select() -> where("title = ? ", $arr['name'])->limit(1);
				$findedRow  = $crawlTbl -> fetchRow($select);
				if ($findedRow -> place_id)
				{
					break;
				}
			}
			*/
			$row = $crawlTbl->createRow();
			$row -> setFromArray(array(
				'title' => $arr['name'],
				'country' => $arr['address']['countryName'],
				'extended_address' => @$arr['address']['extendedAddress'],
				'locality' => $arr['address']['locality'],
				'postal_code' => $arr['address']['postalCode'],
				'region' => $arr['address']['postalCode'],
				'street_address' => $arr['address']['streetAddress'],
				'address' => $arr['address']['streetAddress']. ', ' . $arr['address']['extendedAddress'],
				'guest_reviews' => $arr['guestReviews'],
				'landmarks' => $arr['landmarks'],
				'phone' => array($arr['telephone']['number']),
				'thumb_image' => $arr['thumbnailUrl'],
				'link_detail' => $site . $arr['urls']['pdpDescription'],
				'rating' => $arr['starRating'],
				'price' => $arr['ratePlan']['price']['exactCurrent'],
				'owner_type' => 'user',
		        'owner_id' => 44,
				'user_id' => 44,
                'category_id' => 1,
                'region_id' => $regionId,
			));
			$row -> creation_date = date('Y-m-d H:i:s');
      		$row -> modified_date   = date('Y-m-d H:i:s');
			$row -> save();
			echo $i . " - " . $arr['name'] . "<br />";
			$i++;
		}
	}
	
	if ($numerOfItems == 0)
	{
		break;
	}
	$start += $numerOfItems;
	$pn++;
}
echo "Saved $i records";






