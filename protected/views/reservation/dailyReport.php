
<?php
$this->breadcrumbs=array(
    Yii::t('mx','Reservations')=>array('index'),
    Yii::t('mx','Daily Report'),
);

$this->menu=array(
    array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('cabanaCalendar')),
);

$this->pageSubTitle=Yii::t('mx','Daily Report');
$this->pageIcon='icon-ok';

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

<?php

$this->widget('bootstrap.widgets.TbCKEditor',array(
    'name'=>'ckeditor',
    'value'=>$tabla,
    'editorOptions'=>array(
        'height'=>'400'
    ),

) );

?>