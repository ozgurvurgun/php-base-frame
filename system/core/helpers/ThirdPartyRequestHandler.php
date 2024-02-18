<?php

namespace BaseFrame\Core\Controller\Helpers;

class ThirdPartyRequestHandler
{
    private $instagramRegex = '?fbclid=';

    public function urlControl($url)
    {
        if (strpos($url, $this->instagramRegex)) {
            return true;
        } else {
            return false;
        }
    }
}
