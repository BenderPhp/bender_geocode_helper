<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Bender Geocode Helper
|--------------------------------------------------------------------------
|
| @author Jeremie
| @date_version : 06/03/2013
| @version 0.1
| These functions uses google map api
| 
*/


/*
|--------------------------------------------------------------------------
| Geocode_reverse - Address -> infos google map api
|--------------------------------------------------------------------------
|
| $address - Address of places
|
| Example : 
| 23 allée jacques bossuet 33470 gujan-mestras
| 
| Return $response array or false
|
*/
if ( ! function_exists('geocode_reverse')) {
	function geocode_reverse($address) {

		// Sanitize
		$address = urlencode( trim($address) );

		// Create url api
		$url = 'http://maps.googleapis.com/maps/api/geocode/json?sensor=false&address=' . $address;

		// Use curl
		$results = file_get_contents($url);


		// Json -> array
		$results = json_decode($results, true);


		// Good request ?
		if ($results['status'] != 'OK') return false;

		// Init response
		$response = array(

			'street_number' => '',
			'town' => '',
			'department' => '',
			'area' => '',
			'country' => '',
			'postal_code' => '',
			'lat' => '',
			'lng' => '',
			'formatted_address' => '',
			'route' => ''

			);

		// Loop & push into response
		foreach ($results['results'][0]['address_components'] as $key => $result) {

			switch ( $result['types'][0] ) {

				case 'locality':
				$response['town'] = $result['long_name'];
				break;

				case 'administrative_area_level_2':
				$response['department'] = $result['long_name'];
				break;

				case 'administrative_area_level_1':
				$response['area'] = $result['long_name'];
				break;

				case 'country':
				$response['country'] = $result['long_name'];
				break;

				case 'postal_code':
				$response['postal_code'] = $result['long_name'];
				break;

				case 'street_number':
				$response['street_number'] = $result['long_name'];
				break;

				case 'route':
				$response['route'] = $result['long_name'];
				break;

			}

		}
		$response['formatted_address'] = $results['results'][0]['formatted_address'];

		// Geo
		$geo = $results['results'][0]['geometry']['location'];

		$response['lng'] = $geo['lng'];
		$response['lat'] = $geo['lat'];


		return $response;

	}
}

/*
|--------------------------------------------------------------------------
| Distance - Calculate distance between 2 lat & long
|--------------------------------------------------------------------------
|
| $lat1 - Latitude 1
| $lng1 - Longitude 1
| $lat2 - Bis 2
| $lng2 - Bis 2
| $miles - Display in miles or km
|
*/
if (! function_exists('distance')) {

	function distance($lat1, $lng1, $lat2, $lng2, $miles = true) {
		$pi80 = M_PI / 180;
		$lat1 *= $pi80;
		$lng1 *= $pi80;
		$lat2 *= $pi80;
		$lng2 *= $pi80;

		$r = 6372.797; // mean radius of Earth in km
		$dlat = $lat2 - $lat1;
		$dlng = $lng2 - $lng1;
		$a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
		$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
		$km = $r * $c;

		return ($miles ? ($km * 0.621371192) : $km);
	}

}