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
