<?php
namespace Corley\ErrorModule;

use Corley\Modular\Module\ModuleInterface;
use Psr\Container\ContainerInterface;
use DI\ContainerBuilder;
use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;
use Zend\ServiceManager\ServiceManager;

class ErrorModule implements ModuleInterface
{
    private $options;

    public function __construct(array $options = [])
    {
        $this->options = array_replace_recursive([
            "debug" => true,
        ], $options);
    }

    public function getContainer()
    {
        $service = new ServiceManager();
        $service->setService("error_handler", [$this, "exposeError"]);

        if ($this->options["debug"]) {
            $whoops = new Run;
            $whoops->pushHandler(new PrettyPageHandler());
            $whoops->register();

            $service->setService(Run::class, $whoops);
        }

        return $service;
    }

    public function exposeError($request, $response, $exception)
    {
        if (!$this->options["debug"]) {
            return;
        }

        throw $exception;
    }
}
