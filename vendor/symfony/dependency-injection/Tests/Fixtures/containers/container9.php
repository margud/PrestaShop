<?php

namespace _PhpScoper5eddef0da618a;

require_once __DIR__ . '/../includes/classes.php';
require_once __DIR__ . '/../includes/foo.php';
use _PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\Argument\IteratorArgument;
use _PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\Argument\TaggedIteratorArgument;
use _PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\ContainerInterface;
use _PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\Reference;
use _PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\Parameter;
use _PhpScoper5eddef0da618a\Symfony\Component\ExpressionLanguage\Expression;
$container = new \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\ContainerBuilder();
$container->register('foo', '_PhpScoper5eddef0da618a\\Bar\\FooClass')->addTag('foo', ['foo' => 'foo'])->addTag('foo', ['bar' => 'bar', 'baz' => 'baz'])->setFactory(['_PhpScoper5eddef0da618a\\Bar\\FooClass', 'getInstance'])->setArguments(['foo', new \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\Reference('foo.baz'), ['%foo%' => 'foo is %foo%', 'foobar' => '%foo%'], \true, new \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\Reference('service_container')])->setProperties(['foo' => 'bar', 'moo' => new \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\Reference('foo.baz'), 'qux' => ['%foo%' => 'foo is %foo%', 'foobar' => '%foo%']])->addMethodCall('setBar', [new \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\Reference('bar')])->addMethodCall('initialize')->setConfigurator('sc_configure')->setPublic(\true);
$container->register('foo.baz', '%baz_class%')->setFactory(['%baz_class%', 'getInstance'])->setConfigurator(['%baz_class%', 'configureStatic1'])->setPublic(\true);
$container->register('bar', '_PhpScoper5eddef0da618a\\Bar\\FooClass')->setArguments(['foo', new \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\Reference('foo.baz'), new \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\Parameter('foo_bar')])->setConfigurator([new \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\Reference('foo.baz'), 'configure'])->setPublic(\true);
$container->register('foo_bar', '%foo_class%')->addArgument(new \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\Reference('deprecated_service'))->setShared(\false)->setPublic(\true);
$container->getParameterBag()->clear();
$container->getParameterBag()->add(['baz_class' => 'BazClass', 'foo_class' => '_PhpScoper5eddef0da618a\\Bar\\FooClass', 'foo' => 'bar']);
$container->register('method_call1', '_PhpScoper5eddef0da618a\\Bar\\FooClass')->setFile(\realpath(__DIR__ . '/../includes/foo.php'))->addMethodCall('setBar', [new \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\Reference('foo')])->addMethodCall('setBar', [new \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\Reference('foo2', \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\ContainerInterface::NULL_ON_INVALID_REFERENCE)])->addMethodCall('setBar', [new \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\Reference('foo3', \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\ContainerInterface::IGNORE_ON_INVALID_REFERENCE)])->addMethodCall('setBar', [new \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\Reference('foobaz', \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\ContainerInterface::IGNORE_ON_INVALID_REFERENCE)])->addMethodCall('setBar', [new \_PhpScoper5eddef0da618a\Symfony\Component\ExpressionLanguage\Expression('service("foo").foo() ~ (container.hasParameter("foo") ? parameter("foo") : "default")')])->setPublic(\true);
$container->register('foo_with_inline', 'Foo')->addMethodCall('setBar', [new \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\Reference('inlined')])->setPublic(\true);
$container->register('inlined', 'Bar')->setProperty('pub', 'pub')->addMethodCall('setBaz', [new \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\Reference('baz')])->setPublic(\false);
$container->register('baz', 'Baz')->addMethodCall('setFoo', [new \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\Reference('foo_with_inline')])->setPublic(\true);
$container->register('request', 'Request')->setSynthetic(\true)->setPublic(\true);
$container->register('configurator_service', 'ConfClass')->setPublic(\false)->addMethodCall('setFoo', [new \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\Reference('baz')]);
$container->register('configured_service', 'stdClass')->setConfigurator([new \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\Reference('configurator_service'), 'configureStdClass'])->setPublic(\true);
$container->register('configurator_service_simple', 'ConfClass')->addArgument('bar')->setPublic(\false);
$container->register('configured_service_simple', 'stdClass')->setConfigurator([new \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\Reference('configurator_service_simple'), 'configureStdClass'])->setPublic(\true);
$container->register('decorated', 'stdClass')->setPublic(\true);
$container->register('decorator_service', 'stdClass')->setDecoratedService('decorated')->setPublic(\true);
$container->register('decorator_service_with_name', 'stdClass')->setDecoratedService('decorated', 'decorated.pif-pouf')->setPublic(\true);
$container->register('deprecated_service', 'stdClass')->setDeprecated(\true)->setPublic(\true);
$container->register('new_factory', 'FactoryClass')->setProperty('foo', 'bar')->setPublic(\false);
$container->register('factory_service', 'Bar')->setFactory([new \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\Reference('foo.baz'), 'getInstance'])->setPublic(\true);
$container->register('new_factory_service', 'FooBarBaz')->setProperty('foo', 'bar')->setFactory([new \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\Reference('new_factory'), 'getInstance'])->setPublic(\true);
$container->register('service_from_static_method', '_PhpScoper5eddef0da618a\\Bar\\FooClass')->setFactory(['_PhpScoper5eddef0da618a\\Bar\\FooClass', 'getInstance'])->setPublic(\true);
$container->register('factory_simple', 'SimpleFactoryClass')->addArgument('foo')->setDeprecated(\true)->setPublic(\false);
$container->register('factory_service_simple', 'Bar')->setFactory([new \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\Reference('factory_simple'), 'getInstance'])->setPublic(\true);
$container->register('lazy_context', 'LazyContext')->setArguments([new \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\Argument\IteratorArgument(['k1' => new \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\Reference('foo.baz'), 'k2' => new \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\Reference('service_container')]), new \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\Argument\IteratorArgument([])])->setPublic(\true);
$container->register('lazy_context_ignore_invalid_ref', 'LazyContext')->setArguments([new \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\Argument\IteratorArgument([new \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\Reference('foo.baz'), new \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\Reference('invalid', \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\ContainerInterface::IGNORE_ON_INVALID_REFERENCE)]), new \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\Argument\IteratorArgument([])])->setPublic(\true);
$container->register('tagged_iterator_foo', 'Bar')->addTag('foo')->setPublic(\false);
$container->register('tagged_iterator', 'Bar')->addArgument(new \_PhpScoper5eddef0da618a\Symfony\Component\DependencyInjection\Argument\TaggedIteratorArgument('foo'))->setPublic(\true);
$container->setAlias('alias_for_foo', 'foo')->setPublic(\true);
$container->setAlias('alias_for_alias', 'alias_for_foo')->setPublic(\true);
return $container;
