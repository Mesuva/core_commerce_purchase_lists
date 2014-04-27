<?php  defined('C5_EXECUTE') or die("Access Denied."); 
$cnt = Loader::controller('/dashboard/core_commerce/purchasers');
$p = new Permissions($cnt->getCollectionObject());

if($p->canRead()) {

Loader::model('purchases', 'core_commerce_purchase_lists');
$p = new CoreCommercePurchaseListsPurchases();
 
$id = (int)$_GET['prID'];

if (!$id) {
	$noproduct = true;	
} else {
	$userlist = $p->getPurchases($id); 
	$productName = $p->getProductName($id);	 
}
 

if((int)$_GET['export'] == 1) { 
	$th = Loader::helper('text');

	header("Content-type: text/csv");  
	header("Cache-Control: no-store, no-cache");  
	header('Content-Disposition: attachment; filename="purchasers_'. $th->sanitizeFileSystem($productName) . '_'. date('M-d-Y') .'.csv"');
	
	echo  'last_name, first_name, quantity, options, email, order_number, order_date'. "\n";
				
	// create a write-only output buffer 
	$out = fopen('php://output', 'w');
	 
	foreach($userlist as $o) {  
		$data = array();
		
	 	$data[] = $o['ak_billing_last_name']; 
		$data[] = $o['ak_billing_first_name'];  
		$data[] = $o['quantity']; 
		$data[] = implode(',', $o['OptionValues']);  
		$data[] = $o['oEmail']; 
		$data[] = sprintf('%06s',$o['orderInvoiceNumber']);
		$data[] = date(DATE_APP_GENERIC_MDY_FULL, strtotime($o['oDateAdded']));  
	  
		// use PHP's fputcsv function to ensure CSV formatting
		fputcsv($out, $data);
	}
	
	fclose($out);
	exit();	 


} else { 

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Purchasers - <?php echo $productName; ?></title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<script>
window.onload = function () {
    window.print();
}

</script>
<style>
table {
	width:  100%;
	border-collapse:  collapse;
	font-family: arial, sans-serif;
	font-size:  12px;
}

h2 {
	font-family: arial, sans-serif;
}

th {
	text-align: left;
	padding-left:  4px;
	padding-right:  4px;
	padding-top:  4px;
	padding-bottom:  4px;
}

td {
	border-bottom:  solid 1px #AAA;	
	border-top:  solid 1px #AAA;
	padding-left:  4px;
	padding-right:  4px;
}

a {
	color:  black;
	text-decoration: none;
}

</style>
 
</head>

<body>	 
<?php  
  	 	echo '<h2>' .$productName .'</h2>';
		Loader::packageElement('orders','core_commerce_purchase_lists',array('userlist'=>$userlist)); 	 	
} ?>
	
</body>
</html>

	
<?php  

} else {
	die(t("Access Denied."));	
}

?>
