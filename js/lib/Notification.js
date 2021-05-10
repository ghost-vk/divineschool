/**
 * Class Notification used for showing
 * response to user after some action
 */
class Notification {
    /**
     * Constructor
     * @param el { HTMLElement }
     * @param data {
     *   text: 'notification text',
     *   icon: 'FA icon tag',
     *   linkUrl: 'http://some/url' - no required
     *   linkTitle: 'Link title' - no required
     * }
     */
    constructor(el, data) {
        this.text = data.text;
        this.type = data.type;
        this.el = el;
    }

    /**
     * Method initialize notification window
     * @param timeout { 7000 }
     * @public
     */
    init(timeout = 7000) {
        let template = this._createTemplate();
        this.el.innerHTML = template;
        this._show();

        setTimeout(this.destroy.bind(this), timeout);
    }

    /**
     * Method hides notification wrapper
     * Destroy inner content
     * @public
     */
    destroy() {
        this.el.classList.remove("notification-active");
        if (this.type === "loader") {
            this.el.classList.remove('notification-loader');
        }
        this.el.innerHTML = "";
    }

    /**
     * Method set new value of notification
     * @param options
     */
    setOption(options) {
        this.text = options.text;
        this.type = options.type;
    }

    /**
     * Method show notification window
     * @private
     */
    _show() {
        if (this.type === "loader") {
            this.el.classList.add('notification-loader');
        }
        this.el.classList.add('notification-active');
    }

    /**
     * Method creates notification body
     * @return {string}
     * @private
     */
    _createTemplate() {
        let template;
        console.log(this.text);
        template = `
            <div class="notification__row notification__row-center">`;
        if (this.type === "text-content") {
            template += `
                <p class="text-center">
                    ${this.text}
                </p>
            `;
        } else if (this.type==="loader") {
            template += `
                <div class="notification__loader">
                    <div class="lds-dual-ring"></div>
                </div>
            `;
        }
        template += `</div>`;

        return template;
    }
}