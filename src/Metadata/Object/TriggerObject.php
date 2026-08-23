<?php

declare(strict_types=1);

namespace PhpDb\Metadata\Object;

use DateTime;

/**
 * @mago-expect lint:too-many-properties
 */
final class TriggerObject
{
    private ?string $name = null;

    private ?string $eventManipulation = null;

    private ?string $eventObjectCatalog = null;

    private ?string $eventObjectSchema = null;

    private ?string $eventObjectTable = null;

    private ?string $actionOrder = null;

    private ?string $actionCondition = null;

    private ?string $actionStatement = null;

    private ?string $actionOrientation = null;

    private ?string $actionTiming = null;

    private ?string $actionReferenceOldTable = null;

    private ?string $actionReferenceNewTable = null;

    private ?string $actionReferenceOldRow = null;

    private ?string $actionReferenceNewRow = null;

    private ?DateTime $created = null;

    /**
     * Get Action Condition.
     */
    public function getActionCondition(): ?string
    {
        return $this->actionCondition;
    }

    /**
     * Get Action Order.
     */
    public function getActionOrder(): ?string
    {
        return $this->actionOrder;
    }

    /**
     * Get Action Orientation.
     */
    public function getActionOrientation(): ?string
    {
        return $this->actionOrientation;
    }

    /**
     * Get Action Reference New Row.
     */
    public function getActionReferenceNewRow(): ?string
    {
        return $this->actionReferenceNewRow;
    }

    /**
     * Get Action Reference New Table.
     */
    public function getActionReferenceNewTable(): ?string
    {
        return $this->actionReferenceNewTable;
    }

    /**
     * Get Action Reference Old Row.
     */
    public function getActionReferenceOldRow(): ?string
    {
        return $this->actionReferenceOldRow;
    }

    /**
     * Get Action Reference Old Table.
     */
    public function getActionReferenceOldTable(): ?string
    {
        return $this->actionReferenceOldTable;
    }

    /**
     * Get Action Statement.
     */
    public function getActionStatement(): ?string
    {
        return $this->actionStatement;
    }

    /**
     * Get Action Timing.
     */
    public function getActionTiming(): ?string
    {
        return $this->actionTiming;
    }

    /**
     * Get Created.
     */
    public function getCreated(): ?DateTime
    {
        return $this->created;
    }

    /**
     * Get Event Manipulation.
     */
    public function getEventManipulation(): ?string
    {
        return $this->eventManipulation;
    }

    /**
     * Get Event Object Catalog.
     */
    public function getEventObjectCatalog(): ?string
    {
        return $this->eventObjectCatalog;
    }

    /**
     * Get Event Object Schema.
     */
    public function getEventObjectSchema(): ?string
    {
        return $this->eventObjectSchema;
    }

    /**
     * Get Event Object Table.
     */
    public function getEventObjectTable(): ?string
    {
        return $this->eventObjectTable;
    }

    /**
     * Get Name.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set Action Condition.
     */
    public function setActionCondition(?string $actionCondition): static
    {
        $this->actionCondition = $actionCondition;
        return $this;
    }

    /**
     * Set Action Order.
     */
    public function setActionOrder(string $actionOrder): static
    {
        $this->actionOrder = $actionOrder;
        return $this;
    }

    /**
     * Set Action Orientation.
     */
    public function setActionOrientation(string $actionOrientation): static
    {
        $this->actionOrientation = $actionOrientation;
        return $this;
    }

    /**
     * Set Action Reference New Row.
     *
     * @return $this Provides a fluent interface
     */
    public function setActionReferenceNewRow(string $actionReferenceNewRow): static
    {
        $this->actionReferenceNewRow = $actionReferenceNewRow;
        return $this;
    }

    /**
     * Set Action Reference New Table.
     */
    public function setActionReferenceNewTable(?string $actionReferenceNewTable): static
    {
        $this->actionReferenceNewTable = $actionReferenceNewTable;
        return $this;
    }

    /**
     * Set Action Reference Old Row.
     *
     * @return $this Provides a fluent interface
     */
    public function setActionReferenceOldRow(string $actionReferenceOldRow): static
    {
        $this->actionReferenceOldRow = $actionReferenceOldRow;
        return $this;
    }

    /**
     * Set Action Reference Old Table.
     */
    public function setActionReferenceOldTable(?string $actionReferenceOldTable): static
    {
        $this->actionReferenceOldTable = $actionReferenceOldTable;
        return $this;
    }

    /**
     * Set Action Statement.
     */
    public function setActionStatement(string $actionStatement): static
    {
        $this->actionStatement = $actionStatement;
        return $this;
    }

    /**
     * Set Action Timing.
     */
    public function setActionTiming(string $actionTiming): static
    {
        $this->actionTiming = $actionTiming;
        return $this;
    }

    /**
     * Set Created.
     *
     * @return $this Provides a fluent interface
     */
    public function setCreated(?DateTime $created): static
    {
        $this->created = $created;
        return $this;
    }

    /**
     * Set Event Manipulation.
     */
    public function setEventManipulation(string $eventManipulation): static
    {
        $this->eventManipulation = $eventManipulation;
        return $this;
    }

    /**
     * Set Event Object Catalog.
     */
    public function setEventObjectCatalog(string $eventObjectCatalog): static
    {
        $this->eventObjectCatalog = $eventObjectCatalog;
        return $this;
    }

    /**
     * Set Event Object Schema.
     */
    public function setEventObjectSchema(string $eventObjectSchema): static
    {
        $this->eventObjectSchema = $eventObjectSchema;
        return $this;
    }

    /**
     * Set Event Object Table.
     */
    public function setEventObjectTable(string $eventObjectTable): static
    {
        $this->eventObjectTable = $eventObjectTable;
        return $this;
    }

    /**
     * Set Name.
     */
    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }
}
