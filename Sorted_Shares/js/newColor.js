$(document).ready( function() {
    $('#2').change(function(){
        var gradient = 'linear-gradient(to bottom right,' + $('#1').val() + ', ' + $('#2').val();
        $('#new').css('background', gradient);
	});	
    
    $('#1').change(function(){
        $('#2').val($('#1').val());
        var gradient = 'linear-gradient(to bottom right,' + $('#1').val() + ', ' + $('#2').val();
        $('#new').css('background', gradient);
	});	
});