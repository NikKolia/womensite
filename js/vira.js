var brand_ids = [76,79,82,85,88,136,139,142,145,148,151];
var tell_us_more_ids = [106,109,97,100,103,121,124,127,130,133];

// handle Responsive change events
jQuery(document).on('change','#first-select-box',function(){
	var id = jQuery(this).val();
	var section = jQuery('#first-select-box option:selected').attr('data-get-section');
	jQuery('#treatmentExplanationSubSelectionHeader a[href="#' + id + '"]').tab('show');
	jQuery('.divsections').hide();
	jQuery('#'+section).show();
	var medicineBlock = jQuery('.all-medicines');
	if( medicineBlock.length > 0 ){
		var val = jQuery('#'+section).find('select').val();
		var getid = val.replace(/[^0-9]/g,'');
    	jQuery('.all-medicines').addClass('d-none').removeClass('d-flex');
        jQuery('#med-'+getid).removeClass('d-none').addClass('d-flex');
	}
});

jQuery(document).on('change','.second-select-box',function(){
	var id = jQuery(this).val();
	jQuery('a[href="#' + id + '"]').tab('show');
	var medicineBlock = jQuery('.all-medicines');
	if( medicineBlock.length > 0 ){
		var getid = id.replace(/[^0-9]/g,'');
    	jQuery('.all-medicines').addClass('d-none').removeClass('d-flex');
        jQuery('#med-'+getid).removeClass('d-none').addClass('d-flex');
    }
});

jQuery(document).ready(function(){
	showTabFromUrl();
    if( jQuery('.divsections:first-child').length > 0 ){
		var visibleDivSection = jQuery('.divsections:visible');
		var activeAnchor      = visibleDivSection.find('ul li a.active');
		var id                = activeAnchor.parent('li').attr('data-id');
		var hrefId            = activeAnchor.attr('href');
		var treatmentName     = activeAnchor.text();

        jQuery('#treatment-name').text( jQuery.trim(treatmentName) );
        var medicineBlock = jQuery('.all-medicines:visible');
        var param = {'limit':4,'subtype_id':[id]};
        
        if( medicineBlock.length > 0 ){
        	var anchors = medicineBlock.find('a');
        	if(anchors.length > 0){
        		var medicines = [];
        		jQuery.each(anchors,function(k,v){
        			medicines.push( jQuery(v).attr('data-medicine') );
        		});
        		param['subtype_id'] = medicines
        	}        	
        }
        getReviews(param,false);
    }else{
        var id = jQuery('#treatmentExplanationSubSelectionHeader').find('a.active').parent('li').attr('data-id');
        if( id != undefined ){
        	getReviews({'subtype_id':id},false);
    	}
    }        
});

jQuery(document).on('click','a.nav-link',function(){
	var url   = window.location.toString();
	hashId    = jQuery(this).attr('href');
	var index = url.indexOf('#');
	if( index > 0 ){
		url = url.substring(0,index);
	}
	url = url+hashId;
	window.history.replaceState({}, document.title, url);
	
	var section = jQuery(this).attr('div-section');
	var id = jQuery(this).parent('li').attr('data-id');

	if( section != '' && section != undefined ){
		jQuery('.divsections').hide();
		jQuery('#'+section).show();
		var activeAnchor = jQuery('#'+section).find('a.active');
		if( activeAnchor.length > 0 ){
			var activeAnchorHref = activeAnchor.attr('href');
			var id                = activeAnchor.parent('li').attr('data-id');
			var getid = activeAnchorHref.replace(/[^0-9]/g,'');
			if( jQuery('.all-medicines').length > 0 ){
				jQuery('.all-medicines').removeClass('d-flex').addClass('d-none');
        		jQuery('#med-'+getid).removeClass('d-none').addClass('d-flex');
			}
		}
	}
	
    if( id != undefined && id != '' ){
    	var param = {'subtype_id':[id],'limit':4};
    	var hrefId = jQuery(this).attr('href');
    	var treatmentName = jQuery(this).text();
        jQuery('#treatment-name').text( jQuery.trim(treatmentName) );
        // var medicineBlock = jQuery(hrefId).find('.btnMedicineBlock');
        var medicineBlock = jQuery('.all-medicines');
        if( medicineBlock.length > 0 ){
        	jQuery('.all-medicines').addClass('d-none').removeClass('d-flex');
        	jQuery('#med-'+id).removeClass('d-none').addClass('d-flex');
        	var anchors = jQuery('#med-'+id).find('a');
        	if(anchors.length > 0){
        		var medicines = [];
        		jQuery.each(anchors,function(k,v){
        			medicines.push( jQuery(v).attr('data-medicine') );
        		});
        		param['subtype_id'] = medicines
        	}        	
        }
        getReviews(param,false);
    }
});

