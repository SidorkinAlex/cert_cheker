<?php

namespace Sidalex\CertChecker\Classes\Config;

use AllowDynamicProperties;
use Sidalex\CertChecker\Classes\RequestSandler\RequestParams;
use Sidalex\CertChecker\Classes\RequestSandler\RequestParamsBuilderFromEnv;

class Config
{
    protected array $urlsToCheck = [];
    protected RequestParams $requestParams;
    protected string $pathToJsonUrls = '';
    protected int $countDaysToWorn = 999;
    protected bool $mailReporter = false;
    protected string $mailSmtpServer = '';
    protected bool $mailSmtpAuth = false;
    protected bool $mailSmtpSsl = false;
    private string $mailSmtpLogin;
    private string $mailSmtpPassword;
    /**
     * @var true
     */
    private bool $mailSmtpTsl = false;
    private int $mailSmtpPort = 25;
    private string $mailSmtpFrom;
    private string $mailSmtpTo;
    private string $mailSmtpSubject='';
    private string $mailSmtpBody='';

    public function __construct(array $env)
    {
        $this->initCollectorsConfig($env);
        $this->initMailReporterConfig($env);
    }

    /**
     * @return int
     */
    public function getCountDaysToWorn(): int
    {
        return $this->countDaysToWorn;
    }

    /**
     * @param array $env
     * @return void
     *
     * settings in ENVIRONMENT
     * MAIL_REPORTER="true" #true or false on or of sending email
     * MAIL_SMTP_SERVER="smtp.gmail.com" #host smtp server
     * MAIL_SMTP_AUTH="true" #true or false on or of authenticating in post server
     * MAIL_SMTP_LOGIN="login" #login from auth server
     * MAIL_SMTP_PASSWORD="password" #password from auth server
     * MAIL_SMTP_SSL="true" #true or false
     * MAIL_SMTP_TSL="false" #true or false
     * MAIL_SMTP_PORT=25 #port from connection to post server
     * MAIL_SMTP_FROM="example@mail.com" # address from sending email
     * MAIL_SMTP_TO="example@mail.com" # address to sending email
     * MAIL_SMTP_SUBJECT="subject" # subject email
     * MAIL_SMTP_EMAIL_BODY="SSL certificates expire for the following domains:" # email message if certificate timeout is closely
     */
    private function initMailReporterConfig(array $env): void
    {
        if (isset($env['MAIL_REPORTER']) && $env['MAIL_REPORTER'] === "true") {
            $this->mailReporter = true;
        }
        if (isset($env['MAIL_SMTP_SERVER']) && !empty($env['MAIL_SMTP_SERVER'])) {
            $this->mailSmtpServer = $env['MAIL_SMTP_SERVER'];
        }
        if (isset($env['MAIL_SMTP_AUTH']) && $env['MAIL_SMTP_AUTH'] === "true") {
            $this->mailSmtpAuth = true;
        }
        if (isset($env['MAIL_SMTP_LOGIN']) && !empty($env['MAIL_SMTP_LOGIN'])) {
            $this->mailSmtpLogin = (string)($env['MAIL_SMTP_LOGIN']);
        }
        if (isset($env['MAIL_SMTP_PASSWORD']) && !empty($env['MAIL_SMTP_PASSWORD'])) {
            $this->mailSmtpPassword = (string)($env['MAIL_SMTP_PASSWORD']);
        }
        if (isset($env['MAIL_SMTP_SSL']) && $env['MAIL_SMTP_SSL'] === "true") {
            $this->mailSmtpSsl = true;
        }
        if (isset($env['MAIL_SMTP_TSL']) && $env['MAIL_SMTP_TSL'] === "true") {
            $this->mailSmtpTsl = true;
        }
        if (isset($env['MAIL_SMTP_PORT']) && !empty($env['MAIL_SMTP_PORT'])) {
            $this->mailSmtpPort = (int)($env['MAIL_SMTP_PORT']);
        }
        if (isset($env['MAIL_SMTP_FROM']) && !empty($env['MAIL_SMTP_FROM'])) {
            $this->mailSmtpFrom = (string)($env['MAIL_SMTP_FROM']);
        }
        if (isset($env['MAIL_SMTP_TO']) && !empty($env['MAIL_SMTP_TO'])) {
            $this->mailSmtpTo = (string)($env['MAIL_SMTP_TO']);
        }
        if (isset($env['MAIL_SMTP_SUBJECT']) && !empty($env['MAIL_SMTP_SUBJECT'])) {
            $this->mailSmtpSubject = (string)($env['MAIL_SMTP_SUBJECT']);
        }
        if (isset($env['MAIL_SMTP_EMAIL_BODY']) && !empty($env['MAIL_SMTP_EMAIL_BODY'])) {
            $this->mailSmtpBody = (string)($env['MAIL_SMTP_EMAIL_BODY']);
        }
    }

    private function initCollectorsConfig(array $env): void
    {
        if (isset($env['URLS'])) {
            $this->urlsToCheck = explode(",", $env['URLS']);
        }
        if (RequestParamsBuilderFromEnv::possibleBuild($env)) {
            $this->requestParams = RequestParamsBuilderFromEnv::buildRequestParams($env);

        }
        if (isset($env['COUNT_DAYS_TO_WORN']) && !empty((int)($env['COUNT_DAYS_TO_WORN']))) {
            $this->countDaysToWorn = (int)($env['COUNT_DAYS_TO_WORN']);
        }
    }

    /**
     * @return bool
     */
    public function isMailReporter(): bool
    {
        return $this->mailReporter;
    }

    /**
     * @return string
     */
    public function getMailSmtpServer(): string
    {
        return $this->mailSmtpServer;
    }

    /**
     * @return bool
     */
    public function isMailSmtpAuth(): bool
    {
        return $this->mailSmtpAuth;
    }

    public function isMailSmtpSsl(): bool
    {
        return $this->mailSmtpSsl;
    }

    /**
     * @return array
     */
    public function getUrlsToCheck(): array
    {
        return $this->urlsToCheck;
    }

    /**
     * @return RequestParams
     */
    public function getRequestParams(): RequestParams
    {
        return $this->requestParams;
    }

    /**
     * @return string
     */
    public function getPathToJsonUrls(): string
    {
        return $this->pathToJsonUrls;
    }

    /**
     * @return string
     */
    public function getMailSmtpLogin(): string
    {
        return $this->mailSmtpLogin;
    }

    /**
     * @return string
     */
    public function getMailSmtpPassword(): string
    {
        return $this->mailSmtpPassword;
    }

    /**
     * @return bool
     */
    public function isMailSmtpTsl(): bool
    {
        return $this->mailSmtpTsl;
    }

    /**
     * @return int
     */
    public function getMailSmtpPort(): int
    {
        return $this->mailSmtpPort;
    }

    /**
     * @return string
     */
    public function getMailSmtpFrom(): string
    {
        return $this->mailSmtpFrom;
    }

    /**
     * @return string
     */
    public function getMailSmtpTo(): string
    {
        return $this->mailSmtpTo;
    }

    /**
     * @return string
     */
    public function getMailSmtpSubject(): string
    {
        return $this->mailSmtpSubject;
    }

    /**
     * @return string
     */
    public function getMailSmtpBody(): string
    {
        return $this->mailSmtpBody;
    }


}