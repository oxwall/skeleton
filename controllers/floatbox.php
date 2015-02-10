<?php

class SKELETON_CTRL_Floatbox extends SKELETON_CLASS_ActionController
{

    public function index()
    {
        $language = OW::getLanguage();

        OW::getDocument()->setTitle($language->text("skeleton", "floatbox_page_title"));
        OW::getDocument()->setHeading($language->text("skeleton", "floatbox_page_heading"));


        $script = "$('#skeleton_ajax_floatbox').click(function(){
            skeletonAjaxFloatBox = OW.ajaxFloatBox('SKELETON_CMP_Floatbox', {reload: false} , {width:380, iconClass: 'ow_ic_add', title: '".OW::getLanguage()->text('skeleton', 'floatbox_title')."'});
});


$('#skeleton_floatbox').click(function(){

            window.skeletonFloatBox = new OW_FloatBox({\$title:'".OW::getLanguage()->text('skeleton', 'floatbox_title')."', \$contents: $('#floatbox_content'), width: '550px'});
});
";
        OW::getDocument()->addOnloadScript($script);

    }
}