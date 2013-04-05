<?php
namespace FlorianWolters\Component\Drawing\Color;

use FlorianWolters\Component\Test\TestCaseAbstract;

/**
 * Test class for {@see RgbaColor}.
 *
 * @author    Florian Wolters <wolters.fl@gmail.com>
 * @copyright 2013 Florian Wolters
 * @license   http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @link      http://github.com/FlorianWolters/PHP-Component-Drawing-Color
 *
 * @covers    FlorianWolters\Component\Drawing\Color\RgbaColor
 */
class RgbaColorTest extends TestCaseAbstract
{
    /**
     * The {@see RgbaColor} under test.
     *
     * @var RgbaColor
     */
    private $rgbaColor;

    /**
     * Sets up the fixture.
     *
     * This method is called before a test is executed.
     *
     * @return void
     */
    public function setUp()
    {
        $red = 0xFF;
        $gree = 0xA5;
        $blue = 0x00;
        $alpha = 0x0F;

        $this->rgbaColor = RgbaColor::createFromComponents(
            $red,
            $gree,
            $blue,
            $alpha
        );
    }

    /**
     * @return void
     *
     * @test
     */
    public function testIsFinalClass()
    {
        $this->assertFinalClass($this->rgbaColor);
    }

    /**
     * @return void
     *
     * @expectedException FlorianWolters\Component\Core\ImmutableException
     * @test
     */
    public function testIsImmutableObject()
    {
        $this->rgbaColor->foo = 'bar';
    }

    /**
     * @return void
     *
     * @coversDefaultClass __clone
     * @expectedException FlorianWolters\Component\Core\CloneNotSupportedException
     * @test
     */
    public function testCloneNotSupported()
    {
        clone $this->rgbaColor;
    }

    /**
     * @return void
     *
     * @coversDefaultClass createFromComponents
     * @dataProvider providerCreateFromComponentsThrowsInvalidArgumentException
     * @expectedException \InvalidArgumentException
     * @test
     */
    public function testCreateFromComponentsThrowsInvalidArgumentException(
        $alpha,
        $red,
        $green,
        $blue
    ) {
        RgbaColor::createFromComponents($alpha, $red, $green, $blue);
    }

    /**
     * @return mixed[]
     */
    public static function providerCreateFromComponentsThrowsInvalidArgumentException()
    {
        return [
            'red = -1' => [-1, 0, 0, 0],
            'red = 256' => [256, 0, 0, 0],
            'green = -1' => [0, -1, 0, 0],
            'green = 256' => [0, 256, 0, 0],
            'blue = -1' => [0, 0, -1, 0],
            'blue = 256' => [0, 0, 256, 0],
            'alpha = -1' => [0, 0, 0, -1],
            'alpha = 256' => [0, 0, 0, 256]
        ];
    }

    /**
     * @return void
     *
     * @coversDefaultClass createFromComponents
     * @dataProvider providerCreateFromComponents
     * @test
     */
    public function testCreateFromComponents($alpha, $red, $green, $blue)
    {
        $actual = RgbaColor::createFromComponents($red, $green, $blue, $alpha);

        $this->assertEquals($red, $actual->getRed());
        $this->assertEquals($green, $actual->getGreen());
        $this->assertEquals($blue, $actual->getBlue());
        $this->assertEquals($alpha, $actual->getAlpha());
    }

    /**
     * @return mixed[]
     */
    public static function providerCreateFromComponents()
    {
        return [
            '0x000000' => [0, 0, 0, 0],
            '0xFFFFFF' => [255, 255, 255, 255],
            '0xFF0000' => [255, 255, 0, 0],
            '0x00FF00' => [255, 0, 255, 0],
            '0x0000FF' => [255, 0, 0, 255]
        ];
    }

/**
     * @return void
     *
     * @coversDefaultClass createFromValue
     * @dataProvider providerCreateFromValue
     * @test
     */
    public function testCreateFromValue($expected, $rgb)
    {
        $actual = RgbaColor::createFromValue($rgb);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return mixed[]
     */
    public static function providerCreateFromValue()
    {
        return [
            '0x000000' => [RgbaColor::createFromComponents(0, 0, 0), 0x000000],
            '0xFFFFFF' => [RgbaColor::createFromComponents(255, 255, 255), 0xFFFFFF],
            '0xFF0000' => [RgbaColor::createFromComponents(255, 0, 0), 0xFF0000],
            '0x00FF00' => [RgbaColor::createFromComponents(0, 255, 0), 0x00FF00],
            '0x0000FF' => [RgbaColor::createFromComponents(0, 0, 255), 0x0000FF]
        ];
    }

    /**
     * @return void
     *
     * @coversDefaultClass createFromHtml
     * @dataProvider providerCreateFromHtml
     * @test
     */
    public function testCreateFromHtml($expected, $htmlColor)
    {
        $actual = RgbaColor::createFromHtml($htmlColor);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return mixed[]
     */
    public static function providerCreateFromHtml()
    {
        return [
            'black' => [RgbaColor::createFromComponents(0, 0, 0), 'black'],
            'white' => [RgbaColor::createFromComponents(255, 255, 255), 'white'],
            'red' => [RgbaColor::createFromComponents(255, 0, 0), 'red'],
            'lime' => [RgbaColor::createFromComponents(0, 255, 0), 'lime'],
            'blue' => [RgbaColor::createFromComponents(0, 0, 255), 'blue'],
            '#000000' => [RgbaColor::createFromComponents(0, 0, 0), '#000000'],
            '#ffffff' => [RgbaColor::createFromComponents(255, 255, 255), '#ffffff'],
            '#ff0000' => [RgbaColor::createFromComponents(255, 0, 0), '#ff0000'],
            '#00ff00' => [RgbaColor::createFromComponents(0, 255, 0), '#00ff00'],
            '#0000ff' => [RgbaColor::createFromComponents(0, 0, 255), '#0000ff']
        ];
    }

    /**
     * @return void
     *
     * @coversDefaultClass asCmykColor
     * @test
     */
    public function testAsCmykColor()
    {
        $expected = CmykColor::createFromComponents(0, 35, 100, 0);
        $actual = $this->rgbaColor->asCmykColor();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     *
     * @coversDefaultClass asRgbaColor
     * @test
     */
    public function testAsRgbaColor()
    {
        $expected = $this->rgbaColor;
        $actual = $this->rgbaColor->asRgbaColor();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     *
     * @coversDefaultClass toArray
     * @test
     */
    public function testToArray()
    {
        $expected = [
            'R' => 255,
            'G' => 165,
            'B' => 0,
            'A' => 15
        ];
        $actual = $this->rgbaColor->toArray();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     *
     * @coversDefaultClass toHtmlString
     * @test
     */
    public function testToHtmlString()
    {
        $expected = '#ffa500';
        $actual = $this->rgbaColor->toHtmlString();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     *
     * @coversDefaultClass toCssString
     * @test
     */
    public function testToCssString()
    {
        $expected = 'rgba(255, 165, 0, 0.06)';
        $actual = $this->rgbaColor->toCssString();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     *
     * @coversDefaultClass toHtmlString
     * @test
     */
    public function testToRgbValue()
    {
        $expected = 0xFFA500;
        $actual = $this->rgbaColor->toRgbValue();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     *
     * @coversDefaultClass __toString
     * @test
     */
    public function test__toString()
    {
        $expected = 'RgbaColor [R=255, G=165, B=0, A=15]';
        $actual = $this->rgbaColor->__toString();

        $this->assertEquals($expected, $actual);
    }
}
