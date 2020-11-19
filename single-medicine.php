<?php /* Template Name: Single Medicine */ ?>

<?php get_header('singleReview'); ?>

<?php
	global $wpdb;
	$id = get_the_ID();
	$post = get_post($id);
	$postmeta = get_post_meta($id);
	$subtypeId = $postmeta['select_multiple_subtypes'];
	
	if( !empty($subtypeId) && isset($subtypeId) ){
		$subtype_id = unserialize($subtypeId[0]);
		$subtype_id = $subtype_id[0];
		$subtype = get_post($subtype_id);
		$subtype_postmeta = get_post_meta($subtype_id);
		
		$treatmentId = $subtype_postmeta['select_the_type_of_treatment_detail'][0];
		$mainTreatmentId = get_post_meta($treatmentId,'select_the_type_of_treatment');
		$mainTreatmentId = $mainTreatmentId[0];
		$treatment = get_post($mainTreatmentId);
	}

	$getReviews = $wpdb->get_results("SELECT review_id FROM {$wpdb->prefix}reviews_treatment WHERE post_id = $id");
	$averageRating = $totalReviews = 0;
	if( !empty($getReviews) ){
		$review_ids = array_column($getReviews, 'review_id');
		$implode = implode(',', $review_ids);
		$totalReviews = count($review_ids);
		$ratingsQuery = $wpdb->get_results("SELECT count(*) AS total_ratings, rating FROM {$wpdb->prefix}reviews WHERE id IN ($implode) GROUP BY rating");
		$ratingsSum = $numOfRatings = 0;
		foreach ($ratingsQuery as $key => $value) {
			$ratingsSum += ($value->total_ratings*$value->rating);
			$numOfRatings += $value->total_ratings;
		}
		if( $ratingsSum > 0 && $numOfRatings > 0 ){
			$averageRating = round($ratingsSum/$numOfRatings);
		}
	}
?>

