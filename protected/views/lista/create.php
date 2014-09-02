
<?php
$this->breadcrumbs=array(
	'Lista'=>array('index'),
	Yii::t('mx','Create'),
);

$this->menu=array(
    array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('index')),
);

$this->pageSubTitle=Yii::t('mx','Create');
$this->pageIcon='icon-ok';

$order=Yii::getPathOfAlias('ext.tableorder');
$assets =Yii::app()->assetManager->publish($order);
$lenguaje=substr(Yii::app()->getLanguage(), 0, 2);

$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($assets.'/js/jquery.tablednd.0.7.min.js');
$cs->registerCssFile($assets.'/css/tablednd.css');


?>

<script type="text/javascript">

    var index=1;

    $(document).ready(function() {

        // Make a nice striped effect on the table
        $("#table-2 tr:even").addClass("alt");
        // Initialise the second table specifying a dragClass and an onDrop function that will display an alert
        $("#table-2").tableDnD({
            onDragClass: "myDragClass",
            onDrop: function(table, row) {
                var rows = table.tBodies[0].rows;
                var debugStr = "Row dropped was "+row.id+". New order: ";
                for (var i=0; i<rows.length; i++) {
                    debugStr += rows[i].id+" ";
                }
                $("#debugArea").html(debugStr);
            },
            onDragStart: function(table, row) {
                $("#debugArea").html("Started dragging row "+row.id);
            }
        });

        $(document).on('click','.clsClonarTabla',function(){
            var objTabla=$('#lista-form');       //$(this).parents().get(4);
            //agregamos un clon de la tabla a la capa contenedora
            $('#divContenedor').append($(objTabla).clone());
        });

    });
</script>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>