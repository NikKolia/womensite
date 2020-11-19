<?php /* Template Name: How-it-works Template */ ?>
<?php get_header(); ?>    
    <?php get_template_part('includes/section', 'jumbotron'); ?> 
    
<section id="how-it-works" class='whiteBg pb-3 container pr-0 pl-0'>
    <div class="container p-3 textColorGrey">
        <div class="purpleBg p-sm-1 p-md-2 br-5">
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
    </div>

    <div class="container p-3 orangeBg textColorGrey ">
        
        <div class="accordianContainer container bg-white p-sm-2 p-md-4">
        <div><h2 class="textColorPurple">FAQs</h2></div>
        <div><p class="textColorGrey">Have another question? <a href="mailto:email.com" class="textdecoNone textColorGrey"> Email us</a></p></div>
            <?php 
                $args = array(
                    'numberposts' => -1,
                    'post_type'   => 'faq',
                    'orderby'     => 'id',
                    'order'       => 'ASC',
                );
                $faqs = get_posts($args);
            ?>
            <?php if( !empty($faqs) ){ ?>
                <?php foreach($faqs as $f => $faq ){ ?>
                    <div class="accordion" id="FaqQuestion<?php echo $f; ?>">
                        <div>
                            <div class="cursorPointer" id="heading<?php echo $f; ?>" data-toggle="collapse" data-target="#Q<?php echo $f; ?>">
                                <h2 class="mb-0">
                                    <button type="button" class="btn btn-link textColorPurple font-weight-bold ">
                                        <?php echo $faq->post_title; ?>
                                    </button>
                                    <span class="icon">
                                        <img src="<?php bloginfo('template_directory'); ?>/images/FaqTriangle.png" alt="" />
                                    </span>
                                </h2>
                            </div>
                            <div id="Q<?php echo $f; ?>" class="collapse" aria-labelledby="heading<?php echo $f; ?>" data-parent="#FaqQuestion<?php echo $f; ?>">
                                <div class="card-body">
                                    <p><?php echo $faq->post_content; ?></p>
                                </div>
                            </div>
                        </div>                
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div>
                    FAQs coming soon.
                </div>
            <?php } ?>          
        </div>    
    </div>
</section>
<?php get_footer(); ?>