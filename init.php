<?php

/**
 * Defined routes for plugin Skeleton
 */
OW::getRouter()->addRoute(new OW_Route('skeleton-index', 'skeleton', 'SKELETON_CTRL_Example', 'index'));

OW::getRouter()->addRoute(new OW_Route('skeleton-localization', 'skeleton/localization', 'SKELETON_CTRL_Localization', 'index'));
OW::getRouter()->addRoute(new OW_Route('skeleton-localization-delete-key', 'skeleton/localization/delete/:key', 'SKELETON_CTRL_Localization', 'deleteKey'));

OW::getRouter()->addRoute(new OW_Route('skeleton-routing', 'skeleton/routing', 'SKELETON_CTRL_Routing', 'index'));

OW::getRouter()->addRoute(new OW_Route('skeleton-forms', 'skeleton/forms', 'SKELETON_CTRL_Forms', 'index'));

OW::getRouter()->addRoute(new OW_Route('skeleton-database', 'skeleton/database', 'SKELETON_CTRL_Database', 'index'));
OW::getRouter()->addRoute(new OW_Route('skeleton-database-delete-item', 'skeleton/database/delete/:id', 'SKELETON_CTRL_Database', 'deleteItem'));

OW::getRouter()->addRoute(new OW_Route('skeleton-file-storage', 'skeleton/file-storage/', 'SKELETON_CTRL_FileStorage', 'index'));
OW::getRouter()->addRoute(new OW_Route('skeleton-file-storage-preview', 'skeleton/file-storage/preview', 'SKELETON_CTRL_FileStorage', 'preview'));

OW::getRouter()->addRoute(new OW_Route('skeleton-mail-sending', 'skeleton/mail-sending', 'SKELETON_CTRL_MailSending', 'index'));

OW::getRouter()->addRoute(new OW_Route('skeleton-notifications', 'skeleton/notifications', 'SKELETON_CTRL_Notifications', 'index'));

OW::getRouter()->addRoute(new OW_Route('skeleton-newsfeed', 'skeleton/newsfeed', 'SKELETON_CTRL_Newsfeed', 'index'));

OW::getRouter()->addRoute(new OW_Route('skeleton-floatbox', 'skeleton/floatbox', 'SKELETON_CTRL_Floatbox', 'index'));

OW::getRouter()->addRoute(new OW_Route('skeleton-widgets', 'skeleton/widgets', 'SKELETON_CTRL_Widgets', 'index'));
OW::getRouter()->addRoute(new OW_Route('skeleton-widgets-delete', 'skeleton/widgets/delete/:id', 'SKELETON_CTRL_Widgets', 'delete'));

OW::getRouter()->addRoute(new OW_Route('skeleton-profile_questions', 'skeleton/profile_questions', 'SKELETON_CTRL_ProfileQuestions', 'index'));

OW::getRouter()->addRoute(new OW_Route('skeleton-access_level', 'skeleton/access_level', 'SKELETON_CTRL_AccessLevel', 'index'));

OW::getRouter()->addRoute(new OW_Route('skeleton-cron', 'skeleton/cron', 'SKELETON_CTRL_Example', 'cron'));

OW::getRouter()->addRoute(new OW_Route('skeleton-ping', 'skeleton/ping', 'SKELETON_CTRL_Ping', 'index'));



/**
 * Adding example section to notifications settings page
 *
 * @param BASE_CLASS_EventCollector $e
 */
function skeleton_on_notify_actions( BASE_CLASS_EventCollector $e )
{
    $sectionLabel = OW::getLanguage()->text('skeleton', 'notification_section_label');

    $e->add(array(
        'section' => 'skeleton',
        'action' => 'example',
        'description' => OW::getLanguage()->text('skeleton', 'email_notifications_setting_example'),
        'selected' => true,
        'sectionLabel' => $sectionLabel,
        'sectionIcon' => 'ow_ic_clock'
    ));

}
OW::getEventManager()->bind('notifications.collect_actions', 'skeleton_on_notify_actions');

/**
 * Binding on event that collects entities to be sent by email.
 * Uncomment the function below to start receive notifications from skeleton plugin.
 *
 * This event depends on profiles' email notification settings
 * @param BASE_CLASS_EventCollector $event
 */
//function skeleton_console_send_list( BASE_CLASS_EventCollector $event )
//{
//    $params = $event->getParams();
//    $userIdList = $params['userIdList'];
//
//    foreach ( $userIdList as $id => $userId )
//    {
//        $avatars = BOL_AvatarService::getInstance()->getDataForUserAvatars(array( $userId ) );
//        $avatar = $avatars[$userId];
//
//        $event->add(array(
//            'pluginKey' => 'skeleton',
//            'entityType' => 'skeleton-example',
//            'entityId' => $userId,
//            'userId' => $userId,
//            'action' => 'example',
//            'time' => time(),
//
//            'data' => array(
//                'avatar' => $avatar,
//                'string' => OW::getLanguage()->text('skeleton', 'notify_example', array(
//                    'content' => 'qwerty')
//                )
//            )
//        ));
//    }
//}
//OW::getEventManager()->bind('notifications.send_list', 'skeleton_console_send_list');

/**
 * Binding on event that receives params from client and responds to it
 *
 * @param OW_Event $event
 */
function skeleton_ping( OW_Event $event )
{
    $eventParams = $event->getParams();
    $params = $eventParams['params'];

    if ($eventParams['command'] != 'skeleton_ping')
    {
        return;
    }

    $response = array();

    $counterOldValue = (int)$params['counterOldValue'];

    $response['counterNewValue'] = ++$counterOldValue;

    $event->setData($response);
}
OW::getEventManager()->bind('base.ping', 'skeleton_ping');

