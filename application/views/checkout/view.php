  <main id="main">
    <!-- ======= Team Section ======= -->
    <section id="team" class="wow fadeInUp">
      <div class="container">
        <div class="section-header">
          <h2>Checkout</h2>
          <div class="col-md-12">
             <?php if ($this->session->flashdata('flasherror')) { ?>
            <div class="error alert alert-danger"> <?php echo $this->session->flashdata('flasherror'); ?> </div>
            <?php } ?>
            <?php if ($this->session->flashdata('flashsuccess')) { ?>
            <div class="error alert alert-success"> <?php echo $this->session->flashdata('flashsuccess'); ?> </div>
            <?php } ?>
        </div>
        </div>
        <?php if(empty($this->session->userdata('logged_in'))) { ?>
        <button type="button" class="login-heading btn btn-primary" data-toggle="collapse" data-target="#login">Returning customer? Click here to login</button>
          <div id="login" class="collapse">
            <div class="error" id="login_error"></div>  
              <?php $login_form=array('name'=>'login','onsubmit' => 'return login_form()');
              echo  form_open("entry/login",$login_form);?>            
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="Email">Email</label>
                <input type="email" class="form-control" id="login_email" name="login_email" placeholder="" value="" required="">
              </div>
              <div class="col-md-6 mb-3">
                <label for="Password">Password</label>
                <input type="password" class="form-control" id="login_password" minlength="7" maxlength="10" name="login_password" placeholder="" value="" required="">
              </div>
              <div class="col-md-12">
                  <button type="submit" class="woocommerce-button button woocommerce-form-login__submit" name="login" value="Login">Login</button>
              </div>
            </div>
             <?php echo form_close();?>  
          </div>
        <?php } ?>
          <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Your cart</span>
            <span class="badge badge-secondary badge-pill"><?php echo $count;?></span>
          </h4>
          <ul class="list-group mb-3">
            <?php 
                 $total_cart_price=0;   
                 foreach($cart as $single_product) {
                 $per_product=$single_product['price'];
                 $qty=$single_product['qty'];
                 $total_per_product_price=$per_product*$qty; 
                 $total_cart_price+= $total_per_product_price;        
            ?>
            <li class="list-group-item d-flex justify-content-between lh-condensed">
              <div>
                <h6 class="my-0"><?php echo $single_product['name']?></h6>
              </div>
              <span class="text-muted product-checkout-price">₹ <?php echo $per_product." X ".$qty; ?></br>₹ <?php echo $total_per_product_price; ?></span>
            </li>
          <?php } ?>
            <li class="list-group-item d-flex justify-content-between">
              <span>Total (INR)</span>
              <strong class="product-price">₹ <?php echo $total_cart_price; ?></strong>
            </li>
          </ul>
        </div>
        <div class="col-md-8 order-md-1">
          <?php $checkout_form=array('name'=>'checkout','novalidate'=>'novalidate','onsubmit' => 'return checkout_process()');
          echo  form_open("checkout/process",$checkout_form);?>
          <h4 class="mb-3">Billing address</h4>
          <?php if(!empty($address)) {
          foreach($address as $single_address)
          {?>
            <div class="">
                <input name="billing_address_option" type="radio" class="" value="<?php echo $single_address['address_id'];?>" checked="" required="">
                <label class="" for="credit"><?php echo $single_address['address'];?></label>
              </div>
          <?php }  
           } ?>
           <div class="">
                <input name="billing_address_option" type="radio" class="" value="new">
                <label class="" for="credit">Add new address</label>
            </div> 
            <div id="new_billing_address">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="firstName">First name</label>
                <input type="text" class="form-control" id="billing_firstname" name="billing_firstname" placeholder="" value="" required="">
              </div>
              <div class="col-md-6 mb-3">
                <label for="lastName">Last name</label>
                <input type="text" class="form-control" id="billing_lastname" name="billing_lastname" placeholder="" value="" required="">
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="email">Email</label>
              <input type="email" class="form-control" id="billing_email" name="billing_email">
              </div>
              <div class="col-md-6 mb-3">
                <label for="email">Mobile</label>
              <input type="email" class="form-control" id="billing_mobile" name="billing_mobile">
              </div>
            </div>

            <div class="mb-3">
              <label for="address">Address</label>
              <input type="text" class="form-control" id="billing_address" name="billing_address" required="">
            </div>

            <div class="row">
              <div class="col-md-3 mb-3">
                <label for="country">Country</label>
                <select class="custom-select d-block w-100" id="billing_country" name="billing_country" required="">
                  <?php foreach($country['result'] as $single_country) { ?>
                  <option value="<?php echo $single_country['country_id']; ?>"><?php echo $single_country['name']; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-3 mb-3">
                <label for="state">State</label>
                <select class="custom-select d-block w-100" id="billing_state" name="billing_state" required="">
                  <option value="">Choose...</option>
                  <?php foreach($state['result'] as $single_state) { ?>
                  <option value="<?php echo $single_state['state_id']; ?>"><?php echo $single_state['name']; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-3 mb-3">
                <label for="City">city</label>
                <input type="text" class="form-control" id="billing_city" name="billing_city" placeholder="" required="">
              </div>
              <div class="col-md-3 mb-3">
                <label for="zip">Zip</label>
                <input type="text" class="form-control" id="billing_zip" name="billing_zip" placeholder="" required="">
              </div>
            </div>
            </div>
            <?php if(empty($this->session->userdata('logged_in'))) { ?>
            <hr class="mb-4">
            <div class="">
              <input type="checkbox" class="" id="create-account" name="create-account" value="1" onclick="create_account()">
              <label class="" for="same-address">Create an Account</label>
              <div class="mb-3 hidden-password">
              <label for="address">Password</label>
              <input type="password" class="form-control"  minlength="7" maxlength="10" id="password" name="password" required="">
            </div>
            </div>
            <?php } ?>
             <div class="">
              <input type="checkbox" class="" id="ship-to-diiferent-address" name="ship-to-diiferent-address" value="1" onclick="change_shipping_address()">
              <label class="" for="same-address">Ship To A Different Address?</label>
            </div> 
            <div id="change_shipping_address" style="display: none;">
             <hr class="mb-4"> 
             <h4 class="mb-3">Shipping address</h4>
             <?php if(!empty($address)) {
          foreach($address as $single_address)
          {?>
            <div class="">
                <input name="shipping_address_option" type="radio" class="" value="<?php echo $single_address['address_id'];?>" checked="" required="">
                <label class="" for="credit"><?php echo $single_address['address'];?></label>
              </div>
          <?php }  
           } ?>
           <div class="">
                <input name="shipping_address_option" type="radio" class="" value="new">
                <label class="" for="credit">Add new address</label>
            </div> 
            <div id="new_shipping_address">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="firstName">First name</label>
                <input type="text" class="form-control" id="shipping_firstname" name="shipping_firstname" placeholder="" value="" required="">
              </div>
              <div class="col-md-6 mb-3">
                <label for="lastName">Last name</label>
                <input type="text" class="form-control" id="shipping_lastname" name="shipping_lastname" placeholder="" value="" required="">
              </div>
            </div>
            <div class="mb-3">
              <label for="address">Address</label>
              <input type="text" class="form-control" id="shipping_address" name="shipping_address" required="">
            </div>

            <div class="row">
              <div class="col-md-3 mb-3">
                <label for="country">Country</label>
                <select class="custom-select d-block w-100" id="shipping_country" name="shipping_country" required="">
                  <option value="1">India</option>
                </select>
              </div>
              <div class="col-md-3 mb-3">
                <label for="state">State</label>
                <select class="custom-select d-block w-100" id="shipping_state" name="shipping_state" required="">
                  <option value="">Choose...</option>
                  <option value="1">Maharashtra</option>
                </select>
              </div>
              <div class="col-md-3 mb-3">
                <label for="City">city</label>
                <input type="text" class="form-control" id="shipping_city" name="shipping_city" placeholder="" required="">
              </div>
              <div class="col-md-3 mb-3">
                <label for="zip">Zip</label>
                <input type="text" class="form-control" id="shipping_zip" name="shipping_zip" placeholder="" required="">
              </div>
            </div>
            </div>
            </div>
            <hr class="mb-4">
            <h4 class="mb-3">Payment</h4>
            <div class="d-block my-3">
              <div class="custom-control custom-radio">
                <input id="cod" name="paymentmethod" type="radio" class="custom-control-input" value="cod" checked="" required="">
                <label class="custom-control-label" for="credit">COD</label>
              </div>
            </div>
            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block checkout" type="submit">Continue to checkout</button>
          </form>
        </div>
      </div>
      </div>
    </section><!-- End Team Section -->

  </main><!-- End #main -->