jQuery(document).on('change','#treatmentDropdown',function(){
	var link = jQuery(this).find(':selected').attr('data-link');
	if (link != undefined && link != ''){
		window.location.href=link;
	}
});

jQuery(document).on('click','#previousBtn,.iconPrev',function(){
	currentStep = getCurrentStep();
	if(currentStep == 1){
		jQuery('#previousBtn').hide();
		jQuery('.iconPrev').hide();
	}
	if( currentStep > 0 && currentStep <=2 ){
		nextStep = currentStep-1;
		changeStepForm(nextStep);
		if( currentStep <= 2 ){
			jQuery('#nextBtn').show();
			jQuery('.iconNext').show();
		}
		scrollUp();
	}
});

jQuery(document).on('click','#nextBtn,.iconNext',function(){
	currentStep = getCurrentStep();
	if( currentStep >= 0 && currentStep < 2 ){
		if( validateForm(currentStep) ){
			nextStep = currentStep+1;
			changeStepForm(nextStep);
			jQuery('#previousBtn').show();
			jQuery('.iconPrev').show();
			if( currentStep == 1 ){
				jQuery('#nextBtn').hide();
				jQuery('.iconNext').hide();
			}
			scrollUp();
		}
	}
});

function changeStepForm(step){
	jQuery('.steps').removeClass('orangeBg');
	jQuery('.steps').removeClass('isfilled');
	for (var i = 0; i <= step; i++) {
		jQuery('.steps').eq(i).addClass('orangeBg');
	}
	jQuery('.steps').eq(step).addClass('isfilled');
	jQuery('.review-section').hide();
	jQuery('#add-a-review-Section'+(step+1)).show();
	if( step == 2){
		jQuery('#submitBtnSec').show();
	}else{
		jQuery('#submitBtnSec').hide();
	}
}

function getCurrentStep(){
	var steps = jQuery('.steps');
	step = 0;
	jQuery.each(steps,function(k,v){
		if( jQuery(v).hasClass('isfilled') ){
			step = k;
			return false;
		}
	});
	return step;
}

function showTabFromUrl(){
	var uri = window.location.toString();	
	if( uri.indexOf('#') > 0 ){
		var tabId          = uri.substring(uri.indexOf('#')+1,uri.length);
		var divSectionAttr = jQuery('#'+tabId+'-tab').attr('div-section');
		var divSection     = jQuery('#'+tabId+'-tab').parents('.divsections');
		
		if( divSectionAttr != '' && divSectionAttr != undefined ){
			jQuery('a[href="#' + tabId + '"]').tab('show');
			jQuery('#first-select-box option[value="'+tabId+'"]').prop('selected',true);
			jQuery('.divsections').hide();
			jQuery('#'+divSectionAttr).show();
			jQuery('#'+divSectionAttr).find('select option:first-child').prop('selected',true);

		}else if( divSection.length > 0 ){
			var parentSectionId = divSection.attr('id');
			jQuery('a[div-section="'+parentSectionId+'"]').tab('show');
			jQuery('#first-select-box option[data-get-section="'+parentSectionId+'"]').prop('selected',true);

			jQuery('.divsections').hide();
			divSection.show();
			jQuery('a[href="#' + tabId + '"]').tab('show');
			divSection.find('select option[value="'+tabId+'"]').prop('selected',true);

			var medicineBlock = jQuery('.all-medicines');
	        if( medicineBlock.length > 0 ){
	        	var getid = jQuery('#'+tabId+'-tab').parent('li').attr('data-id');
	        	jQuery('.all-medicines').addClass('d-none').removeClass('d-flex');
	        	jQuery('#med-'+getid).removeClass('d-none').addClass('d-flex');
	        }
		}else{
			jQuery('a[href="#' + tabId + '"]').tab('show');
		}		
	}	
}

function validateForm(step){
	var form = jQuery('#add-a-review-form');
	if( step == 1 ){
		form.validate({
			rules : {
				'time_period':{
					number : true
				}
			},
			messages : {
				'time_period' : {
					'number' : 'valid number'
				}
			}
		});
	}
	var errors = form.validate().errorList
	if( errors.length > 0 ){
		jQuery('html, body').animate({scrollTop: jQuery(errors[0].element).offset().top-100}, 500);
	}
	return form.valid();
}

