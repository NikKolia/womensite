<?php /* Template Name: Search review */ ?>
<?php get_header('singleReview'); ?>
<?php
    $args = array(
        'numberposts' => -1,
        'post_type'   => 'treatments',
        'orderby'     => 'title',
        'order'       => 'ASC',
    );
    $treatments = get_posts($args);
    $jsonArray = [];
    // echo "<br><br><br><br><br><pre>";
    foreach ($treatments as $key => $value) {
        $data = get_posts(
            array(
                'numberposts' => -1,
                'post_type'   => 'treatment_details',
                'orderby'     => 'title',
                'order'       => 'ASC',
                'meta_key'    => 'select_the_type_of_treatment',
                'meta_value'  => $value->ID,
            )
        );
        foreach ($data as $k => $v) {
            $subtypedata = get_posts(
                array(
                    'numberposts' => -1,
                    'post_type'   => 'treatment_sub_types',
                    'orderby'     => 'title',
                    'order'       => 'ASC',
                    'meta_key'    => 'select_the_type_of_treatment_detail',
                    'meta_value'  => $v->ID,
                )
            );
            $jsonArray[$value->ID]['details'][$v->ID]['title'] = $v->post_title;
            foreach ($subtypedata as $i => $j) {
                $medicines = get_posts(
                    array(
                        'numberposts' => -1,
                        'post_type'   => 'medicine',
                        'orderby'     => 'title',
                        'order'       => 'ASC',
                        'suppress_filters' => false,
                        'meta_query'  => array(
                            array(
                                'key'     => 'select_multiple_subtypes',
                                'value'   => sprintf(':"%s";', $j->ID),
                                'compare' => 'LIKE'
                            )
                        )
                    )
                );
                $jsonArray[$value->ID]['details'][$v->ID]['subtype'][$j->ID]['title'] = $j->post_title;
                $jsonArray[$value->ID]['details'][$v->ID]['subtype'][$j->ID]['medicines'] = array_combine(array_column($medicines, 'ID'), array_column($medicines, 'post_title'));
            }
        }
    }
    $ethnicity =  !empty(vira_get_theme_option('ethnicity')) ? vira_get_theme_option('ethnicity') : '';
    asort($ethnicity);
?>
<script type="text/javascript">
    var filterData = '<?php echo json_encode($jsonArray); ?>';
