<?php 
$page->Paint("Register",0); 
?>
<div class="row login-box">  
    <div class="col-md-4 col-md-offset-4">        
        <?php $page->Alert(); ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Site Registration</h3>
            </div>
            <div class="panel-body">
                <?php
                $form->Start('account_register', 1);
                $form->TextBox('fname', $reg->labels['fname'], $reg->fname);
                $form->TextBox('lname', $reg->labels['lname'], $reg->lname);
                $form->TextBox('email', $reg->labels['email'], $reg->email);
                $form->TextBox('mobile', $reg->labels['mobile'], $reg->mobile, 'text', 1, '2348039590420');
                $form->TextBox('pwd1', $reg->labels['pwd1'], '', 'password');
                $form->TextBox('pwd2', $reg->labels['pwd2'], '', 'password');
                $form->Submit('submit', 'Register');
                $form->Close();
                ?>
            </div>            
            <div class="panel-footer">
                <a href="<?= Url('account.reset')?>">Forgot Password</a> -                
                <a href="<?= Url('account.login')?>">Existing User</a>
            </div>            
        </div>
    </div>
</div>