function scrollUp(){
	jQuery('html, body').animate({scrollTop: jQuery(".stepCounter").offset().top-100}, 500);
}

function addRemoveValue(id,value,add=true){
	var getValues = jQuery('#'+id).val();
	if( add ){
		if( getValues == '' ){
			jQuery('#'+id).val(value);
		}else{
			jQuery('#'+id).val(getValues+','+value);
		}
	}else{
		arr = getValues.split(',');
		arr.splice(jQuery.inArray(value, arr), 1);
		jQuery('#'+id).val(arr.join(','));
	}
}

jQuery('.treatment-review').multiselect({
	numberDisplayed               : 1,
	maxHeight                     : 400,
	enableFiltering               : true,
	enableCaseInsensitiveFiltering: true,
	dropRight                     : true,
	buttonText: function(options, select) {
		return select.attr('placeholder');
    },
	onChange: function(element, checked) {
		var value = element.val();
		var text = jQuery.trim(element.text());
		var selectBoxType = element.parent('select').attr('data-type');		
        if(checked == true) {
        	jQuery('#treatment-tags').append('<label data-type-id="'+selectBoxType+'" data-id="'+value+'" class="custom-control-label selected">'+text+'<img class="removeTag" src="'+templateURL+'/images/removeCircle.svg"/></label>');
        	jQuery('input[name="treatment_reviews"]').val(value);
        	addRemoveValue('treatment-review-hidden',value, true);
        	addBrandField(value,text);
        	addSideEffectsOptions(value);
        } else if (checked == false) {
        	jQuery('#treatment-tags').find('label[data-id="'+value+'"]').remove();
        	addRemoveValue('treatment-review-hidden',value, false);
        	removeBrandField(value);
        	removeSideEffectsOptions(value);
        }
    }
});

jQuery('#symptoms-select').multiselect({
	numberDisplayed               : 1,
	maxHeight                     : 400,
	enableFiltering               : true,
	enableCaseInsensitiveFiltering: true,
	dropRight                     : true,
	buttonText: function(options, select) {
		return select.attr('placeholder');
    },
	onChange: function(element, checked) {
		var value = element.val();
		var text = jQuery.trim(element.text());
		var selectBoxType = element.parent('select').attr('data-type');
        if(checked == true) {        	
        	jQuery('#symptoms-tags').append('<label data-type-id="'+selectBoxType+'" data-id="'+value+'" class="custom-control-label selected">'+text+'<img class="removeTag" src="'+templateURL+'/images/removeCircle.svg"/></label>');
        	symptomsFeedbackHtml(value, text);
        	addRemoveValue('symptoms-hidden',value, true);
        } else if (checked == false) {
        	jQuery('#symptoms-tags').find('label[data-id="'+value+'"]').remove();
        	jQuery('#symptom-feedback-'+value).remove();
        	if( jQuery('#symptoms-feedback').is(':empty') ){
        		jQuery('#symptom-change-div').hide();
        	}
        	addRemoveValue('symptoms-hidden',value, false);
        }
    }
});

jQuery('#side-effects').multiselect({
	numberDisplayed               : 1,
	maxHeight                     : 400,
	enableFiltering               : true,
	enableCaseInsensitiveFiltering: true,
	dropRight                     : true,
	buttonText: function(options, select) {
		if( options.length > 0 ){
			return select.attr('placeholder');
		}else{
			return 'None from manufacturer, please enter below';
		}
    },
	onChange: function(element, checked) {
		var value = element.val();
		var text = jQuery.trim(element.text());
		var selectBoxType = element.parent('select').attr('data-type');
        if(checked == true) {        	
        	jQuery('#side-effect-tags').append('<label data-type-id="'+selectBoxType+'" data-id="'+value+'" class="custom-control-label selected">'+text+'<img class="removeTag" src="'+templateURL+'/images/removeCircle.svg"/></label>');
        } else if (checked == false) {
        	jQuery('#side-effect-tags').find('label[data-id="'+value+'"]').remove();
        }
    }
})

