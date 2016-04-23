<?php 
$page->Paint("Login",0); 
?>
<div class="row login-box">  
    <div class="col-md-4 col-md-offset-4">        
        <?php $page->Alert(); ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Site Login</h3>
            </div>
            <div class="panel-body">
                <?php
                $form->Start('account_login');
                $form->TextBox('email', $dto->labels['email'], $dto->email);
                $form->TextBox('pwd', $dto->labels['pwd'], '', 'password');
                $form->Submit('submit', 'Login');
                $form->Close();
                ?>
            </div>            
            <div class="panel-footer">
                <a href="<?= Url('account.register')?>">New User</a> -                 
                <a href="<?= Url('account.reset')?>">Forgot Password</a>
            </div>
        </div>
    </div>
</div>