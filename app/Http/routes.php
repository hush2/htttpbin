<?php
use Illuminate\Http\Request;


$app->get('/', function () {
    return view('index');
});

$app->get('/ip', function (Request $request) {
    return getRemoteIp($request);
});

$app->get('/user-agent', function (Request $request) {
    return ['user-agent' => $request->header('user-agent')];
});

$app->get('/headers', function (Request $request) {
    return getHeaders($request);
});

$app->get('/get', function (Request $request) {
    $data = [];
    $data['query'] = $request->query->all();
    $data['headers'] = getHeaders($request);
    $data['origin'] = getRemoteIp($request);
    $data['url'] = $request->fullUrl();
    return $data;
});

$app->get('/encoding/utf8', function () {
    //header('Content-Type: text/html; charset=utf-8');
    return file_get_contents(base_path() . '/public/utf-8-demo.txt');
});

$app->get('/gzip', function (Request $request) {

    $data = getHeaders($request);

    $data['gzipped'] = true;
    $data['method'] = 'GET';
    $data = array_merge($data, getRemoteIp($request));

    $gzip = gzencode(json_encode($data));

    header('Content-Encoding: gzip');
    header('Content-Type: application/json');
    header('Content-Length: ' . strlen($gzip));

    return $gzip;
});

$app->get('/deflate', function (Request $request) {

    $data = getHeaders($request);
    $data['deflated'] = true;
    $data['method'] = 'GET';
    $data = array_merge($data, getRemoteIp($request));

    $deflate = gzdeflate(json_encode($data));

    header('Content-Encoding: deflate');
    header('Content-Type: application/json');
    header('Content-Length: ' . strlen($deflate));

    return $deflate;
});


$app->get('/status/{code}', function (Request $request, $code) {

    $ascii_art = <<<ASCII_ART
    -=[ teapot ]=-

       _...._
     .'  _ _ `.
    | ."` ^ `". _,
    \_;`"---"`|//
      |       ;/
      \_     _/
        `\"\"\"`
ASCII_ART;

    switch ($code) {
        case 418:
            return response($ascii_art, $code)->header('Content-Type', 'text/plain');
        default:
            $code = 200;
    }

    return response('', $code);
});

