<?php

use Neonus\Microblog\Microblog;

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../views',
));

$app['debug'] = true;

$blog = new Microblog(__DIR__ . '/../data/');

$app->get('/', function() use ($app, $blog) {
    return $app['twig']->render('index.twig', array(
        'posts' => $blog->getPosts(true),
    ));
});

$app->get('/blog/{url}', function($url) use ($app, $blog) {
    $post = $blog->getPostByUrl($url);
    return $app['twig']->render('post.twig', array(
        'post' => $post,
    ));
});

$app->run();
