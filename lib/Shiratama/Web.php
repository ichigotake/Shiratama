<?php

class Shiratama_Web extends Shiratama {

    public $html_content_type = 'text/html; charset=UTF-8';

    public $isRender = false;

    public function toApp()
    {
        $this->dispatch();
    }

    public function request() { return $this->req(); }
    public function req()
    {
        if (!$this->_req) {
            $this->_req = new Shiratama_Web_Request($this->env);
        }

        return $this->_req;
    }

    public function response() { return $this->res(func_get_args()); }
    public function res($status = 200, $headers = array(), $body = null)
    {
        if (!$this->_res) {
            $this->_res = new Shiratama_Web_Response($status, $headers, $body);
        }

        return $this->_res;
    }

    public function dispatch()
    {
        $location = explode('?', str_replace($this->env['SCRIPT_NAME'], '', $this->env['PHP_SELF']));
        $uris = (isset($location[0])) ? explode('/', $location[0]) : array();
        array_shift($uris);
        
        $querys = array();
        if (isset($location[1])) {
            foreach (explode('&', $location[1]) as $_q) {
                $querys[$key] = $value;
            }
        }

        $static_path = Shiratama_Util::catfile(ROOT, 'public', $uris);
        if (file_exists($static_path) && !is_dir($static_path)) {
            return $this->res->responce_by_static_file($static_path);
        }
        
        $this->controller = (!empty($uris[0])) ? strtolower($uris[0]) : 'root';
        $this->action = (isset($uris[1])) ? strtolower($uris[1]) : 'index';
        $this->render(Shiratama_Util::catfile($this->controller, "$this->action.php"), array(
            'c' => $this,
        ));
    }

    public function render($tmpl = null, $bind = array())
    {
        if (!isset($bind['c'])) {
            $bind['c'] = $this;
        }
        $view = new NanoTemplate(APP_VIEW_DIR);
        $view->render($tmpl, $bind);
    }

}
