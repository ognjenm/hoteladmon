<?php

    $this->breadcrumbs=array(
        Yii::t('mx','Direct Invoice')=>array('index'),
        Yii::t('mx','Manage'),
    );

    $this->menu=array(
        array('label'=>Yii::t('mx', 'Refresh'),'icon'=>'icon-refresh','url'=>array('index')),
        array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('index')),
        array('label'=>Yii::t('mx','Polizas'),'icon'=>'icon-bar-chart','url'=>array('/polizas')),
    );

    $this->pageSubTitle=Yii::t('mx','History');
    $this->pageIcon='icon-list';

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

<?php $this->renderPartial('_history', array(
    'model' => $model,
));
?>





