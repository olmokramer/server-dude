//Manages the width of the sidebars and makes it possible to hide them
sidebars = {

	init: function(){
		$('#sidebar_left').click(function(){
			sidebars.resizeLeft(200);
		});
		$('#sidebar_right').click(function(){
			sidebars.resizeRight(100);
		});
		$('#sidebar_left').dblclick(function(){
			sidebars.hideLeft();
		});
		$('#sidebar_right').dblclick(function(){
			sidebars.hideRight();
		});
	},
	hideLeft: function(){
		$('#main').css({
			'padding-left':'0'
		});	
		$('#sidebar_left').css({
			'display':'none'
		});
	},
	hideRight: function(){
		$('#main').css({
			'padding-right':'40px'
		});
		$('#sidebar_right').css({
			'display':'none'
		});
	},
	resizeLeft: function(change){
		$('#sidebar_left').css({
			'width':'+='+change,
			'right':'+='+change,
		});
		$('#main').css({
			'padding-left':'+='+change
		});	
		$('body').css({
			'min-width':'+='+2*change
		});
	},
	resizeRight: function(change){
		$('#sidebar_right').css({
			'width':'+='+change
		});
		$('#main').css({
			'padding-right':'+='+change
		});	
		$('body').css({
			'min-width':'+='+change
		});
	}
}