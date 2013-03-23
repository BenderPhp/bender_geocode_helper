Bender_geocode_helper
=====================

__Version : 0.1__


Bender_geocode_helper vous permet d'ajouter un peu de géolocalisation dans vos applications.

geocode_reverse()
-------------------------

geocode_reverse() est une fonction qui se connecte à l'API Google Map et récupère des infos sur l'adresse que vous lui donnez en paramètre.

*Paramètres* 
===

`$address` - L'adresse du lieu que vous voulez geolocaliser

*Retourne*
===

Soit `FALSE` si il est impossible de localiser le lieu ou un `array` contenant différentes informations.


*Exemple d'utilisation*
===

```php

<?php

class Example extends CI_Controller {

  public function __construct() {
		parent::__Construct();

		// Load helper
		$this->load->helper('bender_geocode_helper');

	}

	public function index() {
		
		$address = '23 allée jacques bossuet 33470';

		// Run
		$geocode = geocode_reverse($address);

		// Success geocode ?
		if ($geocode) echo 'Lat : ' . $geocode['lat'] . ' / Lng : ' . $geocode['lng'];
		
		// Output : Lat : 44.6206092 / Lng : -1.0752272

	}

	public function dump() {

		$address = '23 allée jacques bossuet Gujan Mestras';

		// Run
		$geocode = geocode_reverse($address);

		// Success geocode ?

		if ($geocode) {

			echo '<pre>';
			var_dump($geocode);

		}

		/* Output :

		array(10) {
		  ["street_number"]=>
		  string(2) "23"
		  ["town"]=>
		  string(13) "Gujan-Mestras"
		  ["department"]=>
		  string(7) "Gironde"
		  ["area"]=>
		  string(9) "Aquitaine"
		  ["country"]=>
		  string(6) "France"
		  ["postal_code"]=>
		  string(5) "33470"
		  ["lat"]=>
		  float(44.6206092)
		  ["lng"]=>
		  float(-1.0752272)
		  ["formatted_address"]=>
		  string(54) "23 AllÃ©e Jacques Bossuet, 33470 Gujan-Mestras, France"
		  ["route"]=>
		  string(22) "AllÃ©e Jacques Bossuet"
		}
		
		*/

	}



}


```


distance()
-------------------------

La fonction distance() vous permet de calculer la distance entre deux couples (lng/lat).

*Paramètres* 
===

`$lat1` - La première latitude

`$lng1` - La première longitude

`$lat2` - La deuxième latitude

`$lng2` - La deuxième longitude

`$miles` - Si TRUE renvoie la distance en miles dans le cas contraire en km

*Retourne*
===

Soit la distance en KM, soit en miles


*Exemple d'utilisation*
===

```php

<?php

class Example extends CI_Controller {

  public function __construct() {
		parent::__Construct();

		// Load helper
		$this->load->helper('bender_geocode_helper');

	}

	public function distance() {

		$address1 = '23 allée jacques bossuet 33470';
		$address2 = '10 allée pierre corneille 33470';

		$geocode1  = geocode_reverse($address1);
		$geocode2 = geocode_reverse($address2);

		if ($geocode1 && $geocode2) {

			// Calculate distance between these two addresses (return km)
			$distance = distance($geocode1['lat'], $geocode1['lng'], $geocode2['lat'], $geocode2['lng'], false);

			var_dump($distance);

		}

		// Ouput : float(1.1461119700274)

	}



}

```

Bon code !
