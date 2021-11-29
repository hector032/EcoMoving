<?php

namespace App\Exception;

use Exception;
use Symfony\Component\Form\FormInterface;

class FormValidationException extends Exception
{
    /**
     * @var FormInterface
     */
    private $form;

    /**
     * @param FormInterface $form
     */
    public function __construct(FormInterface $form)
    {
        $this->form = $form;
        $formErrorIterator = $this->form->getErrors(true);
        $formError = $formErrorIterator->current();
        $message = $formError ? $formError->getMessage() : 'Form not valid or not submitted';
        parent::__construct($message);
    }

    /**
     * @return FormInterface
     */
    public function getForm(): FormInterface
    {
        return $this->form;
    }
}