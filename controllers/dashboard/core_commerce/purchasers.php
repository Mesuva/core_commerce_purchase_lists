<?php 
defined('C5_EXECUTE') or die("Access Denied.");

class DashboardCoreCommercePurchasersController extends Controller { 
  	public function view() {
  		Loader::model('purchases', 'core_commerce_purchase_lists');
  		$p = new CoreCommercePurchaseListsPurchases();
  		$db = Loader::db();
  		
  		$noproduct = false; 
  		
  		$id = (int)$_GET['prID'];
  		
  		if (!$id) {
  			$noproduct = true;	
  		} else {
  	 		$userlist = $p->getPurchases($id); 
  	 		$productName = $p->getProductName($id);	 
  	 		$this->set('userlist', $userlist);
  	 		$this->set('productName', $productName);	
  		}
  	 	
  	 	
  	 	$this->set('noproduct', $noproduct);
  	 	$this->set('prID', $id);
  	 	
  	 	$sql = 'select * from CoreCommerceProducts order by prName';
  	 	$result = $db->Execute($sql);
  	 	
  	 	$products['0'] = t('Please select a product');
  	 	
  	 	while($row = $result->fetchRow()) {
  	 		$products[$row['productID']] = $row['prName'] . ($row['prStatus'] != 1 ? ' ('. t('disabled') .')' : '');	
  	  	}
  	 	
  	 	$this->set('products', $products);
  	}   	
}
 
?>