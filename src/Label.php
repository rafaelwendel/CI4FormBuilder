<?php

namespace CI4FormBuilder;

class Label extends AbstractComponent
{
    public function __construct(string $labelText = '', string $id = '', array $attributes = [])
    {
        parent::__construct();
        $this->extraKey = 'labelExtra';

        $this->params = [
            'labelText'  => $labelText,
            'id'         => $id,
            'attributes' => $attributes,
        ];
    }

    /**
     * @override
     * Use a CI4 function to return a new label component
     * @access public
     * @return string
     */
    public function outputComponent()
    {
        return form_label($this->params['labelText'], $this->params['id'], $this->params['attributes']) . "\n";
    }

    /**
     * @override
     * Override the super class method
     * @access public
     * @return string
     */
    public function display()
    {
        $this->checkExtraParam('attributes');
        return "\t\t" . $this->outputComponent();
    }
}