# Shortcode
A text shortcode  parser inspired from wordpress

# Basic usage of ShortCode class

```php
<?php
require_once 'shortcode.class.php';

$ShortCode = new ShortCode();        

// a simple test
$this->addShortCode('shortcodetest', 'ShortCode::shortcodetest');

// A text string with shortcode
$text = 'Lorem ipsum dolor sit amet, [shortcodetest tag01="tag 01"  tag02="tag 02"  tag02="tag 02" ] consectetur adipiscing elit. Morbi nunc ex, interdum eget tincidunt nec, ornare laoreet dui. Lorem ipsum dolor sit amet, consectetur adipiscing elit.'

$newText = $ShortCode->doShortCode($post->content);
echo $newText;
```