function addBrandField(value,text){
	if( jQuery.inArray(parseInt(value), brand_ids) !== -1 ){
		jQuery('#brand-usage').show();
		var html = '<div class="col-sm-12 row mb-3 brand-usage-section-'+value+'">'+
	                    '<div class="col-sm-4">'+text+'</div>'+
	                    '<div class="col-sm-8">'+
	                        '<input class="form-control form-control-lg" type="text" placeholder="Enter brand name" name="brand['+value+']" />'+
	                    '</div>'+
	                '</div>';
	    jQuery('#brand-usage-field').append(html);
	}
	if( jQuery.inArray(parseInt(value), tell_us_more_ids) !== -1 ){
		jQuery('#tell-us-more-usage').show();
		var html = '<div class="col-sm-12 row mb-3 tell-us-more-usage-section-'+value+'">'+
	                    '<div class="col-sm-4">'+text+'</div>'+
	                    '<div class="col-sm-8">'+
	                        '<textarea class="form-control form-control-lg" type="text" placeholder="Tell us more..." name="more['+value+']" /></textarea>'+
	                    '</div>'+
	                '</div>';
	    jQuery('#tell-us-more-field').append(html);
	}
}

function removeBrandField(value){
	if( jQuery.inArray(parseInt(value), brand_ids) !== -1 ){
		jQuery('.brand-usage-section-'+value).remove();
		if( jQuery('#brand-usage-field div').length == 0 ){
			jQuery('#brand-usage').hide();
		}
	}
	if( jQuery.inArray(parseInt(value), tell_us_more_ids) !== -1 ){
		jQuery('.tell-us-more-usage-section-'+value).remove();
		if( jQuery('#tell-us-more-field div').length == 0 ){
			jQuery('#tell-us-more-usage').hide();
		}
	}
}

function addSideEffectsOptions(id){
	var options = jQuery('#prelist-'+id+' option');
	if( options.length > 0 ){
		jQuery.each(options,function(k,v){
			jQuery('#side-effects').append(v);
		});
		jQuery('#side-effects').multiselect('rebuild');
		jQuery('#side-effects').multiselect('deselectAll', false);
	}
}

function removeSideEffectsOptions(id){
	jQuery('#side-effects option[data-side-effct-id="'+id+'"]').remove();
	jQuery('#side-effects').multiselect('rebuild');
}

function randomId(){
	return Math.random().toString(36).substring(7);
}

function symptomsFeedbackHtml(value, text){
	parsedData = jQuery.parseJSON(symptomOptions);
	var options = '';
	var newAttr = '';
	var _class = '';
	var name = 'symptoms['+value+']';
	if(value.match(/new/g)){
		var digit = value.match(/\d/g);
		newAttr   = 'data-new="'+digit[0]+'"';
		_class    = 'new-symptom';
		name      = 'symptoms['+text+']';
	}
	jQuery.each(parsedData,function(k,v){
		id = "symptom"+randomId();
		options += '<div class="custom-control custom-checkbox">'+
                        '<input type="radio" class="custom-control-input-" name="'+name+'" id="'+id+'" value="'+v+'" >'+
                        '<label class="custom-control-label symChangeOpt" for="'+id+'">'+v+'</label>'+
                    '</div>';
	});
	var html = '<div class="row pl-0 pr-0 mt-4 align-items-center '+_class+'" '+newAttr+' id="symptom-feedback-'+value+'">'+
              '<div class="col-sm-12 symtomChange flex-sm-column flex-md-row">'+
                    '<div class="w-28-inline w-sm-100-block"><span class="symChangeQues">'+text+'</span></div><div>'+
                    options +
              '</div></div>'+
        '</div>';
    jQuery('#symptoms-feedback').append(html);
    jQuery('#symptom-change-div').show();
}

jQuery(document).on('click','.symChangeOpt', function(){
	var $this = jQuery(this);
	$this.parents('.symtomChange').find('label').removeClass('selected');
	$this.addClass('selected');
});

jQuery(document).on('keypress','#treatment-other',function(event){
	if(event.which == 13){
		event.preventDefault();
		var value = jQuery(this).val();
		if( value != '' && value != undefined ){
			jQuery('#treatment-tags').append('<label data-type-id="1" data-id="treatment-'+value+'" class="custom-control-label selected">'+value+'<img class="removeTag" src="'+templateURL+'/images/removeCircle.svg"/></label>');
			jQuery(this).val('');
			var getValues = jQuery('#treatment-other-hidden').val();
			if( getValues == '' ){
				jQuery('#treatment-other-hidden').val(value);	
			}else{
				jQuery('#treatment-other-hidden').val(getValues+','+value);
			}			
		}
	}
});

