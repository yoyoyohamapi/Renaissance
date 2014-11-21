define(function(require,exports,module){
	exports.run = function(){
		$('#doJoin').click(function(){
			var btn = $(this);
			var course_id = btn.attr('name').split('-')[0];
			var user_id = btn.attr('name').split('-')[1];
			var salt = btn.attr('name').split('-')[2];
			
			$.ajax({
				url:"/enroll_course",
				type:"post",
				data:"course_id="+course_id+"&user_id="+user_id+"&salt="+salt,
				dataType:"json",
				success : function(data){
					if(data.status == 0)
					{
						alert("加入失败");
					}else{
						btn.attr("id",btn.attr("post_id"));
						btn.attr("value",btn.attr("post_value"));
						btn.attr("onclick",btn.attr("post_href"));
						btn.attr("style",btn.attr("post_style"));
						btn.attr("disabled",btn.attr("post_disabled"));
					}
				}
			});	
		});
	}
});