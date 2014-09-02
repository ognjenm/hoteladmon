<?php
/**
 * Created by PhpStorm.
 * User: cocoaventura
 * Date: 26/03/14
 * Time: 12:47
 */
?>


<?php
$this->breadcrumbs=array(
    Yii::t('mx','Bracelets')=>array('/assignment'),
    Yii::t('mx','Buy'),
);

$this->menu=array(
    array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('/assignment')),
);

$this->pageSubTitle=Yii::t('mx','Buy');
$this->pageIcon='icon-plus';

?>


<?php echo $this->renderPartial('_buy', array('model'=>$model)); ?>