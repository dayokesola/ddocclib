<?php 
$page->Paint("Create Role"); 
$page->PageHeader();
?>
<div class="row" >  
    <div class="col-md-4" >        
        <?php $page->Alert(); ?>
        <div class="panel panel-default">            
            <div class="panel-body">
                <?php
                $form->Start('site-role_create');
                $form->Hidden('role_id', $dto->role_id);
                $form->TextBox('role_name', 'Role Name', $dto->role_name);                
                $form->Submit('submit', 'Submit');
                $form->Close();
                ?>
            </div>
        </div>
    </div>
</div>
