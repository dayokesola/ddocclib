<?php 
$page->Paint("Edit Function"); 
$page->PageHeader();
?>
<div class="row" >  
    <div class="col-md-4" >        
        <?php $page->Alert(); ?>
        <div class="panel panel-default">            
            <div class="panel-body">
                <?php
                $form->Start('site-fxn_edit');
                $form->Hidden('fxn_id', $fxn->fxn_id);
                $form->TextBox('fxn_name', 'Function Name', $fxn->fxn_name);
                $form->TextBox('fxn_url', 'Function URL', $fxn->fxn_url);  
                $form->DropListTab('fxn_group', 'Function Group', $fxn->fxn_group, 1); 
                $form->TextBox('fxn_sort', 'Function Sort', $fxn->fxn_sort);  
                $form->DropListTab('fxn_flag', 'Show in menu', $fxn->fxn_flag, 2); 
                $form->DropListTab('fxn_secure', 'Secured?', $fxn->fxn_secure, 2);
                $form->Submit('submit', 'Submit');
                $form->Close();
                ?>
            </div>
        </div>
    </div>
</div>