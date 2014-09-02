<?php

class TemplateSelectField extends TemplateAbstractField
{
    public function getField($widgetId, $rowGroupName='', $rowIndex, $model, $attribute, $name, $value='', $fieldClassName='', $htmlOptions=array(), $hasError=false, $data='', $params='')
    {
        if ($hasError) {$fieldClassName=$fieldClassName.' '.CHtml::$errorCss;}
        $htmlOptions=ClonnableFields::addClass($htmlOptions, $fieldClassName);

        if (ClonnableFields::isModel($model))
        {
             return CHtml::activeDropDownList($model, $attribute, $data, $htmlOptions);
        }
        else
        {
            return CHtml::dropDownList($name, $value, $data, $htmlOptions);
        }

    }
}