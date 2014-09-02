<?php
/**
 * Created by PhpStorm.
 * User: chinux
 * Date: 1/16/14
 * Time: 1:04 AM
 */
?>

<h4><?php echo Yii::t('mx', 'Questions internal CocoAventura'); ?></h4>
<h3><?php echo Yii::t('mx', 'NO ASK TO CUSTOMERS'); ?></h3>

<div id="pollSending">

    <?php echo $pollForm->renderBegin(); ?>

        <fieldset>
            <legend><?php echo Yii::t('mx', 'How we contact the customer?'); ?></legend>

            <div class="control-group">
                <div class="controls">
                    <?php echo $pollForm['medio']; ?>
                </div>
            </div>

            <div class="agents" style="display: none">
                <div class="control-group">
                    <div class="controls">
                        <?php echo $pollForm['sales_agent_id']; ?>
                        <?php $this->widget('bootstrap.widgets.TbButton', array(
                            'label' => Yii::t('mx','Other'),
                            'type' => 'primary',
                            'icon'=>'icon-ok',
                            'htmlOptions' => array(
                                'data-toggle' => 'modal',
                                'data-target' => '#salesAgent1',
                            ),
                        )); ?>
                    </div>
                </div>
            </div>

            <div class="usedEmail" style="display: none">
                <div class="control-group">
                    <div class="controls">
                        <?php echo $pollForm['used_email']; ?>
                    </div>
                </div>
            </div>

            <div class="arrivedEmail" style="display: none">
                <div class="control-group">
                    <div class="controls">
                        <?php echo $pollForm['arrived_email']; ?>
                    </div>
                </div>
            </div>

            <div class="reservationChannel" style="display: none">
                <div class="control-group">
                    <div class="controls">
                        <?php echo $pollForm['reservation_channel_id']; ?>
                        <?php $this->widget('bootstrap.widgets.TbButton', array(
                            'label' => Yii::t('mx','Other'),
                            'type' => 'primary',
                            'icon'=>'icon-ok',
                            'htmlOptions' => array(
                                'data-toggle' => 'modal',
                                'data-target' => '#reservationChannel1',
                            ),
                        )); ?>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <?php echo $pollForm->renderElement('save'); ?>
            </div>

        </fieldset>

    <?php echo $pollForm->renderEnd(); ?>

</div>


