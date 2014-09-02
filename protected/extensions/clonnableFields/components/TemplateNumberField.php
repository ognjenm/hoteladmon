<?php

    class TemplateNumberField extends TemplateAbstractField
    {
        public function getField($widgetId, $rowGroupName='', $rowIndex, $model, $attribute, $name, $value='', $fieldClassName='', $htmlOptions=array(), $hasError=false, $data='', $params='')
        {
            if ($hasError) {$fieldClassName=$fieldClassName.' '.CHtml::$errorCss;}
            $htmlOptions=ClonnableFields::addClass($htmlOptions, $fieldClassName);

            $htmlOptions['type']='number';

            if (!isset($htmlOptions['name'])) {$htmlOptions['name']=$name;}
            if (!isset($htmlOptions['value'])) {$htmlOptions['value']=$value;}
            $htmlOptions['type']='number';


            if (ClonnableFields::isModel($model))
            {
                return CHtml::activeNumberField($model, $attribute, $htmlOptions);
            }
            else
            {
                return CHtml::tag('input',$htmlOptions);
            }
        }
    }