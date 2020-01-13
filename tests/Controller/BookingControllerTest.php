<?php
/**
 * Created by PhpStorm.
 * User: faveu
 * Date: 29/08/2019
 * Time: 22:58
 */
namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookingControllerTest extends WebTestCase
{

    public function testShowPost()
    {
        $client = static::createClient();

        $client->request('GET', '/add');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

       /* $crawler = $client->request('GET', '/add');

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Hello World")')->count()
        );*/


    }

}