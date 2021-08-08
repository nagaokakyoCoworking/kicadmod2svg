<?php
namespace Hk\KicadmodParser;

use Hk\KicadmodParser\Attributes\Attribute;
use Hk\KicadmodParser\Attributes\Items\Fp\FpLineAttribute;
use Hk\KicadmodParser\Attributes\Items\PadAttribute;
use Hk\KicadmodParser\Geometry\DocumentSize;
use Hk\KicadmodParser\Utils\SVGUtils;
use SVG\NodeRegistryTest;
use SVG\Nodes\Shapes\SVGCircle;
use SVG\Nodes\Shapes\SVGEllipse;
use SVG\Nodes\Shapes\SVGLine;
use SVG\Nodes\Shapes\SVGRect;
use SVG\Nodes\Structures\SVGGroup;

class SVGNodeFactory
{

    /**
     * @param Attribute $attributes
     * @param DocumentSize $size
     * @return SVGLine|null
     */
    public function getInstance(Attribute $attributes, DocumentSize $size)
    {
        $node = NULL;
        if( $attributes->getAttributeName() == FpLineAttribute::NODE_NAME )
        {
            $node = $this->getSVNLine($attributes,$size);
        }
        if( $attributes->getAttributeName() == PadAttribute::NODE_NAME )
        {
            /**
             * @var PadAttribute $pad
             */
            $pad = $attributes;
            if( $pad->getRenderingType() == PadAttribute::PAD_TYPE_RECTANGLE )
            {
                $node = new SVGGroup();
                $node->setAttribute('id','pad' . $pad->getIndex());
                $node->addChild($this->getSVGRect($attributes,$size));
                $node->addChild($this->getSVGCircle($attributes,$size));
            }
            if( $pad->getRenderingType() == PadAttribute::PAD_TYPE_OVAL )
            {
                $node = new SVGGroup();
                $node->setAttribute('id','pad' . $pad->getIndex());
                $node->addChild($this->getSVGEllipse($attributes,$size));
                $node->addChild($this->getSVGCircle($attributes,$size));
            }
        }
        return $node;
    }

    /**
     * @param PadAttribute $attribute
     * @param DocumentSize $size
     * @return SVGCircle
     */
    private static function getSVGCircle(PadAttribute $attribute,DocumentSize $size):SVGCircle
    {
        $point = $attribute->getCenterPoint();
        $boxSize = $attribute->getSize();
        $diameter = $attribute->getDrillSize();
        $node = new SVGCircle();
        if( $point !== NULL && $diameter > 0 )
        {
            $centerPoint = SVGUtils::mappingDocumentPoint($point,$size);
            $node->setCenterX($centerPoint->getX());
            $node->setCenterY($centerPoint->getY());
            $node->setRadius($diameter/2);
            $node->setStyle('fill','black');
        }
        return $node;
    }

    /**
     * @param PadAttribute $attribute
     * @param DocumentSize $size
     * @return SVGEllipse
     */
    private static function getSVGEllipse(PadAttribute $attribute,DocumentSize $size):SVGEllipse
    {
        $point = $attribute->getCenterPoint();
        $boxSize = $attribute->getSize();
        $node = new SVGEllipse();
        if( $point !== NULL && $boxSize !== NULL )
        {
            $centerPoint = SVGUtils::mappingDocumentPoint($point,$size);
            $node->setCenterX($centerPoint->getX());
            $node->setCenterY($centerPoint->getY());
            $node->setRadiusX($boxSize->getWidth()/2);
            $node->setRadiusY($boxSize->getHeight()/2);
            $node->setStyle('stroke-width',0);
            $layers = $attribute->getLayers();
            if( is_array($layers) === TRUE )
            {
                $values = [];
                foreach( $layers as $layerName )
                {
                    $values[] = implode(' ',SVGUtils::getMultiLayersForCss($layerName));
                }
                if( count($values) > 0 )
                {
                    $classValue = implode(' ',$values);
                    $node->setAttribute('class',$classValue);
                }
            }
        }
        return $node;
    }

    /**
     * @param PadAttribute $attribute
     * @param DocumentSize $size
     * @return SVGRect
     */
    private static function getSVGRect(PadAttribute $attribute,DocumentSize $size):SVGRect
    {
        $point = $attribute->getCenterPoint();
        $boxSize = $attribute->getSize();
        $node = new SVGRect();
        if( $point !== NULL && $boxSize !== NULL )
        {
            $boundingBox = $attribute->getBoundingBox();
            $startPoint = $boundingBox->getStartPoint();
            $startPoint = SVGUtils::mappingDocumentPoint($startPoint,$size);
            $node->setX($startPoint->getX());
            $node->setY($startPoint->getY());
            $node->setWidth($boxSize->getWidth());
            $node->setHeight($boxSize->getHeight());
            $node->setStyle('stroke-width',0);
            $layers = $attribute->getLayers();
            if( is_array($layers) === TRUE )
            {
                $values = [];
                foreach( $layers as $layerName )
                {
                    $values[] = $values[] = implode(' ',SVGUtils::getMultiLayersForCss($layerName));
                }
                if( count($values) > 0 )
                {
                    $classValue = implode(' ',$values);
                    $node->setAttribute('class',$classValue);
                }
            }
        }
        return $node;
    }

    /**
     * @param FpLineAttribute $attribute
     * @param DocumentSize $size
     * @return SVGLine
     */
    private static function getSVNLine(FpLineAttribute $attribute, DocumentSize $size): SVGLine
    {
        $layerName = $attribute->getLayerName();
        $startPoint = $attribute->getStartPoint();
        $endPoint = $attribute->getEndPoint();
        $strokeWidth = $attribute->getWidth();
        $node = new SVGLine();
        $point = SVGUtils::mappingDocumentPoint($startPoint,$size);
        $node->setX1($point->getX());
        $node->setY1($point->getY());
        $point = SVGUtils::mappingDocumentPoint($endPoint,$size);
        $node->setX2($point->getX());
        $node->setY2($point->getY());
        $node->setStyle('stroke-width',$strokeWidth);
        $node->setAttribute('class',SVGUtils::getLayerNameForCss($layerName));
        return $node;
    }
}