<?php

use App\Http\Controllers\Admin\CmsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController as Chat;
use App\Http\Controllers\CompanyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/company', [CompanyController::class, 'index']);
// Login Admin
Route::group(['middleware' => ['guest']], function () {
    Route::get('/admin/login', [App\Http\Controllers\Admin\LoginController::class, 'login'])->name('login-admin');
    Route::post('/admin/login', [App\Http\Controllers\Admin\LoginController::class, 'loginAdmin'])->name('login-admin');
    Route::get('/admin/forgot-password', [App\Http\Controllers\Admin\LoginController::class, 'forgotPassword'])->name('forgotPassword-admin');
    Route::post('/admin/forgot-password', [App\Http\Controllers\Admin\LoginController::class, 'forgotPasswordEmail'])->name('forgotPasswordEmail-admin');
    Route::get('/admin/reset-password/{email}/{token}', [App\Http\Controllers\Admin\LoginController::class, 'reset'])->name('resetPass-admin');
    Route::post('/admin/reset-password', [App\Http\Controllers\Admin\LoginController::class, 'resetPassword'])->name('resetPassword-admin');
});

// Support
Route::group(['middleware' => ['LoginCheck', 'auth', 'role:support']], function () {

    // Logout
    Route::post('/support/logout', [App\Http\Controllers\Support\DashboardController::class, 'logout'])->name('logout-support');

    // Dashboard
    Route::get('support', [App\Http\Controllers\Support\DashboardController::class, 'index'])->name('support');
    Route::get('support/fetchall', [App\Http\Controllers\Support\DashboardController::class, 'fetchAll'])->name('support-fetchAll');

    // Verifikasi Gapoktan
    Route::get('support/verifikasi-gapoktan', [App\Http\Controllers\Support\VerificateGapoktanController::class, 'index'])->name('support-verifikasi-gapoktan');
    Route::get('support/verifikasi-gapoktan/fetchall', [App\Http\Controllers\Support\VerificateGapoktanController::class, 'fetchAll'])->name('support-verifikasi-gapoktan-fetchAll');
    Route::get('support/verifikasi-gapoktan/detail/{id}', [App\Http\Controllers\Support\VerificateGapoktanController::class, 'edit'])->name('support-verifikasi-gapoktan-edit');
    Route::post('support/verifikasi-gapoktan/update', [App\Http\Controllers\Support\VerificateGapoktanController::class, 'update'])->name('support-verifikasi-gapoktan-update');

    // Pengaturan
    Route::get('support/pengaturan', [App\Http\Controllers\Support\PengaturanController::class, 'pengaturan'])->name('support-pengaturan');
    Route::post('support/pengaturan-image', [App\Http\Controllers\Support\PengaturanController::class, 'pengaturanImage'])->name('support.pengaturan.image');
    Route::post('support/pengaturan-update', [App\Http\Controllers\Support\PengaturanController::class, 'pengaturanUpdate'])->name('support.pengaturan.update');
    Route::post('support/pengaturan-updatePassword', [App\Http\Controllers\Support\PengaturanController::class, 'pengaturanUpdatePassword'])->name('support.pengaturan.updatePassword');
});

