<?php
namespace Hk\KicadmodParser\Geometry;

/**
 * Size
 */
class Size
{
    /**
     * 幅
     * @var float
     */
    protected $width;

    /**
     * 高さ
     * @var float
     */
    protected $height;

    /**
     * コンストラクタ
     * @param int $width 幅
     * @param int $height 高さ
     */
    public function __construct($width = 0,$height = 0)
    {
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * 幅 をセットする
     * @param float $width
     */
    public function setWidth($width): void
    {
        $this->width = $width;
    }

    /**
     * 幅 を取得する
     * @return float
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * 高さ をセットする
     * @param float $height
     */
    public function setHeight($height): void
    {
        $this->height = $height;
    }

    /**
     * 高さ を取得する
     * @return float
     */
    public function getHeight()
    {
        return $this->height;
    }
}