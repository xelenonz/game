function check_availability(){

		//get the username
		var username = $('#username').val();

		//use ajax to run the check
		$.post("check_user.php", { username: username },
			function(result){
				//if the result is 1
				if(result == 1){
					//show that the username is available
					$('#result').html(username + ' is Available');
				}else{
					//show that the username is NOT available
					$('#result').html(username + ' is not Available');
				}
		});

}