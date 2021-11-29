var FancyFilter = (function(){
	var filter_prefix = 'ffilter_';
	var options = {};

	function read_cookie(filtername){
		var cookies = document.cookie.split(';');
		for(var i=0;i<cookies.length;i++){
			var cookie = cookies[i].trim().split('=');
			if(cookie[0]==filtername){
				try {
					return JSON.parse(decodeURIComponent(cookie[1]));
				} catch {
					console.log('Malformed cookie value:',cookie[1]);
				}
				break;
			}
		}
		return {};
	}

	var store_options = ['path','domain','max-age','expires','secure','samesite'];
	function write_cookie(name, value){
		var cookie = name+'='+encodeURIComponent(JSON.stringify(value));
		for(var i=0;i<store_options.length;i++){
			if(options[store_options[i]]) cookie += ';'+store_options[i]+'='+options[store_options[i]];
		}
		document.cookie = cookie;
	}

	function set(filtername, key, value){
		filtername = filter_prefix+filtername;
		var cookie = read_cookie(filtername);
		cookie[key] = value;
		write_cookie(filtername, cookie);
	}

	function set_filter_prefix(prefix){
		filter_prefix = prefix;
	}

	function set_option(option, value){
		options[option] = value;
	}

	return {
		set:set,
		set_option:set_option,
		set_filter_prefix:set_filter_prefix
	}
})()
