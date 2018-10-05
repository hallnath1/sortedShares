$(document).ready( function() {
	var username = $(this).find('.profileDisplay').attr('id');
	
	var nameP = $('.profileDisplay').first('p').text();
	$(".messageReciever").html(nameP);
	
	displayMessages(username);
	$('.messageContent').scrollTop(1E10);
	
	$(".profileDisplay").click(function(){
		var nameP = $(this).find('p').text();
		$(".messageReciever").html(nameP);
		
		var username = $(this).attr('id');
		$(".profileDisplay").css("background-color","white");
		$(this).css("background-color","rgba(100,100,100,0.5)");
		$('.messageContent').scrollTop(1E10);
		displayMessages(username);
		
		return false;
	});
	
	$('#clear').click(function(){
		$.post("clearContent.php");
		return false;
	});
	
	$("#form").submit(function(){
		var message = $('.newText').val();
		if(message != ''){
			$.post("sendMessage.php",
			{
				message: message
			});
			displayMessages('');
			$('.messageContent').scrollTop(1E10);
		}
		$('.newText').val('');
		
		return false;
	});
	
	setInterval(function(){ 
		displayMessages('');
	}, 500);
	
});

function displayMessages(username){
	
	$.post("messageDisplay.php",
	{
		username: username
	},
	function(data,status){
		$('.messageContent').html(data);
	});
}