<?php
namespace Hk\KicadmodParser;
/**
 * SPECCTRA DSN file format Parser
 *
 * @see https://en.wikipedia.org/wiki/Specctra
 * @see https://cdn.hackaday.io/files/1666717130852064/specctra.pdf
 * @see https://dev-docs.kicad.org/en/file-formats/sexpr-intro/index.html#_footprint
 */
class SpecctraParser
{
    /**
     * ( )
     *
     * @param string $textData
     * @return array
     */
    public static function parseTokens(string $textData): array
    {
        $cols = [];
        $isBranch = FALSE;
        $branchDepth = 0;
        $doubleQuote = FALSE;
        $value = '';
        $len = mb_strlen($textData);
        for($i = 0 ; $i < $len ; $i++)
        {
            $needle = mb_substr($textData,$i,1);
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
    public static function parseAttributeValue($content):string
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