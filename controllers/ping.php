<?php

class SKELETON_CTRL_Ping extends SKELETON_CLASS_ActionController
{

    public function index()
    {
        $language = OW::getLanguage();

        OW::getDocument()->setTitle($language->text("skeleton", "ping_page_title"));
        OW::getDocument()->setHeading($language->text("skeleton", "ping_page_heading"));

        OW::getDocument()->addScript( OW::getPluginManager()->getPlugin('skeleton')->getStaticJsUrl().'ping.js' );
    }
}