define(function(require,exports,module){
	var plaza_nav = require('./plazaNav.js');
	var page_next = require('./pageAjax.js');
	exports.run = function(){
			plaza_nav.run();
			$(document).on('click','#get_more',getMore);
	}
	function getMore(){
		var dom = $(this);
		var object = dom.attr("append-to-id");
		var next_page = dom.attr("next-page");
		var path = dom.attr("go-to");
		dom.find("p").html("加载中....");
		$(document).off('click','#get_more',getMore);
		setTimeout(function(){
			page_next.toNextPage (object,next_page,path,function(){
				dom.fadeOut(500);
				setTimeout(function(){
					$(document).on('click','#get_more',getMore);
				},600);
			
			});
		},300);
	       
}});