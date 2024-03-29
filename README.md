# fancy-filter

## Example
```PHP
$filter = FancyFilter::get('testfilter',['key_b'=>'default_b']);
$foo = $filter->key_a;
```
See more in `sample/example.php`

## Documentation

```PHP
class FancyFilter {
	public static get($name [, $defaults]) : FancyFilter
	public static set_escape_function($func) : void
	public static set_cookie_prefix($prefix) : void
	public static set_option($key, $value) : void
	public static set_option_array($options) : void
	public __get($key) : mixed
	public __isset($key) : bool
}
```

### FancyFilter::get(...)
```PHP
public static get($name [, $defaults]) : FancyFilter
```
Retrieves or creates the named filter.

Parameter | Type | Description
--- | --- | ---
`name` | String | The name of the filter.
`defaults` | Array | An associative array where defaults are read from. If a value isn't in the filter or in the defaults array, the value will default to `null`.

### FancyFilter::set_escape_function(...)
```PHP
public static set_escape_function($func) : void
```
Defines an escape function that will be used whenever a value is read from the object. Values written and stored in the cookie will not be escaped before next read.

Parameter | Type | Description
--- | --- | ---
`func` | Callable | The `callable` that will be given 1 argument (the pre-escaped value) and should return the corresponding escaped value.

### FancyFilter::set_cookie_prefix(...)
```PHP
public static set_cookie_prefix($prefix) : void
```
Defines the prefix that is prepended to the names of the cookies. The full cookie name will be `$prefix . $name`, where `$name` is the name of the filter. The prefix defaults to `ffilter_`.

Parameter | Type | Description
--- | --- | ---
`prefix` | String | The prefix to be used when naming cookies.

### FancyFilter::set_option(...)
```PHP
public static set_option($key, $value) : void
```
Sets an option for use when storing the cookies. See [setcookie on php.net](https://www.php.net/manual/en/function.setcookie.php) for the `options` array documentation.

Parameter | Type | Description
--- | --- | ---
`key` | String | An string which may be one of `expires`, `path`, `domain`, `secure`, `httponly` and `samesite`.
`value` | String | The value for the chosen key.

### FancyFilter::set_option_array(...)
```PHP
public static set_option_array($options) : void
```
Sets the options used when storing the cookies. See [setcookie on php.net](https://www.php.net/manual/en/function.setcookie.php) for the `options` array documentation.

Parameter | Type | Description
--- | --- | ---
`options` | Array | An associative array which may have any of the keys `expires`, `path`, `domain`, `secure`, `httponly` and `samesite`.

### FancyFilter->\_\_get(...)
```PHP
public __get($key) : mixed
```
Returns the value (or default value) in the filter with the given key. The value (or default value) is passed through the escape function before being returned, if an escape function is set.
Usage example for a key `foo`:
```
$result = $filter->foo;
```

Parameter | Type | Description
--- | --- | ---
`key` | String | The key of the value in the filter

### FancyFilter->\_\_isset(...)
```PHP
public __isset($key) : bool
```
Returns whether the value (or default value) is non-null. Usage example for a key `foo`:
```
$result = isset($filter->foo);
```

Parameter | Type | Description
--- | --- | ---
`key` | String | The key of the value in the filter