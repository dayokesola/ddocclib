<?php
$page->Paint("Search Communities");
$page->PageHeader();
?>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <?php $form->Start('community_search'); ?>
        <div class="input-group input-group-lg">
            <input type="text" class="form-control" placeholder="Search for..." name="q">
            <span class="input-group-btn">
                <button class="btn btn-default" type="submit">Go!</button>
            </span>
        </div>
        <?php $form->Close(); ?>
    </div>
</div>

<?php if (isset($items)) { ?>
    <?php if (count($items) > 0) { ?>
        <div class="row">
            <div class="col-md-12">
                <h3>Search Results</h3>
            </div>
            <?php foreach ($items as $item) { ?>
                <div class="col-md-3">
                    <?= $item->Display() ?>
                </div>
            <?php } ?>    
        </div>

    <?php
    } else {
        echo '<div class="row">
        <div class="col-md-12">
            <h3>No results found</h3>
        </div></div>';
    }
}
?>

<?php if (count($dtos) > 0) { ?>
    <div class="row">
        <div class="col-md-12">
            <h3>Featured Communities</h3>
        </div>
            <?php foreach ($dtos as $dto) { ?>
            <div class="col-md-3">
            <?= $dto->Display() ?>
            </div>
    <?php } ?>
    </div>
<?php } ?>