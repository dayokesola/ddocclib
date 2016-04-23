<?php
$page->Paint('Joins Request - ' . $dto->community_name);
$page->PageHeader();
if (count($dtos) > 0) {
    $form->Start('community_joins');
    ?>
    <div class="row">
        <div class="col-md-12">
            <?php $page->Alert(); ?>
            <div>
                <?php
                $form->Submit('submit', 'Accept', 'link', 1, 0, 'btn-sm');
                $form->Submit('submit', 'Reject', 'link', 1, 0, 'btn-sm');
                ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-condensed table-bordered small" id="tablechecks">
                <tr>
                    <th style="width: 15px">
                        <button type="button" name="checktoggle" id="checktoggle" class="btn btn-link btn-xs">
                            <i class="fa fa-check-square"></i></button>
                    </th>
                    <th><?= $dtos[0]->labels['fname'] ?></th>
                    <th><?= $dtos[0]->labels['lname'] ?></th>
                    <th><?= $dtos[0]->labels['email'] ?></th>
                    <th><?= $dtos[0]->labels['mobile'] ?></th>
                    <th><?= $dtos[0]->labels['last_updated'] ?></th>
                </tr>
                <?php
                foreach ($dtos as $dto) {
                    ?>
                    <tr>
                        <td class="text-center">
                            <?php $form->CheckBoxBare('user_ids[]', '', $dto->user_id); ?>                    
                        </td>
                        <td><?= $dto->fname ?></td>
                        <td><?= $dto->lname ?></td>
                        <td><?= $dto->email ?></td>
                        <td><?= $dto->mobile ?></td>
                        <td><?= \com\ddocc\base\utility\Gizmo::PrettyDate($dto->last_updated) ?></td>   
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </div>
    <?php
    $form->Close();
} else {
    echo 'No pending requests';
}
?>
<script type="text/javascript">
    jQuery(function($) {
        $('#tablechecks').checkboxes('range', true);
        $('#checktoggle').on('click', function(e) {
            $('#tablechecks').checkboxes('toggle');
            e.preventDefault();
        });
    });
</script>