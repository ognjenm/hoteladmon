<?php

class TemplateTextFieldAppended extends TemplateAbstractField
{
    public function getField($widgetId, $rowGroupName='', $rowIndex, $model, $attribute, $name, $value='', $fieldClassName='', $htmlOptions=array(), $hasError=false, $data='', $params='')
    {
        $prepend = (isset($params['prepend']) && $params['prepend']);
        $additionClass = $prepend ? 'input-prepend' : 'input-append';
        $prependHtml = isset($params['prependHtml']) ? $params['prependHtml'] : '';
        $prependHtml= CHtml::tag('span', array('class'=>'add-on'), $prependHtml);

        if ($hasError) {$fieldClassName=$fieldClassName.' '.CHtml::$errorCss;}
        $htmlOptions=ClonnableFields::addClass($htmlOptions, $fieldClassName);

        if (ClonnableFields::isModel($model))
        {
            $inputHtml = CHtml::activeTextField($model, $attribute, $htmlOptions);
        }
        else
        {
            $inputHtml =  CHtml::textField($name, $value, $htmlOptions);
        }

        return CHtml::tag('div', array('class'=>$additionClass), $prepend ? $prependHtml.$inputHtml : $inputHtml.$prependHtml);
    }
}