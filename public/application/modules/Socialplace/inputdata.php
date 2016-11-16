<?php
//
//wget -O- "http://localhost/se485/?m=lite&name=inputdata&module=socialplace" > /dev/null
//wget -O- "http://congdongphuot.com/?m=lite&name=inputdata&module=socialplace" > /dev/null
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
ini_set('error_reporting', -1);



require_once APPLICATION_PATH . '/application/modules/Socialplace/Libs/phpQuery-onefile.php';
set_time_limit(0);
$application -> getBootstrap() -> bootstrap('translate');
$application -> getBootstrap() -> bootstrap('locale');
$application -> getBootstrap() -> bootstrap('hooks');

$limit = 5;
$crawlTbl = Engine_Api::_()->getDbTable('crawlingdata', 'socialplace');
$placeTbl = Engine_Api::_()->getDbTable('places', 'socialplace');
$select = $crawlTbl -> select()
    -> where ("done = ?", 0)
    -> limit($limit)
;
$cookie_jar = APPLICATION_PATH . "/temporary/session/cookie1.txt";
$host = "http://vi.hotels.com/search/listings.json";
$hotels = $crawlTbl -> fetchAll($select);
$number = 0;

if (count($hotels))
{
    foreach ($hotels as $hotel)
    {
	
        if ($hotel->link_detail)
        {
            $url = $hotel->link_detail;
            echo "<a href='{$url}'>{$url}</a>";
            echo "<br />=============<br />";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_REFERER, $host);
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_jar);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar);
            curl_setopt($ch, CURLOPT_TIMEOUT, 300);
            //curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Requested-With: XMLHttpRequest", "Content-Type: application/javascript; charset=utf-8", "Host:vi.hotels.com"));
            $data=curl_exec($ch);
            if(curl_getinfo($ch, CURLINFO_HTTP_CODE) !== 200)
            {
                $data=curl_exec($ch);
            }
            curl_close($ch);
            
            if ($data)
            {
				
                phpQuery::newDocumentHTML($data);
                $descriptionElm = pq('div#hotel-overview div.info-box');
                $description = trim($descriptionElm->html());
                if ($description)
                {
                    $hotel -> body = $description;
                }

                $latitudeElm = pq('div#property-name span.latitude');
                $latitude = trim($latitudeElm->html());
                $longitudeElm = pq('div#property-name span.longitude');
                $longitude = trim($longitudeElm->html());
                if ($latitude && $longitude)
                {
                    $hotel -> latitude = $latitude;
                    $hotel -> longitude = $longitude;
                }

                $thumbElms = pq('div#hotel-photos li.thumbnail a');
                $imageUrls = array();
                foreach ($thumbElms as $elm)
                {
                    $imageUrls[] = trim($elm->getAttribute('href'));
                    if (count($imageUrls) == 2)
                    {
                        break;
                    }
                }
                
                $place = $placeTbl -> createRow();
                $place->setFromArray($hotel->toArray());
                $place->phone = array();
                $place->from_crawling = 1;
                if (count($imageUrls))
                {
                    $place->photo_url = $imageUrls[0];
                    $imagePath = Engine_Api::_()->socialplace()->loadImage($imageUrls[0]);
                    $place -> setPhoto($imagePath);
                    @unlink($imagePath);

                    if (count($imageUrls) == 2)
                    {
                        $imagePath = Engine_Api::_()->socialplace()->loadImage($imageUrls[1]);
                        $place -> addPhoto($imagePath);
                        @unlink($imagePath);    
                    }
                }
                
                $place->save();

                // INIT PRIVACY AUTH
                $auth = Engine_Api::_()->authorization()->context;
                $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');
                $viewMax = array_search('everyone', $roles);
                $commentMax = array_search('everyone', $roles);
                foreach( $roles as $i => $role ) {
                    $auth->setAllowed($place, $role, 'view', ($i <= $viewMax));
                    $auth->setAllowed($place, $role, 'comment', ($i <= $commentMax));
                }

                $hotel->done = 1;
                $hotel->save();
                $number ++;
            }
        }
    }

}

echo "Saved $number records";






