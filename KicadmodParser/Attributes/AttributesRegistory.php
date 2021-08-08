<?php
namespace Hk\KicadmodParser\Attributes;



use Hk\KicadmodParser\SpecctraParser;

class AttributesRegistory
{
    /**
     * @var AttributesRegistory
     */
    private static $singleton;

    /**
     * @var array
     */
    private $registories = [];

    /**
     * @return AttributesRegistory
     */
    public static function getInstance()
    {
        if( isset(self::$singleton) === FALSE )
        {
            self::$singleton = new AttributesRegistory();
        }
        return self::$singleton;
    }


    /**
     * コンストラクタ
     *
     */
    public function __construct()
    {
        $path = __DIR__ .DIRECTORY_SEPARATOR . 'Items';
        $this->registories = [];

        $allFiles = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
        $phpFiles = new \RegexIterator($allFiles, '/\.php$/');
        foreach ($phpFiles as $phpFile) {
            $content = file_get_contents($phpFile->getRealPath());
            $tokens = token_get_all($content);
            $namespace = '';
            for ($index = 0; isset($tokens[$index]); $index++)
            {
                if (isset($tokens[$index][0]) === FALSE)
                {
                    continue;
                }
                if (T_NAMESPACE === $tokens[$index][0])
                {
                    $index += 2; // Skip namespace keyword and whitespace
                    while (isset($tokens[$index]) === TRUE && is_array($tokens[$index]) === TRUE )
                    {
                        $namespace .= $tokens[$index++][1];
                    }
                }
                if (T_CLASS === $tokens[$index][0] && T_WHITESPACE === $tokens[$index + 1][0] && T_STRING === $tokens[$index + 2][0])
                {
                    $index += 2; // Skip class keyword and whitespace
                    $this->registories[] = $namespace.'\\'.$tokens[$index][1];
                    # break if you have one class per file (psr-4 compliant)
                    # otherwise you'll need to handle class constants (Foo::class)
                    break;
                }
            }
        }
    }


    /**
     *
     *
     * @param string $data
     * @return Attribute|null
     */
    public function getAttributes($data)
    {
        $attribute = NULL;
        $cols = SpecctraParser::parseAttrbiuteArray($data);
        if( is_array($cols) === TRUE && count($cols) > 0 )
        {
            $nodeName = $cols[0];
            $parameters = [];
            $size = count($cols);
            for($i=1;$i<$size;$i++)
            {
                $parameters[] = $cols[$i];
            }
            /**
             *
             * @var string $className
             */
            foreach( $this->registories as $className )
            {
                if( $nodeName == constant($className . '::NODE_NAME') )
                {
                    $attribute = new $className($parameters);
                }
            }
        }
        return $attribute;
    }


    /**
     * @param string $content
     * @return Attribute|null
     */
    public function parse($content)
    {
        $ret = NULL;
        $data = SpecctraParser::parseAttributeValue($content);
        if($data !== NULL)
        {
            $ret = $this->getAttributes($data);
        }
        return $ret;
    }


}