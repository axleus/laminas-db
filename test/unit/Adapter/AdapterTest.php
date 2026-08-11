<?php

declare(strict_types=1);

namespace PhpDbTest\Adapter;

use Override;
use PhpDb\Adapter\Adapter;
use PhpDb\Adapter\AdapterInterface;
use PhpDb\Adapter\Driver\ConnectionInterface;
use PhpDb\Adapter\Driver\DriverInterface;
use PhpDb\Adapter\Driver\ResultInterface;
use PhpDb\Adapter\Driver\StatementInterface;
use PhpDb\Adapter\Exception\InvalidArgumentException;
use PhpDb\Adapter\Exception\RuntimeException;
use PhpDb\Adapter\Exception\VunerablePlatformQuoteException;
use PhpDb\Adapter\ParameterContainer;
use PhpDb\Adapter\Platform\PlatformInterface;
use PhpDb\Adapter\Profiler;
use PhpDb\ResultSet\ResultSet;
use PhpDb\ResultSet\ResultSetInterface;
use PhpDbTest\TestAsset\TemporaryResultSet;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

#[CoversMethod(Adapter::class, 'setProfiler')]
#[CoversMethod(Adapter::class, 'getProfiler')]
#[CoversMethod(Adapter::class, 'getDriver')]
#[CoversMethod(Adapter::class, 'getPlatform')]
#[CoversMethod(Adapter::class, 'getQueryResultSetPrototype')]
#[CoversMethod(Adapter::class, 'getCurrentSchema')]
#[CoversMethod(Adapter::class, 'query')]
#[CoversMethod(Adapter::class, 'prepareQuery')]
#[CoversMethod(Adapter::class, 'executeQuery')]
#[CoversMethod(Adapter::class, 'createStatement')]
#[CoversMethod(Adapter::class, '__get')]
#[CoversMethod(Adapter::class, '__construct')]
#[CoversMethod(Adapter::class, 'getHelpers')]
#[Group('unit')]
final class AdapterTest extends TestCase
{
    protected DriverInterface&MockObject $mockDriver;

    protected PlatformInterface&MockObject $mockPlatform;

    protected ConnectionInterface&MockObject $mockConnection;

    protected StatementInterface&MockObject $mockStatement;

    protected Adapter $adapter;

    /**
     * @throws Exception
     */
    #[Override]
    protected function setUp(): void
    {
        $this->mockDriver     = $this->createMock(DriverInterface::class);
        $this->mockConnection = $this->createMock(ConnectionInterface::class);
        $this->mockDriver->method('checkEnvironment')->willReturn(true);
        $this->mockDriver->method('getConnection')
                         ->willReturn($this->mockConnection);
        $this->mockPlatform  = $this->createMock(PlatformInterface::class);
        $this->mockStatement = $this->createMock(StatementInterface::class);
        $this->mockDriver->method('createStatement')
                         ->willReturn($this->mockStatement);

        $this->adapter = new Adapter($this->mockDriver, $this->mockPlatform);
    }

    #[TestDox('unit test: Test setProfiler() will store profiler')]
    public function testFluentSetProfiler(): void
    {
        $ret = $this->adapter->setProfiler(new Profiler\Profiler());
        self::assertSame($this->adapter, $ret);
    }

    #[TestDox('unit test: Test getProfiler() will store profiler')]
    public function testGetProfilerReturnsProfiler(): void
    {
        $this->adapter->setProfiler($profiler = new Profiler\Profiler());
        self::assertSame($profiler, $this->adapter->getProfiler());

        $adapter = new Adapter(
            driver: $this->mockDriver,
            platform: $this->mockPlatform,
            profiler: new Profiler\Profiler(),
        );
        self::assertInstanceOf(Profiler\Profiler::class, $adapter->getProfiler());
    }

    #[TestDox('unit test: Test getDriver() will return driver object')]
    public function testGetDriverReturnsDriver(): void
    {
        self::assertSame($this->mockDriver, $this->adapter->getDriver());
    }

