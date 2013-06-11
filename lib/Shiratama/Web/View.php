<?php

class Shiratama_Web_View {

    public function __construct($params)
    {
        $this->template_dir = $params['template_dir'];
    }

    public function render($tmpl = null, $binds = array())
    {
        //bind variable for template
        foreach ($binds as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include("$this->template_dir/$tmpl");
        $content = ob_get_clean();

        if (isset($layout)) {
            include("$this->template_dir/Layout/$layout");
        }
    }

}


