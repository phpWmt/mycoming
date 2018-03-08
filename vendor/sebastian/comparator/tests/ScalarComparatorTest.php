<?php
/*
 * This file is part of the Comparator package.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianBergmann\Comparator;

use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass SebastianBergmann\Comparator\ScalarComparator
 */
class ScalarComparatorTest extends TestCase
{
    private $comparator;

    protected function setUp()
    {
        $this->comparator = new ScalarComparator;
    }

    public function acceptsSucceedsProvider()
    {
        return [
          ['string', 'string'],
          [new ClassWithToString, 'string'],
          ['string', new ClassWithToString],
          ['string', null],
          [false, 'string'],
          [false, true],
          [null, false],
          [null, null],
          ['10', 10],
          ['', false],
          ['1', true],
          [1, true],
          [0, false],
          [0.1, '0.1']
        ];
    }

    public function acceptsFailsProvider()
    {
        return [
          [[], []],
          ['string', []],
          [new ClassWithToString, new ClassWithToString],
          [false, new ClassWithToString],
          [tmpfile(), tmpfile()]
        ];
    }

    public function assertEqualsSucceedsProvider()
    {
        return [
          ['string', 'string'],
          [new ClassWithToString, new ClassWithToString],
          ['string representation', new ClassWithToString],
          [new ClassWithToString, 'string representation'],
          ['string', 'STRING', true],
          ['STRING', 'string', true],
          ['String Representation', new ClassWithToString, true],
          [new ClassWithToString, 'String Representation', true],
          ['10', 10],
          ['', false],
          ['1', true],
          [1, true],
          [0, false],
          [0.1, '0.1'],
          [false, null],
          [false, false],
          [true, true],
          [null, null]
        ];
    }

    public function assertEqualsFailsProvider()
    {
        $stringException = 'Failed asserting that two strings are equal.';
        $otherException  = 'matches expected';

        return [
          ['string', 'other string', $stringException],
          ['string', 'STRING', $stringException],
          ['STRING', 'string', $stringException],
          ['string', 'other string', $stringException],
          // https://github.com/sebastianbergmann/phpunit/issues/1023
          ['9E6666666','9E7777777', $stringException],
          [new ClassWithToString, 'does not match', $otherException],
          ['does not match', new ClassWithToString, $otherException],
          [0, 'Foobar', $otherException],
          ['Foobar', 0, $otherException],
          ['10', 25, $otherException],
          ['1', false, $otherException],
          ['', true, $otherException],
          [false, true, $otherException],
          [true, false, $otherException],
          [null, true, $otherException],
          [0, true, $otherException]
        ];
    }

    /**
     * @covers       ::accepts
     * @dataProvider acceptsSucceedsProvider
     */
    public function testAcceptsSucceeds($expected, $actual)
    {
        $this->assertTrue(
          $this->comparator->accepts($expected, $actual)
        );
    }

    /**
     * @covers       ::accepts
     * @dataProvider acceptsFailsProvider
     */
    public function testAcceptsFails($expected, $actual)
    {
        $this->assertFalse(
          $this->comparator->accepts($expected, $actual)
        );
    }

    /**
     * @covers       ::assertEquals
     * @dataProvider assertEqualsSucceedsProvider
     */
    public function testAssertEqualsSucceeds($expected, $actual, $ignoreCase = false)
    {
        $exception = null;

        try {
            $this->comparator->assertEquals($expected, $actual, 0.0, false, $ignoreCase);
        } catch (ComparisonFailure $exception) {
        }

        $this->assertNull($exception, 'Unexpected ComparisonFailure');
    }

    /**
     * @covers       ::assertEquals
     * @dataProvider assertEqualsFailsProvider
     */
    public function testAssertEqualsFails($expected, $actual, $message)
    {
        $this->expectException(ComparisonFailure::class);
        $this->expectExceptionMessage($message);

        $this->comparator->assertEquals($expected, $actual);
    }
}
