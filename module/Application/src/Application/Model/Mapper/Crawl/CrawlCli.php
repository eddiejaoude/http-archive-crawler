<?php
namespace Application\Model\Mapper\Crawl;

use Common\Model\Mapper\Core;
use Application\Model\Entity\Url as UrlEntity;

class CrawlCli extends Core implements CrawlInterface
{

    public function run(UrlEntity $url)
    {
        $data     = array(
            'id' => $url->getId()
        );
        $response = $this->getDao()->run($data);

        return true;
    }


}
