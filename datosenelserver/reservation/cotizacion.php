<?php
$cnt = 1;
$labels = '';

$colums=array('date','adults','children','pets','total','subtotal');

foreach ($colums as $column) {
    $labels .= "#details td:nth-of-type($cnt):before { content: '{$column}'; }\n";
    $cnt++;
}


$css = <<<EOD
@media
	only screen and (max-width: 760px),
	(min-device-width: 768px) and (max-device-width: 1024px)  {

		#details table,#details thead,#details tbody,#details th,#details td,#details tr {
			display: block;
		}

		#details thead tr {
			position: absolute;
			top: -9999px;
			left: -9999px;
		}

		#details tr { border: 1px solid #ccc; }

		#details td {
			/* Behave  like a "row" */
			border: none;
			border-bottom: 1px solid #eee;
			position: relative;
			padding-left: 50%;
		}

		#details td:before {
			position: absolute;
			top: 6px;
			left: 6px;
			width: 45%;
			padding-right: 10px;
			white-space: nowrap;
		}
		.grid-view .button-column {
			text-align: left;
			width:auto;
		}

		{$labels}
	}
EOD;

Yii::app()->clientScript->registerCss(__CLASS__ . '#details', $css);


$this->breadcrumbs=array(
    Yii::t('mx','Cotizacion')=>array('index'),
);

$this->menu=array(
    array('label'=>Yii::t('mx','Back'),'icon'=>'chevron-left','url'=>array('index')),
    array('label'=>Yii::t('mx','Print'),'icon'=>'print','url'=>array('print'))

);

$this->pageSubTitle=Yii::t('mx','Quote Details');
$this->pageIcon='icon-list-alt';

$totalprice=0;

$c=0;

$table='
    <table class="items table table-hover table-condensed" id="details">
    <thead>
        <tr>
            <th>'.Yii::t('mx','Date').'</th>
            <th>'.Yii::t('mx','Adults').'</th>
            <th>'.Yii::t('mx','Children').'</th>
            <th>'.Yii::t('mx','Pets').'</th>
            <th>'.Yii::t('mx','Total Pax').'</th>
            <th>'.Yii::t('mx','Subtotal').'</th>
        </tr>
    <thead>
    <tr>
';


for($i=$checkin;$i< $checkout+86400;$i+=86400):

    $date=date('Y-m-d',$i);

    foreach($model[$c++] as $item):
        echo $item->room_id.' - '.$item->type_reservation_id.' - '.$item->season."<br>";
        foreach($item->prices as $p):
            $table.='<tr><td colspan="4">'.$date.'</td><td>'.$p->pax.'</td><td>'.$p->price.'</td></tr>';
            $totalprice+=$p->price;

        endforeach;

    endforeach;

endfor;

$table.='</table>';

$this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => Yii::t('mx', 'Details'),
    'headerIcon' => 'icon-th-list',
    'htmlOptions' => array('class'=>'bootstrap-widget-table'),
    'htmlContentOptions'=>array('class'=>'box-content nopadding'),
    'headerButtons' => array(
        array(
            'class' => 'bootstrap.widgets.TbButtonGroup',
            'type' => 'primary',
            'buttons' => array(
                array('label' =>Yii::t('mx','Operations'), 'items' => $this->menu)
            )
        )
    )

));

    echo '<div class="grid-view">';
    echo $table;
    echo '<div class="well pull-right extended-summary span3">
            <h3>'.Yii::t('mx','Total').': $'.$totalprice.' MX</h3>
         </div>';
    echo '</div>';

$this->endWidget();

?>




