<?php

namespace Backend\Modules\Payments\Engine\Base;

use Backend\Core\Engine\Form;
use Backend\Core\Engine\Meta;

/**
 * Class MethodActionEdit
 * @package Backend\Modules\Payments\Engine\Base
 */
class MethodActionEdit extends MethodAction
{

    /**
     * The form instance
     *
     * @var Form
     */
    protected $frm;

    /**
     * The id of the item to edit
     *
     * @var int
     */
    protected $id;

    /**
     * The backends meta-object
     *
     * @var Meta
     */
    protected $meta;

    /**
     * The data of the item to edit
     *
     * @var array
     */
    protected $record;

    /**
     * Parse the form
     */
    protected function parse()
    {
        parent::parse();

        if ($this->frm) {
            $this->frm->parse($this->tpl);
        }
    }
}
