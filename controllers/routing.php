<?php

class SKELETON_CTRL_Routing extends SKELETON_CLASS_ActionController
{
    public function index($params)
    {
        $language = OW::getLanguage();

        OW::getDocument()->setTitle($language->text("skeleton", "routing_page_title"));
        OW::getDocument()->setHeading($language->text("skeleton", "routing_page_heading"));

    }

}