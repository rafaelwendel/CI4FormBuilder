<?php

namespace CI4FormBuilder;

class Button extends AbstractComponent
{
    public function __construct($data = '', string $content = '', $extra = '')
    {
        parent::__construct();
        $this->name = (is_array($data))
                      ? $data['name']
                      : $data;
        $this->params = [
            'data'    => $data,
            'content' => $content,
            'extra'   => $extra,
        ];
    }
    
    /**
     * @override
     * Use a CI4 function to return a new button component
     * @access public
     * @return string
     */
    public function outputComponent()
    {
        return form_button($this->params['data'], $this->params['content'], $this->params['extra']);
    }
}