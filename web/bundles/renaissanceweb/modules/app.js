define(function(require, exports, module) {
	window.$ = window.jQuery = require('jquery');
	require('bootstrap');
	require('transit');
	var renaissance_base = require('renaissance-base');
	renaissance_base.run();
	exports.load = function(name) {
		name = 'http://'+window.location.host + '/bundles/renaissanceweb/modules/controller/' + name +'.js';
		seajs.use(name, function(module) {
			// Auto Run
			if ($.isFunction(module.run)) {
				module.run();
			}
		});

	};
	//Load the Controller
	if (app.action) {
		exports.load(app.action);
	}

});