<?php

namespace CI4FormBuilder;

abstract class FormTypeAbstract
{    
    private Form $form;
    private Template $template;
    private $submitLabel;

    /**
     * Construct method (Set the Template options and submit button label. Create the Form instance)
     * @access public
     * @param array  $templateOptions an array with Template available options
     * @param string $submitLabel the label of form submit button
     * @return void
     */
    public function __construct($templateOptions = [], $submitLabel = 'Save')
    {
        $this->template = new Template($templateOptions);
        $this->form = new Form();
        $this->form->setTemplate($this->template);
        $this->submitLabel = $submitLabel;
    }

    /**
     * Subclasses must implement this method in order to create and add Form components.
     * @access protected
     * @return void
     */
    abstract protected function setComponents();

    /**
     * Set (Form) Template
     * @access public
     * @param Template $template a Template instance
     * @return void
     */
    public function setTemplate(Template $template)
    {
        $this->template = $template;
        $this->form->setTemplate($this->template);
    }

    /**
     * Get (Form) Template
     * @access public
     * @return Template
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Set form submit button label
     * @access public
     * @param string $label submit label
     * @return void
     */
    public function setSubmitLabel($label)
    {
        $this->submitLabel = $label;
    }

    /**
     * Get form submit button label
     * @access public
     * @return string
     */
    public function getSubmitLabel()
    {
        return $this->submitLabel;
    }

    /**
     * Set the Template options
     * @access public
     * @param array $templateOptions available options defined in Template class
     * @return void
     */
    public function setTemplateOptions($templateOptions) 
    {
        $this->template->set($templateOptions);
    }

    /**
     * Add a component (or a list of components) into form
     * @access public
     * @param array|AbstractComponent $components A component or array of components
     * @return void
     */
    public function addComponent($component)
    {
        $this->form->addComponent($component);
    }
    
    /**
     * Set the form data to populate the components
     * @access public
     * @param array|object $formData An object or array returned by a model, or request data submited
     * @return void
     */
    public function setFormData($formData)
    {
        $this->form->setFormData($formData);
    }

    /**
     * Display/prints the form
     * @access public
     * @return string
     */
    public function display() : string
    {
        $this->setComponents();
        return $this->form->display();
    }
    
    /**
     * Call display method to prints the form
     * @access public
     * @return string
     */
    public function __toString()
    {
        return $this->display();
    }
}