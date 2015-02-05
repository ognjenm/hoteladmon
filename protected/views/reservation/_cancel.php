<?php
/**
 * Created by PhpStorm.
 * User: usof03
 * Date: 28/01/2015
 * Time: 05:48 PM
 */
?>

    <?php echo $Formcancel->renderBegin(); ?>

        <div id="amountDiv" class="span-1"></div>

        <div id="fechayhora" style="display: none">
            <?php echo $Formcancel['cancelDate']; ?>
            <?php echo $Formcancel->renderElement('ok'); ?>
        </div>

        <div id="devolucionDiv" style="display: none">
            <?php echo $Formcancel['total']; ?>
            <?php echo $Formcancel['charge']; ?>
            <?php echo $Formcancel['reimburse']; ?>
            <?php echo $Formcancel['type_reimburse']; ?>
            <?php echo $Formcancel['account_id']; ?>
            <?php echo $Formcancel['status']; ?>
            <?php echo $Formcancel->renderElement('cancel'); ?>
        </div>

        <div id="botones">
            <?php echo $Formcancel->renderElement('si'); ?>
            <?php echo $Formcancel->renderElement('no'); ?>
        </div>

    <?php echo $Formcancel->renderEnd(); ?>
