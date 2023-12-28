<?php

namespace Sidalex\CertChecker\Classes\Reporters;

interface ReporterInterface
{

    public function reportCerttWrnings(array $overdueDetailUrls, \Sidalex\CertChecker\Classes\Config\Config $config): void;
}