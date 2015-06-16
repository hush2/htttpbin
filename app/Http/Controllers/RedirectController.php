<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function redirect($n) {

        $n = $n ? $n : 1;
        return redirect('/relative-redirect/'.abs($n));
    }

    public function to(Request $request) {

        return redirect($request->get('url'));
    }

    public function relative($n) {

        if ($n > 0) {
            $n--;
            $location = '/relative-redirect/'.abs($n);
        } else {
            $location = '/get';
        }
        return response(null, 302)->header('Location', $location);
    }

    public function absolute($n) {
        if ($n > 0) {
            $n--;
            return redirect('/absolute-redirect/'.abs($n));
        }
        return redirect('/get');
    }

}
