<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

route::get('{course}/checkout', [PaymentController::class, 'checkout'])->name('checkout');

route::get('{course}/pay', [PaymentController::class, 'pay'])->name('pay');

route::get('{course}/approved', [PaymentController::class, 'approved'])->name('approved');