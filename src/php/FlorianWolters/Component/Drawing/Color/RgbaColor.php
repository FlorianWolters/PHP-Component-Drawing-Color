<?php
namespace FlorianWolters\Component\Drawing\Color;

use \InvalidArgumentException;

use FlorianWolters\Component\Core\ValueObjectTrait;

/**
 * The class {@see RgbaColor} wraps the color model *RGB(A)* in an object.
 *
 * @author    Florian Wolters <wolters.fl@gmail.com>
 * @copyright 2013 Florian Wolters
 * @license   http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @link      http://github.com/FlorianWolters/PHP-Component-Drawing-Color
 * @since     File available since Release 0.1.0
 */
final class RgbaColor implements ColorInterface
{
    // @codingStandardsIgnoreStart
    use ValueObjectTrait
    {
        __construct as constructImmutable;
    }
    /// @codingStandardsIgnoreEnd

    /**
     * The red component of this {@see RgbaColor). Valid values are `0` through
     * `255`.
     *
     * @var integer
     */
    private $red;

    /**
     * The green component of this {@see RgbaColor). Valid values are `0`
     * through `255`.
     *
     * @var integer
     */
    private $green;

    /**
     * The blue component of this {@see RgbaColor). Valid values are `0` through
     * `255`.
     *
     * @var integer
     */
    private $blue;

    /**
     * The alpha component of this {@see RgbaColor). Valid values are `0`
     * through `255`.
     *
     * @var integer
     */
    private $alpha;

    /**
     * Creates a new {@see RgbaColor} from the specified HTML string color
     * representation.
     *
     * @param string $htmlColor The string that represents the HTML color.
     *
     * @return RgbaColor The {@see RgbaColor} that this method creates.
     * @throws InvalidArgumentException If `$htmlColor` is not a valid HTML
     *                                  color.
     */
    public static function createFromHtml($htmlColor)
    {
        $rgb = ColorUtils::htmlToRgbaComponents($htmlColor);

        return new self($rgb['R'], $rgb['G'], $rgb['B']);
    }

    /**
     * Creates a new {@see RgbaColor} from the specified 24-bit RGB value.
     *
     * @param integer $rgb The RGB value. Valid values are `0x000000` through
     *                     `0xffffff`.
     *
     * @return RgbaColor The {@see RgbaColor} that this method creates.
     * @throws InvalidArgumentException If `$rgb` is less than `0x000000` or
     *                                  greater than `0xffffff`.
     */
    public static function createFromValue($rgb)
    {
        $rgb = ColorUtils::rgbaValueToRgbaComponents($rgb);

        return new self($rgb['R'], $rgb['G'], $rgb['B']);
    }

    /**
     * Creates a new {@see RgbaColor} from the specified 8-bit RGBA components
     * (red, green, blue, and alpha).
     *
     * @param integer $red   The red component. Valid values are `0` through
     *                       `255`.
     * @param integer $green The green component. Valid values are `0` through
     *                       `255`.
     * @param integer $blue  The blue component. Valid values are `0` through
     *                       `255`.
     * @param integer $alpha The alpha component. Valid values are `0` through
     *                       `255`.
     *
     * @return RgbaColor The {@see RgbaColor} that this method creates.
     */
    public static function createFromComponents(
        $red,
        $green,
        $blue,
        $alpha = 0xFF
    ) {
        return new self($red, $green, $blue, $alpha);
    }

    /**
     * Constructs a new {@see RgbaColor} from the specified 8-bit RGB components
     * (red, green, blue, and alpha) values.
     *
     * @param integer $red   The red component. Valid values are `0` through
     *                       `255`.
     * @param integer $green The green component. Valid values are `0` through
     *                       `255`.
     * @param integer $blue  The blue component. Valid values are `0` through
     *                       `255`.
     * @param integer $alpha The alpha component. Valid values are `0` through
     *                       `255`.
     */
    private function __construct($red, $green, $blue, $alpha = 0xFF)
    {
        $this->constructImmutable();

        $this->setRed($red);
        $this->setGreen($green);
        $this->setBlue($blue);
        $this->setAlpha($alpha);
    }

