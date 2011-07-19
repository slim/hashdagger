$(function(){
 
 $(document).ready(function() {
	$("#form_person").validate({
    rules: {
			password: {
				required: "#is_user:checked",
				minlength: 5
			},
			login: {
				required: "#is_user:checked",
				minlength: 4
			}
	}
    });
        
  if($(".is_user").is(':checked')) 
  {
  	$(".user_bloc").show();
  	$(".user_bloc_empty").hide();
  }
  else 
  {
  	$(".user_bloc").hide();
  	$(".user_bloc_empty").show();
  }
  
 });

 $(".is_user").change(function() { 

  if($(".is_user").is(':checked')) 
  {
  	$(".user_bloc").show();
  	$(".user_bloc_empty").hide();
  }
  else 
  {
  	$("#user_bloc").hide();
  	$(".user_bloc_empty").show();
  }
  
 });
 
});


