
    <?php
    $this->breadcrumbs=array(
        Yii::t('mx','Lista')=>array('index'),
        Yii::t('mx','Manage'),
    );

    $this->menu=array(
        array('label'=>Yii::t('mx', 'Lista'),'icon'=>'icon-refresh','url'=>array('index')),
        array('label'=>Yii::t('mx','Create'),'icon'=>'icon-plus','url'=>array('create')),
    );

    $this->pageSubTitle=Yii::t('mx','Manage');
    $this->pageIcon='icon-cogs';

    if(Yii::app()->user->hasFlash('success')):
        Yii::app()->user->setFlash('success', '<strong>done!</strong> '.Yii::app()->user->getFlash('success'));
    endif;

    $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true,
        'fade'=>true,
        'closeText'=>'×',
        'alerts'=>array(
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
        ),
    ));


    $order=Yii::getPathOfAlias('ext.manipulacion');
    $assets =Yii::app()->assetManager->publish($order);
    $lenguaje=substr(Yii::app()->getLanguage(), 0, 2);

    $cs = Yii::app()->getClientScript();
    $cs->registerScriptFile($assets.'/js/manipulacion.js');

    ?>


    <div id="divContenedor">

        <div id="divContenedorTabla">
            <table align="center" width="450">
                <thead>
                <tr>
                    <th>Articulo</th>
                    <th>Tel&eacute;fono</th>
                    <th>Correo electr&oacute;nico</th>
                    <th width="22">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><input type="text" class="clsAnchoTotal"></td>
                    <td><input type="text" class="clsAnchoTotal"></td>
                    <td><input type="text" class="clsAnchoTotal"></td>
                    <td align="right"><input type="button" value="-" class="clsEliminarFila"></td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="4" align="right">
                        <input type="button" value="Agregar una fila" class="clsAgregarFila">
                        <input type="button" value="Clonar la tabla" class="clsClonarTabla">
                        <input type="button" value="Eliminar la tabla" class="clsEliminarTabla">
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>




 <?php /*$this->renderPartial('_grid', array(
        'model' => $model,
    ));*/

 ?>







