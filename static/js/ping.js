$(document).ready(function(){
    $('#skeleton_start_ping').click(function(){

        var counterOldValue = 0;

        //Adding command into the ping queue
        OW.getPing().addCommand('skeleton_ping', {
            params: {},
            before: function()
            {
                this.params.counterOldValue = counterOldValue;

            },
            after: function( data )
            {
                counterOldValue = data.counterNewValue;
                $('#skeleton_ping_counter').html(data.counterNewValue);
            }
        }).start(1000); // Time interval in milliseconds

    });

})
