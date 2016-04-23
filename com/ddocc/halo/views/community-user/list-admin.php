<?php 
$page->Paint("Community Administrators"); 
$page->PageHeader();
?>
<div class="row">
    <div class="col-md-12">
        <table class="table table-condensed table-bordered small">
            <tr>
                <th><?= $dto->labels['community_name'] ?></th>
                <th><?= $dto->labels['fullname'] ?></th>
                <th><?= $dto->labels['email'] ?></th>
                <th><?= $dto->labels['mobile'] ?></th>
                <th><?= $dto->labels['role_name'] ?></th>
                <th><?= $dto->labels['statustext'] ?></th>
                <th>Action</th>
            </tr>
            <?php foreach ($dtos as $dto) { ?>
                <tr>
                    <td><?= $dto->community_name ?></td>
                    <td><?= $dto->fname . ' '. $dto->lname ?></td>
                    <td><?= $dto->email ?></td>
                    <td><?= $dto->mobile ?></td>
                    <td><?= $dto->role_name ?></td>
                    <td><?= $dto->statustext ?></td>
                    <td>
                        <div class="btn-group" role="group">
                            <a class="btn btn-xs btn-default" 
                               href="<?= UrlParams('community-user.edit-admin',
                                       array('community_id' => $dto->community_id, 'user_id' => $dto->user_id)) ?>">
                                Edit</a>
                            <a class="btn btn-xs btn-danger" 
                               href="<?= UrlParams('community-user.delete-admin',
                                       array('community_id' => $dto->community_id, 'user_id' => $dto->user_id)) ?>">
                                Delete</a>
                        </div>
                         
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>

