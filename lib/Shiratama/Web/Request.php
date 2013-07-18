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

    public $_isOnRewrite = null;

    public function __get($name)
    {
        if (method_exists($this, $name)) {
            return $this->$name();
        }
    }

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

    public function method()
    {
        return (isset($this->env['REQUEST_METHOD'])) ? $this->env['REQUEST_METHOD'] : 'GET';
    }

    public function param($key = null, $default = null) {
        return (isset($this->params[$key])) ? $this->params[$key] : $default;
    }

    public function baseUri()
    {
        return ($this->isOnRewrite()) ? dirname($this->env['SCRIPT_NAME']) . '/' : $this->env['SCRIPT_NAME'];
    }

    public function redirect($url = '/')
    {
        //プロトコル付きFQDNでない(設置ドメインの 相対or絶対パス)
        if (!preg_match('/^(https?)?:\/\//', $url)) {
            $redirectUrl = $this->uri($url);
        } else {
            $redirectUrl = $url;
        }

        header('Location: ' . $redirectUrl);
    }

    public function uri($path = '/', $params = array())
    {
        $scriptPath = dirname($this->env['SCRIPT_NAME']);
        if (!$this->isOnRewrite()) {
            $scriptName = str_replace("$scriptPath/", '', $this->env['SCRIPT_NAME']);
            $uri = preg_replace("!^($scriptPath)/?(:?$scriptName/?)?.+$!", "$1", $this->env['REQUEST_URI']);
            $uri .= ($path == '/') ? $path : "/$scriptName$path" ;
        } else {
            $uri = preg_replace("!^($scriptPath)/?.+$!", "$1", $this->env['REQUEST_URI']);
            $uri .= $path;
        }

        if ($params) {
            $uri .= '?' . self::queryString($params);
        }

        return $uri;
    }

    public function pathInfo()
    {
        $scriptName = basename($this->env['SCRIPT_NAME']);

        $baseUri = dirname($this->baseUri());
        $path = preg_replace("!$baseUri(/$scriptName)?!", '', $this->env['REQUEST_URI']);

        return $path;
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

    public function isOnRewrite()
    {
        if (!is_null($this->_isOnRewrite)) {
            return $this->_isOnRewrite;
        }

        $htaccess = Shiratama_Util::catfile(ROOT, '.htaccess');
        if (!file_exists($htaccess)) {
            return false;
        }

        $isOnRewrite = false;
        $fh = fopen($htaccess, 'r');
        while (!feof($fh)) {
            $line = trim(fgets($fh));
            if (empty($line)) {
                continue;
            }

            if (!preg_match("/^\s*RewriteBase\s+(.+)\s*$/", $line, $matches)) {
                continue;
            }
            $isOnRewrite = ($this->baseUri == $matches[1]);
        }

        $this->_isOnRewrite = $isOnRewrite;
        return $isOnRewrite;
    }
}

