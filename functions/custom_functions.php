<?php
add_action('admin_enqueue_scripts', 'vira_admin_scripts');
function vira_admin_scripts(){
    wp_enqueue_media();
    wp_register_script('custom-admin-js', get_template_directory_uri() .'/js/admin.js', array('jquery','media-upload','thickbox','jquery-ui-core') );
    wp_enqueue_script('custom-admin-js');   
}

function add_a_review_form_submit() {
    $post = $_POST;    
    if(isset($post['review_nonce_field']) && wp_verify_nonce($post['review_nonce_field'], 'review_nonce')) {
        $side_effects_string = '';
        if( isset($post['side_effects']) && !empty($post['side_effects']) ){
            $side_effects_string .= implode(',', $post['side_effects']);
            if( isset($post['other_side_effects']) && !empty($post['other_side_effects']) && strlen($post['other_side_effects']) > 0 ){
                $side_effects_string .= ','.$post['other_side_effects'];
            }
        }
        $ethnicity = '';
        if( isset($post['ethnicity']) && !empty($post['ethnicity']) ){
            $ethnicity = $post['ethnicity'];
        }else if( isset($post['ethnicity_other']) && !empty($post['ethnicity_other']) ){
            $ethnicity = $post['ethnicity_other'];
        }
        $reviews = array(
            'other_treatments'         => ( isset($post['treatment_other']) ) ? $post['treatment_other'] : '',
            'time_period'              => ( isset($post['time_period']) ) ? $post['time_period'] : '',
            'time_unit'                => ( isset($post['time_unit']) ) ? $post['time_unit'] : '',
            'is_treatment_continue'    => ( isset($post['is_treatment_continue']) ) ? $post['is_treatment_continue'] : '',
            'reason_to_stop_treatment' => ( isset($post['reason_to_stop_treatment']) ) ? $post['reason_to_stop_treatment'] : '',
            'about_treatment'          => ( isset($post['about_treatment']) ) ? $post['about_treatment'] : '',
            'rating'                   => ( isset($post['rating']) ) ? $post['rating'] : '',
            'age'                      => ( isset($post['age']) ) ? $post['age'] : '',
            'symptoms_start_age'       => ( isset($post['symptom_start_date']) ) ? $post['symptom_start_date'] : '',
            'induced_by_treatment'     => ( isset($post['induced_by_treatment']) ) ? $post['induced_by_treatment'] : '',
            'side_effects'             => $side_effects_string,
            'children'                 => ( isset($post['children']) ) ? $post['children'] : '',
            'breastfeed'               => ( isset($post['breastfeed']) ) ? $post['breastfeed'] : '',
            'post_natal_depression'    => ( isset($post['post_natal_depression']) ) ? $post['post_natal_depression'] : '',
            'premenstrual_syndrome'    => ( isset($post['premenstrual_syndrome']) ) ? $post['premenstrual_syndrome'] : '',
            'last_period'              => ( isset($post['last_period']) ) ? $post['last_period'] : '',
            'ethnicity'                => ( isset($post['ethnicity']) ) ? $post['ethnicity'] : '',
            'height'                   => ( isset($post['height']) ) ? $post['height'] : '',
            'height_unit'              => ( isset($post['height_unit']) ) ? $post['height_unit'] : '',
            'weight'                   => ( isset($post['weight']) ) ? $post['weight'] : '',
            'weight_unit'              => ( isset($post['weight_unit']) ) ? $post['weight_unit'] : '',
            'more_about_treatment'     => ( isset($post['more_about_treatment']) ) ? $post['more_about_treatment'] : '',
            'name'                     => ( isset($post['name']) ) ? ucfirst($post['name']) : '',
            'email'                    => ( isset($post['email']) ) ? $post['email'] : '',
            'approved_by'              => 0,
            'created'                  => date('Y-m-d H:i:s'),
        );
        
        $review_id = insertData($reviews,'reviews');        

        if( isset($post['treat']) && !empty($post['treat']) ){
            foreach ($post['treat'] as $key => $value) {
                if( !empty($value) ){
                    $bulkTreat = array();
                    foreach ($value as $k => $v) {
                        $bulkTreat[] = array(
                            'review_id'        => $review_id,
                            'post_id'          => $v,
                            'parent_treatment' => $key,
                        );
                    }
                    bulkInsert('reviews_treatment',$bulkTreat);
                }
            }
        }

        if( isset($post['brand']) && !empty($post['brand']) ){
            $bulkbrand = array();
            foreach ($post['brand'] as $key => $value) {
                $bulkbrand[] = array(
                    'review_id' => $review_id,
                    'post_id'   => $key,
                    'brand'     => $value,
                );
            }
            bulkInsert('reviews_brand',$bulkbrand);
        }

        if( isset($post['more']) && !empty($post['more']) ){
            $bulktellusmore = array();
            foreach ($post['more'] as $key => $value) {
                $bulktellusmore[] = array(
                    'review_id'    => $review_id,
                    'post_id'      => $key,
                    'tell_us_more' => $value,
                );
            }
            bulkInsert('reviews_brand',$bulktellusmore);
        }

        if( !empty($post['symptoms_ids']) && !empty($post['symptoms_ids']) ){
            $bulkSymptoms = array();
            foreach ($post['symptoms_ids'] as $key => $value) {
                $bulkSymptoms[] = array(
                    'review_id'       => $review_id,
                    'symptom_id'      => $value,
                    'symptom_changes' => ( isset($post['symptoms'][$value]) ) ? $post['symptoms'][$value] : ''
                );
            }
            bulkInsert('reviews_symptoms',$bulkSymptoms);
        }
        
        if( !empty($post['other_symptom']) && strlen($post['other_symptom']) > 0 ){
            $otherSymptoms = explode(',', $post['other_symptom']);
            $symptomsReview = $post['symptoms'];
            if( !empty($otherSymptoms) ){
                foreach ($otherSymptoms as $key => $value) {
                    $reviewValue = '';
                    if( isset($symptomsReview[$value]) ){
                        $reviewValue =  $symptomsReview[$value];
                    }
                    $symptom_id = insertData( array('symptom' => strtoupper($value) ), 'symptoms' );
                    if( $reviewValue != '' ){
                        $symptomData = array(
                            'review_id'       => $review_id,
                            'symptom_id'      => $symptom_id,
                            'symptom_changes' => $reviewValue
                        );
                        insertData($symptomData,'reviews_symptoms');
                    }
                }
            }
        }

        if( is_array($post['treatment']) && !empty($post['treatment']) ){
            $bulkTreatments = array();
            foreach ($post['treatment'] as $key => $value) {
                $bulkTreatments[] = array(
                    'review_id' => $review_id,
                    'question'  => $key,
                    'answer'    => $value
                );
            }
            bulkInsert('reviews_treatment_effects',$bulkTreatments);
        }
        wp_redirect(site_url('thank-you'));
        exit;
    }
}
add_action('init', 'add_a_review_form_submit');

