<?php


namespace App\Extensions;


use Illuminate\Routing\ResponseFactory;

class ResponseDebugFactory extends ResponseFactory
{
    public function json($data = [], $status = 200, array $headers = [], $options = 0)
    {
        if (config('app.debug_response')) {
            $data['debug'] = \Debugbar::collect();
        }

        return parent::json($data, $status, $headers, $options);
    }
}