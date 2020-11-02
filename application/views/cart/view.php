<main id="main">
    <!-- ======= Single Product ======= -->
    <section id="team" class="wow fadeInUp">
        <div class="container">
            <h1>Shopping Cart</h1>
            <?php if(count($cart) > 0) { ?>
            <div class="shopping-cart">
                <div class="column-labels">
                    <label class="product-image">Image</label>
                    <label class="product-details">Product</label>
                    <label class="product-price">Price</label>
                    <label class="product-quantity">Quantity</label>
                    <label class="product-removal">Remove</label>
                    <label class="product-line-price">Total</label>
                </div>
                <?php 
                 $total_cart_price=0;   
                foreach($cart as $single_product) {
                 $per_product=$single_product['price'];
                 $qty=$single_product['qty'];
                 $total_per_product_price=$per_product*$qty; 
                 $total_cart_price+= $total_per_product_price;        
                    ?>
                <div class="product">
                    <div class="product-image">
                        <img src="<?php echo $single_product['image']?>">
                        </div>
                        <div class="product-details">
                            <div class="product-title"><a href="<?php echo base_url('product/'.$single_product['id']); ?>"><?php echo $single_product['name']?></a></div>
                        </div>
                        <div class="product-price"><?php echo $per_product?></div>
                        <div class="product-quantity">
                            <select id="quantity_<?php echo $single_product['id']?>" class="product_quantity">
                                <?php for($q=1;$q<=5;$q++){?>
                                <option value="<?php echo $q; ?>" <?php if($qty==$q){echo "Selected";} ?>><?php echo $q; ?></option>
                                <?php } ?>
                            </select>
                            <a class="" href="javascript:void(0)" onclick="update_quantity(<?php echo $single_product['id']?>)">
                                <i class="fa fa-refresh" aria-hidden="true"></i>
                            </a>
                            <div id="cart_result_<?php echo $single_product['id']?>"></div>
                        </div>
                        <div class="product-removal">
                            <a class="" href="javascript:void(0)" onclick="delete_cart(<?php echo $single_product['id']?>)">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                            <div id="cart_delete_<?php echo $single_product['id']?>"></div>
                        </div>
                        <div class="product-line-price"><?php echo $total_per_product_price; ?></div>
                    </div>
                    <?php } ?>
                    <div class="totals">
                        <div class="totals-item totals-item-total">
                            <label>Grand Total</label>
                            <div class="totals-value" id="cart-total"><?php echo $total_cart_price;?></div>
                        </div>
                    </div>
                    <a class="checkout" href="<?php echo base_url('checkout');?>">Checkout</a>
                </div>
            <?php } else { ?>
                <div class="text-center margin-bottom20"><a class="browse-products" href="<?php echo base_url();?>">Browse Products</a></div>
            <?php } ?>
            </div>
        </section>
        <!-- End Single Product -->
    </main>
    <!-- End #main -->