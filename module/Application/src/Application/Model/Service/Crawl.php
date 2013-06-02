<?php
namespace Application\Model\Service;

use Common\Model\Service\Core;
use Application\Model\Entity\Url as UrlEntity;

/**
 * Class Crawler
 *
 * @package Application\Model\Service
 */
class Crawl extends Core
{

    /**
     * @param UrlEntity $urlEntity
     * @return bool
     */
    public function run(UrlEntity $urlEntity)
    {
        $this->getMapper()->run($urlEntity);

        return true;
    }


}
