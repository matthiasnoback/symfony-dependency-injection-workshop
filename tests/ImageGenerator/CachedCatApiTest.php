<?php

namespace ImageGenerator\Tests\CatApi;

use ImageGenerator\CachedCatApi;

class CachedCatApiTest extends \PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        @unlink(__DIR__ . '/../../cache/random');
    }

    /**
     * @test
     */
    public function it_caches_a_random_cat_gif_url_for_3_seconds()
    {
        $catApi = new CachedCatApi();

        $firstUrl = $catApi->getRandomImage();

        sleep(2);
        $secondUrl = $catApi->getRandomImage();
        $this->assertSame($firstUrl, $secondUrl);

        sleep(2);
        $thirdUrl = $catApi->getRandomImage();
        $this->assertNotSame($secondUrl, $thirdUrl);
    }
}
