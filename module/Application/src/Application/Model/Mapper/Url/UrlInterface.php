<?php
namespace Application\Model\Mapper\Url;

use Application\Model\Entity\Url as UrlEntity;

interface UrlInterface
{

    /**
     * @param UrlEntity $url
     * @return bool
     */
    public function create(UrlEntity $url);

    /**
     * @param UrlEntity $url
     * @return mixed
     */
    public function update(UrlEntity $url);
}