<?php declare(strict_types=1);
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Cycle\Annotated\Tests\Fixtures2;

/**
 * @entity
 */
class Simple implements MarkedInterface
{
    /**
     * @column(type=primary)
     * @var int
     */
    protected $id;
}