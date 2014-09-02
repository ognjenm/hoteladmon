<?php

    class TemplateFineUploaderField extends TemplateAbstractField
    {
        /**
         * @param string $widgetId
         * @param string $rowGroupName
         * @param int $rowIndex
         * @param CModel|null $model
         * @param string $attribute
         * @param $name
         * @param string $value
         * @param string $fieldClassName
         * @param array $htmlOptions
         * @param bool $hasError
         * @param string $data
         * @param string $params
         *
         * @return mixed|string
         */
        public function getField($widgetId, $rowGroupName='', $rowIndex, $model, $attribute, $name, $value='', $fieldClassName='', $htmlOptions=array(), $hasError=false, $data='', $params='')
        {
            $emptyImage=Yii::app()->params['imagesUrl'].'/no_photo_small.png';
            $imageUrl=$emptyImage;

            $imageObject=ImageObject::getImageObjectFromObject($model, true);
            if ($imageObject)
            {
                if (isset ($imageObject->temp_small_image_url) && $imageObject->temp_small_image_url !='')
                {
                    $imageUrl=$imageObject->temp_small_image_url;
                }
                else
                {
                    $imageUrl=$imageObject->smallImageFile->getUrl();
                }
            }

            if ($hasError) {$fieldClassName=$fieldClassName.' '.CHtml::$errorCss;}
            $htmlOptions=ClonnableFields::addClass($htmlOptions, $fieldClassName);
            $htmlOptions=ClonnableFields::addClass($htmlOptions, 'clonnable-file-id');
            if (isset($htmlOptions['name'])) {$name=$htmlOptions['name'];}

            $fileUrlHtmlOptions=array();
            $hiddenFieldFileUrlName = ClonnableFields::generateFieldName(!$rowIndex>0, $rowGroupName, $rowIndex, 'file_url');
            $fileUrlHtmlOptions['name']=$hiddenFieldFileUrlName;
            $fileUrlHtmlOptions['id']=ClonnableFields::generateFieldId($widgetId, $rowGroupName, $rowIndex, 'file_url');
            $fileUrlHtmlOptions['data-groupname']=$rowGroupName;
            $fileUrlHtmlOptions['data-attribute']='file_url';
            $fileUrlHtmlOptions['data-widgetname']=$widgetId;

            $fileUrlHtmlOptions=ClonnableFields::addClass($fileUrlHtmlOptions, 'clonnable-file-url');

            $assetPath=Yii::app()->assetManager->getPublishedUrl(dirname(dirname(__FILE__)).'/assets/');
            $loading=$assetPath.'/templateFineUploaderField/loading.gif';

            $imageStyle=isset($params['imageStyle'])?' style="'.$params['imageStyle'].'"':'';

            $template ='<div>
                           <div class="messages">
                                <div class="thumbnail">
                                    <img class="uploaded-preview" src="'.$imageUrl.'"'.$imageStyle.'>
                                </div>
                                <div class="progress" style="height:3px; margin-bottom:0px;">
                                   <div class="bar" style="display:none; width: 0%;"></div>
                                </div>
                                <div class="buttons-row">
                                    <div class="'.$fieldClassName.' btn btn-mini upload-button" style="width:100px; '.((int)$value>0 ? 'display:none' : '').'">
                                        <div class="button-title"><i class="icon-upload"></i> '.Yii::t("ClonnableFields.templateFineUploaderField","Upload").'</div>
                                    </div>
                                    <div class="pull-right">
                                        <a href="#" class="delete-image-link" data-toggle="tooltip" title="'.Yii::t("ClonnableFields.templateFineUploaderField","Delete File").'" style="'.((int)$value>0 ? '' : 'display:none').'" ><i class="icon-trash"></i></a>
                                        <a href="#" class="delete-image-wait" data-toggle="tooltip" title="'.Yii::t("ClonnableFields.templateFineUploaderField","Deleting. Please hold.").'" style="display:none" ><img src="'.$loading.'" alt="'.Yii::t("ClonnableFields.templateFineUploaderField","Deleting. Please hold.").'"></a>
                                    </div>
                                </div>
                                <div style="display:none">'.CHtml::hiddenField($name, $value, $htmlOptions).'</div>
                                <div style="display:none">'.CHtml::hiddenField($hiddenFieldFileUrlName, $imageUrl, $fileUrlHtmlOptions).'</div>
                           </div>
                        </div>';

            return $template;

        }

        public function beforeAddRowCustomAction($fieldName='', $fieldClassName='', $data='', $params='')
        {
            $action = isset($params['action'])?$params['action']:'';
            $deleteAction = isset($params['deleteAction'])?$params['deleteAction']:'';

            $emptyImage = isset($params['emptyImage'])?$params['emptyImage']:'';
            $debug = isset($params['debug'])?$params['debug']:'false';
            $allowedExtensions = isset($params['allowedExtensions'])?$params['allowedExtensions']:'[]';
            $sizeLimit = isset($params['sizeLimit'])?$params['sizeLimit']:0;
            $minSizeLimit = isset($params['minSizeLimit'])?$params['minSizeLimit']:0;
            $acceptFiles = isset($params['acceptFiles'])?"'".$params['acceptFiles']."'":"''";

            $assetPath=Yii::app()->assetManager->getPublishedUrl(dirname(dirname(__FILE__)).'/assets/');
            $loading=$assetPath.'/templateFineUploaderField/loading.gif';
            $js="
                var fub = jQuery('div.$fieldClassName', target);
                var messages = jQuery('div.messages',  target);
                var emptyImage='".$emptyImage."';

                var statusDiv=jQuery('div.clonnable-field-status', messages.parent().parent().parent());
                var button=jQuery('div.upload-button', messages);
                var buttonTitle=jQuery('div.upload-button div.button-title', messages);
                var fileId=jQuery('input.clonnable-file-id', messages);
                var fileUrl=jQuery('input.clonnable-file-url', messages);
                var previewImg = jQuery('img.uploaded-preview', messages);
                var progressBar=jQuery('div.progress div.bar', messages);

                var deleteCallback = function(id)
                {
                    jQuery.ajax
                    (
                        {
                            'dataType':'json',
                            'type':'post',
                            'data':{'".Yii::app()->request->csrfTokenName."':'".Yii::app()->request->csrfToken."', 'image_object_id':id},
                            'url':'".$deleteAction."',
                            'cache':false,
                            'beforeSend':function()
                            {
                                jQuery('a.delete-image-link', messages).css('display','none');
                                jQuery('a.delete-image-wait', messages).css('display','');
                                jQuery('div.uploadError', statusDiv).remove();
                            },
                            'success':function(data,status)
                            {
                                if(data.success)
                                {
                                    fileUrl.val('');
                                    fileId.val('');
                                    previewImg.attr('src', emptyImage);
                                    button.css('display','');
                                }
                                else
                                {
                                    jQuery('a.delete-image-link', messages).css('display','');
                                    statusDiv.append('<div class=\"uploadError errorMessage\">'+ data.error + '</div>');
                                }
                                jQuery('a.delete-image-wait', messages).css('display','none');
                            },
                            'error':function()
                            {
                                jQuery('a.delete-image-link', messages).css('display','');
                                jQuery('a.delete-image-wait', messages).css('display','none');

                                statusDiv.append('<div class=\"uploadError errorMessage\">".Yii::t("ClonnableFields.templateFineUploaderField","File deleting error")."</div>');
                            },
                            'complete':function(jqXHR, textStatus)
                            {
                            }
                        }
                    );
                }

                if (fileId.val()>0)
                {
                    jQuery('a.delete-image-link', messages).click(function()
                    {
                        deleteCallback(fileId.val());
                        return false;
                    });
                }

                var uploader = new qq.FileUploaderBasic({
                    button: fub[0],
                    multiple: false,
                    action: '".$action."',
                    params: {'".Yii::app()->request->csrfTokenName."':'".Yii::app()->request->csrfToken."'},
                    debug: $debug,
                    allowedExtensions: $allowedExtensions,
                    sizeLimit: $sizeLimit,
                    minSizeLimit: $minSizeLimit,
                    acceptFiles:$acceptFiles,
                    onSubmit: function(id, fileName)
                    {
                        button.addClass('disabled');

                        jQuery('a.delete-image-link', messages).css('display','none');
                        jQuery('a.delete-image-wait', messages).css('display','none');
                        jQuery('a.delete-image-link', messages).off('click');

                        previewImg.attr('src', emptyImage);
						fileUrl.val('');
                        fileId.val('');
                        progressBar.css('display','');
                        progressBar.css('width','0%');
                        jQuery('div.uploadError', statusDiv).remove();
                    },
                    onUpload: function(id, fileName)
                    {
                        buttonTitle.html('<img src=\"".$loading."\" alt=\"".Yii::t("ClonnableFields.templateFineUploaderField","Initializing. Please hold.")."\"> ' + '".Yii::t("ClonnableFields.templateFineUploaderField","Initializing")."');
                    },
                    onProgress: function(id, fileName, loaded, total)
                    {
                        if (loaded < total)
                        {
                            var progress = Math.round(loaded / total * 100);
                            progressBar.css('width',progress+'%');
                            buttonTitle.html('<img src=\"".$loading."\" alt=\"".Yii::t("ClonnableFields.templateFineUploaderField","In progress. Please hold.")."\"> ' + '".Yii::t("ClonnableFields.templateFineUploaderField","Uploading...")."');
                        }
                        else
                        {
                            buttonTitle.html('<img src=\"".$loading."\" alt=\"".Yii::t("ClonnableFields.templateFineUploaderField","Saving. Please hold.")."\"> ' + '".Yii::t("ClonnableFields.templateFineUploaderField","Saving...")."');
                            progressBar.css('width','100%');
                        }
                    },
                    onComplete: function(id, fileName, responseJSON)
                    {
                        buttonTitle.html('<i class=\"icon-upload\"></i> ".Yii::t("ClonnableFields.templateFineUploaderField","Upload")."');

                        if (responseJSON.success)
                        {
                            button.css('display','none');
                            jQuery('a.delete-image-link', messages).css('display','');

                            jQuery('a.delete-image-link', messages).off('click');
                            jQuery('a.delete-image-link', messages).click(function()
                            {
                                deleteCallback(responseJSON.id);
                                return false;
                            });

                            previewImg.attr('src', responseJSON.preview);
							fileUrl.val(responseJSON.preview);
                            fileId.val(responseJSON.id);
                        }
                        else
                        {
                            statusDiv.append('<div class=\"uploadError errorMessage\">' + responseJSON.error+'</div>');
							fileUrl.val('');
                            fileId.val('');
                        }

                        button.removeClass('disabled');
                        progressBar.css('display','none');
                    },
                    messages:
                    {
                        typeError: '".Yii::t("ClonnableFields.templateFineUploaderField","{file} has an invalid extension. Valid extension(s): {extensions}.")."',
                        sizeError: '".Yii::t("ClonnableFields.templateFineUploaderField","{file} is too large, maximum file size is {sizeLimit}.")."',
                        minSizeError: '".Yii::t("ClonnableFields.templateFineUploaderField","{file} is too small, minimum file size is {minSizeLimit}.")."',
                        emptyError: '".Yii::t("ClonnableFields.templateFineUploaderField","{file} is empty, please select files again without it.")."',
                        noFilesError: '".Yii::t("ClonnableFields.templateFineUploaderField","No files to upload.")."',
                        onLeave: '".Yii::t("ClonnableFields.templateFineUploaderField","The files are being uploaded, if you leave now the upload will be cancelled.")."'
                    }
                });
            ";
            return $js;
        }

        public function beforeRemoveRowCustomAction($fieldName='', $fieldClassName='', $data='', $params='')
        {
            $deleteAction = isset($params['deleteAction'])?$params['deleteAction']:'';
            $js="
                var messages = jQuery('div.messages',  target);
                var fileId=jQuery('input.clonnable-file-id', messages);

                var deleteCallback = function(id)
                {
                    jQuery.ajax
                    (
                        {
                            'dataType':'json',
                            'type':'post',
                            'data':{'".Yii::app()->request->csrfTokenName."':'".Yii::app()->request->csrfToken."', 'image_object_id':id},
                            'url':'".$deleteAction."',
                            'cache':false,
                        }
                    );
                }

                if (fileId.val()!=='')
                {
                    deleteCallback(fileId.val());
                }
            ";
            return $js;
        }

        public function registerAssets()
        {
            $cs=Yii::app()->clientScript;
            //$cs->registerScript(__CLASS__, $js, CClientScript::POS_READY);

            $assetPath=Yii::app()->assetManager->getPublishedUrl(dirname(dirname(__FILE__)).'/assets/');
            $cs->registerScriptFile($assetPath.'/templateFineUploaderField/fileuploader.js',CClientScript::POS_END);
            $cs->registerCssFile($assetPath.'/templateFineUploaderField/fileuploader.css');

            parent::registerAssets();
        }
    }