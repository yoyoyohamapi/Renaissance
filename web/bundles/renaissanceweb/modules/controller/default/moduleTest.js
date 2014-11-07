define(function(require, exports, module) {
	var Widget = require('arale-widget');
	exports.run = function(){
		var WidgetA = Widget.extend({
			element: "#main",
			events: {
				'click h1': 'heading',
			},

			heading: function(){
				this.$('h1').html("OOOOO");
			}
		});

		var a = new WidgetA();
	}
});