<?php
namespace FlorianWolters\Component\Drawing\Color;

use \InvalidArgumentException;

/**
 * The class {@see ColorUtils} offers operations to translate color models.
 *
 * @author    Florian Wolters <wolters.fl@gmail.com>
 * @copyright 2013 Florian Wolters
 * @license   http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @link      http://github.com/FlorianWolters/PHP-Component-Drawing-Color
 * @since     File available since Release 0.1.0
 */
final class ColorUtils
{
    /**
     * Maps HTML color values to HTML color names.
     *
     * @var string[]
     * @link http://w3.org/TR/CSS21/syndata.html#value-def-color
     */
    private static $htmlHexStringToNameMap = [
        '#00ffff' => 'aqua',
        '#000000' => 'black',
        '#0000ff' => 'blue',
        '#ff00ff' => 'fuchsia',
        '#808080' => 'gray',
        '#008000' => 'green',
        '#00ff00' => 'lime',
        '#800000' => 'maroon',
        '#000080' => 'navy',
        '#808000' => 'olive',
        '#ffA500' => 'orange',
        '#800080' => 'purple',
        '#ff0000' => 'red',
        '#c0c0c0' => 'silver',
        '#008080' => 'teal',
        '#ffffff' => 'white',
        '#ffff00' => 'yellow'
    ];

    // @codeCoverageIgnoreStart

    /**
     * {@see ColorUtils} instances can **NOT** be constructed in standard
     * programming.
     *
     * Instead, the class should be used as:
     * /---code php
     * ColorUtils::rgbaValueToHtml(0xFF0000);
     * \---
     */
    protected function __construct()
    {
    }

    // @codeCoverageIgnoreEnd

    /**
     * Converts the specified *RGB(A)* color value to a HTML color
     * representation.
     *
     * @param integer $rgb The *RGB(A)* color value.
     *
     * @return string The string that represents the HTML color.
     * @throws InvalidArgumentException If `$rgb` is not a valid *RGB(A)* color
     *                                  value.
     */
    public static function rgbaValueToHtml($rgb)
    {
        self::throwExceptionIfNotRgbValue($rgb);

        return '#'
            . self::padRgbaComponent(self::rgbaValueToRedComponent($rgb))
            . self::padRgbaComponent(self::rgbaValueToGreenComponent($rgb))
            . self::padRgbaComponent(self::rgbaValueToBlueComponent($rgb));
    }

    /**
     * Checks whether the specified value is a valid ARGB value.
     *
     * @param integer $value The value to check.
     *
     * @return boolean `true` if `$value` is a valid ARGB value; `false`
     *                 otherwise.
     */
    public static function isValidRgbaValue($value)
    {
        return (-1 < $value) && (0xFFFFFFFF >= $value);
    }

    /**
     * Pads the specified *RGB(A)* component, if necessary.
     *
     * @param integer $int The *RGB(A)* component value.
     *
     * @return string The padded *RGB(A)* component.
     */
    private static function padRgbaComponent($component)
    {
        $result = \dechex($component);

        if (2 > \strlen($result)) {
            $result = '0' . $result;
        }

        return $result;
    }

    /**
     * Checks whether the specified value is a valid *CYMK* component value.
     *
     * @param integer $value The value to check.
     *
     * @return boolean `true` if `$value` is a valid *CYMK* component value;
     *                 `false` otherwise.
     */
    public static function isValidCmykComponent($value)
    {
        return (true === \is_int($value))
            && (-1 < $value)
            && (101 > $value);
    }

    /**
     * Checks whether the specified value is a valid *RGB(A)* value.
     *
     * @param integer $value The value to check.
     *
     * @return boolean `true` if `$value` is a valid *RGB(A)* value; `false`
     *                 otherwise.
     */
    public static function isValidRgbValue($value)
    {
        return (true === \is_int($value))
            && (-1 < $value)
            && (0xFFFFFF >= $value);
    }

