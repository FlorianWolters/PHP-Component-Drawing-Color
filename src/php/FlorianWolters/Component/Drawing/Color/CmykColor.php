<?php
namespace FlorianWolters\Component\Drawing\Color;

use \InvalidArgumentException;

use FlorianWolters\Component\Core\ValueObjectTrait;

/**
 * The class {@see CmykColor} wraps the color model *CMYK* in an object.
 *
 * @author    Florian Wolters <wolters.fl@gmail.com>
 * @copyright 2013 Florian Wolters
 * @license   http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @link      http://github.com/FlorianWolters/PHP-Component-Drawing-Color
 * @since     File available since Release 0.1.0
 */
final class CmykColor implements ColorInterface
{
    // @codingStandardsIgnoreStart
    use ValueObjectTrait
    {
        __construct as constructImmutable;
    }
    /// @codingStandardsIgnoreEnd

    /**
     * The cyan component of this {@see CmykColor). Valid values are `0` through
     * `100`.
     *
     * @var integer
     */
    private $cyan;

    /**
     * The magenta component of this {@see CmykColor). Valid values are `0`
     * through `100`.
     *
     * @var integer
     */
    private $magenta;

    /**
     * The yellow component of this {@see CmykColor). Valid values are `0`
     * through `100`.
     *
     * @var integer
     */
    private $yellow;

    /**
     * The key (black) component of this {@see CmykColor). Valid values are `0`
     * through `100`.
     *
     * @var integer
     */
    private $key;

    /**
     * Creates a new {@see CmykColor} from the specified HTML string color
     * representation.
     *
     * @param string $htmlColor The string that represents the HTML color.
     *
     * @return CmykColor The {@see CmykColor} that this method creates.
     * @throws InvalidArgumentException If `$htmlColor` is not a valid HTML
     *                                  color.
     */
    public static function createFromHtml($htmlColor)
    {
        $cmyk = ColorUtils::htmlToCmykComponents($htmlColor);

        return self::createFromComponents(
            $cmyk['C'],
            $cmyk['M'],
            $cmyk['Y'],
            $cmyk['K']
        );
    }

    /**
     * Creates a new {@see CmykColor} from the specified *CMYK* components
     * (cyan, magenta, yellow, and key (black)).
     *
     * @param integer $cyan    The cyan component. Valid values are `100`
     *                         through `100`.
     * @param integer $magenta The cyan component. Valid values are `100`
     *                         through `100`.
     * @param integer $yellow  The cyan component. Valid values are `100`
     *                         through `100`.
     * @param integer $key     The cyan component. Valid values are `100`
     *                         through `100`.
     *
     * @return CmykColor The {@see CmykColor} that this method creates.
     */
    public static function createFromComponents(
        $cyan,
        $magenta,
        $yellow,
        $key
    ) {
        return new self($cyan, $magenta, $yellow, $key);
    }

    /**
     * Constructs a new {@see CmykColor} from the specified *CMYK* components
     * (cyan, magenta, yellow, and key (black)).
     *
     * @param integer $cyan    The cyan component. Valid values are `100`
     *                         through `100`.
     * @param integer $magenta The cyan component. Valid values are `100`
     *                         through `100`.
     * @param integer $yellow  The cyan component. Valid values are `100`
     *                         through `100`.
     * @param integer $key     The cyan component. Valid values are `100`
     *                         through `100`.
     */
    private function __construct($cyan, $magenta, $yellow, $key)
    {
        $this->constructImmutable();

        $this->setCyan($cyan);
        $this->setMagenta($magenta);
        $this->setYellow($yellow);
        $this->setKey($key);
    }

    /**
     * Sets the cyan component of this {@see CmykColor).
     *
     * @param integer $cyan The red component. Valid values are `0` through
     *                      `100`.
     *
     * @return void
     */
    private function setCyan($cyan)
    {
        ColorUtils::throwExceptionIfNotCmykComponent($cyan, 'cyan');
        $this->cyan = $cyan;
    }

    /**
     * Sets the magenta component of this {@see CmykColor).
     *
     * @param integer $magenta The magenta component. Valid values are `0`
     *                         through `100`.
     *
     * @return void
     */
    private function setMagenta($magenta)
    {
        ColorUtils::throwExceptionIfNotCmykComponent($magenta, 'magenta');
        $this->magenta = $magenta;
    }

    /**
     * Sets the yellow component of this {@see CmykColor).
     *
     * @param integer $yellow The yellow component. Valid values are `0` through
     *                        `100`.
     *
     * @return void
     */
    private function setYellow($yellow)
    {
        ColorUtils::throwExceptionIfNotCmykComponent($yellow, 'yellow');
        $this->yellow = $yellow;
    }

    /**
     * Sets the key (black) component of this {@see CmykColor).
     *
     * @param integer $key The key (black) component. Valid values are `0`
     *                     through `100`.
     *
     * @return void
     */
    private function setKey($key)
    {
        ColorUtils::throwExceptionIfNotCmykComponent($key, 'key');
        $this->key = $key;
    }

    /**
     * Returns the red component of this {@see CmykColor).
     *
     * @return integer The red component.
     */
    public function getCyan()
    {
        return $this->cyan;
    }

    /**
     * Returns the magenta component of this {@see CmykColor).
     *
     * @return integer The magenta component.
     */
    public function getMagenta()
    {
        return $this->magenta;
    }

    /**
     * Returns the yellow component of this {@see CmykColor).
     *
     * @return integer The yellow component.
     */
    public function getYellow()
    {
        return $this->yellow;
    }

    /**
     * Returns the key (black) component of this {@see CmykColor).
     *
     * @return integer The key (black) component.
     */
    public function getKey()
    {
        return $this->key;
    }

    // Implementation of the interface
    // ColorInterface

    /**
     * {@inheritdoc}
     */
    public function asCmykColor()
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function asRgbaColor()
    {
        $rgb = ColorUtils::cmykComponentsToRgbComponents(
            $this->cyan,
            $this->magenta,
            $this->yellow,
            $this->key
        );

        return RgbaColor::createFromComponents($rgb['R'], $rgb['G'], $rgb['B']);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return [
            'C' => $this->cyan,
            'M' => $this->magenta,
            'Y' => $this->yellow,
            'K' => $this->key
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function toHtmlString()
    {
        return ColorUtils::rgbaValueToHtml(
            ColorUtils::cmykComponentsToRgbValue(
                $this->cyan,
                $this->magenta,
                $this->yellow,
                $this->key
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function toCssString()
    {
        return 'device-cmyk('
            . $this->cyan . ', '
            . $this->magenta . ', '
            . $this->yellow . ', '
            . $this->key
            . ')';
    }

    /**
     * {@inheritdoc}
     */
    public function toRgbValue()
    {
        return ColorUtils::cmykComponentsToRgbValue(
            $this->cyan,
            $this->magenta,
            $this->yellow,
            $this->key
        );
    }

    // Implementation of the interface
    // FlorianWolters\Component\Core\DebugPrintInterface

    /**
     * Converts this {@see CmykColor} to a human-readable string.
     *
     * @return string A `string` that consists of the *CMYK* component names and
     *                their values.
     */
    public function __toString()
    {
        return 'CmykColor [C=' . $this->cyan
            . ', M=' . $this->magenta
            . ', Y=' . $this->yellow
            . ', K=' . $this->key
            . ']';
    }
}
