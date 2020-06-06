<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper5ea00cc67502b\Symfony\Component\Filesystem\Tests;

use _PhpScoper5ea00cc67502b\PHPUnit\Framework\TestCase;
use _PhpScoper5ea00cc67502b\Symfony\Component\Filesystem\Exception\IOException;
use _PhpScoper5ea00cc67502b\Symfony\Component\Filesystem\Filesystem;
use _PhpScoper5ea00cc67502b\Symfony\Component\Filesystem\LockHandler;
/**
 * @group legacy
 */
class LockHandlerTest extends \_PhpScoper5ea00cc67502b\PHPUnit\Framework\TestCase
{
    public function testConstructWhenRepositoryDoesNotExist()
    {
        $this->expectException('_PhpScoper5ea00cc67502b\\Symfony\\Component\\Filesystem\\Exception\\IOException');
        $this->expectExceptionMessage('Failed to create "/a/b/c/d/e": mkdir(): Permission denied.');
        if (!\getenv('USER') || 'root' === \getenv('USER')) {
            $this->markTestSkipped('This test will fail if run under superuser');
        }
        new \_PhpScoper5ea00cc67502b\Symfony\Component\Filesystem\LockHandler('lock', '/a/b/c/d/e');
    }
    public function testConstructWhenRepositoryIsNotWriteable()
    {
        $this->expectException('_PhpScoper5ea00cc67502b\\Symfony\\Component\\Filesystem\\Exception\\IOException');
        $this->expectExceptionMessage('The directory "/" is not writable.');
        if (!\getenv('USER') || 'root' === \getenv('USER')) {
            $this->markTestSkipped('This test will fail if run under superuser');
        }
        new \_PhpScoper5ea00cc67502b\Symfony\Component\Filesystem\LockHandler('lock', '/');
    }
    public function testErrorHandlingInLockIfLockPathBecomesUnwritable()
    {
        // skip test on Windows; PHP can't easily set file as unreadable on Windows
        if ('\\' === \DIRECTORY_SEPARATOR) {
            $this->markTestSkipped('This test cannot run on Windows.');
        }
        if (!\getenv('USER') || 'root' === \getenv('USER')) {
            $this->markTestSkipped('This test will fail if run under superuser');
        }
        $lockPath = \sys_get_temp_dir() . '/' . \uniqid('', \true);
        $e = null;
        $wrongMessage = null;
        try {
            \mkdir($lockPath);
            $lockHandler = new \_PhpScoper5ea00cc67502b\Symfony\Component\Filesystem\LockHandler('lock', $lockPath);
            \chmod($lockPath, 0444);
            $lockHandler->lock();
        } catch (\_PhpScoper5ea00cc67502b\Symfony\Component\Filesystem\Exception\IOException $e) {
            if (\false === \strpos($e->getMessage(), 'Permission denied')) {
                $wrongMessage = $e->getMessage();
            } else {
                $this->addToAssertionCount(1);
            }
        } catch (\Exception $e) {
        } catch (\Throwable $e) {
        }
        if (\is_dir($lockPath)) {
            $fs = new \_PhpScoper5ea00cc67502b\Symfony\Component\Filesystem\Filesystem();
            $fs->remove($lockPath);
        }
        $this->assertInstanceOf('_PhpScoper5ea00cc67502b\\Symfony\\Component\\Filesystem\\Exception\\IOException', $e, \sprintf('Expected IOException to be thrown, got %s instead.', \get_class($e)));
        $this->assertNull($wrongMessage, \sprintf('Expected exception message to contain "Permission denied", got "%s" instead.', $wrongMessage));
    }
    public function testConstructSanitizeName()
    {
        $lock = new \_PhpScoper5ea00cc67502b\Symfony\Component\Filesystem\LockHandler('<?php echo "% hello word ! %" ?>');
        $file = \sprintf('%s/sf.-php-echo-hello-word-.4b3d9d0d27ddef3a78a64685dda3a963e478659a9e5240feaf7b4173a8f28d5f.lock', \sys_get_temp_dir());
        // ensure the file does not exist before the lock
        @\unlink($file);
        $lock->lock();
        $this->assertFileExists($file);
        $lock->release();
    }
    public function testLockRelease()
    {
        $name = 'symfony-test-filesystem.lock';
        $l1 = new \_PhpScoper5ea00cc67502b\Symfony\Component\Filesystem\LockHandler($name);
        $l2 = new \_PhpScoper5ea00cc67502b\Symfony\Component\Filesystem\LockHandler($name);
        $this->assertTrue($l1->lock());
        $this->assertFalse($l2->lock());
        $l1->release();
        $this->assertTrue($l2->lock());
        $l2->release();
    }
    public function testLockTwice()
    {
        $name = 'symfony-test-filesystem.lock';
        $lockHandler = new \_PhpScoper5ea00cc67502b\Symfony\Component\Filesystem\LockHandler($name);
        $this->assertTrue($lockHandler->lock());
        $this->assertTrue($lockHandler->lock());
        $lockHandler->release();
    }
    public function testLockIsReleased()
    {
        $name = 'symfony-test-filesystem.lock';
        $l1 = new \_PhpScoper5ea00cc67502b\Symfony\Component\Filesystem\LockHandler($name);
        $l2 = new \_PhpScoper5ea00cc67502b\Symfony\Component\Filesystem\LockHandler($name);
        $this->assertTrue($l1->lock());
        $this->assertFalse($l2->lock());
        $l1 = null;
        $this->assertTrue($l2->lock());
        $l2->release();
    }
}
