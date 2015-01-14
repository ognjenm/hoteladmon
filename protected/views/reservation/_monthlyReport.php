<?php

$this->breadcrumbs=array(
    Yii::t('mx','Reports')=>array('index'),
    Yii::t('mx','Monthly report'),
);

$this->menu=array(
    array('label'=>Yii::t('mx','Back'),'icon'=>'icon-chevron-left','url'=>array('overviewCalendar'))
);

$this->pageSubTitle=Yii::t('mx','Reports');
$this->pageIcon='icon-cogs';


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

?>

<div id="mainDiv">
    <?php echo $FormReport->render(); ?>

        <?php $this->widget('bootstrap.widgets.TbCKEditor',array(
            'name'=>'ckeditor1',
            'value'=>'',
            'editorOptions'=>array(
                'height'=>'400',
                'contentsCss'=> Yii::app()->theme->baseUrl.'/css/reportsTable.css',
            ),

        ) );
        ?>
</div>