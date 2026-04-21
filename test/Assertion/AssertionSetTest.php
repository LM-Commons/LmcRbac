<?php

declare(strict_types=1);

/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

namespace LmcTest\Rbac\Assertion;

use Lmc\Rbac\Assertion\AssertionPluginManagerInterface;
use Lmc\Rbac\Assertion\AssertionSet;
use Lmc\Rbac\Exception\InvalidArgumentException;
use Lmc\Rbac\Identity\IdentityInterface;
use LmcTest\Rbac\Asset\SimpleAssertion;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use stdClass;

use function is_array;

#[CoversClass(AssertionSet::class)]
class AssertionSetTest extends TestCase
{
    public function testWhenNoAssertionsArePresentTheAssertionWillFail(): void
    {
        $assertionContainer = $this->createStub(AssertionPluginManagerInterface::class);
        $assertionSet       = new AssertionSet($assertionContainer, []);

        $this->assertFalse($assertionSet->assert('foo'));
    }

    public function testAcceptsAnAndCondition(): void
    {
        $assertionContainer = $this->createStub(AssertionPluginManagerInterface::class);
        $assertionSet       = new AssertionSet($assertionContainer, ['condition' => AssertionSet::CONDITION_AND]);

        $this->assertFalse($assertionSet->assert('foo'));
    }

    public function testAcceptsAnOrCondition(): void
    {
        $assertionContainer = $this->createStub(AssertionPluginManagerInterface::class);
        $assertionSet       = new AssertionSet($assertionContainer, ['condition' => AssertionSet::CONDITION_OR]);

        $this->assertFalse($assertionSet->assert('foo'));
    }

    public function testThrowsExceptionForAnUnknownCondition(): void
    {
        $assertionContainer = $this->createStub(AssertionPluginManagerInterface::class);

        $this->expectException(InvalidArgumentException::class);
        new AssertionSet($assertionContainer, ['condition' => 'unknown']);
    }

    public function testWhenNoConditionIsGivenAndIsUsed(): void
    {
        $fooAssertion = new SimpleAssertion(true);
        $barAssertion = new SimpleAssertion(false);

        $assertionContainer = $this->getMockBuilder(AssertionPluginManagerInterface::class)->getMock();
        $assertionSet       = new AssertionSet($assertionContainer, ['fooFactory', 'barFactory']);

        $matcher = $this->exactly(2);
        $assertionContainer->expects($matcher)
            ->method('get')
            ->willReturnCallback(function (string $key) use ($fooAssertion, $barAssertion) {
                return match ($key) {
                    'fooFactory' => $fooAssertion,
                    'barFactory' => $barAssertion,
                };
            });

        $this->assertFalse($assertionSet->assert('permission'));

        $this->assertTrue($fooAssertion->gotCalled());
        $this->assertTrue($barAssertion->gotCalled());
    }

    public function testAndConditionWillBreakEarlyWithFailure(): void
    {
        $fooAssertion = new SimpleAssertion(false);
        $barAssertion = new SimpleAssertion(true);

        $assertionContainer = $this->getMockBuilder(AssertionPluginManagerInterface::class)->getMock();
        $assertionSet       = new AssertionSet(
            $assertionContainer,
            ['fooFactory', 'barFactory', 'condition' => AssertionSet::CONDITION_AND]
        );

        $assertionContainer->expects($this->once())->method('get')->with('fooFactory')->willReturn($fooAssertion);

        $this->assertFalse($assertionSet->assert('permission'));

        $this->assertTrue($fooAssertion->gotCalled());
        $this->assertFalse($barAssertion->gotCalled());
    }

    public function testOrConditionWillBreakEarlyWithSuccess(): void
    {
        $fooAssertion = new SimpleAssertion(true);
        $barAssertion = new SimpleAssertion(false);

        $assertionContainer = $this->getMockBuilder(AssertionPluginManagerInterface::class)->getMock();
        $assertionSet       = new AssertionSet(
            $assertionContainer,
            ['fooFactory', 'barFactory', 'condition' => AssertionSet::CONDITION_OR]
        );

        $assertionContainer->expects($this->once())->method('get')->with('fooFactory')->willReturn($fooAssertion);

        $this->assertTrue($assertionSet->assert('permission'));

        $this->assertTrue($fooAssertion->gotCalled());
        $this->assertFalse($barAssertion->gotCalled());
    }

    public function testAssertionsAsStringsAreCached(): void
    {
        $fooAssertion = new SimpleAssertion(true);

        $assertionContainer = $this->getMockBuilder(AssertionPluginManagerInterface::class)->getMock();
        $assertionSet       = new AssertionSet($assertionContainer, ['fooFactory']);

        $assertionContainer->expects($this->once())->method('get')->with('fooFactory')->willReturn($fooAssertion);

        $this->assertTrue($assertionSet->assert('permission'));
        $this->assertTrue($assertionSet->assert('permission'));

        $this->assertTrue($fooAssertion->gotCalled());
        $this->assertSame(2, $fooAssertion->calledTimes());
    }

