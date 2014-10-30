define(function(require, exports, module) {
	var sexangle_mgr = require('./sexangle.js');
	exports.run = function(){
		$(window).scroll(function(){
			//alert(opt.max);
			var adjust=$(window).width()*0.3;
			var max = adjust+102+520+220+$("#courseRect").height();
			if(($(window).height()+$(window).scrollTop()) >= max){
		    	sexangle_mgr.showSexangleCourse();
			}
		});
		// 控制六边形切换逻辑
		$(".sexangleImg").mouseenter(function(){
			$(this).attr("src",$(this).attr("after"));

		});
		$(".sexangleImg").mouseleave(function(){
			$(this).attr("src",$(this).attr("before"));
		});

		//可爱的注册闪动
		$("#regBtn").click(function(){
			$("html,body").animate({
				scrollTop:$("#bodyWrapper").offset().top
			},500,function(){
				$("#formul").animate({
					paddingTop:"35"
				},100,function(){
				$("#formul").animate({
					paddingTop:"40"
				},100,function(){
				$("#formul").animate({
					paddingTop:"35"
				},100,function(){
				$("#formul").animate({
					paddingTop:"40"
				},100);
				});
				});
				});
			});
		});
		//显示介绍Modal
		$("a#show_modal").click(function(){
			$('#myModal').modal('toggle');
		});
	}
});