    /**
     * Checks whether the specified value is a valid *RGB(A)* component value.
     *
     * @param integer $value The value to check.
     *
     * @return boolean `true` if `$value`is a valid *RGB(A)* component value;
     *                        `false` otherwise.
     */
    public static function isValidRgbaComponent($value)
    {
        return (true === \is_int($value))
            && (-1 < $value)
            && (256 > $value);
    }

    /**
     * Converts the specified HTML color to *CMYK* components.
     *
     * @param string $html The HTML color.
     *
     * @return mixed[] The *CMYK* components.
     * @throws InvalidArgumentException If `$htmlColor` is not a HTML color.
     */
    public static function htmlToCmykComponents($htmlColor)
    {
        return ColorUtils::rgbaValueToCmykComponents(
            ColorUtils::htmlToRgbaValue($htmlColor)
        );
    }

    /**
     * Converts the specified HTML color to a *RGB(A)* value.
     *
     * @param string $html The HTML color.
     *
     * @return integer The *RGB(A)* value.
     * @throws InvalidArgumentException If `$htmlColor` is not a HTML color.
     */
    public static function htmlToRgbaValue($htmlColor)
    {
        if (true === self::isValidHtmlName($htmlColor)) {
            $htmlColor = \array_search(
                $htmlColor,
                self::$htmlHexStringToNameMap
            );
        }

        self::throwExceptionIfNotHtmlValue($htmlColor);

        return \hexdec(\substr($htmlColor, 1));
    }

    /**
     * Converts the specified HTML color to *RGB(A)* components.
     *
     * @param string $html The HTML color.
     *
     * @return mixed[] The *RGB(A)* components.
     * @throws InvalidArgumentException If `$htmlColor` is not a HTML color.
     */
    public static function htmlToRgbaComponents($htmlColor)
    {
        return self::rgbaValueToRgbaComponents(self::htmlToRgbaValue($htmlColor));
    }

    /**
     * Checks whether the specified value is a valid CSS color.
     *
     * This method evaluates **both** CSS color names and CSS color values to
     * `true`.
     *
     * @param string $value The value to check.
     *
     * @return boolean `true` if `$value`is a valid CSS color; `false`
     *                        otherwise.
     */
    public static function isValidHtml($value)
    {
        return (true === self::isValidHtmlName($value))
            || (true === self::isValidHtmlValue($value));
    }

    /**
     * Checks whether the specified value is a valid CSS color name.
     *
     * This method evaluates **only** CSS color names to `true`.
     *
     * @param string $value The value to check.
     *
     * @return boolean `true` if `$value`is a valid CSS color name; `false`
     *                        otherwise.
     */
    public static function isValidHtmlName($value)
    {
        return (true === \in_array($value, self::$htmlHexStringToNameMap, true));
    }

    /**
     * Checks whether the specified value is a valid CSS color value.
     *
     *  This method evaluates **only** CSS color values to `true`.
     *
     * @param string $value The value to check.
     *
     * @return boolean `true` if `$value`is a valid CSS color value; `false`
     *                        otherwise.
     */
    public static function isValidHtmlValue($value)
    {
        return (true === \is_string($value))
            && (1 === \preg_match('/^#(?:[0-9a-f]{1,2}){3}$/i', $value));
    }

    /**
     * Retrieves the alpha component from the specified *RGBA* value.
     *
     * @param integer $rgba The **RGB(A)*)* value.
     *
     * @return integer The alpha component.
     * @throws InvalidArgumentException If `$rgba` is less than `0x00000000` or
     *                                  greater than `0xffffffff`.
     */
    public static function rgbaValueToAlphaComponent($rgba)
    {
        self::throwExceptionIfNotRgbaValue($rgba);

        return ($rgba >> 24) & 0xff;
    }

    /**
     * Retrieves the red component from the specified *RGB(A)* value.
     *
     * @param integer $argb The *RGB(A)* value.
     *
     * @return integer The red component.
     * @throws InvalidArgumentException If `$argb` is less than `0x00000000` or
     *                                  greater than `0xffffffff`.
     */
    public static function rgbaValueToRedComponent($argb)
    {
        self::throwExceptionIfNotRgbaValue($argb);
        return ($argb >> 16) & 255;
    }

