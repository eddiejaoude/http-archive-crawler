<?php
namespace Application\Model\Entity;

use Zend\InputFilter\Factory as InputFactory; // <-- Add this import
use Zend\InputFilter\InputFilter; // <-- Add this import
use Zend\InputFilter\InputFilterAwareInterface; // <-- Add this import
use Zend\InputFilter\InputFilterInterface; // <-- Add this import

class Crawler implements InputFilterAwareInterface
{
    /**
     * @var int
     */
    protected $id = 0;

    /**
     * @var string
     */
    protected $url = '';

    /**
     * @var array
     */
    protected $crawledUrls = array();

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
        $this->id        = (isset($data['id'])) ? $data['id'] : null;
        $this->url       = (isset($data['url'])) ? $data['url'] : null;
        $this->createdOn = (isset($data['created_on'])) ? $data['created_on'] : null;
        $this->updatedOn = (isset($data['updated_on'])) ? $data['updated_on'] : null;
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
     * @return Crawler
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
     * @return Crawler
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
        return $this->createdOn;
    }

    /**
     * @param $createdOn
     *
     * @return Crawler
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
        return $this->updatedOn;
    }

    /**
     * @param $updatedOn
     *
     * @return Crawler
     */
    public function setUpdatedOn($updatedOn)
    {
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
     * @return Crawler
     */
    public function setCrawledUrls(array $urls)
    {
        $this->crawledUrls = $urls;
        return $this;
    }

    /**
     * @param string $url
     *
     * @return Crawler
     */
    public function addCrawledUrl($url)
    {
        if (empty($this->crawledUrls[$url])) {
            $this->crawledUrls[$url] = 1;
        } else {
            $this->crawledUrls[$url]++;
        }

        return $this;
    }

}