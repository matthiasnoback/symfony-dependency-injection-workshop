<?php

namespace ImageGenerator;

class CatApi
{
    public function getRandomImage()
    {
        $responseXml = @file_get_contents('http://thecatapi.com/api/images/get?format=xml&type=jpg');
        if (!$responseXml) {
            // the cat API is down or something
            return 'http://cdn.my-cool-website.com/default.jpg';
        }

        $responseElement = new \SimpleXMLElement($responseXml);

        return (string)$responseElement->data->images[0]->image->url;
    }
}
