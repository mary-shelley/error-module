<?php
namespace Corley\ErrorModule;

use PHPUnit\Framework\TestCase;

use Psr\Container\ContainerInterface;
use Whoops\Run;

class ErrorModuleTest extends TestCase
{
    public function testCreateBaseServiceManager()
    {
        $module = new ErrorModule();
        $container = $module->getContainer();
        $this->assertInstanceOf(ContainerInterface::class, $container);
        $this->assertTrue($container->has(Run::class));
    }

    public function testDoesNotCreateServiceManagerOnMissing()
    {
        $module = new ErrorModule(["debug" => false]);
        $container = $module->getContainer();
        $this->assertFalse($container->has(Run::class));
    }
}
