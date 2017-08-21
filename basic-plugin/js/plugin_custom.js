jQuery(document).ready(function(){

	quicktags({
		id :   'about_author',
		buttons : 'em,strong,link',
		title	: 'Vivek'
		});

	jQuery('.cust_meta_block').find('.quicktags-toolbar').prev().css('top','10px');

});