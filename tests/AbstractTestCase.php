<?php

/*
 * This file is part of Laravel TestBench.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\TestBench;

use GrahamCampbell\TestBench\AbstractLaravelTestCase;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

/**
 * This is the abstract test case class.
 *
 * @author Graham Campbell <graham@mineuk.com>
 */
abstract class AbstractTestCase extends AbstractLaravelTestCase
{
    /**
     * Get the service provider class.
     *
     * @return string
     */
    protected function getServiceProviderClass()
    {
        return 'GrahamCampbell\Tests\TestBench\ServiceProviderStub';
    }
}

class ServiceProviderStub extends ServiceProvider
{
    protected $defer = false;

    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->bindShared('testbench.foostub', function ($app) {
            return new FooStub('baz');
        });

        $this->app->alias('testbench.foostub', 'GrahamCampbell\Tests\TestBench\FooStub');
    }

    public function provides()
    {
        return [
            'testbench.foostub',
        ];
    }
}

class FooFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'testbench.foostub';
    }
}

class FooStub
{
    protected $bar;

    public function __construct($bar)
    {
        $this->bar = $bar;
    }

    public function getBar()
    {
        return $this->bar;
    }
}

class BarStub
{
    protected $foo;

    public function __construct($foo)
    {
        $this->foo = $foo;
    }

    public function getFoo()
    {
        return $this->foo;
    }
}
