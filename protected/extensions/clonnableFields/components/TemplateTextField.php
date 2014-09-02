<?php

class TemplateTextField extends TemplateAbstractField
{
    public function getField($widgetId, $rowGroupName='', $rowIndex, $model, $attribute, $name, $value='', $fieldClassName='', $htmlOptions=array(), $hasError=false, $data='', $params='')
    {
        if ($hasError) {$fieldClassName=$fieldClassName.' '.CHtml::$errorCss;}
        $htmlOptions=ClonnableFields::addClass($htmlOptions, $fieldClassName);

        if (ClonnableFields::isModel($model))
        {
            /** CModel $model */
            return CHtml::activeTextField($model, $attribute, $htmlOptions);
        }
        else
        {
            return CHtml::textField($name, $value, $htmlOptions);
        }
    }
}