<?php

use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use NewsApp\Controller\NewsController;
use NewsApp\Repository\News as NewsRepository;
use NewsApp\Service\News as NewsService;

$app = new Application();
$app['debug'] = true;
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app->register(new SilexGuzzle\GuzzleServiceProvider(), [
    'guzzle.timeout' => 1,
]);

$app['twig'] = $app->extend('twig', function ($twig, $app) {
    $twig->addFunction(new \Twig_SimpleFunction('asset', function ($asset) {
        $request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
        return sprintf($request->getBaseUrl().'/%s', ltrim($asset, '/')); 
    }));

    return $twig;
});
$configArr = include __DIR__ . '/../config/configuration.php';
$app['news.api.config'] = $configArr['newsApi'];
$app['news.repository'] = function() use ($app) {
    return new NewsRepository($app['guzzle'], $app['news.api.config']);
};
$app['news.service'] = function() use ($app) {
    return new NewsService($app['news.repository']);
};
$app['news.controller'] = function () use ($app) {
    return new NewsController($app['news.service']);
};
$app->get('/news', function () use ($app) {
    /* @var $controller \NewsApp\Controller\NewsController */
    $controller = $app['news.controller'];
    $newsFeed = $controller->news();
    
    if (empty($newsFeed)) {
        return $app['twig']->render('news/no-result.html.twig');
    }
    
    return $app['twig']->render('news/news.html.twig', [
        'newsFeed' => $newsFeed,
    ]);
});

return $app;
