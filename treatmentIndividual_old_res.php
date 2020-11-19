<?php /* Template Name: Treatment Individual  Page*/ ?>
<?php
$page_id = get_the_ID();
if($page_id=='357' || $page_id=='359'){
    get_header('black'); 
}
else{
get_header();    
}
?>
    <?php get_template_part('includes/section', 'jumbotron'); ?>
    <?php 
        $page_id = get_the_ID();        
        switch ($page_id) {
            case '327':
                $treatment_id = 5;
                break;
            case '355':
                $treatment_id = 8;
                break;
            case '357':
                $treatment_id = 48;
                break;
            case '359':
                $treatment_id = 52;
                break;
            default:
                $treatment_id = 5;
                break;
        }

        $args = array(
            'numberposts' => -1,
            'post_type'   => 'treatments',
            'orderby'     => 'id',
            'order'       => 'ASC',
        );
        $posts = get_posts($args);

        $treatment_details_args = array(
            'numberposts' => -1,
            'post_type'   => 'treatment_details',
            'orderby'     => 'id',
            'order'       => 'ASC',
            'meta_key'    => 'select_the_type_of_treatment',
            'meta_value'  => $treatment_id,
        );
        $treatmentDetailsPost = get_posts($treatment_details_args);
        $treatmentSubTypes = array();
        
        if( !empty($treatmentDetailsPost) ){
            foreach ($treatmentDetailsPost as $key => $value) {
                $data = get_posts(
                    array(
                        'numberposts' => -1,
                        'post_type'   => 'treatment_sub_types',
                        'orderby'     => 'id',
                        'order'       => 'ASC',
                        'meta_key'    => 'select_the_type_of_treatment_detail',
                        'meta_value'  => $value->ID,
                    )
                );
                if( !empty($data) ){
                    foreach ($data as $k => $v) {
                        $medicines = get_posts(
                            array(
                                'numberposts' => -1,
                                'post_type'   => 'medicine',
                                'orderby'     => 'id',
                                'order'       => 'ASC',
                                'meta_query'  => array(
                                    array(
                                        'key'     => 'select_multiple_subtypes',
                                        'value'   => sprintf(':"%s";', $v->ID),
                                        'compare' => 'LIKE'
                                    )
                                )
                            )
                        );
                        if( !empty($medicines) ){
                            $data[$k]->medicine = $medicines;
                        }else{
                            $data[$k]->medicine = array();
                        }                        
                    }
                    $treatmentSubTypes[$value->ID] = $data;
                }
            }
        }
    ?>


    <div class="container whiteBg  pageContentDynamic treatmentIndividual p-15 p-md-4">
        <div class="row mb-2">
                <div class="col-md-8">
                    <h2>TREATMENTS</h2>
                </div>
                <div class="col-md-4">
                    <div class="input-group searchPanel">
                        <input type="text" class="form-control" placeholder="Search treatments...">
                        <div class="input-group-append">
                        <button class="btn btn-secondary lightGreyBg" type="button">
                            Search
                        </button>
                        </div>
                    </div>
                </div>    
            </div>
        <form>
            <!-- Top Dropdown -->
            <div class="form-group">            
                <select class="form-control " id="treatmentDropdown">
                    <?php foreach($posts as $post ) { ?>
                        <?php if($post->ID == $treatment_id ) { $treatmentPost = $post; } ?>
                        <?php 
                            $page_id = get_post_meta($post->ID,'link_to_page');
                            $link = get_permalink($page_id[0]);
                        ?>
                        <option data-link="<?php echo $link; ?>" <?php if($post->ID == $treatment_id ) { ?> selected <?php } ?> >
                            <?php echo $post->post_title; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <!-- Selection Result Treatment Explanation -->
            <div class="treatmentExplanation">
                <?php echo $treatmentPost->post_content; ?>
            </div>      
            
             <!-- End Selection Result Treatment Explanation -->

            <div class="spacer">&nbsp;</div>

            <div class="p-1 containerTreatment">
                <!-- Treatment Explanation Sub Details -->  
                <!-- <div class="mb-0 purpleBg ">           -->
                <div class="mb-0  ">
                    <?php if( !empty($treatmentDetailsPost) ){ ?>
                        <ul class="nav nav-tabs" id="treatmentExplanationSubSelectionHeader" role="tablist">
                            <?php foreach( $treatmentDetailsPost as $k => $v){ $id = strtolower(str_replace(' ', '-', $v->post_title)).'-'.$v->ID; ?>
                                <li class="nav-item" data-id="<?php echo $v->ID; ?>">
                                    <a class="nav-link <?php if($k == 0){ ?> active <?php } ?>" 
                                        id="<?php echo $id; ?>-tab" 
                                        data-toggle="tab" 
                                        href="#<?php echo $id; ?>" 
                                        role="tab" 
                                        aria-controls="<?php echo $id; ?>" 
                                        div-section="div-section-<?php echo $v->ID; ?>"
                                        <?php if($k == 0){ ?> aria-selected="true" <?php }else{ ?> aria-selected="false" <?php } ?> >
                                        <?php echo $v->post_title; ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>    
                    <?php } ?>
                    <?php if( !empty($treatmentDetailsPost) ){ ?>
                        <div class="tab-content treatmentExplanationSubSelection">
                            <?php foreach( $treatmentDetailsPost as $k => $v){ $id = strtolower(str_replace(' ', '-', $v->post_title)).'-'.$v->ID; ?>
                                <?php if($k == 0){ ?>                                    
                                    <div class="tab-pane fade show active" 
                                        id="<?php echo $id; ?>" 
                                        role="tabpanel" 
                                        aria-labelledby="<?php echo $id; ?>-tab" >
                                        <?php echo $v->post_content; ?>
                                    </div>
                                <?php }else{ ?>
                                    <div class="tab-pane fade" 
                                        id="<?php echo $id; ?>" 
                                        role="tabpanel" 
                                        aria-labelledby="<?php echo $id; ?>-tab" >
                                        <?php echo $v->post_content; ?>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
                <!-- End Treatment Explanation Sub Details -->

                <div class="spacer">&nbsp;</div>

                <!-- Sub Details Selection Therapy -->
                <div class="">
                    <?php if( !empty($treatmentSubTypes) ){ $count = -1; ?>
                        <?php foreach ($treatmentSubTypes as $a => $b) { $count++; ?>
                            <div class="divsections" id="div-section-<?php echo $a; ?>" style="display: <?php if( $count == 0 ){ ?>block<?php }else{ ?>none<?php } ?>;">
                                <?php if( !empty($b) ){ ?>
                                    <ul class="nav nav-tabs" id="SubDetailsSelectionTherapyHeader" role="tablist">
                                        <?php foreach($b as $c => $d){ $id = strtolower(str_replace(' ', '-', $d->post_title)).'-'.$d->ID;  ?>
                                            <li class="nav-item" data-id=<?php echo $d->ID; ?>>
                                                <?php if($c == 0){ ?>
                                                    <a class="nav-link active" id="<?php echo $id; ?>-tab" data-toggle="tab" href="#<?php echo $id; ?>" role="tab" aria-controls="<?php echo $id; ?>" aria-selected="true">
                                                        <?php echo $d->post_title; ?>
                                                    </a>
                                                <?php }else{ ?>
                                                    <a class="nav-link" id="<?php echo $id; ?>-tab" data-toggle="tab" href="#<?php echo $id; ?>" role="tab" aria-controls="<?php echo $id; ?>" aria-selected="false">
                                                        <?php echo $d->post_title; ?>
                                                    </a>
                                                <?php } ?>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                                <?php if( !empty($b) ){ ?>
                                    <div class="tab-content treatmentExplanationSubSelection">
                                        <?php foreach($b as $e => $f){ $id = strtolower(str_replace(' ', '-', $f->post_title)).'-'.$f->ID;  ?>
                                            <?php if($e == 0){ ?>                                    
                                                <div class="tab-pane fade show active" 
                                                    id="<?php echo $id; ?>" 
                                                    role="tabpanel" 
                                                    aria-labelledby="<?php echo $id; ?>-tab" >
                                                    <?php echo $f->post_content; ?>
                                            <?php }else{ ?>
                                                <div class="tab-pane fade" 
                                                    id="<?php echo $id; ?>" 
                                                    role="tabpanel" 
                                                    aria-labelledby="<?php echo $id; ?>-tab" >
                                                    <?php echo $f->post_content; ?>
                                            <?php } ?>
                                            <?php if( isset($f->medicine) && !empty($f->medicine) ){ ?>
                                                <?php $allMedicines[$f->ID] = $f->medicine; ?>
                                                <!-- <div class="row btnMedicineBlock">
                                                    <div class="col-sm-2">
                                                        &nbsp;
                                                    </div>
                                                    <div class="col-sm-8"> 
                                                        <?php 
                                                            $medicinesChunk = array_chunk($f->medicine, 3, false);
                                                            foreach( $medicinesChunk as $chunk => $medicin ){ ?>
                                                                <div class="row mb-2 align-items-center">
                                                                    <?php foreach( $medicin as $m => $n ){ ?>
                                                                        <div class="col-sm-4"> 
                                                                            <a data-medicine="<?php echo $n->ID; ?>" href="<?php echo get_permalink($n->ID); ?>" class="btn btn-light btnMedicine text-wrap">
                                                                               <span class="individualMedicineBtn"> <?php echo $n->post_title; ?><span>
                                                                            </a>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        &nbsp;
                                                    </div>
                                                </div> -->
                                            <?php } ?>
                                            </div>  
                                                                                     
                                        <?php } ?>
                                    </div>
                                   
                                <?php } ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    
                    
                    <?php if( isset($allMedicines) && !empty($allMedicines) ){ $j=0; ?>
                        <div class="container p-2">
                            <div class="p-2 pt-5 pb-5 medicineList whiteBg br-5">
                                <div class="row btnMedicineBlock">
                                    <div class="col-sm-2">
                                        &nbsp;
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="row mb-2  align-items-center">
                                            <?php foreach($allMedicines as $all => $meds ){ ?>
                                                <div id="med-<?php echo $all; ?>" class="all-medicines col-sm-12 row <?php echo ($j == 0) ? 'd-flex align-items-center' : 'd-none'; ?>">
                                                    <?php foreach( $meds as $med ){ ?>
                                                        <div class="col-sm-4 mb-2"> 
                                                            <a data-medicine="<?php echo $med->ID; ?>" href="<?php echo get_permalink($med->ID); ?>" class="btn btn-light btnMedicine textColorPurple">
                                                                <?php echo $med->post_title; ?>
                                                            </a>
                                                        </div>
                                                    <?php } $j++; ?>
                                                </div>
                                            <?php } ?>                                            
                                        </div>                                        
                                    </div>
                                    <div class="col-sm-2">
                                        &nbsp;
                                    </div>
                                </div>
                            </div>                                                       
                        </div>
                    <?php } ?>

                </div>

                    <div class="spacer">&nbsp;</div>

                    <div class="p-1">

                        <!-- Review Section -->
                        <div class="treatmentReviewSection p-2 gradientOrangeBG">
                            <div class="w-100 text-center">
                                    <h2>TREATMENT REVIEWS </h2>
                                    <h3 id="treatment-name"></h3>
                            </div>
                            <div class="w-100 text-center mt-5">
                                <button type="button" class="btn btn-light btnMedicine">Filter by </button>
                            </div>

                            <div class="spacer">&nbsp;</div>

                            <div class="container singleReviewBoxTreatment">
                                <div class="d-flex justify-content-between align-items-start flex-wrap singleContainer" id="filter-box">
                                    
                                </div>                                
                            </div>  
                            <div class="spacer">&nbsp;</div>
                            <div class="w-100 text-center mt-5">
                                <a id="see-more-anchor" href="<?php echo site_url('search-reviews').'/?treatment_ids='.$treatment_id.'&page=0'; ?>" class="textdecoNone text-white btn btn-outline-secondary btnMedicine">
                                    See More
                                </a>
                            </div>  
                        </div>
                        <!-- end Review Section -->
                    
                    </div>
                
                <!-- </div> -->
        </form>        
    </div>    
    <div class="w-100 mt-2 bottomText p-1 mb-2">
        <p>The information on this website is NOT intended to endorse any particular medication. While these reviews might be helpful, they are not a substitute for the expertise, skill, knowledge and judgement of healthcare professionals. They ARE intended to help you become a more informed patient.<p>
    </div>  
    </div>   
    
    
</div>  

<?php get_footer(); ?>