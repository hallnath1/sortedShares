$(document).ready( function() {
	$(".profileDisplay").click(function(){
		if($(this).css("opacity") == 0.5) {
			$(this).css("opacity","1");
			$(this).css("border","3px solid limeGreen");
		}
		else{
			$(this).css("opacity","0.5");
			$(this).css("border","3px solid red");
		}
		return false;
	});	
	
	
	
	
	$("#form").submit(function(){
	
		var name = $('.newText').val();
		var data = new Array(name);
		$('.profileDisplay').each(function () {
		    if($(this).css("opacity") == 1){
		    	data.push($(this).attr('id'));
		    }
		});
		
		$.post("createGroupProcessing.php",
		{
			array: JSON.stringify(data)
		});
	});
});