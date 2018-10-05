$(document).ready( function() {
	$(".profileDisplay").click(function(){
		
		$(".profileDisplay").css("opacity","0.5");
		$(".profileDisplay").css("border","3px solid red");
		
		$(this).css("opacity","1");
		$(this).css("border","3px solid limeGreen");
		
		$('#payerID').val($(this).attr('id')).trigger('change');
		return false;
	});	
});