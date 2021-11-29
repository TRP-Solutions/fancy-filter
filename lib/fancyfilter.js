var FancyFilter = (function(){
	var filter_prefix = 'ffilter_';

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

	function set(filtername, key, value){
		filtername = filter_prefix+filtername;
		var cookie = read_cookie(filtername);
		cookie[key] = value;
		document.cookie = filtername+'='+encodeURIComponent(JSON.stringify(cookie));
	}

	function set_filter_prefix(prefix){
		filter_prefix = prefix;
	}

	return {
		set:set,
		set_filter_prefix:set_filter_prefix
	}
})()
