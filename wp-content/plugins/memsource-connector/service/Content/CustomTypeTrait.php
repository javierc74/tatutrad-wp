<?php

namespace Memsource\Service\Content;

trait CustomTypeTrait
{


    /** @var $label string|null */
    protected $label;

    /** @var $type string|null */
    protected $type;



    /**
     * Setter for 'type' property.
     * @param $type string
     * @return void
     */
    public function setType($type)
    {
        $this->type = $type;
    }



    /**
     * @inheritdoc
     */
    public function getType()
    {
        return $this->type;
    }



    /**
     * Setter for 'label' property.
     * @param $label string
     * @return void
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }



    /**
     * @inheritdoc
     */
    public function getLabel()
    {
        return $this->label;
    }
}