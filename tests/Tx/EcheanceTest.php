<?php

namespace FormDev\TauxCalc\Tests\Tx;

use FormDev\TauxCalc\Tx\Echeance;
use PHPUnit\Framework\TestCase;

class EcheanceTest extends TestCase
{
    /**
     * @var Echeance
     */
    private $instance;

    protected function setUp()
    {
        $this->instance = new Echeance;
    }

    public function testNulMontant()
    {
        $result = $this->instance->get(0);
        $this->assertEmpty($result);
    }

    public function testNotIntMontant()
    {
        $result = $this->instance->get('toto');
        $this->assertEmpty($result);
        $result = $this->instance->get('1toto');
        $this->assertEmpty($result);
    }

    public function testStringMontant()
    {
        $result = $this->instance->get('100');
        $this->assertEquals(33.00, $result);
    }

    public function testExpectedResult()
    {
        $result = $this->instance->get(100);
        $this->assertEquals(33.00, $result);
    }

    public function testRoundedResult()
    {
        $result = $this->instance->get(33.33);
        $this->assertEquals(11.00, $result);
    }
}