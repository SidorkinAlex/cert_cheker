<?php

namespace Sidalex\CertChecker\Classes\DataCollectors;

use Sidalex\CertChecker\Classes\Config\Config;

interface DataCollectorInterface
{
    public function __construct(Config $config);
    public function collect(): array;

}