<?php

function getHeaders($request)
{
    $all = $request->headers->all();
    $headers = [];
    foreach ($all as $k => $v) {
        $headers[$k] = $v[0];
    }
    ksort($headers);
    return ['headers' => $headers];
}

function getRemoteIp($request)
{
    $server = $request->server;

    if ($server->has('HTTP_CLIENT_IP')) {
        $ip = $request->server->get('HTTP_CLIENT_IP');
    } elseif ($server->has('HTTP_X_FORWARDED_FOR')) {
        $ip = $request->server->get('HTTP_X_FORWARDED_FOR');
    } else {
        $ip = $request->server->get('REMOTE_ADDR');
    }
    return ['origin' => $ip];
}
