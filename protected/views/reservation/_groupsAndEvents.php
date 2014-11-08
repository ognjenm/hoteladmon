<?php

/**
 * Created by PhpStorm.
 * User: cocoaventura
 * Date: 5/11/13
 * Time: 11:05
 */
?>

    <?php echo $bdgtReservationForm->renderBegin(); ?>

        <?php

            $formConfig=BdgtReservation::model()->getForm();
            $this->widget('ext.multimodelform.MultiModelForm',array(
                'id' => 'id_activities',
                'formConfig' =>$formConfig,
                'model' =>$bdgtReservation,
                'tableView' => true,
                'validatedItems' => $validatedItems,
                'removeText' =>Yii::t('mx','Remove'),
                'removeHtmlOptions'=>array('class'=>'btn btn-danger'),
                'removeConfirm'=>Yii::t('mx','Delete this item?'),
                'addItemText'=>Yii::t('mx','Add'),
                'addItemAsButton'=>true,
                'tableView'=>true,
                'tableHtmlOptions'=>array('class'=>'items table table-hover table-condensed table-bordered'),
                'data' => $bdgtReservation->findAll('customer_reservation_id=:groupId', array(':groupId'=>$model->id)),
                'hideCopyTemplate'=>false,
                'options'=>array('clearInputs'=>false),
                'jsAfterNewId' => MultiModelForm::afterNewIdDateTimePicker($formConfig['elements']['fecha']),
            ));

        ?>

        <div class="form-actions">
            <?php echo $bdgtReservationForm->renderElement('budget'); ?>
            <?php echo $bdgtReservationForm->renderElement('undiscountedBudget'); ?>
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'id'=>'buttonUndiscountedBudget',
                'label' => Yii::t('mx','Agregar a reservación'),
                'type' => 'primary',
                'buttonType'=>'button',
                'icon'=>'icon-ok',
                'htmlOptions' => array(
                    'data-toggle' => 'modal',
                    'data-target' => '#modalActivities',
                ),
            )); ?>

        </div>

    <?php echo $bdgtReservationForm->renderEnd();?>


    <?php

    $this->widget('bootstrap.widgets.TbCKEditor',array(
        'name'=>'ckeditorActivities',
        'value'=>'',
        'editorOptions'=>array(
            'height'=>'400',
            //'contentsCss'=> Yii::app()->theme->baseUrl.'/css/ckeditor.css',
        ),

    ) );

    ?>

    <?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'modalActivities')); ?>
        <div class="modal-header">
            <a class="close" data-dismiss="modal">
                <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/close_green.png'); ?>
            </a>
            <h4><i class="icon-building"></i> <?php echo Yii::t('mx','Reservations'); ?></h4>
        </div>
        <div id="loadingevent">
            <div class="modal-body">
            <?php echo $customerReservationForm->render(); ?>

            <?php $provider = $gridFindCustomerReservation->search2(); ?>

            <?php $this->widget('bootstrap.widgets.TbGridView',array(
                'id'=>'customerReservationsFilter',
                'type' => 'hover condensed',
                'emptyText' => Yii::t('mx','There are no data to display'),
                'showTableOnEmpty' => false,
                'summaryText' => '<strong>'.Yii::t('mx','Budgets').': {count}</strong>',
                'template' => '{items}{pager}',
                'responsiveTable' => true,
                'enablePagination'=>true,
                'dataProvider'=>$provider,
                'pager' => array(
                    'class' => 'bootstrap.widgets.TbPager',
                    'displayFirstAndLast' => true,
                ),
                'columns'=>array(
                    array(
                        'id'=>'chk',
                        'class'=>'CCheckBoxColumn',
                    ),
                    array(
                        'name'=>'Reservación Id',
                        'value'=>'$data->customer_reservation_id'
                    ),
                    'checkin',
                    'checkout',
                    array(
                        'class'=>'bootstrap.widgets.TbButtonColumn',
                        'deleteConfirmation' =>Yii::t('mx','Do you really want to delete this item?'),
                        'headerHtmlOptions' => array('style' => 'width:150px;text-align:center;'),
                        'template'=>'',
                    ),
                ),
            ));
            ?>

            <div class="modal-footer">
                <?php $this->widget('bootstrap.widgets.TbButton', array(
                    'id'=>'saveActivities',
                    'buttonType'=>'ajaxButton',
                    'label' => Yii::t('mx','ok'),
                    'url' => '#',
                    'icon'=>'icon-ok',
                    'url'=>$this->createUrl('/bdgtReservation/save'),
                    'ajaxOptions'=>array(
                        'type'=>'POST',
                        'dataType'=>'json',
                        'data'=> "js:{customerReservationId:$.fn.yiiGridView.getChecked('customerReservationsFilter','chk').toString()}",
                        'beforeSend'=> 'function() { $("#loadingevent").addClass("loading"); }',
                        'complete' => 'function() { $("#loadingevent").removeClass("loading"); }',
                        'success'=>"function(data){

                        }",
                    ),

                )); ?>
            </div>

        </div>
        </div>
        <div class="modal-footer">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'label' => Yii::t('mx','Cancel'),
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
            )); ?>
        </div>
    <?php $this->endWidget(); ?>

