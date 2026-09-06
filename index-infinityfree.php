<?php
/**
 * Entry point untuk InfinityFree / Hosting tanpa kontrol document root
 *
 * Letakkan di root folder hosting, dan pastikan folder berikut sudah terupload:
 * - /app
 * - /config
 * - /core
 * - /database
 * - /resources
 * - /routes
 * - /storage
 * - /public (hanya file CSS, JS, vendor)
 */

// Define path constants
define('SAKUCI_BASE_PATH', __DIR__);
define('SAKUCI_PUBLIC_PATH', __DIR__ . '/public');

// Include bootstrap
require_once SAKUCI_BASE_PATH . '/core/bootstrap.php';

// Jalankan aplikasi
app()->run();
