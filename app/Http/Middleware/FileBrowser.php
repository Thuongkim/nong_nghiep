<?php

namespace App\Http\Middleware;

use Closure;

class FileBrowser
{
    /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @param  string|null  $guard
    * @return mixed
    */

    public function handle($request, Closure $next, $guard = 'admin')
    {
        if(\Auth::guard($guard)->check())
        {
            if (!$request->user()->ability(['system', 'admin'], [])) {
                $folder = str_pad($request->user()->id, 3, '0', STR_PAD_LEFT);
                \File::makeDirectory('assets/media/images/'. $folder . '/' . date('dm'), 0777, true, true);
                // \Config::set('elfinder.dir', ['assets/media/images/' . $folder]);
                \Config::set('elfinder.options.startPath', 'assets/media/images/' . $folder . '/' . date('dm'));
                $options = [
                    'driver' => 'LocalFileSystem', // driver for accessing file system (REQUIRED)
                    'path'   => 'assets/media/images/' . $folder,   // path to files (REQUIRED)
                    // 'tmbURL' => 'http://localhost:8080/thumbnails/', // URL to files (REQUIRED)
                    'uploadDeny'    => array('all'), // All Mimetypes not allowed to upload
                    'uploadAllow'   => array('image', 'text/plain'),// Mimetype image and text/plain allowed to upload
                    'uploadOrder'   => array('deny', 'allow'), // allowed Mimetype image and text/plain only
                    // 'disabled'      => array('rename', 'rm'),
                    'attributes' => [
                        [
                            'pattern' => '/.*/',
                            'locked' => true,
                            'read'    => true,
                            'write'   => false,
                        ],
                        [
                            'pattern' => '/'.$folder.'\/+/',//'/.('.$folder.')/',
                            'locked' => false,
                            'read'    => true,
                            'write'   => true,
                        ],
                    ]
                ];
                \Config::set('elfinder.root_options', $options);
            }

            return $next($request);
        } else {
            return redirect()->guest($guard . '/login');
        }

    }
}