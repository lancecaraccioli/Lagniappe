<?php
$action = $_REQUEST['action'];
/* this file should process an incoming ajax request */

$categories = array(
	0 => 'Clothing',
	1 => 'Office Supplies', 
);

$storeData = array(
	array('item_id' => 1, 'catid' => 0, 'name' => 'Elance T-Shirt', 'description' => 'Be cool in your very own Elance T-Shirt!', 'price' => 15, 'image' => 'images/tshirt.png'),
	array('item_id' => 2, 'catid' => 0,'name' => 'Elance Polo', 'description' => 'Represent Elance with a classic polo shirt!', 'price' => 25, 'image' => 'images/polo.png'),
	array('item_id' => 3, 'catid' => 1,'name' => 'Elance Mug', 'description' => 'Taste success with an Elance mug!', 'price' => 10, 'image' => 'images/mug.png'),
	array('item_id' => 4, 'catid' => 1,'name' => 'Elance Mousepad', 'description' => 'Custom Elance mousepad!', 'price' => 5, 'image' => 'images/mousepad.png')
);

switch($action){
	case 'load':
		$jsonData = array(
			'categories'=>$categories,
		);
		break;
	case 'loadProducts':
		$categoryId = $_REQUEST['catid'];
		$jsonData['storeData']=array();
		foreach ($storeData as $product){
			if ($product['catid'] == $categoryId){
				$jsonData['storeData'][] = $product;
			}
		}
		
		break;
	case 'checkout':
		break;
	default:
		break;
}

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
echo json_encode($jsonData);



