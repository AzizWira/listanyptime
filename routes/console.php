<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment('Keep it cute, clear, and easy to update.');
})->purpose('Display a small project reminder');
