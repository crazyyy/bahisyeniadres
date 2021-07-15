(function ($) {
    $(document).ready(function ($) {


        $('input[data-input-type]').on('input change', function () {
            var val = $(this).val();
            $(this).next('.root-customizer-range-val').html(val);
            $(this).val(val);
        });


    })
})(jQuery);