<?php

$result = $c->Account->insert(array(
    'name' => $c->req->param('form_name'),
    'mail' => $c->req->param('form_mail'),
));

if ($result) {
    $c->req->redirect('/');
}

