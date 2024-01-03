<?php

namespace Sidalex\CertChecker;

use HaydenPierce\ClassFinder\ClassFinder;
use Sidalex\CertChecker\Classes\Config\Config;
use Sidalex\CertChecker\Classes\DataCollectors\DataCollectorInterface;
use Sidalex\CertChecker\Classes\Reporters\ReporterInterface;

class Application
{
    protected array $dataCollectors;
    protected array $urls = [];
    protected Classes\Config\Config $config;
    protected array $overdueDetailUrls = [];
    /**
     * @var array[ReporterInterface] list of reporter they send report from the overdue certificates
     */
    protected array $reporterSandlerList = [];

    public function start(): void
    {
        $this->initConfig();
        $this->initDataCollectors();
        $this->collectUrls();
        $this->checkCertificate();
        $this->reporterInit();
        $this->reportCerttWrnings();


    }

    private function initDataCollectors(): void
    {
        ClassFinder::disablePSR4Vendors();
        foreach (ClassFinder::getClassesInNamespace('Sidalex\CertChecker\Classes\DataCollectors') as $class) {
            $collector = new $class($this->config);
            if ($collector instanceof DataCollectorInterface) {
                $this->dataCollectors[] = $collector;
            }
        }
    }

    private function collectUrls(): void
    {
        foreach ($this->dataCollectors as $collector) {
            $this->urls = array_merge($this->urls, $collector->collect());
        }

    }

    private function initConfig(): void
    {
        $this->config = new Config($_ENV);
    }

    private function checkCertificate(): void
    {
        foreach ($this->urls as $url) {
            $checker = new Classes\Checker\CertChecker($url, $this->config);
            if ($checker->certFromUrlIsOverdue()) {
                $this->overdueDetailUrls[] = $checker->getSiteDTO();
            }
            unset($checker);
        }
    }

    private function reportCerttWrnings(): void
    {
        if (count($this->overdueDetailUrls) > 0) {
            foreach ($this->reporterSandlerList as $reporter) {
                if ($reporter instanceof ReporterInterface) {
                    $reporter->reportCerttWrnings($this->overdueDetailUrls, $this->config);
                }
            }
        }
    }

    protected function reporterInit()
    {
        ClassFinder::disablePSR4Vendors();
        foreach (ClassFinder::getClassesInNamespace('Sidalex\CertChecker\Classes\Reporters') as $class) {
            $collector = new $class();
            if ($collector instanceof ReporterInterface) {
                $this->reporterSandlerList[] = $collector;
            }
        }
    }
}