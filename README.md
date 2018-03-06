# evo-srcset
Simple img srcset generator snippet for Evolution CMS

## Call

```
[[srcset? 
&input=`[*article_img*]` 
&sizes=`(min-width: 1200px) 1140px, 
        (min-width: 992px) 940px, 
        (min-width: 768px) 720px, 
        calc(100vw - 30px)` 
&srcset=`330,546,720,940,1140,1440,1880`
&defaultSize=`1140`
&quality=`80`
&attrAlt=`Image alt text`
&attrClass=`image-class`
&attrStyle=`display: inline-block`
&attrCustom=`data-test="success"`
]]
```

## Result

```
<img sizes="(min-width: 1200px) 1140px,
            (min-width: 992px) 940px,
            (min-width: 768px) 720px,
            calc(100vw - 30px)" 
srcset="assets/cache/images/150944-330x-70e.jpg 330w,
        assets/cache/images/150944-546x-b43.jpg 546w,
        assets/cache/images/150944-720x-33b.jpg 720w,
        assets/cache/images/150944-940x-70d.jpg 940w,
        assets/cache/images/150944-1140x-6d1.jpg 1140w,
        assets/cache/images/150944-1440x-e5d.jpg 1440w,
        assets/cache/images/150944-1880x-ef3.jpg 1880w" 
src="assets/cache/images/150944-1140x-6d1.jpg" 
class="image-class" 
style="display: inline-block" 
alt="Image alt text" 
data-test="success">
```

## Parameters

**input**

Image source.

**sizes**

CSS rules that specifies image sizes for different page layouts.

**srcset**

Dimensions separated by comma, eg. "360,720,1280". From smallest to largest. If you need to crop your image, use WxH eg. "360x200,720x400,1280x400".

**defaultSize** (optional) 

Size used for fallback in src="" attribute. If not used, last dimension from srcset is used.

**quality** (optional) 

Quality of generated JPG files. Default: 80.

**attrAlt** (optional) 

Value of alt="" attribute.

**attrClass** (optional) 

Value of class="" attribute.

**attrStyle** (optional) 

Value of style="" attribute.

**attrCustom** (optional) 

Any additional attributes you may need. Eg. data-test="success"

## Dependency

EVO phpthumb snippet.