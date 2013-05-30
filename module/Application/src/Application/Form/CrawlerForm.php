<?php
namespace Application\Form;

use Zend\Form\Form;

/**
 * Class LoginForm
 *
 * @package Application\Form
 */
class CrawlerForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('crawler');
        $this->setAttribute('method', 'post');

        $this->add(
            array(
                'name'       => 'url',
                'attributes' => array(
                    'type' => 'text',
                ),
                'options'    => array(
                    'label' => 'URL',
                ),
            )
        );

        $this->add(
            array(
                'name'       => 'submit',
                'attributes' => array(
                    'type'  => 'submit',
                    'value' => 'Go',
                    'id'    => 'submitbutton',
                    'class' => 'btn'
                ),
                'options'    => array(
                    'label' => 'GO'
                )
            )
        );
    }
}