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
    Yii::t('mx','Transfer'),
);

$this->menu=array(
    array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('/assignment')),
);

$this->pageSubTitle=Yii::t('mx','Transfer');
$this->pageIcon='icon-exchange';

?>


<?php echo $this->renderPartial('_transfer', array('model'=>$model)); ?>