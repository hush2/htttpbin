<?php
use Illuminate\Http\Request;


$app->get('/', ['as'=>'root', function () {
    return view('index');
}]);

$app->get('/ip', function (Request $request) {
    return ['origin' => getRemoteIp($request)];
});

$app->get('/user-agent', function (Request $request) {
    return ['user-agent' => $request->header('user-agent')];
});

$app->get('/headers', function (Request $request) {
    return getHeaders($request);
});

$app->get('/get', function (Request $request) {
    return getDefaultResponse($request);
});

$app->get('/post', function () {
    return view('form');
});

$app->post('/post', function (Request $request) {

    $data = getDefaultResponse($request);
    $data['post'] = $request->request->all();   // $_POST data;
    // Todo: add file
    return response($data);
});

$app->get('/encoding/utf8', function () {
    $text = file_get_contents(base_path() . '/public/utf-8-demo.txt');
    return response($text);
});

$app->get('/gzip', function (Request $request) {

    $data = getDefaultResponse($request);
    $data['gzipped'] = 'true';

    $gzip = gzencode(json_encode($data));

    return response($gzip)
            ->header('Content-Encoding', 'gzip')
            ->header('Content-Type', 'application/json')
            ->header('Content-Length', strlen($gzip));
});

$app->get('/deflate', function (Request $request) {

    $data = getDefaultResponse($request);
    $data['deflated'] = 'true';

    $deflate = gzdeflate(json_encode($data));

    return response($deflate)
        ->header('Content-Encoding', 'deflate')
        ->header('Content-Type', 'application/json')
        ->header('Content-Length', strlen($deflate));
});


$app->get('/test', function() {
    return redirect('/');
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
            return response($ascii_art, $code)
                ->header('Content-Type', 'text/plain');
        case 301:
        case 302:
        case 303:
        case 305:
        case 307:
            // if error, set cache/session driver to array in .env
            return redirect('/redirect/1', $code);
    }
    return response('', $code);
});


$app->get('/redirect/{code}', function(Request $request, $code) {
    return getDefaultResponse($request);
});