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
class User implements MarkedInterface
{
    /**
     * @column(type=primary)
     * @var int
     */
    protected $id;

    /**
     * @hasOne(target=Simple, inverse=(as="user", type=belongsTo))
     * @var Simple
     */
    protected $simple;
}