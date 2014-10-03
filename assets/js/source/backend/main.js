var CD_Theme_Backend;
(function ($) {
    CD_Theme_Backend = {
        init: function () {
            this.feature_icon_selector();
        },
        feature_icon_selector: function () {
            $('#cd-icon-data-icon').on('keyup change', function () {
                var value = $(this).val();

                $(this).closest('.inside').find('.icon').attr('class', 'icon icon-' + value );
            });
        }
    };

    $(function () {
        CD_Theme_Backend.init();
    });

})(jQuery);