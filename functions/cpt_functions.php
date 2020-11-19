<?php

function treatments_post_type() {
    $labels = array(
        'name'                => _x( 'Treatments', 'Post Type General Name', 'twentytwenty' ),
        'singular_name'       => _x( 'Treatment', 'Post Type Singular Name', 'twentytwenty' ),
        'menu_name'           => __( 'Treatments', 'twentytwenty' ),
        'parent_item_colon'   => __( 'Parent Treatment', 'twentytwenty' ),
        'all_items'           => __( 'All Treatments', 'twentytwenty' ),
        'view_item'           => __( 'View Treatment', 'twentytwenty' ),
        'add_new_item'        => __( 'Add New Treatment', 'twentytwenty' ),
        'add_new'             => __( 'Add New', 'twentytwenty' ),
        'edit_item'           => __( 'Edit Treatment', 'twentytwenty' ),
        'update_item'         => __( 'Update Treatment', 'twentytwenty' ),
        'search_items'        => __( 'Search Treatment', 'twentytwenty' ),
        'not_found'           => __( 'Not Found', 'twentytwenty' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'twentytwenty' ),
    );     
     
    $args = array(
        'label'               => __( 'Treatments', 'twentytwenty' ),
        'description'         => __( 'Treatment news and reviews', 'twentytwenty' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
        // 'taxonomies'          => array( 'genres' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest'        => true,
    );
     
    register_post_type( 'treatments', $args );
 
}

function treatment_details_post_type() {
    $labels = array(
        'name'                => _x( 'Treatment Details', 'Post Type General Name', 'twentytwenty' ),
        'singular_name'       => _x( 'Treatment Details', 'Post Type Singular Name', 'twentytwenty' ),
        'menu_name'           => __( 'Treatment Details', 'twentytwenty' ),
        'parent_item_colon'   => __( 'Parent Treatment Details', 'twentytwenty' ),
        'all_items'           => __( 'All Treatment Details', 'twentytwenty' ),
        'view_item'           => __( 'View Treatment Details', 'twentytwenty' ),
        'add_new_item'        => __( 'Add New Treatment Details', 'twentytwenty' ),
        'add_new'             => __( 'Add New', 'twentytwenty' ),
        'edit_item'           => __( 'Edit Treatment Details', 'twentytwenty' ),
        'update_item'         => __( 'Update Treatment Details', 'twentytwenty' ),
        'search_items'        => __( 'Search Treatment Details', 'twentytwenty' ),
        'not_found'           => __( 'Not Found', 'twentytwenty' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'twentytwenty' ),
    );     
     
    $args = array(
        'label'               => __( 'Treatment Details', 'twentytwenty' ),
        'description'         => __( 'Treatment Details', 'twentytwenty' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
        // 'taxonomies'          => array( 'genres' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest'        => true,
    );
     
    register_post_type( 'treatment_details', $args );
 
}

function treatment_details_sub_types_post_type() {
    $labels = array(
        'name'                => _x( 'Treatment Subtype', 'Post Type General Name', 'twentytwenty' ),
        'singular_name'       => _x( 'Treatment Subtype', 'Post Type Singular Name', 'twentytwenty' ),
        'menu_name'           => __( 'Treatment Subtype', 'twentytwenty' ),
        'parent_item_colon'   => __( 'Parent Treatment Subtype', 'twentytwenty' ),
        'all_items'           => __( 'All Treatment Subtype', 'twentytwenty' ),
        'view_item'           => __( 'View Treatment Subtype', 'twentytwenty' ),
        'add_new_item'        => __( 'Add New Treatment Subtype', 'twentytwenty' ),
        'add_new'             => __( 'Add New', 'twentytwenty' ),
        'edit_item'           => __( 'Edit Treatment Subtype', 'twentytwenty' ),
        'update_item'         => __( 'Update Treatment Subtype', 'twentytwenty' ),
        'search_items'        => __( 'Search Treatment Subtype', 'twentytwenty' ),
        'not_found'           => __( 'Not Found', 'twentytwenty' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'twentytwenty' ),
    );     
     
    $args = array(
        'label'               => __( 'Treatment Subtype', 'twentytwenty' ),
        'description'         => __( 'Treatment Subtype', 'twentytwenty' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
        // 'taxonomies'          => array( 'genres' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest'        => true,
    );
     
    register_post_type( 'treatment_sub_types', $args );
 
}

function medicines_post_type() {
    $labels = array(
        'name'                => _x( 'Medicines', 'Post Type General Name', 'twentytwenty' ),
        'singular_name'       => _x( 'Medicine', 'Post Type Singular Name', 'twentytwenty' ),
        'menu_name'           => __( 'Medicines', 'twentytwenty' ),
        'parent_item_colon'   => __( 'Parent Medicine', 'twentytwenty' ),
        'all_items'           => __( 'All Medicines', 'twentytwenty' ),
        'view_item'           => __( 'View Medicine', 'twentytwenty' ),
        'add_new_item'        => __( 'Add New Medicine', 'twentytwenty' ),
        'add_new'             => __( 'Add New', 'twentytwenty' ),
        'edit_item'           => __( 'Edit Medicine', 'twentytwenty' ),
        'update_item'         => __( 'Update Medicine', 'twentytwenty' ),
        'search_items'        => __( 'Search Medicine', 'twentytwenty' ),
        'not_found'           => __( 'Not Found', 'twentytwenty' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'twentytwenty' ),
    );     
     
    $args = array(
        'label'               => __( 'Medicines', 'twentytwenty' ),
        'description'         => __( 'Medicine news and reviews', 'twentytwenty' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
        // 'taxonomies'          => array( 'genres' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest'        => true,
    );
     
    register_post_type( 'medicine', $args );
 
}

function faq_post_type(){
    $labels = array(
        'name'                => _x( 'FAQs', 'Post Type General Name', 'twentytwenty' ),
        'singular_name'       => _x( 'FAQ', 'Post Type Singular Name', 'twentytwenty' ),
        'menu_name'           => __( 'FAQs', 'twentytwenty' ),
        'parent_item_colon'   => __( 'Parent FAQ', 'twentytwenty' ),
        'all_items'           => __( 'All FAQs', 'twentytwenty' ),
        'view_item'           => __( 'View FAQ', 'twentytwenty' ),
        'add_new_item'        => __( 'Add New FAQ', 'twentytwenty' ),
        'add_new'             => __( 'Add New', 'twentytwenty' ),
        'edit_item'           => __( 'Edit FAQ', 'twentytwenty' ),
        'update_item'         => __( 'Update FAQ', 'twentytwenty' ),
        'search_items'        => __( 'Search FAQ', 'twentytwenty' ),
        'not_found'           => __( 'Not Found', 'twentytwenty' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'twentytwenty' ),
    );     
     
    $args = array(
        'label'               => __( 'FAQs', 'twentytwenty' ),
        'description'         => __( 'FAQ news and reviews', 'twentytwenty' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor','custom-fields', ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-editor-help',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest'        => true,
    );
     
    register_post_type( 'faq', $args ); 
}

function symptoms_post_type() {
    $labels = array(
        'name'                => _x( 'Symptoms', 'Post Type General Name', 'twentytwenty' ),
        'singular_name'       => _x( 'Symptom', 'Post Type Singular Name', 'twentytwenty' ),
        'menu_name'           => __( 'Symptoms', 'twentytwenty' ),
        'parent_item_colon'   => __( 'Parent Symptom', 'twentytwenty' ),
        'all_items'           => __( 'All Symptoms', 'twentytwenty' ),
        'view_item'           => __( 'View Symptom', 'twentytwenty' ),
        'add_new_item'        => __( 'Add New Symptom', 'twentytwenty' ),
        'add_new'             => __( 'Add New', 'twentytwenty' ),
        'edit_item'           => __( 'Edit Symptom', 'twentytwenty' ),
        'update_item'         => __( 'Update Symptom', 'twentytwenty' ),
        'search_items'        => __( 'Search Symptom', 'twentytwenty' ),
        'not_found'           => __( 'Not Found', 'twentytwenty' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'twentytwenty' ),
    );

    $args = array(
        'label'               => __( 'Symptoms', 'twentytwenty' ),
        'description'         => __( 'Symptoms list', 'twentytwenty' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest'        => true,
    );

    register_post_type( 'symptoms', $args );

}

add_action( 'init', 'treatments_post_type', 0 );
add_action( 'init', 'treatment_details_post_type', 0 );
add_action( 'init', 'treatment_details_sub_types_post_type', 0 );
add_action( 'init', 'medicines_post_type', 0 );
add_action( 'init', 'faq_post_type', 0 );
add_action( 'init', 'symptoms_post_type', 0 );


add_filter('manage_treatment_details_posts_columns', 'add_custom_columns_to_treatment_details');
function add_custom_columns_to_treatment_details( $defaults ) {
    $defaults['treatment_type'] = 'Treatment Type';
    return $defaults;
}

/* Add custom fields to listing */
add_action('manage_treatment_details_posts_custom_column', 'add_custom_columns_data_to_treatment_details', 10, 2 );
function add_custom_columns_data_to_treatment_details( $column_name, $post_id ) {
    if ($column_name == 'treatment_type') {
        $post_id = get_field('select_the_type_of_treatment');
        if( $post_id ){
            echo '<a href="'.get_edit_post_link($post_id).'">'.get_the_title($post_id).'</a>';
        }else{
            echo 'NA';
        }
    }
}

add_filter('manage_treatment_sub_types_posts_columns', 'add_custom_columns_to_treatment_sub_types');
function add_custom_columns_to_treatment_sub_types( $defaults ) {
    $defaults['treatment_detail'] = 'Treatment Detail';
    return $defaults;
}

add_action('manage_treatment_sub_types_posts_custom_column', 'add_custom_columns_data_to_treatment_sub_types', 10, 2 );
function add_custom_columns_data_to_treatment_sub_types( $column_name, $post_id ) {
    if ($column_name == 'treatment_detail') {
        $post_id = get_field('select_the_type_of_treatment_detail');
        if( $post_id ){
            echo '<a href="'.get_edit_post_link($post_id).'">'.get_the_title($post_id).'</a>';
        }else{
            echo 'NA';
        }
    }
}

add_filter('manage_medicine_posts_columns', 'add_custom_columns_to_medicine');
function add_custom_columns_to_medicine( $defaults ) {
    $defaults['medicines'] = 'Medicines';
    return $defaults;
}

add_action('manage_medicine_posts_custom_column', 'add_custom_columns_data_to_medicine', 10, 2 );
function add_custom_columns_data_to_medicine( $column_name, $post_id ) {
    if ($column_name == 'medicines') {
        $post_id = get_field('select_multiple_subtypes');        
        if( $post_id ){
            $html = '';
            foreach ($post_id as $key => $value) {
                if( $key > 0 ){
                    $html .= '<br>';
                }
                $html .= '<a href="'.get_edit_post_link($value).'">'.get_the_title($value).'</a>';                
            }
            echo $html;
        }else{
            echo 'NA';
        }
    }
}

add_filter('manage_faq_posts_columns', 'add_custom_columns_to_faq');
function add_custom_columns_to_faq( $defaults ) {
    $defaults['answer'] = 'Answer';
    return $defaults;
}

add_action('manage_faq_posts_custom_column', 'add_custom_columns_data_to_faq', 10, 2 );
function add_custom_columns_data_to_faq( $column_name, $post_id ) {
    if ($column_name == 'answer') {
        $post = get_post($post_id);
        if( $post ){
            $strLimit = 150;
            echo ( strlen($post->post_content) > $strLimit ) ? substr($post->post_content, 0, $strLimit).'...' : substr($post->post_content, 0, $strLimit); 
        }else{
            echo 'NA';
        }
    }
}


/* ACF change admin dropdowns to add optgroup */
// add_filter('acf/fields/post_object/query', 'change_result');
