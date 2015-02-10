<?php

class SKELETON_CMP_Floatbox extends OW_Component
{
    public function __construct($reload)
    {
        parent::__construct();

        if($reload)
        {
            $text = "Component has been reloaded via ajax";
        }
        else
        {
            $text = "This is a component";
        }

        $this->assign('text', $text);

        $js = '$("#reload_button").click(function(){

                OW.loadComponent("SKELETON_CMP_Floatbox", {reload: true},
                    {
                      onReady: function( html ){
                         $("#skeleton_floatbox_content").empty().html(html);

                      }
                    });
        });

        $("#close_button").click(function(){
            skeletonAjaxFloatBox.close()
        });
        ';

        OW::getDocument()->addOnloadScript($js);
    }


}
