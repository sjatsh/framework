<?php

/**
 * This file is part of the Edoger framework.
 *
 * @author    Qingshan Luo <shanshan.lqs@gmail.com>
 * @copyright 2017 Qingshan Luo
 * @license   GNU Lesser General Public License 3.0
 */

namespace Edoger\Logger\Tests\Cases\Handlers;

use Edoger\Logger\AbstractHandler;
use Edoger\Logger\Formatter\LineFormatter;
use Edoger\Logger\Handlers\FileHandler;
use Edoger\Logger\Levels;
use Edoger\Logger\Log;
use Edoger\Logger\Tests\Support\TestFormatter;
use PHPUnit\Framework\Error\Error;
use PHPUnit\Framework\TestCase;

class FileHandlerTest extends TestCase
{
    protected $temp;

    protected function setUp()
    {
        $this->temp = realpath(__DIR__.'/../../temp');

        file_put_contents($this->temp.'/file-handler-test.log', '');
    }

    protected function tearDown()
    {
        if (file_exists($this->temp.'/file-handler-test.log')) {
            unlink($this->temp.'/file-handler-test.log');
        }

        $this->temp = null;
    }

    public function testFileHandlerExtendsAbstractHandler()
    {
        $handler = new FileHandler('');

        $this->assertInstanceOf(AbstractHandler::class, $handler);
    }

    public function testFileHandler()
    {
        $file      = $this->temp.'/file-handler-test.log';
        $now       = time();
        $log       = new Log(Levels::DEBUG, 'TestFileHandler', [], $now, []);
        $handler   = new FileHandler($file);
        $formatter = new LineFormatter(); // default formatter.

        $this->assertTrue($handler->handle('CHANNEL', $log, function () {
            return true;
        }));
        $this->assertStringEqualsFile($file, $formatter->format('CHANNEL', $log));
    }

    public function testFileHandlerWithLevel()
    {
        $file      = $this->temp.'/file-handler-test.log';
        $now       = time();
        $log       = new Log(Levels::DEBUG, 'TestFileHandler', [], $now, []);
        $handler   = new FileHandler($file, Levels::ERROR);
        $formatter = new LineFormatter(); // default formatter.

        $this->assertTrue($handler->handle('CHANNEL', $log, function () {
            return true;
        }));
        $this->assertStringEqualsFile($file, '');

        $log = new Log(Levels::ALERT, 'TestFileHandler', [], $now, []);

        $this->assertTrue($handler->handle('CHANNEL', $log, function () {
            return true;
        }));
        $this->assertStringEqualsFile($file, $formatter->format('CHANNEL', $log));
    }

    public function testFileHandlerWithFormatter()
    {
        $file      = $this->temp.'/file-handler-test.log';
        $log       = new Log(Levels::DEBUG, 'TestFileHandler');
        $formatter = new TestFormatter();
        $handler   = new FileHandler($file, Levels::DEBUG, $formatter);

        $this->assertTrue($handler->handle('CHANNEL', $log, function () {
            return true;
        }));
        $this->assertStringEqualsFile($file, 'TEST::CHANNELTestFileHandler');
    }

    public function testFileHandlerWithAutoInterrupt()
    {
        $file      = $this->temp.'/file/handler/test.log';
        $log       = new Log(Levels::DEBUG, 'TestFileHandler');
        $formatter = new TestFormatter();
        $handler   = new FileHandler($file, Levels::DEBUG, $formatter, true);

        $this->assertFalse($handler->handle('CHANNEL', $log, function () {
            return true;
        }));
    }
}
