<?php if ($result) { ?>
<div class="alert alert-success" role="alert" style="margin-top: 10px">
    Новый пароль <?= $password ?>
</div>
<?php } else { ?>
  <div class="alert alert-danger" role="alert" style="margin-top: 10px">
    Ссылка недействительна
  </div>
<?php }  ?>
