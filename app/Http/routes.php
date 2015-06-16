<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;

$app->get('/', ['as'=>'root', function () {

    return view('index');
}]);

$app->get('/ip', function (Request $request) {

    return to_json(['origin' => getRemoteIp($request)]);
});

$app->get('/user-agent', function (Request $request) {

    return to_json(['user-agent' => $request->header('user-agent')]);
});

$app->get('/headers', function (Request $request) {

    return to_json(getHeaders($request));
});

$app->get('/get', function (Request $request) {

    return to_json(getDefaultResponse($request));
});

$app->get('/post', function () {

    return view('form');
});

$app->post('/post', function (Request $request) {

    $data = getDefaultResponse($request);
    $data['post'] = $request->request->all();   // $_POST data;
    // Todo: add file
    return to_json($data);

});

$app->get('/encoding/utf8', function () {

    $text = file_get_contents(base_path() . '/public/utf-8-demo.txt');
    return response($text);

});

$app->get('/gzip', function (Request $request) {

    $data = getDefaultResponse($request);
    $data['gzipped'] = 'true';

    $gzip = gzencode(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

    return response($gzip)
            ->header('Content-Encoding', 'gzip')
            ->header('Content-Type', 'application/json')
            ->header('Content-Length', strlen($gzip));
});

$app->get('/deflate', function (Request $request) {

    $data = getDefaultResponse($request);
    $data['deflated'] = 'true';

    $deflate = gzdeflate(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

    return response($deflate)
        ->header('Content-Encoding', 'deflate')
        ->header('Content-Type', 'application/json')
        ->header('Content-Length', strlen($deflate));
});

$app->get('/status/{code}', function ($code) {

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
        case 301:
        case 302:
        case 303:
        case 305:
        case 307:
            // if error, set cache/session driver to 'file' in .env
            return redirect('/redirect/1', $code);
    }
    return response(null, $code);
});

$app->get('/response-headers', function(Request $request) {

    header_remove("X-Powered-By");

    $data = [];
    $response = new Response();

    foreach (getQuery($request) as $key => $value) {
        $response->headers->set($key, $value);
        $data[$key] = $value;
    }

    if (!isset($data['Content-Type'])) {
        $response->header('Content-Type', 'application/json');
    }

    $data = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    $response->setContent($data);

    return $response;

});

$app->get('/redirect/{n}',          'App\Http\Controllers\RedirectController@redirect');
$app->get('/redirect-to',           'App\Http\Controllers\RedirectController@to');
$app->get('/relative-redirect/{n}', 'App\Http\Controllers\RedirectController@relative');
$app->get('/absolute-redirect/{n}', 'App\Http\Controllers\RedirectController@absolute');

$app->get('/cookies', function(Request $request) {
    $cookies = $request->cookies->all();
    return to_json(['cookies' => $cookies]);
});

$app->get('/cookies/set', function(Request $request) {

    $response = new Response();
    $query = getQuery($request);
    foreach ($query as $k => $v) {
        $response->withCookie(cookie($k, $v));
    }
    $cookies = array_merge($request->cookies->all(), $query);
    return to_json(['cookies' => $cookies], $response);
});

$app->get('/cookies/delete', function(Request $request) {

    $response = new Response();
    $query = getQuery($request);
    foreach ($query as $k => $v) {
        $response->withCookie(cookie($k, null));    // delete cookie
        $request->cookies->remove($k);
    }
    return to_json(['cookies' => $request->cookies->all()], $response);
});

$app->get('/basic-auth/{user}/{pass}', function(Request $request, $user, $pass)
{
    $basic = $request->header('Authorization');

    if ($basic === 'Basic '.base64_encode("$user:$pass")) {
        return to_json(['authenticated' => true, 'user' => $user]);
    }

    return response(null, 401)
        ->header('WWW-Authenticate', 'Basic realm="Fake Realm"');
});

$app->get('/digest-auth/{qop}/{user}/{pass}', 'App\Http\Controllers\DigestAuthController@index');