function insertData($data,$table){
    global $wpdb;
    $table = $wpdb->prefix.$table;
    $wpdb->insert($table,$data);
    // echo $wpdb->print_error();
    // echo $wpdb->last_error;
    // echo $wpdb->show_errors();
    // echo $wpdb->last_query;
    return $wpdb->insert_id;
}

function bulkInsert($table, $rows) {
    global $wpdb;
    $table = $wpdb->prefix.$table;
    // Extract column list from first row of data
    $columns = array_keys($rows[0]);
    asort($columns);
    $columnList = '`' . implode('`, `', $columns) . '`';

    // Start building SQL, initialise data and placeholder arrays
    $sql = "INSERT INTO `$table` ($columnList) VALUES\n";
    $placeholders = array();
    $data = array();

    // Build placeholders for each row, and add values to data array
    foreach ($rows as $row) {
        ksort($row);
        $rowPlaceholders = array();

        foreach ($row as $key => $value) {
            $data[] = $value;
            $rowPlaceholders[] = is_numeric($value) ? '%d' : '%s';
        }

        $placeholders[] = '(' . implode(', ', $rowPlaceholders) . ')';
    }

    // Stitch all rows together
    $sql .= implode(",\n", $placeholders);

    // Run the query.  Returns number of affected rows.
    return $wpdb->query($wpdb->prepare($sql, $data));
}

function getEnumValuesFromDB($table_name,$column_name){
    global $wpdb;
    $table_name = $wpdb->prefix.$table_name;
    $query = "SELECT COLUMN_TYPE AS vals FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='".$table_name."' AND COLUMN_NAME='".$column_name."'";
    $result = $wpdb->get_results($query);
    if( !empty($result) ){
        $enumString = $result[0]->vals;
        $sanitizedString = str_replace(['enum','(',')','\''], '', $enumString);
        $dataArray = explode(',', $sanitizedString);
        return $dataArray;
    }
}

/* Review Search functionality */

add_action( 'wp_ajax_get_reviews', 'get_reviews' );
add_action( 'wp_ajax_nopriv_get_reviews', 'get_reviews' );

function get_reviews(){
    $post = $_POST;
    if( !empty($post) && isset( $post['action'] ) && $post['action'] == 'get_reviews' ){
        $result = returnFilteredReviews($post);
        $response = array(
            'data'  => $result['result'],
            'total' => $result['total'],
            'showmore' => $result['showmore'],
            'side_effects' => $result['side_effects'],
        );
        $template = vira_get_template('template-parts/reviews_template.php', $response );
        print_r($template);
        exit();
    }
}