    #[TestDox('unit test: Test getPlatform() returns platform object')]
    public function testGetPlatformReturnsPlatform(): void
    {
        self::assertSame($this->mockPlatform, $this->adapter->getPlatform());
    }

    #[TestDox('unit test: Test getPlatform() returns platform object')]
    public function testGetQueryResultSetPrototypeReturnsResultSet(): void
    {
        self::assertInstanceOf(ResultSetInterface::class, $this->adapter->getQueryResultSetPrototype());
    }

    #[TestDox('unit test: Test getCurrentSchema() returns current schema from connection object')]
    public function testGetCurrentSchemaDelegatesToConnection(): void
    {
        $this->mockConnection->expects($this->any())->method('getCurrentSchema')->willReturn('FooSchema');
        self::assertEquals('FooSchema', $this->adapter->getCurrentSchema());
    }

    /**
     * @throws \Exception
     */
    #[TestDox('unit test: Test query() in prepare mode produces a statement object')]
    public function testQueryWhenPreparedProducesStatement(): void
    {
        $s = $this->adapter->query('SELECT foo');
        self::assertSame($this->mockStatement, $s);
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    #[Group('#210')]
    public function testProducedResultSetPrototypeIsDifferentForEachQuery(): void
    {
        $result = $this->createMock(ResultInterface::class);

        $this->mockStatement->method('execute')
                            ->willReturn($result);
        $result->method('isQueryResult')
               ->willReturn(true);
        $result->method('getQueryResult')
               ->willReturnCallback(static fn (): ResultSetInterface => new ResultSet());

        self::assertNotSame(
            $this->adapter->query('SELECT foo', []),
            $this->adapter->query('SELECT foo', [])
        );
    }

    /**
     * @throws \Exception
     */
    #[TestDox('unit test: Test query() in prepare mode, with array of parameters, produces a result object')]
    public function testQueryWhenPreparedWithParameterArrayProducesResult(): void
    {
        $parray = ['bar' => 'foo'];
        $sql    = 'SELECT foo, :bar';
        $result = $this->getMockBuilder(ResultInterface::class)->getMock();
        $this->mockStatement->expects($this->any())->method('execute')->willReturn($result);
        $result->expects($this->any())->method('isQueryResult')->willReturn(false);

        $r = $this->adapter->query($sql, $parray);
        self::assertSame($result, $r);
    }

    /**
     * @throws \Exception
     */
    #[TestDox('unit test: Test query() in prepare mode, with ParameterContainer, produces a result object')]
    public function testQueryWhenPreparedWithParameterContainerProducesResult(): void
    {
        $sql                = 'SELECT foo';
        $parameterContainer = $this->getMockBuilder(ParameterContainer::class)->getMock();
        $result             = $this->getMockBuilder(ResultInterface::class)->getMock();
        $this->mockDriver->expects($this->any())->method('createStatement')
                         ->with($sql)->willReturn($this->mockStatement);
        $this->mockStatement->expects($this->any())->method('execute')->willReturn($result);
        $result->expects($this->any())->method('isQueryResult')->willReturn(true);
        $result->expects($this->any())->method('getQueryResult')->willReturn(new ResultSet());

        $r = $this->adapter->query($sql, $parameterContainer);
        self::assertInstanceOf(ResultSet::class, $r);
    }

    /**
     * @throws \Exception
     */
    #[TestDox('unit test: Test query() in execute mode produces a driver result object')]
    public function testQueryWhenExecutedProducesAResult(): void
    {
        $sql    = 'SELECT foo';
        $result = $this->getMockBuilder(ResultInterface::class)->getMock();
        $this->mockConnection->expects($this->any())->method('execute')->with($sql)->willReturn($result);
        $result->expects($this->any())->method('isQueryResult')->willReturn(false);

        $r = $this->adapter->query($sql, AdapterInterface::QUERY_MODE_EXECUTE);
        self::assertSame($result, $r);
    }

    /**
     * @throws \Exception
     */
    #[TestDox('unit test: Test query() in execute mode produces a resultset object')]
    public function testQueryWhenExecutedProducesAResultSetObjectWhenResultIsQuery(): void
    {
        $sql = 'SELECT foo';

        $result = $this->getMockBuilder(ResultInterface::class)->getMock();
        $this->mockConnection->expects($this->any())->method('execute')->with($sql)->willReturn($result);
        $result->expects($this->any())->method('isQueryResult')->willReturn(true);
        $result->expects($this->any())
               ->method('getQueryResult')
               ->willReturnCallback(
                   static function (?ResultSetInterface $resultPrototype = null): ResultSetInterface {
                       $resultPrototype ??= new ResultSet();

                       return clone $resultPrototype;
                   }
               );

        $r = $this->adapter->query($sql, AdapterInterface::QUERY_MODE_EXECUTE);
        self::assertInstanceOf(ResultSet::class, $r);

        $r = $this->adapter->query($sql, AdapterInterface::QUERY_MODE_EXECUTE, new TemporaryResultSet());
        self::assertInstanceOf(TemporaryResultSet::class, $r);
    }

    #[TestDox('unit test: Test prepareQuery() prepares a statement without executing it')]
    public function testPrepareQueryPreparesStatementWithoutExecuting(): void
    {
        $this->mockStatement->expects($this->once())->method('prepare');
        $this->mockStatement->expects($this->never())->method('execute');

        $statement = $this->adapter->prepareQuery('SELECT foo');

        self::assertSame($this->mockStatement, $statement);
    }

    #[TestDox('unit test: Test prepareQuery() binds an array of parameters as a ParameterContainer')]
    public function testPrepareQueryBindsParameterArray(): void
    {
        $this->mockStatement->expects($this->once())
            ->method('setParameterContainer')
            ->with(self::callback(
                static fn (ParameterContainer $container): bool => $container->getNamedArray() === ['bar' => 'foo']
            ));

        $this->adapter->prepareQuery('SELECT foo, :bar', ['bar' => 'foo']);
    }

    #[TestDox('unit test: Test prepareQuery() binds a ParameterContainer directly')]
    public function testPrepareQueryBindsParameterContainerDirectly(): void
    {
        $parameterContainer = new ParameterContainer(['bar' => 'foo']);

        $this->mockStatement->expects($this->once())
            ->method('setParameterContainer')
            ->with($parameterContainer);

        $this->adapter->prepareQuery('SELECT foo, :bar', $parameterContainer);
    }

    #[TestDox('unit test: Test executeQuery() with raw SQL delegates to connection execute')]
    public function testExecuteQueryWithRawSqlDelegatesToConnectionExecute(): void
    {
        $sql    = 'SELECT foo';
        $result = $this->createMock(ResultInterface::class);
        $this->mockConnection->expects($this->once())->method('execute')->with($sql)->willReturn($result);

        self::assertSame($result, $this->adapter->executeQuery($sql));
    }

    #[TestDox('unit test: Test executeQuery() with a prepared statement executes the statement')]
    public function testExecuteQueryWithStatementExecutesStatement(): void
    {
        $result = $this->createMock(ResultInterface::class);
        $this->mockStatement->expects($this->once())->method('execute')->willReturn($result);
        $this->mockConnection->expects($this->never())->method('execute');

        self::assertSame($result, $this->adapter->executeQuery($this->mockStatement));
    }

    #[TestDox('unit test: Test executeQuery() returns the raw result without wrapping query results')]
    public function testExecuteQueryReturnsRawResultWithoutWrappingQueryResults(): void
    {
        $sql    = 'SELECT foo';
        $result = $this->createMock(ResultInterface::class);

        $this->mockConnection->method('execute')->willReturn($result);
        $result->expects($this->any())->method('isQueryResult')->willReturn(true);
        $result->expects($this->never())->method('getQueryResult');

        self::assertSame($result, $this->adapter->executeQuery($sql));
    }

    #[TestDox('unit test: Test executeQuery() throws when execution does not produce a result')]
    public function testExecuteQueryThrowsWhenExecutionDoesNotProduceAResult(): void
    {
        $sql = 'SELECT foo';
        $this->mockConnection->method('execute')->willReturn(null);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Query execution did not produce a result');

        $this->adapter->executeQuery($sql);
    }

    #[TestDox('unit test: Test createStatement() produces a statement object')]
    public function testCreateStatementDelegatesToDriver(): void
    {
        self::assertSame($this->mockStatement, $this->adapter->createStatement());
    }

    public function testMagicGetReturnsDriverAndPlatformCaseInsensitively(): void
    {
        self::assertSame($this->mockDriver, $this->adapter->driver);
        /** @phpstan-ignore property.notFound */
        self::assertSame($this->mockDriver, $this->adapter->DrivER);
        /** @phpstan-ignore property.notFound */
        self::assertSame($this->mockPlatform, $this->adapter->PlatForm);
        self::assertSame($this->mockPlatform, $this->adapter->platform);

        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Invalid magic');
        /** @phpstan-ignore property.notFound, expr.resultUnused */
        $this->adapter->foo;
    }

    public function testGetHelpersReturnsQuoteIdentifierFunction(): void
    {
        $functions = $this->adapter->getHelpers(Adapter::FUNCTION_QUOTE_IDENTIFIER);

        self::assertCount(1, $functions);
        self::assertIsCallable($functions[0]);
    }

    public function testGetHelpersReturnsQuoteValueFunction(): void
    {
        $functions = $this->adapter->getHelpers(Adapter::FUNCTION_QUOTE_VALUE);

        self::assertCount(1, $functions);
        self::assertIsCallable($functions[0]);
    }

    public function testGetHelpersReturnsBothFunctions(): void
    {
        $functions = $this->adapter->getHelpers(
            Adapter::FUNCTION_QUOTE_IDENTIFIER,
            Adapter::FUNCTION_QUOTE_VALUE
        );

        self::assertCount(2, $functions);
        self::assertIsCallable($functions[0]);
        self::assertIsCallable($functions[1]);
    }

    public function testConstructorWithProfilerDelegatesToSetProfiler(): void
    {
        $profilerMock = $this->createMock(Profiler\ProfilerInterface::class);
        $driverMock   = $this->createMock(DriverInterface::class);
        $platformMock = $this->createMock(PlatformInterface::class);

        $adapter = new Adapter(
            driver: $driverMock,
            platform: $platformMock,
            profiler: $profilerMock,
        );

        self::assertSame($profilerMock, $adapter->getProfiler());
    }

    public function testQueryThrowsOnInvalidParameterType(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Parameter 2 to this method must be a flag, an array, or ParameterContainer');

        $this->adapter->query('SELECT 1', 'invalid_mode');
    }

    public function testSetProfilerDelegatesToDriverWhenProfilerAware(): void
    {
        $profiler = $this->createMock(Profiler\ProfilerInterface::class);
        $driver   = $this->createMockForIntersectionOfInterfaces(
            [DriverInterface::class, Profiler\ProfilerAwareInterface::class]
        );
        $driver->expects($this->once())->method('setProfiler')->with($profiler);

        $platform = $this->createMock(PlatformInterface::class);
        $adapter  = new Adapter(driver: $driver, platform: $platform);

        $adapter->setProfiler($profiler);
    }

    public function testGetHelpersQuoteIdentifierClosureCallsPlatform(): void
    {
        $this->mockPlatform->method('quoteIdentifier')
            ->with('test')
            ->willReturn('"test"');

        $functions = $this->adapter->getHelpers(Adapter::FUNCTION_QUOTE_IDENTIFIER);
        $result    = $functions[0]('test');

        self::assertSame('"test"', $result);
    }

    public function testGetHelpersQuoteValueClosureCallsPlatform(): void
    {
        $this->mockPlatform->method('quoteValue')
            ->with('test')
            ->willThrowException(VunerablePlatformQuoteException::forPlatformAndMethod('test', 'test'));

        $functions = $this->adapter->getHelpers(Adapter::FUNCTION_QUOTE_VALUE);

        $this->expectException(VunerablePlatformQuoteException::class);
        $functions[0]('test');
    }
}
