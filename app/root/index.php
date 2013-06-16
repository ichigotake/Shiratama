<?php $_layout = 'layout/default.php' ?>
<?php
$account = $c->Account->getInfo($c->req->param('id', 1));
?>

<h2>Account</h2>

<dl>
  <dt>username</dt>
    <dd><?php echo $account['name'] ?></dd>

  <dt>mail</dt>
    <dd><?php echo $account['mail'] ?></dd>
</dl>


