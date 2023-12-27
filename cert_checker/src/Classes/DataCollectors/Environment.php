<?php

namespace Sidalex\CertChecker\Classes\DataCollectors;
use Sidalex\CertChecker\Classes\Config\Config;

class Environment implements DataCollectorInterface
{

    public function __construct( protected Config $config)
    {
    }

    public function collect(): array
    {
        return $this->config->getUrlsToCheck();
    }
}