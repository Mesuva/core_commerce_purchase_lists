<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));


class CoreCommercePurchaseListsPurchases extends Object {
	
	public function getPurchases($id = null) {
		if (!$id) {
			return false;
		}
		
		Loader::model('order/model', 'core_commerce');
		
		$successstatuses = 'in (' . 
			CoreCommerceOrder::STATUS_AUTHORIZED . ',' . 
			CoreCommerceOrder::STATUS_SHIPPED . ',' . 
			CoreCommerceOrder::STATUS_COMPLETE . 
		')';
		
		$db = Loader::db();
		
		$sql = 'select cco.oDateAdded, ccpoav.orderProductID, ccpoav.akID, avID, ccosia.*, oEmail, ccp.quantity, ccoin.orderInvoiceNumber
		  	 	from CoreCommerceOrderProducts as ccp 
		  	 	left join CoreCommerceOrders as cco  on  ccp.orderID = cco.orderID
		  	 	left join CoreCommerceOrderInvoiceNumbers as ccoin on cco.orderID = ccoin.orderID
		  	 	left join CoreCommerceOrderSearchIndexAttributes as ccosia on cco.orderID = ccosia.orderID
		  	 	left join CoreCommerceProductOptionAttributeValues as ccpoav on ccp.orderProductID = ccpoav.orderProductID
		  	 	left join AttributeKeys on ccpoav.akID = AttributeKeys.aKID
		  	 	where productID = ? and oStatus ' . $successstatuses . ' order by ak_billing_last_name, ak_billing_first_name';
		  	 	
		
		$result = $db->Execute($sql, array($id));
		
		$orderProductID  = '';
		
		while($row = $result->fetchRow()) {
			if ($orderProductID != $row['orderID']) {
				
				$row['OptionValues'] = array();
				
				if ($row['avID']) {
					$av = AttributeValue::getByID($row['avID']);
					$row['OptionValues'][] = $av->getValue();
				}
				
				$userlist[$row['orderProductID']] = $row;		
			} else {
				$av = AttributeValue::getByID($row['avID']);
				$userlist[$row['orderProductID']]['OptionValues'][] = $av->getValue();

			}
			
			$orderProductID = $row['orderProductID'];	 	
		}
		
		return $userlist;
	}	
	
	public function getProductName($id = null) {
		if (!$id) {
			return false;
		}
	
		$db = Loader::db();
	 	$sql = 'select prName from CoreCommerceProducts where productID = ?';
	  	
		if ($productName = $db->GetOne($sql, array($id))) {
			return $productName;	
		}
		
	
	}
	
}