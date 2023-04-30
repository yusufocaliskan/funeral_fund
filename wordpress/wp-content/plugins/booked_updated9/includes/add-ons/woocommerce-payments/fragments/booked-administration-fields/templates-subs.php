<?php 

//this page Not being used anymore.
//look at admin-function.php (line: 1270)
$balindex = new Balindex();
$products = $balindex->getTimeslotProducts();
?>
<?php if ( $field_type==='single-paid-service' ): ?>
	<li id="bookedCFTemplate-single-paid-service" class="ui-state-default"><i class="sub-handle fa-solid fa-bars"></i>
		<select name="<?php echo $name ?>" >
			<option value=""><?php _e('Select a Product', 'booked'); ?></option>
			<?php foreach ($products as $product): ?>
				<?php $product = Booked_WC_Product::get( intval($product) ); ?>
				
				<option <?php echo intval($value)===$product->data->id ? 'selected="selected"' : '' ?> value="<?php echo $product->data->id ?>"><?php echo esc_html($product->title); ?></option>
			<?php endforeach ?>
		</select>
		<span class="cf-delete"><i class="fa-solid fa-trash-can"></i></span>
	</li>
<?php endif ?>

