<?php
$page->Paint('Site Functions');
$page->PageHeader();
?>
<div class="row">
    <div class="col-md-12">
        <table class="table table-condensed table-bordered small">
            <tr>
                <th>ID</th>
                <th>Function Name</th>
                <th>Function URL</th>
                <th>Function Sort</th>
                <th>Function Group</th>
                <th>Secure?</th>
                <th>In Menu?</th>
                <th>Action</th>
            </tr>
            <?php foreach ($fxns as $item) { ?>
                <tr>
                    <td><?= $item->fxn_id ?></td>
                    <td><?= $item->fxn_name ?></td>
                    <td><?= $item->fxn_url ?></td>
                    <td><?= $item->fxn_sort ?></td>
                    <td><?= $item->fxn_group ?></td>
                    <td><?= $item->fxn_secure ?></td>
                    <td><?= $item->fxn_flag ?></td>
                    <td>
                        <div class="btn-group" role="group">
                        <a class="btn btn-xs btn-default" href="<?= UrlID('site-fxn.edit',$item->fxn_id) ?>">Edit</a>
                        <a class="btn btn-xs btn-danger" href="<?= UrlID('site-fxn.delete',$item->fxn_id) ?>">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>