jQuery(document).on('keypress','#other-side-effects-field',function(event){
	if(event.which == 13){
		event.preventDefault();
		var value = jQuery(this).val();
		if( value != '' && value != undefined ){
			jQuery('#side-effect-tags').append('<label data-type-id="6" data-id="side-effect-'+value+'" class="custom-control-label selected">'+value+'<img class="removeTag" src="'+templateURL+'/images/removeCircle.svg"/></label>');
			jQuery(this).val('');
			var getValues = jQuery('#other-side-effects').val();
			if( getValues == '' ){
				jQuery('#other-side-effects').val(value);	
			}else{
				jQuery('#other-side-effects').val(getValues+','+value);
			}			
		}
	}
});

jQuery(document).on('keypress','#other-symptom',function(event){
	if(event.which == 13){
		event.preventDefault();
		var text = jQuery(this).val();
		if( text != '' && text != undefined ){
			var divs = jQuery('#symptoms-feedback').find('div.new-symptom');
			if( divs.length > 0 ){
				var maximum = null;
				jQuery.each(divs,function() {
					var attrValue = parseFloat(jQuery(this).attr('data-new'));
				  	maximum = (attrValue > maximum) ? attrValue : maximum;
				});
				value = 'new-'+(maximum+1);
			}else{
				value = 'new-1';
			}
			symptomsFeedbackHtml(value,text);
			jQuery('#symptoms-tags').append('<label data-type-id="5" data-id="'+value+'" class="custom-control-label selected">'+text+'<img class="removeTag" src="'+templateURL+'/images/removeCircle.svg"/></label>');
			jQuery(this).val('');
			var getValues = jQuery('#other-symptom-hidden').val();
			if( getValues == '' ){
				jQuery('#other-symptom-hidden').val(text);
			}else{
				jQuery('#other-symptom-hidden').val(getValues+','+text);
			}			
		}
	}
});

jQuery(document).on('click','.star',function(){
	var id = jQuery(this).attr('id');
	jQuery('.star').removeClass('filled');
	jQuery('#star-rating').val(id);
	for (var i = 1 ; i <= id ; i++) {
		jQuery('.star'+i).addClass('filled');
	}
});

jQuery(document).on('click','.removeTag',function(){
	var $this  = jQuery(this);	
	var id     = $this.parent('label').attr('data-id');
	var typeId = $this.parent('label').attr('data-type-id');
	jQuery('option[value="'+id+'"]', jQuery('select[data-type="'+typeId+'"]')).prop('selected', false);
	jQuery('select[data-type="'+typeId+'"]').multiselect('refresh');
	if( $this.parents('div#treatment-tags').length > 0 ){
		removeBrandField(id);
		addRemoveValue('treatment-other-hidden',val,false);
	}
	$this.parent('label').remove();
	if( typeId == 1 ){
		if(id.match(/treatment-/g)){
			var val = $this.parent('label').text();
			addRemoveValue('treatment-other-hidden',val,false);
		}
	}
	if( typeId == 6 ){
		if(id.match(/side-effect-/g)){
			var val = $this.parent('label').text();
			addRemoveValue('other-side-effects',val,false);
		}
	}
	if( typeId == 5 ){
		if(id.match(/new/g)){
			var val = $this.parent('label').text();
			addRemoveValue('other-symptom-hidden',val,false);
		}		
		jQuery('#symptom-feedback-'+id).remove();
	}
});


// Search review 

// jQuery('#treatment-type-filter').multiselect({
// 	numberDisplayed               : 1,
// 	maxHeight                     : 400,
// 	enableFiltering               : true,
// 	enableCaseInsensitiveFiltering: true,
// 	dropRight                     : true,
// 	buttonText: function(options, select) {
// 		return select.attr('placeholder');
//     },
// 	onChange: function(element, checked) {		
// 		var value = element.val();
// 		var text = jQuery.trim(element.text());
//         if(checked == true) {
//         	ids = getTretmentIds();
//         	constructFilters(value);       	
//         } else if (checked == false) {
        	
//         }
//     }
// });

jQuery(document).on('change','#treatment-type-filter',function(){
	$this = jQuery(this);
	value = $this.val();
	var text = jQuery('#treatment-type-filter option:selected').text();
	text = jQuery.trim(text);
	if( value != '' ){
		jQuery('#box1').html(text+'<button type="button" class=" ml-3 btnCustom p-0"><img box-id="box1" class="remove-filter" src="'+templateURL+'/images/removeCircle.svg"/></button>');
		jQuery('#box1').show();
	}else{
		jQuery('#box1').html('').hide();
	}
	jQuery('#box2').html('').hide();
	constructFilters(value);
});

