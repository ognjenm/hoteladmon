<?php

class File extends CFormModel
{
	public $filex;
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('filex', 'file',
				  //'allowEmpty'=>'true',
				  'types'=>'vcf',
				  'maxSize'=>1024 * 1024 * 1, // 1MB
                  'tooLarge'=>'The file was larger than 1MB. Please upload a smaller file.',
				 ),
			);
	}

    public function attributeLabels()
    {
        return array(
            'filex' => Yii::t('mx','File vcard')
        );
    }

}