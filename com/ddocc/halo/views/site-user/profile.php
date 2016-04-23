<?php
$page->Paint('My Profile');
$page->PageHeader('', '', 0);

if ($dto->profile['AVATAR']->profile_value == '') {
    $dto->profile['AVATAR']->profile_value = '_holder.png';
}
?>
<style type="text/css">
    th { width: 40%;}
</style>
<div class="row marginbottom5" >        
    <div class="col-md-10">
        <?php $page->Alert(); ?>
    </div>  
    <div class="col-md-2">
        <a class="btn btn-<?= $btn ?> btn-lg btn-block" href="<?= Url('site-user.update') ?>">Update My Profile!</a>
    </div>
</div> 
<div class="row small">  
    <div class="col-md-3">        
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Personal Info</h3>
            </div>

            <table class="table table-condensed">
                <tr>
                    <td colspan="2" class="text-center"> 
                        <img src="<?= MEDIAURL . 'profiles/' . $dto->profile['AVATAR']->profile_value ?>" 
                             class="img img-responsive" alt="<?= $dto->email ?>" />                     
                    </td>
                </tr> 
                <tr>
                    <th>Full name</th>
                    <td><?= $dto->fname . ' ' . $dto->lname ?></td>
                </tr> 


                <?php
                foreach ($dto->profile as $profile) {
                    if ($profile->profile_group == 'BI') {
                        ?>     
                        <tr>
                            <th><?= $profile->profile_name ?></th>
                            <td><?= $profile->profile_value ?></td>
                        </tr> 
                        <?php
                    }
                }
                ?>
            </table> 
        </div>

    </div>
    <div class="col-md-3">        
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Contact Info</h3>
            </div>
            <table class="table table-condensed">
                <tr>
                    <th><?= $dto->labels['email'] ?></th>
                    <td><?= $dto->email ?></td>
                </tr> 
                <tr>
                    <th><?= $dto->labels['mobile'] ?></th>
                    <td><?= $dto->mobile ?></td>
                </tr> 
                <?php
                foreach ($dto->profile as $profile) {
                    if ($profile->profile_group == 'AD') {
                        ?>     
                        <tr>
                            <th><?= $profile->profile_name ?></th>
                            <td><?= $profile->profile_value ?></td>
                        </tr> 
                        <?php
                    }
                }
                ?>
            </table>
        </div>
    </div>

    <div class="col-md-3">        
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Social Info</h3>
            </div>
            <table class="table table-condensed">
                <?php
                foreach ($dto->profile as $profile) {
                    if ($profile->profile_group == 'SM') {
                        ?>     
                        <tr>
                            <th><?= $profile->profile_name ?></th>
                            <td><?= $profile->profile_value ?></td>
                        </tr> 
                        <?php
                    }
                }
                ?>
            </table>
        </div>
    </div>
    <div class="col-md-3">        


        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Other Info</h3>
            </div>
            <table class="table table-condensed">
                <?php
                foreach ($dto->profile as $profile) {
                    if ($profile->profile_group == 'OI') {
                        ?>     
                        <tr>
                            <th><?= $profile->profile_name ?></th>
                            <td><?= $profile->profile_value ?></td>
                        </tr> 
                        <?php
                    }
                }
                ?>
            </table>
        </div>


        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Next Of Kin Info</h3>
            </div>
            <table class="table table-condensed">
                <?php
                foreach ($dto->profile as $profile) {
                    if ($profile->profile_group == 'KI') {
                        ?>     
                        <tr>
                            <th><?= $profile->profile_name ?></th>
                            <td><?= $profile->profile_value ?></td>
                        </tr> 
                        <?php
                    }
                }
                ?>
            </table>
        </div>
    </div>
</div>


