jQuery(document).ready(function () {
    mam_utm_save_cookies();

    function mam_utm_save_cookies() {
        const mam_utm_referral = mamGetReferral();

        // Save utm_source
        let user_utm_source = mamGetParameterByName('utm_source');
        if (user_utm_source) {
            Cookies.set('user_utm_source', user_utm_source);
        }

        // if the cookie is not set then generate automated cookie
        if (!Cookies.get('user_utm_source')) {
            if (mam_utm_referral !== '') {
                Cookies.set('user_utm_source', 'Referral');
            } else {
                Cookies.set('user_utm_source', 'Direct');
            }
        }

        // Save utm_medium
        let user_utm_medium = mamGetParameterByName('utm_medium');
        if (user_utm_medium) {
            Cookies.set('user_utm_medium', user_utm_medium);
        }

        // if the cookie is not set then generate automated cookie
        if (!Cookies.get('user_utm_medium')) {
            if (mam_utm_referral !== '') {
                Cookies.set('user_utm_medium', mam_utm_referral);
            } else {
                Cookies.set('user_utm_medium', '-');
            }
        }

        // Save utm_campaign
        let user_utm_campaign = mamGetParameterByName('utm_campaign');
        if (user_utm_campaign) {
            Cookies.set('user_utm_campaign', user_utm_campaign);
        }

        // if the cookie is not set then generate automated cookie
        if (!Cookies.get('user_utm_campaign')) {
            Cookies.set('user_utm_campaign', '-');
        }
    }

    function mamGetReferral() {
        if (!document.referrer) {
            return '';
        } else {
            // mam_utm.current_domain is coming from wp_localize_script
            if (document.referrer.includes(mam_utm.site_url)) {
                return '';
            }
            return document.referrer;
        }
    }


    function mamGetParameterByName(name) {
        const url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        const regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }

});