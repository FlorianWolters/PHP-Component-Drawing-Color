<?php
namespace FlorianWolters\Component\Drawing\Color;

use FlorianWolters\Component\Core\DebugPrintInterface;
use FlorianWolters\Component\Core\EqualityInterface;
use FlorianWolters\Component\Core\ImmutableInterface;

/**
 * The interface {@see ColorInterface} indicates that an implementing class
 * implements a color model.
 *
 * @author    Florian Wolters <wolters.fl@gmail.com>
 * @copyright 2013 Florian Wolters
 * @license   http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @link      http://github.com/FlorianWolters/PHP-Component-Drawing-Color
 * @since     File available since Release 0.1.0
 */
interface ColorInterface extends
    DebugPrintInterface,
    EqualityInterface,
    ImmutableInterface
{
    /**
     * Returns a {@see CmykColor} representing this color.
     *
     * The value is converted to the color space *CMYK*.
     *
     * @return CmykColor A {@link CmykColor} representation of this color.
     */
    public function asCmykColor();

    /**
     * Returns a {@see RgbaColor} representing this color.
     *
     * The value is converted to the color space *RGB(A)*.
     *
     * @return RgbaColor A {@link RgbaColor} representation of this color.
     */
    public function asRgbaColor();

    /**
     * Converts this color to an array.
     *
     * @return mixed[] An associative `array` with the component names as the
     *                 `array` keys and their values as the `array` values.
     */
    public function toArray();

    /**
     * Converts this color to a HTML string.
     *
     * @return string The HTML `string` representation of this color.
     */
    public function toHtmlString();

    /**
     * Converts this color to a CSS string.
     *
     * @return string The CSS `string` representation of this color.
     */
    public function toCssString();

    /**
     * Converts this color to a 24-bit *RGB* value.
     *
     * @return integer The 24-bit *RGB* value of this color.
     */
    public function toRgbValue();
}
