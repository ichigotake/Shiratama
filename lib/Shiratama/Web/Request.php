<?php

class Shiratama_Web_Request {

    /**
     * array $_SERVER
     */
    public $env = array();

    /**
     * query string
     */
    public $params = array();

    public function __construct($env = null) {
        $this->env = ($env === null) ? $_SERVER : $env;

        $queryString = (isset($this->env['QUERY_STRING'])) ? $this->env['QUERY_STRING'] : '';
        foreach (explode('&', $queryString) as $_q) {
            if (!$_q) {
                continue;
            }
            list($key, $value) = explode('=', $_q);
            $this->params[$key] = $value;
        }
        if (isset($_POST)) {
            foreach ($_POST as $key => $value) {
                $this->params[$key] = $value;
            }
        }
    }

    public function param($key = null, $default = null) {
        return (isset($this->params[$key])) ? $this->params[$key] : $default;
    }

    public function uri($path = '/', $params = array())
    {
        $uri = '';
        if (!defined('REWRITE_ON') || !REWRITE_ON) {
            $uri = (strpos($path, '/') === 0) ? $this->env['SCRIPT_NAME'] . $path : $path;
            if ($params) {
                $uri .= '?' . self::queryString($params);
            }
        }

        return $uri;
    }

    public function uriWith($params = array()) {
        return self::queryString($params);
    }

    public function queryString($params = array()) {
        $querys = array();
        foreach ($params as $key => $value) {
            $querys[] = $key . "=" . $value;
        }
        return join('&', array_values($querys));
    }

    public function parse($url) {
    }

    public function isOnRewrite() {
        ;
    }
}

