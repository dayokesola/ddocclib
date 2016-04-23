<?php
$page->Paint('Site Roles');
$page->PageHeader(); 
?> 
<div class="row">
    <div class="col-md-12">
        <table class="table table-condensed table-bordered small">
            <tr>
                <th>Role Name</th>
                <th>Action</th>
            </tr>
            <?php foreach ($roles as $role) { ?>
                <tr>
                    <td><?= $role->role_name ?></td>
                    <td>
                        <div class="btn-group" role="group">
                        <a class="btn btn-xs btn-default" href="<?= UrlID('site-role.fxns',$role->role_id) ?>">Functions</a>
                        <a class="btn btn-xs btn-default" href="<?= UrlID('site-role.edit',$role->role_id) ?>">Edit</a>
                        <a class="btn btn-xs btn-danger" href="<?= UrlID('site-role.delete',$role->role_id) ?>">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>