    /**
     * Retrieves the green component from the specified *RGB(A)* value.
     *
     * @param integer $argb The *RGB(A)* value.
     *
     * @return integer The green component.
     * @throws InvalidArgumentException If `$argb` is less than `0x00000000` or
     *                                  greater than `0xffffffff`.
     */
    public static function rgbaValueToGreenComponent($argb)
    {
        self::throwExceptionIfNotRgbaValue($argb);
        return ($argb >> 8) & 255;
    }

    /**
     * Retrieves the blue component from the specified *RGB(A)* value.
     *
     * @param integer $argb The *RGB(A)* value.
     *
     * @return integer The blue component.
     * @throws InvalidArgumentException If `$argb` is less than `0x00000000` or
     *                                  greater than `0xffffffff`.
     */
    public static function rgbaValueToBlueComponent($argb)
    {
        self::throwExceptionIfNotRgbaValue($argb);
        return $argb & 255;
    }

    /**
     * Converts the specified 8-bit *RGB* components (red, green, and blue)
     * to a 24-bit *RGB* value.
     *
     * @param integer $red   The red component. Valid values are `0` through
     *                       `255`.
     * @param integer $green The green component. Valid values are `0` through
     *                       `255`.
     * @param integer $blue  The blue component. Valid values are `0` through
     *                       `255`.
     *
     * @return integer The 24-bit *RGB* value.
     * @throws InvalidArgumentException If `$red` is less than `0` or greater
     *                                  than `0xFF`.
     * @throws InvalidArgumentException If `$green` is less than `0` or greater
     *                                  than `0xFF`.
     * @throws InvalidArgumentException If `$blue` is less than `0` or greater
     *                                  than `0xFF`.
     */
    public static function rgbComponentsToRgbValue(
        $red,
        $green,
        $blue
    ) {
        self::throwExceptionIfNotRgbaComponent($red, 'red');
        self::throwExceptionIfNotRgbaComponent($green, 'green');
        self::throwExceptionIfNotRgbaComponent($blue, 'blue');

        return ($red << 16) | ($green << 8) | $blue;
    }

    /**
     * Converts the specified 24-bit *RGB(A)* color value to *CMYK* components.
     *
     * @param integer $rgb The *RGB(A)* color value to convert.
     *
     * @return mixed[] The *CMYK* components.
     * @throws InvalidArgumentException If `$rgb` is not a valid *RGB(A)* color
     *                                  value.
     * @todo Simplify algorithm.
     */
    public static function rgbaValueToCmykComponents($rgb)
    {
        self::throwExceptionIfNotRgbValue($rgb);

        $cyan = 0;
        $magenta = 0;
        $yellow = 0;
        $key = 1;
        $rgb = self::rgbaValueToRgbaComponents($rgb);

        if (0 !== $rgb['R'] || 0 !== $rgb['G'] || 0 !== $rgb['B']) {
            $cyanDiff = 1 - ($rgb['R'] / 255);
            $magentaDiff = 1 - ($rgb['G'] / 255);
            $yellowDiff = 1 - ($rgb['B'] / 255);

            $key = \min($cyanDiff, $magentaDiff, $yellowDiff);
            $cyan = ($cyanDiff - $key) / (1 - $key);
            $magenta = ($magentaDiff - $key) / (1 - $key);
            $yellow = ($yellowDiff - $key) / (1 - $key) ;
        }

        return [
            'C' => (int) ($cyan * 100),
            'M' => (int) ($magenta * 100),
            'Y' => (int) ($yellow * 100),
            'K' => (int) ($key * 100)
        ];
    }

