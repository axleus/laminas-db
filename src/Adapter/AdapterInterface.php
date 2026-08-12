<?php

declare(strict_types=1);

namespace PhpDb\Adapter;

use PhpDb\ResultSet;

/**
 * @property Driver\DriverInterface $driver
 * @property Platform\PlatformInterface $platform
 */
interface AdapterInterface
{
    /**
     * Query Mode Constants
     */
    public const QUERY_MODE_EXECUTE = 'execute';
    public const QUERY_MODE_PREPARE = 'prepare';

    /**
     * Prepare Type Constants
     */
    public const PREPARE_TYPE_POSITIONAL = 'positional';
    public const PREPARE_TYPE_NAMED      = 'named';

    public const FUNCTION_FORMAT_PARAMETER_NAME = 'formatParameterName';
    public const FUNCTION_QUOTE_IDENTIFIER      = 'quoteIdentifier';
    public const FUNCTION_QUOTE_VALUE           = 'quoteValue';

    public const VALUE_QUOTE_SEPARATOR = 'quoteSeparator';

    public function getDriver(): Driver\DriverInterface;

    public function getPlatform(): Platform\PlatformInterface;

    public function getProfiler(): ?Profiler\ProfilerInterface;

    public function getQueryResultSetPrototype(): ResultSet\ResultSetInterface;

    public function createStatement(
        ?string $initialSql = null,
        ParameterContainer|array $initialParameters = []
    ): Driver\StatementInterface;

    public function query(
        string $sql,
        ParameterContainer|array|string $parametersOrQueryMode = self::QUERY_MODE_PREPARE,
        ?ResultSet\ResultSetInterface $resultPrototype = null
    ): Driver\StatementInterface|ResultSet\ResultSetInterface|Driver\ResultInterface;

    /**
     * Prepares a statement for the given SQL without executing it.
     */
    public function prepareQuery(
        string $sql,
        ParameterContainer|array $parameters = []
    ): Driver\StatementInterface;

    /**
     * Executes raw SQL or a prepared statement.
     *
     * @throws Exception\RuntimeException When execution did not produce a result.
     */
    public function executeQuery(Driver\StatementInterface|string $sql): Driver\ResultInterface;

    /**
     * @todo 0.3.x track down this usage!!!
     * @return array
     */
    public function getHelpers();
}
