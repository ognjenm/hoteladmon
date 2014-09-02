<?php

    $this->breadcrumbs=array(
        Yii::t('mx','Polizas')=>array('index'),
        Yii::t('mx','Manage'),
    );

    $this->menu=array(
        array('label'=>Yii::t('mx', 'Refresh'),'icon'=>'icon-refresh','url'=>array('index')),
        array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('/directInvoice')),
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

<?php $this->widget('bootstrap.widgets.TbTabs',
    array(  'id'=>'wizardReservation',
        'type' => 'tabs',
        'tabs' => array(
            array('label' => Yii::t('mx','Account Cheques'),'content' =>$this->renderPartial('_grid', array('model'=>$model),true),'active' => true),
            array('label' => Yii::t('mx','Account Debit'),'content' =>$this->renderPartial('_debitOperations', array('model'=>$model),true)),
            array('label' => Yii::t('mx','Account Credit'),'content' =>$this->renderPartial('_creditOperations', array('model'=>$model),true)),
        ),
    )
);
?>







