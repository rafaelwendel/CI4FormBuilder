<?php

namespace CI4FormBuilder;

class Template
{
    private $availableOptions = [
        'beforeForm', 
        'afterForm', 
        'beforeComponent', 
        'afterComponent',
        'beforeErrorMessage',
        'afterErrorMessage',
    ];

    private $options = [];

    /**
     * Construct method (Set the template options)
     * Available options: 'beforeForm', 'afterForm', 'beforeComponent', 'afterComponent', 
     * 'beforeErrorMessage', 'afterErrorMessage'
     * 
     * @access public
     * @param array  $options a key/value pair of form options, respecting the $availableOptions
     * @return void
     */
    public function __construct(array $options = [])
    {
        $this->set($options);
    }

    /**
     * Set the template options
     * Available options: 'beforeForm', 'afterForm', 'beforeComponent', 'afterComponent', 
     * 'beforeErrorMessage', 'afterErrorMessage'
     * 
     * @access public
     * @param array  $options a key/value pair of form options, respecting the $availableOptions
     * @return Template
     */
    public function set(array $options)
    {
        if(is_array($options)) {
            foreach ($options as $key => $value) {
                if (in_array($key, $this->availableOptions)) {
                    $this->options[$key] = $value;
                }
            }
        }
        
        return $this;
    }

    /**
     * Returns an specific option of template
     * @access public
     * @param string  $option the template option
     * @return string
     */
    public function get($option)
    {
        if($this->has($option)) {
            return $this->options[$option];
        }
    }

    /**
     * Verify if an option is set
     * @access public
     * @return bool
     */
    public function has($option) : bool
    {
        return isset($this->options[$option]);
    }
}