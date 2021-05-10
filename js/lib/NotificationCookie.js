/**
 * Module is responsible for show message about usage cookie
 */
(function () {
    let btn, block;
        block = document.querySelector("#cookieNotification");
        btn = document.querySelector("#agreeWithCookieBtn");

    if (Cookies.get('isCookieNotification') !== 'true') { // User is not notificated
        block.classList.add("cookieNotification-active");
    }

    btn.addEventListener("click", () => {
        let inWeek = new Date(new Date().getTime() + 7 * 24 * 60 * 60 * 1000);
        Cookies.set('isCookieNotification', 'true', { expires: inWeek });
        block.classList.remove("cookieNotification-active");
    });
})();