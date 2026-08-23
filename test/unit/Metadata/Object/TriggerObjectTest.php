<?php

declare(strict_types=1);

namespace PhpDbTest\Metadata\Object;

use DateTime;
use PhpDb\Metadata\Object\TriggerObject;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class TriggerObjectTest extends TestCase
{
    #[Test]
    public function completeTriggerObject(): void
    {
        $trigger = new TriggerObject();
        $created = new DateTime('2025-11-13 10:30:00');

        $trigger->setName('audit_trigger')
            ->setEventManipulation('UPDATE')
            ->setEventObjectCatalog('main_catalog')
            ->setEventObjectSchema('public')
            ->setEventObjectTable('orders')
            ->setActionOrder('1')
            ->setActionCondition('WHEN (OLD.status != NEW.status)')
            ->setActionStatement('BEGIN INSERT INTO audit_log VALUES (OLD.id, NOW()); END')
            ->setActionOrientation('ROW')
            ->setActionTiming('AFTER')
            ->setActionReferenceOldTable('old_orders')
            ->setActionReferenceNewTable('new_orders')
            ->setActionReferenceOldRow('OLD')
            ->setActionReferenceNewRow('NEW')
            ->setCreated($created);

        // Verify all properties are set correctly
        static::assertSame('audit_trigger', $trigger->getName());
        static::assertSame('UPDATE', $trigger->getEventManipulation());
        static::assertSame('main_catalog', $trigger->getEventObjectCatalog());
        static::assertSame('public', $trigger->getEventObjectSchema());
        static::assertSame('orders', $trigger->getEventObjectTable());
        static::assertSame('1', $trigger->getActionOrder());
        static::assertSame('WHEN (OLD.status != NEW.status)', $trigger->getActionCondition());
        static::assertSame('BEGIN INSERT INTO audit_log VALUES (OLD.id, NOW()); END', $trigger->getActionStatement());
        static::assertSame('ROW', $trigger->getActionOrientation());
        static::assertSame('AFTER', $trigger->getActionTiming());
        static::assertSame('old_orders', $trigger->getActionReferenceOldTable());
        static::assertSame('new_orders', $trigger->getActionReferenceNewTable());
        static::assertSame('OLD', $trigger->getActionReferenceOldRow());
        static::assertSame('NEW', $trigger->getActionReferenceNewRow());
        static::assertSame($created, $trigger->getCreated());
    }

    #[Test]
    public function nullValuesForAllProperties(): void
    {
        $trigger = new TriggerObject();

        // Verify all properties default to null
        static::assertNull($trigger->getName());
        static::assertNull($trigger->getEventManipulation());
        static::assertNull($trigger->getEventObjectCatalog());
        static::assertNull($trigger->getEventObjectSchema());
        static::assertNull($trigger->getEventObjectTable());
        static::assertNull($trigger->getActionOrder());
        static::assertNull($trigger->getActionCondition());
        static::assertNull($trigger->getActionStatement());
        static::assertNull($trigger->getActionOrientation());
        static::assertNull($trigger->getActionTiming());
        static::assertNull($trigger->getActionReferenceOldTable());
        static::assertNull($trigger->getActionReferenceNewTable());
        static::assertNull($trigger->getActionReferenceOldRow());
        static::assertNull($trigger->getActionReferenceNewRow());
        static::assertNull($trigger->getCreated());
    }

    #[Test]
    public function setActionConditionAndGetActionConditionWithFluentInterface(): void
    {
        $trigger = new TriggerObject();

        // Verify fluent interface and value update
        $result = $trigger->setActionCondition('WHEN (NEW.amount > 100)');
        static::assertSame($trigger, $result);
        static::assertSame('WHEN (NEW.amount > 100)', $trigger->getActionCondition());
    }

    #[Test]
    public function setActionOrderAndGetActionOrderWithFluentInterface(): void
    {
        $trigger = new TriggerObject();

        // Verify fluent interface and value update
        $result = $trigger->setActionOrder('1');
        static::assertSame($trigger, $result);
        static::assertSame('1', $trigger->getActionOrder());
    }

    #[Test]
    public function setActionOrientationAndGetActionOrientationWithFluentInterface(): void
    {
        $trigger = new TriggerObject();

        // Verify fluent interface and value update
        $result = $trigger->setActionOrientation('ROW');
        static::assertSame($trigger, $result);
        static::assertSame('ROW', $trigger->getActionOrientation());
    }

    #[Test]
    public function setActionReferenceNewRowAndGetActionReferenceNewRowWithFluentInterface(): void
    {
        $trigger = new TriggerObject();

        // Verify fluent interface and value update
        $result = $trigger->setActionReferenceNewRow('NEW');
        static::assertSame($trigger, $result);
        static::assertSame('NEW', $trigger->getActionReferenceNewRow());
    }

    #[Test]
    public function setActionReferenceNewTableAndGetActionReferenceNewTableWithFluentInterface(): void
    {
        $trigger = new TriggerObject();

        // Verify fluent interface and value update
        $result = $trigger->setActionReferenceNewTable('new_table');
        static::assertSame($trigger, $result);
        static::assertSame('new_table', $trigger->getActionReferenceNewTable());
    }

    #[Test]
    public function setActionReferenceOldRowAndGetActionReferenceOldRowWithFluentInterface(): void
    {
        $trigger = new TriggerObject();

        // Verify fluent interface and value update
        $result = $trigger->setActionReferenceOldRow('OLD');
        static::assertSame($trigger, $result);
        static::assertSame('OLD', $trigger->getActionReferenceOldRow());
    }

    #[Test]
    public function setActionReferenceOldTableAndGetActionReferenceOldTableWithFluentInterface(): void
    {
        $trigger = new TriggerObject();

        // Verify fluent interface and value update
        $result = $trigger->setActionReferenceOldTable('old_table');
        static::assertSame($trigger, $result);
        static::assertSame('old_table', $trigger->getActionReferenceOldTable());
    }

    #[Test]
    public function setActionStatementAndGetActionStatementWithFluentInterface(): void
    {
        $trigger = new TriggerObject();

        // Verify fluent interface and value update
        $result = $trigger->setActionStatement('BEGIN ... END');
        static::assertSame($trigger, $result);
        static::assertSame('BEGIN ... END', $trigger->getActionStatement());
    }

    #[Test]
    public function setActionTimingAndGetActionTimingWithFluentInterface(): void
    {
        $trigger = new TriggerObject();

        // Verify fluent interface and value update
        $result = $trigger->setActionTiming('BEFORE');
        static::assertSame($trigger, $result);
        static::assertSame('BEFORE', $trigger->getActionTiming());
    }

    #[Test]
    public function setCreatedAndGetCreatedWithFluentInterface(): void
    {
        $trigger  = new TriggerObject();
        $dateTime = new DateTime('2025-01-01 12:00:00');

        // Verify fluent interface and value update
        $result = $trigger->setCreated($dateTime);
        static::assertSame($trigger, $result);
        static::assertSame($dateTime, $trigger->getCreated());
    }

    #[Test]
    public function setCreatedWithDifferentDateTime(): void
    {
        $trigger   = new TriggerObject();
        $dateTime1 = new DateTime('2025-01-01 12:00:00');
        $dateTime2 = new DateTime('2025-12-31 23:59:59');

        // Set first datetime and verify
        $trigger->setCreated($dateTime1);
        static::assertSame($dateTime1, $trigger->getCreated());

        // Update to second datetime and verify
        $trigger->setCreated($dateTime2);
        static::assertSame($dateTime2, $trigger->getCreated());
    }

    #[Test]
    public function setEventManipulationAndGetEventManipulationWithFluentInterface(): void
    {
        $trigger = new TriggerObject();

        // Verify fluent interface and value update
        $result = $trigger->setEventManipulation('INSERT');
        static::assertSame($trigger, $result);
        static::assertSame('INSERT', $trigger->getEventManipulation());
    }

    #[Test]
    public function setEventObjectCatalogAndGetEventObjectCatalogWithFluentInterface(): void
    {
        $trigger = new TriggerObject();

        // Verify fluent interface and value update
        $result = $trigger->setEventObjectCatalog('catalog_name');
        static::assertSame($trigger, $result);
        static::assertSame('catalog_name', $trigger->getEventObjectCatalog());
    }

    #[Test]
    public function setEventObjectSchemaAndGetEventObjectSchemaWithFluentInterface(): void
    {
        $trigger = new TriggerObject();

        // Verify fluent interface and value update
        $result = $trigger->setEventObjectSchema('schema_name');
        static::assertSame($trigger, $result);
        static::assertSame('schema_name', $trigger->getEventObjectSchema());
    }

    #[Test]
    public function setEventObjectTableAndGetEventObjectTableWithFluentInterface(): void
    {
        $trigger = new TriggerObject();

        // Verify fluent interface and value update
        $result = $trigger->setEventObjectTable('table_name');
        static::assertSame($trigger, $result);
        static::assertSame('table_name', $trigger->getEventObjectTable());
    }

    #[Test]
    public function setNameAndGetNameWithFluentInterface(): void
    {
        $trigger = new TriggerObject();

        // Verify fluent interface and value update
        $result = $trigger->setName('trigger_name');
        static::assertSame($trigger, $result);
        static::assertSame('trigger_name', $trigger->getName());

        // Verify mutation with different name
        $trigger->setName('updated_trigger');
        static::assertSame('updated_trigger', $trigger->getName());
    }
}
