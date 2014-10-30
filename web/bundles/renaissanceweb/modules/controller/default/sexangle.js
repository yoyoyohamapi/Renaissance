define(function(require,exports,module){
//六边形课程显示	
	exports.showSexangleCourse = function(){

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

});