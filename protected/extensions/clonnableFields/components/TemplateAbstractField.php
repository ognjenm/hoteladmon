<?php
    abstract class TemplateAbstractField
    {
        /* Данные методы должны быть определёны в дочернем классе */

        /** Возвращает HTML код поля, который должен быть клонирован
         *
         * @param string $widgetId - ID виджета
         * @param string $rowGroupName - имя группы
         * @param integer $rowIndex - номер строки
         * @param CModel|null $model
         * @param string $attribute
         * @param $name - имя поля
         * @param mixed $value - значение
         * @param string $fieldClassName - CSS класс, который назначен полю
         * @param array $htmlOptions
         * @param bool $hasError - индикатор ошибки валидации
         * @param string|array $data - дополнительные данные
         * @param string|array $params - дополнительные параметры
         *
         * @internal param $ СActiveRecord $model - модель
         * @return mixed - HTML код поля
         */
        abstract public function getField($widgetId, $rowGroupName='', $rowIndex, $model, $attribute, $name, $value='', $fieldClassName='', $htmlOptions=array(), $hasError=false, $data='', $params='');

        /** Java функции, которые буду выполняться при создании каждой клонируемой записи
         * @param mixed $fieldName
         * @param string $fieldClassName - CSS класс, который назначен полю
         * @param mixed $data
         * @param mixed $params
         * @return string
         */
        public function beforeAddRowCustomAction($fieldName='', $fieldClassName='', $data='', $params='')
        {
            return '';
        }

        /** Java функции, которые буду выполняться при создании каждой клонируемой записи
         * @param mixed $fieldName
         * @param string $fieldClassName - CSS класс, который назначен полю
         * @param mixed $data
         * @param mixed $params
         * @return string
         */
        public function afterAddRowCustomAction($fieldName='', $fieldClassName='', $data='', $params='')
        {
            return '';
        }

        /** Java функции, которые буду выполняться при удалении каждой клонируемой записи
         * @param mixed $fieldName
         * @param string $fieldClassName - CSS класс, который назначен полю
         * @param mixed $data
         * @param mixed $params
         * @return string
         */
        public function beforeRemoveRowCustomAction($fieldName='', $fieldClassName='', $data='', $params='')
        {
            return '';
        }

        /** Java функции, которые буду выполняться при удалении каждой клонируемой записи
         * @param mixed $fieldName
         * @param string $fieldClassName - CSS класс, который назначен полю
         * @param mixed $data
         * @param mixed $params
         * @return string
         */
        public function afterRemoveRowCustomAction($fieldName='', $fieldClassName='', $data='', $params='')
        {
            return '';
        }

        /** Java функции, которые буду выполняться после сортировки строк (например drag'n'drop)
         * @param mixed $fieldName
         * @param string $fieldClassName - CSS класс, который назначен полю
         * @param mixed $data
         * @param mixed $params
         * @return string
         */
        public function afterSortRowsCustomAction($fieldName='', $fieldClassName='', $data='', $params='')
        {
            return '';
        }

        /**
         * Register JS and CSS
         */
        public function registerAssets()
        {
        }
     }