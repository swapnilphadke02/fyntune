  <!-- ======= Intro Section ======= -->
  <section id="intro">
    <div class="intro-content">
      <h2>Great <span>Indian Festival</span><br>Upto 60% Off</h2>
    </div>
    <div id="intro-carousel" class="owl-carousel">
      <div class="item" style="background-image: url('<?php echo base_url(assets_img);?>/intro-carousel/1.jpg');"></div>
    </div>
  </section><!-- End Intro Section -->

  <main id="main">
    <!-- ======= Team Section ======= -->
    <section id="team" class="wow fadeInUp">
      <div class="container">
        <div class="section-header">
          <h2>Blockbuster Deals</h2>
        </div>
        <div class="row">
          <?php if($products['count'] > 0) 
          { 
            foreach ($products['list'] as $key => $value) 
              {
              ?>
              <div class="col-lg-3 col-md-6">
                <div class="member product-info">
                  <div class="pic"><a href="<?php echo base_url("product/".$value['id']);?>" title="<?php echo $value['title']?>"><img src="<?php echo $value['image']?>" alt="<?php echo $value['title']?>"></a></div>
                  <div class="details">
                    <h5><a href="<?php echo base_url("product/".$value['id']);?>"><?php echo substr($value['title'],0,20)?><?php if(strlen($value['title']) > 20) { echo "..."; }?></a></h5>
                    <h4 class="price">₹ <?php echo $value['price']?></h4>
                    <div class="add_to_cart text-center">
                        <select id="quantity_<?php echo $value['id']?>" class="product_quantity">
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                        </select>
                        <a data-product="<?php echo $value['id']?>" class="cta-btn align-middle product_<?php echo $value['id']?>" href="javascript:void(0)" onclick="add_to_cart(<?php echo $value['id']?>)">Add to Cart</a>
                        <div id="cart_result_<?php echo $value['id']?>"></div>
                    </div>    
                  </div>
                </div>
              </div>
              <?php 
              }
          } ?>
        </div>
      </div>
    </section><!-- End Team Section -->

  </main><!-- End #main -->
