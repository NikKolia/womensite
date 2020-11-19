<?php

if(!class_exists('WP_List_Table')){
   require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Reviews_List_Table extends WP_List_Table {

	public $perPage = 20;	

	function prepare_items() {
		$this->process_bulk_action();
		$perPage = $this->perPage;
		$page = $this->get_pagenum();
		if( $page == 1 ){
			$page = 0;
		}

		$columns = $this->get_columns();		
	  	$hidden = array();
	  	$sortable = array();
	  	$this->_column_headers = array($columns, $hidden, $sortable);
	  	$data = $this->getData($perPage, $page);
	  	$totalPosts = $data['total'];
	  	unset($data['total']);
	  	$this->set_pagination_args(
	  		array(
				'total_items' => $totalPosts,
				'per_page'    => $perPage
			),
			$this->items = $data
	  	);
	}

	function get_columns(){
  		$columns = array(
			'cb'          => '<input type="checkbox" />',
			'name'        => 'Name',
			'email'       => 'Email',
			'rating'      => 'Rating',
			'approved_by' => 'Approved',
			'created'     => 'Date',
			'view'        => 'Action'
		);		
  		return $columns;
	}

	function column_cb($item) {
        return sprintf('<label class="screen-reader-text" for="cb-select-%s">%s</label><input id="cb-select-%s" type="checkbox" name="post[]" value="%s" />', $item['id'],$item['name'],$item['id'], $item['id']);
    }

	function getData($perPage, $page){
		global $wpdb;
		$reviewData = array();
		$query = "SELECT * FROM {$wpdb->prefix}reviews ORDER BY created DESC LIMIT {$page},{$perPage}";

		$data = $wpdb->get_results($query);

		$getTotalPosts = $wpdb->get_results("SELECT COUNT(*) AS cnt FROM {$wpdb->prefix}reviews");
		$totalPosts = $getTotalPosts[0]->cnt;

		if( !empty($data) ){
			foreach($data as $k => $v){
				$reviewData[$k]['cb']          = '<label class="screen-reader-text" for="cb-select-'.$v->id.'" >'.$v->id.'</label><input id="cb-select-'.$v->id.'" type="checkbox" value="'.$v->id.'" />';
				$reviewData[$k]['id']          = $v->id;
				$reviewData[$k]['name']        = $v->name;
				$reviewData[$k]['email']       = $v->email;
				$reviewData[$k]['rating']      = $v->rating;
				$reviewData[$k]['approved_by'] = $v->approved_by;
				$reviewData[$k]['created']     = $v->created;
				// $reviewData[$k]['view']        = '<input data-id="'.$v->id.'" alt="#TB_inline?height=550&width=800&inlineId=reviewpopup" title="User Review Details" class="button action thickbox view-review" type="button" value="View" />';
				$reviewData[$k]['view']        = '<a href="'.admin_url('admin.php?page=reviews&action=edit&id=').$v->id.'" class="button action">View</a>';
			}
		}
		$reviewData['total'] = $totalPosts;
		echo "<script type='text/javascript'> var reviewData = ".json_encode($data)."</script>";
		return $reviewData;
	}

	function column_default( $item, $column_name ) {
		switch( $column_name ) {
	    	case 'name':
	    		echo ucfirst($item['name']);
	    		break;
	    	case 'email':
	    		echo $item['email'];
	    		break;
	    	case 'rating':
	    		echo $this->getRatingStars($item['rating']);
	    		break;
	    	case 'approved_by':
	    		echo $this->getApproved($item['approved_by']);
	    		break;
	    	case 'created':
	    		if( $item['created'] != '0000-00-00 00:00:00' && $item['created'] != '' && $item['created'] != null ){
	    			echo date_format(date_create($item['created']),'d M Y');
	    		}else{
	    			echo $item['created'];
	    		}
	    		break;
	    	case 'view':
	    		echo $item['view'];
	    		break;
	  	}
	}

	function getRatingStars($stars){
		$starsHtml = '';
		for($i=1; $i <= 5; $i++){
			if( $i <= $stars ){
				$starsHtml .= '<span style="font-size: 12px; height:13px; width:13px;" class="dashicons dashicons-star-filled"></span>';
			}else{
				$starsHtml .= '<span style="font-size: 12px; height:13px; width:13px;" class="dashicons dashicons-star-empty"></span>';
			}
		}
		return $starsHtml;
	}

	function getApproved($id){
		if( $id > 0 ){
			$user = get_user_by('ID',$id);
			return '<span class="dashicons dashicons-yes" style="color:green;"></span> | '.$user->data->user_nicename;
		}else{
			return '<span class="dashicons dashicons-no-alt" style="color:red;"></span>';
		}
	}

	function get_bulk_actions() {
		$actions = array(
	    	'approve' => 'Approve',
	    	'disapprove' => 'Disapprove',
	    	'delete' => 'Delete'
	  	);
	  	return $actions;
	}

	function process_bulk_action(){
		$url = admin_url('admin.php?page=reviews');
		if( 'approve' === $this->current_action() ){
			if( isset($_GET['post']) && !empty($_GET['post']) ){
				global $wpdb;
				$ids = implode(',', $_GET['post']);
				$user = get_current_user_id();
				$query = "UPDATE {$wpdb->prefix}reviews SET approved_by = $user WHERE id IN ($ids)";
				$update = $wpdb->query($query);
				sendApprovedEmail($_GET['post']);
				ob_start();
				wp_redirect($url);
				ob_clean();
			}
		}
		if( 'disapprove' === $this->current_action() ){
			if( isset($_GET['post']) && !empty($_GET['post']) ){
				global $wpdb;
				$ids = implode(',', $_GET['post']);
				$user = 0;
				$query = "UPDATE {$wpdb->prefix}reviews SET approved_by = $user WHERE id IN ($ids)";
				$update = $wpdb->query($query);
				ob_start();
				wp_redirect($url);
				ob_clean();
			}
		}
		if ( 'delete' === $this->current_action() ) {
			if( isset($_GET['post']) && !empty($_GET['post']) ){
				global $wpdb;
				$ids = implode(',', $_GET['post']);
				$deleteQuery = "DELETE a,b,c,d FROM {$wpdb->prefix}reviews a 
								LEFT JOIN {$wpdb->prefix}reviews_symptoms b ON (a.id = b.review_id) 
								LEFT JOIN {$wpdb->prefix}reviews_treatment c ON (a.id = c.review_id) 
								LEFT JOIN {$wpdb->prefix}reviews_treatment_effects d ON (a.id = d.review_id)
						    	WHERE a.id IN ($ids)";
				$delete = $wpdb->query($deleteQuery);
				if($delete){
					ob_start();
					wp_redirect($url);
					ob_clean();
				}
			}
		}
	}

	function review_udpate_error() {
	    ?>
	    <div class="error is-dismissible">
	        <p><?php _e( 'There was some error updating the Reviews. Please try again!' ); ?></p>
	    </div>
	    <?php
	}

	function review_udpate_success() {
	    ?>
	    <div class="success is-dismissible">
	        <p><?php _e( 'Review(s) were successfully updated !' ); ?></p>
	    </div>
	    <?php
	}

}



add_action('admin_menu', 'add_review_page');
function add_review_page(){
    add_menu_page(
	    'Reviews',
	    'Reviews',
	    'edit_posts',
	    'reviews',
	    'addReviewsHtml',
	    'dashicons-star-filled',
	    5
	);
	// add_submenu_page(
	//     'reviews',
	//     'Settings', /*page title*/
	//     'Settings', /*menu title*/
	//     'edit_posts', /*roles and capability needed*/
	//     'user_referral_settings',
	//     'userReferralSettingPage' /*function*/
	// );
}

function review_disapprove() {
    ?>
    <div class="error is-dismissible">
        <p><?php _e( 'Review has been disapproved !' ); ?></p>
    </div>
    <?php
}

function review_approve() {
    ?>
    <div class="success is-dismissible">
        <p><?php _e( 'Review has been approved !' ); ?></p>
    </div>
    <?php
}

function addReviewsHtml(){
	$get = $_GET;
	if( isset($get['action']) && $get['action'] == 'edit' && isset($get['id']) && !empty($get['id']) ){
		$post = $_POST;
		if( isset($post) && !empty($post) ){
			global $wpdb;
			$approveValue = 0;
			if( isset($post['approve']) ){
				$approveValue = get_current_user_id();
			}
			$id = $post['id'];
			$query = "UPDATE {$wpdb->prefix}reviews SET approved_by = $approveValue WHERE id = $id";
			$update = $wpdb->query($query);			
			if( $approveValue == 0 ){
				add_action('admin_notices', 'review_disapprove');
			}else{
				sendApprovedEmail($id);
				add_action('admin_notices', 'review_approve');
			}
		}
		$data = getReviewData($get['id']);
		addPreviewHtml($data);
	}else{
		$myListTable = new Reviews_List_Table();
		echo '<div class="wrap"><h2>User Reviews</h2>';
		echo '<form id="posts-filter" method="get">';
		echo '<input type="hidden" name="page" value="'.$_REQUEST['page'].'"/>';
		$myListTable->prepare_items();
		$myListTable->display();
		echo '</form>';
		echo '</div>';
	}
	// add_thickbox();
	// addPopUpHtml();
}

function getReviewData($id){
	global $wpdb;

	$getReviews = "SELECT * FROM {$wpdb->prefix}reviews WHERE id = $id";
	$getTreatmentsEffect = "SELECT * FROM {$wpdb->prefix}reviews_treatment_effects WHERE review_id = $id";

	$getTreatments = "SELECT {$wpdb->prefix}posts.ID,{$wpdb->prefix}posts.post_title,{$wpdb->prefix}posts.post_type FROM {$wpdb->prefix}reviews_treatment
					LEFT JOIN {$wpdb->prefix}posts ON {$wpdb->prefix}reviews_treatment.post_id = {$wpdb->prefix}posts.ID
					WHERE {$wpdb->prefix}reviews_treatment.review_id = $id";

    $getSymptoms = "SELECT {$wpdb->prefix}posts.post_title,{$wpdb->prefix}reviews_symptoms.symptom_changes
					FROM {$wpdb->prefix}reviews_symptoms 
					LEFT JOIN {$wpdb->prefix}posts ON {$wpdb->prefix}reviews_symptoms.symptom_id = {$wpdb->prefix}posts.id
					WHERE {$wpdb->prefix}reviews_symptoms.review_id = $id";

/*	$getSymptoms = "SELECT {$wpdb->prefix}symptoms.symptom,{$wpdb->prefix}reviews_symptoms.symptom_changes
					FROM {$wpdb->prefix}reviews_symptoms 
					LEFT JOIN {$wpdb->prefix}symptoms ON {$wpdb->prefix}reviews_symptoms.symptom_id = {$wpdb->prefix}symptoms.id
					WHERE {$wpdb->prefix}reviews_symptoms.review_id = $id";*/

	$getBrands = "SELECT {$wpdb->prefix}posts.post_title,{$wpdb->prefix}reviews_brand.brand,{$wpdb->prefix}reviews_brand.tell_us_more FROM {$wpdb->prefix}reviews_brand
					LEFT JOIN {$wpdb->prefix}posts on {$wpdb->prefix}reviews_brand.post_id = {$wpdb->prefix}posts.ID
					WHERE {$wpdb->prefix}reviews_brand.review_id = $id";

	$reviews           = $wpdb->get_results($getReviews);
	$treatment_effects = $wpdb->get_results($getTreatmentsEffect);
	$treatments        = $wpdb->get_results($getTreatments);
	$symptoms          = $wpdb->get_results($getSymptoms);
	$brands            = $wpdb->get_results($getBrands);

	return array('reviews' => $reviews, 'treatment_effects' => $treatment_effects, 'treatments' => $treatments, 'symptoms' => $symptoms, 'brands' => $brands );
}

function addPopUpHtml(){
	?>
		<style type="text/css">
			
		</style>
		<div id="reviewpopup" style="display:none">
			<section id="review-section-1">
				<h2>What menopause treatment(s) are you reviewing?</h2>
				<div>Bedol and others</div>
				<div>Other</div>
				<div>What brand are you using?</div>
				<div>How long have you been taking this or did you take it? </div>
				<div> Are you still using this treatment(s)?</div>
				<div>Why did you stop? </div>
			</section>
			<section id="review-section-2">
				<h2>What symptoms made you go on this treatments(s)?</h2>
				<div>Anger</div>
				<div>Anxiety</div>
			</section>
			<section id="review-section-3">
				<div>MOOD & WELLBEING</div>
				<div>WHEN YOU LOOK IN THE MIRROR</div>
			</section>
			<section id="review-section-4">
				
			</section>
			<section id="review-section-5">
				<div>What would you want your friends to know about this treatment?</div>
				<div>Overall star rating</div>
			</section>
			
		</div>
	<?php
}

function addPreviewHtml($data){
	$reviews           = $data['reviews'][0];
	$treatment_effects = $data['treatment_effects'];
	$treatments        = $data['treatments'];
	$symptoms          = $data['symptoms'];
	$brands            = $data['brands'];	
	?>
		<style type="text/css">
			#view-review section{
				padding: 1px 0px 10px 8px;
    			background-color: #ffffff82;
			}
			#view-review label{
				border: 1px solid #23282d;
			    padding: 6px;
			    background-color: #f8f8f8;
			    color: black;
			    border-radius: 6px;
			    margin: 6px 0 0px 5px;
			    font-weight: 500;
			    display: inline-block;
			}
			#view-review #inline-section h4{
				display: inline-block;
			}
			#view-review .last-section{
			    line-height: 0px;
			    height: auto;
			}
			#view-review .last-section span{
			    font-weight: bold;
			}
		</style>
		<div class="wrap" id="view-review">
			<h2>User Reviews</h2>
			<hr>
			<section>
				<h2>What menopause treatment(s) are you reviewing?</h2>
				<div>
					<?php if( !empty($treatments) ){ ?>
						<?php foreach($treatments as $k => $v ){ ?>
							<label><?php echo $v->post_title; ?></label>
						<?php } ?>
					<?php } else{  ?>
						NA
					<?php } ?>
				</div>
				<hr>
				<h4>Other Treatments</h4>
				<div>
					<?php 
						if( !empty($reviews->other_treatments) && strlen($reviews->other_treatments) > 0 ){
							$exp = explode(',', $reviews->other_treatments);
							foreach($exp as $k => $v ){
								echo '<label>'.$v.'</label>';
							}
						}else{
							echo 'NA';
						}
					?>
				</div>
				<hr>
				<h4>What brand are you using?</h4>
				<div>
					<?php if( !empty($brands) ){ ?>
						<?php foreach($brands as $k=> $v){ ?>
							<div>
								<?php echo $v->post_title; ?> : 
								<label>
									<?php if (!empty($v->brand)){ 
										echo $v->brand; 
									} else if(!empty($v->tell_us_more)) { 
										echo $v->tell_us_more; 
									} else{
										echo 'NA';
									}
									?>
								</label>
							</div>
						<?php } ?>
					<?php } else { ?>
						<div>NA</div>
					<?php } ?>
				</div>
				<hr>
				<h4>How long have you been taking this or did you take it?</h4>
				<div>
					<?php echo ( !empty($reviews->time_period) && strlen($reviews->time_period) > 0 ) ? $reviews->time_period.' '.$reviews->time_unit : 'NA'; ?>
				</div>
				<hr>
				<h4>Are you still using this treatment(s)?</h4>
				<div>
					<?php echo ($reviews->is_treatment_continue) ? 'Yes' : 'No'; ?>
				</div>
				<hr>
				<h4>Why did you stop?</h4>
				<div>
					<?php echo ( !empty($reviews->reason_to_stop_treatment) && strlen($reviews->reason_to_stop_treatment) > 0 ) ? $reviews->reason_to_stop_treatment : 'NA'; ?>
				</div>
			</section>
			<hr>
			<section>
				<h2>What symptoms made you go on this treatments(s)?</h2>
				<div>
					<?php if( !empty($symptoms) ){ ?>
						<?php foreach($symptoms as $k => $v){ ?>
							<div><?php echo $v->post_title; ?> : <label><?php echo ($v->symptom_changes && strlen($v->symptom_changes) > 0 ) ? $v->symptom_changes : 'NA' ; ?></label></div>
						<?php } ?>
					<?php }else{ ?>
						<div>NA</div>
					<?php } ?>
				</div>
			</section>
			<hr>
			<section>
				<h2>Did your treatment have any effect on these things?</h2>
				<div>
					<?php if( !empty($treatment_effects) ){ ?>
						<?php foreach($treatment_effects as $k => $v ){ ?>
							<div><?php echo $v->question; ?> : 
								<label><?php echo ( strlen($v->answer) > 0 ) ? $v->answer : 'NA' ; ?></label>
							</div>
						<?php } ?>
					<?php } else{ ?>
						<div>NA</div>
					<?php } ?>
				</div>
			</section>
			<hr>
			<section>
				<h2>Did you experience any side effects?</h2>
				<div>
					<?php if( !empty($reviews->side_effects) && strlen($reviews->side_effects) > 0 ) { ?>
						<?php 
							$ex = explode(',', $reviews->side_effects);
							$ex = array_unique($ex);
							foreach ($ex as $e => $x) {
								echo '<label>'.$x.'</label>';
							}
						?>
					<?php } else { ?>
						NA
					<?php } ?>
				</div>
			</section>
			<hr>
			<section>
				<h2> What would you want your friends to know about this treatment?</h2>
				<div>
					<?php echo (!empty($reviews->about_treatment)) ? (stripslashes($reviews->about_treatment)) : 'NA'; ?>
				</div>
				<hr>
				<h2>Overall star rating</h2>
				<div>
					<?php
						$starsHtml = '';
						for($i=1; $i <= 5; $i++){
							if( $i <= $reviews->rating ){
								$starsHtml .= '<span style="font-size: 12px; height:13px; width:13px;" class="dashicons dashicons-star-filled"></span>';
							}else{
								$starsHtml .= '<span style="font-size: 12px; height:13px; width:13px;" class="dashicons dashicons-star-empty"></span>';
							}
						}
						echo $starsHtml;
					?>
				</div>
			</section>
			<hr>
			<section id="inline-section">
				<h2>Gathering this information helps us to learn more about what works for different women</h2>
				<div class="last-section">
					<h4>HOW OLD ARE YOU?</h4>
					<span>
						<?php echo ( !empty($reviews->age) && strlen($reviews->age) > 0 ) ? $reviews->age : 'NA'; ?>
					</span>
				</div>
				<div class="last-section">
					<h4>WHAT AGE DID YOU START HAVING PERIMENOPAUSE/MENOPAUSE SYMPTOMS?</h4>
					<span>
						<?php echo ( !empty($reviews->symptoms_start_age) && strlen($reviews->symptoms_start_age) > 0 ) ? $reviews->symptoms_start_age : 'NA'; ?>
					</span>
				</div>
				<div class="last-section">
					<h4>WAS YOUR MENOPAUSE INDUCED BY CANCER TREATMENT/OTHER MEDICAL SITUATION?</h4>
					<span>
						<?php echo ($reviews->induced_by_treatment) ? 'Yes' : 'No'; ?>
					</span>
				</div>
				<div class="last-section">
					<h4>DID YOU HAVE CHILDREN?</h4>
					<span>
						<?php echo ($reviews->children) ? 'Yes' : 'No'; ?>
					</span>
				</div>
				<div class="last-section">
					<h4>DID YOU BREASTFEED?</h4>
					<span>
						<?php echo ($reviews->breastfeed) ? 'Yes' : 'No'; ?>
					</span>
				</div>
				<div class="last-section">
					<h4>DID YOU SUFFER FROM POST NATAL DEPRESSION?</h4>
					<span>
						<?php echo ($reviews->post_natal_depression) ? 'Yes' : 'No'; ?>
					</span>
				</div>
				<div class="last-section">
					<h4>DID YOU SUFFER FROM PREMENSTRUAL SYNDROME?</h4>
					<span>
						<?php echo ($reviews->premenstrual_syndrome) ? 'Yes' : 'No'; ?>
					</span>
				</div>
				<div class="last-section">
					<h4>WHEN DID YOU HAVE YOUR LAST PERIOD?</h4>
					<span>
						<?php echo ( !empty($reviews->last_period) && strlen($reviews->last_period) > 0 ) ? $reviews->last_period : 'NA'; ?>
					</span>
				</div>
				<div class="last-section">
					<h4>ETHNICITY</h4>
					<span>
						<?php echo ( !empty($reviews->ethnicity) && strlen($reviews->ethnicity) > 0 ) ? $reviews->ethnicity : 'NA'; ?>
					</span>
				</div>
				<div class="last-section">
					<h4>HEIGHT</h4>
					<span>
						<?php echo ( !empty($reviews->height) && strlen($reviews->height) > 0 ) ? $reviews->height.' '.$reviews->height_unit : 'NA'; ?>
					</span>
				</div>
				<div class="last-section">
					<h4>WEIGHT</h4>
					<span>
						<?php echo ( !empty($reviews->weight) && strlen($reviews->weight) > 0 ) ? $reviews->weight.' '.$reviews->weight_unit : 'NA'; ?>
					</span>
				</div>				
			</section>
			<hr>
			<section>
				<h2>Anything else you want to tell us about your treatment regime?</h2>
				<div>
					<?php echo ( !empty($reviews->more_about_treatment) && strlen($reviews->more_about_treatment) > 0 ) ? $reviews->more_about_treatment : 'NA'; ?>
				</div>
				<hr>
				<h2>Name</h2>
				<div>
					<?php echo ( !empty($reviews->name) && strlen($reviews->name) > 0 ) ? $reviews->name : 'Anonymous'; ?>
				</div>
				<h2>Email</h2>
				<div>
					<?php echo ( !empty($reviews->email) && strlen($reviews->email) > 0 ) ? $reviews->email : 'NA'; ?>
				</div>
			</section>
			<hr>
			<div>
				<form method="POST">
					<input type="hidden" name="id" value="<?php echo $reviews->id; ?>">
					<?php if( $reviews->approved_by > 0 ){ ?>
						<input type="submit" name="disapprove" value="DisApprove Review" class="button">						
					<?php }else{ ?>
						<input type="submit" name="approve" value="Approve Review" class="button">
					<?php } ?>
				</form>
			</div>
		</div>
	<?php
}

function sendApprovedEmail($id){
	global $wpdb;
	$headers = array('Content-Type: text/html; charset=UTF-8');
	if( is_array($id) && !empty($id) ){
		$data = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}reviews WHERE id IN (".implode(',', $id).")");
		if( !empty($data) ){
			foreach ($data as $key => $value) {
				$email = $value->email;
				if( !empty($email) ){
					$subject = 'Review approved - Menopause';
					$message = prepareEmailContent($value);
					wp_mail($email,$subject,$message,$headers);
				}
			}
		}
	}else{
		$data = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}reviews WHERE id=$id");
		if( !empty($data) ){
			$email = $data[0]->email;
			if( !empty($email) ){
				$subject = 'Review approved - Menopause';
				$message = prepareEmailContent($data[0]);
				wp_mail($email,$subject,$message,$headers);
			}
		}
	}
}

function prepareEmailContent($data){
	$name = ($data->name != '') ? $data->name : 'Anonymous';
	$link = site_url().'/user-review/'.$data->id;
	$message = '<div>Hello '.$name.',</div>';
	$message .= '<p>Your recent review has been approved and published to our site. You can find it <a href="'.$link.'">here</a></p>';
	$message .= '<p>Regards,<br> Team Menopause</p>';
	return $message;
}

?>