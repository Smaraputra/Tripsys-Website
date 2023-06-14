$(document).ready(function() {
	var valid_login = $("#user").text();
	var test = "Anda Belum Login (!)";
	if(valid_login!=test){
		$("#showsignup").hide();
		$("#showlogin").hide();
		$('#showlogin').text('Log Out');
	}
	$("#user").click(function() {
		$("#showlogin").show();
	});

});