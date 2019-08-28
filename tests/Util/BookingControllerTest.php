<?php
/**
 * Created by PhpStorm.
 * User: faveu
 * Date: 27/08/2019
 * Time: 22:26
 */

namespace App\Tests\Util;

use App\Controller\BookingController;
use PHPUnit\Framework\TestCase;


class BookingControllerTest extends TestCase
{

    public function testAdd()
    {
        $booking = new BookingController();
        $result = $booking->recup(3);
        $result1 = $booking->recup(10);
        $result3 = $booking->recup(20);


        // assert that your calculator added the numbers correctly!
        $this->assertEquals(0, $result);
        $this->assertEquals(8, $result1);
        $this->assertEquals(16, $result3);
    }

}
