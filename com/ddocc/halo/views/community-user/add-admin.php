<?php 
$page->Paint("Add Administrator To Community"); 
$page->PageHeader();
?>
<div class="row" >  
    <div class="col-md-4" >        
        <?php $page->Alert(); ?>
        <div class="panel panel-default">            
            <div class="panel-body">
                <?php
                $form->Start('community-user_add-admin');
                $form->Hidden('community_id', $dto->community_id); 
                $form->TextBox('community_name', $dto->labels['community_name'], $dto->community_name,'text',2); 
                $form->TextBox('email', $dto->labels['email'], $dto->email); 
                $form->DropListTab('statusflag', $dto->labels['statusflag'], $dto->role_id, 22);   
                if($page->alertBox->css != 'warning'){
                    $form->Submit('submit', 'Submit');
                }
                else {
                    $form->Submit('submit', 'Submit','danger', 0);
                }
                $form->Close();
                ?>
            </div>
        </div>
    </div>
</div>