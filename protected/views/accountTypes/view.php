    <?php
$this->breadcrumbs=array(
        Yii::t('mx','Account Types')=>array('index'),
         Yii::t('mx','View'),
    );

    $this->menu=array(
        array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('index')),
        array('label'=>Yii::t('mx','Create'),'icon'=>'icon-plus','url'=>array('create')),
        array('label'=>Yii::t('mx','Update'),'icon'=>'icon-pencil','url'=>array('update','id'=>$model->id)),
        array('label'=>Yii::t('mx','Delete'),'icon'=>'icon-remove','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('mx','Are you sure you want to delete this item?'))),
    );


    $this->pageSubTitle=Yii::t('mx','View');
    $this->pageIcon='icon-list-alt';


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



            <?php $this->widget('bootstrap.widgets.TbDetailView',array(
            'data'=>$model,
            'attributes'=>array(
            		'id',
		            'tipe',
            ),
            )); ?>
