$(function(){
	//判断是否是移动设备 
	var isMobile = {
    	Android: function() {
        	return navigator.userAgent.match(/Android/i) ? true : false;
    	},
    	BlackBerry: function() {
        	return navigator.userAgent.match(/BlackBerry/i) ? true : false;
    	},
    	iOS: function() {
        	return navigator.userAgent.match(/iPhone|iPad|iPod/i) ? true : false;
    	},
    	Windows: function() {
        	return navigator.userAgent.match(/IEMobile/i) ? true : false;
    	},
    	any: function() {
        	return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Windows());
    	}
    };
	iden=isMobile; //lcx-debug
	/*
    if( isMobile.any() ){
    	alert("移动设备");
    }else{
    	alert("pc");
    	showSexangleCourse(); 
    }
	*/
});

//六边形课程显示
function showSexangleCourse(){

	var speed=200; // anime speed
	
	$("#imgOne").animate({
		opacity:1
	},speed,function(){
		$("#imgTwo").animate({
			opacity:1
		},speed,function(){
			$("#imgThree").animate({
				opacity:1
			},speed,function(){
				$("#imgFour").animate({
					opacity:1
				},speed,function(){
					$("#imgFive").animate({
						opacity:1
					},speed,function(){
						$("#imgSix").animate({
							opacity:1
						},speed,function(){
							$("#imgSeven").animate({
								opacity:1
							},speed,function(){
								$("#courseTitleRect").css("background-size","91.7% auto");
							});
						})
					})
				})
			})
		})
	});
}
$(function(){
	$("#imgOne").mouseenter(function(){
		$("#imgOne").attr("src","img/frontpage/sexangle4after.png");
	});
	$("#imgOne").mouseleave(function(){
		$("#imgOne").attr("src","img/frontpage/sexangle1.png");
	});
	$("#imgTwo").mouseenter(function(){
		$("#imgTwo").attr("src","img/frontpage/sexangle4after.png");
	});
	$("#imgTwo").mouseleave(function(){
		$("#imgTwo").attr("src","img/frontpage/sexangle2.png");
	});
	$("#imgThree").mouseenter(function(){
		$("#imgThree").attr("src","img/frontpage/sexangle4after.png");
	});
	$("#imgThree").mouseleave(function(){
		$("#imgThree").attr("src","img/frontpage/sexangle3.png");
	});
	$("#imgFour").mouseenter(function(){
		$("#imgFour").attr("src","img/frontpage/sexangle4after.png");
	});
	$("#imgFour").mouseleave(function(){
		$("#imgFour").attr("src","img/frontpage/sexangle4.png");
	});
	$("#imgFive").mouseenter(function(){
		$("#imgFive").attr("src","img/frontpage/sexangle4after.png");
	});
	$("#imgFive").mouseleave(function(){
		$("#imgFive").attr("src","img/frontpage/sexangle5.png");
	});
	$("#imgSix").mouseenter(function(){
		$("#imgSix").attr("src","img/frontpage/sexangle4after.png");
	});
	$("#imgSix").mouseleave(function(){
		$("#imgSix").attr("src","img/frontpage/sexangle6.png");
	});
	$("#imgSeven").mouseenter(function(){
		$("#imgSeven").attr("src","img/frontpage/sexangle4after.png");
	});
	$("#imgSeven").mouseleave(function(){
		$("#imgSeven").attr("src","img/frontpage/sexangle7.png");
	});
});
