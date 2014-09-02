<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo Yii::app()->name; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Hotel Online Marketing Tool es un servicio de Promocion y Marketing en Internet para Hoteles online">
    <meta name="author" content="Hotel Marketing Tool">
    <link href="http://fonts.googleapis.com/css?family=Carrois+Gothic" rel="stylesheet" type="text/css">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Fav and Touch and touch icons -->
    <link rel="shortcut icon" href="<?php echo Yii::app()->theme->baseUrl;?>/images/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo Yii::app()->theme->baseUrl;?>/img/icons/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo Yii::app()->theme->baseUrl;?>/img/icons/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo Yii::app()->theme->baseUrl;?>/img/icons/apple-touch-icon-57-precomposed.png">
    <link href="<?php echo Yii::app()->theme->baseUrl;?>/css/style.css" rel="stylesheet" />
</head>
<body class="login">
<div class="wrapper box2">
    <div class="login-body">

        <div class="row-fluid">

            <div class="span10 offset1">
                <?php
                $this->beginWidget('zii.widgets.CPortlet', array(
                    'title'=>'<h2>'.ucwords(CrugeTranslator::t("RECOVER PASSWORD")).'</h2>',
                ));
                ?>

                <div class="form">

                    <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'pwdrcv-form',
                        'enableClientValidation'=>false,
                        'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                        ),
                    )); ?>

                    <div class="row">
                        <?php echo $form->labelEx($model,'username'); ?>
                        <?php echo $form->textField($model,'username'); ?>
                        <?php echo $form->error($model,'username'); ?>
                    </div>

                    <?php if(CCaptcha::checkRequirements()): ?>
                        <div class="row">
                            <?php echo $form->labelEx($model,'verifyCode'); ?>
                            <div>
                                <?php $this->widget('CCaptcha'); ?>
                                <?php echo $form->textField($model,'verifyCode'); ?>
                            </div>
                            <div class="hint"><?php echo CrugeTranslator::t("Please enter characters or digits you see in the picture");?></div>
                            <?php echo $form->error($model,'verifyCode'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="form-actions">
                        <?php Yii::app()->user->ui->tbutton("Recover the Key"); ?>
                    </div>

                    <?php echo Yii::app()->user->ui->loginLink; ?>



                    <?php $this->endWidget(); ?>
                </div>
                <?php $this->endWidget();?>

            </div>

        </div>
    </div>
</body>
</html>

