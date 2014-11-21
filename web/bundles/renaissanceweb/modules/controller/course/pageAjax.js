define(function(require,exports,module){
	exports.toNextPage = function(object,next_page,path,system,category,callback) {
			$dom=$("#"+object);
			$.ajax({
				url:path,
				data:{object:object,pageno:next_page,system:system,category:category},
				type:'get',
				dataType:'html',
				success:function(html){
					callback();
					setTimeout(function(){
						$dom.append(html)
					},500);
				}
			});
		}
});