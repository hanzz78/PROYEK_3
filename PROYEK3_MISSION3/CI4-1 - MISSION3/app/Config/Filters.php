<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\Cors;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\SecureHeaders;

// Tambahkan RoleFilter custom kita
use App\Filters\RoleFilter;

class Filters extends BaseFilters
{
    /**
     * Alias filter → supaya gampang dipakai di Routes.
     */
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'cors'          => Cors::class,
        'forcehttps'    => ForceHTTPS::class,
        'pagecache'     => PageCache::class,
        'performance'   => PerformanceMetrics::class,

        // 🔑 custom role filter
        'role'          => RoleFilter::class,
    ];

    /**
     * Filter wajib (jalan selalu).
     */
    public array $required = [
        'before' => [
            // Kalau mau aktif force HTTPS → buka komen
            // 'forcehttps',
        ],
        'after' => [
            'toolbar', // Debug toolbar biar gampang debugging
        ],
    ];

    /**
     * Filter global → jalan di semua request.
     */
    public array $globals = [
        'before' => [
            // Aktifkan CSRF global untuk semua form
          //  'csrf',//
        ],
        'after' => [
            // 'secureheaders',
        ],
    ];

    /**
     * Filter berdasarkan HTTP method.
     * Contoh: hanya POST pakai csrf, dsb.
     */
    public array $methods = [
        // 'post' => ['csrf'],
    ];

    /**
     * Filter untuk pattern URI tertentu.
     * Bisa dipakai kalau mau set langsung disini, tanpa di Routes.
     */
    public array $filters = [
        // contoh: kalau mau semua /admin/* harus role admin
        // 'role' => [
        //     'before' => ['admin/*']
        // ]
    ];
}
