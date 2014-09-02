
<?php
    $this->breadcrumbs=array(
        Yii::t('mx','Direct Invoice')=>array('index'),
        Yii::t('mx','Create'),
    );

    $this->menu=array(
        array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('index')),
    );

    $this->pageSubTitle=Yii::t('mx','Create');
    $this->pageIcon='icon-ok';

?>

<?php

$facturas="";
$pending=0;

if($amount!=0) $facturas="<strong>Las facturas no debe exceder los: "." $".number_format($amount,2)."</strong><br>";
if($totalFacturas!=0) $facturas.="<strong>Total Facturado: "." $".number_format($totalFacturas,2)."</strong><br>";
if($amount!=0 && $totalFacturas!=0){
    $pending=$amount-$totalFacturas;
    $facturas.="<strong>Pendiente por facturar: "." $".number_format($pending,2)."</strong>";

    Yii::app()->user->setFlash('warning', $facturas);

    $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true,
        'fade'=>true,
        'closeText'=>'×',
        'alerts'=>array('warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×')),
    ));

}



?>


<?php echo $this->renderPartial('_form', array('model'=>$model,'items'=>$items)); ?>