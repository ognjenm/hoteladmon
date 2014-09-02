<?php
    $this->breadcrumbs=array(
        Yii::t('mx','Operations')=>array('index'),
        Yii::t('mx','Balance'),
    );

    //$this->pageSubTitle=Yii::t('mx','Manage');
    //$this->pageIcon='icon-cogs';

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

    <?php
    foreach( $botones as $botom){

        $this->widget(
            'bootstrap.widgets.TbButtonGroup',
            array(
                'size' => 'large',
                'buttons' => array($botom),
            )
        );

    }
    ?>