    public function testUsesAssertionsAsStrings(): void
    {
        $fooAssertion = new SimpleAssertion(true);

        $assertionContainer = $this->getMockBuilder(AssertionPluginManagerInterface::class)->getMock();
        $assertionSet       = new AssertionSet($assertionContainer, ['fooFactory']);

        $assertionContainer->expects($this->once())->method('get')->with('fooFactory')->willReturn($fooAssertion);

        $this->assertTrue($assertionSet->assert('permission'));

        $this->assertTrue($fooAssertion->gotCalled());
    }

    public function testUsesAssertionsAsInstances(): void
    {
        $fooAssertion = new SimpleAssertion(true);

        $assertionContainer = $this->createStub(AssertionPluginManagerInterface::class);
        $assertionSet       = new AssertionSet($assertionContainer, [$fooAssertion]);

        $this->assertTrue($assertionSet->assert('permission'));

        $this->assertTrue($fooAssertion->gotCalled());
    }

    public function testUsesAssertionsAsCallables(): void
    {
        $called       = false;
        $fooAssertion = function ($permission, ?IdentityInterface $identity = null, $context = null) use (&$called) {
            $called = true;

            return true;
        };

        $assertionContainer = $this->createStub(AssertionPluginManagerInterface::class);
        $assertionSet       = new AssertionSet($assertionContainer, [$fooAssertion]);

        $this->assertTrue($assertionSet->assert('permission'));

        $this->assertTrue($called);
    }

    public function testUsesAssertionsAsArrays(): void
    {
        $fooAssertion = new SimpleAssertion(true);
        $barAssertion = new SimpleAssertion(true);

        $assertionContainer = $this->createMock(AssertionPluginManagerInterface::class);
        $assertionSet       = new AssertionSet($assertionContainer, ['fooFactory', ['barFactory']]);

        $assertionContainer->expects($this->exactly(2))
            ->method('get')
            ->willReturnCallback(fn (string $key) => match ($key) {
                'fooFactory' => $fooAssertion,
                'barFactory' => $barAssertion,
            });

        $this->assertTrue($assertionSet->assert('permission'));

        $this->assertTrue($fooAssertion->gotCalled());
        $this->assertTrue($barAssertion->gotCalled());
    }

    public function testThrowExceptionForInvalidAssertion(): void
    {
        $fooAssertion = new stdClass();

        $assertionContainer = $this->createStub(AssertionPluginManagerInterface::class);
        $assertionSet       = new AssertionSet($assertionContainer, [$fooAssertion]);

        $this->expectException(InvalidArgumentException::class);
        $this->assertTrue($assertionSet->assert('permission'));
    }

    #[DataProvider('dpMatrix')]
    public function testMatrix(array $assertions, bool $expectedResult, int|array $assertionCalledCount): void
    {
        $assertionContainer = $this->createStub(AssertionPluginManagerInterface::class);
        $assertionSet       = new AssertionSet($assertionContainer, $assertions);

        $this->assertSame($expectedResult, $assertionSet->assert('permission'));

        $this->assertionsCalled($assertions, $assertionCalledCount);
    }

    private function assertionsCalled(array $assertions, int|array $assertionCalledCount): void
    {
        unset($assertions['condition']);
        /** @var array|SimpleAssertion $assertion */
        foreach ($assertions as $key => $assertion) {
            if (is_array($assertion)) {
                $this->assertionsCalled($assertion, $assertionCalledCount[$key]);
            } else {
                $this->assertSame($assertionCalledCount[$key], $assertion->calledTimes());
            }
        }
    }

    public static function dpMatrix(): array
    {
        return [
            // no assertions will fail
            [
                'assertions'           => [],
                'expectedResult'       => false,
                'assertionCalledCount' => [],
            ],

            // one failure, one success
            [
                'assertions'           => ['condition' => AssertionSet::CONDITION_AND, new SimpleAssertion(false)],
                'expectedResult'       => false,
                'assertionCalledCount' => [1],
            ],
            [
                'assertions'           => ['condition' => AssertionSet::CONDITION_AND, new SimpleAssertion(true)],
                'expectedResult'       => true,
                'assertionCalledCount' => [1],
            ],

            // one failure, one success
            [
                'assertions'           => ['condition' => AssertionSet::CONDITION_OR, new SimpleAssertion(false)],
                'expectedResult'       => false,
                'assertionCalledCount' => [1],
            ],
            [
                'assertions'           => ['condition' => AssertionSet::CONDITION_OR, new SimpleAssertion(true)],
                'expectedResult'       => true,
                'assertionCalledCount' => [1],
            ],

            // break early for AND condition with failure
            [
                'assertions'           => [
                    'condition' => AssertionSet::CONDITION_AND,
                    new SimpleAssertion(false),
                    new SimpleAssertion(false),
                ],
                'expectedResult'       => false,
                'assertionCalledCount' => [1, 0],
            ],

            // break early for OR condition with success
            [
                'assertions'           => [
                    'condition' => AssertionSet::CONDITION_OR,
                    new SimpleAssertion(true),
                    new SimpleAssertion(false),
                ],
                'expectedResult'       => true,
                'assertionCalledCount' => [1, 0],
            ],

            // nested assertions
            [
                'assertions'           => [
                    'condition' => AssertionSet::CONDITION_OR,
                    new SimpleAssertion(false),
                    [
                        new SimpleAssertion(true),
                    ],
                ],
                'expectedResult'       => true,
                'assertionCalledCount' => [1, [1]],
            ],
        ];
    }
}
