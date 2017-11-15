<?php

/**
 * This file is part of the Edoger framework.
 *
 * @author    Qingshan Luo <shanshan.lqs@gmail.com>
 * @copyright 2017 Qingshan Luo
 * @license   GNU Lesser General Public License 3.0
 */

namespace Edoger\Logger\Tests\Support;

use Closure;
use Edoger\Logger\AbstractHandler;
use Edoger\Logger\Log;
use Exception;

class TestExceptionHandler extends AbstractHandler
{
    public function handle(string $channel, Log $log, Closure $next): bool
    {
        throw new Exception('ExceptionHandler');
    }
}