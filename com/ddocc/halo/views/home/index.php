<?php
$page->Paint("Welcome Home");
?>
<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <h1>Welcome <?= $su->Fullname() ?></h1>
        </div>
    </div>
</div>
<div class="row">        
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-users fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?= $dto->my_community_count ?></div>
                        <div>My Communities</div>
                    </div>
                </div>
            </div>
            <a href="<?= Url('community.list') ?>">
                <div class="panel-footer">
                    <span class="pull-left">View Communities</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>

<div class="row">
    
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-users fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?= $dto->community_count ?></div>
                        <div>All Active Communities</div>
                    </div>
                </div>
            </div>
            <a href="<?= Url('community.search') ?>">
                <div class="panel-footer">
                    <span class="pull-left">Search Communities</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>