<?php
/**
 * Created by chinux
 * Date: 7/31/13
 * Time: 12:54 PM
 * To change this template use File | Settings | File Templates.
 */

class DualSelect extends CWidget{

    public $leftTitle;
    public $rightTitle;
    public $leftName;
    public $rightName;
    public $leftList;
    public $rightList;
    public $size=15;
    public $width;

    protected function registerClientScript(){

        $cs=Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');
        $cs->registerScriptFile(Yii::app()->getAssetManager()->publish(dirname(__FILE__).'/jquery.dualListBox.js'));
        $cs->registerCssFile(Yii::app()->getAssetManager()->publish(dirname(__FILE__).'/plugins.css'));
        $cs->registerScript("id","$.configureBoxes();");

    }

    public function init(){

        if(!isset($this->leftName)) { throw new CHttpException(500,'"leftName" have to be set!'); }
        if(!isset($this->rightName)){  throw new CHttpException(500,'"rightName" have to be set!'); }
        if(!isset($this->leftList)) { throw new CHttpException(500,'"leftList" have to be set!');  }
        if(!isset($this->rightList)){ throw new CHttpException(500,'"rightList" have to be set!'); }
    }

    public function run()
    {

        echo '<div class="widget">';


        echo '<div class="body">';

            echo '<div class="leftBox span5">';

                //$options=array();
                //foreach($this->leftList as $item) array_push($options,array('class'=>'uno'));

                if(isset($this->leftTitle)) echo CHtml::label($this->leftTitle,'leftTitle');
                echo CHtml::textField('box1filter','',array('id'=>'box1Filter','class'=>'boxFilter','placeholder'=>'Filter Entries','style'=>'width:'.$this->width));
                $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'button',
                    'type'=>'btn',
                    'icon'=>'icon-filter',
                    'label'=>'',
                    'htmlOptions'=>array(
                        'id'=>'box1Clear',
                        'class'=>'dualBtn fltr'
                    )
                ));
                echo CHtml::dropDownList($this->leftName,null,$this->leftList,array(
                    'id'=>'box1View',
                    'multiple'=>'multiple',
                    'size'=>$this->size,
                    'style'=>'width:'.$this->width,
                    'class'=>'multiple',
                    //'options'=>$options
                ));
                echo CHtml::tag('span', array('id'=>'box1Counter','class'=>'countLabel'),true);
                echo CHtml::dropDownList('','',array(),array('id'=>'box1Storage','class'=>'displayNone'));
            echo '</div>';

            echo '<div class="dualControl span1">';
                $this->widget('bootstrap.widgets.TbButtonGroup', array(
                    'stacked'=>true,
                    'buttons' => array(
                        array('buttonType'=>'button','icon'=>'icon-angle-right','htmlOptions'=>array('id'=>'to2','class'=>'dualBtn mr5 mb15 ')),
                        array('buttonType'=>'button','icon'=>'icon-double-angle-right','htmlOptions'=>array('id'=>'allTo2','class'=>'dualBtn')),
                        array('buttonType'=>'button','icon'=>'icon-angle-left','htmlOptions'=>array('id'=>'to1','class'=>'dualBtn mr5')),
                        array('buttonType'=>'button','icon'=>'icon-double-angle-left','htmlOptions'=>array('id'=>'allTo1','class'=>'dualBtn')),
                    ),
                ));
            echo '</div>';

            echo '<div class="rightBox span5">';
                if(isset($this->rightTitle)) echo CHtml::label($this->rightTitle,'rightTitle');
                echo CHtml::textField('box2Filter','',array('id'=>'box2Filter','class'=>'boxFilter','placeholder'=>'Filter Entries','style'=>'width:'.$this->width));
                $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'button',
                    'type'=>'btn',
                    'icon'=>'icon-filter',
                    'label'=>'',
                    'htmlOptions'=>array(
                        'id'=>'box2Clear',
                        'class'=>'dualBtn fltr'
                    )
                ));
                echo CHtml::dropDownList($this->rightName,'',$this->rightList,array('id'=>'box2View','multiple'=>'multiple','size'=>$this->size,'style'=>'width:'.$this->width,'class'=>'multiple'));
                echo CHtml::tag('span', array('id'=>'box2Counter','class'=>'countLabel'),true);
                echo CHtml::dropDownList('','',array(),array('id'=>'box2Storage','class'=>'displayNone'));
            echo '</div>';

            echo '<div class="clear"/>';

        echo '</div>';


        echo '</div>';

        $this->registerClientScript();

        parent::init();
    }

    protected function renderContent(){}
}