<?php

namespace Sidalex\CertChecker\Classes\Checker;

final class CertSiteDTO
{
public string $url;
public int $daysToEndCert;
public int $secondsToEndCert;

    /**
     * @param string $url
     * @param int $daysToEndCert
     * @param int $secondsToEndCert
     */
    public function __construct(string $url, int $daysToEndCert, int $secondsToEndCert)
    {
        $this->url = $url;
        $this->daysToEndCert = $daysToEndCert;
        $this->secondsToEndCert = $secondsToEndCert;
    }

}