jQuery(document).on('change','.treatment-sub-type-filter',function(){
	if( jQuery(this).val() != '' ){
		var text = jQuery('.treatment-sub-type-filter option:selected').text();
		text = jQuery.trim(text);
		jQuery('#box2').html(text+'<button type="button" class=" ml-3  btnCustom p-0"><img box-id="box2" class="remove-filter" src="'+templateURL+'/images/removeCircle.svg"/></button>');
		jQuery('#box2').show();
	}else{
		jQuery('#box2').html('').hide();
	}
});

jQuery('#filters').multiselect({
	numberDisplayed               : 1,
	maxHeight                     : 400,
	enableFiltering               : true,
	enableCaseInsensitiveFiltering: true,
	dropRight                     : true,
	buttonText: function(options, select) {
		return select.attr('placeholder');
    },
	onChange: function(element, checked) {
		var value = element.val();
		var text  = jQuery.trim(element.text());
		var label = jQuery(element[0]).parent('optgroup').attr('label')
		// var tag   = label+' : '+text;
		var tag   = text;
        if(checked == true) {
			var labelHtml = '<label data-value="'+value+'" id="filter-'+value.replace(/[:<>]+/g,'')+'" class="multiple-filters custom-control-label selected br-5 font-weight-bold mb-2 ">'+tag+'<button type="button" class=" ml-3  btnCustom p-0"><img box-id="filter-'+value.replace(/[:<>]+/g,'')+'" class="remove-filter" src="'+templateURL+'/images/removeCircle.svg"></button></label> ';
        	jQuery('#filter-labels').append(labelHtml);
        } else if (checked == false) {
        	jQuery('#filter-'+value.replace(/[:<>]+/g,'')).remove();
        }
    }
});

jQuery(document).on('click','.remove-filter',function(){
	var id = jQuery(this).attr('box-id');	
	if(id == 'box1'){
		jQuery('#'+id).html('').hide();
		jQuery('#treatment-type-filter option[value=""]').prop('selected',true).change();
	}else if(id == 'box2'){
		jQuery('#'+id).html('').hide();
		jQuery('.treatment-sub-type-filter option[value=""]').prop('selected',true).change();
	}else{
		var val = jQuery('#'+id).attr('data-value');
		jQuery('#'+id).remove();
		jQuery('#filters option[value="'+val+'"]').prop('selected',false);
		jQuery('#filters').multiselect('refresh');
	}
});

jQuery(document).on('click','#filter-button',function(){
	params = getFilterParams();
	jQuery('#filter-box').html('');
	params.pagenum = 0;	
	getReviews(params);
});

jQuery(document).on('click','#more',function(){
	var params = getUrlParams();
	if( params != '' ){
		if( params.pagenum ){
			var page = parseInt(params.pagenum)
			var nextpage = page+1;
			params = getFilterParams();
			params.pagenum = nextpage;
			getReviews(params);
		}else{
			params.pagenum = 0;
			getReviews(params);
		}
	}else{
		params.pagenum = 0;
		getReviews(params);
	}
});

function getFilterParams(){
	var treatment_id = jQuery('#treatment-type-filter').val();
	var params = {'treatment_ids' : treatment_id};
	if( jQuery('.treatment-sub-type-filter').length > 0 ){
		var subtype_id = jQuery('.treatment-sub-type-filter').val();
		if(subtype_id != '' && subtype_id != undefined){
			params.subtype_id = subtype_id;
		}
	}
	var filter = jQuery('#filters').val();
	jQuery.each(filter,function(i,v){
		if(v.match(/age:/g)){
			var val = v.replace('age:','');
			params.age = val;
		}
		if(v.match(/periods:/g)){
			var val = v.replace('periods:','');
			params.periods = val;
		}
		if(v.match(/menopause:/g)){
			var val = v.replace('menopause:','');
			params.menopause = val;
		}
		if(v.match(/children:/g)){
			var val = v.replace('children:','');
			params.children = val;
		}
		if(v.match(/ethnicity:/g)){
			var val = v.replace('ethnicity:','');
			params.ethnicity = val;
		}
	});
	return params;
}

