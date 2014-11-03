seajs.config({
  base: "/assets/scripts/spm_modules/",
  alias: {
    "jquery": "jquery/1.10.1/jquery.js",
    "$": "jquery/1.10.1/jquery.js",
    "bootstrap": "bootstrap/3.2.0/js/bootstrap.js",
    "transit": "transit/0.9.9/jquery.transit.js",
    "star-rating": "plugins/star-rating.min.js",
    "videojs": "plugins/video.min.js",
    "renaissance-base": "renaissance/1.0/base.js",
    "arale-base": "arale-base/1.2.0/base.js",
    "arale-events": "arale-events/1.2.0/events.js",
    "arale-class": "arale-class/1.2.0/class.js",
    "arale-widget": "arale-widget/1.2.0/widget.js",

    'map': [
    	[ /^(.*\.(?:css|js))(.*)$/i, '$1?20140801' ]
  	],
  }
})

