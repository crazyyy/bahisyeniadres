jQuery(function($) {
    "use strict";


    /********************************************************************
     * The Designer Hover
     *******************************************************************/
    $('.js-the-designer-b').live({
        mouseenter: function () {

            var $this = $(this);
            $this.find( '.the-designer-t' ).show();

        },
        mouseleave: function () {

            var $this = $(this);
            $this.find( '.the-designer-t' ).hide();

        }
    });


    /********************************************************************
     * Clone
     */
    $('.js-the-designer-clone').live('click', function () {
        console.log('clone');
        var $this = $(this);
        var $the_designer_b = $this.parents('.js-the-designer-b');

        var clone = $the_designer_b.clone();
        clone.find('.the-designer-t').hide();
        console.log(clone);
        $the_designer_b.after( clone );
    });


    /********************************************************************
     * Remove
     */
    $('.js-the-designer-remove').live( 'click', function() {

        if ( ! confirm('Удалить?') ) return false;

        var $this = $(this);
        var $the_designer_b = $this.parents('.js-the-designer-b');

        $the_designer_b.slideUp( 150, function(){ jQuery(this).remove(); } )
    });


    /********************************************************************
     * Settings
     */
    $('.js-the-designer-settings').live( 'click', function() {

        $('.js-the-designer-m').html('Настройки блока');

        $('.js-the-designer-o').show();
        $('.js-the-designer-m').show();
    });

    $('.js-the-designer-o').on('click', function(){
        $('.js-the-designer-o').hide();
        $('.js-the-designer-m').hide();
    });


    /********************************************************************
     * Add
     *******************************************************************/
    $('.js-the-designer-add').on('click', function () {

        $('.js-the-designer-m').html( $('.js-the-designer-add-blocks').html() );

        $('.js-the-designer-o').show();
        $('.js-the-designer-m').show();
    });



    /********************************************************************
     * Sortable
     *******************************************************************/
    $('.js-the-designer-l').sortable({
        handle: ".js-the-designer-move",
        stop: function (event, ui) {
            var new_order = jQuery(this).sortable('serialize');
            console.log(new_order);
            console.log(jQuery(this).sortable('toArray').toString());
        },
        //connectWith: ".column",
        //cancel: ".portlet-toggle",
        //placeholder: "the-designer-placeholder"
    });

});