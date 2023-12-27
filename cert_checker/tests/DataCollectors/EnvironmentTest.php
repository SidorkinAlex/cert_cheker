<?php

namespace Sidalex\CertChecker\Classes\DataCollectors;

use PHPUnit\Framework\TestCase;
use \Sidalex\CertChecker\Classes\Config\Config;

/**
 * @uses \Sidalex\CertChecker\Classes\DataCollectors\Environment
 */

class EnvironmentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     *
     * @covers       \Sidalex\CertChecker\Classes\DataCollectors\Environment
     */
    public function test_collect(){
        $config = $this->configStubGenerator([]);
    $eDataCollector = new Environment($config);
    $this->assertIsArray($eDataCollector->collect(),'Environment::collect returns not array');
    $this->assertEmpty($eDataCollector->collect(),'empty config returned not empty array');
        $config = $this->configStubGenerator(["https://localhost","https://localhost1"]);
        $eDataCollector = new Environment($config);
        $this->assertIsArray($eDataCollector->collect(),'Environment::collect returns not array');
        $this->assertEquals($eDataCollector->collect(),["https://localhost","https://localhost1"],'empty config returned not empty array');

    }

    public function configStubGenerator(array $resultsStab){
//        $stab = $this->createMock(\Sidalex\CertChecker\Classes\Config\Config::class);
        $stub = $this->getMockBuilder(\Sidalex\CertChecker\Classes\Config\Config::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->getMock();
        $stub->expects($this->any())->method("getUrlsToCheck")->willReturn($resultsStab);

        return $stub;
    }
}