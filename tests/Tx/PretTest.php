<?php

namespace FormDev\TauxCalc\Tests\Tx;

use FormDev\TauxCalc\Tx\Pret;
use PHPUnit\Framework\TestCase;


class PretTest extends TestCase
{
    /**
     * @var Pret
     */
    private $instance;

    public function setUp()
    {
        $this->instance = new Pret;
    }

    public function testFormule()
    {
        $echeance = 1000;
        $taux = 0.0103;
        $months = 180;
        $result = $this->instance->get($echeance, $taux, $months);
        $expected = 166718;
        $this->assertEquals($expected, $result);
    }
}