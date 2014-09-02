<?php
/**
 * by chinux chinuxe@gmail.com
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>

<?php
echo "<?php\n";
$label=$this->class2name($this->modelClass);
echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	Yii::t('mx','Create'),
);\n";

?>

$this->menu=array(
    array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('index')),
);

$this->pageSubTitle=Yii::t('mx','Create');
$this->pageIcon='icon-ok';

?>

<?php echo "<?php echo \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>
