<?php
use App\Route;

Route::set("GET", "/", "MainController@home");
Route::set("GET", "/admin/init", "MainController@init");


// Users

Route::set("GET", "/users/login", "UserController@login", "guest");
Route::set("POST", "/users/login", "UserController@loginExecute", "guest");
Route::set("POST", "/users/login/prev", "UserController@loginPrevExecute");

Route::set("GET", "/users/join", "UserController@join", "guest");
Route::set("POST", "/users/join", "UserController@joinExecute", "guest");
Route::set("GET", "/users/logout", "UserController@logout");

Route::set("POST", "/users/exist", "UserController@isExist");


// Gallery

Route::set("GET", "/gallery", "GalleryController@galleryHome");
Route::set("GET", "/gallery/info", "GalleryController@galleryInfo");

Route::set("GET", "/gallery/add-artwork", "GalleryController@addArtwork", "president");
Route::set("POST", "/gallery/add-artwork", "GalleryController@addArtworkExecute", "president");

Route::set("POST", "/gallery/take-list", "GalleryController@takeList");
Route::set("POST", "/gallery/popular-list", "GalleryController@popularList");
Route::set("POST", "/gallery/take-empty-artworks", "GalleryController@takeEmptyArtworks");

Route::set("GET", "/artworks/info", "GalleryController@artworkInfo");
Route::set("POST", "/artworks/buy", "GalleryController@buyArtwork", "user");

// Mypage

Route::set("GET", "/mypage", "MypageController@mypageHome", "user");

Route::set("GET", "/mypage/add-artwork", "MypageController@addArtwork", "user");
Route::set("POST", "/mypage/add-artwork", "MypageController@addArtworkExecute", "user");

Route::set("GET", "/mypage/workspace", "MypageController@workspace", "user");

// Reservation

Route::set("GET", "/reservation/booth", "ReserveController@reserveBooth", "user");
Route::set("POST", "/reservation/booth", "ReserveController@reserveBoothExecute", "user");


Route::set("GET", "/reservation/list", "ReserveController@reserveList");

Route::set("POST", "/take/reserve-list", "ReserveController@takeReservedList");
Route::set("POST", "/take/booth-list", "ReserveController@takeBoothList");
Route::redirect();