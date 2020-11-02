  <main id="main">
    <!-- ======= Single Product ======= -->
    <section id="team" class="wow fadeInUp">
      <div class="container">
        <div class="section-header">
        </div>
        <div class="row">
              <div class="col-lg-6 col-md-6">
                <div class="member product-info">
                  <div class="pic"><img src="<?php echo $product['detail']['image']?>" alt="<?php echo $product['detail']['title']?>"></div>
                </div>
              </div>
              <div class="col-lg-6 col-md-6">
                <div class="member product-info">
                  <div class="details">
                    <h5><?php echo $product['detail']['title']; ?></h5>
                    <h4 class="price">₹ <?php echo $product['detail']['price']?></h4>
                    <p><?php echo $product['detail']['description']?></p>
                    <p>Category : <?php echo $product['detail']['category']?></p>
                    <select id="quantity_<?php echo $product['detail']['id']?>" class="product_quantity">
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                    </select>
                    <a data-product="<?php echo $product['detail']['id']?>" class="cta-btn align-middle product_<?php echo $product['detail']['id']?>" href="javascript:void(0)" onclick="add_to_cart(<?php echo $product['detail']['id']?>)">Add to Cart</a>
                        <div id="cart_result_<?php echo $product['detail']['id']?>"></div>
                  </div>
                </div>
              </div>
        </div>
      </div>
    </section><!-- End Single Product -->

  </main><!-- End #main -->
