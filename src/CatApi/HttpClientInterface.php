<?php

namespace CatApi;

interface HttpClientInterface
{
    /**
     * @param string $url
     * @return string
     */
    public function get($url);
}
