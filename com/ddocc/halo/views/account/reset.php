<?php
$page->Paint("Reset Password", 0);
?>
<div class="row login-box"> 
    <div class="col-md-4 col-md-offset-4">
        <?php $page->Alert(); ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Password Reset</h3>
            </div>
            <div class="panel-body">
                <?php
                $form->Start('account_reset');
                $form->TextBox('email', $dto->labels['email'], $dto->email);
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