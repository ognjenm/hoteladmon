    <?php
    $this->breadcrumbs=array(
        Yii::t('mx','Providers')=>array('index'),
        Yii::t('mx','Manage'),
    );

    $this->menu=array(
        array('label'=>Yii::t('mx', 'Refresh'),'icon'=>'icon-refresh','url'=>array('index')),
        array('label'=>Yii::t('mx','Create'),'icon'=>'icon-plus','url'=>array('create')),
        array('label'=>Yii::t('mx','Export All'),'icon'=>'icon-book','url'=>array('exportAll'),'visible'=>Yii::app()->user->isSuperAdmin),
        array('label'=>Yii::t('mx','Import'),'icon'=>'icon-download-alt','url'=>array('Import'),'visible'=>Yii::app()->user->isSuperAdmin),
    );

    $this->pageSubTitle=Yii::t('mx','Manage');
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

    Yii::app()->clientScript->registerScript('filters', "

        $('#filterForm').submit(function(){

            $('#providers-grid').yiiGridView('update', {
                data: $(this).serialize()
            });

            return false;

        });

         $('.popover-examples a').popover({
                trigger : 'hover',
                placement : 'top',
                html : true
        });

    ");


?>

    <?php echo $formFilter->render(); ?>

 <?php $this->renderPartial('_grid', array(
        'model' => $model,
    ));
 ?>






