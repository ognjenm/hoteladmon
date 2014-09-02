<?php
/**
 * Created by PhpStorm.
 * User: chinux
 * Date: 14/04/14
 * email: chinuxe@hmail.com
 */
?>



<?php
$this->breadcrumbs=array(
    Yii::t('mx','Assignment')=>array('index'),
    Yii::t('mx','Reports'),
);

$this->menu=array(
    array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('index')),
);

$this->pageSubTitle=Yii::t('mx','Reports');
$this->pageIcon='icon-file-alt';

?>
<?php echo $this->renderPartial('_reports', array()); ?>