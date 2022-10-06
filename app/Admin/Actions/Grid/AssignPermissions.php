<?php

namespace App\Admin\Actions\Grid;

use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Widgets\Modal;

class AssignPermissions extends RowAction
{
    /**
     * @return string
     */
    protected $title = '开通权限';

    public $permissions;
    public $salespeople;

    public function __construct($title = null)
    {
        parent::__construct($this->title);

        $this->permissions = $title['permissions'];
        $this->salespeople = $title['salespeople'];
    }

    public function render()
    {
        $form = \App\Admin\Forms\AssignPermissions::make()->payload(['id' => $this->getKey(), 'permissions' =>
            $this->permissions, 'salespeople' => $this->salespeople]);

        return Modal::make()
            ->lg()
            ->title($this->title)
            ->body($form)
            ->button('<a class="btn btn-sm btn-success"><i class="fa fa-unlock-alt"></i></a> ');
    }
}
