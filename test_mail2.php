<?php
use Illuminate\Support\Facades\Mail;

try {
    Mail::raw('Tests no Laravel!', function($m) {
        $m->to('test@test.com')->subject('Laravel mail tests');
    });
    echo "E-pasts nosūtīts!\n";
} catch (\Exception $e) {
    echo "Kļūda: " . $e->getMessage() . "\n";
}
