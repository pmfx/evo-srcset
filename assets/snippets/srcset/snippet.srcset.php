<?php
/**
 * srcset
 * 
 * Simple img srcset generator snippet for Evolution CMS
 *
 * @version      1.0.1
 * @author       Piotr Matysiak (pmfx)
 * @category     snippet
 * @internal     @properties 
 * @internal     @modx_category Content
 * @internal     @installset base,sample
 * @lastupdate   06/03/2018
 * @link         https://github.com/pmfx/evo-srcset
 * @reportissues https://github.com/pmfx/evo-srcset/issues
 */

/*
 * example
 *
 * [[srcset? 
 * &input=`[*article_img*]` 
 * &sizes=`(min-width: 1200px) 1140px, 
 *         (min-width: 992px) 940px, 
 *         (min-width: 768px) 720px, 
 *         calc(100vw - 30px)` 
 * &srcset=`330,546,720,940,1140,1440,1880`
 * &defaultSize=`1140`
 * &quality=`80`
 * &attrAlt=`Image alt text`
 * &attrClass=`image-class`
 * &attrStyle=`display: inline-block`
 * &attrCustom=`data-test="success"`
 * ]]
*/

if(!defined('MODX_BASE_PATH')) {die('What are you doing? Get out of here!');}

/*
 * format sizes
 */

if (!empty($sizes)) {
  $sizes      = str_replace(array("\r\n", "\r"), "\n", $sizes);
  $sizesLines = explode("\n", $sizes);
  $sizesNew   = array();

  foreach ($sizesLines as $i => $sizesLine) {
    if(!empty($sizesLine)) {
      $sizesNew[] = trim($sizesLine);
    }
  }

  $sizes = implode($sizesNew);
}

/*
 * generate srcset images
 */

$quality = (empty($quality) ? '80' : $quality);

$srcset    = explode(",", $srcset);
$srcsetNew = array();

foreach ($srcset as $i => $srcsetItem) {

  // check if both dimensions are set
  
  $bothDimensions = strpos($srcsetItem, 'x');
  
  if ($bothDimensions !== false) {
    $dimensions = explode("x", $srcsetItem);
    $imgWidth   = $dimensions[0];
    $imgHeight  = $dimensions[1];
    $options    = 'w='.$imgWidth.',h='.$imgHeight.',zc=1,f=jpg,q='.$quality;
  }
  
  else {
    $imgWidth = $srcsetItem;
    $options  = 'w='.$imgWidth.',f=jpg,q='.$quality;
  }

  // last srcset item
  
  if ($srcsetItem === end($srcset)) {
    $src = $modx->runSnippet('phpthumb', [
      'input'   => $input,
      'options' => $options
    ]);
    $srcsetNew[] = $src.' '.$imgWidth.'w';
  } 
  
  else {
    $srcsetNew[] = $modx->runSnippet('phpthumb', [
      'input'   => $input,
      'options' => $options
    ]).' '.$imgWidth.'w,';
  }

}

$srcset = implode($srcsetNew);

/*
 * generate default image
 */

if (empty($defaultSize)) {
  $src = $src;
}

else {
  
  // check if both dimensions are set
  
  $bothDimensions = strpos($defaultSize, 'x');
  
  if ($bothDimensions !== false) {
    $dimensions = explode("x", $defaultSize);
    $imgWidth   = $dimensions[0];
    $imgHeight  = $dimensions[1];
    $src        = $modx->runSnippet('phpthumb', [
      'input'   => $input,
      'options' => 'w='.$imgWidth.',h='.$imgHeight.',zc=1,f=jpg,q='.$quality
    ]);
  }
  
  else {
    $imgWidth = $defaultSize;
    $src      = $modx->runSnippet('phpthumb', [
      'input'   => $input,
      'options' => 'w='.$imgWidth.',f=jpg,q='.$quality
    ]);
  }
}

/*
 * output
 */

$output  = '<img ';
$output .= (empty($sizes) ? '' : 'sizes="'. $sizes.'" ');
$output .= 'srcset="'.$srcset.'" ';
$output .= 'src="'.   $src.'" ';
$output .= (empty($attrClass) ? '' : 'class="'. $attrClass.'" ');
$output .= (empty($attrStyle) ? '' : 'style="'. $attrStyle.'" ');
$output .= 'alt="'.   $attrAlt.'" ';
$output .= $attrCustom;
$output .= '>';

return $output;
