<?php
namespace Hk\KicadmodParser;

use Hk\KicadmodParser\Attributes\AttributesRegistry;
use Hk\KicadmodParser\Attributes\Items\DescriptionAttribute;
use Hk\KicadmodParser\Attributes\Items\Fp\FpLineAttribute;
use Hk\KicadmodParser\Geometry\BoundingBox;
use Hk\KicadmodParser\Geometry\DocumentSize;
use Hk\KicadmodParser\Geometry\Point;
use Hk\KicadmodParser\Utils\SVGUtils;
use SVG\Nodes\Shapes\SVGLine;
use SVG\Nodes\Structures\SVGGroup;
use SVG\Nodes\Structures\SVGStyle;
use SVG\SVG;

class KicadmodParser
{
    /**
     * 設定ファイル
     */
    const CONFIG_FILE = __DIR__ . '/config/config.ini';

    /**
     * 設定情報
     * @var array
     */
    private $config;

    /**
     * constructor.
     */
    public function __construct()
    {
        $this->config = parse_ini_file(self::CONFIG_FILE,true);
    }


    /**
     * SVG ドキュメントを取得する
     *
     * @param DocumentSize $documentSize
     * @param BoundingBox $viewBox
     * @return SVG
     */
    private function getSVGWriter(DocumentSize $documentSize, BoundingBox $viewBox)
    {
        $svg = new SVG($documentSize->getWidthWithUnit(), $documentSize->getHeightWithUnit());
        $doc = $svg->getDocument();
        if( isset( $this->config['other'] ) === TRUE )
        {
            if( isset( $this->config['other']['Color4DPCBBackground'] ) === TRUE )
            {
                if( $this->config['other']['Color4DPCBBackground'] != '' )
                {
                    $doc->setStyle('background',$this->config['other']['Color4DPCBBackground'] );
                }
            }
        }
        $doc->setAttribute('viewBox',$viewBox->getViewBox());
        if( isset( $this->config['layer_color'] ) === TRUE )
        {
            if( is_array($this->config['layer_color']) === TRUE )
            {
                $css = '';
                foreach($this->config['layer_color'] as $layerName => $color )
                {
                    $layerName = str_replace('Color4DPCBLayer_','',$layerName);
                    $value = '';
                    $value .= '.' . SVGUtils::getLayerNameForCss($layerName) . ' {';
                    $value .= 'stroke: ' . $color . ';';
                    $value .= 'fill: ' . $color . ';';
                    $value .= '}' . "\n";
                    $css .= $value;
                }
                $node = new SVGStyle($css);
                $doc->addChild($node);
            }
        }
        return $svg;
    }

    /**
     *
     *
     * @param string $content
     * @return string
     */
    public function parseContent(string $content):string
    {
        $factory = AttributesRegistry::getInstance();
        $svgFactory = new SVGNodeFactory();
        $data = $factory->parse($content);
        $layers = [];
        $attributes = $data->getAttributes();
        $boundingBox = new BoundingBox();
        $size = new DocumentSize();
        if( is_array($attributes) === TRUE  )
        {
            // 領域検索
            /**
             * @var FpLineAttribute $obj
             */
            foreach($attributes as $obj)
            {
                if( method_exists($obj,'getLayerName') === TRUE )
                {
                    $layerName = $obj->getLayerName();
                    if( isset($layers[$layerName]) === FALSE )
                    {
                        $layers[$layerName] = [];
                    }
                }
                if( $obj->hasBoundingBox() === TRUE )
                {
                    $_boundingBox = $obj->getBoundingBox();
                    $boundingBox->fittingRegion($_boundingBox->getStartPoint(),$_boundingBox->getEndPoint());
                }
            }
            // 描写領域からドキュメントのサイズを取得する
            $size = SVGUtils::getDocumentSize($boundingBox);
            /**
             * @var FpLineAttribute $obj
             */
            foreach($attributes as $obj)
            {
                $node = $svgFactory->getInstance($obj,$size);
                if( $node !== NULL )
                {
                    $layers[$layerName][] = $node;
                }
            }
        }
        //
        $viewBox = SVGUtils::getViewBox($boundingBox,$size);
        //
        $svg = $this->getSVGWriter($size,$viewBox);
        $doc = $svg->getDocument();

        $groupNode = new SVGGroup();
        $groupNode->setAttribute('id','symbol');
        foreach($layers as $layerName => $nodes )
        {
            foreach($nodes as $node)
            {
                $groupNode->addChild($node);
            }
        }
        $doc->addChild($groupNode);
        return $svg->toXMLString();
    }

    /**
     *
     *
     * @param string $fileName
     * @return bool
     */
    public function parseFile($fileName)
    {
        $ret = FALSE;
        if( file_exists($fileName) === TRUE )
        {
            $fp = fopen($fileName,'r');
            if( $fp !== FALSE )
            {
                $content = file_get_contents($fileName);
                $content = str_replace('\r\n','',$content);
                $content = str_replace('\r','',$content);
                $content = str_replace('\n','',$content);
                $ret = $this->parseContent($content);
                fclose( $fp );
            }
        }
        return $ret;
    }
}