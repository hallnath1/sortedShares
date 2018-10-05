$(document).ready( function() {
	var owed = 0;
	$('.amountDisplay').each(function () {
		owed += parseFloat($(this).attr('id'));
	});

	var difference = $('.difDisplay').attr('id');

	if(difference == null){
		difference = 0;
	}
	
	var width = ((owed-difference)/(owed+(owed - difference)))*100;

	if(!isNaN(width)){
		$('.redBar').css("width",String(width) + "%");
	}
	else{
		$('.redBar').css("width","0%");
		$('.barBase').css("background-color","rgba(132,178,225,1)");
	}
	
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