<?php $this->beginContent('//layouts/main'); ?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div style="clear:both" id="submenu"></div>
            <?php if(isset($this->breadcrumbs)):?>
            <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
                                    'links'=>$this->breadcrumbs,
                                    'homeLink'=>CHtml::link('<i class="icon-home"></i>', array('site/index')),
                                    ));
                            ?><!-- breadcrumbs -->
            <?php endif?>
            <div class="box-title">
                <h3><i class="<?php echo $this->pageIcon; ?> icon-2x"></i> <?php echo $this->pageSubTitle; ?></h3>
            </div>
            <div style="clear:both"></div>
            <?php echo $content; ?>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>