<?php
namespace Hk\KicadmodParser;

class SpecctraParser
{
    /**
     *
     *
     * @param string $data
     * @return array
     */
    public static function parseAttrbiuteArray($data)
    {
        $cols = [];
        $isBranch = FALSE;
        $branchDepth = 0;
        $doubleQuote = FALSE;
        $value = '';
        $len = mb_strlen($data);
        for($i = 0 ; $i < $len ; $i++)
        {
            $needle = mb_substr($data,$i,1);
            if( $needle != ' ' || $isBranch === TRUE || $doubleQuote == TRUE )
            {
                $value .= $needle;
                if( $needle == '"' )
                {
                    if( $doubleQuote === FALSE )
                    {
                        $doubleQuote = TRUE;
                    }
                    else
                    {
                        $doubleQuote = FALSE;
                    }

                }
                if( $needle == '(' )
                {
                    $isBranch = TRUE;
                    $branchDepth++;
                }
                if( $needle == ')' )
                {
                    $branchDepth--;
                    if( $branchDepth == 0 )
                    {
                        $isBranch = FALSE;
                    }
                }
            }
            else
            {
                if($value != '')
                {
                    $cols[] = trim($value);
                    $value = '';
                    $isBranch = FALSE;
                }
            }
        }
        if($value != '')
        {
            $cols[] = trim($value);
        }
        return $cols;
    }


    /**
     *
     *
     * @param string $content
     * @return string
     */
    public static function parseAttributeValue($content)
    {
        if( preg_match('/^\(([\s\S"]*)\)$/',$content,$matches) === 1 )
        {
            $ret = $matches[1];
        }
        else
        {
            $ret = $content;
        }
        return $ret;
    }

}