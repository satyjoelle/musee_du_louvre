<?php
/**
 * Created by PhpStorm.
 * User: faveu
 * Date: 26/08/2019
 * Time: 00:29
 */

namespace App\Tests\Util;

use App\Util\Calculator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    public function testAdd()
    {
        $calculator = new Calculator();
        $result = $calculator->add(30, 12);

        $this->assertEquals(42, $result);
    }
}