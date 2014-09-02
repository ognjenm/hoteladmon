<!--	<footer>
        <div class="subnav navbar navbar-fixed-bottom">
            <div class="navbar-inner">
                <div class="container">
                    Designed by Chinux. All Rights Reserved.<br />
                    <small>Powered by
                        <a href="http://www.yiiframework.com" title="Yii Framework" target="_new">Yii Framework</a> and
                        <a href="http://twitter.github.com/bootstrap/" title="Twitter Bootstrap" target="_new">Twitter Bootstrap</a>
                    </small>
                </div>
            </div>
        </div>      
	</footer>
-->

<?php
$path_image=Yii::app()->baseUrl.'/images/copyright.png';
$images= CHtml::image($path_image,'Copyright',array("title" =>'Copyright'));
?>
<p>Copyright &copy; <?php echo date('Y'); ?> by <?php echo $images; ?> | &nbsp; All Rights Reserved.</p>


