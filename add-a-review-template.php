<?php /* Template Name: Add a review */ ?>

<?php get_header('inner'); ?>
<?php 
    global $wpdb;
    
    $treatmentQuestions = getEnumValuesFromDB('reviews_treatment_effects','question');
    $treatmentOptions   = getEnumValuesFromDB('reviews_treatment_effects','answer');
    $symptomChanges     = getEnumValuesFromDB('reviews_symptoms','symptom_changes');
    
    $hormonalTreatmentId = 5;
    $hormonalTreatmentPost = get_post($hormonalTreatmentId);
    $hormonalTreatmentDetails = get_posts(
        array(
            'numberposts' => -1,
            'post_type'   => 'treatment_details',
            'orderby'     => 'id',
            'order'       => 'ASC',
            'meta_key'    => 'select_the_type_of_treatment',
            'meta_value'  => $hormonalTreatmentId,
        )
    );
    if( !empty($hormonalTreatmentDetails) ){
        foreach($hormonalTreatmentDetails as $key => $value){
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
                    $medicines[] = get_posts(
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
                }
            }
        }
    }
    // echo "<br><br><br><br><br><pre>";
    $medicinesArray = array();
    $sideEffectsOptions = array();
    if( !empty($medicines) ){
        foreach ($medicines as $key => $value) {
            if(is_array($value) && !empty($value)){
                foreach ($value as $k => $v) {
                    $medicinesArray[$v->ID] = $v->post_title;
                    $side_effects = get_field('side_effects',$v->ID);
                    if( !empty($side_effects) ){
                        $explode = array_map('trim', explode(',', $side_effects));
                        $sideEffectsOptions[$v->ID] = $explode;
                    }
                }
            }
        }
    }
    
    asort($medicinesArray);
    $nonHormonalTreatmentId = 8;
    $nonHormonalTreatmentPost = get_post($nonHormonalTreatmentId);
    $nonHormonalTreatmentDetails = get_posts(
        array(
            'numberposts' => -1,
            'post_type'   => 'treatment_details',
            'orderby'     => 'id',
            'order'       => 'ASC',
            'meta_key'    => 'select_the_type_of_treatment',
            'meta_value'  => $nonHormonalTreatmentId,
        )
    );

    $lifeStyleTreatmentId = 48;
    $lifeStyleTreatmentPost = get_post($lifeStyleTreatmentId);
    $lifeStyleTreatmentDetails = get_posts(
        array(
            'numberposts' => -1,
            'post_type'   => 'treatment_details',
            'orderby'     => 'id',
            'order'       => 'ASC',
            'meta_key'    => 'select_the_type_of_treatment',
            'meta_value'  => $lifeStyleTreatmentId,
        )
    );

    if( !empty($lifeStyleTreatmentDetails) ){
        $lifeStyleTreatmentSubtypes = array();
        foreach($lifeStyleTreatmentDetails as $key => $value){
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
                foreach($data as $k => $v){
                    array_push($lifeStyleTreatmentSubtypes, $v);        
                }
            }
        }
    }

    $naturalRemediesTreatmentId = 52;
    $naturalRemediesTreatmentPost = get_post($naturalRemediesTreatmentId);
    $naturalRemediesTreatmentDetails = get_posts(
        array(
            'numberposts' => -1,
            'post_type'   => 'treatment_details',
            'orderby'     => 'id',
            'order'       => 'ASC',
            'meta_key'    => 'select_the_type_of_treatment',
            'meta_value'  => $naturalRemediesTreatmentId,
        )
    );

    if( !empty($naturalRemediesTreatmentDetails) ){
        $naturalRemediesTreatmentSubtypes = array();
        foreach($naturalRemediesTreatmentDetails as $key => $value){
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
                foreach($data as $k => $v){
                    array_push($naturalRemediesTreatmentSubtypes, $v);        
                }
            }
        }
    }

    // $symptoms = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}symptoms ORDER BY symptom ASC" );
    $symptoms = get_posts(
        array(
            'numberposts' => -1,
            'post_type'   => 'symptoms',
            // 'orderby'     => 'id',
            'orderby'     => 'title',
            'order'       => 'ASC',
        )
    );

    $ethnicity =  !empty(vira_get_theme_option('ethnicity')) ? vira_get_theme_option('ethnicity') : '';
    asort($ethnicity);

?>
<script type="text/javascript">
    var symptomOptions = '<?php echo json_encode($symptomChanges); ?>';    
