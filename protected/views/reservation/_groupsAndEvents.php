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
                //'fieldsetWrapper' => array('tag' => 'div', 'htmlOptions' => array('class' => 'span3')),

            ));

        ?>

        <div class="form-actions">
            <?php echo $bdgtReservationForm->renderElement('budget'); ?>
            <?php echo $bdgtReservationForm->renderElement('undiscountedBudget'); ?>
        </div>

    <?php echo $bdgtReservationForm->renderEnd();?>


    <?php

    $this->widget('bootstrap.widgets.TbCKEditor',array(
        'name'=>'ckeditorActivities',
        'value'=>'',
        'editorOptions'=>array(
            'height'=>'400',
            //'contentsCss'=> Yii::app()->theme->baseUrl.'/css/ckeditor.css',
            //'stylesSet'=> '[]'
        ),

    ) );

    ?>

    <div style="display: none;" id="actionsActivities">

        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'label' => Yii::t('mx','Agregar a hospedaje'),
            'type' => 'primary',
            'icon'=>'icon-ok',
            'htmlOptions' => array(
                'data-toggle' => 'modal',
                'data-target' => '#modalActivities',
            ),
        )); ?>

    </div>


    <?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'modalActivities')); ?>
        <div class="modal-header">
            <a class="close" data-dismiss="modal">
                <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/close_green.png'); ?>
            </a>
            <h4><i class="icon-user"></i> <?php echo Yii::t('mx','Activities'); ?></h4>
        </div>

        <div class="modal-body"><?php echo $customerReservationForm->render(); ?></div>

        <div class="modal-footer">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'label' => Yii::t('mx','Cancel'),
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
            )); ?>
        </div>
    <?php $this->endWidget(); ?>