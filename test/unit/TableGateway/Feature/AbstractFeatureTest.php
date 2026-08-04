<?php

declare(strict_types=1);

namespace PhpDbTest\TableGateway\Feature;

use PhpDb\TableGateway\AbstractTableGateway;
use PhpDb\TableGateway\Feature\AbstractFeature;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;

class AbstractFeatureTest extends TestCase
{
    private AbstractFeature&MockObject $feature;

    public function testGetMagicMethodSpecificationsReturnsEmptyArray(): void
    {
        $result = $this->feature->getMagicMethodSpecifications();

        self::assertEmpty($result);
    }

    public function testGetNameReturnsClassName(): void
    {
        $name = $this->feature->getName();

        self::assertNotEmpty($name);
    }

    public function testInitializeDoesNothing(): void
    {
        // initialize() is a no-op, just verify it doesn't throw
        $this->feature->initialize();

        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertTrue(true);
    }

    public function testSetTableGateway(): void
    {
        /** @var AbstractTableGateway&MockObject $tableGateway */
        $tableGateway = $this->getMockBuilder(AbstractTableGateway::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->feature->setTableGateway($tableGateway);

        $reflection = new ReflectionProperty(AbstractFeature::class, 'tableGateway');
        $value      = $reflection->getValue($this->feature);

        self::assertSame($tableGateway, $value);
    }

    protected function setUp(): void
    {
        $this->feature = $this->getMockBuilder(AbstractFeature::class)
            ->disableOriginalConstructor()
            ->onlyMethods([])
            ->getMock();
    }
}
