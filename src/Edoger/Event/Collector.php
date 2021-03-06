<?php

/**
 * This file is part of the Edoger framework.
 *
 * @author    Qingshan Luo <shanshan.lqs@gmail.com>
 * @copyright 2017 - 2018 Qingshan Luo
 * @license   GNU Lesser General Public License 3.0
 */

namespace Edoger\Event;

use Edoger\Event\Traits\CollectorSupport;
use Edoger\Event\Contracts\Collector as CollectorContract;

class Collector extends DispatcherContainer implements CollectorContract
{
    use CollectorSupport;
}
