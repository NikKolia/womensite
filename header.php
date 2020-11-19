<!doctype html>

<html <?php language_attributes(); ?>>
<head>
  <!-- Required meta tags -->
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title><?php bloginfo('name'); ?></title>
  <meta name="description" content="Menopause">
  <meta name="author" content="Menopause">

  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="57x57" href="<?php bloginfo('template_directory'); ?>/images/favicon/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="<?php bloginfo('template_directory'); ?>/images/favicon/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="<?php bloginfo('template_directory'); ?>/images/favicon/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="<?php bloginfo('template_directory'); ?>/images/favicon/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="<?php bloginfo('template_directory'); ?>/images/favicon/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="<?php bloginfo('template_directory'); ?>/images/favicon/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="<?php bloginfo('template_directory'); ?>/images/favicon/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="<?php bloginfo('template_directory'); ?>/images/favicon/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="<?php bloginfo('template_directory'); ?>/images/favicon/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="<?php bloginfo('template_directory'); ?>/images/favicon/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?php bloginfo('template_directory'); ?>/images/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="<?php bloginfo('template_directory'); ?>/images/favicon/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?php bloginfo('template_directory'); ?>/images/favicon/favicon-16x16.png">
  <link rel="manifest" href="<?php bloginfo('template_directory'); ?>/images/favicon/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="<?php bloginfo('template_directory'); ?>/images/favicon/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">
  <!-- end FavIcon -->

  <?php 
    $url            = site_url();
    $fb_title       = !empty(vira_get_theme_option('fb_title')) ? vira_get_theme_option('fb_title') : 'Menopause';
    $fb_description = !empty(vira_get_theme_option('fb_description')) ? vira_get_theme_option('fb_description') : 'Menopause';
    $fb_image       = $url.'/wp-content/uploads/2020/04/HomeBanner-1.jpeg';
  ?>
  <meta property="og:type" content="article">
  <meta property="og:title" content="<?php echo $fb_title; ?>">
  <meta property="og:description" content="<?php echo $fb_description; ?>">
  <meta property="og:url" content="<?php echo $url; ?>">
  <meta property="og:image" content="<?php echo $fb_image; ?>">

  <!-- Wordpress Header -->
  <?php wp_head(); ?>

  <style>
  .cover{    
    background: #2b2d34 url(<?php the_field('background_image'); ?>) center;
    background-size: cover;
  }
  </style>
    <script type="text/javascript">
        var ajaxURL = '<?php echo site_url().'/wp-admin/admin-ajax.php'; ?>';
        var templateURL = '<?php echo get_template_directory_uri(); ?>';
        var pageId = <?php echo isset($posts[0]) ? $posts[0]->ID : 'null'; ?>;
    </script>
</head>

<body <?php body_class(); ?>>
  <section class="cover container-fluid" class="uk-animation-fade" uk-parallax="blur: 10">
    <nav class="navbar navbar-expand-lg navbar-light fixed-top container-fluid">
      <a class="navbar-brand mr-0" href="<?php bloginfo('url')?>">
          <img src="<?php bloginfo('template_directory'); ?>/images/mwwLogo.svg" alt="MWW logo" />
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
    <?php /* Primary navigation */
    wp_nav_menu( array(
      'menu' => 'top_menu',
      'depth' => 2,
      'container' => false,
      'menu_class' => 'navbar-nav ml-auto mt-2 mt-lg-0 text-uppercase',
      //Process nav menu using our custom nav walker
      'walker' => new wp_bootstrap_navwalker())
    );
    ?>
    </div>
    </nav>