<?php
/**
 * Created by PhpStorm.
 * User: chinux
 * Date: 1/16/14
 * Time: 12:26 AM
 */
?>

    <div class="alert in alert-block fade alert-error" id="error-alert" style="display:none;">
        <div id="customer-error"></div>
        <div id="message-request"></div>
    </div>

    <p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mx','are required');?>.
    </p>

    <span class="help-block error" id="Customers_email_em_" style="display: none;"></span>


<?php echo $customerForm->renderBegin(); ?>

    <?php  echo $customerForm['id']; ?>
    <?php  echo $customerForm['email']; ?>
    <?php  echo $customerForm['alternative_email']; ?>
    <?php  echo $customerForm['first_name']; ?>
    <?php  echo $customerForm['last_name']; ?>
    <?php  echo $customerForm['country']; ?>
    <?php  echo $customerForm['state']; ?>
    <?php  echo $customerForm['city']; ?>
    <?php  echo $customerForm['how_find_us']; ?>

    <div class="controls controls-row">
        <?php  echo $customerForm['international_code1']; ?>
        <?php  echo $customerForm['home_phone']; ?>
    </div>
    <div class="controls controls-row">
        <?php  echo $customerForm['international_code2']; ?>
        <?php  echo $customerForm['work_phone']; ?>
    </div>
    <div class="controls controls-row">
        <?php  echo $customerForm['international_code3']; ?>
        <?php  echo $customerForm['cell_phone']; ?>
    </div>

    <div class="form-actions">
        <?php
        if($action=='CREATE') echo $customerForm->renderElement('submit');
        else echo $customerForm->renderElement('update');
        ?>
    </div>

<?php echo $customerForm->renderEnd(); ?>
