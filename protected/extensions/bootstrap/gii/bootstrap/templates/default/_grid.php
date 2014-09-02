<?php
/**
 * by chinux chinuxe@gmail.com
 * - $this: the CrudCode object
 */
?>
<?php echo '<?php'; ?> $provider = $model->search(); ?>
<div class="inner" id="<?php echo $this->class2id($this->modelClass); ?>-grid-inner">

    <?php echo '<?php'; ?> $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => Yii::t('mx', '<?php echo $this->class2name($this->modelClass); ?>'),
        'headerIcon' => 'icon-th-list',
        'htmlOptions' => array('class'=>'bootstrap-widget-table'),
        'htmlContentOptions'=>array('class'=>'box-content nopadding'),
        'headerButtons' => array(
            array(
                'class' => 'bootstrap.widgets.TbButtonGroup',
                'type' => 'primary',
                'buttons' => array(
                    array('label' =>Yii::t('mx','Operations'), 'items' => $this->menu)
                )
            )
        )

    ));?>

        <?php echo "<?php"; ?> $this->widget('bootstrap.widgets.TbExtendedGridView',array(
            'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
            'type' => 'hover condensed',
            'emptyText' => Yii::t('mx','There are no data to display'),
            'showTableOnEmpty' => false,
            'summaryText' => '<strong>'.Yii::t('mx','<?php echo $this->pluralize($this->class2name($this->modelClass)); ?>').': {count}</strong>',
            'template' => '{items}{pager}',
            'responsiveTable' => true,
            'enablePagination'=>true,
            'dataProvider'=>$provider,
            'filter'=>$model,
            'columns'=>array(
                <?php
                $count=0;
                foreach($this->tableSchema->columns as $column)
                {
                    if(++$count==7)
                        echo "\t\t/*\n";
                    echo "\t\t'".$column->name."',\n";
                }
                if($count>=7)
                    echo "\t\t*/\n";
                ?>
                array(
                    'class'=>'bootstrap.widgets.TbButtonColumn',
                    'deleteConfirmation' =>Yii::t('mx','Do you really want to delete this item?'),
                    'headerHtmlOptions' => array('style' => 'width:150px;'),
                    'header'=>Yii::t('mx','Actions')
                ),
            ),
        ));
        ?>

    <?php echo "<?php"; ?> $this->endWidget();?>


</div>