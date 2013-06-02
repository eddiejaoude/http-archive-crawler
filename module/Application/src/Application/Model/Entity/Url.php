<?php
namespace Application\Model\Entity;

use Zend\InputFilter\Factory as InputFactory; // <-- Add this import
use Zend\InputFilter\InputFilter; // <-- Add this import
use Zend\InputFilter\InputFilterAwareInterface; // <-- Add this import
use Zend\InputFilter\InputFilterInterface; // <-- Add this import
use Application\Model\Entity\CrawledUrl as CrawledUrlEntity;

class Url implements InputFilterAwareInterface
{
    const PENDING = 'Pending';
    const RUNNING = 'Running';
    const ABORTED = 'Aborted';

    /**
     * @var int
     */
    protected $id = 0;

    /**
     * @var int
     */
    protected $userId = 0;

    /**
     * @var string
     */
    protected $url = '';

    /**
     * @var int
     */
    protected $depth = 0;

    /**
     * @var int
     */
    protected $limit = 0;

    /**
     * @var string
     */
    protected $spiderId = '';

    /**
     * @var int
     */
    protected $queued = 0;

    /**
     * @var int
     */
    protected $skipped = 0;

    /**
     * @var int
     */
    protected $failed = 0;

    /**
     * @var array
     */
    protected $crawledUrls = array();

    /**
     * @var string
     */
    protected $crawlStart = '0000-00-00 00:00:00';

    /**
     * @var string
     */
    protected $crawlEnd = '0000-00-00 00:00:00';

    /**
     * @var string
     */
    protected $createdOn = '';

    /**
     * @var string
     */
    protected $updatedOn = '';

    protected $inputFilter; // <-- Add this variable

    /**
     * @param array $data
     */
    public function exchangeArray(array $data)
    {
        $this->id         = (isset($data['id'])) ? $data['id'] : null;
        $this->userId     = (isset($data['user_id'])) ? $data['user_id'] : null;
        $this->url        = (isset($data['url'])) ? $data['url'] : null;
        $this->depth      = (isset($data['depth'])) ? $data['depth'] : null;
        $this->limit      = (isset($data['limit'])) ? $data['limit'] : null;
        $this->spiderId   = (isset($data['spider_id'])) ? $data['spider_id'] : null;
        $this->queued     = (isset($data['queued'])) ? $data['queued'] : null;
        $this->failed     = (isset($data['failed'])) ? $data['failed'] : null;
        $this->skipped    = (isset($data['skipped'])) ? $data['skipped'] : null;
        $this->crawlStart = (isset($data['crawl_start'])) ? $data['crawl_start'] : '0000-00-00 00:00:00';
        $this->crawlEnd   = (isset($data['crawl_end'])) ? $data['crawl_end'] : '0000-00-00 00:00:00';
        $this->createdOn  = (isset($data['created_on'])) ? $data['created_on'] : null;
        $this->updatedOn  = (isset($data['updated_on'])) ? $data['updated_on'] : null;
    }

