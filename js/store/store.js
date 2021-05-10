/**
 * Object for state management
 */
const store = {
    /**
     * App state
     */
    _state: {
        general: {
            nonce: Utils.getLocalizeData('appSettings', 'nonce'),
            ajaxUrl: Utils.getLocalizeData('appSettings', 'url'),
            userAccountURL: Utils.getLocalizeData("appSettings", "userAccountURL"),
            notificationContainer: document.getElementById("notification"),
        },
        homepage: {
            countdownTime: Utils.getLocalizeData('countdownTimer', 'timeTo')
        }
    },


    /**
     * Method returns state
     * @param branch { String } Object value key
     * @return {}
     */
    getState (branch = null) {
        if (branch === null) {
            return this._state;
        }
        return this._state[branch];
    }
}