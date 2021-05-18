$(document).ready(function() {
	$("#login-button").click( function() {
		if(($("input[name='usr']").val()!=false)&&($("input[name='psw']").val()!=false)){
			if(($("input[name='usr']").val().length >= 3)&&($("input[name='usr']").val().length < 64)&&($("input[name='psw']").val().length >= 3)&&($("input[name='psw']").val().length < 64)){
				$.ajax({
					type: "POST",
					url: "http://gikon.ru/login",
					data: {usr:$("input[name='usr']").val(),psw:$("input[name='psw']").val()},
					dataType: "html",
					success: function(data){
						if((data!=false) && (data != '1')){
							alert(data);
						}
						location.reload();
					}
						
				});
			}
		}
		else{
			alert('Введите логин и пароль');
		}
	});
	$("#add-task").click( function() {
		var user = $("input[name='user']").val();
		var email = $("input[name='email']").val();
		var text = $("textarea[name='task']").val();
		if(user==false || email==false || text==false) { alert("Заполните все поля формы!"); return; }
		$.ajax({
			type: "POST",
			url: "http://gikon.ru/add-task",
			data: {user:user,email:email,text:text},
			dataType: "html",
			success: function(data){
				alert(data);
				location.reload();
			}
		});
	});
	$(".sorting").click( function() {
		var sorting = $(this).attr('id');
		var d = $(this).attr('d');
		$.ajax({
			type: "POST",
			url: "http://gikon.ru/sorting",
			data: {sorting:sorting,d:d},
			dataType: "html",
			success: function(data){
				var f = data;
				$(".task_table").remove();
				$("#title").after(data);
			}
		});
	});
	$(".usr_adm, .email_adm, .task_text_adm, .status_adm").dblclick( function() {
		var id = $(this).attr('id');
		if(id=="blocked") return;
		var cl = $(this).attr('class');
		var str = $(this).attr('str');
		var i = $(this).attr('i');
		var v = $(this).html();
		$.ajax({
			type: "POST",
			url: "http://gikon.ru/edit",
			data: {cl:cl,v:v,str:str},
			dataType: "html",
			success: function(data){
				if(data==false) { location.reload(); return; }
				$("td[str='"+str+"']").attr('id','blocked');
				$("td[str='"+str+"']").empty();
				$("td[str='"+str+"']").html(data);
				$("#"+cl).bind("click", function(){
				var input_data = $("input[str='"+str+"']").val();
					$.ajax({
						type: "POST",
						url: "http://gikon.ru/confirm",
						data: {v:v,input_data:input_data,str:str,i:i},
						dataType: "html",
						success: function(data){
							alert(data);
							location.reload();
						}
					});
				});
			}
		});
	});
	function Confirm(str) {
		alert(str);
	}
	$("#logout").click( function() {
		$.ajax({
			type: "POST",
			url: "http://gikon.ru/logout",
			dataType: "html",
			success: function(data){
				location.reload();
			}
		});
	});
});