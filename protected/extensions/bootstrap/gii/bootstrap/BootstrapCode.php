<?php
/**
 * BootstrapCode class file.
 * @author Chinux <chinuxe@gmail.com>
 * @copyright Copyright &copy; Chinux 2013-2015
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

Yii::import('gii.generators.crud.CrudCode');

class BootstrapCode extends CrudCode
{
    public $generateLayouts = true;
    public $generateComponents = true;
    public $layoutPrefix = '';

    public function rules()
    {
        return array_merge(parent::rules(), array(
            array('generateComponents, generateLayouts,layoutPrefix','sticky'),
        ));
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), array(
            'generateComponents' => 'Generate Components and Widgets',
            'generateLayouts' => 'Generate Layouts',
            'layoutPrefix' => 'Layout Prefix',
        ));
    }



	public function generateActiveRow($modelClass, $column)
	{
		if ($column->type === 'boolean') {
			return "\$form->checkBoxRow(\$model,'{$column->name}')";
		} else if (stripos($column->dbType, 'text') !== false) {
			return "\$form->textAreaRow(\$model,'{$column->name}',array('rows'=>6, 'cols'=>50, 'class'=>'span5'))";
		} else {
			if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name)) {
				$inputField = 'passwordFieldRow';
			} else {
				$inputField = 'textFieldRow';
			}

			if ($column->type !== 'string' || $column->size === null) {
				return "\$form->{$inputField}(\$model,'{$column->name}',array('class'=>'span5'))";
			} else {
				return "\$form->{$inputField}(\$model,'{$column->name}',array('class'=>'span5','maxlength'=>$column->size))";
			}
		}
	}


    public function prepare()
    {

        $this->files = array();
        $templatePath = $this->templatePath;
        $controllerTemplateFile = $templatePath . DIRECTORY_SEPARATOR . 'controller.php';
        $this->files[] = new CCodeFile(
            $this->controllerFile,
            $this->render($controllerTemplateFile)
        );
        $files = scandir($templatePath);
        foreach ($files as $file)
        {
            if (is_file($templatePath . '/' . $file) && CFileHelper::getExtension($file) === 'php' && $file !== 'controller.php')
            {
                $this->files[] = new CCodeFile(
                    $this->viewPath . DIRECTORY_SEPARATOR . $file,
                    $this->render($templatePath . '/' . $file)
                );
            }
        }

        if ($this->generateComponents)
		{
			$templatePath = $this->templatePath . DIRECTORY_SEPARATOR . 'components';
			$files = scandir($templatePath);
			foreach ($files as $file)
			{
				if (is_file($templatePath . '/' . $file) && CFileHelper::getExtension($file) === 'php')
				{
					$this->files[] = new CCodeFile(
						Yii::getPathOfAlias('application.components') . DIRECTORY_SEPARATOR . $file,
						$this->render($templatePath . '/' . $file)
					);
				}
			}
			$templatePath = $this->templatePath . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'views';
			$files = scandir($templatePath);
			foreach ($files as $file)
			{
				if (is_file($templatePath . '/' . $file) && CFileHelper::getExtension($file) === 'php')
				{
					$this->files[] = new CCodeFile(
						Yii::getPathOfAlias('application.components.views') . DIRECTORY_SEPARATOR . $file,
						$this->render($templatePath . '/' . $file)
					);
				}
			}
		}

		if ($this->generateLayouts)
		{
			$templatePath = $this->templatePath . DIRECTORY_SEPARATOR . 'layouts';
			$files = scandir($templatePath);
			foreach ($files as $file)
			{
				if (is_file($templatePath . '/' . $file) && CFileHelper::getExtension($file) === 'php')
				{
					$this->files[] = new CCodeFile(
						$this->layoutPath . DIRECTORY_SEPARATOR . $file,
						$this->render($templatePath . '/' . $file)
					);
				}
			}
		}

    }

    public function getLayoutPath()
	{
		return rtrim($this->getModule()->getLayoutPath() . DIRECTORY_SEPARATOR . str_replace('.', DIRECTORY_SEPARATOR, $this->layoutPrefix), DIRECTORY_SEPARATOR);
	}

	public function getRelativeLayoutPath()
	{
		return rtrim('layouts/' . str_replace('.', '/', $this->layoutPrefix), '/');
	}


}
