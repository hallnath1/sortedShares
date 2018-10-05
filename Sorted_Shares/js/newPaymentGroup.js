$(document).ready( function() {
	$(".profileDisplay").click(function(){
		
		var id = "#" + $(this).attr('id');
		if($(this).css("opacity") == 0.5) {
			$(this).css("opacity","1");
			$(this).css("border","3px solid limeGreen");
			$('#people').find(id).show();
		}
		else{
			$(this).css("opacity","0.5");
			$(this).css("border","3px solid red");
			$('#people').find(id).hide();
			$('#people').find(id).find('.amountSplit').val('0.00');
			$('#people').find(id).find('.percentSplit').val('');
		}
		updateAmount();
		return false;
	});	
	
	$('#money').change(function () {
		updateAmount();
	});
	
	$('.percentSplit').change(function () {
		var percent = ($(this).val()/100);
		var value = $('#money').val();
		$(this).parent().parent().find('.amountSplit').val(value*percent);
		var check = 0;
		$('.person').each(function () {
			check += parseFloat($(this).find('.percentSplit').val());
		});
		check = Math.ceil(check);
		if(check != 100){
			$('#button').css('opacity','0.2');
			$('#alertDiv').text('Percentages do not add up!');
		}
		else{
			$('#button').css('opacity','1');
			$('#alertDiv').text('');
		}
		updateMoney();

	});
	
	
	$("#form").submit(function(){
		var check = 0;
		$('.person').each(function () {
			if ($(this).css('display') != 'none'){
				check += parseFloat($(this).find('.percentSplit').val());
			}
		});
		check = Math.ceil(check);
		if(check != 100){
			return false;
		}
		else{
			return true;
		}
	});
});

function updateAmount(){
	updatePercent();
	updateMoney();
}

function updatePercent(){
	var count = 0;
	$('.person').each(function () {
		if ($(this).css('display') != 'none'){
			count += 1;
		}
	});

	var amount = $('#money').val();
	$('.person').each(function () {
		if ($(this).css('display') != 'none'){
			var percent = (100/count).toFixed(2);
			$(this).find('.percentSplit').val(percent);
		}
	});
}

function updateMoney(){
	var amount = $('#money').val();
	
	$('.person').each(function () {
		if ($(this).css('display') != 'none'){
			var message = ($(this).find('.percentSplit').val()/100)*amount;
			$(this).find('.amountSplit').val(message.toFixed(2));
		}
	});
}