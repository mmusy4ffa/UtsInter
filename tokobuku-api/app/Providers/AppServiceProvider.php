<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('kategori', function ($attribute, $value, $parameters, $validator) {

            $allowedCategories = ['nama_kategori'];
            return in_array($value, $allowedCategories);
        });

        // Validator::extend('buku', function ($attribute, $value, $parameters, $validator) {

        //     $allowedCategories = ['judul', 'penulis', 'harga', 'stok', 'kategori_id'];
        //     return in_array($value, $allowedCategories);
        // });
    }

}
