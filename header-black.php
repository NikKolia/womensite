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
  <section class="cover container-fluid">
    <nav class="navbar navbar-expand-lg navbar-light fixed-top container-fluid darkMode">
      <a class="navbar-brand mr-0" href="<?php bloginfo('url')?>">
      <svg xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" width="249px" height="69px" viewBox="0 0 249 69">
  <defs>
    <path d="M0 0L44.211 0L44.211 26.0334L0 26.0334L0 0Z" transform="translate(0.0001 0.744)" id="path_1"></path>
    <path d="M0 0L22.33 0L22.33 26.6503L0 26.6503L0 0Z" transform="translate(0.9772 0.744)" id="path_2"></path>
    <path d="M0 0L28.951 0L28.951 26.0334L0 26.0334L0 0Z" transform="translate(0.7562 0.744)" id="path_3"></path>
    <path d="M0 0L18.01 0L18.01 26.6499L0 26.6499L0 0Z" transform="translate(0.156 0.744)" id="path_4"></path>
    <path d="M0 0L22.33 0L22.33 26.6503L0 26.6503L0 0Z" transform="translate(0.2979 0.744)" id="path_5"></path>
    <clipPath id="mask_1">
      <use xlink:href="#path_1"></use>
    </clipPath>
    <clipPath id="mask_2">
      <use xlink:href="#path_2"></use>
    </clipPath>
    <clipPath id="mask_3">
      <use xlink:href="#path_3"></use>
    </clipPath>
    <clipPath id="mask_4">
      <use xlink:href="#path_4"></use>
    </clipPath>
    <clipPath id="mask_5">
      <use xlink:href="#path_5"></use>
    </clipPath>
  </defs>
  <g id="Group-44" transform="translate(4.5 1.5)">
    <g id="Group-3" transform="translate(0 0.2562)">
      <path d="M0 0L44.211 0L44.211 26.0334L0 26.0334L0 0Z" transform="translate(0.0001 0.744)" id="Clip-2" fill="none" stroke="none"></path>
      <g clip-path="url(#mask_1)">
        <path d="M16.383 25.753C19.357 25.641 20.367 25.36 20.367 23.509L20.367 8.529C20.367 4.713 19.132 2.132 15.71 2.132C12.904 2.132 10.099 4.657 8.36 7.968L8.36 23.509C8.36 25.36 9.37 25.641 12.343 25.753L12.343 26.034L0 26.034L0 25.753C3.254 25.697 4.545 25.416 4.545 23.509L4.545 3.479C4.545 1.74 4.096 1.235 0 0.898L0 0.618L8.304 0.281L8.304 6.958C10.548 3.255 13.97 0 17.673 0C21.545 0 23.957 2.357 24.181 6.902C26.65 2.862 29.904 0 33.495 0C37.815 0 40.003 2.918 40.003 7.631L40.003 23.509C40.003 25.36 41.182 25.641 44.211 25.753L44.211 26.034L32.205 26.034L32.205 25.753C35.178 25.641 36.188 25.36 36.188 23.509L36.188 8.529C36.188 4.713 34.954 2.132 31.531 2.132C28.894 2.132 26.146 4.321 24.181 7.911L24.181 23.509C24.181 25.36 25.191 25.641 28.165 25.753L28.165 26.034L16.383 26.034L16.383 25.753Z" transform="translate(0.0001 0.7434)" id="Fill-logo" fill="#FEFEFE" stroke="none"></path>
      </g>
    </g>
    <g id="Group-6" transform="translate(42 0.2562)">
      <path d="M0 0L22.33 0L22.33 26.6503L0 26.6503L0 0Z" transform="translate(0.9772 0.744)" id="Clip-5" fill="none" stroke="none"></path>
      <g clip-path="url(#mask_2)">
        <path d="M12.007 0C5.274 0 0 6.565 0 13.803C0 21.601 5.162 26.651 11.839 26.651C16.552 26.651 19.974 23.565 22.33 19.918L21.938 19.637C19.637 22.835 16.776 25.36 12.849 25.36C7.575 25.36 4.04 20.872 4.04 13.466L4.04 13.41C4.04 12.737 4.04 12.119 4.096 11.446L22.274 11.446C22.611 5.331 18.796 0 12.007 0ZM18.347 10.829L4.152 10.829C4.713 4.321 7.518 0.505 11.895 0.505C16.832 0.505 18.571 4.882 18.347 10.829Z" transform="translate(0.9772 0.7433)" id="Fill-logo" fill="#FEFEFE" fill-rule="evenodd" stroke="none"></path>
      </g>
    </g>
    <g id="Group-9" transform="translate(65 0.2562)">
      <path d="M0 0L28.951 0L28.951 26.0334L0 26.0334L0 0Z" transform="translate(0.7562 0.744)" id="Clip-8" fill="none" stroke="none"></path>
      <g clip-path="url(#mask_3)">
        <path d="M0 25.753C3.254 25.697 4.545 25.416 4.545 23.509L4.545 3.479C4.545 1.74 4.096 1.235 0 0.898L0 0.618L8.304 0.281L8.304 6.958C10.548 3.255 14.027 0 17.954 0C22.443 0 24.743 2.918 24.743 7.799L24.743 23.509C24.743 25.36 25.921 25.641 28.951 25.753L28.951 26.034L16.944 26.034L16.944 25.753C19.917 25.641 20.927 25.36 20.927 23.509L20.927 8.697C20.927 4.713 19.581 2.132 15.99 2.132C13.072 2.132 10.099 4.657 8.36 7.968L8.36 23.509C8.36 25.36 9.37 25.641 12.343 25.753L12.343 26.034L0 26.034L0 25.753Z" transform="translate(0.7562 0.7434)" id="Fill-logo" fill="#FEFEFE" stroke="none"></path>
      </g>
    </g>
    <path d="M12.455 0C6.172 0 0 5.61 0 13.409C0 21.264 5.891 26.65 12.399 26.65C18.683 26.65 24.855 21.04 24.855 13.241C24.855 5.386 18.964 0 12.455 0ZM12.175 0.449C16.944 0.449 20.647 4.095 20.647 13.353C20.647 22.61 17.393 26.201 12.68 26.201C7.911 26.201 4.208 22.554 4.208 13.297C4.208 4.039 7.462 0.449 12.175 0.449Z" transform="translate(93.4722 1.0003)" id="Fill-logo" fill="#FEFEFE" fill-rule="evenodd" stroke="none"></path>
    <path d="M4.545 34.112C4.545 36.02 3.254 36.3 0 36.356L0 36.637L13.971 36.637L13.971 36.244C9.763 36.244 8.36 35.908 8.36 34L8.36 24.013C10.043 25.247 12.512 26.313 15.486 26.313C21.769 26.313 27.38 20.534 27.38 12.343C27.38 5.105 22.947 0 16.832 0C13.353 0 10.885 1.795 8.304 4.544L8.304 0.112L0 0.449L0 0.729C4.096 1.066 4.545 1.571 4.545 3.31L4.545 34.112ZM14.924 1.739C20.03 1.739 23.116 6.508 23.116 12.792C23.116 20.366 20.311 25.753 15.486 25.753C12.175 25.753 9.538 24.294 8.36 21.376L8.36 5.162C10.212 3.086 12.624 1.739 14.924 1.739Z" transform="translate(117.2612 1.1686)" id="Fill-logo" fill="#FEFEFE" fill-rule="evenodd" stroke="none"></path>
    <path d="M3.703 14.587C1.346 15.878 0 17.729 0 20.254C0 23.284 2.244 26.145 6.677 26.145C9.987 26.145 12.904 24.35 15.485 21.432L15.541 21.432C15.541 24.855 17.224 26.033 19.637 26.033C21.208 26.033 22.779 25.416 24.181 24.406L24.069 24.238C20.703 25.64 19.3 24.687 19.3 21.376L19.3 7.125C19.3 2.132 15.709 0 10.267 0C5.61 0 1.402 2.244 1.402 5.442C1.402 6.845 2.244 8.079 3.927 8.079C5.33 8.079 6.396 7.069 6.396 5.442C6.396 4.208 5.61 3.142 3.983 2.861C4.713 1.739 6.564 0.673 9.425 0.673C13.633 0.673 15.485 2.413 15.485 7.574L15.485 11.614C11.277 12.231 6.788 12.904 3.703 14.587ZM15.485 12.175L15.485 20.703C13.633 22.947 11.333 24.406 8.528 24.406C5.666 24.406 3.983 22.779 3.983 19.525C3.983 15.036 6.059 13.409 15.485 12.175Z" transform="translate(145.7636 1.2246)" id="Fill-logo" fill="#FEFEFE" fill-rule="evenodd" stroke="none"></path>
    <path d="M4.208 18.571L4.208 3.198C4.208 1.459 3.759 1.01 0 0.617L0 0.336L8.023 0L8.023 17.673C8.023 21.657 9.37 24.238 12.961 24.238C15.878 24.238 18.739 21.713 20.479 18.403L20.479 3.198C20.479 1.459 20.03 0.954 15.822 0.617L15.822 0.336L24.294 0L24.294 23.228C24.294 25.135 25.585 25.416 28.838 25.472L28.838 25.753L20.535 25.753L20.535 19.413C18.291 23.116 14.924 26.37 10.997 26.37C6.508 26.37 4.208 23.452 4.208 18.571" transform="translate(166.5782 1.2806)" id="Fill-logo" fill="#FEFEFE" stroke="none"></path>
    <g id="Group-20" transform="translate(197 0.2562)">
      <path d="M0 0L18.01 0L18.01 26.6499L0 26.6499L0 0Z" transform="translate(0.156 0.744)" id="Clip-19" fill="none" stroke="none"></path>
      <g clip-path="url(#mask_4)">
        <path d="M0 17.561L0.168 17.561C3.478 24.406 4.881 26.145 9.426 26.145C12.961 26.145 15.261 24.069 15.261 20.815C15.261 17.842 14.195 16.439 8.36 14.7C2.861 13.072 0.224 11.502 0.224 7.687C0.224 3.422 4.6 0 8.753 0C11.053 0 13.129 0.673 14.868 1.571L16.495 0L16.776 0L16.776 8.135L16.607 8.135C13.69 1.964 12.175 0.505 8.697 0.505C5.218 0.505 2.974 2.525 2.974 5.442C2.974 8.304 4.881 9.594 10.099 11.165C15.709 12.848 18.01 15.036 18.01 18.683C18.01 23.452 13.521 26.65 9.314 26.65C6.564 26.65 4.095 25.696 2.244 24.687L0.281 26.65L0 26.65L0 17.561Z" transform="translate(0.156 0.7439)" id="Fill-logo" fill="#FEFEFE" stroke="none"></path>
      </g>
    </g>
    <g id="Group-23" transform="translate(217 0.2562)">
      <path d="M0 0L22.33 0L22.33 26.6503L0 26.6503L0 0Z" transform="translate(0.2979 0.744)" id="Clip-22" fill="none" stroke="none"></path>
      <g clip-path="url(#mask_5)">
        <path d="M12.007 0C5.274 0 0 6.565 0 13.803C0 21.601 5.162 26.651 11.838 26.651C16.551 26.651 19.974 23.565 22.33 19.918L21.937 19.637C19.637 22.835 16.776 25.36 12.849 25.36C7.574 25.36 4.039 20.872 4.039 13.466L4.039 13.41C4.039 12.737 4.039 12.119 4.096 11.446L22.274 11.446C22.611 5.331 18.795 0 12.007 0ZM18.347 10.829L4.152 10.829C4.713 4.321 7.518 0.505 11.894 0.505C16.832 0.505 18.571 4.882 18.347 10.829Z" transform="translate(0.2979 0.7433)" id="Fill-logo" fill="#FEFEFE" fill-rule="evenodd" stroke="none"></path>
      </g>
    </g>
    <path d="M13.744 2.833C13.017 0.804 12.634 0.307 10.566 0.153L10.566 0L18.798 0L18.798 0.153C16.768 0.268 16.003 0.766 16.003 1.685C16.003 1.876 16.079 2.259 16.232 2.68L20.443 14.241L20.52 14.241L24.54 3.293C24.77 2.603 24.923 2.068 24.923 1.646C24.923 0.804 24.348 0.383 22.741 0.153L22.741 0L28.483 0L28.483 0.191C26.301 0.498 25.918 0.766 24.884 3.599L19.602 17.955L19.334 17.955L14.739 5.551L9.495 17.955L9.303 17.955L3.408 2.833C2.642 0.881 2.259 0.345 0 0.191L0 0L8.384 0L8.384 0.153C6.317 0.268 5.705 0.766 5.705 1.608C5.705 1.799 5.743 2.182 5.934 2.68L10.49 14.318L10.566 14.318L14.548 5.054L13.744 2.833Z" transform="translate(0.3227 41.3009)" id="Fill-logo" fill="#FEFEFE" stroke="none"></path>
    <path d="M0.153 27.258C2.297 27.182 3.101 27.029 3.101 25.727L3.101 2.106C3.101 0.919 2.795 0.574 0 0.345L0 0.153L5.704 0L5.704 14.395C7.235 11.868 9.571 9.686 12.251 9.686C15.313 9.686 16.883 11.677 16.883 15.007L16.883 25.727C16.883 26.99 17.687 27.182 19.754 27.258L19.754 27.449L11.561 27.449L11.561 27.258C13.591 27.182 14.28 26.99 14.28 25.727L14.28 15.62C14.28 12.902 13.361 11.141 10.911 11.141C8.92 11.141 6.891 12.864 5.704 15.122L5.704 25.727C5.704 26.99 6.393 27.182 8.422 27.258L8.422 27.449L0.153 27.449L0.153 27.258Z" transform="translate(27.1984 31.1939)" id="Fill-logo" fill="#FEFEFE" stroke="none"></path>
    <path d="M2.527 9.954C0.919 10.835 0 12.098 0 13.821C0 15.888 1.531 17.841 4.556 17.841C6.814 17.841 8.805 16.615 10.566 14.625L10.604 14.625C10.604 16.96 11.753 17.764 13.399 17.764C14.471 17.764 15.543 17.343 16.5 16.654L16.424 16.539C14.126 17.496 13.169 16.845 13.169 14.587L13.169 4.863C13.169 1.455 10.719 0 7.006 0C3.828 0 0.957 1.532 0.957 3.714C0.957 4.671 1.531 5.513 2.679 5.513C3.637 5.513 4.364 4.824 4.364 3.714C4.364 2.871 3.828 2.144 2.718 1.953C3.216 1.187 4.479 0.46 6.432 0.46C9.303 0.46 10.566 1.647 10.566 5.168L10.566 7.925C7.695 8.346 4.632 8.806 2.527 9.954ZM10.566 8.308L10.566 14.127C9.303 15.658 7.733 16.654 5.819 16.654C3.867 16.654 2.718 15.544 2.718 13.323C2.718 10.26 4.135 9.15 10.566 8.308Z" transform="translate(46.4551 41.0326)" id="Fill-logo" fill="#FEFEFE" fill-rule="evenodd" stroke="none"></path>
    <path d="M3.56 19.525L3.56 6.891L0 6.891L0 6.547L3.56 6.394L3.56 1.264L6.163 0L6.163 6.47L11.906 6.47L11.906 6.891L6.163 6.891L6.163 19.678C6.163 21.975 7.197 23.239 8.805 23.239C10.068 23.239 11.063 22.434 12.327 20.443L12.518 20.559C11.217 22.932 9.762 24.234 7.656 24.234C5.283 24.234 3.56 22.741 3.56 19.525" transform="translate(60.6202 34.8307)" id="Fill-logo" fill="#FEFEFE" stroke="none"></path>
    <path d="M13.744 2.833C13.017 0.804 12.634 0.307 10.566 0.153L10.566 0L18.798 0L18.798 0.153C16.768 0.268 16.003 0.766 16.003 1.685C16.003 1.876 16.079 2.259 16.232 2.68L20.443 14.241L20.52 14.241L24.54 3.293C24.77 2.603 24.923 2.068 24.923 1.646C24.923 0.804 24.348 0.383 22.741 0.153L22.741 0L28.483 0L28.483 0.191C26.301 0.498 25.918 0.766 24.884 3.599L19.602 17.955L19.334 17.955L14.739 5.551L9.495 17.955L9.303 17.955L3.408 2.833C2.642 0.881 2.259 0.345 0 0.191L0 0L8.384 0L8.384 0.153C6.317 0.268 5.705 0.766 5.705 1.608C5.705 1.799 5.743 2.182 5.934 2.68L10.49 14.318L10.566 14.318L14.548 5.054L13.744 2.833Z" transform="translate(77.043 41.3009)" id="Fill-logo" fill="#FEFEFE" stroke="none"></path>
    <path d="M8.498 0C4.211 0 0 3.828 0 9.149C0 14.509 4.02 18.184 8.461 18.184C12.748 18.184 16.959 14.356 16.959 9.034C16.959 3.675 12.939 0 8.498 0ZM8.307 0.306C11.561 0.306 14.088 2.794 14.088 9.111C14.088 15.428 11.867 17.878 8.652 17.878C5.398 17.878 2.871 15.389 2.871 9.073C2.871 2.756 5.091 0.306 8.307 0.306Z" transform="translate(103.1532 40.8804)" id="Fill-logo" fill="#FEFEFE" fill-rule="evenodd" stroke="none"></path>
    <path d="M0 17.534C2.22 17.496 3.101 17.305 3.101 16.003L3.101 2.335C3.101 1.149 2.795 0.804 0 0.574L0 0.383L5.666 0.154L5.666 4.862C6.623 2.489 8.882 0 10.988 0C12.596 0 13.399 0.919 13.399 2.144C13.399 3.216 12.596 4.096 11.676 4.096C10.566 4.096 9.839 3.369 9.839 2.374C9.839 1.761 9.992 1.34 10.413 0.804C8.729 1.034 7.006 2.757 5.704 5.398L5.704 16.003C5.704 17.305 6.47 17.496 9.227 17.534L9.227 17.725L0 17.725L0 17.534Z" transform="translate(119.6917 40.9179)" id="Fill-logo" fill="#FEFEFE" stroke="none"></path>
    <path d="M5.704 25.726C5.704 26.989 6.393 27.181 8.231 27.257L8.231 27.449L0.153 27.449L0.153 27.257C2.297 27.181 3.101 27.028 3.101 25.726L3.101 2.105C3.101 0.918 2.795 0.574 0 0.344L0 0.153L5.704 0L5.704 19.715L11.868 13.475C13.935 11.37 13.629 10.451 10.681 10.298L10.681 10.106L18.07 10.106L18.07 10.298C16.002 10.413 15.084 10.91 12.174 13.782L9.456 16.462L15.543 24.616C17.189 26.836 17.457 27.066 19.333 27.257L19.333 27.449L11.294 27.449L11.294 27.257C13.705 27.066 13.859 26.53 12.863 25.152L7.848 18.069L5.704 20.175L5.704 25.726Z" transform="translate(131.8276 31.1946)" id="Fill-logo" fill="#FEFEFE" stroke="none"></path>
    <path d="M0 11.983L0.115 11.983C2.373 16.654 3.331 17.841 6.431 17.841C8.843 17.841 10.413 16.424 10.413 14.204C10.413 12.174 9.686 11.218 5.704 10.031C1.952 8.921 0.153 7.849 0.153 5.245C0.153 2.336 3.139 0 5.972 0C7.542 0 8.959 0.46 10.145 1.072L11.256 0L11.447 0L11.447 5.552L11.332 5.552C9.341 1.34 8.307 0.345 5.934 0.345C3.56 0.345 2.029 1.723 2.029 3.714C2.029 5.666 3.331 6.547 6.891 7.619C10.719 8.767 12.289 10.26 12.289 12.749C12.289 16.003 9.226 18.185 6.355 18.185C4.479 18.185 2.795 17.534 1.531 16.845L0.191 18.185L0 18.185L0 11.983Z" transform="translate(152.1177 40.8795)" id="Fill-logo" fill="#FEFEFE" stroke="none"></path>
    <path d="M12.633 6.776C12.633 11.14 11.446 13.284 5.972 14.241L5.972 20.635L6.47 20.635L6.47 14.586C12.174 13.59 15.543 10.949 15.543 6.738C15.543 3.063 12.518 0 7.35 0C3.062 0 0 3.025 0 5.321C0 6.661 0.842 7.58 2.028 7.58C3.292 7.58 3.943 6.546 3.943 5.589C3.943 4.671 3.407 3.79 1.799 3.445C2.526 1.723 4.479 0.344 7.159 0.344C10.489 0.344 12.633 2.45 12.633 6.776ZM6.201 24.54C5.13 24.54 4.249 25.382 4.249 26.492C4.249 27.526 5.13 28.368 6.201 28.368C7.273 28.368 8.154 27.526 8.154 26.416C8.154 25.382 7.273 24.54 6.201 24.54Z" transform="translate(164.4838 30.8879)" id="Fill-logo" fill="#FEFEFE" fill-rule="evenodd" stroke="none"></path>
  </g>
</svg>

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