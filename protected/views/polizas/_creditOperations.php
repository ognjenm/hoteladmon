<?php $provider = $model->accountCredit(); ?>
<div class="inner" id="polizas-grid-inner">

    <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => Yii::t('mx', 'Polizas'),
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

    <?php $this->widget('bootstrap.widgets.TbExtendedGridView',array(
        'id'=>'credit-grid',
        'type' => 'hover condensed',
        'emptyText' => Yii::t('mx','There are no data to display'),
        'showTableOnEmpty' => false,
        'summaryText' => '<strong>'.Yii::t('mx','Polizases').': {count}</strong>',
        'template' => '{items}{pager}',
        'responsiveTable' => true,
        'enablePagination'=>true,
        'dataProvider'=>$provider,
        'filter'=>$model,
        'columns'=>array(
            array(
                'name'=>'date',
                'value'=>'$data->accountCredit->datex'
            ),
            array(
                'name'=>'bank',
                'value'=>'BankAccounts::model()->accountByPk($data->accountCredit->accountBank->id)',
                'filter'=>BankAccounts::model()->listAll()
            ),
            array(
                'name'=>'cheq',
                'value'=>'$data->accountCredit->cheq'
            ),
            array(
                'name'=>'released',
                'value'=>'$data->accountCredit->released'
            ),
            array(
                'name'=>'retirement',
                'value'=>'"$".number_format($data->accountCredit->retirement,2)',
                'htmlOptions'=>array('style'=>'width:100px; text-align: right;color:red;font-style:italic;'),
            ),

            array(
                'class'=>'bootstrap.widgets.TbButtonColumn',
                'deleteConfirmation' =>Yii::t('mx','Do you really want to delete this item?'),
                'headerHtmlOptions' => array('style' => 'width:150px;text-align: center;'),
                'header'=>Yii::t('mx','Actions'),
                'template'=>'{view}{delete}{pdf}',
                'buttons'=>array(
                    /*'cheque'=>array(
                        'label'=>Yii::t('mx','Cheq'),
                        'imageUrl'=>Yii::app()->theme->baseUrl.'/images/cheque.png',
                        'url'=>'Yii::app()->createUrl("polizas/generaCheque", array("id"=>$data->id))'
                    ),*/
                    'pdf'=>array(
                        'label'=>Yii::t('mx','Export Pdf'),
                        'imageUrl'=>Yii::app()->theme->baseUrl.'/images/pdf.png',
                        'url'=>'Yii::app()->createUrl("polizas/polizaToPdf", array("id"=>$data->id))'
                    )
                )
            ),
        ),
    ));
    ?>

    <?php $this->endWidget();?>


</div>