<?php
/**
 * Setup routes with a single request method:
 *
 * $app->get('/', App\Action\HomePageAction::class, 'home');
 * $app->post('/album', App\Action\AlbumCreateAction::class, 'album.create');
 * $app->put('/album/:id', App\Action\AlbumUpdateAction::class, 'album.put');
 * $app->patch('/album/:id', App\Action\AlbumUpdateAction::class, 'album.patch');
 * $app->delete('/album/:id', App\Action\AlbumDeleteAction::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', App\Action\ContactAction::class, ['GET', 'POST', ...], 'contact');
 *
 * Or handling all request methods:
 *
 * $app->route('/contact', App\Action\ContactAction::class)->setName('contact');
 *
 * or:
 *
 * $app->route(
 *     '/contact',
 *     App\Action\ContactAction::class,
 *     Mezzio\Router\Route::HTTP_METHOD_ANY,
 *     'contact'
 * );
 */

/** @var \Mezzio\Application $app */

$app->get('/', \App\Action\HomePageAction::class, 'home');
$app->get('/api/ping', \App\Action\PingAction::class, 'api.ping');
$app->get('/downloads', \App\Action\DownloadsPageAction::class, 'downloads');
$app->route('/ua-lookup', \App\Action\LookupPageAction::class, ['GET', 'POST'], 'ua-lookup');
$app->get('/capabilities', \App\Action\CapabilitiesPageAction::class, 'capabilities');
