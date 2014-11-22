<div class="row-fluid">
    <div class="span4">

        <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
            'title' => Yii::t('mx', 'Customer'),
            'headerIcon' => 'icon-user',
            'htmlOptions' => array('class'=>'box box-color'),
            'htmlContentOptions'=>array('class'=>'box-content'),
        ));?>

            <p><strong><?php echo Yii::t('mx','Name'); ?>:</strong> <?php echo $customer->first_name; ?><p>
            <p><strong><?php echo Yii::t('mx','Last Name'); ?>:</strong> <?php echo $customer->last_name; ?><p>
            <p><strong><?php echo Yii::t('mx','Home Phone'); ?>:</strong> <?php echo $customer->home_phone; ?><p>
            <p><strong><?php echo Yii::t('mx','State'); ?>:</strong> <?php echo $customer->state; ?><p>
            <p><strong><?php echo Yii::t('mx','Email'); ?>:</strong> <?php echo $customer->email; ?><p>

        <?php $this->endWidget();?>

    </div>
    <div class="span4">

        <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
            'title' => Yii::t('mx', 'Balance'),
            'headerIcon' => 'icon-book',
            'htmlOptions' => array('class'=>'box box-color'),
            'htmlContentOptions'=>array('class'=>'box-content'),
        ));?>

        <p><strong><?php echo Yii::t('mx','Importe de reservacion'); ?>:</strong> $<?php echo number_format($importe->total,2); ?><p>
        <p><strong><?php echo Yii::t('mx','Total Charges'); ?>:</strong> $<?php echo number_format($totalcharges,2); ?><p>
        <p><strong><?php echo Yii::t('mx','Total Payments'); ?>:</strong> $<?php echo number_format($totalpayments,2) ?><p>
        <!--<p><strong><?php //echo Yii::t('mx','Balance'); ?>:</strong> $<?php //echo number_format(($totalcharges-$totalpayments),2) ?><p> !-->

        <?php $this->endWidget();?>

    </div>
</div>

<?php $provider = $gridPayments; ?>
<div class="inner" id="payments-grid-inner">

    <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => Yii::t('mx', 'Payments'),
        'headerIcon' => 'icon-plus',
        'htmlOptions' => array('class'=>'bootstrap-widget-table'),
        'htmlContentOptions'=>array('class'=>'box-content nopadding'),
        'headerButtons' => array(
            array(
                'class' => 'bootstrap.widgets.TbButton',
                'type' => 'primary',
                'label'=>Yii::t('mx','Add Payment'),
                'htmlOptions' => array(
                    'data-toggle' => 'modal',
                    'data-target' => '#payment-modal',
                ),
            ),
        )

    ));?>

        <?php $this->widget('bootstrap.widgets.TbExtendedGridView',array(
            'id'=>'payments-grid',
            'type' => 'hover condensed',
            'emptyText' => Yii::t('mx','There are no data to display'),
            'showTableOnEmpty' => false,
            'summaryText' => '<strong>'.Yii::t('mx','Payments').': {count}</strong>',
            'template' => "{items}{pager}",
            'responsiveTable' => true,
            'enablePagination'=>true,
            'dataProvider'=>$provider,
            'columns'=>array(
                'datex',
                array(
                    'name'=>'payment_type',
                    'value'=>'$data->payment->payment',
                ),
                array(
                    'name'=>'account_id',
                    'value'=>'BankAccounts::model()->accountByPk($data->account_id)',
                ),
                array(
                    'name'=>'amount',
                    'value'=>'number_format($data->amount,2)',
                ),
                array(
                    'class'=>'bootstrap.widgets.TbButtonColumn',
                    'deleteConfirmation' =>Yii::t('mx','Do you really want to delete this item?'),
                    'headerHtmlOptions' => array('style' => 'width:150px;'),
                    'header'=>Yii::t('mx','Actions'),
                    'template'=>'{view}{delete}',
                    'buttons'=>array(
                        'view'=>array(
                            'url'=>'Yii::app()->createUrl("payments/view", array("id"=>$data->id))',
                            'options'=>array(
                                'ajax'=>array(
                                    'type'=>'POST',
                                    'url'=>"js:$(this).attr('href')",
                                    'success'=>'function(data) {
                                        $("#detail-modal .modal-body p").html(data);
                                        $("#detail-modal").modal();
                                    }'
                                ),
                            ),
                        )
                    )
                ),
            ),

        ));
        ?>

    <?php $this->endWidget();?>

</div>

<div class="inner" id="charges-grid-inner">

    <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => Yii::t('mx', 'Charges'),
        'headerIcon' => 'icon-minus',
        'htmlOptions' => array('class'=>'bootstrap-widget-table'),
        'htmlContentOptions'=>array('class'=>'box-content nopadding'),
        'headerButtons' => array(
            array(
                'class' => 'bootstrap.widgets.TbButton',
                'type' => 'primary',
                'label'=>Yii::t('mx','Add Charge'),
                'htmlOptions' => array(
                    'data-toggle' => 'modal',
                    'data-target' => '#charge-modal',
                ),
            ),
        )

    ));?>

    <?php $this->widget('bootstrap.widgets.TbExtendedGridView',array(
        'id'=>'charges-grid',
        'type' => 'hover condensed',
        'emptyText' => Yii::t('mx','There are no data to display'),
        'showTableOnEmpty' => false,
        'summaryText' => '<strong>'.Yii::t('mx','Charges').': {count}</strong>',
        'template' => "{items}{pager}",
        'responsiveTable' => true,
        'enablePagination'=>true,
        'dataProvider'=>$gridCharges,
        'columns'=>array(
            array(
                'name'=>'concept_id',
                'value'=>'$data->concepto->concept',
            ),
            'description',
            array(
                'name'=>'amount',
                'value'=>'number_format($data->amount,2)',
            ),
            array(
                'class'=>'bootstrap.widgets.TbButtonColumn',
                'deleteConfirmation' =>Yii::t('mx','Do you really want to delete this item?'),
                'headerHtmlOptions' => array('style' => 'width:150px;'),
                'header'=>Yii::t('mx','Actions'),
                'template'=>'{view}',
                'buttons'=>array(
                    'view'=>array(
                        'url'=>'Yii::app()->createUrl("charges/view", array("id"=>$data->id))',
                        'options'=>array(
                            'ajax'=>array(
                                'type'=>'POST',
                                'url'=>"js:$(this).attr('href')",
                                'success'=>'function(data) {
                                    $("#detail-modal .modal-body p").html(data);
                                    $("#detail-modal").modal();
                                }'
                            ),
                        ),
                    )
                )
            ),
        ),
    ));
    ?>

    <?php $this->endWidget();?>


</div>