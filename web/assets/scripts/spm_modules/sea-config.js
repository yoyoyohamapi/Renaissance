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
    'map': [
    	[ /^(.*\.(?:css|js))(.*)$/i, '$1?20140801' ]
  	],
  }
})

