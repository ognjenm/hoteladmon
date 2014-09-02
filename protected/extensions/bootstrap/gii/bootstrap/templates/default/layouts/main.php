<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo "<?php"; ?> echo CHtml::encode($this->pageTitle); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="My Web application theme">
        <meta name="author" content="chinuxe@gmail.com">

        <link rel="shortcut icon" href="<?php echo "<?php"; ?> echo Yii::app()->baseUrl; ?>/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="<?php echo "<?php"; ?> echo Yii::app()->baseUrl; ?>/css/main.css" />
        <?php echo "<?php"; ?> Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/style.css'); ?>
    </head>
    <body>
        <div class="content" id="page">
            <div class="row-fluid">

                <div id="header">

                    <div id="logo">
                        <?php echo "<?php"; ?>
                            $path_image=Yii::app()->baseUrl.'/images/logo_header.png';
                            $logo= CHtml::image($path_image,'My web aplication',array("title" =>'My web aplication'));
                            echo $logo;
                        ?>
                    </div>

                    <div id="lang">
                        <?php echo "<?php"; ?> $this->widget('application.components.LangBox'); ?>
                    </div>

                </div><!-- header -->

                <div id="navigation">
                    <?php echo "<?php"; ?> require_once('tpl_navigation.php')?>
                </div><!-- mainmenu -->

                <div id="sidebar">
                    <?php echo "<?php"; ?>
                        $this->widget('bootstrap.widgets.TbMenu', array(
                            'type'=>'list',
                            'items'=>$this->menu,
                            'htmlOptions'=>array('class'=>'sidemenu'),
                            'encodeLabel'=>false,
                        ));
                    ?>
                </div>

                <?php echo "<?php"; ?> echo $content; ?>
                <div class="clear"></div>

                <div id="footer">
                    <?php echo "<?php"; ?> require_once('tpl_footer.php')?>
                </div><!-- footer -->

            </div><!-- row-fluid -->
        </div><!-- page -->
    </body>
</html>