function returnFilteredReviews($params){
    global $wpdb;
    $reviewTable    = $wpdb->prefix.'reviews';
    $treatmentTable = $wpdb->prefix.'reviews_treatment';
    $effectsTable   = $wpdb->prefix.'reviews_treatment_effects';
    $symptomsTable  = $wpdb->prefix.'reviews_symptoms';
    $postTable      = $wpdb->posts;

    $limit = 10;

    $allSelect = " SELECT $reviewTable.*, $treatmentTable.parent_treatment, $postTable.post_title FROM $reviewTable ";
    $countSelect = " SELECT COUNT(*) AS cnt FROM $reviewTable ";
    $query = " LEFT JOIN $treatmentTable ON $reviewTable.id = $treatmentTable.review_id  
                LEFT JOIN $postTable ON $treatmentTable.parent_treatment = $postTable.ID
                WHERE ";
    if( isset($params['treatment_ids']) && !empty($params['treatment_ids']) ){
        if(is_array($params['treatment_ids'])){
            $treatment_ids = implode(',', $params['treatment_ids']);
        }else{
            $treatment_ids = $params['treatment_ids'];
        }
        $query .= " $treatmentTable.parent_treatment IN (".$treatment_ids.") AND ";
    }

    if( isset($params['subtype_id']) && !empty($params['subtype_id']) ){
        if(is_array($params['subtype_id'])){
            $subtype_id = implode(',', $params['subtype_id']);
        }else{
            $subtype_id = $params['subtype_id'];
        }
        $query .= " $treatmentTable.post_id IN (".$subtype_id.") AND ";
    }

    if( isset($params['age']) && !empty($params['age']) ){
        switch ($params['age']) {
            case '<40':
                $query .= " $reviewTable.age <= 40 AND ";
                break;
            case '41-50':
                $query .= " ($reviewTable.age > 40 AND $reviewTable.age <= 50 ) AND ";
                break;
            case '>51':
                $query .= " $reviewTable.age > 51 AND ";
                break;
        }
    }

    if( isset($params['periods']) && !empty($params['periods']) ){
        switch ($params['periods']) {
            case '<12':
                $query .= " $reviewTable.last_period = 'Less than 12 months' AND ";
                break;
            case '>12':
                $query .= " $reviewTable.last_period = 'More than 12 months' AND ";
                break;            
        }
    }

    if( isset($params['menopause']) && !empty($params['menopause']) ){
        switch ($params['menopause']) {
            case '1':
                $query .= " $reviewTable.induced_by_treatment = 1 AND ";
                break;
            case '0':
                $query .= " $reviewTable.induced_by_treatment = 0 AND ";
                break;
        }
    }

    if( isset($params['children']) && !empty($params['children']) ){
        switch ($params['children']) {
            case '1':
                $query .= " $reviewTable.children = 1 AND ";
                break;
            case '0':
                $query .= " $reviewTable.children = 0 AND ";
                break;
        }
    }

    if( isset($params['ethnicity']) && !empty($params['ethnicity']) ){
        $query .= " $reviewTable.ethnicity = '".$params['ethnicity']."' AND ";
    }

    $query .= " $reviewTable.approved_by > 0 ";
    $query .= " GROUP BY $reviewTable.id ";
    $query .= " ORDER BY $reviewTable.created DESC ";

    $count = $wpdb->get_results($countSelect.$query);
    $total = count($count);
    $showmore = 0;

    if( isset($params['limit']) ){
        if( isset($params['pagenum']) ){
            $query .= " LIMIT ".$params['pagenum']*$limit.', '.$params['limit'];
            if( ($params['pagenum']*$limit) + ($limit) < $total ){
                $showmore = 1;
            }
        }else{
            $query .= " LIMIT ".$params['limit'];
        }
    }else{
        if( isset($params['pagenum']) ){
            $query .= " LIMIT ".$params['pagenum']*$limit.", ".$limit;
            if( ($params['pagenum']*$limit) + ($limit) < $total ){
                $showmore = 1;
            }
        }else{
            $query .= " LIMIT ".$limit;
        }
    }

    if( isset($params['side_effects']) ){
        $side_effects = true;
    }else{
        $side_effects = false;;
    }
    
    $result = $wpdb->get_results($allSelect.$query);
    return( array('side_effects' => $side_effects,'showmore' => $showmore,'total' => $total, 'result' => $result ) );
}

function vira_get_template($slug, array $params = array(), $output = true) {
    if(!$output) ob_start();    
    if (!$template_file = locate_template($slug, false, false)) {
        trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
    }
    extract($params, EXTR_SKIP);
    require($template_file);
    if(!$output) return ob_get_clean();
}

