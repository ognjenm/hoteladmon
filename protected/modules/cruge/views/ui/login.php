<h<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Hotel Online Marketing Tool es un servicio de Promocion y Marketing en Internet para Hoteles online">
    <meta name="author" content="Hotel Marketing Tool">
    <link href='http://fonts.googleapis.com/css?family=Carrois+Gothic' rel='stylesheet' type='text/css'>

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
<div class="sun">
<div class="wrapper box1">
    <div class="login-body">
        <h2>SIGN IN</h2>
        <?php if(Yii::app()->user->hasFlash('loginflash')): ?>
            <div class="flash-error">
                <?php echo Yii::app()->user->getFlash('loginflash'); ?>
            </div>
        <?php else: ?>

            <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                'id'=>'login',
                'enableClientValidation'=>false,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
            )); ?>
            <div class="email">
                <?php echo $form->textField($model,'username',array('class'=>'input-block-level','placeholder'=>'User Name')); ?>
                <?php echo $form->error($model,'username'); ?>
            </div>
            <div class="pw">
                <?php echo $form->passwordField($model,'password',array('placeholder'=>'Enter Password','class'=>'input-block-level')); ?>
                <?php echo $form->error($model,'password'); ?>
            </div>
            <div class="inputwrapper animate4 bounceIn">
                <?php echo $form->checkBox($model,'rememberMe'); ?>
                <?php echo $form->label($model,'rememberMe'); ?>
                <?php echo $form->error($model,'rememberMe'); ?>
            </div>
            <div class="submit">
                <?php Yii::app()->user->ui->tbutton(CrugeTranslator::t('logon', "SIGN ME IN")); ?>
            </div>
            <?php
            //	si el componente CrugeConnector existe lo usa:
            //
            if(Yii::app()->getComponent('crugeconnector') != null){
                if(Yii::app()->crugeconnector->hasEnabledClients){
                    ?>
                    <div class='crugeconnector'>
                        <span><?php echo CrugeTranslator::t('logon', 'You also can login with');?>:</span>
                        <ul>
                            <?php
                            $cc = Yii::app()->crugeconnector;
                            foreach($cc->enabledClients as $key=>$config){
                                $image = CHtml::image($cc->getClientDefaultImage($key));
                                echo "<li>".CHtml::link($image,
                                        $cc->getClientLoginUrl($key))."</li>";
                            }
                            ?>
                        </ul>
                    </div>
                <?php }} ?>
            <?php $this->endWidget(); ?>
        <?php endif; ?>
        <div class="forget">
            <?php echo Yii::app()->user->ui->passwordRecoveryLink; ?>
            <?php
            if(Yii::app()->user->um->getDefaultSystem()->getn('registrationonlogin')===1)
                echo Yii::app()->user->ui->registrationLink;
            ?>
        </div>
    </div>
</div>
</div>
</body>
</html>