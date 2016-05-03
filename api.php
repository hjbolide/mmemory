<?php

require_once('./util.php');

abstract class API {

    public static $AVAILABLE_X_METHODS = ['PUT', 'DELETE'];

    protected $method = '';
    protected $endpoint = '';
    protected $verb = '';
    protected $args = [];

    public function __construct($request) {

        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: *');
        header('Content-Type: application/json');

        $this -> args = explode('/', rtrim($requset, '/'));
        $this -> endpoint = array_shift($this->args);

        if (array_key_exists(0, $this -> args)
                && !is_numeric($this -> args[0])) {
            $this -> verb = array_shift($this -> args);
        }

        $this -> method = $_SERVER['REQUEST_METHOD'];
        if ('GET' != $this -> method) {
            throw new Exception('Currently we only support GET method');
        }
    }

    public function call() {
        if (method_exists($this, $this -> endpoint)) {
            return $this -> _out($this -> {$this -> endpoint}($this -> args));
        }

        return $this -> _out('Invalid API endpoint');
    }

    protected function out($data, $status=200) {
        header('HTTP/1.1 ' . $status . ' ' . $this -> _reqStatus($status));
        return json_encode($data);
    }

    private function _reqStatus($code) {
        $status = [
            200 => 'OK',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error'
        ];

        return $status[$code] ? $status[$code] : $status[500];
    }
}


class FlickrAPI extends API {

}
