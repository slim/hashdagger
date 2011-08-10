$(function(){
 
 $(document).ready(function() {
	$("#form_password").validate({
    rules: {
			password: {
				minlength: 5,				
			},
			password2: {
				minlength: 5,
				equalTo: "#password"
			},
			login: {
				minlength: 4
			}
	}
    });
        
 });

});


