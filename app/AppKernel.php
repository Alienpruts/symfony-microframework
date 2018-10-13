<?php

/**
 * Created by PhpStorm.
 * User: bert
 * Date: 12/10/18
 * Time: 23:08
 */

use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Bundle\WebProfilerBundle\WebProfilerBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

$loader = require __DIR__ . '/../vendor/autoload.php';
AnnotationRegistry::registerLoader([$loader, 'loadClass']);

class AppKernel extends Kernel{

    use MicroKernelTrait;

    /**
     * Returns an array of bundles to register.
     *
     * @return iterable|\Symfony\Component\HttpKernel\Bundle\BundleInterface An iterable of bundle instances
     */
    public function registerBundles()
    {
        $bundles = [
            new FrameworkBundle(),
            new TwigBundle()
        ];

        if ($this->getEnvironment() == 'dev'){
            $bundles[] = new WebProfilerBundle();
        }

        return $bundles;
    }

    /**
     * Add or import routes into your application.
     *
     *     $routes->import('config/routing.yml');
     *     $routes->add('/admin', 'AppBundle:Admin:dashboard', 'admin_dashboard');
     *
     * @param RouteCollectionBuilder $routes
     */
    protected function configureRoutes(RouteCollectionBuilder $routes)
    {

        // import the WebProfilerRoutes, only if the bundle is enabled
        if (isset($this->bundles['WebProfilerBundle'])) {
            $routes->import('@WebProfilerBundle/Resources/config/routing/wdt.xml', '/_wdt');
            $routes->import('@WebProfilerBundle/Resources/config/routing/profiler.xml', '/_profiler');
        }

        // load the annotation routes
        $routes->import(__DIR__ . '/../src/App/Controller/', '/', 'annotation');
    }

    /**
     * Configures the container.
     *
     * You can register extensions:
     *
     *     $c->loadFromExtension('framework', array(
     *         'secret' => '%secret%'
     *     ));
     *
     * Or services:
     *
     *     $c->register('halloween', 'FooBundle\HalloweenProvider');
     *
     * Or parameters:
     *
     *     $c->setParameter('halloween', 'lot of fun');
     *
     * @param ContainerBuilder $c
     * @param LoaderInterface $loader
     */
    protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config/config.yml');

        if (isset($this->bundles['WebProfilerBundle'])){
            $c->loadFromExtension('web_profiler', [
                'toolbar' => true,
                'intercept_redirects' => false,
            ]);
        }
    }

    /**
     * @inheritdoc
     */
    public function getCacheDir()
    {
        return __DIR__ . '/../cache/' . $this->getEnvironment();
    }

    /**
     * @inheritdoc
     */
    public function getLogDir()
    {
        return __DIR__ . '/../var/logs';
    }
}