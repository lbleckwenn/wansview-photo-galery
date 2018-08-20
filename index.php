 <?php
	$username = '';
	$password = '';
	$wansview = 'http://0.0.0.0/sd/';
	
	$rootPage = getPage ( $wansview, $username, $password );
	$rootPagePosition = 0;
	$days = array ();
	while ( $rootPagePosition = strpos ( $rootPage, '/sd/2', $rootPagePosition + 1 ) ) {
		$day = substr ( $rootPage, $rootPagePosition + 4, 8 );
		$days [$day] = array (
				'images' => array (),
				'videos' => array () 
		);
		$dayPage = getPage ( $wansview . $day . '/', $username, $password );
		$dayPagePosition = 0;
		while ( $dayPagePosition = strpos ( $dayPage, '/image', $dayPagePosition + 1 ) ) {
			$folder = substr ( $dayPage, $dayPagePosition + 1, 10 );
			$imagePage = getPage ( $wansview . $day . '/' . $folder, $username, $password );
			$imagePagePosition = 0;
			while ( $imagePagePosition = strpos ( $imagePage, $folder . 'A', $imagePagePosition + 1 ) ) {
				$image = substr ( $imagePage, $imagePagePosition + 10, 19 );
				$days [$day] ['images'] [] = $folder . $image;
			}
		}
	}
	var_dump ( $days );
	function getPage($URL, $username, $password) {
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $URL );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, 30 ); // timeout after 30 seconds
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY );
		curl_setopt ( $ch, CURLOPT_USERPWD, "$username:$password" );
		$result = curl_exec ( $ch );
		$status_code = curl_getinfo ( $ch, CURLINFO_HTTP_CODE ); // get status code
		curl_close ( $ch );
		return $result;
	}