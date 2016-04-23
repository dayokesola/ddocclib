<?php 
$page->Paint("Add User to Community"); 
$page->PageHeader();
?>
<div class="row" >  
    <div class="col-md-4" >        
        <?php $page->Alert(); ?>
        <div class="panel panel-default">            
            <div class="panel-body">
                <?php
                $form->Start('community_create');
                $form->Hidden('id', $item->id);                
                $form->Hidden('parent_id', 0);
                $form->TextBox('community_name', 'Community Name', $item->community_name); 
                $form->TextBox('community_slug', 'Community Slug', $item->community_slug);               
                $form->Submit('submit', 'Submit');
                $form->Close();
                ?>
            </div>
        </div>
    </div>
</div>