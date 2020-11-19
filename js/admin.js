jQuery(document).on('click', '.add-more-title', function(){
	var clone = jQuery('#first-title').clone();
	clone.prop('id','');
	clone.find('input').val('');
	clone.find('span').removeClass('dashicons-plus-alt add-more-title').addClass('dashicons-dismiss remove-title').css('color','red');
	jQuery('.add-review-table').append(clone);
});

jQuery(document).on('click', '.remove-title', function(){
	jQuery(this).parents('tr.treatment-titles').remove();
});

jQuery(document).on('click','.view-review',function(){
	var id = $(this).attr('data-id');
	console.log(id);
	var parsedData = jQuery.parseJSON();
	console.log(parsedData);
});