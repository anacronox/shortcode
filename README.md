# Shortcode
A text shortcode  parser inspired from wordpress

# Basic usage of ShortCode class

```php
<?php
require_once 'shortcode.class.php';


/**
 * a simple test function for short code
 *
 * @param $context the contexts separed by : for child context
 * @param false $params
 * @return string
 */
function myTestFunction($context, $params=false){

    $TContext = explode(':', $context);

    $out = "<span class='helloworld'>Hello world</span>";

    if(!empty($params) && is_array($params)){
        $TItems = array();
        foreach ($params as $key => $item){
            $TItems[] = $key.' : '.$item;
        }
        if(!empty($TItems)){
            $out.= ' / attributes : ';

            $out.= '<ul><li>'.implode('</li><li>', $TItems).'</li></ul>';
        }
    }

	  return $out;
}


$ShortCode = new ShortCode();

// a simple test
$this->addShortCode('myshortcode', 'myTestFunction');

// A text string with shortcode
$text = 'Lorem ipsum dolor sit amet, [myshortcode tag01="tag 01"  tag02="tag 02"  tag02="tag 02" ] consectetur adipiscing elit. Morbi nunc ex, interdum eget tincidunt nec, ornare laoreet dui. Lorem ipsum dolor sit amet, consectetur adipiscing elit.'

$newText = $ShortCode->doShortCode($post->content);
echo $newText;
```
