<?php
$page->Paint($dto->community_name);
$page->PageHeader('', '', 0);
?>
<div class="row">   
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-12">
                <div class="btn-group btn-group-sm" role="group" aria-label="..." style="margin-bottom: 10px;">
                    <a href="#" class="btn btn-default">View members</a>
                    <a href="#" class="btn btn-default">View Sub-Groups</a>
                    <?php if ($dtouser->role_id == 1) { ?>
                    <a href="#" class="btn btn-default">New Sub-Group</a>
                    <a href="<?= UrlID("community-user.joins", $dto->id) ?>" class="btn btn-default">Approve Joins <span class="label label-success"><?= $dto->request_users ?></span></a>
                        <a href="#" class="btn btn-default">Manage Users</a>
                        <a href="#" class="btn btn-default">Update Community</a>
                    <?php } ?>
                    <?php if ($dtouser->role_id != 1) { ?>
                        <a href="#" class="btn btn-default">Contact Administrator</a>
                    <?php } ?>
                    <?php if ($dtouser->community_id == 0) { ?>
                        <a href="#" class="btn btn-success">Join Group</a>
                    <?php } ?>
                    <?php if ($dtouser->community_id > 0 && $dtouser->statusflag == 1) { ?>
                        <a href="#" class="btn btn-danger">Leave Group</a>
                    <?php } ?>
                    <?php if ($dtouser->community_id > 0 && $dtouser->statusflag == 9) { ?>
                        <a href="#" class="btn btn-warning">Awaiting Group Approval</a>
                    <?php } ?>
                </div> 
            </div>
            <div class="col-md-12">
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                    when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                    It has survived not only five centuries, but also the leap into electronic typesetting,
                    remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset 
                    sheets containing Lorem Ipsum passages, and more recently with desktop publishing software 
                    like Aldus PageMaker including versions of Lorem Ipsum.</p>
                <p>It is a long established fact that a reader will be distracted by the readable content of a page
                    when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal 
                    distribution of letters, as opposed to using 'Content here, content here', making it look like 
                    readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as 
                    their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy.
                    Various versions have evolved over the years, sometimes by accident, 
                    sometimes on purpose (injected humour and the like).</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">Latest Activities</div>
            <ul class="list-group">
                <li class="list-group-item">Cras justo odio</li>
                <li class="list-group-item">Dapibus ac facilisis in</li>
                <li class="list-group-item">Morbi leo risus</li>
                <li class="list-group-item">Porta ac consectetur ac</li>
                <li class="list-group-item">Vestibulum at eros</li>
            </ul>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-2 col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-users fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?= $dto->members ?></div>
                        <div>Sub-Groups!</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?= $dto->members ?></div>
                        <div>Members!</div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    <div class="col-lg-2 col-md-4">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-thumbs-up fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?= $dto->active_users ?></div>
                        <div>Active</div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
    <div class="col-lg-2 col-md-4">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-thumbs-down fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?= $dto->inactive_users ?></div>
                        <div>Inactive</div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
    <div class="col-lg-2 col-md-4">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user-times fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?= $dto->blocked_users ?></div>
                        <div>Blocked</div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
    <div class="col-lg-2 col-md-4">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user-plus fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?= $dto->request_users ?></div>
                        <div>Joins!</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>