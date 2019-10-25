<?php
// Home
$app->get('/', App\Action\HomeAction::class)
->setName('homepage');

// Doodles
$app->get('/doodles', App\Action\DoodlesAction::class . ':getDoodlesData')
    ->setName('doodles');
$app->post('/get-dates', App\Action\DoodlesAction::class . ':getDates')
    ->setName('doodles');
$app->post('/get-questions', App\Action\DoodlesAction::class . ':getQuestions')
    ->setName('doodles');
$app->post('/get-drawings', App\Action\DoodlesAction::class . ':getDrawings')
    ->setName('doodles');

// Doodle
$app->get('/doodle', App\Action\DoodleAction::class . ':getDoodleData')
    ->setName('doodle');
$app->post('/upload-drawings', App\Action\DoodleAction::class . ':uploadDrawings')
    ->setName('doodle');

// Team
$app->get('/team', App\Action\TeamAction::class)
    ->setName('team');
$app->post('/team/add', App\Action\TeamAction::class . ':add')
    ->setName('team');

// Retros
$app->get('/retros', App\Action\RetrosAction::class)
    ->setName('retros');
$app->post('/retro/add', App\Action\RetrosAction::class . ':addRetro')
    ->setName('retros');
$app->get('/retro/{id}', App\Action\RetrosAction::class . ':getRetro')
    ->setName('retros');
