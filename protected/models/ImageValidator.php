<?php

class ImageValidator extends CFileValidator {

    public $width;

    public $height;

    public $dimensionError;

    protected function validateAttribute($object, $attribute) {

        $file = $object->$attribute;

        if (!$file instanceof CUploadedFile) {
            $file = CUploadedFile::getInstance($object, $attribute);

            if (null === $file)
                return $this->emptyAttribute($object, $attribute);
        }


        $data = file_exists($file->tempName) ? getimagesize($file->tempName) : false;

        if (isset($this->width, $this->height) && $data !== false) {
            if ($data[0] < $this->width && $data[1] < $this->height) {
                $message = $this->dimensionError ? $this->dimensionError : Yii::t('yii', 'Minimum dimension of the image should be {width}x{height}');
                $this->addError($object, $attribute, $message, array('{width}' => $this->width, '{height}' => $this->height));
                return;
            }
        }
    }

}

?>