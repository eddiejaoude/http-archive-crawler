<?php
namespace Application\Model\Dao\Crawl;

use Common\Model\Dao\DaoInterface;

/**
 * Class CrawlCli
 *
 * @package Application\Model\Dao\Crawl
 */
class CrawlCli implements CrawlInterface, DaoInterface
{

    /**
     * @param array $data
     * @return bool
     */
    public function run(array $data)
    {
        shell_exec('php ' . getcwd() . '/public/index.php crawl ' . escapeshellarg(($data['id'])) . '  >/dev/null 2>/dev/null &');
        return true;
    }

}