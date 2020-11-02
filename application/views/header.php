<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?php echo $page_title; ?></title>
  <meta name="description" content="<?php echo $page_description; ?>">
  <!-- Favicons -->
  <link href="<?php echo base_url(assets_img);?>/favicon.png" rel="icon">
  <link href="<?php echo base_url(assets_img);?>/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800|Montserrat:300,400,700" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?php echo base_url(assets_vendor);?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url(assets_vendor);?>/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?php echo base_url(assets_vendor);?>/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?php echo base_url(assets_css);?>/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Reveal - v2.1.0
  * Template URL: https://bootstrapmade.com/reveal-bootstrap-corporate-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Top Bar ======= -->
  <section id="topbar" class="d-none d-lg-block">
    <div class="container clearfix">
      <div class="contact-info float-left">
        <i class="fa fa-envelope-o"></i> <a href="mail-to:devendra.b@fyntune.com"><span>devendra.b@fyntune.com</span></a>
        <i class="fa fa-phone"></i> <span>+91-9987 451 093</span>
      </div>
      <div class="social-links float-right">
        <a href="<?php echo base_url('cart') ?>" class="cart"><span class="count"><?php echo $count;?></span> <i class="fa fa-cart-arrow-down"></i></a>
      </div>
    </div>
  </section><!-- End Top Bar-->

  <!-- ======= Header ======= -->
  <header id="header">
    <div class="container">

      <div id="logo" class="pull-left">
        <h1><a href="<?php echo base_url();?>"><img src="<?php echo base_url(assets_img).'/logo.png';?>"/></a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt=""></a>-->
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li><a href="<?php echo base_url();?>">Products</a></li>
          <li><a href="<?php echo base_url('cart');?>">Cart</a></li>
          <?php if(!empty($this->session->userdata('logged_in')))
          {
              echo "<li><a href='".base_url('logout')."'>Logout</a></li>";
          }
          ?>  
        </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </header><!-- End Header -->