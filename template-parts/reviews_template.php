<input type="hidden" class="total_reviews" value="<?php echo $total; ?>" >
<input type="hidden" class="showmore" value="<?php echo $showmore; ?>" >
<!-- <?php print_r ($data); ?> -->

<?php if( !empty($data) ){ ?>
    <?php foreach($data as $k => $v){ ?>
        <?php
        global $wpdb;
        $review_id = $v->id;
        $treatments = $wpdb->get_results("SELECT {$wpdb->prefix}reviews_treatment.*,{$wpdb->prefix}posts.post_title,p2.post_title AS parent_title FROM {$wpdb->prefix}reviews_treatment
                                    LEFT JOIN {$wpdb->prefix}posts ON {$wpdb->prefix}reviews_treatment.post_id = {$wpdb->prefix}posts.ID
                                    LEFT JOIN {$wpdb->prefix}posts AS p2 ON {$wpdb->prefix}reviews_treatment.parent_treatment = p2.ID
                                    WHERE {$wpdb->prefix}reviews_treatment.review_id = $review_id");
        // echo "<br><br><br><br><pre>";

        $post_title = $parent_title = '';
        if( !empty($treatments) ){
            $post_title = $treatments[0]->post_title;
            //$parent_title = $treatments[0]->parent_title;
            $treatment_detail_id = get_field('select_multiple_subtypes',$treatments[0]->post_id);
            if( !empty($treatment_detail_id) ){
                $treatment_details = get_post( $treatment_detail_id[0] );
                $detailTitle = $treatment_details->post_title;
            }
        }

        // print_r($treatments);
        // die;

        ?>
        <div class="singleReviewBox mb-4 p-2">
            <a class="textdecoNone textColorGrey d-flex flex-column h-100 justify-content-between" style="min-height:inherit" href="<?php echo site_url('/user-review/').$v->id; ?>">
                <div>
                    <div class="d-flex justify-content-between flex-sm-column flex-md-row">
                        <div class="font-weight-bold mb-sm-10">
                            <!-- <p><?php echo $v->post_title; ?></p> -->
                            <p><?php echo ( isset($post_title) && strlen($post_title) > 0 ) ? $post_title : 'NA'; ?></p>
                            <!-- <p><?php echo ( isset($detailTitle) && strlen($detailTitle) > 0 ) ? $detailTitle : '' ; ?></p> -->
                            <!-- <p><?php echo $parent_title; ?></p> -->
                        </div>
                        <div class="ratings">
                            <div class="d-flex justify-content-center">
                                <?php echo getStars($v->rating); ?>
                            </div>
                        </div>
                    </div>
                    <div class="mute">
                        <?php 
                            $date = date_format(date_create($v->created),'d/m/Y');
                            echo (strlen($v->name) > 0) ? ucfirst($v->name).', '.$date : 'Anonymous, '.$date;
                            /* if( isset($v->name) && strlen(isset($v->name)) > 0 ){
                                echo ucfirst($v->name).', '.$date;
                            }else {
                                echo 'Anonymous, '.$date;
                            } */
                        ?>
                    </div>
                </div>
                
                <div>
                    <p>
                        <?php
                            displayTreatmentText(stripslashes($v->about_treatment));
                        ?>
                    </p>
                </div>
                <?php if( $side_effects ){ ?>
                    <?php if( !empty($v->side_effects) && strlen($v->side_effects) > 0 ){ ?>
                        <?php $sd = explode(',', $v->side_effects); ?>
                        <div class="listTagsSingleMedicine d-flex flex-wrap">
                            <?php foreach( $sd as $s ){ ?>
                                <span><?php echo $s; ?></span>
                            <?php } ?>
                        </div>
                    <?php } ?>
                <?php } ?>
                <div class="text-right">
                    <strong>
                        <span class=" textColorGrey" >read more</span>
                    </strong>
                </div>
            </a>
        </div>
    <?php } ?>
<?php }else{ ?>
    <div class="text-white">No Reviews Found</div>
<?php } ?>
