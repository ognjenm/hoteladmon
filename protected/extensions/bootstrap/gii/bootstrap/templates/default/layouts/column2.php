<?php /* @var $this Controller */ ?>
<?php echo '<?php'; ?> $this->beginContent('//<?php echo $this->relativeLayoutPath; ?>/main'); ?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div style="clear:both" id="submenu"></div>
            <?php echo "<?php"; ?> if(isset($this->breadcrumbs)):?>
            <?php echo "<?php"; ?> $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
                                    'links'=>$this->breadcrumbs,
                                    'homeLink'=>CHtml::link('<i class="icon-home"></i>', array('site/index')),
                                    ));
                            ?><!-- breadcrumbs -->
            <?php echo "<?php"; ?> endif?>
            <div class="box-title">
                <h3><i class="<?php echo "<?php"; ?> echo $this->pageIcon; ?> icon-2x"></i> <?php echo "<?php"; ?> echo $this->pageSubTitle; ?></h3>
            </div>
            <div style="clear:both"></div>
            <?php echo "<?php"; ?> echo $content; ?>
        </div>
    </div>
</div>
<?php echo "<?php"; ?> $this->endContent(); ?>