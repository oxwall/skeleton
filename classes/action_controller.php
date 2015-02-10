<?php


class SKELETON_CLASS_ActionController extends OW_ActionController
{
    /**
    *
    * @var SKELETON_BOL_Service
    */
    protected $service;

    public function init()
    {
        $this->service = SKELETON_BOL_Service::getInstance();
        OW::getDocument()->addStyleSheet( OW::getPluginManager()->getPlugin('skeleton')->getStaticCssUrl().'skeleton.css' );

        OW::getNavigation()->activateMenuItem('main', 'skeleton', 'main_menu_item');

        if (!OW::getUser()->isAuthenticated())
        {
            $this->redirect(OW::getRouter()->urlForRoute('static_sign_in'));
        }
    }
}

