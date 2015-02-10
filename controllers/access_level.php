<?php

class SKELETON_CTRL_AccessLevel extends SKELETON_CLASS_ActionController
{

    public function index()
    {
        $language = OW::getLanguage();

        OW::getDocument()->setTitle($language->text("skeleton", "access_level_page_title"));
        OW::getDocument()->setHeading($language->text("skeleton", "access_level_page_heading"));


    }
}