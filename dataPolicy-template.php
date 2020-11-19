<?php /* Template Name: Data Policy Template */ ?>

<?php  get_header('inner'); ?>
  </section>
  <section id="dataPolicy" class='container-fluid orangeBg p-3'>
	<div class="dataPolicyPage mt-95 container-fluid p-3 whiteBg textColorGrey">
        <!-- Page Title -->
        <!-- <h1 class="entry-title"><?php the_title(); ?></h1>  -->
        <?php
            // TO SHOW THE PAGE CONTENTS
            while ( have_posts() ) : the_post(); ?> <!--Because the_content() works only inside a WP Loop -->
                <div class="entry-content-page">
                    <?php the_content(); ?> <!-- Page Content -->
                </div><!-- .entry-content-page -->

            <?php
            endwhile; //resetting the page loop
            wp_reset_query(); //resetting the page query
        ?>
    </div>
  </section  
    
 <?php get_footer(); ?>
