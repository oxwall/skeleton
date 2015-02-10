<?php

class SKELETON_CTRL_Newsfeed extends SKELETON_CLASS_ActionController
{

    public function index()
    {
        $language = OW::getLanguage();

        OW::getDocument()->setTitle($language->text("skeleton", "newsfeed_page_title"));
        OW::getDocument()->setHeading($language->text("skeleton", "newsfeed_page_heading"));

        $newsfeedForm = new Form('NewsfeedExampleForm');
        $newsfeedForm->setEnctype(Form::ENCTYPE_MULTYPART_FORMDATA);

        $content = new TextField('content');
        $content->setLabel($language->text('skeleton', 'item_content'));
        $content->setRequired();

        $newsfeedForm->addElement($content);

        $place = new Selectbox('place');
        $place->setLabel($language->text('skeleton', 'place_on'));

        $options = array(
            '4'=>'Dashboard Newsfeed', //NEWSFEED_BOL_Service::VISIBILITY_AUTHOR
            '1'=>'Index Newsfeed', //NEWSFEED_BOL_Service::VISIBILITY_SITE
            '8'=>'Profile Newsfeed' //NEWSFEED_BOL_Service::VISIBILITY_FEED
        );
        $place->setOptions($options);
        $place->setRequired();

        $newsfeedForm->addElement($place);

        $submitButton = new Submit('submit');
        $submitButton->setValue($language->text('skeleton', 'submit_entity'));

        $newsfeedForm->addElement($submitButton);

        $this->addForm($newsfeedForm);

        $this->assign('username', OW::getUser()->getUserObject()->getUsername());

        $avatarList = BOL_AvatarService::getInstance()->getDataForUserAvatars(array(OW::getUser()->getId()));
        $this->assign('avatar', $avatarList[OW::getUser()->getId()]);

        //Processing form data after submit
        if ( OW::getRequest()->isPost() && $newsfeedForm->isValid($_POST) )
        {
            $data = $newsfeedForm->getValues();

            $eventData = array(
                'time' => time(),
                'string' => $data['content'],
                'view' => array(
                    'iconClass' => 'ow_ic_add'
                )
            );

            $event = new OW_Event('feed.action', array(
                'pluginKey' => 'skeleton',
                'entityType' => 'skeleton_entity',
                'entityId' => OW::getUser()->getId(),
                'userId' => OW::getUser()->getId(),
                'visibility' => $data['place'],
            ), $eventData);
            OW::getEventManager()->trigger($event);

            OW::getFeedback()->info('You have successfully added newsfeed item to '.$options[$data['place']]);
        }
    }


}