function constructFilters(treatment_id,append=false){
	var parsed = jQuery.parseJSON(filterData);
	treatment_id = parseInt(treatment_id);
	var detailsBox = ''; 
	var subtypeBox = '';
	var medicineBox = '';
	if( parsed[treatment_id] != undefined ){
		var details = parsed[treatment_id]['details'];
		if( details ){
			subtypeBox += '<select name="treatment_subtype" class="form-control form-control-lg treatment-sub-type-filter">';
			subtypeBox += '<option value="">Type</option>';
			jQuery.each(details,function(k,v){
				if( v['subtype'] && !jQuery.isEmptyObject(v['subtype']) ){
					jQuery.each(v['subtype'],function(a,b){
						if( !jQuery.isEmptyObject(b['medicines']) ){
							jQuery.each(b['medicines'],function(x,y){
								subtypeBox += '<option value="'+x+'">'+y+'</option>';
							});
						}else{
							subtypeBox += '<option value="'+a+'">'+b['title']+'</option>';
						}
					});					
				}else{
					subtypeBox += '<option value="'+k+'">'+v['title']+'</option>';
				}
			});
			subtypeBox += '</select>';
		}
	}
	jQuery('#filters-div2 select.treatment-sub-type-filter').remove();
	if( subtypeBox == '' ){
		jQuery('#filters-div2').html(addBlankSelectBox());
	}else{
		jQuery('#filters-div2').html(subtypeBox);
	}
	// if(append == 'detail'){		
		// jQuery('#filters-div2 select.treatment-sub-type-filter').remove();
		// jQuery('#filters-div2').html(subtypeBox);
	// }
	
}

function addBlankSelectBox(){
	return '<select class="form-control form-control-lg" disabled="true"><option>Type</option></select>';	
}

// function constructFilters(treatment_id,append=false){
// 	var parsed = jQuery.parseJSON(filterData);
// 	treatment_id = parseInt(treatment_id);
// 	var detailsBox = ''; 
// 	var subtypeBox = '';
// 	var medicineBox = '';
// 	if( parsed[treatment_id] != undefined ){
// 		var details = parsed[treatment_id]['details'];
// 		if( details ){
// 			detailsBox += '<select data-id="'+treatment_id+'" name="treatment_detail" class="form-control form-control-lg treatment-detail-filter">';
// 			detailsBox += '<option value="">--All--</option>';
// 			jQuery.each(details,function(k,v){
// 				detailsBox += '<option value="'+k+'">'+v['title']+'</option>';
// 				if( v['subtype'] && !jQuery.isEmptyObject(v['subtype']) ){
// 					subtypeBox += '<select name="treatment_subtype" id="review-filter-'+k+'" class="form-control form-control-lg treatment-sub-type-filter">';
// 					subtypeBox += '<option value="">--All--</option>';
// 					jQuery.each(v['subtype'],function(a,b){
// 						subtypeBox += '<option value="'+a+'">'+b['title']+'</option>';
// 						// if( !jQuery.isEmptyObject(b['medicines']) ){							
// 						// 	medicineBox += '<select id="review-filter-'+a+'" class="form-control form-control-lg">';
// 						// 	jQuery.each(b['medicines'],function(x,y){
// 						// 		medicineBox += '<option id="'+x+'">'+y+'</option>';
// 						// 	});
// 						// 	medicineBox += '</select>';
// 						// }
// 					});
// 					subtypeBox += '</select>';
// 				}
// 			});
// 			detailsBox += '</select>';
// 		}
// 	}
// 	if(append == 'detail'){
// 		jQuery('#filters-div select.treatment-detail-filter').remove();
// 		jQuery('#filters-div select.treatment-sub-type-filter').remove();
// 		jQuery('#filters-div').append(detailsBox);
// 	}else{
// 		jQuery('#filters-div select.treatment-sub-type-filter').remove();
// 		jQuery('#filters-div').append(subtypeBox);
// 	}
// 	// jQuery('#refrence').append(medicineBox);
// }

function getReviews(params = false, appendToURL=true){
	if(appendToURL){
		updateURL(params);
	}
	data = {'action' : 'get_reviews'};
	if(params){
		jQuery.each(params,function(k,v){
			data[k] = v
		});
	}
	jQuery.ajax({
        url : ajaxURL,
        type : 'POST',
        data : data,
        beforeSend: function(xhr){
        	var width = jQuery('#filter-box').width();
        	var height = jQuery('#filter-box').height() + 100;
        	var loader = '<div id="ajax-loader" class="d-flex align-items-center justify-content-center" style="position: absolute;height: '+height+'px;width: '+width+'px;background-color: black;opacity: 0.5;">'+
        					'<div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
    					'</div>';
        	jQuery('#filter-box').append(loader)
        },
        success : function(response){
        	if(appendToURL){
        		jQuery('.showmore').remove();
        		jQuery('.total_reviews').remove();
            	jQuery('#filter-box').append(response);
            	var show = jQuery('.showmore').val();
            	if(parseInt(show) == 1){
            		jQuery('#more').show();
            	}else{
            		jQuery('#more').hide();
            	}
            	jQuery('#box4').html(jQuery('.total_reviews').val()+' Reviews')
            	// var total = jQuery('.total_reviews').val();
            	// var divLength = jQuery('.singleReviewBox').length;
            	// if(divLength >= total){
            	// 	jQuery('#more').hide();
            	// }
        	}else{
        		jQuery('#filter-box').html(response);
        	}
        	jQuery('#ajax-loader').remove();
        }
    });
}

