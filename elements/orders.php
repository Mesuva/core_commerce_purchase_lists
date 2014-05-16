 <?php 	$date = Loader::helper('date'); ?>
 
 <?php $totalquantity = 0; ?>
 
 <table class="table table-striped">
	<tr>
		
		<th><?php echo t('Last Name'); ?></th>
		<th><?php echo t('First Name'); ?></th>
		<th><?php echo t('Quantity'); ?></th>
		<th><?php echo t('Options'); ?></th>
		<th><?php echo t('Email'); ?></th>
		<th><?php echo t('Order #'); ?></th>
		<th><?php echo t('Order Date'); ?></th>
	</tr>

	<?php foreach($userlist as $o) { ?>
	<tr>
		<td><?php echo $o['ak_billing_last_name']; ?></td>
		<td><?php echo $o['ak_billing_first_name']; ?></td>
		<td><?php echo $o['quantity']; $totalquantity += $o['quantity'] ?></td>
		<td><?php echo implode(', ', $o['OptionValues']); ?></td>
		<td><a href="mailto:<?php echo $o['oEmail']; ?>"><?php echo $o['oEmail']; ?></a></td>
		
		<?php if ($this) { ?>
		<td><a href="<?php echo $this->url('index.php/dashboard/core_commerce/orders/search/detail/', $o['orderID']);?>"><?php echo sprintf('%06s',$o['orderInvoiceNumber']); ?></a></td>
		 <?php } else { ?>
		 <td><?php echo sprintf('%06s',$o['orderInvoiceNumber']); ?></td>
		 <?php } ?> 
		  
		  <td><?php echo date(DATE_APP_GENERIC_MDY_FULL, strtotime($o['oDateAdded'])); ?></td>
		  
	</tr>
	<?php } ?>
	<tr><td colspan="2" style="text-align: right"><strong><?php echo t('Total'); ?></strong></td><td colspan="5"><strong><?php echo $totalquantity; ?></strong></td></tr>
</table>
