<?php

class SKELETON_CTRL_Database extends SKELETON_CLASS_ActionController
{

    public function index()
    {
        $language = OW::getLanguage();
        
        OW::getDocument()->setTitle($language->text("skeleton", "database_page_title"));
        OW::getDocument()->setHeading($language->text("skeleton", "database_page_heading"));
        
        $form = new Form("database_form");
        
        //Simple text field
        $textField = new TextField("text");
        $textField->setLabel($language->text("skeleton", "forms_text_field_label"));
        $textField->setDescription($language->text("skeleton", "forms_text_field_description"));
        $textField->setHasInvitation(true);
        
        $textField->setRequired();
        
        $form->addElement($textField);
        
        //Extended text field
        $textareaField = new Textarea("extended_text");
        $textareaField->setLabel($language->text("skeleton", "forms_textarea_field_label"));
        $textareaField->setDescription($language->text("skeleton", "forms_textarea_field_description"));
        
        $textareaValidator = new StringValidator(1, 200);
        $textareaField->addValidator($textareaValidator);
        
        $form->addElement($textareaField);
        
        //Selectbox field
        $selectField = new Selectbox("selectbox");
        $selectField->setLabel($language->text("skeleton", "forms_selectbox_field_label"));
        $selectField->setDescription($language->text("skeleton", "forms_selectbox_field_description"));
        
        $selectField->setOptions(array(
            "1" => "Option 1",
            "2" => "Option 2",
            "3" => "Option 3",
            "4" => "Option 4"
        ));
        
        $form->addElement($selectField);
        
        //Submit field
        $submit = new Submit("submit");
        $submit->setLabel($language->text("skeleton", "forms_submit_field_label"));
        
        $form->addElement($submit);
        
        $service = SKELETON_BOL_Service::getInstance();
        
        if ( OW::getRequest()->isPost() && $form->isValid($_POST) )
        {
            $values = $form->getValues();
            $service->addRecord($values["text"], $values["extended_text"], $values["selectbox"]);
            
            OW::getFeedback()->info(OW::getLanguage()->text("skeleton", "database_record_saved_info"));
            
            $this->redirect();
        }
        
        $this->addForm($form);
        
        $list = $service->findList();
        $tplList = array();
        foreach ( $list as $listItem )
        {
            /* @var $listItem SKELETON_BOL_Record */
            $tplList[] = array(
                "text" => $listItem->text,
                "extendedText" => $listItem->extendedText,
                "choice" => $listItem->choice,
                "deleteUrl" => OW::getRouter()->urlForRoute('skeleton-database-delete-item', array('id'=>$listItem->getId()))
            );
        }
        
        $this->assign("list", $tplList);
    }

    public function deleteItem($params)
    {
        $this->service->deleteDatabaseRecord($params['id']);

        OW::getFeedback()->info(OW::getLanguage()->text('skeleton', 'database_record_deleted'));

        $this->redirect( OW::getRouter()->urlForRoute('skeleton-database') );
    }

}