    /**
     * Converts the specified *RGB(A)* value to *RGB(A)* components.
     *
     * @param integer $rgb The *RGB(A)* color value to convert.
     *
     * @return mixed[] The *RGB(A)* components.
     * @throws InvalidArgumentException If `$rgb` is not a *RGB(A)* color value.
     */
    public static function rgbaValueToRgbaComponents($rgb)
    {
        self::throwExceptionIfNotRgbaValue($rgb);

        $alpha = self::rgbaValueToAlphaComponent($rgb);

        if (0 === $alpha) {
            $alpha = 0xFF;
        }

        return [
            'R' => self::rgbaValueToRedComponent($rgb),
            'G' => self::rgbaValueToGreenComponent($rgb),
            'B' => self::rgbaValueToBlueComponent($rgb),
            'A' => $alpha
        ];
    }

    /**
     * Converts the specified *CMYK* components (cyan, magenta, yellow, and key
     * (black)) to a 24-bit *RGB* value.
     *
     * @param integer $cyan    The cyan component. Valid values are `0` through
     *                         `100`.
     * @param integer $magenta The magenta component. Valid values are `0`
     *                         through `100`.
     * @param integer $yellow  The yellow component. Valid values are `0`
     *                         through `100`.
     * @param integer $key     The key (black) component. Valid values are `0`
     *                         through `100`.
     *
     * @return integer The 24-bit *RGB* value.
     * @throws InvalidArgumentException If `$cyan` is less than `0` or greater
     *                                  than `100`.
     * @throws InvalidArgumentException If `$magenta` is less than `0` or
     *                                  greater than `100`.
     * @throws InvalidArgumentException If `$yellow` is less than `0` or greater
     *                                  than `100`.
     * @throws InvalidArgumentException If `$key` is less than `0` or greater
     *                                  than `100`.
     */
    public static function cmykComponentsToRgbValue(
        $cyan,
        $magenta,
        $yellow,
        $key
    ) {
        $rgb = self::cmykComponentsToRgbComponents(
            $cyan,
            $magenta,
            $yellow,
            $key
        );

        return self::rgbComponentsToRgbValue($rgb['R'], $rgb['G'], $rgb['B']);
    }

    /**
     * Converts the specified *CMYK* components (cyan, magenta, yellow, and key
     * (black)) to *RGB* components.
     *
     * @param integer $cyan    The cyan component. Valid values are `0` through
     *                         `100`.
     * @param integer $magenta The magenta component. Valid values are `0`
     *                         through `100`.
     * @param integer $yellow  The yellow component. Valid values are `0`
     *                         through `100`.
     * @param integer $key     The key (black) component. Valid values are `0`
     *                         through `100`.
     *
     * @return integer The *RGB* components.
     * @throws InvalidArgumentException If `$cyan` is less than `0` or greater
     *                                  than `100`.
     * @throws InvalidArgumentException If `$magenta` is less than `0` or
     *                                  greater than `100`.
     * @throws InvalidArgumentException If `$yellow` is less than `0` or greater
     *                                  than `100`.
     * @throws InvalidArgumentException If `$key` is less than `0` or greater
     *                                  than `100`.
     */
    public static function cmykComponentsToRgbComponents(
        $cyan,
        $magenta,
        $yellow,
        $key
    ) {
        self::throwExceptionIfNotCmykComponent($cyan, 'cyan');
        self::throwExceptionIfNotCmykComponent($magenta, 'magenta');
        self::throwExceptionIfNotCmykComponent($yellow, 'yellow');
        self::throwExceptionIfNotCmykComponent($key, 'key');

        // TODO Simplify and allow to use the Adobe algorithm as an alternative
        // $red = 1 - \min(1, $c + $key);
        // $green = 1 - \min(1, $m + $key);
        // $blue = 1 - \min(1, $y + $key);

        $cyan /= 100;
        $magenta /= 100;
        $yellow /= 100;
        $key /= 100;

        $scale = 1;
        $red = $scale - ($cyan * ($scale - $key) + $key);
        $green = $scale - ($magenta * ($scale - $key) + $key);
        $blue = $scale - ($yellow * ($scale - $key) + $key);

        return [
            'R' => (int) ($red * 255),
            'G' => (int) ($green * 255),
            'B' => (int) ($blue * 255),
        ];
    }

