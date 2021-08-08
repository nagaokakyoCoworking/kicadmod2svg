<?php

namespace Hk\KicadmodParser\Geometry;

use Hk\KicadmodParser\Geometry\BoundingBox;

/**
 * ドキュメントのサイズ
 */
class DocumentSize
{
    /**
     * 幅
     * @var int
     */
    protected $width;

    /**
     * 高さ
     * @var int
     */
    protected $height;

    /**
     * 単位
     * @var string
     */
    protected $unit = 'mm';

    /**
     * コンストラクタ
     *
     * @param int $width 幅
     * @param int $height 高さ
     */
    public function __construct($width=0,$height=0,$unit = 'mm')
    {
        $this->width = $width;
        $this->height= $height;
        $this->unit = $unit;
    }

    /**
     * 幅 を単位付きで取得する
     * @return string
     */
    public function getWidthWithUnit():string
    {
        return '' . $this->width . $this->unit;
    }

    /**
     * 高さ を単位付きで取得する
     * @return string
     */
    public function getHeightWithUnit():string
    {
        return '' . $this->height . $this->unit;
    }

    /**
     * ドキュメントの中心の X 座標
     * @return int
     */
    public function getCenterX():int
    {
        return ($this->width / 2);
    }

    /**
     * ドキュメントの中心の Y 座標
     * @return int
     */
    public function getCenterY():int
    {
        return ($this->height / 2);
    }

    /**
     * 単位 を設定する
     * @param string $unit
     */
    public function setUnit($unit): void
    {
        $this->unit = $unit;
    }

    /**
     * SVG フォーマット用の文字列を取得する
     * @return string
     */
    public function getStringForSvg():string
    {
        return '' . $this->width . ',' . $this->height;
    }

    /**
     * バウンディングボックス を取得する
     * @return BoundingBox
     */
    public function getBoudingBox():BoundingBox
    {
        return new BoundingBox(0,0,$this->width,$this->height);
    }
}