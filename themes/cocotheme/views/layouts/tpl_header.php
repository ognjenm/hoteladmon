
    <h1 id="logo-text">Coco<span class="gray">Aventura</span></h1>
    <h2 id="slogan">CABAÑAS, CLUB DE PLAYA & CAMPING</h2>


    <div id="logo">
    <?php $path_image=Yii::app()->theme->baseUrl.'/images/logo.jpg';
			$logo= CHtml::image($path_image,'CocoAventura',array("title" =>'CocoAventura','width'=>'100px','height'=>'100px'));
    ?>
        <?php //echo $logo; ?>
    </div>


        <div class="navbar-search pull-right">
            <div id="lang">
                <?php $this->widget('application.components.LangBox'); ?>
            </div>
        </div>