    /**
     * Converts the specified *RGB* components (red, green, and blue) to *CMYK*
     * components (cyan, magenta, yellow, and key (black)).
     *
     * @param integer $red   The red component. Valid values are `0` through
     *                       `255`.
     * @param integer $green The green component. Valid values are `0` through
     *                       `255`.
     * @param integer $blue  The blue component. Valid values are `0` through
     *                       `255`.
     *
     * @return array[mixed] The *CMYK* components.
     * @throws InvalidArgumentException If `$red` is less than `0` or greater
     *                                  than `0xFF`.
     * @throws InvalidArgumentException If `$green` is less than `0` or greater
     *                                  than `0xFF`.
     * @throws InvalidArgumentException If `$blue` is less than `0` or greater
     *                                  than `0xFF`..
     */
    public static function rgbComponentsToCmykComponents($red, $green, $blue)
    {
        $rgb = ColorUtils::rgbComponentsToRgbValue(
            $red,
            $green,
            $blue
        );

        return ColorUtils::rgbaValueToCmykComponents($rgb);
    }

    /**
     * Throws an {@see InvalidArgumentException} if the specified value is not a
     * *CMYK* component color value.
     *
     * @param integer $value The value to check.
     * @param string  $name  The name of the component color.
     *
     * @return void
     * @throws InvalidArgumentException If `$value` is not a *CMYK* component.
     */
    public static function throwExceptionIfNotCmykComponent($value, $name)
    {
        if (false === self::isValidCmykComponent($value)) {
            throw new InvalidArgumentException(
                'The ' . $name
                . ' CMYK component value is less than 0 or greater than 100.'
            );
        }
    }

    /**
     * Throws an {@see InvalidArgumentException} if the specified value is not a
     * *HTML* color value.
     *
     * @param integer $value The value to check.
     *
     * @return void
     * @throws InvalidArgumentException If `$value` is not a *HTML* color value.
     */
    public static function throwExceptionIfNotHtmlValue($value)
    {
        if (false === self::isValidHtmlValue($value)) {
            throw new InvalidArgumentException(
                'The HTML color value is invalid.'
            );
        }
    }

    /**
     * Throws an {@see InvalidArgumentException} if the specified value is not a
     * *RGB* color value.
     *
     * @param integer $value The value to check.
     *
     * @return void
     * @throws InvalidArgumentException If `$value` is not a *RGB* color value.
     */
    public static function throwExceptionIfNotRgbValue($value)
    {
        if (false === self::isValidRgbValue($value)) {
            throw new InvalidArgumentException(
                'The RGB color value is less than 0x0 or greater than 0xFFFFFF.'
            );
        }
    }

    /**
     * Throws an {@see InvalidArgumentException} if the specified value is not a
     * *RGB(A)* component color value.
     *
     * @param integer $value The value to check.
     * @param string  $name  The name of the component color.
     *
     * @return void
     * @throws InvalidArgumentException If `$value` is not a *RGB(A)* component
     *                                  color value.
     */
    public static function throwExceptionIfNotRgbaComponent($value, $name)
    {
        if (false === self::isValidRgbaComponent($value)) {
            throw new InvalidArgumentException(
                'The ' . $name
                . ' RGB(A) component color is less than 0x00 or greater than 0xFF.'
            );
        }
    }

    /**
     * Throws an {@see InvalidArgumentException} if the specified value is not a
     * *RGBA* color value.
     *
     * @param integer $value The value to check.
     *
     * @return void
     * @throws InvalidArgumentException If `$value` is not a *RGBA* color value.
     */
    public static function throwExceptionIfNotRgbaValue(
        $value
    ) {
        if (false === self::isValidRgbaValue($value)) {
            throw new InvalidArgumentException(
                'The RGBA color value is less than 0x0 or greater than 0xFFFFFFFF.'
            );
        }
    }
}
