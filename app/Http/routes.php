<?php
use Illuminate\Http\Request;


function getHeaders($request) {
    $all = $request->headers->all();
    $headers = [];
    foreach ($all as $k => $v) {
        $headers[$k] = $v[0];
    }
    ksort($headers);
    return ['headers' => $headers];
}

function getOrigin($request) {
    return ['origin' => $request->server->get('REMOTE_ADDR')];
}
//----------------------------
$app->get('/', function() {
    return view('index');
});

$app->get('/ip', function(Request $request) {
    return ['origin' => $request->server->get('REMOTE_ADDR')];
//    return ['origin' => $request->server->all()];
});

$app->get('/user-agent', function(Request $request) {
    return ['user-agent' => $request->header('user-agent')];

});

$app->get('/headers', function(Request $request)  {
    return getHeaders($request);
});


$app->get('/get', function(Request $request)  {

    $json = [];
    $all = $request->headers->all();
    $headers = [];
    foreach ($all as $k => $v) {
        $headers[$k] = $v[0];
    }
    ksort($headers);

    $json['query']   = $request->query->all();
    $json['headers'] = $headers;
    $json['origin']  = $request->server->get('REMOTE_ADDR');
    $json['url']     = $request->fullUrl();

    return $json;
});

$app->get('/encoding/utf8', function()  {
    //header('Content-Type: text/html; charset=utf-8');
    return file_get_contents(base_path() . '/public/utf-8-demo.txt');
});

$app->get('/gzip', function(Request $request)  {

        $data = getHeaders($request);
        $data['gzipped'] = true;
        $data['method'] = 'GET';
        $data = array_merge($data, getOrigin($request));

        $gzip = gzencode(json_encode($data));

        header('Content-Encoding: gzip');
        header('Content-Type: text/json');
        header('Content-Length: ' . strlen($gzip));

        return $gzip;
});

$app->get('/deflate', function(Request $request)  {

    $data = getHeaders($request);
    $data['deflated'] = true;
    $data['method'] = 'GET';
    $data = array_merge($data, getOrigin($request));

    $deflate = gzdeflate(json_encode($data));

    header('Content-Encoding: deflate');
    header('Content-Type: text/json');
    header('Content-Length: ' . strlen($deflate));

    return $deflate;
});

$ASCII_ART = <<<ASCII_ART
    -=[ teapot ]=-

       _...._
     .'  _ _ `.
    | ."` ^ `". _,
    \_;`"---"`|//
      |       ;/
      \_     _/
        `\"\"\"`
ASCII_ART;


$app->get('/status/{code}', function(Request $request, $code) use ($ASCII_ART) {

    switch ($code) {
        case 418:
            return response($ASCII_ART, $code)->header('Content-Type', 'text/plain');


    }

    return response('', $code);
});

