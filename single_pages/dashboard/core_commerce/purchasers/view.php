<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php 
$th = Loader::helper('text'); 
$form = Loader::helper('form');
$ih = Loader::helper('concrete/interface');

$task = $this->controller->getTask();

if ($productName) {
	$title = t('Purchasers') .' - ' . $productName;	
} else {
	$title = t('Product Purchasers');
}
?>
  
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(  $title , false, false, false)?>

 <div class="ccm-pane-body">
	<form method="get">
 		<?php echo $form->select('prID', $products, $prID); ?>
 		<input type="submit" class="btn" value="View" />
 	</form>
 	
 	<h2><?php echo $productName; ?></h2>
 	
 	<?php if (!empty($userlist)) { ?>
 	<?php Loader::packageElement('orders','core_commerce_purchase_lists',array('userlist'=>$userlist)); ?>
  	
	<?php } elseif (!$noproduct) { ?>
	<p><?php echo t('There are no orders of this product to display');?></p>
	<?php } ?>	
 			
 </div>
 
<div class="ccm-pane-footer">

<?php if (!empty($userlist)) { ?>

 	
	
	<?php echo $ih->button(t('Print'), '../../../tools/packages/core_commerce_purchase_lists/purchasers.php?prID='. $prID, 'right', 'btn btn-primary', array('target'=>'_blank')); ?>
	
	<?php echo $ih->button(t('Export as CSV'), '../../../tools/packages/core_commerce_purchase_lists/purchasers.php?export=1&amp;prID='. $prID, 'right', 'btn btn-primary'); ?>
 
 
<?php } ?>	

</div>
 
 
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false)?>

 