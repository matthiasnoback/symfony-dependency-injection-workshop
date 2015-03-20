<?php

namespace CatApi;

class PrefetchGifObserver implements NewUrlObserver
{
    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function notify($url)
    {
        file_put_contents(
            __DIR__ . '/../../cache/' . md5($url) . '.gif',
            $this->httpClient->get($url)
        );
    }
}
