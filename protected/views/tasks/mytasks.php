<?php

$this->breadcrumbs=array(
    Yii::t('mx','Tasks')=>array('myTasks'),
    Yii::t('mx','My Tasks'),
);

$this->menu=array(
    array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('/site/index')),
    array('label'=>Yii::t('mx','Create'),'icon'=>'icon-plus','url'=>array('create')),
    array('label'=>Yii::t('mx','History'),'icon'=>'icon-remove','url'=>array('history')),
    array('label'=>Yii::t('mx','Departments'),'icon'=>'icon-home','url'=>array('/departments')),
    array('label'=>Yii::t('mx','Zones'),'icon'=>'icon-map-marker','url'=>array('/zones')),
);

$this->pageSubTitle=Yii::t('mx','My Tasks');
$this->pageIcon='icon-th-list';

if(Yii::app()->user->hasFlash('success')):
    Yii::app()->user->setFlash('success', '<strong>done!</strong> '.Yii::app()->user->getFlash('success'));
endif;

$this->widget('bootstrap.widgets.TbAlert', array(
    'block'=>true,
    'fade'=>true,
    'closeText'=>'×',
    'alerts'=>array(
        'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
    ),
));

Yii::app()->clientScript->registerScript('task2', "

        $('.popover-examples a').popover({
                trigger : 'hover',
                placement : 'top',
                html : true
        });

    ");

?>

<!--
<div class="pull-right">
    <ul class="stats ">
        <li class="satgreen">
            <i class="icon-th-list"></i>
            <div class="details">
                <a href="#" id="linkTask">
                    <span class="big"><?php //echo 3; ?></span>
                    <span><?php //echo Yii::t('mx','New Tasks'); ?></span>
                </a>
            </div>
        </li>
    </ul>

</div>
--!>

<?php $this->renderPartial('_mytasks', array(
    'model' => $model,
));
?>








