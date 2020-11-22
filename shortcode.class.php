<?php



class ShortCode
{

    public $shortCodeManifest = array();

    function __construct(){

        // a simple test
        $this->addShortCode('shortcodetest', 'ShortCode::shortcodetest');
    }

    /**
     * @param string $name the shorcode name
     * @param callback $callback
     * @param array $dependency an array of files needed for inclusion
     */
    function addShortCode($name, callable $callback, $dependency = array())
    {
        // TODO : check name, $callback and $dependency are valid
        // TODO : for perfomances check is callable in doShortCode

        $shortCode = new stdClass();
        $shortCode->name = $name;
        $shortCode->callback = $callback;

        if(!is_array($dependency)){
            $shortCode->dependency = array($dependency);
        }
        else{
            $shortCode->dependency = $dependency;
        }

        $this->shortCodeManifest[$name] = $shortCode;
    }

    /**
     * parse a string to apply shortcodes
     *
     * @param $string
     * @param string $context the context of execution of shortcode, usefull to display diferent king of output according to context
     * @return string|string[]|null
     */
    function doShortCode($string, $context = 'default'){
        return preg_replace_callback('#\[(.*?)\]#', function ($matches) {
            $whitespace_explode = explode(" ", $matches[1]);
            $fnName = array_shift($whitespace_explode);
            if(isset($this->shortCodeManifest[$fnName])){
                $attribs = preg_replace("/^(\w+\s)/", "", $matches[1]);
                $attributes = false;
                try {
                    $x = new SimpleXMLElement('<element '.$attribs.' />');
                    foreach ($x->attributes() as $attr_key => $attr_value){
                        $attributes[$attr_key] = (string) $attr_value;
                    }
                } catch (Exception $e) {
                    //echo 'Exception reçue : ',  $e->getMessage(), "\n";
                }
                $shortCode = $this->shortCodeManifest[$fnName];

                if(!empty($shortCode->dependency)){
                    foreach ($shortCode->dependency as $dependency){
                        require_once $dependency;
                    }
                }

                if(is_callable($shortCode->callback)){
                    // TODO find a way to pass $context from doShortCode()
                    $context = 'default';
                    return call_user_func($shortCode->callback, $context, $attributes);
                }
            }

            return $matches[0];
        }, $string);
    }

    /**
     * a simple test for short code
     *
     * @param $context the contexts separed by : for child context
     * @param false $params
     * @return string
     */
    static function shortcodetest($context, $params=false){

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
}

