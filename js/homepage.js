(function ($) {
    $(document).ready(function () {

        let date = new Date(Number(countdown.timeTo) * 1000),
            fontSize, captionSize;

        if ( $('#counterMobile').length ) { // Mobile and PC versions
            fontSize = 28;
            captionSize = 12;
        } else {
            fontSize = 48;
            captionSize = 14;
        }

        $('#countdown').timeTo({
            timeTo: date,
            theme: "black",
            displayCaptions: true,
            fontSize: fontSize,
            captionSize: captionSize,
            lang: 'ru'
        });
    });
})(jQuery);