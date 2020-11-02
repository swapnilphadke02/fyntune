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
                  <div class="pic"><img src="<?php echo $value['image']?>" alt="<?php echo $value['title']?>"></div>
                  <div class="details">
                    <h5><?php echo substr($value['title'],0,20)?>...</h5>
                    <h4>₹ <?php echo $value['price']?></h4>
                    <a class="cta-btn align-middle" href="#">Add to Cart</a>
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
