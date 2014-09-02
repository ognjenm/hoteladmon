<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
    <link rel="shortcut icon" href="<?php echo Yii::app()->theme->baseUrl;?>/images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/main.css" />
    <?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->theme->baseUrl.'/css/style.css'); ?>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body class="custom-background">

    <div class='notifications top-right'></div>

    <div class="content" id="page">

        <div class="row-fluid">

            <div id="header">
                <?php include('tpl_header.php'); ?>
            </div><!-- header -->

            <div id="menu">
                <?php include('tpl_navigation.php'); ?>
            </div><!-- mainmenu -->

            <?php echo $content; ?>

            <div class="clear"></div>

            <div id="footer">
            <?php include('tpl_footer.php'); ?>
            </div> <!-- footer -->

        </div><!-- row-fluid -->
    </div><!-- page -->

</body>
</html>
