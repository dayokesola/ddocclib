<?php
$page->Paint('Site Role Functions');
$page->PageHeader();


$form->Start('site-role_fxns');
?> 
<div class="row">
    <div class="col-md-1 col-md-offset-11">
        <?php
        $form->Submit('submit', 'Submit');
        ?>
    </div> 
</div> 
<div class="row">
    <div class="col-md-12">
        <h3>Misc</h3>
    </div>
    <?php
    $chk = "";
    $grp = 0;
    foreach ($fxns as $row) {
        if ($row->fxn_secure == 1) {
            if ($row->role_id > 0) {
                $chk = 'checked="checked" ';
            }
            if ($row->fxn_group != $grp) {
                $grp = $row->fxn_group;
                echo '</div><div class="row"><div class="col-md-12"><h3>' . $row->tab_text . '</h3></div>';
            }
            ?>
            <div class="col-xs-2">
                <?= $row->fxn_name; ?><br />
                <input type="checkbox" name="fxns[]" value="<?= $row->fxn_id; ?>" <?php echo $chk; ?> />                 
                <span class="label label-default"><?= $row->fxn_url; ?></span>
            </div>
            <?php
            $chk = "";
        }
    }
    echo '</div>';
    ?>
</div> 

<?php
$form->Close();
