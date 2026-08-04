<?php

declare(strict_types=1);

namespace PhpDb\TableGateway\Feature\EventFeature;

use Laminas\EventManager\EventInterface;
use PhpDb\TableGateway\AbstractTableGateway;

class TableGatewayEvent implements EventInterface
{
    protected ?AbstractTableGateway $target = null;

    protected ?string $name = null;

    protected array|object $params = [];

    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Get a single parameter by name
     *
     * @param string|int $name
     * @param mixed $default Default value to return if parameter does not exist
     */
    public function getParam($name, $default = null): mixed
    {
        return $this->params[$name] ?? $default;
    }

    /**
     * Get parameters passed to the event
     */
    public function getParams(): array|object
    {
        return $this->params;
    }

    /**
     * Get target/context from which event was triggered
     */
    public function getTarget(): ?AbstractTableGateway
    {
        return $this->target;
    }

    /**
     * Has this event indicated event propagation should stop?
     */
    public function propagationIsStopped(): false
    {
        return false;
    }

    /**
     * Set the event name
     *
     * @param string $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * Set a single parameter by key
     *
     * @param string|int $name
     * @param mixed $value
     */
    public function setParam($name, $value): void
    {
        $this->params[$name] = $value;
    }

    /**
     * Set event parameters
     *
     * @param array|object $params
     * @phpstan-ignore selfOut.type
     */
    public function setParams($params): void
    {
        $this->params = $params;
    }

    /**
     * Set the event target/context
     *
     * @param object|string|null $target
     * @phpstan-ignore selfOut.type
     */
    public function setTarget($target): void
    {
        $this->target = $target;
    }

    /**
     * Indicate whether or not the parent EventManagerInterface should stop propagating events
     *
     * @param bool $flag
     */
    public function stopPropagation($flag = true): void {}
}
