<?php $_layout = 'layout/default.php' ?>
<?php
$accountList = $c->Account->getList();
?>

<form action="<?php echo $c->req->uri('/account/add') ?>" method="post">
  <fieldset>
    <legend>new user</legend>
    <div>
      <label for="form_name">name</label>
      <input type="text" name="form_name" id="form_name">
    </div>
    <div>
      <label for="form_mail">mail</label>
      <input type="text" name="form_mail" id="form_mail">
    </div>

    <input type="submit" value="register">
  </fieldset>
</form>

<h2>Account</h2>

<?php if (!$accountList) : ?>

  <p>non data.</p>

<?php else : ?>

  <table border="1" style="border-collapse:collapse;">
    <thead>
      <tr>
        <th>name</th>
        <th>mail</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($accountList as $key => $account): ?>
      <tr>
        <td><?php echo $account['name'] ?></td>
        <td><?php echo $account['mail'] ?></td>
      </tr>
    <?php endforeach ?>
    </tbody>
  </table>

<?php endif ?>