function getStars($stars){
    $starsHtml = '';
    for($i=1; $i <= 5; $i++){
        if( $i <= $stars ){
            $starsHtml .= '<span class="star filled">
                                <svg width="" height="" viewBox="0 0 71 71" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">  
                                <path d="M35 52.5L14.4275 63.3156L18.3565 40.4078L1.71302 24.1844L24.7138 20.8422L35 0L45.2862 20.8422L68.287 24.1844L51.6435 40.4078L55.5725 63.3156L35 52.5Z" transform="translate(0.5 0.5)" id="Star1" fill="none" stroke="#848181" stroke-opacity="0.4" stroke-width="1" />
                                </svg>
                          </span>';
        }else{
            $starsHtml .= '<span class="star">
                                <svg width="" height="" viewBox="0 0 71 71" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">  
                                <path d="M35 52.5L14.4275 63.3156L18.3565 40.4078L1.71302 24.1844L24.7138 20.8422L35 0L45.2862 20.8422L68.287 24.1844L51.6435 40.4078L55.5725 63.3156L35 52.5Z" transform="translate(0.5 0.5)" id="Star1" fill="none" stroke="#848181" stroke-opacity="0.4" stroke-width="1" />
                                </svg>
                          </span>';
        }
    }
    return $starsHtml;
}

function displayTreatmentText($text){
    if( $text && strlen($text) > 0 ){
        $chars = 425;
        if( strlen($text) > $chars ){
            echo substr($text, 0, $chars).'...';
        }else{
            echo $text;
        }
    }else{
        echo 'NA';
    }
}

add_action( 'init', 'wpse26388_rewrites_init' );
function wpse26388_rewrites_init(){
    add_rewrite_rule(
        'user-review/([0-9]+)/?$',
        'index.php?pagename=user-review&review_id=$matches[1]',
        'top' );
}

add_filter( 'query_vars', 'wpse26388_query_vars' );
function wpse26388_query_vars( $query_vars ){
    $query_vars[] = 'review_id';
    return $query_vars;
}

/* Search Autocomplete */

add_action( 'wp_ajax_get_treatments', 'get_treatments' );
add_action( 'wp_ajax_nopriv_get_treatments', 'get_treatments' );

function get_treatments(){
    $post = $_POST;
    global $wpdb;
    if( !empty($post) && isset( $post['action'] ) && $post['action'] == 'get_treatments' ){
        $key = $post['key'];
        if( $key != '' ){
            $query = "SELECT
                        {$wpdb->prefix}posts.ID,
                        {$wpdb->prefix}posts.post_title,
                        {$wpdb->prefix}posts.post_type,
                        (
                            CASE WHEN {$wpdb->prefix}posts.post_type = 'treatment_details' THEN (
                                SELECT
                                    {$wpdb->prefix}postmeta.meta_value
                                FROM
                                    {$wpdb->prefix}postmeta
                                WHERE
                                    {$wpdb->prefix}postmeta.meta_key = 'select_the_type_of_treatment' AND {$wpdb->prefix}postmeta.post_id = {$wpdb->prefix}posts.ID
                            )
                               
                            WHEN {$wpdb->prefix}posts.post_type = 'treatment_sub_types' THEN (
                                SELECT
                                    {$wpdb->prefix}postmeta.meta_value
                                FROM
                                    {$wpdb->prefix}postmeta
                                WHERE
                                    {$wpdb->prefix}postmeta.meta_key = 'select_the_type_of_treatment_detail' AND {$wpdb->prefix}postmeta.post_id = {$wpdb->prefix}posts.ID
                            )
                            END
                    ) AS parent
                    FROM
                        {$wpdb->prefix}posts
                    WHERE
                        post_title LIKE '%".$key."%' AND post_status IN('publish') AND post_type IN(
                            'treatment_details',
                            'treatment_sub_types',
                            'medicine'
                        )
                    ORDER BY
                        INSTR(post_title,'".$key."')  ASC
                    LIMIT 10";                    
            $result = $wpdb->get_results($query);
            if( !empty($result) ){
                foreach ($result as $key => $value) {
                    $result[$key]->post_title = ucwords(strtolower($value->post_title));
                    if( $value->post_type == 'medicine' ){
                        $result[$key]->href = get_permalink($value->ID);
                    }else{
                        if( $value->post_type == 'treatment_sub_types' ){
                            $mainParentId = get_post_meta($value->parent,'select_the_type_of_treatment');
                            if( !empty($mainParentId) ){
                                $mainParentId = $mainParentId[0];
                            }
                        }else{
                            $mainParentId = $value->parent;
                        }
                        $page_id = get_post_meta($mainParentId,'link_to_page');
                        $link = get_permalink($page_id[0]);
                        $replaceChar = array('\'',' ','/','-','~','^','#','$','%','@','!','&','*','(',')','+');
                        $result[$key]->href = $link.'#'.strtolower(str_replace($replaceChar, '-', $value->post_title)).'-'.$value->ID;
                    }
                }
            }
            print_r( json_encode($result) );
            exit();
        }
    }
}

function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}