$(document).ready( function() { 

  $('#form').submit(
	function() {
		$(".alert").each(function(){$(this).empty();});
		var username = $('#username').val();
		var password = $('#password').val();
		$.post("loginCheck.php",
		{
		    uName: username,
		    user_password: password,
		    js: '1'
		}, 
		function(data)
		{
		  if(data != 'error'){
			var address = window.location.href.split('/');
			address[address.length-1] = 'index.php';
			window.location.assign(address.join('/'))
		  }
		  else{
			$('#2').text('Username or Login Incorrect!');
			$('#2').css('height','auto');
			$('#username').css('background-color','#FFA3A3');
			$('#password').css('background-color','#FFA3A3');
		  }
		});
		return false;
	});
	
});