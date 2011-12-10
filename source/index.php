<?php

use \Utils\Geom\Point;
use \Utils\Geom\Dimension;
use \Woody\Components\Windows\MainWindow;
use \Woody\App\TestApplication;

use \Woody\Components\Timer\Timer;

use \Woody\Components\Controls\Frame;
use \Woody\Components\Controls\EditBox;
use \Woody\Components\Controls\Checkbox;

use \Utils\Http\HttpRequest;
use \Utils\Sockets\ServerSocket;

require_once(realpath(__DIR__.'/bootstrap/bootstrap.php'));

/*$fh = popen('start run_server.bat', 'r');
while(!feof($fh))
{
    echo fread($fh, 128);
}*/
/*
$desc = array(0 => array('file', 'D:/r.txt', 'a'), 1 => array('file', 'D:/w.txt', 'a'), 2 => array('file', 'D:/e.txt', 'a'));
$pipes = array();

chdir("C:/Program Files/PHP54/");
proc_open('"C:/Program Files/PHP54/php.exe" -S 127.0.0.1:8008', $desc, $pipes);

die;*/
var_dump(phpversion());

if(!TRUE)
{
    $win = new MainWindow('MyWin2', new Point(50, 50), new Dimension(800, 600));
    $win->create();

    $server = new \Woody\Server\HtmlControlServer($win, 8008);

    $server->run(100);

    $check = new Checkbox(TRUE, new Point(10, 10), new Dimension(20, 20));
    $win->add($check);

    $htmlControl = new Woody\Components\Controls\HTMLControl('http://localhost:8008?id=3', new Point(50, 50), new Dimension(600, 100));
    $win->add($htmlControl);
    $htmlControl2 = new Woody\Components\Controls\HTMLControl('http://localhost:8008?id=4', new Point(50, 200), new Dimension(600, 100));
    $win->add($htmlControl2);

    Woody\Event\EventHandler::addEventHandler($htmlControl2,
        function($control, ServerSocket $clientSocket, HttpRequest $httpRequest)
        {
            $keyValuePairs = $httpRequest->getKeyValuePairs();

            if($keyValuePairs['id'] == 3)
                $clientSocket->write('void');

            else
                $clientSocket->write('<a href="?id='.($keyValuePairs['id'] - 1)
                        .'">-</a><b style="color:red;">goodbye '
                        .$keyValuePairs['id'].'</b><a href="?id='
                        .($keyValuePairs['id'] + 1).'">+</a>');
        });

    $server->register($htmlControl2);
}

else if(!TRUE)
{
    $win = new MainWindow('MyWin2', new Point(50, 50), new Dimension(800, 600));
    $win->create();

    $listControl = new Woody\Components\Controls\ListBox(new Point(10, 10), new Dimension(100, 300));
    $win->add($listControl);

    $comboControl = new Woody\Components\Controls\ComboBox(new Point(120, 10), new Dimension(100, 300));
    $win->add($comboControl);

    $listView = new Woody\Components\Controls\ListView(new Point(120, 50), new Dimension(300, 400));

    $win->add($listView);
    $listView->setColumns(array('1', '2', '4'));

    $data = new ArrayObject();
    $data[] = 1;
    $data[] = 'eins';
    $data[] = 2;
    $data[] = 'zwei';
    $data[] = 1.2;
    $data[] = new Woody\Event\Event(1, 2, 3, 4, 5);

    $comboControl->setModel($model = new \Woody\Model\ListModel($data));
    $listControl->setModel($model);
    $listView->setModel($model);
    $model->attach($comboControl);
    $model->attach($listControl);
    $model->attach($listView);
    $model->notify();

    Woody\Event\EventHandler::addEventHandler($listView,
            function(Woody\Components\Controls\ListView $control, $param1, $param2)
            {
                var_dump('addElement(777)');
                $control->getModel()->addElement(777);
                $control->getModel()->notify();
            });

    $button = new \Woody\Components\Controls\PushButton("click me", new Point(440, 140), new Dimension(100, 20));
    $win->add($button);
} else if(TRUE) {
    $win = new MainWindow('MyWin2', new Point(50, 50), new Dimension(800, 600));
    $win->create();

    $table = new Woody\Components\Controls\Table(new Point(10, 10), new Dimension(100, 300));
    $model = new \Woody\Components\Controls\DefaultTableModel(array(array(1, 2, 3, 4), array(10, 20, 30, 40)));
    $win->add($table);
    $table->setModel($model);
}
$win->startEventHandler();