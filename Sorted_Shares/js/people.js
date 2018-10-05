$(document).ready( function() {
	$(".extraInfo").each(function(){
		$(this).hide();
	});
	
	$(".expandClick").click(function(event) {
		var $target = $(this).parent().parent().parent().next();
		var isVisible = $target.is(':visible');
 
		if (isVisible === true) {
			$target.hide();
			$(this).attr('src','icons/expandM(black).png');
		} else {
			$target.show();
			$(this).attr('src','icons/expandL(black).png');
		}
	});
});