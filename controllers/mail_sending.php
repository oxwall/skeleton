<?php

class SKELETON_CTRL_MailSending extends SKELETON_CLASS_ActionController
{
    public function index()
    {
        $language = OW::getLanguage();
        
        OW::getDocument()->setTitle($language->text("skeleton", "mail_sending_page_title"));
        OW::getDocument()->setHeading($language->text("skeleton", "mail_sending_page_heading"));

        //Creating mail sending form
        $mailSendingExampleForm = new Form('MailSendingExampleForm');

        $from = new TextField('from');
        //Set email validation for input field
        $from->addValidator(new EmailValidator());
        $from->setLabel($language->text("skeleton", "from"));
        $from->setHasInvitation(true);
        $from->setInvitation('youremail@example.com');
        $from->setRequired();

        $mailSendingExampleForm->addElement($from);

        $to = new TextField('to');
        $to->addValidator(new EmailValidator());
        $to->setLabel($language->text("skeleton", "to"));
        $to->setHasInvitation(true);
        $to->setInvitation('recepientemail@example.com');
        $to->setRequired();

        $mailSendingExampleForm->addElement($to);

        $subject = new TextField('subject');
        $subject->setLabel($language->text("skeleton", "subject"));
        $subject->setHasInvitation(true);
        $subject->setInvitation('enter email title');
        $subject->setRequired();

        $mailSendingExampleForm->addElement($subject);

        $body = new Textarea('body');
        $body->setLabel($language->text("skeleton", "body"));
        $body->setHasInvitation(true);
        $body->setInvitation('enter email body');
        $body->setRequired();

        $mailSendingExampleForm->addElement($body);

        $deliver = new RadioField('deliver');
        $deliverOptions = array('immediately'=>'Immediately', 'add_to_queue'=>'Add to Queue');
        $deliver->setOptions($deliverOptions);
        $deliver->setLabel($language->text("skeleton", "deliver"));
        $deliver->setRequired();

        $mailSendingExampleForm->addElement($deliver);

        $sendButton = new Submit('send');
        $sendButton->setValue($language->text("skeleton", "send"));

        $mailSendingExampleForm->addElement($sendButton);

        $this->addForm($mailSendingExampleForm);

        //Processing form data after submit
        if ( OW::getRequest()->isPost() && $mailSendingExampleForm->isValid($_POST) )
        {
            $data = $mailSendingExampleForm->getValues();

            $body = $data['body'];
            $bodyHtml = nl2br($body);

            //To send email as site administration use this config as sender email OW::getConfig()->getValue('base', 'site_email');

            $mail = OW::getMailer()->createMail();
            $mail->addRecipientEmail($data['to']);
            $mail->setReplyTo($data['from']);
            $mail->setSender($data['from'], 'Mail sender');
            $mail->setSubject($data['subject']);
            $mail->setHtmlContent($bodyHtml);
            $mail->setTextContent($body);

            switch($data['deliver'])
            {
                case 'immediately':

                    OW::getMailer()->send($mail);
                    OW::getFeedback()->info($language->text("skeleton", "your_message_was_sent_successfully"));
                    $this->redirect();

                    break;
                case 'add_to_queue':

                    OW::getMailer()->addToQueue($mail);
                    OW::getFeedback()->info($language->text("skeleton", "email_will_be_sent_when_cron_runs"));
                    $this->redirect();

                    break;
            }
        }
    }

}