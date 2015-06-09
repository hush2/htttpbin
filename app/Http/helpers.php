<?php

function getHeaders($request) {
    $all = $request->headers->all();
    $headers = [];
    foreach ($all as $k => $v) {
        $headers[$k] = $v[0];
    }
    ksort($headers);
    return ['headers' => $headers];
}

