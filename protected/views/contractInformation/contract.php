<?php
    $this->breadcrumbs=array(
        Yii::t('mx','Contracts')=>array('index'),
        Yii::t('mx','Create'),
    );

    $this->menu=array(
        array('label'=>Yii::t('mx', 'Contracts'),'icon'=>'icon-chevron-left','url'=>array('gridContract')),
    );

    $this->pageSubTitle=Yii::t('mx','Create');
    $this->pageIcon='icon-ok';

?>

<?php echo $this->renderPartial('_contract', array('contract'=>$contract)); ?>