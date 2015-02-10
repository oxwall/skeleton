<?php

class SKELETON_CTRL_FileStorage extends SKELETON_CLASS_ActionController
{

    public function index()
    {
        $language = OW::getLanguage();

        OW::getDocument()->setTitle($language->text("skeleton", "file_storage_page_title"));
        OW::getDocument()->setHeading($language->text("skeleton", "file_storage_page_heading"));

        //Creating image upload form
        $fileStorageForm = new Form('FileStorageExampleForm');
        $fileStorageForm->setEnctype(Form::ENCTYPE_MULTYPART_FORMDATA);

        $image = new FileField('image');
        $image->setLabel($language->text('skeleton', 'upload_image'));

        $fileStorageForm->addElement($image);

        $description = new Textarea('description');
        $description->setLabel($language->text('skeleton', 'short_description'));
        $description->setHasInvitation(true);
        $description->setInvitation($language->text('skeleton', 'describe_your_image'));

        $fileStorageForm->addElement($description);

        $submitButton = new Submit('submit');
        $submitButton->setValue($language->text('skeleton', 'submit_image'));

        $fileStorageForm->addElement($submitButton);

        $this->addForm($fileStorageForm);

        $showForm = true;

        //Processing form data after submit
        if ( OW::getRequest()->isPost() && $fileStorageForm->isValid($_POST) )
        {
            //Checking file upload and validating image extension
            if ( (int) $_FILES['image']['error'] !== 0 || !is_uploaded_file($_FILES['image']['tmp_name']) || !UTIL_File::validateImage($_FILES['image']['name']) )
            {
                $imageValid = false;
                OW::getFeedback()->error($language->text('base', 'not_valid_image'));
            }
            else
            {
                $imageValid = true;
            }

            $data = $fileStorageForm->getValues();

            if ( $imageValid )
            {
                $showForm = false;

                //get configured file storage (Cloud files or file system drive, depends on settings in config file)
                $storage = OW::getStorage();

                $imagesDir = OW::getPluginManager()->getPlugin('skeleton')->getUserFilesDir();
                $imageName = 'file_storage_'.md5($_FILES['image']['name']).'.jpg';
                $imagePath = $imagesDir . $imageName;

                if ( $storage->fileExists($imagePath) )
                {
                    $storage->removeFile($imagePath);
                }

                $pluginfilesDir = Ow::getPluginManager()->getPlugin('skeleton')->getPluginFilesDir();
                $tmpImgPath = $pluginfilesDir . 'file_storage_' .uniqid() . '.jpg';

                $image = new UTIL_Image($_FILES['image']['tmp_name']);
                $image->resizeImage(500, null)->saveImage($tmpImgPath);

                unlink($_FILES['image']['tmp_name']);

                //Copy file into storage folder
                $storage->copyFile($tmpImgPath, $imagePath);

                unlink($tmpImgPath);

                $imagesUrl = OW::getPluginManager()->getPlugin('skeleton')->getUserFilesUrl();

                $this->assign('description', $data['description']);
                $this->assign('imageUrl', $imagesUrl . $imageName);
                $this->assign('backUrl', OW::getRouter()->urlForRoute('skeleton-file-storage'));

            }

        }

        $this->assign('showForm', $showForm);
    }

}