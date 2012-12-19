#A friendlyThumbOf#
###Friendly url for phpThumbOf (MODx Revo)###
---------------------------------------------

Generate friendly url for thumbnail image and use *mod_rewrite* to parse the url. This extra depend on [phpThumbOf](https://github.com/splittingred/phpThumbOf) for rendering the thumbnail, but will do fine to generate url only. That's the main different with phpThumbOf. When using friendlyThumbOf, the thumbnail will be rendered *later* if there is a 'real' request to the server.

---------------------------------------------

####Features####
* Enable/disable friendly feature
* Modify the url prefix (by default "image")
* Enable/disable to append __context__ to url, like `http://mydomain.com/image/contextKey/anyMode/image.jpg`
* Add, modify and delete any __mode__ as you wish from System Events. By default, there are 4 modes provided: *default* `mw950`, *thumb* `w90&h120`, *medium* `w=300&h=400`, and *large* `w=900&h=1200`
* Sample mod_rewrite with 4 advanced scenarios can be found on doc *core/components/friendlythumbof/doc/ht.access*
* TO DO: Plugin for cleaning up the cache

---------------------------------------------
####Usage####
Call the snippet from resource or chunk:
```tpl
[[friendlyThumbOf? &input=`media/logo.jpg` &mode=`thumb`]] 
/* will generate a url like http://mydomain.com/image/thumb/media/logo.jpg */
[[friendlyThumbOf? &input=`path/to/my/image.jpg` &mode=`anotherMode`]] 
/* will generate a url like http://mydomain.com/image/anotherMode/path/to/my/image.jpg */
```

For CMP, like gallery or image browser, the snippet also can be used to display the thumbail. For example:
```javascript
<script type="text/javascript">
var thumbUrl = "[[friendlyThumbOf? &mode=`thumb` &base=`1`]]";
//will generate http://mydomain.com/image/thumb (without trailing slash)
var imgGallery = ['gallery/photo1.jpg','gallery/photo2.jpg'];
Ext.each(imgGallery, function(img){
  document.write('<img src="' + thumbUrl + '/' + img + '" />');
});
//...
```

Another example is using __runSnippet__ to get the base thumbnail url:
```php
<?php
$thumbUrl = $modx->runSnippet('friendlyThumbOf', array('mode'=>'anotherThumb', 'base'=>1));
/* will generate http://mydomain.com/image/anotherThumb (without trailing slash) */
$imgGallery = array('gallery/photo1.jpg','gallery/photo2.jpg');
foreach($imgGallery as $img) {
  echo '<img src="' . $thumbUrl . '/' . $img . '" />';
}
//...
```