</script>
    <section class=''>
        <div class="searchReview mt-95 container-fluid pb-3 whiteBg pl-0 pr-0">
            <div class="gradientOrangeBG text-center p-sm-1 pt-4 p-md-5">
                <h2 class="bigFont text-uppercase">search reviews </h2>
                <p class="mediumFont text-uppercase">find out what other women said</p>

                <div class="spacer py-3">&nbsp;</div>
                    <div class="singleReviewBoxTreatment m-auto row w-lg-75">

                        <div class="col-sm-12 col-md-4 mb-sm-10 caret_wraper" id="filters-div">
                            <select name="treatment" placeholder="Treatment Type" id="treatment-type-filter" class=" textColorPurple  form-control form-control-lg">
                                <?php if( !empty($treatments) ){ ?>
                                    <option value="">Category</option>
                                    <?php foreach($treatments as $k => $v ){ ?>
                                        <option value="<?php echo $v->ID; ?>">
                                            <?php echo $v->post_title; ?>
                                        </option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-sm-12 col-md-4 mb-sm-10 caret_wraper" id="filters-div2">
                        </div>

                        <div class="col-sm-12 col-md-4 mb-sm-10 multiselect_wrp demographics">
                            <select multiple="true" id="filters" placeholder="Demographics" class=" textColorPurple   form-control form-control-lg" name="filters">
                                <optgroup label="Age">
                                    <option value="age:<40">Under 40 years of age</option>
                                    <option value="age:41-50">41-50 years of age</option>
                                    <option value="age:>51">Over 50 years of age</option>
                                </optgroup>
                                <optgroup label="Periods">
                                    <option value="periods:<12">Still having periods</option>
                                    <option value="periods:>12">More than 12 months since last period</option>
                                </optgroup>
                                <optgroup label="Induced menopause">
                                    <option value="menopause:1">Induced menopause</option>
                                    <option value="menopause:0">Natural menopause</option>
                                </optgroup>
                                <optgroup label="Children">
                                    <option value="children:1">Had children</option>
                                    <option value="children:0">Did not have children</option>
                                </optgroup>
                                <optgroup label="Ethnicity">
                                    <?php if( !empty($ethnicity) ){ ?>
                                        <?php foreach($ethnicity as $k => $v){ ?>
                                            <option value="ethnicity:<?php echo $v; ?>"><?php echo $v; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </optgroup>
                            </select>
                        </div>

                    </div>

                <div class="spacer">&nbsp;</div>

                <div class="container-fluid singleReviewBoxTreatment textColorGrey text-left">
                    <div id="filter-tags" class="searchReviewsFilter bg-white p-3 br-5 d-flex align-items-center justify-content-between flex-md-row flex-sm-column">
                        <div class="w-90 w-sm-100" id="filter-labels">
                            <label id="box1" class="custom-control-label selected br-5 font-weight-bold mb-1 mt-1" style="display: none;">

                            </label>
                            <label id="box2" class="custom-control-label selected br-5 font-weight-bold mb-1 mt-1" style="display: none;">

                            </label>
                        </div>
                        <div class="w-10 w-sm-100">

                            <span id="box4" class="custom-control-label selected br-5 font-weight-bold float-right">

                            </span>
                        </div>
                    </div>
                </div>

                <div class="spacer">&nbsp;</div>
                <div class="container-fluid m-auto row w-75 p-3 justify-content-center">
                        <button type="button" class="btn btn-light btnMedicine textColorPurple " id="filter-button">
                            Filter
                        </button>
                    </div>
                <div class="spacer">&nbsp;</div>
                <div class="container-fluid singleReviewBoxTreatment textColorGrey text-left">
                    <!-- Loader -->
                    <!-- <div class="d-flex align-items-center justify-content-center w-100">
                        <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                    </div> -->
                    <!-- Loader End -->
                    <div id="filter-box" class="d-flex justify-content-between  flex-wrap singleContainer">
                    </div>

                </div>
                <div class="spacer">&nbsp;</div>


                <div class="container-fluid singleReviewBoxTreatment">
                    <span class="seemore seemore_btn" id="more">
                        <strong>See More... </strong>
                    </span>
                </div>

            </div>
    </section>
<?php get_footer(); ?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        var params = getUrlParams();
        if( params ){
            if(!params.pagenum){
                params.pagenum = 0;
            }
            getReviews(params);
            constructFilters(params.treatment_ids,'detail');
            if( params.subtype_id && params.subtype_id != '' ){
                jQuery('.treatment-sub-type-filter option[value="'+params.subtype_id+'"]').prop('selected',true).change();
            }else{
                jQuery('#filters-div2').html(addBlankSelectBox());
            }
            var text = jQuery('#treatment-type-filter option[value="'+params.treatment_ids+'"]').text();
            text     = jQuery.trim(text);
            if(text != ''){
                jQuery('#box1').html(text+'<button type="button" class=" ml-3  btnCustom p-0"><img class="" src="'+templateURL+'/images/removeCircle.svg"/></button>').show();
            }
            jQuery('#treatment-type-filter option[value="'+params.treatment_ids+'"]').prop('selected',true);
        }else{
            var val  = jQuery('#treatment-type-filter option:first-child').val();
            // var text = jQuery('#treatment-type-filter option:first-child').text();
            // text     = jQuery.trim(text);
            // jQuery('#box1').html(text+'<button type="button" class=" ml-3  btnCustom p-0"><img class="" src="'+templateURL+'/images/removeCircle.svg"/></button>');
            jQuery('#filters-div2').html(addBlankSelectBox());
            constructFilters(val,'detail');
            getReviews({'treatment_ids':val,'pagenum':0});
        }
                
    });
    
</script>