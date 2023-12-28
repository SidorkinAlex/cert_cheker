<?php

namespace Sidalex\CertChecker\Classes\Reporters;

use Sidalex\CertChecker\Classes\Config\Config;

interface ReporterInterface
{

    public function reportCerttWrnings(array $overdueDetailUrls, Config $config): void;
}