<?php

namespace Sidalex\CertChecker\Classes\Checker;

use Sidalex\CertChecker\Classes\Config\Config;

class CertChecker
{
    protected string $url;
    protected Config $config;
    protected CertSiteDTO $siteDTO;

    /**
     * @param string $url
     * @param Config $config
     */
    public function __construct(string $url, Config $config)
    {
        $this->url = $url;
        $this->config = $config;
    }

    /**
     * check ssl cert duration from url
     *
     * @return bool
     * @throws \Exception
     */
    public function certFromUrlIsOverdue(): bool
    {

        $orignal_parse = parse_url($this->url, PHP_URL_HOST);
        $get = stream_context_create(array("ssl" => array("capture_peer_cert" => true)));
        $read = stream_socket_client("ssl://" . $orignal_parse . ":443", $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $get);
        $cert = stream_context_get_params($read);
        $certinfo = openssl_x509_parse($cert['options']['ssl']['peer_certificate']);

        $sertDate = date("Y-m-d", $certinfo['validTo_time_t']);
        $nawDate = date("Y-m-d");
        $date1 = new \DateTime($sertDate);
        $date2 = new \DateTime($nawDate);
        $interval = $date1->diff($date2);
        if ($interval->days <= $this->config->getCountDaysToWorn()) {
            $this->siteDTO = new CertSiteDTO($this->url, $interval->days, ($certinfo['validTo_time_t'] - time()));
            return true;
        }
        return false;
    }

    /**
     * @return CertSiteDTO
     */
    public function getSiteDTO(): CertSiteDTO
    {
        return $this->siteDTO;
    }
}