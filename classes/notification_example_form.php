<?php

class SKELETON_CLASS_NotificationExampleForm extends Form
{
    public function __construct()
    {
        parent::__construct('NotificationExampleForm');

        $language = OW::getLanguage();

        //Simple text field
        $content = new TextField("content");
        $content->setLabel($language->text("skeleton", "notification_content"));
        $content->setHasInvitation(true);
        $content->setInvitation($language->text("skeleton", "notification_content_invitation"));
        $content->setRequired();
        
        $this->addElement($content);

        //File upload field
        $image = new ImageField("image");
        $image->setLabel($language->text("skeleton", "notification_attach_image"));
        $image->addValidator(new ImageValidator());
        $this->addElement($image);

        //Send button
        $send = new Submit("send");
        $send->setValue($language->text("skeleton", "send"));

        //$this->setAjax();
        $this->setEnctype(Form::ENCTYPE_MULTYPART_FORMDATA);

        $this->addElement($send);
    }

    public function process()
    {
        $data = $this->getValues();

        $userId = OW::getUser()->getId();

        $avatars = BOL_AvatarService::getInstance()->getAvatarsUrlList(array($userId));
        $userUrls = BOL_UserService::getInstance()->getUserUrlsForList(array($userId));

        $notificationParams = array(
            'pluginKey' => 'skeleton',
            'action' => 'example',
            'entityType' => 'skeleton-example',
            'entityId' => OW::getUser()->getId(),
            'userId' => OW::getUser()->getId(),
            'time' => time()
        );

        /**
         * avatar - is an image of the user or entity that initiated notification
         * url - is an URL to the entity that initiated notification
         * string - language key with variables or text of the notification
         */
        $notificationData = array(
            'string' => array(
                'key' => 'skeleton+notify_example',
                'vars' => array(
                    'content' => $data['content']
                )
            ),
            'avatar' => $avatars[$userId],
            'url' => $userUrls[$userId]
        );

        if (isset($_FILES['image']['error']) && $_FILES['image']['error'] == UPLOAD_ERR_OK)
        {
            //get configured file storage (Cloud files or file system drive, depends on settings in config file)
            $storage = OW::getStorage();

            $imagesDir = OW::getPluginManager()->getPlugin('skeleton')->getUserFilesDir();
            $imagePath = $imagesDir . $_FILES['image']['name'];

            if ( $storage->fileExists($imagePath) )
            {
                $storage->removeFile($imagePath);
            }

            $pluginfilesDir = Ow::getPluginManager()->getPlugin('skeleton')->getPluginFilesDir();
            $tmpImgPath = $pluginfilesDir . 'notification_' .uniqid() . '.jpg';

            $image = new UTIL_Image($_FILES['image']['tmp_name']);
            $image->resizeImage(200, null)->saveImage($tmpImgPath);

            unlink($_FILES['image']['tmp_name']);

            //Copy file into storage folder
            $storage->copyFile($tmpImgPath, $imagePath);

            unlink($tmpImgPath);

            $imagesUrl = OW::getPluginManager()->getPlugin('skeleton')->getUserFilesUrl();

            $notificationData['contentImage'] = $imagesUrl . $_FILES['image']['name'];
        }

        //Adding notification on action
        $event = new OW_Event('notifications.add', $notificationParams, $notificationData);
        OW::getEventManager()->trigger($event);
        $this->reset();

        OW::getFeedback()->info(OW::getLanguage()->text("skeleton", "notification_has_been_added"));
    }
}

class ImageField extends FileField
{

    public function getValue()
    {
        return empty($_FILES[$this->getName()]['tmp_name']) ? null : $_FILES[$this->getName()];
    }
}

class ImageValidator extends OW_Validator
{

    public function __construct()
    {

    }

    /**
     * @see OW_Validator::isValid()
     *
     * @param mixed $value
     */
    public function isValid( $value )
    {
        if ( empty($value) )
        {
            return true;
        }

        $realName = $value['name'];
        $tmpName = $value['tmp_name'];

        switch ( false )
        {
            case is_uploaded_file($tmpName):
                $this->setErrorMessage(OW::getLanguage()->text('base', 'upload_file_fail'));
                return false;

            case UTIL_File::validateImage($realName):
                $this->setErrorMessage(OW::getLanguage()->text('skeleton', 'errors_image_invalid'));
                return false;
        }

        return true;
    }
}