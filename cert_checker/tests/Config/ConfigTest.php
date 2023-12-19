<?php

namespace Sidalex\CertChecker\Classes\Config;

use PHPUnit\Framework\TestCase;

/**
 * @uses \Sidalex\CertChecker\Classes\Config\Config
 */
class ConfigTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @dataProvider envDataProvider
     * @covers       \Sidalex\CertChecker\Classes\Config\Config::__construct
     * @covers       \Sidalex\CertChecker\Classes\RequestSandler\RequestParamsBuilderFromEnv
     */
    public function test_construct($env)
    {
        $config = new Config($env);
        $this->assertIsArray($config->getUrlsToCheck(), "url in config is not array");
        $this->assertIsInt($config->getCountDaysToWorn(), 'count days to worn is not integer');

    }

    /**
     * @covers \Sidalex\CertChecker\Classes\Config\Config
     * @covers Sidalex\CertChecker\Classes\RequestSandler\RequestParamsBuilderFromEnv
     * @covers \Sidalex\CertChecker\Classes\Config\Config::getUrlsToCheck
     */
    public function test_getUrlsToCheck()
    {
        $env = [
            "URLS" => "http://localhost,http://localhost1,http://localhost2,http://localhost3,http://localhost4"
        ];
        $config = new Config($env);
        $this->assertIsArray($config->getUrlsToCheck(), "url in config is not array");

        $env = [
            "URLS" => "http://localhost"
        ];
        $config = new Config($env);
        $this->assertEquals($config->getUrlsToCheck()[0], 'http://localhost', "config.url in config is not valid");

        $env = [
        ];
        $config = new Config($env);
        $this->assertEmpty($config->getUrlsToCheck(), "config.url in config is not empty");


    }

    public static function envDataProvider(): array
    {
        return [
            [
                [
                    "URLS" => "http://test1.com,https://test2.com,http://test3.com",
                    "COUNT_DAYS_TO_WORN" => 1,
                ]
            ],
            [
                [
                    "URLS" => "http://localhost,http://localhost1,http://localhost2,http://localhost3,http://localhost4",
                    "COUNT_DAYS_TO_WORN" => 5,
                ]
            ],
            [
                [
                    "test" => 'test'
                ]
            ],
        ];
    }

}
