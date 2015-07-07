Polytmus CMS
==========

Polytmus CMS is a small (around 55KB in size without plugins) very simple to setup CMS. 
No database, just upload the files to your web directory.

The index.php file generates and stores, fast to load, plain HTML files per page based on your settings.
Thumbnails are auto generated and CSS is minified.

After setting up your own password you have access to the settings.
To open CMS settings, click settings in the left top corner. To see the settings for evt plugins, click plugins.

No admin menu:
==========

Want the controls? You will need your own key instead of the default password. Go change your password. 
Log out. Go to the login page, and click cange password below the password input field.

Making a new page:
==========

Go to settings, click inside the menu text area to activate it. Place your cursor. Now type the name of the new page below or above the other(s). Next, click outside of the text area to deactivate the editor. Now you are ready to refresh the page with the refresh button at the top of settings, or press F5 on the keyboard. It is really that simple!
Click on your new entry in the menu to take you to your new page. You will be greeted by a page that contains the default plugin. You can go into the settings and add your choice of content blocks to the plugin order for the new page. Once done you can remove the default plugin from the plugin order of your new page.
Plugin order:

The installed plugins that are capable of generating content blocks are shown on the right side of the text area. To activate a plugin for the page you are currently on, click the left side of the text area, type the name of the plugin you want below or above evt other plugins. Click outside the text editing area and refresh the page.
Other settings:

Settings such as title are global on every page, where as description and keywords (used by search engines like Google) are per page.
There are no X in my Y:

If a plugin is telling you that there are no images or icons available to it, you can use the upload plugin to provide it with an image. Do note that the name of the image or icon is related to the text content. Renaming an existing image will result in you seeing a new empty text block. Though the file containing your text is not lost, it is simply not requested to show.

Upload plugin:
=====

This plugin will upload your full size images to the selected content block plugin, for the selected page. The content block plugins handle thumbnails ect.To fully benefit from the automated content generation of some of the galleries you should stick to the following naming convention for images.

XX--PROJECTNAME_-_THE_TITLE.ext

Example: 05--Landscapes_-_Lovely_snowy_mountains.jpg

Though this is not required for plugins that simply ask for one (or more) icons to add a text block to. Keep in mind the order of numbers and or alphabetical order.

Logo and background images:
==========

You can upload a different one for each page, but it is not required as they will fallback to the one set on home. The logo will take the place of the website title.
Not seeing all folders in FTP:

Log in on the website and refresh your FTP.

Non menu pages:
==========

Yes, you can have pages that are not in the main menu. You can make a menu entry, go to the page, add plugins and then remove it from the menu. Or add them to a submenu plugin and go to the page. Or type the name in the url bar of the browser to start working on it.