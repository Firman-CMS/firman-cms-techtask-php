<?php

namespace App\Test\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LunchTest extends WebTestCase
{
	
	public function testLunchRecipe()
	{
		$client = static::createClient();

		$client->request('GET', '/lunch?date=2019-03-06');

		$this->assertEquals(200, $client->getResponse()->getStatusCode());
	}
}