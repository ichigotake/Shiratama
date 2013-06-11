<?php

class Controller_Root extends Shiratama_Controller
{
    function index($c)
    {
        $account = $c->Account->getInfo(1);
        return $c->render('Root/index.php', array(
            'account' => $account,
        ));
    }
}
