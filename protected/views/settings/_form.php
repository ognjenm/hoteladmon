<?php echo $form->renderBegin(); ?>


    <?php $this->widget('bootstrap.widgets.TbTabs',
        array(  'id'=>'wizardReservation',
            'type' => 'tabs',
            'tabs' => array(
                array('label' => Yii::t('mx','Reservations'),'content' =>$this->renderPartial('_reservations', array('form'=>$form),true),'active' => true),
                array('label' => Yii::t('mx','Tax Information'),'content' =>$this->renderPartial('_taxInformation', array('form'=>$form),true)),
                array('label' => Yii::t('mx','Billing'),'content' =>$this->renderPartial('_billing', array('form'=>$form),true)),
                array('label' => Yii::t('mx','General'),'content' =>$this->renderPartial('_general', array('form'=>$form),true)),
            ),
        )
    );
    ?>

    <div class="form-actions">
        <?php echo $form->renderElement('send'); ?>
    </div>

<?php echo $form->renderEnd(); ?>
