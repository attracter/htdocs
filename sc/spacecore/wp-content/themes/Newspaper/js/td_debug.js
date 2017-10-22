/**
 * Created by ra on 10/7/2014.
 */


var td_debug = {

    td_debug_visible: false,

    /**
     * replaces the log
     * @param msg
     */
    log_live: function log_live(msg) {
        td_debug._show_debug_window();
        jQuery('#td_debug').html(msg);
    },


    /**
     * @todo log with history not implemented yet
     */
    log : function log() {
        td_debug._show_debug_window();

    },


    _show_debug_window: function _show_debug_window() {
        if (td_debug.td_debug_visible === false) {
            td_debug.td_debug_visible = true;
            jQuery('body').append('<div id="td_debug" style="position: fixed; bottom: 0; left:0; width:200px; height:50px; background-color: black; color: white; z-index: 99999; padding: 5px; font-size:11px;"></div>');
        }

    }
};


