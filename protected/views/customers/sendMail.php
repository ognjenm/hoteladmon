<?php

    $this->breadcrumbs=array(
        Yii::t('mx','Customers')=>array('index'),
        Yii::t('mx','Send Mail'),
    );

    $this->menu=array(
        array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('index')),
    );

    $this->pageSubTitle=Yii::t('mx','Send Mail');
    $this->pageIcon='icon-envelope';

    Yii::app()->clientScript->registerScript('filters', "

        $(document).ready(function () {
            $('#ckbCheckAll').click(function () {
                $('.select-on-check').prop('checked', $(this).prop('checked'));
            });
        });


    ");

?>

<div class="row-fluid">
    <div class="span4">
        <?php echo $customers ?>
    </div>
    <div class="span8">
        <?php echo $this->renderPartial('_formEmail', array('model'=>$model)); ?>
    </div>
</div>

