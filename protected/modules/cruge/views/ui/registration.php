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

    <div class="wrapper box2">
        <div class="login-body padding">
            <div class="row-fluid">
                <div class="span12">
                    <?php
                        $this->beginWidget('zii.widgets.CPortlet',array('title'=>'<h3>'.ucwords(CrugeTranslator::t("REGISTRATION")).'</h3>'));
                    ?>
                    <div class="form">
                        <?php
                        /*
                            $model:  es una instancia que implementa a ICrugeStoredUser
                        */
                        ?>
                        <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                            'id'=>'registration-form',
                            'enableAjaxValidation'=>false,
                            'enableClientValidation'=>false,
                        )); ?>
                        <div class="row form-group-vert">
                            <h6><?php echo ucfirst(CrugeTranslator::t("datos de la cuenta"));?></h6>
                            <?php
                            foreach (CrugeUtil::config()->availableAuthModes as $authmode){
                                echo "<div class='col'>";
                                echo $form->labelEx($model,$authmode);
                                echo $form->textField($model,$authmode);
                                echo $form->error($model,$authmode);
                                echo "</div>";
                            }
                            ?>
                            <div class="col">
                                <?php echo $form->labelEx($model,'newPassword'); ?>
                                <div class='item'>
                                    <?php echo $form->textField($model,'newPassword'); ?>
                                    <p class='hint'><?php echo CrugeTranslator::t("Su contraseña, letras o digitos o los caracteres @#$%. minimo 6 simbolos.");?></p>
                                </div>
                                <?php echo $form->error($model,'newPassword'); ?>
                                <script>
                                    function fnSuccess(data){
                                        $('#CrugeStoredUser_newPassword').val(data);
                                    }
                                    function fnError(e){
                                        alert("error: "+e.responseText);
                                    }
                                </script>
                                <?php echo CHtml::ajaxbutton(
                                    CrugeTranslator::t("Generar una nueva clave")
                                    ,Yii::app()->user->ui->ajaxGenerateNewPasswordUrl
                                    ,array('success'=>new CJavaScriptExpression('fnSuccess'),
                                        'error'=>new CJavaScriptExpression('fnError'))
                                ); ?>
                            </div>
                        </div>


                        <!-- inicio de campos extra definidos por el administrador del sistema -->
                        <?php
                        if(count($model->getFields()) > 0){
                            echo "<div class='row form-group-vert'>";
                            echo "<h6>".ucfirst(CrugeTranslator::t("perfil"))."</h6>";
                            foreach($model->getFields() as $f){
                                // aqui $f es una instancia que implementa a: ICrugeField
                                echo "<div class='col'>";
                                echo Yii::app()->user->um->getLabelField($f);
                                echo Yii::app()->user->um->getInputField($model,$f);
                                echo $form->error($model,$f->fieldname);
                                echo "</div>";
                            }
                            echo "</div>";
                        }
                        ?>
                        <!-- fin de campos extra definidos por el administrador del sistema -->


                        <!-- inicio - terminos y condiciones -->
                        <?php
                        if(Yii::app()->user->um->getDefaultSystem()->getn('registerusingterms') == 1)
                        {
                            ?>
                            <div class='form-group-vert'>
                                <h6><?php echo ucfirst(CrugeTranslator::t("terminos y condiciones"));?></h6>
                                <?php echo CHtml::textArea('terms'
                                    ,Yii::app()->user->um->getDefaultSystem()->get('terms')
                                    ,array('readonly'=>'readonly','rows'=>5,'cols'=>'80%')
                                ); ?>
                                <div><span class='required'>*</span><?php echo CrugeTranslator::t(Yii::app()->user->um->getDefaultSystem()->get('registerusingtermslabel')); ?></div>
                                <?php echo $form->checkBox($model,'terminosYCondiciones'); ?>
                                <?php echo $form->error($model,'terminosYCondiciones'); ?>
                            </div>
                            <!-- fin - terminos y condiciones -->
                        <?php } ?>



                        <!-- inicio pide captcha -->
                        <?php if(Yii::app()->user->um->getDefaultSystem()->getn('registerusingcaptcha') == 1) { ?>
                            <div class='row form-group-vert'>
                                <h6><?php echo ucfirst(CrugeTranslator::t("codigo de seguridad"));?></h6>

                                    <div>
                                        <?php $this->widget('CCaptcha'); ?>
                                        <?php echo $form->textField($model,'verifyCode'); ?>
                                    </div>
                                    <div class="hint"><?php echo CrugeTranslator::t("por favor ingrese los caracteres o digitos que vea en la imagen");?></div>
                                    <?php echo $form->error($model,'verifyCode'); ?>
                            </div>
                        <?php } ?>
                        <!-- fin pide captcha-->



                        <div class="row buttons">
                            <?php Yii::app()->user->ui->tbutton("Registrarse"); ?>
                        </div>
                        <?php echo $form->errorSummary($model); ?>
                        <?php $this->endWidget(); ?>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </div>
    </div>



</body>
</html>