<?php

/**
 * This file is part of the Edoger framework.
 *
 * @author    Qingshan Luo <shanshan.lqs@gmail.com>
 * @copyright 2017 Qingshan Luo
 * @license   GNU Lesser General Public License 3.0
 */

namespace Edoger\Http\Tests\Cases\Foundation;

use Edoger\Container\Collection as CollectionContainer;
use Edoger\Http\Foundation\Collection;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    public function testCollectionExtendsCollectionContainer()
    {
        $collection = new Collection();

        $this->assertInstanceOf(CollectionContainer::class, $collection);
    }

    public function testCollectionHasAny()
    {
        $collection = new Collection(['test' => 'test']);

        $this->assertTrue($collection->hasAny(['foo', 'test']));
        $this->assertTrue($collection->hasAny(['bar', 'test']));
        $this->assertFalse($collection->hasAny(['bar', 'foo']));
        $this->assertTrue($collection->hasAny(new Collection(['foo', 'test'])));
        $this->assertTrue($collection->hasAny(new Collection(['bar', 'test'])));
        $this->assertFalse($collection->hasAny(new Collection(['bar', 'foo'])));
        $this->assertTrue($collection->hasAny(new CollectionContainer(['foo', 'test'])));
        $this->assertTrue($collection->hasAny(new CollectionContainer(['bar', 'test'])));
        $this->assertFalse($collection->hasAny(new CollectionContainer(['bar', 'foo'])));
    }

    public function testCollectionGetAny()
    {
        $collection = new Collection(['test' => 'test']);

        $this->assertEquals('test', $collection->getAny(['foo', 'test']));
        $this->assertEquals('test', $collection->getAny(['bar', 'test']));
        $this->assertNull($collection->getAny(['bar', 'foo']));
        $this->assertEquals('test', $collection->getAny(['bar', 'foo'], 'test'));
        $this->assertEquals('test', $collection->getAny(new Collection(['foo', 'test'])));
        $this->assertEquals('test', $collection->getAny(new Collection(['bar', 'test'])));
        $this->assertEquals('test', $collection->getAny(new Collection(['bar', 'foo']), 'test'));
        $this->assertEquals('test', $collection->getAny(new CollectionContainer(['foo', 'test'])));
        $this->assertEquals('test', $collection->getAny(new CollectionContainer(['bar', 'test'])));
        $this->assertEquals('test', $collection->getAny(new CollectionContainer(['bar', 'foo']), 'test'));
    }
}
