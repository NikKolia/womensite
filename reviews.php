<?php /* Template Name: Reviews*/ ?>
<?php get_header('inner'); ?>
<?php

	$args = array(
        'numberposts' => -1,
        'post_type'   => 'treatments',
        'orderby'     => 'id',
        'order'       => 'ASC',
    );
    $treatments = get_posts($args);
?>
<br><br><br><br>
<select multiple="multiple" class="form-control treatment-type-filter" name="treatment">
    <?php if( !empty($treatments) ){ ?>
        <?php foreach($treatments as $k => $v ){ ?>
            <option value="<?php echo $v->ID; ?>">
                <?php echo $v->post_title; ?>
            </option>
        <?php } ?>
    <?php } ?>
</select>

<?php get_footer(); ?>