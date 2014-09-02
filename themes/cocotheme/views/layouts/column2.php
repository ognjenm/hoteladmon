<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

    <div class="container-fluid">

        <div class="row-fluid">

            <div class="span12">

                <?php if(isset($this->breadcrumbs)):?>
                    <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
                            'links'=>$this->breadcrumbs,
                            'homeLink'=>CHtml::link('<i class="icon-home"></i>', array('/site/index')),
                            ));
                    ?><!-- breadcrumbs -->
                <?php endif?>

                <div class="box-title">
                    <h3><i class="<?php echo $this->pageIcon; ?> icon-2x"></i>
                        <?php echo $this->pageSubTitle; ?></h3>

                </div>

                <div id="sidebar">
                    <?php
                    $this->widget('bootstrap.widgets.TbMenu', array(
                        'type'=>'list',
                        'items'=>$this->menu,
                        'htmlOptions'=>array('class'=>'sidemenu'),
                        'encodeLabel'=>false,
                    ));
                    ?>
                </div>

                <?php echo $content; ?>
            </div>
        </div>
    </div>


<?php $this->endContent(); ?>
