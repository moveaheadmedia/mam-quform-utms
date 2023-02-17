# MAM QUFORM UTMs

This is a WordPress plugin "Move Ahead Media UTM To Forms", developed by Move Ahead Media. 

The purpose of this plugin is to allow website owners to track the UTM values of users who submit forms. 

UTM values are used to track the effectiveness of marketing campaigns and traffic sources.

This plugin requires the jQuery library and Quform plugin to be installed and activated on the WordPress website. 

The form fields used to capture the UTM values must be labeled as "utm_source", "utm_medium", and "utm_campaign".

The plugin enqueues two JavaScript files, "js-cookie" and "mam_utm_forms", which are used to set and retrieve cookies for the UTM values. 

The plugin sets a cookie with the UTM values when a user first visits the website and then retrieves the values and populates the corresponding form fields when the user submits a form.

The "quform_pre_display" action is used to retrieve the form fields labeled as "utm_source", "utm_medium", and "utm_campaign", and populate their values with the corresponding UTM cookie values. 

The script is wrapped in a jQuery document ready function and window load event to ensure that the form fields are populated after the DOM has fully loaded.


**Installation and Configuration** 

- Download the latest release here https://github.com/moveaheadmedia/mam-quform-utms/releases
- Install and activate the plugin on your website
- Add the following hidden fields to your Quform forms, the labels must be  `utm_source`, `utm_medium` and `utm_campaign`.

That's it. the plugin will automatically populate those hidden fields with the UTMs data from the cookies before the users submit the forms.

**Changelog**

***1.4.1 (latest)***
- Fix Referral Not Tracked If The User Visited Direct Before

***1.4***
- Changed from using PHP to save and return cookies data to use only Javascript
- Fixed "Referral" users being tracked as "Direct"

***1.3***
- Changed from session to cookies
- Fixed Direct users not being tracked
