--------------------
friendlyThumbOf 1.1.0 - Beta1
--------------------

First Released: December 17th, 2012
Author: Zaenal Muttaqin @lokamaya.com
License: GNU GPLv2 (or later at your option)

GitHub: https://github.com/lokamaya/friendlyThumbOf

This extra is companion for phpThumbOf made by Shaun McCormick. This will generate
friendly url for thumbnail image and use mod_rewrite to parse the url.

Sample mod_rewrite for .htaccess can be found in .ht.access file under doc directory.

Standard Use
------------
Default mode: friendlythumbof.imagemode_thumb = 'w=90&h=120'
- [[friendlyThumbOf? &input=`media/logo.jpg`]]
- [[*mygallery:friendlyThumbOf=`mode=thumb&context=web`]]


For CMP
------------
Get base thumbnail url (without image) for further use
- [[friendlyThumbOf? &context=`web` mode=`thumb` &base=`1`]]
or using runSnippet
- $baseThumb = $modx->runSnippet('friendlyThumbOf',array('context'=>'web', 'mode'=>'thumb', 'base'=>1));
Output http://mydomain.com/image/web/thumb (without trailing slash)


Questions or bugs?  visit https://github.com/lokamaya/friendlyThumbOf

Thank you
Zaenal