// Admin
Route::group(['middleware' => ['LoginCheck', 'auth', 'role:admin']], function () {

    // Logout
    Route::post('/admin/logout', [App\Http\Controllers\Admin\LoginController::class, 'logout'])->name('logout-admin');

    // Dashboard
    Route::get('admin', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin');
    Route::get('admin/fetchall', [App\Http\Controllers\Admin\DashboardController::class, 'fetchAll'])->name('admin-fetchAll');

    // Hero
    Route::get('admin/hero', [App\Http\Controllers\Admin\HeroController::class, 'index'])->name('admin-hero');
    Route::post('admin/hero/store', [App\Http\Controllers\Admin\HeroController::class, 'store'])->name('admin-hero-store');
    Route::get('admin/hero/fetchall', [App\Http\Controllers\Admin\HeroController::class, 'fetchAll'])->name('admin-hero-fetchAll');
    Route::delete('admin/hero/delete', [App\Http\Controllers\Admin\HeroController::class, 'delete'])->name('admin-hero-delete');
    Route::get('admin/hero/edit', [App\Http\Controllers\Admin\HeroController::class, 'edit'])->name('admin-hero-edit');
    Route::post('admin/hero/update', [App\Http\Controllers\Admin\HeroController::class, 'update'])->name('admin-hero-update');

    // Pesanan Masuk
    Route::get('admin/pesanan', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('admin.orders');
    Route::get('admin/pesanan/fetchall', [App\Http\Controllers\Admin\OrderController::class, 'fetchAll'])->name('admin.orders.fetchAll');
    Route::get('admin/pesanan/fetchDikemas', [App\Http\Controllers\Admin\OrderController::class, 'fetchDikemas'])->name('admin.orders.fetchDikemas');
    Route::get('admin/pesanan/fetchDikirim', [App\Http\Controllers\Admin\OrderController::class, 'fetchDikirim'])->name('admin.orders.fetchDikirim');
    Route::get('admin/pesanan/fetchSelesai', [App\Http\Controllers\Admin\OrderController::class, 'fetchSelesai'])->name('admin.orders.fetchSelesai');
    Route::get('admin/pesanan/fetchDibatalkan', [App\Http\Controllers\Admin\OrderController::class, 'fetchDibatalkan'])->name('admin.orders.fetchDibatalkan');
    Route::get('admin/pesanan/detail-pesanan/{id}', [App\Http\Controllers\Admin\OrderController::class, 'viewOrder'])->name('admin.viewOrder');
    Route::post('admin/pesanan/update-pesanan', [App\Http\Controllers\Admin\OrderController::class, 'updateOrder'])->name('admin.updateOrder');
    Route::post('admin/pesanan/reply-review', [App\Http\Controllers\Admin\OrderController::class, 'replyReview'])->name('admin.replyReview');

    // Jumlah Pesanan Masuk
    Route::get('admin/load-order', [App\Http\Controllers\Admin\OrderController::class, 'countOrder']);

    // Reply Ulasan
    Route::get('/admin/reply-ulasan', [App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('admin.review');
    Route::get('/admin/reply-ulasan/fetchBelumDiulas', [App\Http\Controllers\Admin\ReviewController::class, 'fetchBelumDiulas'])->name('admin.review.fetchBelumDiulas');
    Route::get('/admin/reply-ulasan/fetchUlasanSaya', [App\Http\Controllers\Admin\ReviewController::class, 'fetchUlasanSaya'])->name('admin.review.fetchUlasanSaya');

    // Jumlah Pesanan Masuk
    Route::get('admin/load-review', [App\Http\Controllers\Admin\ReviewController::class, 'countReview']);

    // Lahan
    Route::get('admin/lahan', [App\Http\Controllers\Admin\FieldController::class, 'index'])->name('admin-lahan');
    Route::post('admin/lahan/store', [App\Http\Controllers\Admin\FieldController::class, 'store'])->name('admin-lahan-store');
    Route::get('admin/lahan/fetchall', [App\Http\Controllers\Admin\FieldController::class, 'fetchAll'])->name('admin-lahan-fetchAll');
    Route::delete('admin/lahan/delete', [App\Http\Controllers\Admin\FieldController::class, 'delete'])->name('admin-lahan-delete');
    Route::post('admin/lahan/recycleField', [App\Http\Controllers\Admin\FieldController::class, 'recycleField'])->name('admin-lahan-recycleField');
    Route::get('admin/lahan/edit', [App\Http\Controllers\Admin\FieldController::class, 'edit'])->name('admin-lahan-edit');
    Route::post('admin/lahan/update', [App\Http\Controllers\Admin\FieldController::class, 'update'])->name('admin-lahan-update');
    Route::get('dropdown-farmer/{id}', [App\Http\Controllers\Admin\FieldController::class, 'farmer']);

    // Kategori Lahan
    Route::get('admin/kategori-lahan', [App\Http\Controllers\Admin\FieldCategoryController::class, 'index'])->name('admin-kategoriLahan');
    Route::post('admin/kategori-lahan/store', [App\Http\Controllers\Admin\FieldCategoryController::class, 'store'])->name('admin-kategoriLahan-store');
    Route::get('admin/kategori-lahan/fetchall', [App\Http\Controllers\Admin\FieldCategoryController::class, 'fetchAll'])->name('admin-kategoriLahan-fetchAll');
    Route::get('admin/kategori-lahan/edit', [App\Http\Controllers\Admin\FieldCategoryController::class, 'edit'])->name('admin-kategoriLahan-edit');
    Route::post('admin/kategori-lahan/update', [App\Http\Controllers\Admin\FieldCategoryController::class, 'update'])->name('admin-kategoriLahan-update');

    // Edukasi
    Route::get('admin/edukasi', [App\Http\Controllers\Admin\EducationController::class, 'index'])->name('admin-edukasi');
    Route::post('admin/edukasi/store', [App\Http\Controllers\Admin\EducationController::class, 'store'])->name('admin-edukasi-store');
    Route::get('admin/edukasi/fetchall', [App\Http\Controllers\Admin\EducationController::class, 'fetchAll'])->name('admin-edukasi-fetchAll');
    Route::delete('admin/edukasi/delete', [App\Http\Controllers\Admin\EducationController::class, 'delete'])->name('admin-edukasi-delete');
    Route::get('admin/edukasi/edit', [App\Http\Controllers\Admin\EducationController::class, 'edit'])->name('admin-edukasi-edit');
    Route::post('admin/edukasi/update', [App\Http\Controllers\Admin\EducationController::class, 'update'])->name('admin-edukasi-update');
    Route::get('admin/edukasi/checkSlug', [App\Http\Controllers\Admin\EducationController::class, 'checkSlug'])->name('admin-edukasi-checkSlug');

    // Kategori Edukasi
    Route::get('admin/kategori-edukasi', [App\Http\Controllers\Admin\EducationCategoryController::class, 'index'])->name('admin-kategoriEdukasi');
    Route::post('admin/kategori-edukasi/store', [App\Http\Controllers\Admin\EducationCategoryController::class, 'store'])->name('admin-kategoriEdukasi-store');
    Route::get('admin/kategori-edukasi/fetchall', [App\Http\Controllers\Admin\EducationCategoryController::class, 'fetchAll'])->name('admin-kategoriEdukasi-fetchAll');
    Route::get('admin/kategori-edukasi/edit', [App\Http\Controllers\Admin\EducationCategoryController::class, 'edit'])->name('admin-kategoriEdukasi-edit');
    Route::post('admin/kategori-edukasi/update', [App\Http\Controllers\Admin\EducationCategoryController::class, 'update'])->name('admin-kategoriEdukasi-update');
    Route::get('admin/kategori-edukasi/checkSlug', [App\Http\Controllers\Admin\EducationCategoryController::class, 'checkSlug'])->name('admin-kategoriEdukasi-checkSlug');

    // Kegiatan
    Route::get('admin/kegiatan', [App\Http\Controllers\Admin\ActivityController::class, 'index'])->name('admin-kegiatan');
    Route::post('admin/kegiatan/store', [App\Http\Controllers\Admin\ActivityController::class, 'store'])->name('admin-kegiatan-store');
    Route::get('admin/kegiatan/fetchall', [App\Http\Controllers\Admin\ActivityController::class, 'fetchAll'])->name('admin-kegiatan-fetchAll');
    Route::delete('admin/kegiatan/delete', [App\Http\Controllers\Admin\ActivityController::class, 'delete'])->name('admin-kegiatan-delete');
    Route::get('admin/kegiatan/edit', [App\Http\Controllers\Admin\ActivityController::class, 'edit'])->name('admin-kegiatan-edit');
    Route::post('admin/kegiatan/update', [App\Http\Controllers\Admin\ActivityController::class, 'update'])->name('admin-kegiatan-update');
    Route::get('admin/kegiatan/checkSlug', [App\Http\Controllers\Admin\ActivityController::class, 'checkSlug'])->name('admin-kegiatan-checkSlug');

    // Kategori Kegiatan
    Route::get('admin/kategori-kegiatan', [App\Http\Controllers\Admin\ActivityCategoryController::class, 'index'])->name('admin-kategoriKegiatan');
    Route::post('admin/kategori-kegiatan/store', [App\Http\Controllers\Admin\ActivityCategoryController::class, 'store'])->name('admin-kategoriKegiatan-store');
    Route::get('admin/kategori-kegiatan/fetchall', [App\Http\Controllers\Admin\ActivityCategoryController::class, 'fetchAll'])->name('admin-kategoriKegiatan-fetchAll');
    Route::get('admin/kategori-kegiatan/edit', [App\Http\Controllers\Admin\ActivityCategoryController::class, 'edit'])->name('admin-kategoriKegiatan-edit');
    Route::post('admin/kategori-kegiatan/update', [App\Http\Controllers\Admin\ActivityCategoryController::class, 'update'])->name('admin-kategoriKegiatan-update');
    Route::get('admin/kategori-kegiatan/checkSlug', [App\Http\Controllers\Admin\ActivityCategoryController::class, 'checkSlug'])->name('admin-kategoriKegiatan-checkSlug');

    // Kategori Produk
    Route::get('admin/kategori-produk', [App\Http\Controllers\Admin\ProductCategoryController::class, 'index'])->name('admin-kategoriProduk');
    Route::post('admin/kategori-produk/store', [App\Http\Controllers\Admin\ProductCategoryController::class, 'store'])->name('admin-kategoriProduk-store');
    Route::get('admin/kategori-produk/fetchall', [App\Http\Controllers\Admin\ProductCategoryController::class, 'fetchAll'])->name('admin-kategoriProduk-fetchAll');
    Route::get('admin/kategori-produk/edit', [App\Http\Controllers\Admin\ProductCategoryController::class, 'edit'])->name('admin-kategoriProduk-edit');
    Route::post('admin/kategori-produk/update', [App\Http\Controllers\Admin\ProductCategoryController::class, 'update'])->name('admin-kategoriProduk-update');
    Route::get('admin/kategori-produk/checkSlug', [App\Http\Controllers\Admin\ProductCategoryController::class, 'checkSlug'])->name('admin-kategoriProduk-checkSlug');

    // Produk
    Route::get('admin/produk', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('admin-produk');
    Route::post('admin/produk/store', [App\Http\Controllers\Admin\ProductController::class, 'store'])->name('admin-produk-store');
    Route::get('admin/produk/fetchall', [App\Http\Controllers\Admin\ProductController::class, 'fetchAll'])->name('admin-produk-fetchAll');
    Route::delete('admin/produk/delete', [App\Http\Controllers\Admin\ProductController::class, 'delete'])->name('admin-produk-delete');
    Route::get('admin/produk/edit', [App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('admin-produk-edit');
    Route::post('admin/produk/update', [App\Http\Controllers\Admin\ProductController::class, 'update'])->name('admin-produk-update');
    Route::get('admin/produk/checkSlug', [App\Http\Controllers\Admin\ProductController::class, 'checkSlug'])->name('admin-produk-checkSlug');
    Route::get('admin/produk/viewPhoto', [App\Http\Controllers\Admin\ProductController::class, 'viewPhoto'])->name('admin-produk-viewPhoto');
    Route::delete('admin/produk/deletePhoto', [App\Http\Controllers\Admin\ProductController::class, 'deletePhoto'])->name('admin-produk-deletePhoto');
    Route::get('admin/produk/addPhoto', [App\Http\Controllers\Admin\ProductController::class, 'addPhoto'])->name('admin-produk-addPhoto');
    Route::post('admin/produk/addPhotoProduct', [App\Http\Controllers\Admin\ProductController::class, 'addPhotoProduct'])->name('admin-produk-addPhotoProduct');

    // Daftar Gapoktan
    Route::get('admin/daftar-gapoktan', [App\Http\Controllers\Admin\GapoktanController::class, 'index'])->name('admin-gapoktan');
    Route::post('admin/daftar-gapoktan/store', [App\Http\Controllers\Admin\GapoktanController::class, 'store'])->name('admin-gapoktan-store');
    Route::get('admin/daftar-gapoktan/fetchall', [App\Http\Controllers\Admin\GapoktanController::class, 'fetchAll'])->name('admin-gapoktan-fetchAll');
    Route::delete('admin/daftar-gapoktan/delete', [App\Http\Controllers\Admin\GapoktanController::class, 'delete'])->name('admin-gapoktan-delete');
    Route::get('admin/daftar-gapoktan/edit', [App\Http\Controllers\Admin\GapoktanController::class, 'edit'])->name('admin-gapoktan-edit');
    Route::post('admin/daftar-gapoktan/update', [App\Http\Controllers\Admin\GapoktanController::class, 'update'])->name('admin-gapoktan-update');
    Route::get('admin/certificate/viewPhoto', [App\Http\Controllers\Admin\GapoktanController::class, 'viewPhoto'])->name('admin-certificate-viewPhoto');
    Route::delete('admin/certificate/deletePhoto', [App\Http\Controllers\Admin\GapoktanController::class, 'deletePhoto'])->name('admin-certificate-deletePhoto');
    Route::get('admin/certificate/addPhoto', [App\Http\Controllers\Admin\GapoktanController::class, 'addPhoto'])->name('admin-certificate-addPhoto');
    Route::post('admin/certificate/addPhotoProduct', [App\Http\Controllers\Admin\GapoktanController::class, 'addPhotoProduct'])->name('admin-certificate-addPhotoProduct');


    // Daftar Poktan
    Route::get('admin/daftar-poktan', [App\Http\Controllers\Admin\PoktanController::class, 'index'])->name('admin-poktan');
    Route::post('admin/daftar-poktan/store', [App\Http\Controllers\Admin\PoktanController::class, 'store'])->name('admin-poktan-store');
    Route::get('admin/daftar-poktan/fetchall', [App\Http\Controllers\Admin\PoktanController::class, 'fetchAll'])->name('admin-poktan-fetchAll');
    Route::delete('admin/daftar-poktan/delete', [App\Http\Controllers\Admin\PoktanController::class, 'delete'])->name('admin-poktan-delete');
    Route::get('admin/daftar-poktan/edit', [App\Http\Controllers\Admin\PoktanController::class, 'edit'])->name('admin-poktan-edit');
    Route::post('admin/daftar-poktan/update', [App\Http\Controllers\Admin\PoktanController::class, 'update'])->name('admin-poktan-update');

    // Daftar Petani
    Route::get('admin/daftar-petani', [App\Http\Controllers\Admin\FarmerController::class, 'index'])->name('admin-petani');
    Route::post('admin/daftar-petani/store', [App\Http\Controllers\Admin\FarmerController::class, 'store'])->name('admin-petani-store');
    Route::get('admin/daftar-petani/fetchall', [App\Http\Controllers\Admin\FarmerController::class, 'fetchAll'])->name('admin-petani-fetchAll');
    Route::delete('admin/daftar-petani/delete', [App\Http\Controllers\Admin\FarmerController::class, 'delete'])->name('admin-petani-delete');
    Route::get('admin/daftar-petani/edit', [App\Http\Controllers\Admin\FarmerController::class, 'edit'])->name('admin-petani-edit');
    Route::post('admin/daftar-petani/update', [App\Http\Controllers\Admin\FarmerController::class, 'update'])->name('admin-petani-update');
    Route::get('dropdown-poktan/{id}', [App\Http\Controllers\Admin\FarmerController::class, 'poktan']);

    // Tandur
    Route::get('admin/tandur', [App\Http\Controllers\Admin\PlantController::class, 'index'])->name('admin-tandur');
    Route::post('admin/tandur/store', [App\Http\Controllers\Admin\PlantController::class, 'store'])->name('admin-tandur-store');
    Route::get('admin/tandur/fetchall', [App\Http\Controllers\Admin\PlantController::class, 'fetchAll'])->name('admin-tandur-fetchAll');
    Route::delete('admin/tandur/delete', [App\Http\Controllers\Admin\PlantController::class, 'delete'])->name('admin-tandur-delete');
    Route::get('admin/tandur/edit', [App\Http\Controllers\Admin\PlantController::class, 'edit'])->name('admin-tandur-edit');
    Route::post('admin/tandur/update', [App\Http\Controllers\Admin\PlantController::class, 'update'])->name('admin-tandur-update');

    // Panen
    Route::get('admin/panen', [App\Http\Controllers\Admin\HarvestController::class, 'index'])->name('admin-panen');
    Route::post('admin/panen/store', [App\Http\Controllers\Admin\HarvestController::class, 'store'])->name('admin-panen-store');
    Route::get('admin/panen/fetchall', [App\Http\Controllers\Admin\HarvestController::class, 'fetchAll'])->name('admin-panen-fetchAll');
    Route::get('admin/panen/edit', [App\Http\Controllers\Admin\HarvestController::class, 'edit'])->name('admin-panen-edit');

    // Riwayat Penanam
    Route::get('admin/riwayat-penanam', [App\Http\Controllers\Admin\PlantingHistoryController::class, 'index'])->name('admin-riwayat-penanam');
    Route::get('admin/riwayat-penanam/fetchall', [App\Http\Controllers\Admin\PlantingHistoryController::class, 'fetchAll'])->name('admin-riwayat-penanam-fetchAll');
    Route::get('admin/riwayat-penanam/edit', [App\Http\Controllers\Admin\PlantingHistoryController::class, 'edit'])->name('admin-riwayat-penanam-edit');

    // Rekap Penjualan
    Route::get('admin/rekap-penjualan', [App\Http\Controllers\Admin\SalesRekapController::class, 'index'])->name('admin-sales-rekap');
    Route::get('admin/rekap-penjualan/fetchall', [App\Http\Controllers\Admin\SalesRekapController::class, 'fetchAll'])->name('admin-salesRekap-fetchAll');

    // Pengaturan
    Route::get('admin/pengaturan', [App\Http\Controllers\Admin\PengaturanController::class, 'pengaturan'])->name('admin-pengaturan');
    Route::post('admin/pengaturan-image', [App\Http\Controllers\Admin\PengaturanController::class, 'pengaturanImage'])->name('admin.pengaturan.image');
    Route::post('admin/pengaturan-update', [App\Http\Controllers\Admin\PengaturanController::class, 'pengaturanUpdate'])->name('admin.pengaturan.update');
    Route::post('admin/pengaturan-updatePassword', [App\Http\Controllers\Admin\PengaturanController::class, 'pengaturanUpdatePassword'])->name('admin.pengaturan.updatePassword');

    Route::get('admin/cms', [CmsController::class, 'index']);
    Route::post('admin/cms/update', [CmsController::class, 'update']);
    Route::post('admin/cms/update-img', [CmsController::class, 'updateImage']);
    Route::post('admin/cms/update-img-multiple', [CmsController::class, 'updateImageMultiple']);
});

// Login Gapoktan
// Route::group(['middleware' => ['guest']], function() {
//     Route::get('/gapoktan/login', [App\Http\Controllers\Gapoktan\LoginController::class, 'login'])->name('login-gapoktan');
//     Route::post('/gapoktan/login', [App\Http\Controllers\Gapoktan\LoginController::class, 'loginGapoktan'])->name('login-gapoktan');

Route::get('/gapoktan/register', [App\Http\Controllers\Gapoktan\LoginController::class, 'register'])->name('register-gapoktan');
Route::post('/gapoktan/register', [App\Http\Controllers\Gapoktan\LoginController::class, 'registerGapoktan'])->name('registerGapoktan-gapoktan');
// });



// Gapoktan
Route::group(['middleware' => ['LoginCheck', 'auth', 'role:gapoktan']], function () {

    // Logout
    Route::post('/gapoktan/logout', [App\Http\Controllers\Gapoktan\LoginController::class, 'logout'])->name('logout-gapoktan');

    // Dashboard
    Route::get('gapoktan', [App\Http\Controllers\Gapoktan\DashboardController::class, 'index'])->name('gapoktan');
    Route::get('gapoktan/fetchall', [App\Http\Controllers\Gapoktan\DashboardController::class, 'fetchAll'])->name('gapoktan-fetchAll');

    // Notifikasi Dibaca
    Route::post('gapoktan/markasreadUser', [App\Http\Controllers\Gapoktan\NotificationController::class, 'markNotificationUser'])->name('gapoktan.markas.read.user');
    Route::post('gapoktan/markasreadPlant', [App\Http\Controllers\Gapoktan\NotificationController::class, 'markNotificationPlant'])->name('gapoktan.markas.read.plant');
    Route::post('gapoktan/markasreadHarvest', [App\Http\Controllers\Gapoktan\NotificationController::class, 'markNotificationHarvest'])->name('gapoktan.markas.read.harvest');

    // Chat
    Route::get('/gapoktan/chat', [App\Http\Controllers\Gapoktan\ChatController::class, 'index'])->name('gapoktan.chat');
    Route::post('/gapoktan/chat', [App\Http\Controllers\Gapoktan\ChatController::class, 'createChat'])->name('gapoktan.createChat');
    // Route::get('gapoktan/chat', function() {
    //     return view('gapoktan.chat.index');
    // })->name('gapoktan.chat');

    // Kategori Lahan
    Route::get('gapoktan/kategori-lahan', [App\Http\Controllers\Gapoktan\FieldCategoryController::class, 'index'])->name('gapoktan-kategoriLahan');
    Route::post('gapoktan/kategori-lahan/store', [App\Http\Controllers\Gapoktan\FieldCategoryController::class, 'store'])->name('gapoktan-kategoriLahan-store');
    Route::get('gapoktan/kategori-lahan/fetchall', [App\Http\Controllers\Gapoktan\FieldCategoryController::class, 'fetchAll'])->name('gapoktan-kategoriLahan-fetchAll');
    Route::get('gapoktan/kategori-lahan/edit', [App\Http\Controllers\Gapoktan\FieldCategoryController::class, 'edit'])->name('gapoktan-kategoriLahan-edit');
    Route::post('gapoktan/kategori-lahan/update', [App\Http\Controllers\Gapoktan\FieldCategoryController::class, 'update'])->name('gapoktan-kategoriLahan-update');

    // Lahan
    Route::get('gapoktan/lahan', [App\Http\Controllers\Gapoktan\FieldController::class, 'index'])->name('gapoktan-lahan');
    Route::post('gapoktan/lahan/store', [App\Http\Controllers\Gapoktan\FieldController::class, 'store'])->name('gapoktan-lahan-store');
    Route::get('gapoktan/lahan/fetchall', [App\Http\Controllers\Gapoktan\FieldController::class, 'fetchAll'])->name('gapoktan-lahan-fetchAll');
    Route::delete('gapoktan/lahan/delete', [App\Http\Controllers\Gapoktan\FieldController::class, 'delete'])->name('gapoktan-lahan-delete');
    Route::post('gapoktan/lahan/recycleField', [App\Http\Controllers\Gapoktan\FieldController::class, 'recycleField'])->name('gapoktan-lahan-recycleField');
    Route::get('gapoktan/lahan/edit', [App\Http\Controllers\Gapoktan\FieldController::class, 'edit'])->name('gapoktan-lahan-edit');
    Route::post('gapoktan/lahan/update', [App\Http\Controllers\Gapoktan\FieldController::class, 'update'])->name('gapoktan-lahan-update');

    // Edukasi
    Route::get('gapoktan/edukasi', [App\Http\Controllers\Gapoktan\EducationController::class, 'index'])->name('gapoktan-edukasi');
    Route::post('gapoktan/edukasi/store', [App\Http\Controllers\Gapoktan\EducationController::class, 'store'])->name('gapoktan-edukasi-store');
    Route::get('gapoktan/edukasi/fetchall', [App\Http\Controllers\Gapoktan\EducationController::class, 'fetchAll'])->name('gapoktan-edukasi-fetchAll');
    Route::delete('gapoktan/edukasi/delete', [App\Http\Controllers\Gapoktan\EducationController::class, 'delete'])->name('gapoktan-edukasi-delete');
    Route::get('gapoktan/edukasi/edit', [App\Http\Controllers\Gapoktan\EducationController::class, 'edit'])->name('gapoktan-edukasi-edit');
    Route::post('gapoktan/edukasi/update', [App\Http\Controllers\Gapoktan\EducationController::class, 'update'])->name('gapoktan-edukasi-update');
    Route::get('gapoktan/edukasi/checkSlug', [App\Http\Controllers\Gapoktan\EducationController::class, 'checkSlug'])->name('gapoktan-edukasi-checkSlug');

    // Kategori Edukasi
    Route::get('changeStatus', [App\Http\Controllers\Gapoktan\EducationCategoryController::class, 'changeStatus']);
    Route::get('gapoktan/kategori-edukasi', [App\Http\Controllers\Gapoktan\EducationCategoryController::class, 'index'])->name('gapoktan-kategoriEdukasi');
    Route::post('gapoktan/kategori-edukasi/store', [App\Http\Controllers\Gapoktan\EducationCategoryController::class, 'store'])->name('gapoktan-kategoriEdukasi-store');
    Route::get('gapoktan/kategori-edukasi/fetchall', [App\Http\Controllers\Gapoktan\EducationCategoryController::class, 'fetchAll'])->name('gapoktan-kategoriEdukasi-fetchAll');
    Route::get('gapoktan/kategori-edukasi/edit', [App\Http\Controllers\Gapoktan\EducationCategoryController::class, 'edit'])->name('gapoktan-kategoriEdukasi-edit');
    Route::post('gapoktan/kategori-edukasi/update', [App\Http\Controllers\Gapoktan\EducationCategoryController::class, 'update'])->name('gapoktan-kategoriEdukasi-update');
    Route::get('gapoktan/kategori-edukasi/checkSlug', [App\Http\Controllers\Gapoktan\EducationCategoryController::class, 'checkSlug'])->name('gapoktan-kategoriEdukasi-checkSlug');

    // Kegiatan
    Route::get('gapoktan/kegiatan', [App\Http\Controllers\Gapoktan\ActivityController::class, 'index'])->name('gapoktan-kegiatan');
    Route::post('gapoktan/kegiatan/store', [App\Http\Controllers\Gapoktan\ActivityController::class, 'store'])->name('gapoktan-kegiatan-store');
    Route::get('gapoktan/kegiatan/fetchAddActivity', [App\Http\Controllers\Gapoktan\ActivityController::class, 'fetchAddActivity'])->name('gapoktan-kegiatan-fetchAddActivity');
    Route::get('gapoktan/kegiatan/fetchDraftActivity', [App\Http\Controllers\Gapoktan\ActivityController::class, 'fetchDraftActivity'])->name('gapoktan-kegiatan-fetchDraftActivity');
    Route::delete('gapoktan/kegiatan/delete', [App\Http\Controllers\Gapoktan\ActivityController::class, 'delete'])->name('gapoktan-kegiatan-delete');
    Route::get('gapoktan/kegiatan/edit', [App\Http\Controllers\Gapoktan\ActivityController::class, 'edit'])->name('gapoktan-kegiatan-edit');
    Route::get('gapoktan/kegiatan/show', [App\Http\Controllers\Gapoktan\ActivityController::class, 'show'])->name('gapoktan-kegiatan-showActivity');
    Route::post('gapoktan/kegiatan/update', [App\Http\Controllers\Gapoktan\ActivityController::class, 'update'])->name('gapoktan-kegiatan-update');
    Route::get('gapoktan/kegiatan/checkSlug', [App\Http\Controllers\Gapoktan\ActivityController::class, 'checkSlug'])->name('gapoktan-kegiatan-checkSlug');

    // Kategori Kegiatan
    Route::get('gapoktan/kategori-kegiatan', [App\Http\Controllers\Gapoktan\ActivityCategoryController::class, 'index'])->name('gapoktan-kategoriKegiatan');
    Route::post('gapoktan/kategori-kegiatan/store', [App\Http\Controllers\Gapoktan\ActivityCategoryController::class, 'store'])->name('gapoktan-kategoriKegiatan-store');
    Route::get('gapoktan/kategori-kegiatan/fetchall', [App\Http\Controllers\Gapoktan\ActivityCategoryController::class, 'fetchAll'])->name('gapoktan-kategoriKegiatan-fetchAll');
    Route::get('gapoktan/kategori-kegiatan/edit', [App\Http\Controllers\Gapoktan\ActivityCategoryController::class, 'edit'])->name('gapoktan-kategoriKegiatan-edit');
    Route::post('gapoktan/kategori-kegiatan/update', [App\Http\Controllers\Gapoktan\ActivityCategoryController::class, 'update'])->name('gapoktan-kategoriKegiatan-update');
    Route::get('gapoktan/kategori-kegiatan/checkSlug', [App\Http\Controllers\Gapoktan\ActivityCategoryController::class, 'checkSlug'])->name('gapoktan-kategoriKegiatan-checkSlug');

    // Kategori Produk
    Route::get('gapoktan/kategori-produk', [App\Http\Controllers\Gapoktan\ProductCategoryController::class, 'index'])->name('gapoktan-kategoriProduk');
    Route::post('gapoktan/kategori-produk/store', [App\Http\Controllers\Gapoktan\ProductCategoryController::class, 'store'])->name('gapoktan-kategoriProduk-store');
    Route::get('gapoktan/kategori-produk/fetchall', [App\Http\Controllers\Gapoktan\ProductCategoryController::class, 'fetchAll'])->name('gapoktan-kategoriProduk-fetchAll');
    Route::get('gapoktan/kategori-produk/edit', [App\Http\Controllers\Gapoktan\ProductCategoryController::class, 'edit'])->name('gapoktan-kategoriProduk-edit');
    Route::post('gapoktan/kategori-produk/update', [App\Http\Controllers\Gapoktan\ProductCategoryController::class, 'update'])->name('gapoktan-kategoriProduk-update');
    Route::get('gapoktan/kategori-produk/checkSlug', [App\Http\Controllers\Gapoktan\ProductCategoryController::class, 'checkSlug'])->name('gapoktan-kategoriProduk-checkSlug');

    // Produk
    Route::get('gapoktan/produk', [App\Http\Controllers\Gapoktan\ProductController::class, 'index'])->name('gapoktan-produk');
    Route::post('gapoktan/produk/store', [App\Http\Controllers\Gapoktan\ProductController::class, 'store'])->name('gapoktan-produk-store');
    Route::get('gapoktan/produk/fetchall', [App\Http\Controllers\Gapoktan\ProductController::class, 'fetchAll'])->name('gapoktan-produk-fetchAll');
    Route::delete('gapoktan/produk/delete', [App\Http\Controllers\Gapoktan\ProductController::class, 'delete'])->name('gapoktan-produk-delete');
    Route::get('gapoktan/produk/edit', [App\Http\Controllers\Gapoktan\ProductController::class, 'edit'])->name('gapoktan-produk-edit');
    Route::post('gapoktan/produk/update', [App\Http\Controllers\Gapoktan\ProductController::class, 'update'])->name('gapoktan-produk-update');
    Route::get('gapoktan/produk/checkSlug', [App\Http\Controllers\Gapoktan\ProductController::class, 'checkSlug'])->name('gapoktan-produk-checkSlug');
    Route::get('gapoktan/produk/viewPhoto', [App\Http\Controllers\Gapoktan\ProductController::class, 'viewPhoto'])->name('gapoktan-produk-viewPhoto');
    Route::delete('gapoktan/produk/deletePhoto', [App\Http\Controllers\Gapoktan\ProductController::class, 'deletePhoto'])->name('gapoktan-produk-deletePhoto');
    Route::get('gapoktan/produk/addPhoto', [App\Http\Controllers\Gapoktan\ProductController::class, 'addPhoto'])->name('gapoktan-produk-addPhoto');
    Route::post('gapoktan/produk/addPhotoProduct', [App\Http\Controllers\Gapoktan\ProductController::class, 'addPhotoProduct'])->name('gapoktan-produk-addPhotoProduct');

    // Daftar Poktan
    Route::get('gapoktan/daftar-poktan', [App\Http\Controllers\Gapoktan\PoktanController::class, 'index'])->name('gapoktan-poktan');
    Route::post('gapoktan/daftar-poktan/store', [App\Http\Controllers\Gapoktan\PoktanController::class, 'store'])->name('gapoktan-poktan-store');
    Route::get('gapoktan/daftar-poktan/fetchall', [App\Http\Controllers\Gapoktan\PoktanController::class, 'fetchAll'])->name('gapoktan-poktan-fetchAll');
    Route::delete('gapoktan/daftar-poktan/delete', [App\Http\Controllers\Gapoktan\PoktanController::class, 'delete'])->name('gapoktan-poktan-delete');
    Route::get('gapoktan/daftar-poktan/edit', [App\Http\Controllers\Gapoktan\PoktanController::class, 'edit'])->name('gapoktan-poktan-edit');
    Route::post('gapoktan/daftar-poktan/update', [App\Http\Controllers\Gapoktan\PoktanController::class, 'update'])->name('gapoktan-poktan-update');

    // Rekap Penjualan
    Route::get('gapoktan/rekap-penjualan', [App\Http\Controllers\Gapoktan\SalesRekapController::class, 'index'])->name('gapoktan-sales-rekap');
    Route::get('gapoktan/rekap-penjualan/fetchall', [App\Http\Controllers\Gapoktan\SalesRekapController::class, 'fetchAll'])->name('gapoktan-salesRekap-fetchAll');

    // Pesanan Masuk
    Route::get('gapoktan/pesanan', [App\Http\Controllers\Gapoktan\OrderController::class, 'index'])->name('gapoktan.orders');
    Route::get('gapoktan/pesanan/fetchDikemas', [App\Http\Controllers\Gapoktan\OrderController::class, 'fetchDikemas'])->name('gapoktan.orders.fetchDikemas');
    Route::get('gapoktan/pesanan/fetchDikirim', [App\Http\Controllers\Gapoktan\OrderController::class, 'fetchDikirim'])->name('gapoktan.orders.fetchDikirim');
    Route::get('gapoktan/pesanan/fetchSelesai', [App\Http\Controllers\Gapoktan\OrderController::class, 'fetchSelesai'])->name('gapoktan.orders.fetchSelesai');
    Route::get('gapoktan/pesanan/detail-pesanan/{id}', [App\Http\Controllers\Gapoktan\OrderController::class, 'viewOrder'])->name('gapoktan.viewOrder');
    Route::post('gapoktan/pesanan/update-pesanan', [App\Http\Controllers\Gapoktan\OrderController::class, 'updateOrder'])->name('gapoktan.updateOrder');
    Route::post('gapoktan/pesanan/reply-review', [App\Http\Controllers\Gapoktan\OrderController::class, 'replyReview'])->name('gapoktan.replyReview');

    // Jumlah Pesanan Masuk
    Route::get('/load-order', [App\Http\Controllers\Gapoktan\OrderController::class, 'countOrder']);

    // Reply Ulasan
    Route::get('/gapoktan/reply-ulasan', [App\Http\Controllers\Gapoktan\ReviewController::class, 'index'])->name('gapoktan.review');
    Route::get('/gapoktan/reply-ulasan/fetchBelumDiulas', [App\Http\Controllers\Gapoktan\ReviewController::class, 'fetchBelumDiulas'])->name('gapoktan.review.fetchBelumDiulas');
    Route::get('/gapoktan/reply-ulasan/fetchUlasanSaya', [App\Http\Controllers\Gapoktan\ReviewController::class, 'fetchUlasanSaya'])->name('gapoktan.review.fetchUlasanSaya');

    // Jumlah Pesanan Masuk
    Route::get('/load-review', [App\Http\Controllers\Gapoktan\ReviewController::class, 'countReview']);

    // Daftar Petani
    Route::get('gapoktan/daftar-petani', [App\Http\Controllers\Gapoktan\FarmerController::class, 'index'])->name('gapoktan-petani');
    Route::post('gapoktan/daftar-petani/store', [App\Http\Controllers\Gapoktan\FarmerController::class, 'store'])->name('gapoktan-petani-store');
    Route::get('gapoktan/daftar-petani/fetchall', [App\Http\Controllers\Gapoktan\FarmerController::class, 'fetchAll'])->name('gapoktan-petani-fetchAll');
    Route::delete('gapoktan/daftar-petani/delete', [App\Http\Controllers\Gapoktan\FarmerController::class, 'delete'])->name('gapoktan-petani-delete');
    Route::get('gapoktan/daftar-petani/edit', [App\Http\Controllers\Gapoktan\FarmerController::class, 'edit'])->name('gapoktan-petani-edit');
    Route::post('gapoktan/daftar-petani/update', [App\Http\Controllers\Gapoktan\FarmerController::class, 'update'])->name('gapoktan-petani-update');

    // Tandur
    Route::get('gapoktan/tandur', [App\Http\Controllers\Gapoktan\PlantController::class, 'index'])->name('gapoktan-tandur');
    Route::post('gapoktan/tandur/store', [App\Http\Controllers\Gapoktan\PlantController::class, 'store'])->name('gapoktan-tandur-store');
    Route::get('gapoktan/tandur/fetchall', [App\Http\Controllers\Gapoktan\PlantController::class, 'fetchAll'])->name('gapoktan-tandur-fetchAll');
    Route::delete('gapoktan/tandur/delete', [App\Http\Controllers\Gapoktan\PlantController::class, 'delete'])->name('gapoktan-tandur-delete');
    Route::get('gapoktan/tandur/edit', [App\Http\Controllers\Gapoktan\PlantController::class, 'edit'])->name('gapoktan-tandur-edit');
    Route::post('gapoktan/tandur/update', [App\Http\Controllers\Gapoktan\PlantController::class, 'update'])->name('gapoktan-tandur-update');

    // Panen
    Route::get('gapoktan/panen', [App\Http\Controllers\Gapoktan\HarvestController::class, 'index'])->name('gapoktan-panen');
    Route::post('gapoktan/panen/store', [App\Http\Controllers\Gapoktan\HarvestController::class, 'store'])->name('gapoktan-panen-store');
    Route::get('gapoktan/panen/fetchall', [App\Http\Controllers\Gapoktan\HarvestController::class, 'fetchAll'])->name('gapoktan-panen-fetchAll');
    Route::get('gapoktan/panen/edit', [App\Http\Controllers\Gapoktan\HarvestController::class, 'edit'])->name('gapoktan-panen-edit');

    // Riwayat Penanam
    Route::get('gapoktan/riwayat-penanam', [App\Http\Controllers\Gapoktan\PlantingHistoryController::class, 'index'])->name('gapoktan-riwayat-penanam');
    Route::get('gapoktan/riwayat-penanam/fetchall', [App\Http\Controllers\Gapoktan\PlantingHistoryController::class, 'fetchAll'])->name('gapoktan-riwayat-penanam-fetchAll');
    Route::get('gapoktan/riwayat-penanam/edit', [App\Http\Controllers\Gapoktan\PlantingHistoryController::class, 'edit'])->name('gapoktan-riwayat-penanam-edit');

    // Pengaturan
    Route::get('gapoktan/pengaturan', [App\Http\Controllers\Gapoktan\PengaturanController::class, 'pengaturan'])->name('gapoktan-pengaturan');
    Route::post('gapoktan/pengaturan-image', [App\Http\Controllers\Gapoktan\PengaturanController::class, 'pengaturanImage'])->name('gapoktan.pengaturan.image');
    Route::post('gapoktan/pengaturan-update', [App\Http\Controllers\Gapoktan\PengaturanController::class, 'pengaturanUpdate'])->name('gapoktan.pengaturan.update');
    Route::post('gapoktan/pengaturan-updatePassword', [App\Http\Controllers\Gapoktan\PengaturanController::class, 'pengaturanUpdatePassword'])->name('gapoktan.pengaturan.updatePassword');
});

// // Login Poktan
// Route::group(['middleware' => ['guest']], function() {
//     Route::get('/poktan/login', [App\Http\Controllers\Poktan\LoginController::class, 'login'])->name('login-poktan');
//     Route::post('/poktan/login', [App\Http\Controllers\Poktan\LoginController::class, 'loginPoktan'])->name('login-poktan');
//     Route::get('/poktan/register', [App\Http\Controllers\Poktan\LoginController::class, 'register'])->name('register-poktan');
//     Route::post('/poktan/register', [App\Http\Controllers\Poktan\LoginController::class, 'registerPoktan'])->name('registerPoktan-poktan');
// });

// Poktan
Route::group(['middleware' => ['LoginCheck', 'auth', 'role:poktan']], function () {

    // Logout
    Route::post('/poktan/logout', [App\Http\Controllers\Poktan\LoginController::class, 'logout'])->name('logout-poktan');

    // Route::get('poktan', function() {
    //     return view('poktan.dashboard.index');
    // })->name('poktan');

    // Dashboard
    Route::get('poktan', [App\Http\Controllers\Poktan\DashboardController::class, 'index'])->name('poktan');
    Route::get('poktan/fetchall', [App\Http\Controllers\Poktan\DashboardController::class, 'fetchAll'])->name('poktan-fetchAll');

    // Edukasi
    Route::get('poktan/edukasi', [App\Http\Controllers\Poktan\EducationController::class, 'index'])->name('poktan-edukasi');
    Route::post('poktan/edukasi/store', [App\Http\Controllers\Poktan\EducationController::class, 'store'])->name('poktan-edukasi-store');
    Route::get('poktan/edukasi/fetchall', [App\Http\Controllers\Poktan\EducationController::class, 'fetchAll'])->name('poktan-edukasi-fetchAll');
    Route::delete('poktan/edukasi/delete', [App\Http\Controllers\Poktan\EducationController::class, 'delete'])->name('poktan-edukasi-delete');
    Route::get('poktan/edukasi/edit', [App\Http\Controllers\Poktan\EducationController::class, 'edit'])->name('poktan-edukasi-edit');
    Route::post('poktan/edukasi/update', [App\Http\Controllers\Poktan\EducationController::class, 'update'])->name('poktan-edukasi-update');
    Route::get('poktan/edukasi/checkSlug', [App\Http\Controllers\Poktan\EducationController::class, 'checkSlug'])->name('poktan-edukasi-checkSlug');

    // Kegiatan
    Route::get('poktan/kegiatan', [App\Http\Controllers\Poktan\ActivityController::class, 'index'])->name('poktan-kegiatan');
    Route::post('poktan/kegiatan/store', [App\Http\Controllers\Poktan\ActivityController::class, 'store'])->name('poktan-kegiatan-store');
    Route::get('poktan/kegiatan/fetchAddActivity', [App\Http\Controllers\Poktan\ActivityController::class, 'fetchAddActivity'])->name('poktan-kegiatan-fetchAddActivity');
    Route::get('poktan/kegiatan/fetchDraftActivity', [App\Http\Controllers\Poktan\ActivityController::class, 'fetchDraftActivity'])->name('poktan-kegiatan-fetchDraftActivity');
    Route::delete('poktan/kegiatan/delete', [App\Http\Controllers\Poktan\ActivityController::class, 'delete'])->name('poktan-kegiatan-delete');
    Route::get('poktan/kegiatan/show', [App\Http\Controllers\Poktan\ActivityController::class, 'show'])->name('poktan-kegiatan-show');
    Route::get('poktan/kegiatan/edit', [App\Http\Controllers\Poktan\ActivityController::class, 'edit'])->name('poktan-kegiatan-edit');
    Route::post('poktan/kegiatan/update', [App\Http\Controllers\Poktan\ActivityController::class, 'update'])->name('poktan-kegiatan-update');
    Route::get('poktan/kegiatan/checkSlug', [App\Http\Controllers\Poktan\ActivityController::class, 'checkSlug'])->name('poktan-kegiatan-checkSlug');

    // Notifikasi dibaca
    Route::post('poktan/markasreadUser', [App\Http\Controllers\Poktan\NotificationController::class, 'markNotificationUser'])->name('markas.read.user');
    Route::post('poktan/markasreadPlant', [App\Http\Controllers\Poktan\NotificationController::class, 'markNotificationPlant'])->name('markas.read.plant');
    Route::post('poktan/markasreadHarvest', [App\Http\Controllers\Poktan\NotificationController::class, 'markNotificationHarvest'])->name('markas.read.harvest');

    // Daftar Petani
    Route::get('poktan/daftar-petani', [App\Http\Controllers\Poktan\FarmerController::class, 'index'])->name('poktan-petani');
    Route::post('poktan/daftar-petani/store', [App\Http\Controllers\Poktan\FarmerController::class, 'store'])->name('poktan-petani-store');
    Route::get('poktan/daftar-petani/fetchall', [App\Http\Controllers\Poktan\FarmerController::class, 'fetchAll'])->name('poktan-petani-fetchAll');
    Route::delete('poktan/daftar-petani/delete', [App\Http\Controllers\Poktan\FarmerController::class, 'delete'])->name('poktan-petani-delete');
    Route::get('poktan/daftar-petani/edit', [App\Http\Controllers\Poktan\FarmerController::class, 'edit'])->name('poktan-petani-edit');
    Route::post('poktan/daftar-petani/update', [App\Http\Controllers\Poktan\FarmerController::class, 'update'])->name('poktan-petani-update');

    // Tandur
    Route::get('poktan/tandur', [App\Http\Controllers\Poktan\PlantController::class, 'index'])->name('poktan-tandur');
    Route::post('poktan/tandur/store', [App\Http\Controllers\Poktan\PlantController::class, 'store'])->name('poktan-tandur-store');
    Route::get('poktan/tandur/fetchall', [App\Http\Controllers\Poktan\PlantController::class, 'fetchAll'])->name('poktan-tandur-fetchAll');
    Route::delete('poktan/tandur/delete', [App\Http\Controllers\Poktan\PlantController::class, 'delete'])->name('poktan-tandur-delete');
    Route::get('poktan/tandur/edit', [App\Http\Controllers\Poktan\PlantController::class, 'edit'])->name('poktan-tandur-edit');
    Route::post('poktan/tandur/update', [App\Http\Controllers\Poktan\PlantController::class, 'update'])->name('poktan-tandur-update');

    // Panen
    Route::get('poktan/panen', [App\Http\Controllers\Poktan\HarvestController::class, 'index'])->name('poktan-panen');
    Route::post('poktan/panen/store', [App\Http\Controllers\Poktan\HarvestController::class, 'store'])->name('poktan-panen-store');
    Route::get('poktan/panen/fetchall', [App\Http\Controllers\Poktan\HarvestController::class, 'fetchAll'])->name('poktan-panen-fetchAll');
    Route::get('poktan/panen/edit', [App\Http\Controllers\Poktan\HarvestController::class, 'edit'])->name('poktan-panen-edit');

    // Riwayat Penanam
    Route::get('poktan/riwayat-penanam', [App\Http\Controllers\Poktan\PlantingHistoryController::class, 'index'])->name('poktan-riwayat-penanam');
    Route::get('poktan/riwayat-penanam/fetchall', [App\Http\Controllers\Poktan\PlantingHistoryController::class, 'fetchAll'])->name('poktan-riwayat-penanam-fetchAll');
    Route::get('poktan/riwayat-penanam/edit', [App\Http\Controllers\Poktan\PlantingHistoryController::class, 'edit'])->name('poktan-riwayat-penanam-edit');

    // Pengaturan
    Route::get('poktan/pengaturan', [App\Http\Controllers\Poktan\PengaturanController::class, 'pengaturan'])->name('poktan-pengaturan');
    Route::post('poktan/pengaturan-image', [App\Http\Controllers\Poktan\PengaturanController::class, 'pengaturanImage'])->name('poktan.pengaturan.image');
    Route::post('poktan/pengaturan-update', [App\Http\Controllers\Poktan\PengaturanController::class, 'pengaturanUpdate'])->name('poktan.pengaturan.update');
    Route::post('poktan/pengaturan-updatePassword', [App\Http\Controllers\Poktan\PengaturanController::class, 'pengaturanUpdatePassword'])->name('poktan.pengaturan.updatePassword');
});

// Login Petani
// Route::group(['middleware' => ['guest']], function() {
//     Route::get('/petani/login', [App\Http\Controllers\Petani\LoginController::class, 'login'])->name('login-petani');
//     Route::post('/petani/login', [App\Http\Controllers\Petani\LoginController::class, 'loginPetani'])->name('login-petani');
//     Route::get('/petani/register', [App\Http\Controllers\Petani\LoginController::class, 'register'])->name('register-petani');
//     Route::post('/petani/register', [App\Http\Controllers\Petani\LoginController::class, 'registerPetani'])->name('registerPetani-petani');
// });

// Petani
Route::group(['middleware' => ['LoginCheck', 'auth', 'role:petani']], function () {

    // Logout
    Route::post('/petani/logout', [App\Http\Controllers\Petani\LoginController::class, 'logout'])->name('logout-petani');

    // Route::get('petani', function() {
    //     return view('petani.dashboard.index');
    // })->name('petani');

    // Dashboard
    Route::get('petani', [App\Http\Controllers\Petani\DashboardController::class, 'index'])->name('petani');
    Route::get('petani/fetchall', [App\Http\Controllers\Petani\DashboardController::class, 'fetchAll'])->name('petani-fetchAll');

    Route::post('petani/markasreadActivity', [App\Http\Controllers\Petani\NotificationController::class, 'markNotificationActivity'])->name('petani.markas.read.activity');

    // Edukasi Page
    Route::get('/edukasi', [App\Http\Controllers\Pages\EducationController::class, 'index']);
    Route::get('/edukasi/{education:slug}', [App\Http\Controllers\Pages\EducationController::class, 'show']);
    Route::get('/autocomplete', [App\Http\Controllers\Pages\EducationController::class, 'autocomplete'])->name('autocomplete');

    // Tandur
    Route::get('petani/tandur', [App\Http\Controllers\Petani\PlantController::class, 'index'])->name('petani-tandur');
    // Route::post('petani/tandur/store', [App\Http\Controllers\Petani\PlantController::class, 'store'])->name('petani-tandur-store');
    Route::get('petani/tandur/fetchall', [App\Http\Controllers\Petani\PlantController::class, 'fetchAll'])->name('petani-tandur-fetchAll');
    Route::get('petani/lahan/fetchall-fields', [App\Http\Controllers\Petani\PlantController::class, 'fetchAllFields'])->name('petani-lahan-fetchAllFields');
    Route::delete('petani/tandur/delete', [App\Http\Controllers\Petani\PlantController::class, 'delete'])->name('petani-tandur-delete');
    Route::get('petani/tandur/edit', [App\Http\Controllers\Petani\PlantController::class, 'edit'])->name('petani-tandur-edit');
    Route::post('petani/tandur/update', [App\Http\Controllers\Petani\PlantController::class, 'update'])->name('petani-tandur-update');

    // Kegiatan
    Route::get('petani/kegiatan', [App\Http\Controllers\Petani\ActivityController::class, 'index'])->name('petani-kegiatan');
    Route::post('petani/kegiatan/store', [App\Http\Controllers\Petani\ActivityController::class, 'store'])->name('petani-kegiatan-store');
    Route::get('petani/kegiatan/fetchall', [App\Http\Controllers\Petani\ActivityController::class, 'fetchAll'])->name('petani-kegiatan-fetchAll');
    Route::delete('petani/kegiatan/delete', [App\Http\Controllers\Petani\ActivityController::class, 'delete'])->name('petani-kegiatan-delete');
    Route::get('petani/kegiatan/edit', [App\Http\Controllers\Petani\ActivityController::class, 'edit'])->name('petani-kegiatan-edit');
    Route::post('petani/kegiatan/update', [App\Http\Controllers\Petani\ActivityController::class, 'update'])->name('petani-kegiatan-update');
    Route::get('petani/kegiatan/checkSlug', [App\Http\Controllers\Petani\ActivityController::class, 'checkSlug'])->name('petani-kegiatan-checkSlug');

    // Panen
    Route::get('petani/panen', [App\Http\Controllers\Petani\HarvestController::class, 'index'])->name('petani-panen');
    Route::get('petani/panen/fetchall', [App\Http\Controllers\Petani\HarvestController::class, 'fetchAll'])->name('petani-panen-fetchAll');
    Route::get('petani/lahan/fetchall-planting', [App\Http\Controllers\Petani\HarvestController::class, 'fetchAllPlanting'])->name('petani-panen-fetchAllPlanting');
    Route::get('petani/panen/edit', [App\Http\Controllers\Petani\HarvestController::class, 'edit'])->name('petani-panen-edit');
    Route::post('petani/panen/update', [App\Http\Controllers\Petani\HarvestController::class, 'update'])->name('petani-panen-update');
    Route::get('petani/panen/edit-panen', [App\Http\Controllers\Petani\HarvestController::class, 'editPanen'])->name('petani-panen-editPanen');
    Route::post('petani/panen/update-panen', [App\Http\Controllers\Petani\HarvestController::class, 'updatePanen'])->name('petani-panen-updatePanen');

    // Riwayat Penanam
    // Route::get('petani/riwayat-penanam', [App\Http\Controllers\Petani\PlantingHistoryController::class, 'index'])->name('petani-riwayat-penanam');
    // Route::get('petani/riwayat-penanam/fetchall', [App\Http\Controllers\Petani\PlantingHistoryController::class, 'fetchAll'])->name('petani-riwayat-penanam-fetchAll');
    // Route::get('petani/riwayat-penanam/edit', [App\Http\Controllers\Petani\PlantingHistoryController::class, 'edit'])->name('petani-riwayat-penanam-edit');

    // Pengaturan
    Route::get('petani/pengaturan', [App\Http\Controllers\Petani\PengaturanController::class, 'pengaturan'])->name('petani-pengaturan');
    Route::post('petani/pengaturan-image', [App\Http\Controllers\Petani\PengaturanController::class, 'pengaturanImage'])->name('petani.pengaturan.image');
    Route::post('petani/pengaturan-update', [App\Http\Controllers\Petani\PengaturanController::class, 'pengaturanUpdate'])->name('petani.pengaturan.update');
    Route::post('petani/pengaturan-updatePassword', [App\Http\Controllers\Petani\PengaturanController::class, 'pengaturanUpdatePassword'])->name('petani.pengaturan.updatePassword');
});

// Login Pembeli
Route::group(['middleware' => ['guest']], function () {
    Route::get('/login', [App\Http\Controllers\Pembeli\LoginController::class, 'login'])->name('login');
    Route::post('/login', [App\Http\Controllers\Pembeli\LoginController::class, 'loginPembeli'])->name('loginPembeli-pembeli');
    Route::get('/register', [App\Http\Controllers\Pembeli\LoginController::class, 'register'])->name('register-pembeli');
    Route::post('/register', [App\Http\Controllers\Pembeli\LoginController::class, 'registerPembeli'])->name('registerPembeli-pembeli');
    Route::get('/forgot-password', [App\Http\Controllers\Pembeli\LoginController::class, 'forgotPassword'])->name('forgotPassword-pembeli');
    Route::post('/forgot-password', [App\Http\Controllers\Pembeli\LoginController::class, 'forgotPasswordEmail'])->name('forgotPasswordEmail-pembeli');
    Route::get('/reset-password/{email}/{token}', [App\Http\Controllers\Pembeli\LoginController::class, 'reset'])->name('resetPassword-pembeli');
    Route::post('/reset-password', [App\Http\Controllers\Pembeli\LoginController::class, 'resetPassword'])->name('resetPassword');
    Route::get('/account/verify/{token}', [App\Http\Controllers\Pembeli\LoginController::class, 'verifyAccount'])->name('user.verify');

    // Login dengan Google
    Route::get('auth/google', [App\Http\Controllers\Pembeli\LoginController::class, 'redirectToGoogle'])->name('redirectToGoogle');
    Route::get('auth/callback', [App\Http\Controllers\Pembeli\LoginController::class, 'handleGoogleCallback']);
});

// Pembeli
Route::group(['middleware' => ['LoginCheck', 'auth', 'role:pembeli']], function () {

    // Logout
    Route::post('/logout', [App\Http\Controllers\Pembeli\LoginController::class, 'logout'])->name('logout');

    // Notifikasi
    Route::get('read-allnotif', [App\Http\Controllers\Pages\ProductController::class, 'readNotif'])->name('read.all.notif');
    Route::post('read-notif-data', [App\Http\Controllers\Pages\ProductController::class, 'readNotifData'])->name('read.notif.data');

    // Profile
    Route::get('pembeli', [App\Http\Controllers\Pembeli\PengaturanController::class, 'pengaturan'])->name('pembeli');
    Route::post('pembeli-image', [App\Http\Controllers\Pembeli\PengaturanController::class, 'pengaturanImage'])->name('pembeli.pengaturan.image');
    Route::post('pembeli-update', [App\Http\Controllers\Pembeli\PengaturanController::class, 'pengaturanUpdate'])->name('pembeli.pengaturan.update');
    Route::post('pembeli-updatePassword', [App\Http\Controllers\Pembeli\PengaturanController::class, 'pengaturanUpdatePassword'])->name('pembeli.pengaturan.updatePassword');
    Route::delete('pembeli-delete-image', [App\Http\Controllers\Pembeli\PengaturanController::class, 'delete'])->name('pembeli.delete.profile');

    // Pemberitahuan
    Route::get('/pembeli/pemberitahuan', [App\Http\Controllers\Pembeli\NotificationController::class, 'index'])->name('pembeli.notifications');
    Route::get('/pembeli/pemberitahuan/fetchall', [App\Http\Controllers\Pembeli\NotificationController::class, 'fetchAll'])->name('pembeli.notifications.fetchAll');

    // Menunggu Pembayaran
    Route::get('/pembeli/menunggu-pembayaran', [App\Http\Controllers\Pembeli\WaitingPaymentController::class, 'index'])->name('pembeli.waitingPayment');
    Route::get('/pembeli/menunggu-pembayaran/fetchall', [App\Http\Controllers\Pembeli\WaitingPaymentController::class, 'fetchAll'])->name('pembeli.waitingPayment.fetchAll');
    Route::get('/pembeli/menunggu-pembayaran/detail-order/{id}', [App\Http\Controllers\Pembeli\WaitingPaymentController::class, 'viewWaitingPayment'])->name('pembeli.viewWaitingPayment');
    Route::post('/pembeli/menunggu-pembayaran/updateOrder', [App\Http\Controllers\Pembeli\WaitingPaymentController::class, 'updateWaitingPayment'])->name('pembeli.updateWaitingPayment');

    // List Transaksi
    Route::get('/pembeli/daftar-transaksi', [App\Http\Controllers\Pembeli\TransactionListController::class, 'index'])->name('pembeli.transactionList');
    Route::get('/pembeli/daftar-transaksi/fetchall', [App\Http\Controllers\Pembeli\TransactionListController::class, 'fetchAll'])->name('pembeli.transactionList.fetchAll');
    Route::get('/pembeli/daftar-transaksi/fetchDikemas', [App\Http\Controllers\Pembeli\TransactionListController::class, 'fetchDikemas'])->name('pembeli.transactionList.fetchDikemas');
    Route::get('/pembeli/daftar-transaksi/fetchDikirim', [App\Http\Controllers\Pembeli\TransactionListController::class, 'fetchDikirim'])->name('pembeli.transactionList.fetchDikirim');
    Route::get('/pembeli/daftar-transaksi/fetchSelesai', [App\Http\Controllers\Pembeli\TransactionListController::class, 'fetchSelesai'])->name('pembeli.transactionList.fetchSelesai');
    Route::get('/pembeli/daftar-transaksi/fetchDibatalkan', [App\Http\Controllers\Pembeli\TransactionListController::class, 'fetchDibatalkan'])->name('pembeli.transactionList.fetchDibatalkan');
    Route::get('/pembeli/daftar-transaksi/detail-order/{id}', [App\Http\Controllers\Pembeli\TransactionListController::class, 'viewTransactionList'])->name('pembeli.viewTransactionList');
    Route::post('/pembeli/daftar-transaksi/order-completed', [App\Http\Controllers\Pembeli\TransactionListController::class, 'orderCompleted'])->name('pembeli.orderCompleted');

    // Buat Ulasan
    Route::get('/pembeli/ulasan', [App\Http\Controllers\Pembeli\ReviewController::class, 'index'])->name('pembeli.review');
    Route::get('/pembeli/ulasan/fetchBelumDiulas', [App\Http\Controllers\Pembeli\ReviewController::class, 'fetchBelumDiulas'])->name('pembeli.review.fetchBelumDiulas');
    Route::get('/pembeli/ulasan/fetchUlasanSaya', [App\Http\Controllers\Pembeli\ReviewController::class, 'fetchUlasanSaya'])->name('pembeli.review.fetchUlasanSaya');
    Route::post('/pembeli/ulasan/updateUlasanSaya', [App\Http\Controllers\Pembeli\ReviewController::class, 'updateUlasanSaya'])->name('pembeli.updateUlasanSaya');

    // Ulasan
    Route::post('/pembeli/review', [App\Http\Controllers\Pembeli\ReviewController::class, 'addReview'])->name('add.pembeli.review');

    // CRUD Alamat
    Route::get('/pembeli/alamat', [App\Http\Controllers\Pembeli\AddressController::class, 'index'])->name('pembeli.alamat');
    Route::post('/pembeli/addAddress', [App\Http\Controllers\Pembeli\AddressController::class, 'addAlamat'])->name('add.pembeli.alamat');
    Route::get('/pembeli/fetchallAddress', [App\Http\Controllers\Pembeli\AddressController::class, 'fetchAll'])->name('pembeli.alamat.fetchAll');
    Route::get('/pembeli/editAddress', [App\Http\Controllers\Pembeli\AddressController::class, 'editAddress'])->name('edit.pembeli.alamat');
    Route::post('/pembeli/updateAddress', [App\Http\Controllers\Pembeli\AddressController::class, 'updateAddress'])->name('update.pembeli.alamat');
    Route::get('/pembeli/autocompleteAddress', [App\Http\Controllers\Pembeli\AddressController::class, 'autocomplete'])->name('alamat.autocomplete');

    // Order Detail
    Route::get('/cart/shipment/place-order/received/{orderID}', [App\Http\Controllers\Pembeli\CheckoutController::class, 'received']);

    // Wishlist
    Route::get('/pembeli/wishlist', [App\Http\Controllers\Pembeli\WishlistController::class, 'index'])->name('pembeli.wishlist');

    // Keranjang dan Order
    Route::get('/cart', [App\Http\Controllers\Pembeli\CartController::class, 'viewCart']);
    Route::get('/checkout', [App\Http\Controllers\Pembeli\CheckoutController::class, 'index'])->name('checkout.pembeli');
    Route::post('/checkout', [App\Http\Controllers\Pembeli\CheckoutController::class, 'index'])->name('checkout.pembeli');
    // Route::post('/cart/shipment', [App\Http\Controllers\Pembeli\CheckoutController::class, 'index'])->name('cart.shipment.pembeliPost');
    Route::post('/cart/shipment/place-order', [App\Http\Controllers\Pembeli\CheckoutController::class, 'placeOrder'])->name('place-order-costumer');

    // Beli Sekarang
    Route::get('/buy-now', [App\Http\Controllers\Pembeli\BuyNowController::class, 'buyNow'])->name('buy.now');
    Route::post('/buy-now', [App\Http\Controllers\Pembeli\BuyNowController::class, 'buyNowPost'])->name('buy.now.pembeli');
    Route::post('/ongkir/buy-now', [App\Http\Controllers\Pembeli\BuyNowController::class, 'check_ongkir']);
    Route::post('/buy-now/shipment/place-order', [App\Http\Controllers\Pembeli\BuyNowController::class, 'placeOrder'])->name('buy.now.place_order');
    // Route::get('/checkout', [App\Http\Controllers\Pembeli\BuyNowController::class, 'index'])->name('buy.now.pembeli');

    // Crud Address
    Route::post('/cart/shipment/addAddress', [App\Http\Controllers\Pembeli\CheckoutController::class, 'addAlamat'])->name('add-alamat-costumer');
    Route::get('/cart/shipment/fetchallAddress', [App\Http\Controllers\Pembeli\CheckoutController::class, 'fetchAll'])->name('alamat-fetchAll');
    Route::get('/cart/shipment/editAddress', [App\Http\Controllers\Pembeli\CheckoutController::class, 'editAddress'])->name('edit.alamat.costumer');
    Route::post('/cart/shipment/updateAddress', [App\Http\Controllers\Pembeli\CheckoutController::class, 'updateAddress'])->name('update.alamat.costumer');
    Route::post('/cart/shipment/updateMainAddress', [App\Http\Controllers\Pembeli\CheckoutController::class, 'updateMainAddress'])->name('updateMainAddress.pembeli.alamat');

    // Check Ongkir (RajaOngkir)
    Route::post('/ongkir', [App\Http\Controllers\Pembeli\CheckoutController::class, 'check_ongkir']);

    // Hapus Order Ketika Hitungan Mundur Sudah Habis
    Route::get('/delete-orders/{id}', [App\Http\Controllers\Pembeli\WaitingPaymentController::class, 'deleteOrders'])->name('delete.orders');

    // Chat
    Route::get('/pembeli/chat', [App\Http\Controllers\Pembeli\ChatController::class, 'index'])->name('pembeli.chat');
    Route::post('/pembeli/createChat', [App\Http\Controllers\Pembeli\ChatController::class, 'createChat'])->name('pembeli.createChat');
    // Route::get('/pembeli/detailChat', [App\Http\Controllers\Poktan\ChatController::class, 'detailChat'])->name('pembeli.detailChat');
    Route::post('/produkChat', [App\Http\Controllers\Pembeli\ChatController::class, 'produkChat'])->name('produk.createChat');
    // Route::get('pembeli/chat', function() {
    //     return view('costumer.chat.index');
    // })->name('pembeli.chat');

    Route::post('/store-token', [App\Http\Controllers\Pembeli\NotificationController::class, 'storeToken'])->name('store.token');
    Route::post('/send-web-notification', [App\Http\Controllers\Pembeli\NotificationController::class, 'sendWebNotification'])->name('send.web-notification');
});

// Cek Raja Ongkir
Route::get('/raja-ongkir', [App\Http\Controllers\Pages\RajaOngkirController::class, 'index']);

// Laravolt Indonesia
Route::get('provinces', [App\Http\Controllers\Pages\DependantDropdownController::class, 'provinces'])->name('provinces');
Route::get('cities', [App\Http\Controllers\Pages\DependantDropdownController::class, 'cities'])->name('cities');
Route::get('districts', [App\Http\Controllers\Pages\DependantDropdownController::class, 'districts'])->name('districts');
Route::get('villages', [App\Http\Controllers\Pages\DependantDropdownController::class, 'villages'])->name('villages');

// Notifikasi Payment Midtrans
Route::post('payments/notification', [App\Http\Controllers\Pembeli\PaymentController::class, 'notification']);
Route::get('payments/completed', [App\Http\Controllers\Pembeli\PaymentController::class, 'completed']);
Route::get('payments/failed', [App\Http\Controllers\Pembeli\PaymentController::class, 'unfinish']);
Route::get('payments/unfinish', [App\Http\Controllers\Pembeli\PaymentController::class, 'failed']);

// Home Tani Kula
Route::get('/', [App\Http\Controllers\Pages\ProductController::class, 'index']);
Route::get('/home', [App\Http\Controllers\Pages\ProductController::class, 'index'])->name('home');
Route::get('/fetchallHomeNewProduct', [App\Http\Controllers\Pages\ProductController::class, 'fetchallHomeNewProduct'])->name('fetchallHomeNewProduct');
Route::get('/fetchallHomeSearchProduct', [App\Http\Controllers\Pages\ProductController::class, 'fetchallHomeSearchProduct'])->name('fetchallHomeSearchProduct');
Route::get('/home/{product:slug}', [App\Http\Controllers\Pages\ProductController::class, 'detailProduct']);

// Produk Berdasarkan Pencarian
Route::get('/based-on-your-search', [App\Http\Controllers\Pages\ProductController::class, 'basedSearch'])->name('based.search');
Route::get('/based-on-your-search/fetchallBasedSearch', [App\Http\Controllers\Pages\ProductController::class, 'fetchAllBasedSearch'])->name('fetchAllBasedSearch');

// Produk Terbaru
Route::get('/new-product', [App\Http\Controllers\Pages\ProductController::class, 'newProduct'])->name('new.product');
Route::get('/new-product/fetchallNewProduct', [App\Http\Controllers\Pages\ProductController::class, 'fetchAllNewProduct'])->name('fetchAllNewProduct');

// Review Star 5, 4, 3, 2, & 1
Route::get('/five-stars-reviews/{id}', [App\Http\Controllers\Pages\ProductController::class, 'fetchAllFiveStar'])->name('five.stars');
Route::get('/four-stars-reviews/{id}', [App\Http\Controllers\Pages\ProductController::class, 'fetchAllFourStar'])->name('four.stars');
Route::get('/three-stars-reviews/{id}', [App\Http\Controllers\Pages\ProductController::class, 'fetchAllThreeStar'])->name('three.stars');
Route::get('/two-stars-reviews/{id}', [App\Http\Controllers\Pages\ProductController::class, 'fetchAllTwoStar'])->name('two.stars');
Route::get('/one-stars-reviews/{id}', [App\Http\Controllers\Pages\ProductController::class, 'fetchAllOneStar'])->name('one.stars');

// Count Review Star 5, 4, 3, 2, & 1
Route::get('/five-stars-count/{id}', [App\Http\Controllers\Pages\ProductController::class, 'countStarsFive'])->name('five.stars.count');
Route::get('/four-stars-count/{id}', [App\Http\Controllers\Pages\ProductController::class, 'countStarsFour'])->name('four.stars.count');
Route::get('/three-stars-count/{id}', [App\Http\Controllers\Pages\ProductController::class, 'countStarsThree'])->name('three.stars.count');
Route::get('/two-stars-count/{id}', [App\Http\Controllers\Pages\ProductController::class, 'countStarsTwo'])->name('two.stars.count');
Route::get('/one-stars-count/{id}', [App\Http\Controllers\Pages\ProductController::class, 'countStarsOne'])->name('one.stars.count');

// Search Produk
Route::get('/search-product', [App\Http\Controllers\Pages\ProductController::class, 'searchAllProduct'])->name('searchAllProduct');

// Semua Kategori Produk
Route::get('/product-category/all-category', [App\Http\Controllers\Pages\ProductController::class, 'allCategory']);
Route::get('/product-category/all-category/fetchallCategory', [App\Http\Controllers\Pages\ProductController::class, 'fetchallCategory'])->name('fetchallCategory');

// Nama Kategori Produk
Route::get('/product-category/{slug}', [App\Http\Controllers\Pages\ProductController::class, 'viewCategory'])->name('view.category');
Route::get('/product-category/fetchallNameCategory/{slug}', [App\Http\Controllers\Pages\ProductController::class, 'fetchallNameCategory'])->name('fetchallNameCategory');
Route::get('/product-category/{category_slug}/{product_slug}', [App\Http\Controllers\Pages\ProductController::class, 'productView'])->name('view.product');

// Keranjang
Route::post('/add-to-cart', [App\Http\Controllers\Pembeli\CartController::class, 'addProduct']);
Route::post('/delete-cart-item', [App\Http\Controllers\Pembeli\CartController::class, 'deleteCartItem']);
Route::post('/delete-out-of-stock-product', [App\Http\Controllers\Pembeli\CartController::class, 'deleteCartOutOfStockProduct']);
Route::post('/update-cart-item', [App\Http\Controllers\Pembeli\CartController::class, 'updateCartItem']);

// Hubungi Kami
Route::get('/hubungi-kami', [App\Http\Controllers\Pages\ContactUsController::class, 'index'])->name('contact.us');
Route::post('/hubungi-kami', [App\Http\Controllers\Pages\ContactUsController::class, 'addContactUs'])->name('addContactUs');

// Count Beli di Halaman Keranjang
Route::post('/load-beli-keranjang', [App\Http\Controllers\Pembeli\CartController::class, 'countBeliKeranjang']);

// Count Beli Keranjang di Navbar
Route::post('/navbar-keranjang', [App\Http\Controllers\Pembeli\CartController::class, 'navbarCountBeliKeranjang']);

// Count Keranjang
Route::get('/load-cart', [App\Http\Controllers\Pages\ProductController::class, 'countCart']);

// Count Notifikasi
Route::get('/load-notifications', [App\Http\Controllers\Pages\ProductController::class, 'countNotif']);

// List Pencarian Product
Route::get('/product-list', [App\Http\Controllers\Pages\ProductController::class, 'productListAjax'])->name('productListAjax');
// Route::post('/product-searchProduct', [App\Http\Controllers\Pages\ProductController::class, 'searchProduct']);

// Profile Gapoktan
Route::get('/profile/{name}', [App\Http\Controllers\Pages\ProductController::class, 'profileGapoktan'])->name('profile.gapoktan');
Route::get('/fetchall-produk-gapoktan/{name}', [App\Http\Controllers\Pages\ProductController::class, 'fetchallprodukGapoktan'])->name('fetchallprodukGapoktan');

// Wishlist
Route::post('/add-to-wishlist', [App\Http\Controllers\Pembeli\WishlistController::class, 'addToWishlist'])->name('pembeli.addToWishlist');
Route::post('/delete-cart-wishlist', [App\Http\Controllers\Pembeli\WishlistController::class, 'deleteWishlistItem']);

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/logout', function () {
//     Auth::logout();
//     return Redirect::to('login');
// });


Route::group(['middleware' => 'auth'], function () {
    Route::post('all-messages', [Chat::class, 'getAllMessages']);
    Route::post('read-messages', [Chat::class, 'readMessage']);
    Route::post('send-messages', [Chat::class, 'sendMessage']);
});
