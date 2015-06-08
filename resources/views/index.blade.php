<!doctype html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>HTTP Request & Response Service</title>
    <style>
        body {
            font-family: monospace;
        }
        ul {
            list-style-type: none;
        }
        li {
            line-height: 2em;
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
        <li>/post </li>
        <li>/patch </li>
        <li>/put </li>
        <li>/delete </li>
        <li><a href='/encoding/utf8'>/encoding/utf8</a> returns a page containing utf-8 data</li>
        <li><a href='/gzip'>/gzip</a> returns gzip encoded data</li>
        <li><a href='/deflate'>/deflate</a> returns deflate encoded data</li>
        <li><a href='/status/418'>/status/:code</a> returns given http status code</li>


    </ul>

</div>


</body>
</html>