<section class='container-fluid whiteBg'>
	<div class="singleMedicine mt-95 container-fluid pt-4 pb-3 whiteBg ">
		<div class="gradientOrangeBG text-center p-5 br-5">
			<h2 class="bigFont textColorPurple"><?php echo $post->post_title; ?></h2>
			<p class="mediumFont"><?php echo $subtype->post_title; ?></p>
			<p><?php echo $treatment->post_title; ?></p>
			<div class="ratings">
				<div class="d-flex justify-content-center">
					<?php if( $averageRating > 0 ) { ?>
						<?php echo getStars($averageRating); ?>
					<?php } ?>    
				</div>
			</div>
			<button class="btnCustom  text-white p-0 mt-2 font-weight-bold cookiesClass ">
				<span>
					<?php 
						if($totalReviews > 0) {
							echo 'Based on '.$totalReviews.' reviews';
						}else{
							echo 'No Reviews Yet';
						}
					?>					
				</span>
			</button>
		</div>
	</div>

	<section>
		<div class="container-fluid pt-3 pb-3 whiteBg">
			<div class="p-4 borderBox textColorGrey">
				<div class="text-center text-uppercase textColorPurple"><h2>Medical Information</h2></div>
				<div class="spacer">&nbsp;</div>
				<div class="text-left textColorGrey">
					<?php echo $post->post_content; ?>
				</div>
			</div>
		</div>
	</section>
	<section class="container-fluid mt-3 textDarkGrey mb-3">
		<div class="container-fluid borderBox p-3 bgPurple text-white">
			<div class="text-center">
				<p class="mb-0">Have you taken <?php echo $post->post_title; ?>?
					<span class="text-uppercase"><a class="textdecoNone text-white noDecoration" href="<?php echo site_url('add-a-review'); ?>">CONTRIBUTE YOUR REVIEW</a></span>
				</p>
			</div>
		</div>
	</section>  
	
	<section class=''>
        <div class="searchReview container-fluid pt-3 pb-3 whiteBg ">
            <div class="gradientOrangeBG text-center p-sm-1 p-md-2 br-5">
                <h2 class="bigFont text-uppercase">search reviews </h2>
                <p class="mediumFont text-uppercase">find out what other women said</p>               

                <div class="spacer">&nbsp;</div>
                    <div class="container-fluid singleReviewBoxTreatment m-auto row w-25 common_select">                 
                        <div class="col-sm-12">
                            <!-- <select class="form-control form-control-lg">
                                <option>Large select</option>
                            </select> -->
                        </div>
                    </div>
                <div class="spacer">&nbsp;</div>

                <div class="container-fluid singleReviewBoxTreatment textColorGrey text-left">
                    <div id="filter-box" class="d-flex justify-content-between align-items-start flex-wrap singleContainer">
                        
                    <!--     <div class="singleReviewBox mb-4 p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="mediumFont">Name of Treatment</div>
                                <div>
                                <div class="ratings">
                                    <div class="d-flex justify-content-center">
                                        <span id="1" class="star star1 filled">
                                            <svg width="" height="" viewBox="0 0 71 71" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">  
                                            <path d="M35 52.5L14.4275 63.3156L18.3565 40.4078L1.71302 24.1844L24.7138 20.8422L35 0L45.2862 20.8422L68.287 24.1844L51.6435 40.4078L55.5725 63.3156L35 52.5Z" transform="translate(0.5 0.5)" id="Star1" fill="none" stroke="#848181" stroke-opacity="0.4" stroke-width="1" />
                                            </svg>
                                            </span>      
                                            <span id="2" class="star star2 filled">
                                                    <svg width="" height="" viewBox="0 0 71 71" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">  
                                                    <path d="M35 52.5L14.4275 63.3156L18.3565 40.4078L1.71302 24.1844L24.7138 20.8422L35 0L45.2862 20.8422L68.287 24.1844L51.6435 40.4078L55.5725 63.3156L35 52.5Z" transform="translate(0.5 0.5)" id="Star2" fill="none" stroke="#848181" stroke-opacity="0.4" stroke-width="1" />
                                                    </svg>
                                            </span>      
                                            <span id="3" class="star star3 filled">
                                                    <svg width="" height="" viewBox="0 0 71 71" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">  
                                                    <path d="M35 52.5L14.4275 63.3156L18.3565 40.4078L1.71302 24.1844L24.7138 20.8422L35 0L45.2862 20.8422L68.287 24.1844L51.6435 40.4078L55.5725 63.3156L35 52.5Z" transform="translate(0.5 0.5)" id="Star3" fill="none" stroke="#848181" stroke-opacity="0.4" stroke-width="1" />
                                                    </svg>
                                            </span>      
                                            <span id="4" class="star star4 filled">
                                                    <svg width="" height="" viewBox="0 0 71 71" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">  
                                                    <path d="M35 52.5L14.4275 63.3156L18.3565 40.4078L1.71302 24.1844L24.7138 20.8422L35 0L45.2862 20.8422L68.287 24.1844L51.6435 40.4078L55.5725 63.3156L35 52.5Z" transform="translate(0.5 0.5)" id="Star4" fill="none" stroke="#848181" stroke-opacity="0.4" stroke-width="1" />
                                                    </svg>
                                            </span>      
                                            <span id="5" class="star star5">
                                                    <svg width="" height="" viewBox="0 0 71 71" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">  
                                                    <path d="M35 52.5L14.4275 63.3156L18.3565 40.4078L1.71302 24.1844L24.7138 20.8422L35 0L45.2862 20.8422L68.287 24.1844L51.6435 40.4078L55.5725 63.3156L35 52.5Z" transform="translate(0.5 0.5)" id="Star5" fill="none" stroke="#848181" stroke-opacity="0.4" stroke-width="1" />
                                                    </svg>
                                            </span>      
                                        </div>
                                    </div>
                                </div>
                            </div>                                    
                            <div class="listTags">Name, 06/04/2020</div>
                            <div class="spacer">&nbsp;</div>
                            <div>
                                <p>My hot flashes took over my life —I wasn’t sleeping, I couldn’t concentrate at work, I was irritable at home with my kids. I went on HRT and within 10 days I felt so much better. My hot flashes had decreased substantially, I was sleeping better, I was productive at work, happier at home. I felt like myself again. After 3 weeks on HRT, I hardly ever  get a hot flash. I have more energy and I feel joyful about my life.</p>
                            </div>
							<div class="listTagsSingleMedicine d-flex flex-wrap">
								<span>Hot flushes</span>
								<span>Hot flushes</span>								
								<span>Hot flushes</span>
								<span>Hot flushes</span>
							</div>
                        </div>
                        <div class="singleReviewBox mb-4 p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="mediumFont">Name of Treatment</div>
                                <div>
                                <div class="ratings">
                                    <div class="d-flex justify-content-center">
                                        <span id="1" class="star star1 filled">
                                            <svg width="" height="" viewBox="0 0 71 71" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">  
                                            <path d="M35 52.5L14.4275 63.3156L18.3565 40.4078L1.71302 24.1844L24.7138 20.8422L35 0L45.2862 20.8422L68.287 24.1844L51.6435 40.4078L55.5725 63.3156L35 52.5Z" transform="translate(0.5 0.5)" id="Star1" fill="none" stroke="#848181" stroke-opacity="0.4" stroke-width="1" />
                                            </svg>
                                            </span>      
                                            <span id="2" class="star star2 filled">
                                                    <svg width="" height="" viewBox="0 0 71 71" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">  
                                                    <path d="M35 52.5L14.4275 63.3156L18.3565 40.4078L1.71302 24.1844L24.7138 20.8422L35 0L45.2862 20.8422L68.287 24.1844L51.6435 40.4078L55.5725 63.3156L35 52.5Z" transform="translate(0.5 0.5)" id="Star2" fill="none" stroke="#848181" stroke-opacity="0.4" stroke-width="1" />
                                                    </svg>
                                            </span>      
                                            <span id="3" class="star star3 filled">
                                                    <svg width="" height="" viewBox="0 0 71 71" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">  
                                                    <path d="M35 52.5L14.4275 63.3156L18.3565 40.4078L1.71302 24.1844L24.7138 20.8422L35 0L45.2862 20.8422L68.287 24.1844L51.6435 40.4078L55.5725 63.3156L35 52.5Z" transform="translate(0.5 0.5)" id="Star3" fill="none" stroke="#848181" stroke-opacity="0.4" stroke-width="1" />
                                                    </svg>
                                            </span>      
                                            <span id="4" class="star star4 filled">
                                                    <svg width="" height="" viewBox="0 0 71 71" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">  
                                                    <path d="M35 52.5L14.4275 63.3156L18.3565 40.4078L1.71302 24.1844L24.7138 20.8422L35 0L45.2862 20.8422L68.287 24.1844L51.6435 40.4078L55.5725 63.3156L35 52.5Z" transform="translate(0.5 0.5)" id="Star4" fill="none" stroke="#848181" stroke-opacity="0.4" stroke-width="1" />
                                                    </svg>
                                            </span>      
                                            <span id="5" class="star star5">
                                                    <svg width="" height="" viewBox="0 0 71 71" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">  
                                                    <path d="M35 52.5L14.4275 63.3156L18.3565 40.4078L1.71302 24.1844L24.7138 20.8422L35 0L45.2862 20.8422L68.287 24.1844L51.6435 40.4078L55.5725 63.3156L35 52.5Z" transform="translate(0.5 0.5)" id="Star5" fill="none" stroke="#848181" stroke-opacity="0.4" stroke-width="1" />
                                                    </svg>
                                            </span>      
                                        </div>
                                    </div>
                                </div>
                            </div>                                    
                            <div class="mute">Name, 06/04/2020</div>
                            <div class="spacer">&nbsp;</div>
                            <div>
                                <p>My hot flashes took over my life —I wasn’t sleeping, I couldn’t concentrate at work, I was irritable at home with my kids. I went on HRT and within 10 days I felt so much better. My hot flashes had decreased substantially, I was sleeping better, I was productive at work, happier at home. I felt like myself again. After 3 weeks on HRT, I hardly ever  get a hot flash. I have more energy and I feel joyful about my life.</p>
                            </div>
                            <div class="listTagsSingleMedicine d-flex flex-wrap">
								<span>Hot flushes</span>
								<span>Hot flushes</span>								
								<span>Hot flushes</span>
								<span>Hot flushes</span>
							</div>
                        </div>
                        <div class="singleReviewBox mb-4 p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="mediumFont">Name of Treatment</div>
                                <div>
                                <div class="ratings">
                                    <div class="d-flex justify-content-center">
                                        <span id="1" class="star star1 filled">
                                            <svg width="" height="" viewBox="0 0 71 71" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">  
                                            <path d="M35 52.5L14.4275 63.3156L18.3565 40.4078L1.71302 24.1844L24.7138 20.8422L35 0L45.2862 20.8422L68.287 24.1844L51.6435 40.4078L55.5725 63.3156L35 52.5Z" transform="translate(0.5 0.5)" id="Star1" fill="none" stroke="#848181" stroke-opacity="0.4" stroke-width="1" />
                                            </svg>
                                            </span>      
                                            <span id="2" class="star star2 filled">
                                                    <svg width="" height="" viewBox="0 0 71 71" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">  
                                                    <path d="M35 52.5L14.4275 63.3156L18.3565 40.4078L1.71302 24.1844L24.7138 20.8422L35 0L45.2862 20.8422L68.287 24.1844L51.6435 40.4078L55.5725 63.3156L35 52.5Z" transform="translate(0.5 0.5)" id="Star2" fill="none" stroke="#848181" stroke-opacity="0.4" stroke-width="1" />
                                                    </svg>
                                            </span>      
                                            <span id="3" class="star star3 filled">
                                                    <svg width="" height="" viewBox="0 0 71 71" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">  
                                                    <path d="M35 52.5L14.4275 63.3156L18.3565 40.4078L1.71302 24.1844L24.7138 20.8422L35 0L45.2862 20.8422L68.287 24.1844L51.6435 40.4078L55.5725 63.3156L35 52.5Z" transform="translate(0.5 0.5)" id="Star3" fill="none" stroke="#848181" stroke-opacity="0.4" stroke-width="1" />
                                                    </svg>
                                            </span>      
                                            <span id="4" class="star star4 filled">
                                                    <svg width="" height="" viewBox="0 0 71 71" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">  
                                                    <path d="M35 52.5L14.4275 63.3156L18.3565 40.4078L1.71302 24.1844L24.7138 20.8422L35 0L45.2862 20.8422L68.287 24.1844L51.6435 40.4078L55.5725 63.3156L35 52.5Z" transform="translate(0.5 0.5)" id="Star4" fill="none" stroke="#848181" stroke-opacity="0.4" stroke-width="1" />
                                                    </svg>
                                            </span>      
                                            <span id="5" class="star star5">
                                                    <svg width="" height="" viewBox="0 0 71 71" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">  
                                                    <path d="M35 52.5L14.4275 63.3156L18.3565 40.4078L1.71302 24.1844L24.7138 20.8422L35 0L45.2862 20.8422L68.287 24.1844L51.6435 40.4078L55.5725 63.3156L35 52.5Z" transform="translate(0.5 0.5)" id="Star5" fill="none" stroke="#848181" stroke-opacity="0.4" stroke-width="1" />
                                                    </svg>
                                            </span>      
                                        </div>
                                    </div>
                                </div>
                            </div>                                    
                            <div class="mute">Name, 06/04/2020</div>
                            <div class="spacer">&nbsp;</div>
                            <div>
                                <p>My hot flashes took over my life —I wasn’t sleeping, I couldn’t concentrate at work, I was irritable at home with my kids. I went on HRT and within 10 days I felt so much better. My hot flashes had decreased substantially, I was sleeping better, I was productive at work, happier at home. I felt like myself again. After 3 weeks on HRT, I hardly ever  get a hot flash. I have more energy and I feel joyful about my life.</p>
                            </div>
                            <div class="listTagsSingleMedicine d-flex flex-wrap">
								<span>Hot flushes</span>
								<span>Hot flushes</span>								
								<span>Hot flushes</span>
								<span>Hot flushes</span>
							</div>
                        </div>
                        <div class="singleReviewBox mb-4 p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="mediumFont">Name of Treatment</div>
                                <div>
                                <div class="ratings">
                                    <div class="d-flex justify-content-center">
                                        <span id="1" class="star star1 filled">
                                            <svg width="" height="" viewBox="0 0 71 71" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">  
                                            <path d="M35 52.5L14.4275 63.3156L18.3565 40.4078L1.71302 24.1844L24.7138 20.8422L35 0L45.2862 20.8422L68.287 24.1844L51.6435 40.4078L55.5725 63.3156L35 52.5Z" transform="translate(0.5 0.5)" id="Star1" fill="none" stroke="#848181" stroke-opacity="0.4" stroke-width="1" />
                                            </svg>
                                            </span>      
                                            <span id="2" class="star star2 filled">
                                                    <svg width="" height="" viewBox="0 0 71 71" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">  
                                                    <path d="M35 52.5L14.4275 63.3156L18.3565 40.4078L1.71302 24.1844L24.7138 20.8422L35 0L45.2862 20.8422L68.287 24.1844L51.6435 40.4078L55.5725 63.3156L35 52.5Z" transform="translate(0.5 0.5)" id="Star2" fill="none" stroke="#848181" stroke-opacity="0.4" stroke-width="1" />
                                                    </svg>
                                            </span>      
                                            <span id="3" class="star star3 filled">
                                                    <svg width="" height="" viewBox="0 0 71 71" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">  
                                                    <path d="M35 52.5L14.4275 63.3156L18.3565 40.4078L1.71302 24.1844L24.7138 20.8422L35 0L45.2862 20.8422L68.287 24.1844L51.6435 40.4078L55.5725 63.3156L35 52.5Z" transform="translate(0.5 0.5)" id="Star3" fill="none" stroke="#848181" stroke-opacity="0.4" stroke-width="1" />
                                                    </svg>
                                            </span>      
                                            <span id="4" class="star star4 filled">
                                                    <svg width="" height="" viewBox="0 0 71 71" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">  
                                                    <path d="M35 52.5L14.4275 63.3156L18.3565 40.4078L1.71302 24.1844L24.7138 20.8422L35 0L45.2862 20.8422L68.287 24.1844L51.6435 40.4078L55.5725 63.3156L35 52.5Z" transform="translate(0.5 0.5)" id="Star4" fill="none" stroke="#848181" stroke-opacity="0.4" stroke-width="1" />
                                                    </svg>
                                            </span>      
                                            <span id="5" class="star star5">
                                                    <svg width="" height="" viewBox="0 0 71 71" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">  
                                                    <path d="M35 52.5L14.4275 63.3156L18.3565 40.4078L1.71302 24.1844L24.7138 20.8422L35 0L45.2862 20.8422L68.287 24.1844L51.6435 40.4078L55.5725 63.3156L35 52.5Z" transform="translate(0.5 0.5)" id="Star5" fill="none" stroke="#848181" stroke-opacity="0.4" stroke-width="1" />
                                                    </svg>
                                            </span>      
                                        </div>
                                    </div>
                                </div>
                            </div>                                    
                            <div class="mute">Name, 06/04/2020</div>
                            <div class="spacer">&nbsp;</div>
                            <div>
                                <p>My hot flashes took over my life —I wasn’t sleeping, I couldn’t concentrate at work, I was irritable at home with my kids. I went on HRT and within 10 days I felt so much better. My hot flashes had decreased substantially, I was sleeping better, I was productive at work, happier at home. I felt like myself again. After 3 weeks on HRT, I hardly ever  get a hot flash. I have more energy and I feel joyful about my life.</p>
                            </div>
                            <div class="listTagsSingleMedicine d-flex flex-wrap">
								<span>Hot flushes</span>
								<span>Hot flushes</span>								
								<span>Hot flushes</span>
								<span>Hot flushes</span>
							</div>
                        </div> -->
                        
                    </div>
                    
                </div>  
                <div class="spacer">&nbsp;</div>

                <div class="container singleReviewBoxTreatment">
                	<a class="seemore seemore_btn" href="<?php echo site_url('search-reviews').'/?treatment_ids='.$treatment->ID.'&subtype_id='.$post->ID.'&pagenum=0'; ?>">
                        <span class="text-uppercase "> <strong>See More </strong></span>
                    </a>
                </div>
                <div class="spacer">&nbsp;</div>

            </div>
    </section>
</section>

<?php get_footer(); ?>
<script type="text/javascript">
	getReviews({'side_effects':true,'treatment_ids':<?php echo $treatment->ID; ?>,'subtype_id':<?php echo $post->ID; ?>},false);
</script>