<?php

class SKELETON_CTRL_Notifications extends SKELETON_CLASS_ActionController
{

    public function index()
    {
        $language = OW::getLanguage();
        
        OW::getDocument()->setTitle($language->text("skeleton", "notifications_page_title"));
        OW::getDocument()->setHeading($language->text("skeleton", "notifications_page_heading"));

        $notificationExampleForm = new SKELETON_CLASS_NotificationExampleForm();

        $this->addForm($notificationExampleForm);

        //Processing form data after submit
        if ( OW::getRequest()->isPost() && $notificationExampleForm->isValid($_POST) )
        {
            $notificationExampleForm->process();
        }
    }

}