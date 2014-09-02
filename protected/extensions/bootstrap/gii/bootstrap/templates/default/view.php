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
         Yii::t('mx','View'),
    );\n";
    ?>

    $this->menu=array(
        array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('index')),
        array('label'=>Yii::t('mx','Create'),'icon'=>'icon-plus','url'=>array('create')),
        array('label'=>Yii::t('mx','Update'),'icon'=>'icon-pencil','url'=>array('update','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>)),
        array('label'=>Yii::t('mx','Delete'),'icon'=>'icon-remove','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>),'confirm'=>Yii::t('mx','Are you sure you want to delete this item?'))),
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



            <?php echo "<?php"; ?> $this->widget('bootstrap.widgets.TbDetailView',array(
            'data'=>$model,
            'attributes'=>array(
            <?php
            foreach($this->tableSchema->columns as $column)
                echo "\t\t'".$column->name."',\n";
            ?>
            ),
            )); ?>
