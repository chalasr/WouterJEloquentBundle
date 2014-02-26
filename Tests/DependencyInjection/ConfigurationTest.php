<?php

namespace Wj\EloquentBundle\Tests\DependencyInjection;

use Wj\EloquentBundle\DependencyInjection as DI;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionConfigurationTestCase;

class ConfigurationTest extends AbstractExtensionConfigurationTestCase
{
    protected function getContainerExtension()
    {
        return new DI\WjEloquentExtension();
    }

    protected function getConfiguration()
    {
        return new DI\Configuration();
    }

    /**
     * @test
     * @dataProvider provideFormattingData
     */
    public function it_works_with_different_formats($source, $expectedConfiguration)
    {
        $this->assertProcessedConfigurationEquals($expectedConfiguration, array($source));
    }

    public function provideFormattingData()
    {
        $expected1 = array(
            'connections' => array(),
            'eloquent' => array('enabled' => false),
            'default_connection' => null,
        );
        $expected2 = array(
            'connections' => array(
                'default' => array(
                    'driver' => 'mysql',
                    'host' => 'localhost',
                    'database' => 'database',
                    'username' => 'root',
                    'password' => '',
                    'charset' => 'utf8',
                    'collation' => 'utf8_unicode_ci',
                    'prefix' => '',
                ),
            ),
            'default_connection' => 'default',
            'eloquent' => array('enabled' => false),
        );
        $expected3 = array(
            'connections' => array(
                'default' => array(
                    'driver' => 'sqlite',
                    'host' => 'local',
                    'database' => 'foo.db',
                    'username' => 'user',
                    'password' => 'pass',
                    'charset' => 'utf8',
                    'collation' => 'utf8_unicode_ci',
                    'prefix' => 'symfo_',
                ),
            ),
            'default_connection' => 'default',
            'eloquent' => array('enabled' => true),
        );
        $expected4 = array(
            'connections' => array(
                'default' => array(
                    'driver' => 'mysql',
                    'host' => 'localhost',
                    'database' => 'database',
                    'username' => 'root',
                    'password' => '',
                    'charset' => 'utf8',
                    'collation' => 'utf8_unicode_ci',
                    'prefix' => '',
                ),
                'foo' => array(
                    'driver' => 'sqlite',
                    'host' => 'local',
                    'database' => 'foo.db',
                    'username' => 'user',
                    'password' => 'pass',
                    'charset' => 'utf8',
                    'collation' => 'utf8_unicode_ci',
                    'prefix' => 'symfo_',
                ),
            ),
            'default_connection' => 'foo',
            'eloquent' => array('enabled' => false),
        );

        $path = function ($file) {
            return __DIR__.'/../Fixtures/config/'.$file;
        };

        return array(
            array($path('config1.yml'), $expected1),
            array($path('config1.xml'), $expected1),
            array($path('config1.php'), $expected1),

            array($path('config2.yml'), $expected2),
            array($path('config2.xml'), $expected2),
            array($path('config2.php'), $expected2),

            array($path('config3.yml'), $expected3),
            array($path('config3.xml'), $expected3),
            array($path('config3.php'), $expected3),

            array($path('config4.yml'), $expected4),
            array($path('config4.xml'), $expected4),
            array($path('config4.php'), $expected4),
        );
    }
}
