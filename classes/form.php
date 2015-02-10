<?php

class SKELETON_CLASS_Form extends Form
{
    public function __construct( $name ) 
    {
        parent::__construct($name);
        
        $language = OW::getLanguage();
        
        
        //Simple text field
        $textField = new TextField("text");
        $textField->setLabel($language->text("skeleton", "forms_text_field_label"));
        $textField->setDescription($language->text("skeleton", "forms_text_field_description"));
        $textField->setHasInvitation(true);
        $textField->setRequired();
        
        $this->addElement($textField);
        
        //Extended text field
        $textareaField = new Textarea("extended_text");
        $textareaField->setLabel($language->text("skeleton", "forms_textarea_field_label"));
        $textareaField->setHasInvitation(true);
        $textareaField->setInvitation($language->text("skeleton", "forms_textarea_field_invitation"));
        $textareaValidator = new StringValidator(1, 200);
        $textareaField->addValidator($textareaValidator);
        
        $this->addElement($textareaField);
        
        //Selectbox field
        $selectField = new Selectbox("selectbox");
        $selectField->setLabel($language->text("skeleton", "forms_selectbox_field_label"));
        $selectField->setInvitation('Select any');

        $selectField->setOptions(array(
            "1" => "Red",
            "2" => "Blue"
        ));
        
        $this->addElement($selectField);
        
        //Multiple choice field
        $multiChoiceField = new CheckboxGroup("multichoice");
        $multiChoiceField->setLabel($language->text("skeleton", "forms_multichoice_field_label"));
        $multiChoiceField->setOptions(array(
            "1" => "New York",
            "2" => "Boston",
            "3" => "Chicago"
        ));
        
        $multiChoiceField->setColumnCount(2);
        
        $this->addElement($multiChoiceField);

        /**
         * View more validators and form elements here /ow_core/form_element.php, /ow_core/validator.php
         */


        //File upload field
        $uploadField = new FileField("file");
        $uploadField->setLabel($language->text("skeleton", "forms_file_field_label"));
        $this->addElement($uploadField);

        //Hidden Field
        $hiddenField = new HiddenField("hidden");
        $hiddenField->setValue("Hidden Value");
        $this->addElement($hiddenField);


        //Submit field
        $submit = new Submit("submit");
        $submit->setLabel($language->text("skeleton", "forms_submit_field_label"));
        
        $this->addElement($submit);
    }
}