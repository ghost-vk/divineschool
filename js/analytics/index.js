/**
 * Facebook Pixel
 */
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '289404779547933');
fbq('track', 'PageView');


/**
 * Yandex.Metrika
 */
(function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
    m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
(window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

ym(80601841, "init", {
    clickmap:true,
    trackLinks:true,
    accurateTrackBounce:true
});

analytics = {
    settings: {
        yandexID: 80601841,
        runCounter: 0
    },
    send : function (eventName) {
        if (typeof ym === 'function') {
            ym(this.settings.yandexID, 'reachGoal', eventName);
        }
    },
    handleEvents : function () {
        /**
         * Handle prepayment events
         */
        var addToCartPrepaymentButtons = document.querySelectorAll('.addToCartPrepayment'),
            isPrepaymentClicked = false,
            onClick = function (e) {
                if (isPrepaymentClicked === true) {
                    return;
                }
                e.preventDefault();
                let packageIndex = e.target.getAttribute('data-package');
                this.send('add_to_cart_prepayment_' + packageIndex);
                isPrepaymentClicked = true;
                e.target.click();
            };
        for (var i = 0, max = addToCartPrepaymentButtons.length; i < max; i += 1) {
            addToCartPrepaymentButtons[i].addEventListener('click', onClick.bind(this));
        }
    },
    run : function () {
        if (typeof ym === 'undefined' && this.settings.runCounter < 8) {
            setTimeout(this.run, 500);
            this.settings.runCounter += 1;
        } else if (this.settings.runCounter < 8) {
            this.handleEvents();
        }
    }
};

analytics.run();