</script>
</section>
    <div class="add-a-review mt-95 container-fluid whiteBg p-5 textColorGrey">
        <form method="POST" action="" id="add-a-review-form">
            <section id="topHeaderWithStepsBtn"  class="topHeaderWithStepsBtn">
                <div class="w-100 text-center">
                      <h2>Leave a review</h2>
                      <p>Share your experience of a menopause treatment.<br/> 
                      The more you tell us the more you help other women. <br/>
                      <font> Average time to complete survey is 10 minutes.</font> </p>

                      <div class="stepCounter mt-4 d-flex justify-content-center align-items-center">
                            <button type="button" id="previousBtn" style="display: none;">
                                  <span class="previousStep">
                                        <svg id="previous" enable-background="new 0 0 482.239 482.239" height="42 " viewBox="0 0 482.239 482.239" width="42" xmlns="http://www.w3.org/2000/svg"><path d="m206.812 34.446-206.812 206.673 206.743 206.674 24.353-24.284-165.167-165.167h416.31v-34.445h-416.31l165.236-165.236z"/></svg>
                                  </span>
                            </button>
                            <button type="button"><span class="steps step-one isfilled orangeBg"></span></button>
                            <button type="button"><span class="steps step-two"></span></button>
                            <button type="button"><span class="steps step-three"></span></button>
                            <button type="button" id="nextBtn">
                                  <span class="nextStep">
                                        <svg id="next" enable-background="new 0 0 482.238 482.238" height="42" viewBox="0 0 482.238 482.238" width="42" xmlns="http://www.w3.org/2000/svg"><path d="m275.429 447.793 206.808-206.674-206.74-206.674-24.354 24.287 165.164 165.164h-416.307v34.446h416.306l-165.231 165.231z"/></svg>
                                  </span>
                            </button>     
                      </div>
                </div>
            </section>

            <div class="spacer">&nbsp;</div>

            <section id="add-a-review-Section1"  class="add-a-review-Section1 mt-5 review-section">
               
                <div id="ques1" class="mb-4">
                      <div class="instructions d-flex align-items-center justify-content-between flex-small-column">
                            <div class="instructionText">
                                  <span>What menopause treatment(s) are you reviewing?</span>
                            </div>
                            <div class="helpText">
                                  <span> Select all that apply </span>
                            </div>
                      </div>

                      <div class="optionHolder p-4">                              
                            <!-- <input class="form-control form-control-lg" type="text" placeholder=""/>  -->
                            <div id="treatment-tags">
                                
                            </div>
                            <div class="row pl-0 pr-0 mt-3">  
                                  <div class="col-sm-12 col-md-6 treatmentDropdown cross_inside ">
                                        <input type="hidden" name="treatment_reviews" id="treatment-review-hidden">
                                        <select data-type="1" placeholder="<?php echo $hormonalTreatmentPost->post_title; ?>" multiple="multiple" name="treat[<?php echo $hormonalTreatmentPost->ID; ?>][]" class="form-control form-control-lg mt-2 treatment-review">
                                            <?php if( !empty($medicinesArray) ){ ?>
                                                <?php foreach($medicinesArray as $k => $v ){ ?>
                                                    <option value="<?php echo $k; ?>">
                                                        <?php echo $v; ?>
                                                    </option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                              </div>
                              <div class="row pl-0 pr-0 mt-3">  
                                  <div class="col-sm-12 col-md-6 treatmentDropdown cross_inside">         
                                        <select data-type="2" placeholder="<?php echo $nonHormonalTreatmentPost->post_title; ?>" multiple="multiple" name="treat[<?php echo $nonHormonalTreatmentPost->ID; ?>][]" class="form-control form-control-lg mt-2 treatment-review">
                                            <?php if( !empty($nonHormonalTreatmentDetails) ){ ?>
                                                <?php foreach($nonHormonalTreatmentDetails as $k => $v){ ?>
                                                    <option value="<?php echo $v->ID; ?>">
                                                        <?php echo $v->post_title; ?>
                                                    </option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                              </div>
                              <div class="row pl-0 pr-0 mt-3">  
                                  <div class="col-sm-12 col-md-6 treatmentDropdown cross_inside ">     
                                        <select data-type="3" placeholder="<?php echo $lifeStyleTreatmentPost->post_title; ?>" multiple="multiple" name="treat[<?php echo $lifeStyleTreatmentPost->ID; ?>][]" class="form-control form-control-lg mt-2 treatment-review">
                                            <?php if( !empty($lifeStyleTreatmentSubtypes) ){ ?>
                                                <?php foreach($lifeStyleTreatmentSubtypes as $k => $v){ ?>
                                                    <option value="<?php echo $v->ID; ?>">
                                                        <?php echo $v->post_title; ?>
                                                    </option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                              </div>
                              <div class="row pl-0 pr-0 mt-3">  
                                  <div class="col-sm-12 col-md-6 treatmentDropdown cross_inside ">
                                        <select data-type="4" placeholder="<?php echo $naturalRemediesTreatmentPost->post_title; ?>" multiple="multiple" name="treat[<?php echo $naturalRemediesTreatmentPost->ID; ?>][]" class="form-control form-control-lg mt-2 treatment-review">
                                            <?php if( !empty($naturalRemediesTreatmentSubtypes) ){ ?>
                                                <?php foreach($naturalRemediesTreatmentSubtypes as $k => $v){ ?>
                                                    <option value="<?php echo $v->ID; ?>">
                                                        <?php echo $v->post_title; ?>
                                                    </option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>  
                                  </div>
                              </div> 
                            <div class="row pl-0 pr-0 mt-2 align-items-center">  
                                  <div class="col-sm-12 col-md-2 othermuteText">
                                        <span class="qtext text-bold">Other</span>
                                  </div>
                                  <div class="col-sm-12 col-md-4">
                                        <input id="treatment-other" class="form-control form-control-lg" type="text" placeholder=""/> 
                                        <input type="hidden" name="treatment_other" id="treatment-other-hidden">
                                  </div>
                            </div>             
                            <div class="row pl-0 pr-0 mt-0 align-items-center" id="brand-usage" style="display: none;">  
                                <div class="col-sm-12 col-md-4 mb-3">
                                    <span class="qtext text-bold">What brand are you using? </span>
                                </div>
                            </div>
                            <div id="brand-usage-field" class="inner_fields">
                                
                            </div>
                            <div class="row pl-0 pr-0 mt-0 align-items-center" id="tell-us-more-usage" style="display: none;">
                                <div class="col-sm-12 col-md-4 mb-3">
                                    <span class="qtext text-bold">Tell us more </span>
                                </div>
                            </div>
                            <div id="tell-us-more-field" class="inner_fields">
                                
                            </div>

                            <div class="row pl-0 pr-0 mt-3 align-items-center">  
                                  <div class="col-sm-12 col-md-8">
                                        <span class="qtext text-bold">How long have you been taking this or did you take it? </span>
                                  </div>
                                  <div class="col-sm-12 col-md-1">
                                        <input class="form-control form-control-lg" type="number" placeholder="" name="time_period" />
                                  </div>
                                  <div class="col-sm-12 col-md-2">
                                        <div class="btn-group yesNo" id="status" data-toggle="buttons">
                                              <label class="btn btn-default btn-on btn-lg active">
                                              <input type="radio" value="months" name="time_unit" checked="checked">Months</label>
                                              <label class="btn btn-default btn-off btn-lg">
                                              <input type="radio" value="years" name="time_unit">Years</label>
                                        </div>
                                  </div>
                            </div>                     
                            <div class="row pl-0 pr-0 mt-3 align-items-center">  
                                  <div class="col-sm-12 col-md-5">
                                        <span class="qtext text-bold">Are you still using this treatment(s)? </span>
                                  </div>
                                  <div class="col-sm-12 col-md-3">
                                        <div class="btn-group yesNo" id="status" data-toggle="buttons">
                                              <label class="btn btn-default btn-on btn-lg active is_treatment">
                                                <input type="radio" value="1" name="is_treatment_continue" checked="checked">Yes
                                              </label>
                                              <label class="btn btn-default btn-off btn-lg is_treatment">
                                                <input type="radio" value="0" name="is_treatment_continue">No
                                              </label>
                                        </div>
                                  </div>
                            </div>                              
                            <div class="row pl-0 pr-0 mt-3 align-items-center" id="why-did-you-stop" style="display: none;">  
                                  <div class="col-sm-12 col-md-5">
                                        <span class="qtext text-bold">Why did you stop? </span>
                                  </div>
                                  <div class="col-sm-12 col-md-6">
                                        <input class="form-control form-control-lg" type="text" placeholder="" name="reason_to_stop_treatment" />
                                  </div>                                    
                            </div>                     
                      </div>
                </div>

                <div id="ques2" class="mb-4">
                      <div class="instructions d-flex align-items-center justify-content-between flex-small-column">
                            <div class="instructionText">
                                  <span>What symptoms made you go on this treatments(s)?</span>
                            </div>
                            <div class="helpText">
                                  <span></span>
                            </div>
                      </div>
                      <div class="optionHolder p-4">                              
                            <div id="symptoms-tags">
                                
                            </div>
                            <div class="row pl-0 pr-0">  
                                  <div class="col-sm-12 col-md-6 treatmentDropdown cross_inside">
                                        <input type="hidden" name="_symptoms_ids" id="symptoms-hidden">
                                          <select data-type="5" placeholder="Symptoms" multiple="multiple" name="symptoms_ids[]" class="form-control form-control-lg mt-2" id="symptoms-select">
                                              <?php if( !empty($symptoms) ){ ?>
                                                  <?php foreach($symptoms as $symptom){ ?>
                                                      <option value="<?php echo $symptom->ID; ?>">
                                                          <?php echo $symptom->post_title; ?>
                                                      </option>
                                                  <?php } ?>
                                              <?php } ?>
                                          </select>
                                    <!--  <select data-type="5" placeholder="Symptoms" multiple="multiple" name="symptoms_ids[]" class="form-control form-control-lg mt-2" id="symptoms-select">
                                              <?php if( !empty($symptoms) ){ ?>
                                                  <?php foreach($symptoms as $symptom){ ?>
                                                      <option value="<?php echo $symptom->id; ?>">
                                                          <?php echo $symptom->symptom; ?>
                                                      </option>
                                                  <?php } ?>
                                              <?php } ?>
                                          </select> -->
                                  </div>
                            </div>
                            <div class="row pl-0 pr-0 mt-2 align-items-center">  
                                  <div class="col-sm-12 col-md-2 othermuteText">
                                        <span class="qtext text-bold">Other</span>
                                  </div>
                                  <div class="col-sm-12 col-md-4">
                                        <input class="form-control form-control-lg" type="text" placeholder="" id="other-symptom" /> 
                                        <input type="hidden" name="other_symptom" id="other-symptom-hidden">
                                  </div>
                            </div>  
                            <div class="row pl-0 pr-0 mt-0 align-items-center" id="symptom-change-div" style="display: none;">  
                                  <div class="col-sm-12 col-md-5 pt-3">
                                        <span class="qtext text-bold">Did these symptoms change?</span>
                                  </div>                     
                            </div>
                            <div id="symptoms-feedback"></div>
                      </div>      
                </div>                   
                      
            </section>

            <section id="add-a-review-Section2"  class="add-a-review-Section2 mt-5 review-section" style="display: none;">
                <div id="ques3" class="mb-4">
                      <div class="instructions d-flex align-items-center justify-content-between flex-small-column">
                            <div class="instructionText">
                                  <span>Did your treatment have any effect on these things?</span>
                            </div>
                            <div class="helpText">
                                  <span></span>
                            </div>
                      </div>
                      <div class="optionHolder p-4">
                            <?php if( !empty($treatmentQuestions) ){ ?>
                                <?php foreach($treatmentQuestions as $ii => $question){ ?>
                                    <div class="row pl-0 pr-0 mt-0 align-items-center">
                                        <div class="col-sm-12 symtomChange flex-sm-column flex-md-row">
                                          <div class="w-28-inline w-sm-100-block">
                                            <span class="symChangeQues"><?php echo $question ?></span>
                                          </div>
                                          <div>
                                            <?php foreach($treatmentOptions as $jj => $opt){ ?>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="radio" class="custom-control-input-" name="treatment[<?php echo $question; ?>]" id="treatment-effect-<?php echo $ii.'-'.$jj; ?>" value="<?php echo $opt; ?>">
                                                    <label class="custom-control-label symChangeOpt" for="treatment-effect-<?php echo $ii.'-'.$jj; ?>"><?php echo $opt; ?></label>                                                   
                                                </div>    
                                            <?php } ?>                              
                                            </div>
                                        </div>               
                                    </div>
                                    <?php
                                        if( 'UROGENITAL HEALTH' == $question ){
                                    ?>
                                        <div class="row subPoint">
                                            <div class="col-sm-12 ml-2 ">
                                                (e.g. vulval and vaginal soreness, dysuria and urinary frequency, uncomfortable sex, recurrent UTIs)
                                            </div>
                                        </div>
                                    <?php
                                        }else if( 'RELATIONSHIPS' == $question ){
                                    ?>
                                        <div class="row subPoint">
                                            <div class="col-sm-12 ml-2 ">
                                                (Friendships & partnerships)
                                            </div>
                                        </div>    
                                    <?php
                                        }
                                    ?>
                                <?php } ?>
                            <?php } ?>                                 
                      </div>      
                </div>

                <div id="ques4" class="mb-4">
                      <div class="instructions d-flex align-items-center justify-content-between flex-small-column">
                            <div class="instructionText">
                                  <span>Did you experience any side effects?</span>
                            </div>
                            <div class="helpText">
                                  <span>Select all that apply</span>
                            </div>
                      </div>
                      <div class="optionHolder p-4">
                            <!-- <input class="form-control form-control-lg" type="text" placeholder=""/>  -->
                            <div id="side-effect-tags">
                                
                            </div>
                            <div class="row pl-0 pr-0">  
                                <div class="col-sm-12 col-md-6 treatmentDropdown side_effect ">                                                                                
                                    <select data-type="6" multiple="multiple" id="side-effects" placeholder="Side Effects" class="form-control form-control-lg mt-2 " name="side_effects[]">
                                            
                                    </select>
                                </div>
                                <?php if( !empty($sideEffectsOptions) ){ ?>
                                    <?php foreach($sideEffectsOptions as $key => $value){ ?>
                                        <select style="display: none;" id="prelist-<?php echo $key; ?>" >
                                            <?php if( !empty($value) ){ ?>
                                                <?php foreach( $value as $k => $v ){ ?>
                                                    <option data-side-effct-id="<?php echo $key; ?>" value="<?php echo $v; ?>">
                                                        <?php echo $v; ?>
                                                    </option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    <?php } ?>
                                <?php } ?>
                            </div> 
                            <div class="row pl-0 pr-0 mt-2 align-items-center">  
                                  <div class="col-sm-12 col-md-2 othermuteText">
                                        <span class="qtext fadedText">Enter other side effects</span>
                                  </div>
                                  <div class="col-sm-12 col-md-4">
                                        <input id="other-side-effects-field" class="form-control form-control-lg" type="text" placeholder=""/>
                                        <input type="hidden" name="other_side_effects" id="other-side-effects">
                                  </div>
                            </div>  
                      </div> 
                </div>    

                <div id="ques5" class="mb-4">
                      <div class="instructions d-flex align-items-center justify-content-between flex-small-column">
                            <div class="instructionText">
                                  <span>What would you want your friends to know about this treatment?</span>
                            </div>
                            <div class="helpText" style="max-width:unset">
                                  <span>Women find this the most helpful.</span>
                            </div>
                      </div>
                      <div class="optionHolder p-4">                              
                            <textarea class="form-control" rows="5" id="comment" name="about_treatment"></textarea>
                      </div> 
                </div>  
                
                <div id="ques6" class="mb-4">
                      <div class="row d-flex align-items-center">
                            <div class="col-md-4 col-sm-5 ">
                                  <div class="instructions">
                                        <div class="instructionText">
                                              <span>Overall star rating</span>
                                        </div>
                                  </div>
                            </div>
                            <input type="hidden" name="rating" id="star-rating" value="0">
                            <div class="col-md-8 col-sm-7 d-flex justify-content-center">
                                  <span id="1" class="star star1 ">
                                        <svg width="71px" height="71px" viewBox="0 0 71 71" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">  
                                        <path d="M35 52.5L14.4275 63.3156L18.3565 40.4078L1.71302 24.1844L24.7138 20.8422L35 0L45.2862 20.8422L68.287 24.1844L51.6435 40.4078L55.5725 63.3156L35 52.5Z" transform="translate(0.5 0.5)" id="Star1" fill="none" stroke="#848181" stroke-opacity="0.4" stroke-width="1" />
                                        </svg>
                                  </span>      
                                  <span id="2" class="star star2 ">
                                        <svg width="71px" height="71px" viewBox="0 0 71 71" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">  
                                        <path d="M35 52.5L14.4275 63.3156L18.3565 40.4078L1.71302 24.1844L24.7138 20.8422L35 0L45.2862 20.8422L68.287 24.1844L51.6435 40.4078L55.5725 63.3156L35 52.5Z" transform="translate(0.5 0.5)" id="Star2" fill="none" stroke="#848181" stroke-opacity="0.4" stroke-width="1" />
                                        </svg>
                                  </span>      
                                  <span id="3" class="star star3 ">
                                        <svg width="71px" height="71px" viewBox="0 0 71 71" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">  
                                        <path d="M35 52.5L14.4275 63.3156L18.3565 40.4078L1.71302 24.1844L24.7138 20.8422L35 0L45.2862 20.8422L68.287 24.1844L51.6435 40.4078L55.5725 63.3156L35 52.5Z" transform="translate(0.5 0.5)" id="Star3" fill="none" stroke="#848181" stroke-opacity="0.4" stroke-width="1" />
                                        </svg>
                                  </span>      
                                  <span id="4" class="star star4 ">
                                        <svg width="71px" height="71px" viewBox="0 0 71 71" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">  
                                        <path d="M35 52.5L14.4275 63.3156L18.3565 40.4078L1.71302 24.1844L24.7138 20.8422L35 0L45.2862 20.8422L68.287 24.1844L51.6435 40.4078L55.5725 63.3156L35 52.5Z" transform="translate(0.5 0.5)" id="Star4" fill="none" stroke="#848181" stroke-opacity="0.4" stroke-width="1" />
                                        </svg>
                                  </span>      
                                  <span id="5" class="star star5">
                                        <svg width="71px" height="71px" viewBox="0 0 71 71" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">  
                                        <path d="M35 52.5L14.4275 63.3156L18.3565 40.4078L1.71302 24.1844L24.7138 20.8422L35 0L45.2862 20.8422L68.287 24.1844L51.6435 40.4078L55.5725 63.3156L35 52.5Z" transform="translate(0.5 0.5)" id="Star5" fill="none" stroke="#848181" stroke-opacity="0.4" stroke-width="1" />
                                        </svg>
                                  </span>      
                            </div>
                      </div>
                </div>
            </section>

            <section id="add-a-review-Section3"  class="add-a-review-Section3 mt-5 review-section" style="display: none;">
                <div id="ques7" class="mb-4">
                      <div class="instructions d-block align-items-center justify-content-between flex-small-column orangeBg">
                            <div class="instructionText">
                                  <span>Gathering this information helps us to learn more about what works for different women</span>
                            </div>
                      <div class="textColorPurple text-right w-100 font-weight-bold"><a class="readMore" href='../how-it-works/'> Read more... </a></div>

                            <div class="helpText">
                                  <span></span>
                            </div>
                      </div>
                      <div class="optionHolder p-4"> 
                            <div class="row pl-0 pr-0 d-flex align-items-center mb-2">  
                                  <div class="col-sm-12 col-md-3">
                                        <span class="qtext">HOW OLD ARE YOU?</span>                             
                                  </div>
                                  <div class="col-sm-12 col-md-1">
                                         <input class="form-control form-control-lg" type="number" placeholder="" name="age" />                             
                                  </div>
                            </div>
                            <div class="row pl-0 pr-0 d-flex align-items-center mb-2">  
                                  <div class="col-sm-12 col-md-9">
                                        <span class="qtext">WHAT AGE DID YOU START HAVING PERIMENOPAUSE/MENOPAUSE SYMPTOMS?</span>                             
                                  </div>
                                  <div class="col-sm-12 col-md-1">
                                         <input class="form-control form-control-lg" type="number" placeholder="" name="symptom_start_date" />                             
                                  </div>
                            </div>
                            <div class="row pl-0 pr-0 d-flex align-items-center mb-2">  
                                  <div class="col-sm-12 col-md-10">
                                        <span class="qtext">WAS YOUR MENOPAUSE INDUCED BY CANCER TREATMENT/OTHER MEDICAL SITUATION?</span>                             
                                  </div>
                                  <div class="col-sm-12 col-md-2">
                                        <div class="btn-group yesNo" id="status" data-toggle="buttons">
                                              <label class="btn btn-default btn-on btn-lg">
                                              <input type="radio" value="1" name="induced_by_treatment" >Yes</label>
                                              <label class="btn btn-default btn-off btn-lg">
                                              <input type="radio" value="0" name="induced_by_treatment">No</label>
                                        </div>                             
                                  </div>
                            </div>
                            <div class="row pl-0 pr-0 d-flex align-items-center mb-2">  
                                  <div class="col-sm-12 col-md-4 col-xxl-2 col-xl-3">
                                        <span class="qtext">DID YOU HAVE CHILDREN?</span>                             
                                  </div>
                                  <div class="col-sm-12 col-md-2">
                                        <div class="btn-group yesNo" id="status" data-toggle="buttons">
                                              <label class="btn btn-default btn-on btn-lg ">
                                              <input type="radio" value="1" name="children" >Yes</label>
                                              <label class="btn btn-default btn-off btn-lg">
                                              <input type="radio" value="0" name="children">No</label>
                                        </div>                             
                                  </div>
                            </div>
                            <div class="row pl-0 pr-0 d-flex align-items-center mb-2">  
                                  <div class="col-sm-12 col-md-4 text-md-right col-xxl-2 col-xl-3">
                                        <span class="qtext">DID YOU BREASTFEED? </span>                             
                                  </div>
                                  <div class="col-sm-12 col-md-2">
                                        <div class="btn-group yesNo" id="status" data-toggle="buttons">
                                              <label class="btn btn-default btn-on btn-lg ">
                                              <input type="radio" value="1" name="breastfeed" >Yes</label>
                                              <label class="btn btn-default btn-off btn-lg">
                                              <input type="radio" value="0" name="breastfeed">No</label>
                                        </div>                             
                                  </div>
                            </div>
                            <div class="row pl-0 pr-0 d-flex align-items-center mb-2">  
                                  <div class="col-sm-12 col-md-7 text-md-right col-xxl-4 col-xllg-5 col-lg-6">
                                        <span class="qtext">DID YOU SUFFER FROM POST NATAL DEPRESSION? </span>                             
                                  </div>
                                  <div class="col-sm-12 col-md-2">
                                        <div class="btn-group yesNo" id="status" data-toggle="buttons">
                                              <label class="btn btn-default btn-on btn-lg ">
                                              <input type="radio" value="1" name="post_natal_depression" >Yes</label>
                                              <label class="btn btn-default btn-off btn-lg">
                                              <input type="radio" value="0" name="post_natal_depression">No</label>
                                        </div>                             
                                  </div>
                            </div>
                            <div class="row pl-0 pr-0 d-flex align-items-center mb-2">  
                                  <div class="col-sm-12 col-md-7 col-xxl-4 col-xllg-5 col-lg-6">
                                        <span class="qtext">DID YOU SUFFER FROM PREMENSTRUAL SYNDROME? </span>                             
                                  </div>
                                  <div class="col-sm-12 col-md-2">
                                        <div class="btn-group yesNo" id="status" data-toggle="buttons">
                                              <label class="btn btn-default btn-on btn-lg ">
                                              <input type="radio" value="1" name="premenstrual_syndrome" >Yes</label>
                                              <label class="btn btn-default btn-off btn-lg">
                                              <input type="radio" value="0" name="premenstrual_syndrome">No</label>
                                        </div>                             
                                  </div>
                            </div>
                            <div class="row pl-0 pr-0 d-flex align-items-center mb-2">  
                                  <div class="col-sm-12 col-md-5">
                                        <span class="qtext">WHEN DID YOU HAVE YOUR LAST PERIOD? </span>                             
                                  </div>
                                  <div class="col-sm-12 col-md-6">
                                        <div class="btn-group yesNo lastPeriod" id="status" data-toggle="buttons">
                                              <label class="btn btn-default btn-on btn-lg ">
                                              <input type="radio" value="More than 12 months" name="last_period">More than 12 months</label>
                                              <label class="btn btn-default btn-on btn-lg ">
                                              <input type="radio" value="Less than 12 months" name="last_period" >Less than 12 months</label>
                                              <label class="btn btn-default btn-off btn-lg">
                                              <input type="radio" value="Don't know" name="last_period">Don't know</label>
                                        </div>                             
                                  </div>
                            </div>
                            <div class="row pl-0 pr-0 d-flex align-items-center mb-2">  
                                  <div class="col-sm-12 col-md-2">
                                  <div class="label_spacer"></div>
                                        <span class="qtext">ETHNICITY</span>                             
                                  </div>
                                  <div class="col-sm-12 col-md-3">
                                  <div class="label_spacer"></div>
                                        <?php if( !empty($ethnicity) ){ ?>
                                            <select class="form-control otherSelect form-control-lg mt-2" name="ethnicity">
                                                <option value="">Other</option>
                                                <?php foreach( $ethnicity as $k=> $v ){ ?>
                                                    <option value="<?php echo $v; ?>"><?php echo $v; ?></option>
                                                <?php } ?>
                                            </select>
                                        <?php } ?>                                        
                                  </div>
                                  <div class="col-sm-12 col-md-3">
                                      <label for="ethnicity_other">Other</label>
                                      <input class="form-control form-control-lg" type="text" placeholder="" id="ethnicity_other" name="ethnicity_other" />
                                  </div>
                            </div>
                            <div class="row pl-0 pr-0 d-flex align-items-center mb-2">  
                                  <div class="col-sm-12 col-md-2">
                                        <span class="qtext">HEIGHT</span>                             
                                  </div>
                                  <div class="col-sm-12 col-md-2">
                                         <input class="form-control form-control-lg" type="number" placeholder="" name="height" />                             
                                  </div>
                                  <div class="col-sm-12 col-md-2">
                                        <div class="btn-group bg-transparent" id="status" data-toggle="buttons">                                          
                                              <label class="btn btn-default btn-on btn-lg ">
                                              <input type="radio" value="feet" name="height_unit" >FEET</label>
                                              <label class="btn btn-default btn-off btn-lg">
                                              <input type="radio" value="meters" name="height_unit">METERS</label>
                                        </div>                             
                                  </div>
                            </div>
                            <div class="row pl-0 pr-0 d-flex align-items-center mb-2">  
                                  <div class="col-sm-12 col-md-2">
                                        <span class="qtext">WEIGHT</span>                             
                                  </div>
                                  <div class="col-sm-12 col-md-2">
                                         <input class="form-control form-control-lg" type="number" placeholder="" name="weight" />                             
                                  </div>
                                  <div class="col-sm-12 col-md-2">
                                        <div class="btn-group bg-transparent" id="status" data-toggle="buttons">                                          
                                              <label class="btn btn-default btn-on btn-lg ">
                                              <input type="radio" value="Lbs" name="weight_unit" >LBS</label>
                                              <label class="btn btn-default btn-off btn-lg">
                                              <input type="radio" value="Kg" name="weight_unit">KG</label>
                                        </div>                             
                                  </div>
                            </div>                      
                      </div>
                </div>

                <div id="ques8" class="mb-4">
                      <div class="instructions d-flex align-items-center justify-content-between flex-small-column orangeBg width-fit-content pr-md-4">
                            <div class="instructionText ">
                                  <span>Anything else you want to tell us about your treatment regime?</span>
                            </div>
                            <div class="helpText text-right">
                                  <span></span>
                            </div>
                      </div>
                      <div class="textColorLightGrey w-100 font-weight-bold pl-md-4"> For example are you coping with other health conditions such as diabetes? </div>
                      <div class="optionHolder p-4">                              
                            <textarea class="form-control" rows="5" id="comment" name="more_about_treatment"></textarea>
                      </div> 
                </div> 
                
                <div id="ques9" class="mb-4">
                      <div class="instructions d-flex align-items-center justify-content-between flex-small-column orangeBg width-fit-content pr-md-4   pr-md-4">
                            <div class="instructionText">
                                  <span>Leave a first name so we can attribute your review.</span>
                            </div>
                            <div class="helpText">
                                  <span></span>
                            </div>
                      </div>
                      <div class="textColorLightGrey w-100 font-weight-bold pl-md-4"><span>Leave empty to be listed as anonymous.</span> </div>
                      <div class="optionHolder p-4"> 
                            <div class="row pl-0 pr-0 d-flex align-items-center mb-2">  
                                  <div class="col-sm-12 col-md-6">
                                         <input class="form-control form-control-lg" type="text" placeholder="" name="name" />                             
                                  </div>
                            </div>     
                      </div>
                </div>

                <div id="ques10" class="mb-4">
                      <div class="instructions d-flex align-items-center justify-content-between flex-small-column orangeBg">
                            <div class="instructionText">
                                  <span>Leave your email if you would like to be notified when we publish information about this treatment.</span>
                            </div>
                            <div class="helpText">
                                  <span></span>
                            </div>
                      </div>                 
                      <div class="optionHolder p-4"> 
                            <div class="row pl-0 pr-0 d-flex align-items-center mb-2">  
                                  <div class="col-sm-12 col-md-6">
                                         <input class="form-control form-control-lg" type="email" placeholder="" name="email" />                             
                                  </div>
                            </div>     
                      </div>
                </div>
            </section>

            <?php wp_nonce_field('review_nonce', 'review_nonce_field'); ?>
            <section id="submitBtnSec"  class="submitBtnSec" style="display: none;">
                <div class="submitBtnSecContainer d-flex justify-content-center align-items-center  ">  
                      <button type="submit">                  
                            <div class="d-flex justify-content-center align-items-center flex-column">                                           
                                  <span class="iconSubmit">
                                        <img class="submit_arrow" alt="Submit icon" >
                                        <!--
                                              <img  onmouseover="this.src='<?php bloginfo('template_directory'); ?>/images/submitIcon_hover.png'" onmouseout="this.src='<?php bloginfo('template_directory'); ?>/images/submitIcon.png'"  src="<?php bloginfo('template_directory'); ?>/images/submitIcon.png" alt="Submit icon"> 
                                                -->
                                    </span>
                                  <span class="txt submitTxt">SUBMIT</span>                              
                             </div>
                      </button>
                </div>
            </section>

            <section id="nextPreviousBtn"  class="nextPreviousBtn">
                <div class="nextPreviousBtnContainer d-flex justify-content-between align-items-center ">
                      <div class="d-flex justify-content-between align-items-center">
                            <span class="iconPrev" style="display: none;">
                                  <img src="<?php bloginfo('template_directory'); ?>/images/prvBtn.svg" alt="previous icon"> 
                                  <span class="txt ml-2">Previous</span>    
                            </span>
                            
                      </div>
                      <div class="d-flex justify-content-between align-items-center">                        
                           
                            <span class="iconNext">
                                    <span class="txt mr-2">Next</span>
                                  <img src="<?php bloginfo('template_directory'); ?>/images/nextBtn.svg" alt="next icon">       
                            </span>
                      </div>
                </div>
            </section>
        </form>
    </div>       
 <?php get_footer(); ?>
</section>
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
 fbq('init', '292761598416306'); 
fbq('track', 'PageView');
</script>
<noscript>
 <img height="1" width="1" 
src="https://www.facebook.com/tr?id=292761598416306&ev=PageView
&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->