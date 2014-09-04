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

<?php echo $customers ?>