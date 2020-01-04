<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next( $request );
        // $response->header('Access-Control-Allow-Origin', '*');
        // $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        // $response->header('X-Frame-Options','deny');
        // $response->header('X-XSS-Protection', '1; mode=block');
        // $response->header('X-Content-Type-Options', 'nosniff');
        // $response->header('Content-Security-Policy', 'default-src \'self\' https://wwww.youtube.com http://baoquankhu5.vn');
        // $response->header('X-Powered-By', 'BCTech.vn');
        
        return $response;

        // return $next($request)
        //     ->header('Access-Control-Allow-Origin', '*')
        //     ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
            // $response->header('X-Frame-Options','deny'); // Anti clickjacking
            // $response->header('X-XSS-Protection', '1; mode=block'); // Anti cross site scripting (XSS)
            // $response->header('X-Content-Type-Options', 'nosniff'); // Reduce exposure to drive-by dl attacks
            // $response->header('Content-Security-Policy', 'default-src \'self\''); // Reduce risk of XSS, clickjacking, and other stuff
            //     // Don't cache stuff (we'll be updating the page frequently)
            // $response->header('Cache-Control', 'nocache, no-store, max-age=0, must-revalidate');
            // $response->header('Pragma', 'no-cache');
            // $response->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
    }
}
