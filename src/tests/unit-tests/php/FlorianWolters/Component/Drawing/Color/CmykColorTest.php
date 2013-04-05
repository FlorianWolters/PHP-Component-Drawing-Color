<?php
namespace FlorianWolters\Component\Drawing\Color;

use FlorianWolters\Component\Test\TestCaseAbstract;

/**
 * Test class for {@see CmykColor}.
 *
 * @author    Florian Wolters <wolters.fl@gmail.com>
 * @copyright 2013 Florian Wolters
 * @license   http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @link      http://github.com/FlorianWolters/PHP-Component-Drawing-Color
 *
 * @covers    FlorianWolters\Component\Drawing\Color\CmykColor
 */
class CmykColorTest extends TestCaseAbstract
{
    /**
     * The {@see CmykColor} under test.
     *
     * @var CmykColor
     */
    private $cmykColor;

    /**
     * Sets up the fixture.
     *
     * This method is called before a test is executed.
     *
     * @return void
     */
    public function setUp()
    {
        $cyan = 0;
        $magenta = 35;
        $yellow = 100;
        $key = 0;

        $this->cmykColor = CmykColor::createFromComponents(
            $cyan,
            $magenta,
            $yellow,
            $key
        );
    }

    /**
     * @return void
     *
     * @test
     */
    public function testIsFinalClass()
    {
        $this->assertFinalClass($this->cmykColor);
    }

    /**
     * @return void
     *
     * @expectedException FlorianWolters\Component\Core\ImmutableException
     * @test
     */
    public function testIsImmutableObject()
    {
        $this->cmykColor->foo = 'bar';
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
        clone $this->cmykColor;
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
        $cyan,
        $magenta,
        $yellow,
        $key
    ) {
        CmykColor::createFromComponents($cyan, $magenta, $yellow, $key);
    }

    /**
     * @return mixed[]
     */
    public static function providerCreateFromComponentsThrowsInvalidArgumentException()
    {
        return [
            'cyan = -1' => [-1, 0, 0, 0],
            'cyan = 101' => [101, 0, 0, 0],
            'magenta = -1' => [0, -1, 0, 0],
            'magenta = 101' => [0, 101, 0, 0],
            'yellow = -1' => [0, 0, -1, 0],
            'yellow = 101' => [0, 0, 101, 0],
            'key = -1' => [0, 0, 0, -1],
            'key = 101' => [0, 0, 0, 101]
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
        $actual = CmykColor::createFromHtml($htmlColor);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return mixed[]
     */
    public static function providerCreateFromHtml()
    {
        return [
            'black' => [CmykColor::createFromComponents(0, 0, 0, 100), 'black'],
            'white' => [CmykColor::createFromComponents(0, 0, 0, 0), 'white'],
            'red' => [CmykColor::createFromComponents(0, 100, 100, 0), 'red'],
            'lime' => [CmykColor::createFromComponents(100, 0, 100, 0), 'lime'],
            'blue' => [CmykColor::createFromComponents(100, 100, 0, 0), 'blue'],
            '#000000' => [CmykColor::createFromComponents(0, 0, 0, 100), '#000000'],
            '#ffffff' => [CmykColor::createFromComponents(0, 0, 0, 0), '#ffffff'],
            '#ff0000' => [CmykColor::createFromComponents(0, 100, 100, 0), '#ff0000'],
            '#00ff00' => [CmykColor::createFromComponents(100, 0, 100, 0), '#00ff00'],
            '#0000ff' => [CmykColor::createFromComponents(100, 100, 0, 0), '#0000ff'],
            '#0f0000' => [CmykColor::createFromComponents(0, 100, 100, 94), '#0f0000']
        ];
    }

    /**
     * @return void
     *
     * @coversDefaultClass getCyan
     * @test
     */
    public function testGetCyan()
    {
        $expected = 0;
        $actual = $this->cmykColor->getCyan();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     *
     * @coversDefaultClass getMagenta
     * @test
     */
    public function testGetMagenta()
    {
        $expected = 35;
        $actual = $this->cmykColor->getMagenta();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     *
     * @coversDefaultClass getYellow
     * @test
     */
    public function testGetYellow()
    {
        $expected = 100;
        $actual = $this->cmykColor->getYellow();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     *
     * @coversDefaultClass getKey
     * @test
     */
    public function testGetKey()
    {
        $expected = 0;
        $actual = $this->cmykColor->getKey();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     *
     * @coversDefaultClass asCmykColor
     * @test
     */
    public function testAsCmykColor()
    {
        $expected = $this->cmykColor;
        $actual = $this->cmykColor->asCmykColor();

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
        $expected = RgbaColor::createFromComponents(0xFF, 0xA5, 0x00);
        $actual = $this->cmykColor->asRgbaColor();

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
            'C' => 0,
            'M' => 35,
            'Y' => 100,
            'K' => 0
        ];
        $actual = $this->cmykColor->toArray();

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
        $actual = $this->cmykColor->toHtmlString();

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
        $expected = 'device-cmyk(0, 35, 100, 0)';
        $actual = $this->cmykColor->toCssString();

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
        $actual = $this->cmykColor->toRgbValue();

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
        $expected = 'CmykColor [C=0, M=35, Y=100, K=0]';
        $actual = $this->cmykColor->__toString();

        $this->assertEquals($expected, $actual);
    }
}
