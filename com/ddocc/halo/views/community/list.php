<?php
$page->Paint("My Communities"); 
$page->PageHeader();
?>
<div class="row">
     <?php foreach ($dtos as $dto) { ?>
    <div class="col-md-3">
        <?= $dto->Display() ?>
    </div>
     <?php } ?>
</div>
