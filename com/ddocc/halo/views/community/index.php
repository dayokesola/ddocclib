<?php 
$page->Paint("List Communities"); 
$page->PageHeader();
?>
<div class="row">
    <div class="col-md-12">
        <table class="table table-condensed table-bordered small">
            <tr>
                <th><?= $dto->labels['community_name'] ?></th>
                <th><?= $dto->labels['community_slug'] ?></th>
                <th><?= $dto->labels['members'] ?></th>
                <th><?= $dto->labels['admin_users'] ?></th>
                <th><?= $dto->labels['non_admin_users'] ?></th>
                <th><?= $dto->labels['active_users'] ?></th>
                <th><?= $dto->labels['inactive_users'] ?></th>
                <th><?= $dto->labels['blocked_users'] ?></th>
                <th>Admin Users</th>
                <th>Action</th>
            </tr>
            <?php foreach ($dtos as $dto) { ?>
                <tr>
                    <td><?= $dto->community_name ?></td>
                    <td><?= $dto->community_slug ?></td>
                    <td class="text-right"><?= $dto->members ?></td>
                    <td class="text-right"><?= $dto->admin_users ?></td>
                    <td class="text-right"><?= $dto->non_admin_users ?></td>
                    <td class="text-right"><?= $dto->active_users ?></td>
                    <td class="text-right"><?= $dto->inactive_users ?></td>
                    <td class="text-right"><?= $dto->blocked_users ?></td>
                    <td>
                        <div class="btn-group" role="group">
                        <a class="btn btn-xs btn-default" href="<?= UrlID('community-user.list-admin',$dto->id) ?>">List</a>
                        <a class="btn btn-xs btn-default" href="<?= UrlID('community-user.add-admin',$dto->id) ?>">Add</a>
                        </div>
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                        <a class="btn btn-xs btn-default" href="<?= UrlID('community.edit',$dto->id) ?>">Edit</a>
                        <a class="btn btn-xs btn-danger" href="<?= UrlID('community.delete',$dto->id) ?>">Delete</a>
                        </div>
                        
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>




 
