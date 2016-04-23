<?php
$page->Paint("Activate Account", 0);
?>
<div class="row login-box"> 
    <div class="col-md-4 col-md-offset-4">
        <?php $page->Alert(); ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Activate Account</h3>
            </div>
            <div class="panel-body">
                <?php
                $form->Start('account_activate');
                $form->TextBox('email', $dto->labels['email'], $dto->email,'text',0);
                $form->Hidden('code', $dto->code);
                $form->TextBox('pwd1', $dto->labels['pwd1'], '', 'password');
                $form->TextBox('pwd2', $dto->labels['pwd2'], '', 'password');
                $form->Submit('submit', 'Submit');
                $form->Close();
                ?>
            </div>
            <div class="panel-footer">
                <a href="<?= Url('account.register') ?>">New User</a> - 
                <a href="<?= Url('account.login') ?>">Existing User</a>
            </div>
        </div>
    </div>
</div>

