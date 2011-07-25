$(function(){
 
 $(document).ready(function() {
	$("#form_person").validate({
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


