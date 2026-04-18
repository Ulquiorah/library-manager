<?php

namespace App\Models;

use Illuminate\Auth\EloquentUserProvider;

class Menu extends EloquentUserProvider{
    protected $table = 'menu';
    protected $pk = "idMenu";
}