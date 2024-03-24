<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Admin::index');

$routes->get('/pengguna', 'Pengguna::index');
$routes->get('/pengguna/hapus/(:num)', 'Pengguna::hapus/$1');
$routes->post('/pengguna/tambah', 'Pengguna::tambah');
$routes->post('/pengguna/upload/(:num)', 'Pengguna::upload/$1');

$routes->get('/pdf/provinsi', 'PDF::provinsi');
$routes->get('/pdf/kabupaten/(:num)', 'PDF::kabupaten/$1');
$routes->get('/pdf/kecamatan/(:num)', 'PDF::kecamatan/$1');
$routes->get('/pdf/desa/(:num)', 'PDF::desa/$1');

$routes->get('/excel/provinsi', 'Excel::provinsi');
$routes->get('/excel/kabupaten/(:num)', 'Excel::kabupaten/$1');
$routes->get('/excel/kecamatan/(:num)', 'Excel::kecamatan/$1');
$routes->get('/excel/desa/(:num)', 'Excel::desa/$1');

$routes->get('/admin', 'Admin::index');
$routes->get('/logout', 'Admin::logout');
$routes->post('/login', 'Admin::login');

$routes->get('provinsi/(:num)', 'Provinsi::index/$1');
$routes->get('provinsi/(:num)/(:num)', 'Provinsi::index/$1/$2');
$routes->get('/kabupaten/(:num)/(:num)', 'Kabupaten::index/$1/$2');
$routes->get('/kabupaten/(:num)/(:num)/(:num)', 'Kabupaten::index/$1/$2/$3');
$routes->get('/kecamatan/(:num)/(:num)/(:num)', 'Kecamatan::index/$1/$2/$3');
$routes->get('/kecamatan/(:num)/(:num)/(:num)/(:num)', 'Kecamatan::index/$1/$2/$3/$4');
$routes->get('/desa/(:num)/(:num)/(:num)/(:num)', 'Desa::index/$1/$2/$3/$4');
$routes->get('/desa/(:num)/(:num)/(:num)/(:num)/(:num)', 'Desa::index/$1/$2/$3/$4/$5');

$routes->get('/provinsi/hapus/(:num)', 'Provinsi::hapus/$1');
$routes->get('/kabupaten/hapus/(:num)', 'Kabupaten::hapus/$1');
$routes->get('/kecamatan/hapus/(:num)', 'Kecamatan::hapus/$1');
$routes->get('/desa/hapus/(:num)', 'Desa::hapus/$1');

$routes->post('/provinsi/tambah', 'Provinsi::tambah');
$routes->post('/kabupaten/tambah', 'Kabupaten::tambah');
$routes->post('/kecamatan/tambah', 'Kecamatan::tambah');
$routes->post('/desa/tambah', 'Desa::tambah');

$routes->get('/provinsi/form_ubah', 'Provinsi::form_ubah');
$routes->get('/kabupaten/form_ubah/(:num)/(:num)', 'Kabupaten::form_ubah/$1/$2');
$routes->get('/kecamatan/form_ubah/(:num)/(:num)/(:num)', 'Kecamatan::form_ubah/$1/$2/$3');
$routes->get('/desa/form_ubah/(:num)/(:num)/(:num)/(:num)', 'Desa::form_ubah/$1/$2/$3/$4');

$routes->post('/provinsi/ubah', 'Provinsi::ubah');
$routes->post('/kabupaten/ubah', 'Kabupaten::ubah');
$routes->post('/kecamatan/ubah', 'Kecamatan::ubah');
$routes->post('/desa/ubah', 'Desa::ubah');

$routes->post('/kabupaten/batch_add/(:num)', 'kabupaten::batch_add/$1');
$routes->post('/kecamatan/batch_add/(:num)/(:num)', 'Kecamatan::batch_add/$1/$2');
$routes->post('/desa/batch_add/(:num)/(:num)/(:num)', 'Desa::batch_add/$1/$2/$3');
$routes->post('/desa/batch_delete', 'Desa::batch_delete');