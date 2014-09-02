<?php
/**
 * Created by PhpStorm.
 * User: cocoaventura
 * Date: 10/01/14
 * Time: 17:25
 */
?>

<?php
$this->breadcrumbs=array(
    Yii::t('mx','Audit Trails')=>array('/auditTrail'),
    Yii::t('mx','Manage'),
);
/*
$this->menu=array(
	array('label'=>'List AuditTrail', 'url'=>array('index')),
	array('label'=>'Create AuditTrail', 'url'=>array('create')),
);
*/

$this->pageSubTitle=Yii::t('mx','Audit Trails');
$this->pageIcon='icon-cogs';


?>

<p>
    <?php echo Yii::t('mx','You may optionally enter a comparison operator'); ?> (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    <?php echo Yii::t('mx','or'); ?> <b>=</b>) <?php echo Yii::t('mx','at the beginning of each of your search values to specify how the comparison should be done'); ?>.
</p>



<?php $this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => Yii::t('mx', 'Audit Trail'),
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

<?php $this->widget('bootstrap.widgets.TbExtendedGridView', array(
    'id'=>'audit-trail-grid',
    'type' => 'hover condensed',
    'emptyText' => Yii::t('mx','There are no data to display'),
    'showTableOnEmpty' => false,
    'summaryText' => '<strong>'.Yii::t('mx','Audit Trail').': {count}</strong>',
    'template' => '{items}{pager}',
    'responsiveTable' => true,
    'enablePagination'=>true,
    'pager' => array(
        'class' => 'bootstrap.widgets.TbPager',
        'displayFirstAndLast' => true,
    ),
    'dataProvider'=>$model->customers(),
    'filter'=>$model,
    'columns'=>array(
        //'id',
        'old_value',
        'new_value',
        //'action',
        //'model',
        'field',
        'stamp',
        array(
            'name'=>'user_id',
            'value'=>'$data->user->username'
        ),
        //'model_id',
        //		array(
        //			'class'=>'CButtonColumn',
        //		),
    ),
)); ?>

<?php $this->endWidget();?>
