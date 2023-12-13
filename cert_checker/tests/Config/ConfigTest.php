<?php

namespace Sidalex\CertChecker\Classes\Config;

use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @dataProvider envDataProvider
     */
    public function test_config_construct($env){
        $env =[
            "URLS"=>"http://localhost,http://localhost1,http://localhost2,http://localhost3,http://localhost4"
        ];
        $config = new Config($env);
        $this->assertIsArray($config->getUrlsToCheck(),"url in config is not array");

    }
    public function test_getUrlsToCheck(){
        $env =[
            "URLS"=>"http://localhost,http://localhost1,http://localhost2,http://localhost3,http://localhost4"
        ];
        $config = new Config($env);
        $this->assertIsArray($config->getUrlsToCheck(),"url in config is not array");

        $env =[
            "URLS"=>"http://localhost"
        ];
        $config = new Config($env);
        $this->assertEquals($config->getUrlsToCheck()[0],'http://localhost',"config.url in config is not valid");

        $env =[
        ];
        $config = new Config($env);
        $this->assertEmpty($config->getUrlsToCheck(),"config.url in config is not empty");


    }

    public static function envDataProvider()
    {
        return  [
            [
                "URLS"=>"http://test1.com,https://test2.com,http://test3.com"
            ],
            [
                "URLS"=>"http://localhost,http://localhost1,http://localhost2,http://localhost3,http://localhost4"
            ],
        ];
    }

}