function getTretmentIds(){
	var ids = [];
	jQuery('.treatment-type-filter option:selected').map(function(a, item){ids.push(item.value)});
	return ids;
}

function getUrlParams(){
	var uri = window.location.toString();
	params = ''
	if( uri.indexOf('?') > 0 ){
		query = uri.substring(uri.indexOf('?')+1,uri.length);
		params = JSON.parse('{"' + query.replace(/&/g, '","').replace(/=/g,'":"') + '"}', function(key, value) {
			return key===""?value:decodeURIComponent(value) 
		});
	}
	return params;
}

function updateURL(params){
	var uri = window.location.toString();
	if (params != '' ){
		var query = '';
		if (uri.indexOf("?") > 0) {
    		var uri = uri.substring(0, uri.indexOf("?"));
		}
		jQuery.each(params,function(k,v){
			query += '&'+k+'='+v;
		});
		uri = uri+'?'+query.substring(1,query.length)
	}
	window.history.replaceState({}, document.title, uri);
}

// Autocomplete search
if( jQuery('#search-treatment').length > 0 ){

	jQuery('#search-treatment').autocomplete({
		source: function(request, response){
			jQuery.ajax({
				url : ajaxURL,
				type : 'POST',
				data : {
					'action' : 'get_treatments',
					'key' : request.term
				},
				success : function(res){
					if( res ){
						var parsed = jQuery.parseJSON(res);
						response(jQuery.map(parsed, function (item) {
				            return {
				                label: item.post_title,
				                value: item.post_title,
				                href : item.href
				            };
				        }));
					}
				}
			});
		},
		focus:function(event, ui){
			jQuery('#search-treatment').val(ui.item.label);
			jQuery('#search-treatment').attr('data-href',ui.item.href);
			return false;
		},
	    select: function( event, ui ) {
	    	window.location.href = ui.item.href;
	    }
	}).data('ui-autocomplete')._renderItem = function(ul, item){
		return jQuery( "<li></li>" )
	            .data( "item.autocomplete", item )
	            .append( "<a href='" + item.href + "'>" + item.label + "</a>" )
	            .appendTo( ul );
	}

	jQuery("#search-treatment").keydown(function(event){
	    if(event.keyCode == 13) {
	    	if( jQuery("#search-treatment").val().length == 0 ) {
	        	event.preventDefault();	          	
	      	}else{
	      		if( jQuery("#search-treatment").attr('data-href') != '' ){
	      			window.location.href = jQuery("#search-treatment").attr('data-href');
	      			showTabFromUrl();
	      		}
	      	}
	    }
	});

	jQuery("#search-button").click(function(event){
    	if( jQuery("#search-treatment").val().length == 0 ) {
        	event.preventDefault();
      	}else{
      		if( jQuery("#search-treatment").attr('data-href') != '' ){
      			window.location.href = jQuery("#search-treatment").attr('data-href');
      			showTabFromUrl();
      		}
      	}	    
	});

}

if( jQuery('#add-a-review-Section1').length > 0 ){
	var submitted = false;
	window.onbeforeunload = function (e) {
        if (!submitted) {
            var message = "Are you sure you want to leave ? You will lose all the content you have put in.";
            return message;
        }
    }
    jQuery("form#add-a-review-form").submit(function(event) {    	
    	submitted = true;
    });
    jQuery('#add-a-review-Section1').keypress(function(event){
    	var keycode = (event.keyCode ? event.keyCode : event.which);
		if(keycode == '13'){
			event.preventDefault();
		}
    });
}

jQuery(document).on('click','.is_treatment',function(){
	var val = jQuery(this).next().find('input').val();
	if( val == undefined ){
		jQuery('#why-did-you-stop').show();
	}else{
		jQuery('#why-did-you-stop').hide();
	}
});