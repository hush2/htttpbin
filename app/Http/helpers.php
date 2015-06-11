<?php

function to_json(array $data) {
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    return response($json)->header('Content-Type', 'application/json');
}

function getHeaders($request)
{
    $all = $request->headers->all();
    $headers = [];
    foreach ($all as $k => $v) {
        $headers[$k] = $v[0];
    }
    ksort($headers);
    return $headers;
}

function getRemoteIp($request)
{
    $server = $request->server;

    if ($server->has('HTTP_CLIENT_IP')) {
        $ip = $server->get('HTTP_CLIENT_IP');
    } elseif ($server->has('HTTP_X_FORWARDED_FOR')) {
        $ip = $server->get('HTTP_X_FORWARDED_FOR');
    } else {
        $ip = $server->get('REMOTE_ADDR');
    }
    return $ip;
}

function getQuery($request) {
    return $request->query->all();
}

function getDefaultResponse($request) {

    $data['origin'] = getRemoteIp($request);
    $data['url'] = $request->fullUrl();
    $data['query'] = getQuery($request);
    $data['headers'] = getHeaders($request);

    return $data;
}