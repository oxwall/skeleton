<?php

class SKELETON_CTRL_Widgets extends SKELETON_CLASS_ActionController
{

    public function index()
    {
        $language = OW::getLanguage();

        OW::getDocument()->setTitle($language->text("skeleton", "widgets_page_title"));
        OW::getDocument()->setHeading($language->text("skeleton", "widgets_page_heading"));

        //$component = new BASE_CMP_UserListWidget();
        //$this->addComponent('component', $component);

        $widgetExampleForm = new Form('WidgetExampleForm');

        $place = new Selectbox('place');
        $place->setLabel($language->text('skeleton', 'place_widget_on_page'));

        $options = array(
            BOL_ComponentAdminService::PLACE_PROFILE => 'User Profile',
            BOL_ComponentAdminService::PLACE_DASHBOARD => 'User Dashboard',
            BOL_ComponentAdminService::PLACE_INDEX => 'Index Page'
        );
        $place->setOptions($options);
        $place->setRequired();

        $widgetExampleForm->addElement($place);

        $section = new Selectbox('section');
        $section->setLabel($language->text('skeleton', 'place_widget_in_section'));

        $options = array(
            BOL_ComponentAdminService::SECTION_LEFT => 'Left',
            BOL_ComponentAdminService::SECTION_TOP => 'Top',
            BOL_ComponentAdminService::SECTION_RIGHT => 'Right',
            BOL_ComponentAdminService::SECTION_BOTTOM => 'Bottom',
            BOL_ComponentAdminService::SECTION_SIDEBAR => 'Sidebar'
        );
        $section->setOptions($options);
        $section->setRequired();

        $widgetExampleForm->addElement($section);


        $addButton = new Submit('add');
        $addButton->setValue(OW::getLanguage()->text('skeleton', 'add'));
        $widgetExampleForm->addElement($addButton);

        $this->addForm($widgetExampleForm);


        //Processing form data after submit
        if ( OW::getRequest()->isPost() && $widgetExampleForm->isValid($_POST) )
        {
            $data = $widgetExampleForm->getValues();

            $widget = BOL_ComponentAdminService::getInstance()->addWidget('BASE_CMP_UserListWidget', false);

            $placeWidget = BOL_ComponentAdminService::getInstance()->addWidgetToPlace($widget, $data['place']);

            BOL_ComponentAdminService::getInstance()->addWidgetToPosition($placeWidget, $data['section'], 0 );
        }

        $addedComponentList = $this->getAddedComponentList(BOL_ComponentAdminService::PLACE_PROFILE);
        $addedComponentList = array_merge($addedComponentList, $this->getAddedComponentList(BOL_ComponentAdminService::PLACE_DASHBOARD));
        $addedComponentList = array_merge($addedComponentList, $this->getAddedComponentList(BOL_ComponentAdminService::PLACE_INDEX));

        $this->assign('addedComponentList', $addedComponentList);
    }

    public function delete($params)
    {
        $componentPlace = BOL_ComponentPlaceDao::getInstance()->findById($params['id']);

        BOL_ComponentAdminService::getInstance()->deleteWidgetPlace($componentPlace->uniqName);

        $this->redirect( OW::getRouter()->urlForRoute('skeleton-widgets') );
    }

    private function getAddedComponentList($place)
    {
        $places = array(
            BOL_ComponentAdminService::PLACE_PROFILE => 'User Profile',
            BOL_ComponentAdminService::PLACE_DASHBOARD => 'User Dashboard',
            BOL_ComponentAdminService::PLACE_INDEX => 'Index Page'
        );
        $addedComponentList = array();

        $placeComponentList = BOL_ComponentAdminService::getInstance()->findPlaceComponentList($place);

        foreach($placeComponentList as $component)
        {
            if ($component['className'] == 'BASE_CMP_UserListWidget')
            {
                $place = BOL_ComponentAdminService::getInstance()->findPlaceComponent($component['uniqName']);

                $addedComponentList[$component['id']] = array(
                    'place'=>$places[BOL_PlaceDao::getInstance()->findById($place->placeId)->name],
                    'deleteUrl'=>OW::getRouter()->urlForRoute('skeleton-widgets-delete', array('id'=>$component['id']))
                );
            }
        }

        return $addedComponentList;
    }
}