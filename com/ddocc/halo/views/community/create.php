<?php 
$page->Paint("Create Community"); 
$page->PageHeader();
?>
<div class="row" >  
    <div class="col-md-4" >        
        <?php $page->Alert(); ?>
        <div class="panel panel-default">            
            <div class="panel-body">
                <?php
                $form->Start('community_create');
                $form->Hidden('id', $dto->id);                
                $form->Hidden('parent_id', $dto->parent_id);               
                $form->Hidden('ancestor_id', $dto->ancestor_id);
                $form->TextBox('community_name', 'Community Name', $dto->community_name); 
                $form->TextBox('community_slug', 'Community Slug', $dto->community_slug);               
                $form->Submit('submit', 'Submit');
                $form->Close();
                ?>
            </div>
        </div>
    </div>
</div>