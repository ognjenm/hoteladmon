<?php

    class TemplateHiddenInputField extends TemplateAbstractField
    {
        public function getField($widgetId, $rowGroupName='', $rowIndex, $model, $attribute, $name, $value='', $fieldClassName='', $htmlOptions=array(), $hasError=false, $data='', $params='')
        {
            if ($hasError) {$fieldClassName=$fieldClassName.' '.CHtml::$errorCss;}
            $htmlOptions=ClonnableFields::addClass($htmlOptions, $fieldClassName);

            $htmlOptions['style'] = 'display:none';

            if (ClonnableFields::isModel($model))
            {
                return CHtml::activeHiddenField($model, $attribute, $htmlOptions);
            }
            else
            {
                return CHtml::hiddenField($name, $value, $htmlOptions);
            }
        }
    }