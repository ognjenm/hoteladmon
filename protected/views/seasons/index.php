    <?php
    $this->breadcrumbs=array(
        Yii::t('mx','Seasons')=>array('index'),
        Yii::t('mx','Manage'),
    );

    $this->menu=array(
        array('label'=>Yii::t('mx','Refresh'),'icon'=>'icon-refresh','url'=>array('index')),
        array('label'=>Yii::t('mx','Create'),'icon'=>'icon-plus','url'=>array('create')),
        array('label'=>Yii::t('mx', 'Update Calendar'),'icon'=>'icon-calendar','url'=>array('calendar')),
    );

    $this->pageSubTitle=Yii::t('mx','Manage');
    $this->pageIcon='icon-cogs';




    if(Yii::app()->user->hasFlash('success')):
    Yii::app()->user->setFlash('success', '<strong>done!</strong> '.Yii::app()->user->getFlash('success'));
    endif;

    $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'×', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
        ),
    ));

?>

    <?php echo Yii::app()->user->setFlash('warning', Yii::t('mx','IMPORTANT: Please do not forget to update the calendar after adding new holidays.')); ?>
    <?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true,
        'fade'=>true,
        'closeText'=>'×',
        'alerts'=>array('warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×')),
    ));
    ?>


 <?php $this->renderPartial('_grid', array(
        'model' => $model,
    ));
 ?>






