<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DigestAuthController extends Controller
{
    // http://php.net/manual/en/features.http-auth.php

    public function index(Request $request, $qop, $user, $pass) {

        // WWW-Authenticate: Digest nonce="d4088ff39a6eeb50ef9448aea4dddcf7", opaque="be53adc6e67ce6da5340a753bdd88c50", realm="me@kennethreitz.com", qop=auth
        // Authorization: Digest username="user", realm="me@kennethreitz.com", nonce="d4088ff39a6eeb50ef9448aea4dddcf7", uri="/digest-auth/auth/user/passwd", response="6fefeb61a9fca4b9e443a59ff6e08804", opaque="be53adc6e67ce6da5340a753bdd88c50", qop=auth, nc=00000001, cnonce="0483b7dde5658044"

        $realm = 'Fake Realm';
        $users = array('admin' => 'mypass', 'guest' => 'guest');

        if (empty($_SERVER['PHP_AUTH_DIGEST'])) {
            return response(null, 401)
               ->header('WWW-Authenticate',
                    'Digest realm="'.$realm.'",qop="$qop",nonce="'.uniqid().'",opaque="'.md5($realm).'"');

        }
        if (!($data = $this->http_digest_parse($_SERVER['PHP_AUTH_DIGEST'])) || !isset($users[$data['username']]))
            die('Wrong Credentials!');

        // generate the valid response
        $A1 = md5($data['username'] . ':' . $realm . ':' . $users[$data['username']]);
        $A2 = md5($_SERVER['REQUEST_METHOD'].':'.$data['uri']);

        $valid_response = md5($A1.':'.$data['nonce'].':'.$data['nc'].':'.$data['cnonce'].':'.$data['qop'].':'.$A2);

        if ($data['response'] != $valid_response)
            die('Wrong Credentials!');

        // ok, valid username & password
        return 'You are logged in as: ' . $data['username'];

    }



    private function http_digest_parse($txt)
    {
        // protect against missing data
        $needed_parts = array('nonce'=>1, 'nc'=>1, 'cnonce'=>1, 'qop'=>1, 'username'=>1, 'uri'=>1, 'response'=>1);
        $data = array();
        $keys = implode('|', array_keys($needed_parts));

        preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);

        foreach ($matches as $m) {
            $data[$m[1]] = $m[3] ? $m[3] : $m[4];
            unset($needed_parts[$m[1]]);
        }

        return $needed_parts ? false : $data;
    }
}
