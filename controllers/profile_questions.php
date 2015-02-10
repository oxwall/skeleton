<?php

class SKELETON_CTRL_ProfileQuestions extends SKELETON_CLASS_ActionController
{

    public function index()
    {
        $language = OW::getLanguage();

        OW::getDocument()->setTitle($language->text("skeleton", "profile_questions_page_title"));
        OW::getDocument()->setHeading($language->text("skeleton", "profile_questions_page_heading"));

        $questionData = BOL_QuestionService::getInstance()->getQuestionData(array( OW::getUser()->getId() ), array( 'username', 'sex', 'birthdate' ));

        $profileQuestionsForm = new Form('ProfileQuestionsExampleForm');

        $username = new TextField('username');
        $username->setLabel(OW::getLanguage()->text('base', 'questions_question_username_label'));
        $username->setValue($questionData[OW::getUser()->getId()]['username']);

        $profileQuestionsForm->addElement($username);

        //

        $sex = new Selectbox('sex');
        $sex->setLabel(OW::getLanguage()->text('base', 'questions_question_sex_label'));
        $values = BOL_QuestionService::getInstance()->findQuestionsValuesByQuestionNameList(array('sex'));
        $valuesArray = array();

        foreach ( $values['sex']['values'] as $value )
        {
            $valuesArray[$value->value] = OW::getLanguage()->text( 'base', 'questions_question_' . $value->questionName . '_value_' . ($value->value) );
        }
        $sex->setOptions($valuesArray);

        $sex->setValue($questionData[OW::getUser()->getId()]['sex']);

        $profileQuestionsForm->addElement($sex);

        //

        $question = BOL_QuestionService::getInstance()->findQuestionByName('birthdate');
        $birthdate = BOL_QuestionService::getInstance()->getPresentationClass($question->presentation, 'birthdate', $question->custom);
        $birthdate->setLabel(OW::getLanguage()->text('base', 'questions_question_birthdate_label'));

        $date = UTIL_DateTime::parseDate($questionData[OW::getUser()->getId()]['birthdate'], UTIL_DateTime::MYSQL_DATETIME_DATE_FORMAT);

        if ( isset($date) )
        {
            $birthdate->setValue($date['year'] . '/' . $date['month'] . '/' . $date['day']);
        }

        $profileQuestionsForm->addElement($birthdate);

        $this->addForm($profileQuestionsForm);

        $saveButton = new Submit('save');
        $saveButton->setValue($language->text('skeleton', 'save'));

        $profileQuestionsForm->addElement($saveButton);

        $this->addForm($profileQuestionsForm);

        //Processing form data after submit
        if ( OW::getRequest()->isPost() && $profileQuestionsForm->isValid($_POST) )
        {
            $data = $profileQuestionsForm->getValues();

            $questionData = array(
                'username'=>$data['username'],
                'sex'=>$data['sex'],
                'birthdate'=>$data['birthdate']
            );

            BOL_QuestionService::getInstance()->saveQuestionsData($data, OW::getUser()->getId());

            OW::getFeedback()->info('Profile questions were updated');
            $this->redirect();
        }
    }
}