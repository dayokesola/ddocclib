<?php 
$page->Paint("Edit Role"); 
$page->PageHeader();
?>
<div class="row" >  
    <div class="col-md-4" >        
        <?php $page->Alert(); ?>
        <div class="panel panel-default">            
            <div class="panel-body">
                <?php
                $form->Start('site-role_edit');
                $form->Hidden('role_id', $role->role_id);
                $form->TextBox('role_name', 'Role Name', $role->role_name);                
                $form->Submit('submit', 'Submit');
                $form->Close();
                ?>
            </div>
        </div>
    </div>
</div>