function testExistPhone(object)
{
	$.get(
    "../../person/exist/?phone="+object.value,
    function(data) { if(data) {alert(data); object.value=""; } }
    );
}

function testExistMail(object)
{
	$.get(
    "../../person/exist/?mail="+object.value,
    function(data) { if(data) { alert(data); object.value=""; } }
    );
}

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
			},
			email: {
				required: "#phone:blank"
			},
			phone: {
				required: "#email:blank"
			}
	}
    });
        
 });

});


