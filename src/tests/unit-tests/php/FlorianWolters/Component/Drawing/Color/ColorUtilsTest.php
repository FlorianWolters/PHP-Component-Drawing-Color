<?php
namespace FlorianWolters\Component\Drawing\Color;

use FlorianWolters\Component\Test\TestCaseAbstract;

/**
 * Test class for {@see ColorUtils}.
 *
 * @author    Florian Wolters <wolters.fl@gmail.com>
 * @copyright 2013 Florian Wolters
 * @license   http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @link      http://github.com/FlorianWolters/PHP-Component-Drawing-Color
 *
 * @covers    FlorianWolters\Component\Drawing\Color\ColorUtils
 */
class ColorUtilsTest extends TestCaseAbstract
{
    /**
     * @return void
     *
     * @test
     */
    public function testIsStaticClass()
    {
        $className = __NAMESPACE__ . '\ColorUtils';
        $this->assertFinalClass($className);
        $this->assertNotInstantiableClass($className);
    }

    /**
     * @return void
     *
     * @coversDefaultClass rgbaValueToHtml
     * @dataProvider providerRgbaValueToHtml
     * @test
     */
    public function testRgbaValueToHtml($expected, $rgb)
    {
        $actual = ColorUtils::rgbaValueToHtml($rgb);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return mixed[]
     */
    public static function providerRgbaValueToHtml()
    {
        return [
            '#000000' => ['#000000', 0x000000],
            '#ffffff' => ['#ffffff', 0xFFFFFF],
            '#ff0000' => ['#ff0000', 0xFF0000],
            '#00ff00' => ['#00ff00', 0x00FF00],
            '#0000ff' => ['#0000ff', 0x0000FF],
            '#000001' => ['#000001', 0x000001]
        ];
    }

    /**
     * @return void
     *
     * @coversDefaultClass rgbaValueToHtml
     * @expectedException \InvalidArgumentException
     * @test
     */
    public function testRgbaValueToHtmlThrowsInvalidArgumentException()
    {
        ColorUtils::rgbaValueToHtml(null);
    }

    /**
     * @return void
     *
     * @coversDefaultClass htmlToRgbaValue
     * @dataProvider providerHtmlToRgbaValue
     * @test
     */
    public function testHtmlToRgbaValue($expected, $html)
    {
        $actual = ColorUtils::htmlToRgbaValue($html);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return mixed[]
     */
    public static function providerHtmlToRgbaValue()
    {
        return [
            '0x000000' => [0x000000, '#000000'],
            '0xFFFFFF' => [0xFFFFFF, '#ffffff'],
            '0xFF0000' => [0xFF0000, '#ff0000'],
            '0x00FF00' => [0x00FF00, '#00ff00'],
            '0x0000FF' => [0x0000FF, '#0000ff'],
            'black' => [0x000000, 'black'],
            'white' => [0xFFFFFF, 'white'],
            'red' => [0xFF0000, 'red'],
            'lime' => [0x00FF00, 'lime'],
            'blue' => [0x0000FF, 'blue']
        ];
    }

    /**
     * @return void
     *
     * @coversDefaultClass htmlToRgbaValue
     * @expectedException \InvalidArgumentException
     * @test
     */
    public function testHtmlToRgbaValueThrowsInvalidArgumentException()
    {
        ColorUtils::htmlToRgbaValue(null);
    }

    /**
     * @return void
     *
     * @coversDefaultClass htmlToCmykComponents
     * @dataProvider providerHtmlToCmykComponents
     * @test
     */
    public function testHtmlToCmykComponents(array $expected, $html)
    {
        $actual = ColorUtils::htmlToCmykComponents($html);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return mixed[]
     */
    public static function providerHtmlToCmykComponents()
    {
        return [
            [['C' => 0, 'M' => 0, 'Y' => 0, 'K' => 100], '#000000'],
            [['C' => 0, 'M' => 0, 'Y' => 0, 'K' => 0], '#ffffff'],
            [['C' => 0, 'M' => 100, 'Y' => 100, 'K' => 0], '#ff0000'],
            [['C' => 100, 'M' => 0, 'Y' => 100, 'K' => 0], '#00ff00'],
            [['C' => 100, 'M' => 100, 'Y' => 0, 'K' => 0], '#0000ff']
        ];
    }

    /**
     * @return void
     *
     * @coversDefaultClass htmlToRgbaComponents
     * @dataProvider providerHtmlToRgbaComponents
     * @test
     */
    public function testHtmlToRgbaComponents(array $expected, $html)
    {
        $actual = ColorUtils::htmlToRgbaComponents($html);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return mixed[]
     */
    public static function providerHtmlToRgbaComponents()
    {
        return [
            [['R' => 0, 'G' => 0, 'B' => 0, 'A' => 0xFF], '#000000'],
            [['R' => 0xFF, 'G' => 0xFF, 'B' => 0xFF, 'A' => 0xFF], '#ffffff'],
            [['R' => 0xFF, 'G' => 0, 'B' => 0, 'A' => 0xFF], '#ff0000'],
            [['R' => 0, 'G' => 0xFF, 'B' => 0, 'A' => 0xFF], '#00ff00'],
            [['R' => 0, 'G' => 0, 'B' => 0xFF, 'A' => 0xFF], '#0000ff']
        ];
    }

    /**
     * @return void
     *
     * @coversDefaultClass isValidHtmlName
     * @dataProvider providerIsValidHtmlName
     * @test
     */
    public function testIsValidHtmlName($expected, $value)
    {
        $actual = ColorUtils::isValidHtmlName($value);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return mixed[]
     */
    public static function providerIsValidHtmlName()
    {
        return [
            [true, 'black'],
            [true, 'white'],
            [true, 'red'],
            [true, 'green'],
            [true, 'blue'],
            [false, null],
            [false, new \stdClass],
            [false, false],
            [false, 0],
            [false, .1],
            [false, ''],
            [false, 'unknown']
        ];
    }

    /**
     * @return void
     *
     * @coversDefaultClass isValidHtmlValue
     * @dataProvider providerIsValidHtmlValue
     * @test
     */
    public function testIsValidHtmlValue($expected, $value)
    {
        $actual = ColorUtils::isValidHtmlValue($value);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return mixed[]
     */
    public static function providerIsValidHtmlValue()
    {
        return [
            [true, '#000000'],
            [true, '#ffffff'],
            [true, '#ff0000'],
            [true, '#00ff00'],
            [true, '#0000ff'],
            [false, null],
            [false, new \stdClass],
            [false, false],
            [false, 0],
            [false, .1],
            [false, ''],
            [false, '#gggggg']
        ];
    }

    /**
     * @return void
     *
     * @coversDefaultClass isValidHtml
     * @dataProvider providerIsValidHtml
     * @test
     */
    public function testIsValidHtml($expected, $value)
    {
        $actual = ColorUtils::isValidHtml($value);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return mixed[]
     */
    public static function providerIsValidHtml()
    {
        return \array_merge(
            self::providerIsValidHtmlName(),
            self::providerIsValidHtmlValue()
        );
    }

    /**
     * @return void
     *
     * @coversDefaultClass isValidCmykComponent
     * @dataProvider providerIsValidCmykComponent
     * @test
     */
    public function testIsValidCmykComponent($expected, $value)
    {
        $actual = ColorUtils::isValidCmykComponent($value);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return mixed[]
     */
    public static function providerIsValidCmykComponent()
    {
        return [
            '0' => [true, 0],
            '1' => [true, 1],
            '50' => [true, 50],
            '99' => [true, 99],
            '100' => [true, 100],
            '-1' => [false, -1],
            '101' => [false, 101]
        ];
    }

    /**
     * @return void
     *
     * @coversDefaultClass isValidRgbaComponent
     * @dataProvider providerIsValidRgbaComponent
     * @test
     */
    public function testIsValidRgbaComponent($expected, $value)
    {
        $actual = ColorUtils::isValidRgbaComponent($value);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return mixed[]
     */
    public static function providerIsValidRgbaComponent()
    {
        return [
            '0' => [true, 0],
            '1' => [true, 1],
            '127' => [true, 127],
            '254' => [true, 254],
            '255' => [true, 255],
            '-1' => [false, -1],
            '256' => [false, 256]
        ];
    }

    /**
     * @return void
     *
     * @coversDefaultClass rgbaValueToAlphaComponent
     * @dataProvider providerRgbaValueToAlphaComponent
     * @test
     */
    public function testRgbaValueToAlphaComponent($expected, $rgb)
    {
        $actual = ColorUtils::rgbaValueToAlphaComponent($rgb);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return mixed[]
     */
    public static function providerRgbaValueToAlphaComponent()
    {
        return [
            '0x00000000' => [0, 0x00000000],
            '0x00FFFFFF' => [0, 0x00FFFFFF],
            '0xFFFFFFFF' => [0xFF, 0xFFFFFFFF],
            '0xFF000000' => [0xFF, 0xFF000000],
            '0xF0000000' => [0xF0, 0xF0000000],
            '0x0F000000' => [0x0F, 0x0F000000]
        ];
    }

    /**
     * @return void
     *
     * @coversDefaultClass rgbaValueToRedComponent
     * @dataProvider providerRgbaValueToRedComponent
     * @test
     */
    public function testRgbaValueToRedComponent($expected, $rgb)
    {
        $actual = ColorUtils::rgbaValueToRedComponent($rgb);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return mixed[]
     */
    public static function providerRgbaValueToRedComponent()
    {
        return [
            // RGB
            [0, 0x000000],
            [0, 0x00FFFF],
            [255, 0xFFFFFF],
            [255, 0xFF0000],
            [240, 0xF00000],
            [15, 0x0F0000],
            // ARGB
            [0, 0x00000000],
            [0, 0xFF00FFFF],
            [255, 0xFFFFFFFF],
            [255, 0x00FF0000],
            [240, 0x00F00000],
            [15, 0x000F0000]
        ];
    }

    /**
     * @return void
     *
     * @coversDefaultClass rgbaValueToGreenComponent
     * @dataProvider providerRgbaValueToGreenComponent
     * @test
     */
    public function testRgbaValueToGreenComponent($expected, $rgb)
    {
        $actual = ColorUtils::rgbaValueToGreenComponent($rgb);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return mixed[]
     */
    public static function providerRgbaValueToGreenComponent()
    {
        return [
            // RGB
            [0, 0x000000],
            [0, 0xFF00FF],
            [255, 0xFFFFFF],
            [255, 0x00FF00],
            [240, 0x00F000],
            [15, 0x000F00],
            // ARGB
            [0, 0x00000000],
            [0, 0xFFFF00FF],
            [255, 0xFFFFFFFF],
            [255, 0x0000FF00],
            [240, 0x0000F000],
            [15, 0x00000F00]
        ];
    }

    /**
     * @return void
     *
     * @coversDefaultClass rgbaValueToBlueComponent
     * @dataProvider providerRgbaValueToBlueComponent
     * @test
     */
    public function testRgbaValueToBlueComponent($expected, $rgb)
    {
        $actual = ColorUtils::rgbaValueToBlueComponent($rgb);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return mixed[]
     */
    public static function providerRgbaValueToBlueComponent()
    {
        return [
            // RGB
            [0, 0x000000],
            [0, 0xFFFF00],
            [255, 0xFFFFFF],
            [255, 0x0000FF],
            [240, 0x0000F0],
            [15, 0x00000F],
            // ARGB
            [0, 0x00000000],
            [0, 0xFFFFFF00],
            [255, 0xFFFFFFFF],
            [255, 0x000000FF],
            [240, 0x000000F0],
            [15, 0x0000000F]
        ];
    }

    /**
     * @return void
     *
     * @coversDefaultClass rgbComponentsToCmykComponents
     * @dataProvider providerRgbComponentsToCmykComponents
     * @test
     */
    public function testRgbComponentsToCmykComponents(
        $expected,
        $red,
        $green,
        $blue
    ) {
        $actual = ColorUtils::rgbComponentsToCmykComponents($red, $green, $blue);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return mixed[]
     */
    public static function providerRgbComponentsToCmykComponents()
    {
        return [
            '0x0' => [['C' => 0, 'M' => 0, 'Y' => 0, 'K' => 100], 0, 0, 0, 0],
            '0xFFFFFF' => [['C' => 0, 'M' => 0, 'Y' => 0, 'K' => 0], 0xFF, 0xFF, 0xFF],
            '0xFF0000' => [['C' => 0, 'M' => 100, 'Y' => 100, 'K' => 0], 0xFF, 0, 0],
            '0x00FF00' => [['C' => 100, 'M' => 0, 'Y' => 100, 'K' => 0], 0, 0xFF, 0],
            '0x0000FF' => [['C' => 100, 'M' => 100, 'Y' => 0, 'K' => 0], 0, 0, 0xFF]
        ];
    }

    /**
     * @return void
     *
     * @coversDefaultClass rgbComponentsToRgbValue
     * @dataProvider providerRgbComponentsToRgbValue
     * @test
     */
    public function testRgbComponentsToRgbValue(
        $expected,
        $red,
        $green,
        $blue
    ) {
        $actual = ColorUtils::rgbComponentsToRgbValue($red, $green, $blue);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return mixed[]
     */
    public static function providerRgbComponentsToRgbValue()
    {
        return [
            '0x0' => [0x0, 0, 0, 0, 0],
            '0xFFFFFF' => [0xFFFFFF, 0xFF, 0xFF, 0xFF],
            '0xFF0000' => [0xFF0000, 0xFF, 0, 0],
            '0x00FF00' => [0x00FF00, 0, 0xFF, 0],
            '0x0000FF' => [0x0000FF, 0, 0, 0xFF]
        ];
    }

    /**
     * @return void
     *
     * @coversDefaultClass cmykComponentsToRgbComponents
     * @dataProvider providerCmykComponentsToRgbComponents
     * @test
     */
    public function testCmykComponentsToRgbComponents(
        $expected,
        $cyan,
        $magenta,
        $yellow,
        $key
    ) {
        $actual = ColorUtils::cmykComponentsToRgbComponents(
            $cyan,
            $magenta,
            $yellow,
            $key
        );

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return mixed[]
     */
    public static function providerCmykComponentsToRgbComponents()
    {
        return [
            '0x0' => [['R' => 0, 'G' => 0, 'B' => 0], 0, 0, 0, 100],
            '0xFFFFFF' => [['R' => 0xFF, 'G' => 0xFF, 'B' => 0xFF], 0, 0, 0, 0],
            '0xFF0000' => [['R' => 0xFF, 'G' => 0, 'B' => 0], 0, 100, 100, 0],
            '0x00FF00' => [['R' => 0, 'G' => 0xFF, 'B' => 0], 100, 0, 100, 0],
            '0x0000FF' => [['R' => 0, 'G' => 0, 'B' => 0xFF], 100, 100, 0, 0]
        ];
    }

    /**
     * @return void
     *
     * @coversDefaultClass cmykComponentsToRgbComponents
     * @dataProvider providerInvalidCmykComponents
     * @expectedException \InvalidArgumentException
     * @test
     */
    public function testCmykComponentsToRgbComponentsThrowsInvalidArgumentException(
        $cyan,
        $magenta,
        $yellow,
        $key
    ) {
        ColorUtils::cmykComponentsToRgbComponents(
            $cyan,
            $magenta,
            $yellow,
            $key
        );
    }

    /**
     * @return mixed[]
     */
    public static function providerInvalidCmykComponents()
    {
        return [
            [-1, 0, 0, 0],
            [101, 0, 0, 0],
            [0, -1, 0, 0],
            [0, 101, 0, 0],
            [0, 0, -1, 0],
            [0, 0, 101, 0],
            [0, 0, 0, -1],
            [0, 0, 0, 101]
        ];
    }

    /**
     * @return void
     *
     * @coversDefaultClass cmykComponentsToRgbValue
     * @dataProvider providerCmykComponentsToRgbValue
     * @test
     */
    public function testCmykComponentsToRgbValue(
        $expected,
        $cyan,
        $magenta,
        $yellow,
        $key
    ) {
        $actual = ColorUtils::cmykComponentsToRgbValue(
            $cyan,
            $magenta,
            $yellow,
            $key
        );

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return mixed[]
     */
    public static function providerCmykComponentsToRgbValue()
    {
        return [
            '0x0' => [0x0, 0, 0, 0, 100],
            '0xFFFFFF' => [0xFFFFFF, 0, 0, 0, 0],
            '0xFF0000' => [0xFF0000, 0, 100, 100, 0],
            '0x00FF00' => [0x00FF00, 100, 0, 100, 0],
            '0x0000FF' => [0x0000FF, 100, 100, 0, 0]
        ];
    }

    /**
     * @return void
     *
     * @coversDefaultClass rgbaValueToRgbaComponents
     * @dataProvider providerRgbaValueToRgbaComponents
     * @test
     */
    public function testRgbaValueToRgbaComponents($expected, $rgb)
    {
        $actual = ColorUtils::rgbaValueToRgbaComponents($rgb);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return mixed[]
     */
    public static function providerRgbaValueToRgbaComponents()
    {
        return [
            [['R' => 0, 'G' => 0, 'B' => 0, 'A' => 0xFF], 0x000000],
            [['R' => 0xFF, 'G' => 0xFF, 'B' => 0xFF, 'A' => 0xFF], 0xFFFFFF],
            [['R' => 0xFF, 'G' => 0, 'B' => 0, 'A' => 0xFF], 0xFF0000],
            [['R' => 0, 'G' => 0xFF, 'B' => 0, 'A' => 0xFF], 0x00FF00],
            [['R' => 0, 'G' => 0, 'B' => 0xFF, 'A' => 0xFF], 0x0000FF],
            [['R' => 0xFF, 'G' => 0xFF, 'B' => 0xFF, 'A' => 0xFF], 0xFFFFFFFF],
            [['R' => 0, 'G' => 0, 'B' => 0, 'A' => 0xF0], 0xF0000000]
        ];
    }

    /**
     * @return void
     *
     * @coversDefaultClass rgbaValueToRgbaComponents
     * @expectedException \InvalidArgumentException
     * @test
     */
    public function testRgbaValueToRgbaComponentsThrowsInvalidArgumentException()
    {
        ColorUtils::rgbaValueToRgbaComponents(null);
    }

    /**
     * @return void
     *
     * @coversDefaultClass rgbComponentsToRgbValue
     * @dataProvider providerInvalidRgbComponents
     * @expectedException \InvalidArgumentException
     * @test
     */
    public function testRgbComponentsToRgbValueThrowsInvalidArgumentException(
        $red,
        $green,
        $blue
    ) {
        ColorUtils::rgbComponentsToRgbValue($red, $green, $blue);
    }

    /**
     * @return mixed[]
     */
    public static function providerInvalidRgbComponents()
    {
        return [
            [-1, 0, 0],
            [256, 0, 0],
            [0, -1, 0],
            [0, 256, 0],
            [0, 0, -1],
            [0, 0, 256]
        ];
    }

    /**
     * @return mixed[]
     */
    public static function providerInvalidRgbaComponents()
    {
        return [
            [-1, 0, 0, 0xFF],
            [256, 0, 0, 0xFF],
            [0, -1, 0, 0xFF],
            [0, 256, 0, 0xFF],
            [0, 0, -1, 0xFF],
            [0, 0, 256, 0xFF],
            [0, 0, 0, -1],
            [0, 0, 0, 256]
        ];
    }

    /**
     * @return void
     *
     * @coversDefaultClass isValidRgbValue
     * @dataProvider providerIsValidRgbValue
     * @test
     */
    public function testIsValidRgbValue($expected, $rgb)
    {
        $actual = ColorUtils::isValidRgbValue($rgb);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return mixed[]
     */
    public static function providerIsValidRgbValue()
    {
        return [
            [true, 0x0],
            [true, 0x000001],
            [true, 0xFFFFFE],
            [true, 0xFFFFFF],
            [false, 0x1000000],
            [false, -1]
        ];
    }

    /**
     * @return void
     *
     * @coversDefaultClass isValidRgbaValue
     * @dataProvider providerIsValidRgbaValue
     * @test
     */
    public function testIsValidRgbaValue($expected, $rgb)
    {
        $actual = ColorUtils::isValidRgbaValue($rgb);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return mixed[]
     */
    public static function providerIsValidRgbaValue()
    {
        return [
            [true, 0x0],
            [true, 0x00000001],
            [true, 0xFFFFFFFE],
            [true, 0xFFFFFFFF],
            [false, 0x100000000],
            [false, -1]
        ];
    }
}
