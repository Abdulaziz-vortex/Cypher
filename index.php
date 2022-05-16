<?php

ini_set('display_errors', 1);

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

use App\Handlers\FormHandler;
use App\Handlers\ProjectHandler;
use Framework\Application\Application;
use Framework\Application\Singletone;

/*
 * @var $req Request
 */

// initialization
$req = \Framework\Http\RequestFactory::fromGlobals();

$request = $req->setHeader('x-Developer', 'Abdulaziz')->setHeader('protocol', "HTTP");

//==================== Application

//config file
$config = include 'config/main.php';

// #Application object -> entry point


$app = new Application($config);

Singletone::install($app);

//App init point

$app->init();

// pubsub component use subscribe

Singletone::$app->pubsub->subscribe('DELETE-ITEM', (new ProjectHandler));
Singletone::$app->pubsub->subscribe('FORM_RECEIVED', (new FormHandler));
Singletone::$app->pubsub->subscribe('FORM_RECEIVED', (new \App\Handlers\NotifyHandler));

if (isset($_POST['form'])) {
    Singletone::$app->pubsub->publish('FORM_RECEIVED', Singletone::$app->request->post('*'));
}elseif (isset($_GET['delete_item'])){
    Singletone::$app->pubsub->publish('DELETE-ITEM', Singletone::$app->request->get('delete_item'));
}

Singletone::$app->redis->connect('localhost', 6379);

$keys = Singletone::$app->redis->keys('*');

$data = [];

foreach ($keys as $v) {
    $data[$v] = Singletone::$app->redis->get($v);
}

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
	      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<title>Document</title>
</head>
<body>

<div class="container mt-3">
	<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" name="form">
		<div class="d-flex gap-3">
			<div class="col-5">
				<input type="text" name="key" class="form-control" placeholder="Key">
			</div>
			<div class="col-5">
				<input type="text" name="value" class="form-control" placeholder="Value">
			</div>
			<div class="col">
				<button class="btn btn-primary w-100" type="submit" name="form" value="form button">Add to redis
				</button>
			</div>
		</div>
	</form>

	<table class="table">
		<tr>
			<td>key</td>
			<td>value</td>
		</tr>
        <?php
        foreach ($data as $k => $v):
            ?>
			<tr>
				<td><?= $k ?></td>
				<td><?= $v ?></td>
				<td>
					<form action="" method="get">
						<input type="hidden" name="delete_item" value="<?= $k ?>">
						<button class="btn btn-danger">delete</button>
					</form>
				</td>
			</tr>

        <?php
        endforeach;
        ?>
	</table>
</div>
</body>
</html>
