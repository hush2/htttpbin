<!doctype html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>HTTP Request & Response Service</title>
    <style>
        body {
            font-family: monospace;
            padding-left: 100px;
        }
        ul {
            list-style-type: none;
        }
        li {
            line-height: 1.8em;
            color: #333;
        }
        h1 {
            color: #111;
        }
    </style>
</head>
<body>

<h1>http request & response service</h1>

<div>
    <h3>endpoints</h3>
    <ul>
        <li><a href='/'>/</a> this page</li>
        <li><a href='/ip'>/ip</a> returns origin ip</li>
        <li><a href='/user-agent'>/user-agent</a> returns the browsers user-agent</li>
        <li><a href='/headers'>/headers</a> returns request headers</li>
        <li><a href='/get?field1=value1&field2=value2'>/get</a> returns GET data & query strings</li>
        <li><a href="/post">/post</a> returns POST data </li>
        <li><b>/patch</b></li>
        <li><b>/put</b></li>
        <li><b>/delete</b></li>
        <li><a href='/encoding/utf8'>/encoding/utf8</a> returns a page containing utf-8 data</li>
        <li><a href='/gzip'>/gzip</a> returns gzip encoded data</li>
        <li><a href='/deflate'>/deflate</a> returns deflate encoded data</li>
        <li><a href='/status/418'>/status/:code</a> returns given http status code</li>
        <li><a href='/response-headers?Content-Type=text/plain;%20charset=UTF-8&X-Powered-By=httpbin;'>/response-headers?key=val</a> returns given response header</li>
        <li><a href='/redirect/6'>/redirect/:n</a> 302 redirect <i>n</i> times</li>
        <li><a href='/redirect-to?url=http://example.com'>/redirect-to?url=foo</a> 302 redirects to the <i>foo</i> url</li>
        <li><a href='/relative-redirect/6'>/relative-redirect/:n</a> 302 relative redirect <i>n</i> times</li>
        <li><a href='/absolute-redirect/6'>/absolute-redirect/:n</a> 302 absolute redirect <i>n</i> times</li>
        <li><a href='/cookies/'>/cookies</a> returns cookie data</li>
        <li><a href='/cookies/set?cookie=oreo'>/cookies/set?cookie=oreo</a> sets one or more cookie data</li>
        <li><a href='/cookies/delete?cookie=oreo'>/cookies/delete?cookie=oreo</a> deletes one or more cookie data</li>
    </ul>
</div>

</body>
</html>

