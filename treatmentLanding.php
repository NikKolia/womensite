<?php /* Template Name: Treatment Landing Page */ ?>
<?php get_header('black'); ?>    
    <?php get_template_part('includes/section', 'jumbotron'); ?>
    <?php 
        $args = array(
            'numberposts' => -1,
            'post_type'   => 'treatments',
            'orderby'     => 'id',
            'order'       => 'ASC',
        );
        $posts = get_posts($args);
        if ( !empty($posts) ){
            $posts = array_chunk($posts, 2, false);
        }
    ?>
    <div class="container-fluid whiteBg overflow-hidden treatmentLanding pageContentDynamic p-15 p-md-4">
        <div class="row mb-2">
            <div class="col-md-8">
                <h2>TREATMENT OPTIONS</h2>
            </div>
            <div class="col-md-4 mb-2">
                <div class="input-group searchPanel">
                <div class="input-group-append">
                    <button class="" type="button" id="search-button">
                        Search treatments
                    </button>
                    </div>
                    <input id="search-treatment" type="text" class="form-control" placeholder="Start Typing...">
                    
                </div>
            </div>    
        </div>
        <?php 
            $page = get_post(get_the_ID());            
            echo $page->post_content;
        ?>
        <!-- <p class="treatmentLanding mb-4">
        Your healthcare professional should help you understand the different treatment options to help identify which ones may be best for you. This guidance is evidence based but specific to you. Always discuss any questions related to your individual treatment with a health professional.</p> -->

        <?php if( !empty($posts) ){ ?>
            <?php foreach($posts as $key => $post){ ?>                
                <div class="row mb-2">
                    <?php foreach($post as $k => $v){ ?>
                        <div class="col-sm-6">
                            <?php 
                                $page_id = get_post_meta($v->ID,'link_to_page');
                                $link = get_permalink($page_id[0]);
                            ?>
                            <a href="<?php echo $link; ?>" class="btn btn-outline-secondary w-100 my-4">
                                <?php echo $v->post_title; ?>
                            </a>
                            <p class="mt-2">
                                <?php echo $v->post_excerpt; ?>
                            </p>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        <?php } ?>                 
    </div>
<?php get_footer(); ?>