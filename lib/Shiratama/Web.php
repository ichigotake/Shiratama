<?php

class Shiratama_Web extends Shiratama {

    public $html_content_type = 'text_html; charset=UTF-8';

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
        $querys = array();
        if (isset($location[1])) {
            foreach (explode('&', $location[1]) as $_q) {
                $querys[$key] = $value;
            }
        }

        $static_path = Shiratama_Util::catfile(ROOT, 'public', $uris);
        if (file_exists($static_path) && !is_dir($static_path)) {
            echo file_get_contents($static_path);
            return ;
        }
        
        $controller = (isset($uris[0])) ? Shiratama_Util::camelize($uris[0]) : 'Root';
        if ($controller != 'Root' && Shiratama_Util::isController($controller)) {
            $controller_class = "Controller_$controller";
            $c = new $controller_class();
            $action = (method_exists($c, $uris[1])) ? $uris[1] : 'index';
        } else {
            $controller = 'Controller_Root';
            $c = new $controller();
            $action = (method_exists($c, @$uris[1])) ? $uris[1] : 'index';
            if (!method_exists($c, $action)) {
                return $this->error_404();
            }
        }

        $c->$action($this);

        if (!$this->isRender) {
            $template = Shiratama_Util::catfile(APP_VIEW_DIR, $controller, "$action.php");
            
            ob_start();
            include($template);
            if (!isset($layout)) {
                $layout = Shiratama_Util::catfile(APP_VIEW_DIR, 'Layout', 'default.php');
            }

            $content = ob_get_clean();
            include(Shiratama_Util::catfile(APP_VIEW_DIR, 'Layout', $layout));
        }
    }

    public function render($tmpl = null, $bind = array())
    {
        $this->isRender = true;

        $html = (new Shiratama_Web_View(array('template_dir' => APP_VIEW_DIR)))->render($tmpl, $bind);
        return $this->res(200, array(
            'Content-Type'   => $this->html_content_type,
            'Content-Length' => strlen($html),
        ), $html);
    }

    public function _functionArgsNum()
    {
        return count(explode(',', $line));
    }
}
