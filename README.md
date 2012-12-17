#A friendlyThumbOf#
###Friendly url for phpThumbOf (MODx Revo)###
---------------------------------------------
Generate friendly url for thumbnail image and use mod_rewrite to parse the url. This extra depend on [phpThumbOf](https://github.com/splittingred/phpThumbOf) for rendering the thumbnail, but will do fine to generate url only. That the main different with phpThumbOf: the image thumbnail will be rendered when there is a 'real' request to the server.

####Usage####
Call the snippet from resource or chunk:
```tpl
[[friendlyThumbOf? &input=`media/logo.jpg` &mode=`thumb`]] 
//will generate a url like http://mydomain.com/image/thumb/media/logo.jpg
```


For CMP, like gallery or image browser, the snippet also can be used to display the image thumbail. For example:
```javascript
<script type="text/javascript">
var thumbUrl = "[[friendlyThumbOf? &mode=`thumb`]]";
//will generate http://mydomain.com/image/thumb (without trailing slash)
var imgGallery = ['gallery/photo1.jpg','gallery/photo2.jpg'];
Ext.each(imgGallery, function(img){
  document.write('<img src="' + thumbUrl + '/' + img + '" />');
});
</script>
```


Another example is using runSnippet to get the base thumbnail url:
```php
$thumbUrl = $modx->runSnippet('friendlyThumbOf', array('mode'=>'thumb', 'base'=>1));
/* will generate http://mydomain.com/image/thumb (without trailing slash) */
$imgGallery = array('gallery/photo1.jpg','gallery/photo2.jpg');
foreach($imgGallery as $img) {
  echo '<img src="' . $thumbUrl . '/' . $img . '" />';
}
```

