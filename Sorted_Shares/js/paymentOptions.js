$(document).ready( function() {
    
	$(".paypalOption").click(function(){
        var win = window.open("https://www.paypal.me/"+$(this).attr('id2')+"/"+($(this).attr('id3')/100)+"gbp", '_blank');
        if (win) {
            //Browser has allowed it to be opened
            win.focus();
        }
        else {
            //Browser has blocked it
            alert('Please allow popups for this website');
        }
        window.location.href = "paymentSend.php?id=" + $(this).attr('id1')+"&amount="+$(this).attr('id3');
        return false;
	});	
    
    
	

});