    /**
     * @return array
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    /**
     * @param InputFilterInterface $inputFilter
     *
     * @return void|InputFilterAwareInterface
     * @throws \Exception
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    /**
     * @return InputFilter|InputFilterInterface
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'     => 'id',
                        'required' => false,
                        'filters'  => array(
                            array('name' => 'Int'),
                        ),
                    )
                )
            );

            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'     => 'user_id',
                        'required' => false,
                        'filters'  => array(
                            array('name' => 'Int'),
                        ),
                    )
                )
            );

            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'url',
                        'required'   => true,
                        'filters'    => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name'    => 'StringLength',
                                'options' => array(
                                    'encoding' => 'UTF-8',
                                    'min'      => 5,
                                    'max'      => 64,
                                ),
                            ),
                            array(
                                'name' => 'Zend\Validator\Hostname'
                            ),
                        )
                    )
                )
            );

            $inputFilter->add(
                $factory->createInput(
                    array(
                        'spider_id'  => 'id',
                        'required'   => false,
                        'filters'    => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name'    => 'StringLength',
                                'options' => array(
                                    'encoding' => 'UTF-8',
                                    'min'      => 5,
                                    'max'      => 64,
                                ),
                            ),
                        )
                    )
                )
            );

            $factory->createInput(
                array(
                    'name'     => 'queued',
                    'required' => false,
                    'filters'  => array(
                        array('name' => 'Int'),
                    ),
                )
            );

            $factory->createInput(
                array(
                    'name'     => 'skipped',
                    'required' => false,
                    'filters'  => array(
                        array('name' => 'Int'),
                    ),
                )
            );

            $factory->createInput(
                array(
                    'name'     => 'failed',
                    'required' => false,
                    'filters'  => array(
                        array('name' => 'Int'),
                    ),
                )
            );

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     *
     * @return Url
     */
    public function setId($id)
    {
        $this->id = (int)$id;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return Url
     */
    public function setUrl($url)
    {
        $this->url = (string)$url;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedOn()
    {
        if (empty($this->createdOn)) {
            $datetime        = new \DateTime('now');
            $this->createdOn = $datetime->format('Y-m-d H:i:s');
        }

        return $this->createdOn;
    }

    /**
     * @param $createdOn
     *
     * @return Url
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = (string)$createdOn;

        return $this;
    }

    /**
     * @return string
     */
    public function getUpdatedOn()
    {
        if (empty($this->updatedOn)) {
            $this->setUpdatedOn();
        }

        return $this->updatedOn;
    }

    /**
     * @param $updatedOn
     *
     * @return Url
     */
    public function setUpdatedOn($updatedOn = null)
    {
        if (is_null($updatedOn)) {
            $datetime  = new \DateTime();
            $updatedOn = $datetime->format('Y-m-d H:i:s');
        }
        $this->updatedOn = (string)$updatedOn;

        return $this;
    }

    /**
     * @return array
     */
    public function getCrawledUrls()
    {
        return $this->crawledUrls;
    }

    /**
     * @param array $urls
     *
     * @return Url
     */
    public function setCrawledUrls(array $urls)
    {
        $this->crawledUrls = $urls;

        return $this;
    }

    /**
     * @param CrawledUrlEntity $crawledUrl
     *
     * @return Url
     */
    public function addCrawledUrl(CrawledUrlEntity $crawledUrl)
    {
        $this->crawledUrls[] = $crawledUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getSpiderId()
    {
        return $this->spiderId;
    }

    /**
     * @param string $spiderId
     * @return $this
     */
    public function setSpiderId($spiderId)
    {
        $this->spiderId = (string)$spiderId;

        return $this;
    }

    /**
     * @return int
     */
    public function getQueued()
    {
        return $this->queued;
    }

    /**
     * @param int $queued
     * @return $this
     */
    public function setQueued($queued)
    {
        $this->queued = (int)$queued;

        return $this;
    }

    /**
     * @return int
     */
    public function getSkipped()
    {
        return $this->skipped;
    }

    /**
     * @param int $skipped
     * @return $this
     */
    public function setSkipped($skipped)
    {
        $this->skipped = (int)$skipped;

        return $this;
    }

    /**
     * @return int
     */
    public function getFailed()
    {
        return $this->failed;
    }

    /**
     * @param int $failed
     * @return $this
     */
    public function setFailed($failed)
    {
        $this->failed = (int)$failed;

        return $this;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return $this
     */
    public function setUserId($userId)
    {
        $this->userId = (int)$userId;

        return $this;
    }

    /**
     * @return int
     */
    public function getTotalCrawled()
    {
        return $this->getSkipped() + $this->getFailed() + $this->getQueued();
    }

    /**
     * @return string
     */
    public function getCrawlStart()
    {
        return $this->crawlStart;
    }

    /**
     * @param string|null $crawlStart
     * @return $this
     */
    public function setCrawlStart($crawlStart = null)
    {
        if (is_null($crawlStart)) {
            $datetime   = new \DateTime();
            $crawlStart = $datetime->format('Y-m-d H:i:s');
        }
        $this->crawlStart = (string)$crawlStart;

        return $this;
    }

    /**
     * @return string
     */
    public function getCrawlEnd()
    {
        return $this->crawlEnd;
    }

    /**
     * @param string|null $crawlEnd
     * @return $this
     */
    public function setCrawlEnd($crawlEnd = null)
    {
        if (is_null($crawlEnd)) {
            $datetime = new \DateTime();
            $crawlEnd = $datetime->format('Y-m-d H:i:s');
        }
        $this->crawlEnd = (string)$crawlEnd;

        return $this;
    }

    /**
     * @param int $limit
     * @return string
     */
    public function getDuration($limit = 600)
    {
        $start = $this->getCrawlStart();
        $end   = $this->getCrawlEnd();

        $now           = new \DateTime();
        $startDateTime = new \DateTime($start);
        $endDateTime = new \DateTime($end);

        if ('0000-00-00 00:00:00' == $start && '0000-00-00 00:00:00' == $end) {
            return self::PENDING;
        } elseif ('0000-00-00 00:00:00' != $start && '0000-00-00 00:00:00' == $end && $startDateTime->diff(
                $now
            )->format('%s') > $limit
        ) {
            return self::ABORTED;
        } elseif ('0000-00-00 00:00:00' != $start && '0000-00-00 00:00:00' == $end) {
            return self::RUNNING;
        }

        return $startDateTime->diff($endDateTime)->format('%s');
    }

    /**
     * @return int
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * @param int $depth
     * @return $this
     */
    public function setDepth($depth)
    {
        $this->depth = (int)$depth;

        return $this;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function setLimit($limit)
    {
        $this->limit = (int)$limit;

        return $this;
    }


}