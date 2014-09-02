<?php
/**
 * by chinux chinuxe@gmail.com
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n";
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label=$this->class2name($this->modelClass);
echo "\$this->breadcrumbs=array(
	Yii::t('mx','$label')=>array('index'),
	Yii::t('mx','Update'),
	\$model->{$nameColumn}=>array('view','id'=>\$model->{$this->tableSchema->primaryKey}),
);\n";
?>

$this->menu=array(
    array('label'=>Yii::t('mx','Back'),'icon'=>'icon-chevron-left','url'=>array('index')),
    array('label'=>Yii::t('mx','Create'),'icon'=>'icon-plus','url'=>array('create')),
    array('label'=>Yii::t('mx','View'),'icon'=>'icon-eye-open','url'=>array('view','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>)),
);

$this->pageSubTitle=Yii::t('mx','Update');
$this->pageIcon='icon-edit';

?>


<?php echo "<?php echo \$this->renderPartial('_form',array('model'=>\$model)); ?>"; ?>




