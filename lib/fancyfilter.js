var FancyFilter = (function(){
	var filter_prefix = 'ffilter_';
	var cookie_cache = undefined;

	function read_cookies(){
		if(typeof cookie_cache == 'undefined'){
			var cookie_string = document.cookie.split(';');
			cookie_cache = {};
			for(var i=0;i<cookie_string.length;i++){
				var cookie = cookie_string[i].trim().split('=');
				try {
					cookie_cache[cookie[0]] = JSON.parse(decodeURIComponent(cookie[1]));
				} catch {
					continue;
				}
			}
		}
	}

	function write_cookie(name){
		if(cookie_cache && cookie_cache[name]){
			document.cookie = name+'='+encodeURIComponent(JSON.stringify(cookie_cache[name]));
		}
	}

	function set(filtername, key, value){
		read_cookies();
		filtername = filter_prefix+filtername;
		var cookie = cookie_cache[filtername];
		cookie[key] = value;
		write_cookie(filtername);
	}

	function set_filter_prefix(prefix){
		filter_prefix = prefix;
	}

	return {
		set:set,
		set_filter_prefix:set_filter_prefix
	}
})()
