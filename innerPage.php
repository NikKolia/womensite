<?php /* Template Name: Inner Page without Header Image */ ?>

<?php 
  if( is_page('add-a-review') || is_page('reviews')){    
    get_header('inner');
  }
  else{
    get_header();
  }
  ?>
  
 <?php get_template_part('includes/section', 'jumbotronWithoutImg'); ?>      
 <?php get_footer(); ?>
</section>


