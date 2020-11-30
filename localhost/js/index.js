
$(document).ready(function(){ 


$("#createLot").on("click", function(){
	
	var count = 	$("#count").val().trim();
    var percent = 	$("#percent").val().trim();   
    var days = 		$("#days").val().trim();
	
	if((count == '') || (percent == '') || (days == '') )
	{
		$("#errorLC").text("введите данные");
		return false;
	}

	$.ajax({
		type:'POST',
		url:'ajax/LotCr.php',
		data:{count:count,percent:percent,days:days},
		beforeSend: function(){
			$("#createLot").attr("disabled", true);
	}}).done(function(data){
			$("#errorLC").text(data);
			$("#createLot").attr("disabled", false);
			cleanInp();
		})
	}); 
	
	function cleanInp()
	{
		$("#count").val("");
		$("#percent").val("");
		$("#days").val("");
	}
});