define(function(require,exports,module){
//六边形课程显示	
	exports.showSexangleCourse = function(){

		var speed=200; // anime speed
		
		$("#img1").animate({
			opacity:1
		},speed,function(){
			$("#img2").animate({
				opacity:1
			},speed,function(){
				$("#img3").animate({
					opacity:1
				},speed,function(){
					$("#img4").animate({
						opacity:1
					},speed,function(){
						$("#img5").animate({
							opacity:1
						},speed,function(){
							$("#img6").animate({
								opacity:1
							},speed,function(){
								$("#img7").animate({
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