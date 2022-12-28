# MAM QUFORM UTMS
This is a WordPress plugin that is used to track UTMs (Urchin Tracking Module) on a website. UTMs are tags that are added to the end of a URL to identify the source, medium, and campaign of the traffic coming to a website.

This plugin saves the UTMs in cookies on the user's browser when they visit the website. If the UTMs are not present in the URL, the plugin sets the source to "Direct", and medium and campaign to "-".

The plugin then adds an action to the quform_pre_display hook, which is called when a form is displayed on the website. This action includes some JavaScript that makes an AJAX request to the server to retrieve the UTM values saved in the cookies. The retrieved UTM values are then used to populate hidden fields in the form with the corresponding label "utm_source", "utm_medium", and "utm_campaign".

The purpose of this plugin is to allow the website owner to track the UTM values of the users who submit the form, so they can understand where their traffic is coming from and how it is interacting with their website.

**Installation and Configuration** 

1- Go to https://github.com/moveaheadmedia/mam-quform-utms/releases
2- Download the latest release mam-quform-utms-1.3.zip
3- Install and activate the plugin on your website
4- Add the following hidden fields to your Quform form, the labels must be  `utm_source`, `utm_medium` and `utm_campaign`.

That's it. the plugin will automatically populate those hidden fields with the UTMs data from the users when they submit.

**Changelog v1.3**

- Changed from session to cookies
- Fixed Direct users not being tracked
