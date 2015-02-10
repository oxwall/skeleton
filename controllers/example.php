<?php

class SKELETON_CTRL_Example extends SKELETON_CLASS_ActionController
{

    public function index()
    {
        $language = OW::getLanguage();
        $router = OW::getRouter();

        OW::getDocument()->setTitle($language->text("skeleton", "index_page_title"));
        OW::getDocument()->setDescription($language->text("skeleton", "index_page_description"));
        OW::getDocument()->setHeading($language->text("skeleton", "index_page_heading"));
        
        $skeletonMenu = array();

        $skeletonMenu[] = array(
            "label" => $language->text("skeleton", "menu_item_file_structure"),
            "url" => $router->urlFor("SKELETON_CTRL_Example", "fileStructure")
        );

        $skeletonMenu[] = array(
            "label" => $language->text("skeleton", "menu_item_devtools"),
            "url" => $router->urlFor("SKELETON_CTRL_Example", "devtools")
        );

        $skeletonMenu[] = array(
            "label" => $language->text("skeleton", "menu_item_pluginxml"),
            "url" => $router->urlFor("SKELETON_CTRL_Example", "pluginxml")
        );

        $skeletonMenu[] = array(
            "label" => $language->text("skeleton", "menu_item_routing"),
            "url" => $router->urlForRoute("skeleton-routing")
        );

        $skeletonMenu[] = array(
            "label" => $language->text("skeleton", "menu_item_localization"),
            "url" => $router->urlForRoute("skeleton-localization")
        );

        $skeletonMenu[] = array(
            "label" => $language->text("skeleton", "menu_item_forms"),
            "url" => $router->urlForRoute("skeleton-forms")
        );
        
        $skeletonMenu[] = array(
            "label" => $language->text("skeleton", "menu_item_database"),
            "url" => $router->urlForRoute("skeleton-database")
        );
        
        $skeletonMenu[] = array(
            "label" => $language->text("skeleton", "menu_item_file_storage"),
            "url" => $router->urlForRoute("skeleton-file-storage")
        );
        
        $skeletonMenu[] = array(
            "label" => $language->text("skeleton", "menu_item_mail_sending"),
            "url" => $router->urlForRoute("skeleton-mail-sending")
        );
        
        $skeletonMenu[] = array(
            "label" => $language->text("skeleton", "menu_item_notifications"),
            "url" => $router->urlForRoute("skeleton-notifications")
        );
        
        $skeletonMenu[] = array(
            "label" => $language->text("skeleton", "menu_item_newsfeed"),
            "url" => $router->urlForRoute("skeleton-newsfeed")
        );

        $skeletonMenu[] = array(
            "label" => $language->text("skeleton", "menu_item_floatbox"),
            "url" => $router->urlForRoute("skeleton-floatbox")
        );

        $skeletonMenu[] = array(
            "label" => $language->text("skeleton", "menu_item_widgets"),
            "url" => $router->urlForRoute("skeleton-widgets")
        );

        $skeletonMenu[] = array(
            "label" => $language->text("skeleton", "menu_item_access_level"),
            "url" => $router->urlForRoute("skeleton-access_level")
        );

        $skeletonMenu[] = array(
            "label" => $language->text("skeleton", "menu_item_profile_questions"),
            "url" => $router->urlForRoute("skeleton-profile_questions")
        );

        $skeletonMenu[] = array(
            "label" => $language->text("skeleton", "menu_item_cron"),
            "url" => $router->urlForRoute("skeleton-cron")
        );

        $skeletonMenu[] = array(
            "label" => $language->text("skeleton", "menu_item_ping"),
            "url" => $router->urlForRoute("skeleton-ping")
        );

        $skeletonMenu[] = array(
            "label" => $language->text("skeleton", "menu_item_install"),
            "url" =>  $router->urlFor("SKELETON_CTRL_Example", "install")
        );

        $this->assign("menu", $skeletonMenu);
    }

    public function devtools()
    {
        $language = OW::getLanguage();

        OW::getDocument()->setTitle($language->text("skeleton", "devtools_page_title"));
        OW::getDocument()->setHeading($language->text("skeleton", "devtools_page_heading"));

        $this->assign('devtoolsUrl', OW_URL_HOME.'admin/dev-tools/languages');
    }

    public function pluginxml()
    {
        $language = OW::getLanguage();

        OW::getDocument()->setTitle($language->text("skeleton", "pluginxml_page_title"));
        OW::getDocument()->setHeading($language->text("skeleton", "pluginxml_page_heading"));
    }

    public function fileStructure()
    {
        $language = OW::getLanguage();

        OW::getDocument()->setTitle($language->text("skeleton", "file_structure_page_title"));
        OW::getDocument()->setHeading($language->text("skeleton", "file_structure_page_heading"));

        $this->assign('pluginxmlUrl', OW::getRouter()->urlFor("SKELETON_CTRL_Example", "pluginxml"));
        $this->assign('cronUrl', OW::getRouter()->urlFor("SKELETON_CTRL_Example", "cron"));
    }

    public function cron()
    {
        $language = OW::getLanguage();

        OW::getDocument()->setTitle($language->text("skeleton", "cron_page_title"));
        OW::getDocument()->setHeading($language->text("skeleton", "cron_page_heading"));

    }

    public function install()
    {
        $language = OW::getLanguage();

        OW::getDocument()->setTitle($language->text("skeleton", "install_page_title"));
        OW::getDocument()->setHeading($language->text("skeleton", "install_page_heading"));

    }

}