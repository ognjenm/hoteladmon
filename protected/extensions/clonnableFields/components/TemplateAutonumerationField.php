<?php

    class TemplateAutonumerationField extends TemplateAbstractField
    {
        public function getField($widgetId, $rowGroupName='', $rowIndex, $model, $attribute, $name, $value='', $fieldClassName='', $htmlOptions=array(), $hasError=false, $data='', $params='')
        {
            $template = isset($params['template'])?$params['template']:'';
            $content = ($template!=='')?str_replace('{num}', $rowIndex, $template):$rowIndex;
            if (isset($htmlOptions['id'])) {unset($htmlOptions['id']);}

            $htmlOptions=ClonnableFields::addClass($htmlOptions, $fieldClassName);

            return CHtml::tag('div',$htmlOptions, $content);
        }

        public function beforeAddRowCustomAction($fieldName='', $fieldClassName='', $data='', $params='')
        {
            $template = isset($params['template'])?$params['template']:'{num}';
            return "
            var template = '".$template."';
            jQuery('.$fieldClassName', target).html(template.replace('{num}', currentClonedNum));
            ";
        }

        public function afterRemoveRowCustomAction($fieldName='', $fieldClassName='', $data='', $params='')
        {
            $template = isset($params['template'])?$params['template']:'{num}';
            return "
            var template = '".$template."';
            jQuery('.$fieldClassName', widget).each
            (
                function(i, elem)
                {
                    jQuery(this).html(template.replace('{num}', i));
                }
            );
            ";
        }

        public function afterSortRowsCustomAction($fieldName='', $fieldClassName='', $data='', $params='')
        {
            return $this->afterRemoveRowCustomAction($fieldName, $fieldClassName, $data, $params);
        }
    }