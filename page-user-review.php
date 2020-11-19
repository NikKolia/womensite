<?php
	global $wpdb;
	get_header('singleReview');
    $review_id = get_query_var('review_id');
    $proceed   = true;
    $treatmentQuestions = getEnumValuesFromDB('reviews_treatment_effects','question');

    $data      = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}reviews WHERE id = $review_id");
	$treatmentEffects = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}reviews_treatment_effects WHERE review_id = $review_id");
	$getSymptoms = $wpdb->get_results("SELECT {$wpdb->prefix}reviews_symptoms.symptom_id, {$wpdb->prefix}reviews_symptoms.symptom_changes,{$wpdb->prefix}posts.post_title
									FROM {$wpdb->prefix}reviews_symptoms 
									LEFT JOIN {$wpdb->prefix}posts ON {$wpdb->prefix}reviews_symptoms.symptom_id = {$wpdb->prefix}posts.id
									WHERE {$wpdb->prefix}reviews_symptoms.review_id = $review_id");
    $treatments = $wpdb->get_results("SELECT {$wpdb->prefix}reviews_treatment.*,{$wpdb->prefix}posts.post_title,p2.post_title AS parent_title FROM {$wpdb->prefix}reviews_treatment
                                    LEFT JOIN {$wpdb->prefix}posts ON {$wpdb->prefix}reviews_treatment.post_id = {$wpdb->prefix}posts.ID
                                    LEFT JOIN {$wpdb->prefix}posts AS p2 ON {$wpdb->prefix}reviews_treatment.parent_treatment = p2.ID
                                    WHERE {$wpdb->prefix}reviews_treatment.review_id = $review_id");
	// echo "<br><br><br><br><pre>";

    $post_title = $parent_title = '';
    if( !empty($treatments) ){
        $post_title = $treatments[0]->post_title;
        $parent_title = $treatments[0]->parent_title;
        $treatment_detail_id = get_field('select_multiple_subtypes',$treatments[0]->post_id);
        if( !empty($treatment_detail_id) ){
            $treatment_details = get_post( $treatment_detail_id[0] );
            $detailTitle = $treatment_details->post_title;
        }
    }

	$symptoms = array();

	if( !empty($getSymptoms) ){
		foreach( $getSymptoms as $k => $v ){
			$symptoms[$v->symptom_changes][] = $v->post_title;
		}
        $list = array('NO CHANGE','GOT WORSE','IMPROVED A LITTLE','IMPROVED A LOT','CANT TELL');
        foreach ($list as $l => $ll) {
            if( !in_array($ll, array_keys($symptoms)) ){
                $symptoms[$ll] = array();
            }
        }
	}else{
        $symptoms['NO CHANGE']         = array();
        $symptoms['GOT WORSE']         = array();
        $symptoms['IMPROVED A LITTLE'] = array();
        $symptoms['IMPROVED A LOT']    = array();
        $symptoms['CANT TELL']         = array();
    }
    // print_r($symptoms);
    // die;

	$effectsPercentage = array(
		'no change'         => array(0,'grey'),
		'got worse'         => array(33,'#F7B3B3'),
		'improved a little' => array(66,'#8EF1A9'),
		'improved a lot'    => array(100,'green'),
		'cant tell'         => array(0,'none'),
	);

	if( empty($data) ){
		$proceed = false;
	}else{
		$data = $data[0];
	}

    if( !empty($treatmentEffects) ){
        // get all the treatement effects
        $list = array_column($treatmentEffects, 'question');
        $diff = array_diff($treatmentQuestions, $list);
        if( !empty($diff) ){
            $c = count($treatmentEffects);
            foreach ($diff as $d => $dd) {
                $treatmentEffects[$c] = new stdClass();
                $treatmentEffects[$c]->question = $dd;
                $treatmentEffects[$c]->answer = 'No Change';
                $c++;
            }
        }
    }else{
        foreach ($treatmentQuestions as $tc => $tq) {
            $treatmentEffects[$tc] = new stdClass();
            $treatmentEffects[$tc]->question = $tq;
            $treatmentEffects[$tc]->answer = 'No Change';
        }
    }
    // print_r($treatmentEffects);
    // print_r($treatmentQuestions);
    // die;

?>
<?php if( $proceed ){ ?>
    <section class=''>
        <div class="singleReview mt-95 container-fluid pt-0 pb-3 whiteBg pl-0 pr-0">
            <div class="gradientOrangeBG text-center p-5">
                <h2 class="bigFont">
                    <?php echo $post_title; ?>
                </h2>
                <p class="mediumFont">
                    <?php echo ( isset($detailTitle) && strlen($detailTitle) > 0 ) ? $detailTitle : '' ; ?>
                </p>
                <p>
                    <?php echo $parent_title; ?>
                </p>
            </div>

            <section class="container-fluid mt-3 textDarkGrey">
                <div class="container-fluid borderBox review_name_wrp d-flex justify-content-between align-items-center p-3 flex-sm-column flex-md-row">
                    <div class="flex40 d-flex align-items-center justify-content-center flex-column">
                        <div>
                            <h2 class="bigFont">
                            	<?php echo ( $data->name && strlen($data->name) > 0 ) ? $data->name : 'Anonymous'; ?>
                            </h2>
                        </div>
                        <div class="ratings">
                            <div class="d-flex justify-content-center">
                            	<?php
                            		$starsHtml = '';
							    	for($i=1; $i <= 5; $i++){
							        	if( $i <= $data->rating ){
							            	$starsHtml .= '<span id="1" class="star filled">
						                                        <svg width="" height="" viewBox="0 0 71 71" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">  
						                                        <path d="M35 52.5L14.4275 63.3156L18.3565 40.4078L1.71302 24.1844L24.7138 20.8422L35 0L45.2862 20.8422L68.287 24.1844L51.6435 40.4078L55.5725 63.3156L35 52.5Z" transform="translate(0.5 0.5)" id="Star1" fill="none" stroke="#848181" stroke-opacity="0.4" stroke-width="1" />
						                                        </svg>
						                                </span>';
							        	}else{
							            	$starsHtml .= '<span id="1" class="star">
						                                        <svg width="" height="" viewBox="0 0 71 71" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">  
						                                        <path d="M35 52.5L14.4275 63.3156L18.3565 40.4078L1.71302 24.1844L24.7138 20.8422L35 0L45.2862 20.8422L68.287 24.1844L51.6435 40.4078L55.5725 63.3156L35 52.5Z" transform="translate(0.5 0.5)" id="Star1" fill="none" stroke="#848181" stroke-opacity="0.4" stroke-width="1" />
						                                        </svg>
						                                </span>';
							        	}
							    	}
							    	echo $starsHtml;
							    ?>

                            </div>
                        </div>
                    </div>
                    <div>
                        <div>
                            <p class="description">
                            	<?php echo ( $data->more_about_treatment && strlen($data->more_about_treatment) > 0 ) ? $data->more_about_treatment : 'NA'; ?>
                            </p>
                        </div>
                        <div class="date text-right">
                            <strong>
                            	<?php echo date_format(date_create($data->created),'m-d-Y'); ?>
                            </strong>
                        </div>
                    </div>
                </div>
            </section>

            <section class="container-fluid mt-3 textDarkGrey">
                <div class="container-fluid borderBox p-3">
                    <div class="text-center text-uppercase"><h2>overview</h2></div>

                    <?php if( !empty($treatmentEffects) ){  ?>
                    	<?php foreach($treatmentEffects as $k => $v){ ?>
                            <?php if( empty($v->answer) ){ $v->answer = 'no change'; } ?>
                    		<?php //if( !empty($v->answer) ){ ?>
                                <?php
                                    $cleanAnswer = strtolower( str_replace(['\'','-','_'], '', $v->answer));
                                    if ( in_array($cleanAnswer, array_keys($effectsPercentage)) ){
                                        $width = $effectsPercentage[$cleanAnswer][0];
                                        $color = $effectsPercentage[$cleanAnswer][1];
                                    }
                                ?>
	                    		<div class="row p-0 m-0 overViewSlider mt-3 align-items-center">
			                        <div class="col-sm-12 col-md-4 w-sm-65 mb-sm-10">
			                            <p class="ques mb-0"><?php echo $v->question; ?></p>
                                    </div>
                                    <div class="col-sm-12 col-md-1 text-left text-md-center w-sm-35 mb-sm-10">
                                        <?php if( $cleanAnswer == 'cant tell' ){ ?>
                                            <div class="cantTell">
                                                <span class="d-md-none">Can't Tell</span><span class="selected text-center">X</span>
                                            </div>
                                        <?php } ?>
                                    </div>
			                        <div class="col-sm-12 col-md-7">
			                            <div></div>
			                            <div class="progressWrapperBG">
                                            <div class="progressWrapper">
                                                <div class="progress">
                                                    <?php //echo $v->answer; ?>
                                                    <div class="progress-bar" role="progressbar" style="width: <?php echo $width; ?>%; background-color: <?php echo $color; ?>;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                               <span>
                                                               <?php echo $cleanAnswer; ?>
                                                               </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row p-0 m-0 overViewSlider align-items-center d-md-none">
                                                <div class="col-sm-12 col-md-12 pl-0 pr-0 smallFont">
                                                    <div class="row p-0 m-0 align-items-center">
                                                        <div class="w-25 text-center pl-0 pr-0">
                                                            No Change
                                                        </div>
                                                        <div class="w-25 text-center pl-0 pr-0">
                                                            Got Worse
                                                        </div>
                                                        <div class="w-25 text-center pl-0 pr-0">
                                                            Imporoved a little
                                                        </div>
                                                        <div class="w-25 text-center pl-0 pr-0">
                                                            Imporoved a lot
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
			                            </div>
			                        </div>
			                    </div>
		                	<?php //} ?>
                        <?php } ?>
                        <div class="row p-0 m-0 overViewSlider mt-3 align-items-center d-none d-md-flex">
                            <div class="col-sm-12 col-md-4">
                                &nbsp;
                            </div>
                            <div class="col-sm-12 col-md-1 pl-0 pr-0 smallFont">
                                <div class="row p-0 m-0 align-items-center">
                                    <div class="col-md-12 text-center pl-0 pr-0">
                                        Can't tell
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7 pl-0 pr-0 smallFont">
                                <div class="row p-0 m-0 align-items-center">
                                    <div class="col-md-3 text-center pl-0 pr-0">
                                        No Change
                                    </div>
                                    <div class="col-md-3 text-center pl-0 pr-0">
                                        Got Worse
                                    </div>
                                    <div class="col-md-3 text-center pl-0 pr-0">
                                        Imporoved a little
                                    </div>
                                    <div class="col-md-3 text-center pl-0 pr-0">
                                        Imporoved a lot
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php } else { ?>
                    	<div class="row p-0 m-0 overViewSlider mt-3 align-items-center">
                    		No Information provided
                    	</div>
                    <?php } ?>


                    <div class="text-left text-uppercase mt-3">
                        <p class="symptomChangeBlockHeading">symptom Changes</p>
                    </div>
                    <div class="row p-0 m-0 mt-3 align-items-start">
                    	<?php if( !empty($symptoms) ){ ?>
                    		<?php foreach($symptoms as $k =>$v ){ ?>
                                <?php if( !empty($k) ){ ?>
                        			<div class="col-sm-12 col-md-3 symptomChanges text-center">
    		                            <div class="symptomHeading">
    		                                <p><?php echo $k ?></p>
    		                            </div>
    		                            <div class="symptomsPill">
    		                            <?php if( is_array($v) && !empty($v) ){ ?>
    		                            	<?php foreach($v as $a => $b){ ?>
    		                            		<span><?php echo $b; ?></span>
    		                            	<?php } ?>
    		                            <?php } ?>
    		                            </div>
    		                        </div>
                                <?php } ?>
                    		<?php } ?>
                    	<?php } ?>
                    </div>

                    <div class="text-left text-uppercase mt-3">
                        <p class="symptomChangeBlockHeading">Side Effects</p>
                    </div>
                    <div class="row p-0 m-0 mt-3 align-items-center">
                        <?php if( strlen($data->side_effects) > 0 ){ ?>
                        <?php $explode = array_unique( explode(',', $data->side_effects) ); ?>
                            <?php foreach( $explode as $k => $v ){ ?>
                                <div class="col-sm-6 col-md-2 sideEffects text-center">
                                    <span>
                                        <?php echo $v; ?>
                                    </span>
                                </div>
                            <?php } ?>
                        <?php } else{ ?>
                            <div class="col-sm-6 col-md-2 sideEffects text-center">
                            No side effects
                            </div>
                        <?php } ?>
                    </div>

                    <div class="text-left text-uppercase mt-3">
                        <p class="symptomChangeBlockHeading">How long have you been taking this or did you take it?</p>
                    </div>
                    <div class="row p-0 m-0 mt-3 align-items-center">
                        <?php if( strlen($data->time_period) > 0 ){ ?>
                            <?php $explode = array_unique( explode(',', $data->time_period.' '.$data->time_unit) ); ?>
                            <?php foreach( $explode as $k => $v ){ ?>
                                <div class="col-sm-6 col-md-2 sideEffects text-center">
                                    <span>
                                        <?php echo $v; ?>
                                    </span>
                                </div>
                            <?php } ?>
                        <?php } else{ ?>
                            <div class="col-sm-6 col-md-2 sideEffects text-center">
                                NA
                            </div>
                        <?php } ?>
                    </div>

                    <div class="text-left text-uppercase mt-3">
                        <p class="symptomChangeBlockHeading">Are you still using this treatment(s)?</p>
                    </div>
                    <div class="row p-0 m-0 mt-3 align-items-center">
                        <div class="col-sm-6 col-md-2 sideEffects text-center">
                            <?php echo ($data->is_treatment_continue) ? 'Yes' : 'No'; ?>
                        </div>
                    </div>

                </div>
            </section>

            <section class="container-fluid mt-3 textDarkGrey otherMedicineContainer">
                <div class="container-flui borderBox p-3">
                    <div class="row align-items-center">
                        <div class="col-md-6 text-md-left text-uppercase text-sm-center">
                            <h2>OTHER TREATMENTS</h2>
                        </div>
                        <div class="col-md-6 otherMedicine">
                            <div class="d-flex flex-wrap">
                                <?php
                                    if( $treatments && !empty($treatments) ){
                                        array_shift($treatments);
                                    }
                                    if( !empty($treatments) ){
                                        foreach ($treatments as $k => $v) {
                                            echo '<span>'.$v->post_title.'</span>';
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="container-fluid mt-3 textDarkGrey">
                <div class="container-fluid borderBox p-3">
                    <div class="text-center text-uppercase">
                        <h2>ABOUT REVIEWER</h2>
                    </div>
                    <div class="d-flex justify-content-between align-items-start flex-sm-wrap aboutReviewer p-4">
                        <div class="d-flex justify-content-center align-items-center flex-column w-sm-50 text-center mb-sm-10 ">
                            <div>
                                <img src="<?php bloginfo('template_directory'); ?>/images/reviewAge.png" alt=""/>
                            </div>
                            <div class="cat_name">Current Age</div>
                            <div class="textColorPurple"><?php echo ( $data->age && strlen($data->age) > 0 ) ? $data->age : 'NA'; ?></div>
                        </div>
                        <div class="d-flex justify-content-center align-items-center flex-column w-sm-50 text-center mb-sm-10">
                            <div>
                                <img src="<?php bloginfo('template_directory'); ?>/images/reviewFirstSymptom.png" alt=""/>
                            </div>
                            <div class="cat_name">Age at first symptoms</div>
                            <div class="textColorPurple"><?php echo ( $data->symptoms_start_age && strlen($data->symptoms_start_age) > 0 ) ? $data->symptoms_start_age : 'NA'; ?></div>
                        </div>
                        <div class="d-flex justify-content-center align-items-center flex-column w-sm-50 text-center mb-sm-10">
                            <div>
                                <img src="<?php bloginfo('template_directory'); ?>/images/reviewLastPeriod.png" alt=""/>
                            </div>
                            <div class="cat_name">Last period?</div>
                            <div class="textColorPurple"><?php echo ( $data->last_period && strlen($data->last_period) > 0 ) ? $data->last_period : 'NA'; ?></div>
                        </div>
                        <div class="d-flex justify-content-center align-items-center flex-column w-sm-50 text-center mb-sm-10">
                            <div>
                                <img src="<?php bloginfo('template_directory'); ?>/images/reviewhasChildren.png" alt=""/>
                            </div>
                            <div class="cat_name">Has children?</div>
                            <div class="textColorPurple"><?php echo ( $data->children && strlen($data->children) > 0 ) ? 'Yes' : 'No'; ?></div>
                        </div>
                        <div class="d-flex justify-content-center align-items-center flex-column w-sm-50 text-center mb-sm-10">
                            <div>
                                <img src="<?php bloginfo('template_directory'); ?>/images/reviewEthnicity.png" alt=""/>
                            </div>
                            <div class="cat_name">Ethnicity</div>
                            <div class="textColorPurple"><?php echo ( $data->ethnicity && strlen($data->ethnicity) > 0 ) ? $data->ethnicity : 'NA'; ?></div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="container-fluid mt-3 textDarkGrey">
                <div class="container-fluid borderBox p-3 bgPurple text-white contribut_review">
                    <div class="text-center">
                        <p class="mb-0">Have you taken <?php echo $post_title; ?>?<span class="text-uppercase"> <a class="textdecoNone text-white noDecoration" href="<?php echo site_url('add-a-review'); ?>">CONTRIBUTE YOUR REVIEW</a></span></p>
                    </div>
                </div>
            </section>

        </div>
    </section>
<?php } else { ?>
	<section>
		Invalid Id pased.
	</section>
<?php } ?>

<?php get_footer(); ?>