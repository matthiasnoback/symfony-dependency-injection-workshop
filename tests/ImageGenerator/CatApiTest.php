<?php

namespace ImageGenerator\Tests\CatApi;

use ImageGenerator\CatApi;

class CatApiTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_fetches_a_random_url_of_a_cat_gif()
    {
        $catApi = new CatApi();

        $url = $catApi->getRandomImage();

        $this->assertTrue(filter_var($url, FILTER_VALIDATE_URL) !== false);
    }
}
