<?php
/**
 * Created by  chinux
 * Date: 8/7/13
 * Time: 6:16 PM
 * email: chinuxe@gmail.com
 */

?>

<?php echo $form->render(); ?>

    <div id="reserv" style="display:none;">

        <?php

        echo $reservationForm->renderBegin();

            $formConfig=Reservation::model()->getForm();
            $this->widget('ext.multimodelform.MultiModelForm',array(
                'id' => 'id_member',
                'formConfig' =>$formConfig,
                'model' =>$reservation,
                'tableView' => true,
                'validatedItems' => $validatedItems,
                'removeText' =>Yii::t('mx','Remove'),
                'removeConfirm'=>Yii::t('mx','Delete this item?'),
                'addItemText'=>Yii::t('mx','Add'),
                'tableView'=>true,
                'tableHtmlOptions'=>array('class'=>'items table table-hover table-condensed'),
                'data' => $reservation->findAll('customer_reservation_id=:groupId', array(':groupId'=>$model->id)),
                'hideCopyTemplate'=>false,
                'options'=>array('clearInputs'=>false),
                'jsAfterNewId' => MultiModelForm::afterNewIdDateTimePicker($formConfig['elements']['checkin']),
                'jsBeforeClone'=>$formConfig,
                'jsAfterNewId' => MultiModelForm::afterNewIdDateTimePicker($formConfig['elements']['checkout']),
            ));

        ?>

        <div class="form-actions">
            <?php echo $reservationForm->renderElement('budget'); ?>
            <?php echo $reservationForm->renderElement('undiscountedBudget'); ?>
        </div>

        <?php echo $reservationForm->renderEnd();?>


    </div>

    <!--  inicia formulario para hacer la reservacion !-->


    <?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'myModal')); ?>
        <div class="modal-header">
            <a class="close" data-dismiss="modal">
                <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/close_green.png'); ?>
            </a>
            <h4><i class="icon-check"></i> <?php echo Yii::t('mx','Reservation'); ?></h4>
        </div>

        <div id="messages-reservation" class="modal-body">
            <?php
            $this->widget('bootstrap.widgets.TbTabs',
                array(  'id'=>'wizardReservation',
                        'type' => 'tabs',
                        'tabs' => array(
                            array('label' => Yii::t('mx','Step One'),'content' =>$this->renderPartial('_customer', array('customerForm'=>$CustomerForm,'action'=>'CREATE'),true),'active' => true),
                            array('label' => Yii::t('mx','Step Two'),'content' =>$this->renderPartial('_poll', array('pollForm'=>$pollForm),true)),
                        ),
                )
            );

            ?>
        </div>

        <div class="modal-footer">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'label' => Yii::t('mx','Cancel'),
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
            )); ?>
        </div>
    <?php $this->endWidget(); ?>

    <div id="detailsGrid"></div>

    <br>
    <br>

    <div style="display: none;" id="actions">

        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'label' => Yii::t('mx','Reservation'),
            'type' => 'primary',
            'icon'=>'icon-ok',
            'htmlOptions' => array(
                'data-toggle' => 'modal',
                'data-target' => '#myModal',
            ),
        )); ?>

    </div>


<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'salesAgent1')); ?>
    <div class="modal-header">
        <a class="close" data-dismiss="modal">
            <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/close_green.png'); ?>
        </a>
        <h4><i class="icon-user"></i> <?php echo Yii::t('mx','Sales Agents'); ?></h4>
    </div>

    <div class="modal-body">
        <div id="saveSalesAgents">
            <?php echo $formSalesAgents->render(); ?>
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


<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' =>'reservationChannel1')); ?>
    <div class="modal-header">
        <a class="close" data-dismiss="modal">
            <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/close_green.png'); ?>
        </a>
        <h4><i class="icon-user"></i> <?php echo Yii::t('mx','Reservation Channel'); ?></h4>
    </div>

    <div class="modal-body">
        <div id="saveReservationChannel">
            <?php echo $formReservationChannel->render(); ?>
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




