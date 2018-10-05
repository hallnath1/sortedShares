$(document).ready( function() { 
	$('#form').submit(
	function() {
		$(".alert").each(function(){$(this).empty();});
		var email = $('#email').val();
		var password = $('#password').val();
		var passwordCheck = $('#password_check').val();
		var ok = 1;
		
		$('#password_check').css('background-color','green');
		$('#password').css('background-color','green');
		$('#email').css('background-color','green');
		
		if(password!=passwordCheck){
			$("#1").text("Passwords Do Not Match!");
			$("#1").css('height','auto');
			$('#password').css('background-color','red');
			$('#password_check').css('background-color','red');
			ok = 0;
		}
		
		if(!((password.length < 15) && (password.length > 6))){
			$("#4").text("Password must be between 7 and 14 characters!");
			$("#4").css('height','auto');
			$('#password').css('background-color','red');
			ok = 0;
		}
		
		$.post("usernameExists.php",
		{
		    username: $('#username').val()
		}, 
		function(data)
		{
		  if(data=='exists'){
		    $('#username').css('background-color','red');
		    $("#2").text("Username is alreay in use!");
		    $("#2").css('height','auto');
		    ok=0;
		  }
		  else{
		      $('#username').css('background-color','green');
		      $("#2").text('');
		      $("#2").css('height','0');
		  }
		});
		
		
		if(!isValidEmailAddress(email)){
			$("#3").text("Not a valid Email!");
			$("#3").css('height','auto');
			$('#email').css('background-color','red');
			ok = 0;
		}
		
		if(ok==0){
			$(".alert").css('height','auto');
			return false;
		}
		else{
			return true;
		  
		}
	});
	
	$('#username').change(function(){
	  $.post("usernameExists.php",
	  {
	      username: $('#username').val()
	  }, 
	  function(data)
	  {
	    if(data=='exists'){
	      $('#username').css('background-color','red');
		$("#2").text("Username is alreay in use!");
					$("#2").css('height','auto');
	    }
	    else{
	      $('#username').css('background-color','green');
		$("#2").text('');
					$("#2").css('height','0');
	    }
	  });
	});
	
	$('#email').change(function(){
	  var email = $(this).val();
	  $('#email').css('background-color','green');
	  $("#3").css('height','0');
	  $("#3").text("");
	  if(!isValidEmailAddress(email)){
			$("#3").text("Not a valid Email!");
			$('#email').css('background-color','red');
			$("#3").css('height','auto');
			ok = 0;
		}
	});
	
	
	$('#password').change(function(){
		passwordChecker();
	});
	
	$('#password_check').change(function(){
		passwordChecker();
	});
});

function isValidEmailAddress(emailAddress) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
}

function passwordChecker(){
    		var password = $('#password').val();
		var passwordCheck = $('#password_check').val();
	  	$('#password_check').css('background-color','green');
		$('#password').css('background-color','green');
		
		if(password!=passwordCheck){
			$("#1").text("Passwords Do Not Match!");
			$("#1").css('height','auto');
			$('#password').css('background-color','red');
			$('#password_check').css('background-color','red');
		}
		else{
			$("#1").text("");
			$("#1").css('height','0');
			$('#password').css('background-color','green');
			$('#password_check').css('background-color','green');
		}
		
		if(!((password.length < 15) && (password.length > 6))){
			$("#4").text("Password must be between 7 and 14 characters!");
			$("#4").css('height','auto');
			$('#password').css('background-color','red');
		}
		else{
			$("#4").text("");
			$("#4").css('height','0');
			$('#password').css('background-color','green');
		}
}