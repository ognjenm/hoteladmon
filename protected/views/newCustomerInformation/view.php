    <?php

    $this->breadcrumbs=array(
        Yii::t('mx','New Customer Information')=>array('index'),
         Yii::t('mx','View'),
    );

    $this->menu=array(
        array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('index')),

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
                'email',
                'alternative_email',
                'first_name',
                'last_name',
                'country',
                'state',
                'city',
                array(
                    'name'=>Yii::t('mx','Home Phone'),
                    'value'=>$model->home_phone
                ),
                array(
                    'name'=>Yii::t('mx','Work Phone'),
                    'value'=>$model->work_phone
                ),
                array(
                    'name'=>Yii::t('mx','Cell Phone'),
                    'value'=>$model->cell_phone
                ),
            ),
            )); ?>
