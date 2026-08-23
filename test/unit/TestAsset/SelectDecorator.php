<?php

declare(strict_types=1);

namespace PhpDbTest\TestAsset;

use PhpDb\Sql;

final class SelectDecorator extends Sql\Select implements Sql\Platform\PlatformDecoratorInterface
{
    /**
     * @return $this Provides a fluent interface
     */
    public function setSubject(?object $subject): self
    {
        $this->subject = $subject;
        return $this;
    }
}