    /**
     * Sets the red component of this {@see RgbaColor).
     *
     * @param integer $red The red component. Valid values are `0` through
     *                     `255`.
     *
     * @return void
     */
    private function setRed($red)
    {
        ColorUtils::throwExceptionIfNotRgbaComponent($red, 'red');
        $this->red = $red;
    }

    /**
     * Sets the green component of this {@see RgbaColor).
     *
     * @param integer $green The green component. Valid values are `0` through
     *                       `255`.
     *
     * @return void
     */
    private function setGreen($green)
    {
        ColorUtils::throwExceptionIfNotRgbaComponent($green, 'green');
        $this->green = $green;
    }

    /**
     * Sets the blue component of this {@see RgbaColor).
     *
     * @param integer $blue The blue component. Valid values are `0` through
     *                      `255`.
     *
     * @return void
     */
    private function setBlue($blue)
    {
        ColorUtils::throwExceptionIfNotRgbaComponent($blue, 'blue');
        $this->blue = $blue;
    }

    /**
     * Sets the alpha component of this {@see RgbaColor).
     *
     * @param integer $alpha The alpha component. Valid values are `0` through
     *                       `255`.
     *
     * @return void
     */
    private function setAlpha($alpha)
    {
        ColorUtils::throwExceptionIfNotRgbaComponent($alpha, 'alpha');
        $this->alpha = $alpha;
    }

    /**
     * Returns the red component of this {@see RgbaColor).
     *
     * @return integer The red component.
     */
    public function getRed()
    {
        return $this->red;
    }

    /**
     * Returns the green component of this {@see RgbaColor).
     *
     * @return integer The green component.
     */
    public function getGreen()
    {
        return $this->green;
    }

    /**
     * Returns the blue component of this {@see RgbaColor).
     *
     * @return integer The blue component.
     */
    public function getBlue()
    {
        return $this->blue;
    }

    /**
     * Returns the alpha component of this {@see RgbaColor).
     *
     * @return integer The alpha component.
     */
    public function getAlpha()
    {
        return $this->alpha;
    }

    // Implementation of the interface
    // ColorInterface

    /**
     * {@inheritdoc}
     */
    public function asCmykColor()
    {
        $cmyk = ColorUtils::rgbComponentsToCmykComponents(
            $this->red,
            $this->green,
            $this->blue
        );

        return CmykColor::createFromComponents(
            $cmyk['C'],
            $cmyk['M'],
            $cmyk['Y'],
            $cmyk['K']
        );
    }

    /**
     * {@inheritdoc}
     */
    public function asRgbaColor()
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return [
            'R' => $this->red,
            'G' => $this->green,
            'B' => $this->blue,
            'A' => $this->alpha
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function toHtmlString()
    {
        return ColorUtils::rgbaValueToHtml(
            ColorUtils::rgbComponentsToRgbValue(
                $this->red,
                $this->green,
                $this->blue
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function toCssString()
    {
        return 'rgba('
            . $this->red . ', '
            . $this->green . ', '
            . $this->blue . ', '
            . \round($this->alpha / 255, 2)
            . ')';
    }

    /**
     * {@inheritdoc}
     */
    public function toRgbValue()
    {
        return ColorUtils::rgbComponentsToRgbValue(
            $this->red,
            $this->green,
            $this->blue
        );
    }

    // Implementation of the interface
    // FlorianWolters\Component\Core\DebugPrintInterface

    /**
     * Converts this {@see RgbaColor} to a human-readable string.
     *
     * @return string A `string` that consists of the RGB(A) component names and
     *                their values.
     */
    public function __toString()
    {
        return 'RgbaColor [R=' . $this->red
            . ', G=' . $this->green
            . ', B=' . $this->blue
            . ', A=' . $this->alpha
            . ']';
    }
}
