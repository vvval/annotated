<?php declare(strict_types=1);
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Cycle\Annotated\Tests\Relation;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\RefersTo;
use Cycle\Annotated\Annotation\Table;
use Cycle\Annotated\Columns;
use Cycle\Annotated\Entities;
use Cycle\Annotated\Indexes;
use Cycle\Annotated\Tests\BaseTest;
use Cycle\ORM\Relation;
use Cycle\ORM\Schema;
use Cycle\Schema\Compiler;
use Cycle\Schema\Generator\GenerateRelations;
use Cycle\Schema\Generator\GenerateTypecast;
use Cycle\Schema\Generator\RenderRelations;
use Cycle\Schema\Generator\RenderTables;
use Cycle\Schema\Generator\ResetTables;
use Cycle\Schema\Generator\SyncTables;
use Cycle\Schema\Registry;
use Cycle\Schema\Relation\RefersTo as RefersToRelation;
use Spiral\Annotations\Parser;

abstract class RefersToTest extends BaseTest
{
    public function testRelation()
    {
        $p = new Parser();
        $p->register(new Entity());
        $p->register(new Column());
        $p->register(new Table());
        $p->register(new RefersTo());

        $r = new Registry($this->dbal);

        $schema = (new Compiler())->compile($r, [
            new Entities($this->locator, $p),
            new ResetTables(),
            new Columns($p),
            new GenerateRelations(['refersTo' => new RefersToRelation()]),
            new RenderTables(),
            new RenderRelations(),
            new Indexes($p),
            new SyncTables(),
            new GenerateTypecast(),
        ]);

        $this->assertArrayHasKey('parent', $schema['simple'][Schema::RELATIONS]);
        $this->assertSame(Relation::REFERS_TO, $schema['simple'][Schema::RELATIONS]['parent'][Relation::TYPE]);
        $this->assertSame("simple", $schema['simple'][Schema::RELATIONS]['parent'][Relation::TARGET]);

        $this->assertSame(
            'NO ACTION',
            $this->dbal->database('default')
                       ->getDriver()
                       ->getSchema('simples')
                       ->foreignKey('parent_id')
                       ->getDeleteRule()
        );
    }
}