<?php

use \Utils\Geom\Point;
use \Utils\Geom\Dimension;
use \Woody\Components\Windows\MainWindow;
use \Woody\App\TestApplication;
use \Woody\Components\Timer\Timer;
use \Woody\Components\Controls\Frame;
use \Woody\Components\Controls\EditBox;
use \Woody\Components\Controls\Checkbox;
use \Woody\Components\Controls\HTMLControl;
use \Woody\Server\BuiltInWebServer;
use \Woody\Util\ImageResource;
use \Utils\Http\HttpRequest;
use \Utils\Sockets\ServerSocket;

require_once(realpath(__DIR__.'/bootstrap/bootstrap.php'));

class Handler implements Woody\Event\ActionListener {

  public function actionPerformed(Woody\Event\ActionEvent $actionEvent) {
    echo PHP_EOL.'hey, you triggered an action on the field with the value '.$this->value;
  }
}

class FocusHandler implements Woody\Event\FocusListener {

  public function focusGained(\Woody\Event\FocusEvent $event) {
    echo PHP_EOL.'hey, you focus the field with the value '.$event->getFocusGainedComponent()->getLabel();
  }
}

if(TRUE) {
  $win = new MainWindow('MyWin2', new Point(50, 50), new Dimension(800, 600));
  $win->create();
  if(TRUE) {
    $builtInServer = new BuiltInWebServer($win, 8009);
    $builtInServer->run();

    $htmlControl = new HTMLControl('http://localhost:8009?id=3', new Point(50, 50), new Dimension(700, 500));
    $win->add($htmlControl);
  }
  else {
    $server = new \Woody\Server\HtmlControlServer($win, 8008);

    $server->run(100);

    $check = new Checkbox(TRUE, new Point(10, 10), new Dimension(20, 20));
    $win->add($check);

    $htmlControl = new HTMLControl('http://localhost:8008?id=3', new Point(50, 50), new Dimension(600, 100));
    $win->add($htmlControl);
    $htmlControl2 = new HTMLControl('http://localhost:8008?id=4', new Point(50, 200), new Dimension(600, 100));
    $win->add($htmlControl2);

    Woody\Event\EventHandler::addEventHandler($htmlControl2,
            function($control, ServerSocket $clientSocket, HttpRequest $httpRequest) {
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
}

else if(!TRUE) {
  $win = new MainWindow('MyWin2', new Point(50, 50), new Dimension(800, 600));
  $win->create();

  $listControl = new Woody\Components\Controls\ListBox(new Point(10, 10), new Dimension(100, 300));
  $win->add($listControl);

  $comboControl = new Woody\Components\Controls\ComboBox(new Point(120, 10), new Dimension(100, 300));
  $win->add($comboControl);

  $data = new ArrayObject();
  $data[] = 1;
  $data[] = 'eins';
  $data[] = 2;
  $data[] = 'zwei';
  $data[] = 1.2;
  $data[] = new Woody\Event\Event(1, 2, 3, 4, 5);

  $comboControl->setModel($model = new \Woody\Model\ListModel($data));
  $listControl->setModel($model);
  $model->attach($comboControl);
  $model->attach($listControl);
  $model->notify();

  $button = new \Woody\Components\Controls\PushButton("click me", new Point(440, 140), new Dimension(100, 20));
  $win->add($button);
}
else if(!TRUE) {
  $win = new MainWindow('MyWin2', new Point(50, 50), new Dimension(800, 600));
  $win->create();

  $table = new Woody\Components\Controls\Table(new Point(10, 10), new Dimension(100, 300));

  $model = new \Woody\Model\DefaultTableModel(array(array(100, 200, 300, 400), array(10, 20, 30, 40)));
  $win->add($table);
  $table->setModel($model);
}
else if(!TRUE) {
  $win = new MainWindow('MyWin2', new Point(50, 50), new Dimension(800, 600));
  $win->create();

  $gauge = wb_create_control($win->getControlID(), Gauge, "Update", 230, 245, 310, 15, 287525);
  var_dump(wb_set_value($gauge, 50));
  var_dump(wb_get_value($gauge, 50));
}
else if(!TRUE) {
  $win = new MainWindow('MyWin2', new Point(50, 50), new Dimension(800, 600));
  $win->create();

  $treeView = new \Woody\Components\Controls\TreeView(new Point(10, 10), new Dimension(300, 400));
  $win->add($treeView);
  $root = new Utils\Tree\TreeNode('test1');
  $root->populateRandomly(100, 50);
  $treeView->setModel(new \Woody\Model\DefaultTreeModel($root));
}
else if(!TRUE) {
  $win = new MainWindow('MyWin2', new Point(50, 50), new Dimension(800, 600));
  $win->create();

  $tab = new \Woody\Components\Controls\Tab(new Point(10, 10), new Dimension(300, 400));
  $win->add($tab);
  $tab->addPage('title1');
  $tab->addPage('title2');
}
else if(!TRUE) {
  $win = new MainWindow('MyWin2', new Point(50, 50), new Dimension(800, 600));
  $win->create();

  $imageFileName = 'D:/workspace/programming/PHP/woody/paypal.jpg';
  $dimension = getimagesize($imageFileName);
  $dimension = new Dimension($dimension[0] * 1, $dimension[1] * 1);
  $resource = new ImageResource($imageFileName);

  $img = new \Woody\Components\Controls\Image($resource, new Point(10, 10), new Dimension(300, 400));
  $win->add($img);

  $d = new \Woody\Dialog\PopUp\YesNoCancelConfirmationDialog('OK?', 'really ok');
  $d->open();
  var_dump($d->yes());
  var_dump($d->no());
  var_dump($d->cancel());
  $d = new \Woody\Dialog\PopUp\YesNoConfirmationDialog('OK?', 'really ok');
  $d->open();
  var_dump(" ");
  var_dump($d->yes());
  var_dump($d->no());
  $d = new \Woody\Dialog\PopUp\OkCancelConfirmationDialog('OK?', 'really ok');
  $d->open();
  var_dump(" ");
  var_dump($d->ok());
  var_dump($d->cancel());
}
else if(!TRUE) {
  $win = new MainWindow('MyWin2', new Point(50, 50), new Dimension(400, 300));
  $win->create();

  $box1 = new \Woody\Components\Controls\EditBox('', new Point(10, 10), new Dimension(300, 22));
  $win->add($box1);
  $box2 = new \Woody\Components\Controls\EditBox('', new Point(10, 35), new Dimension(300, 22));
  $win->add($box2);
  //$box1->addActionListener(new Handler());
  $box1->addFocusListener(new FocusHandler());

  $box1->addKeyListener(
          new \Woody\Event\KeyAdapter(
                  null, function($ev) {
                    $currentValue = $ev->getSource()->getValue();
                    if(strlen($currentValue) > 3) {
                      $ev->getSource()
                              ->setValue(substr($currentValue, 0, 3))
                              ->setCursor(3);
                    }
                  }));
}
else if(!TRUE) {
  $win = new MainWindow('MyWin2', new Point(50, 50), new Dimension(400, 300));
  $win->create();

  $button = new Woody\Components\Controls\PushButton('lbl', new Point(10, 35), new Dimension(300, 22));
  $win->add($button);
  //$box1->addActionListener(new Handler());
  $button->addFocusListener(new Woody\Event\FocusAdapter(function() {
                    var_dump("FOCUS!!!");
                  }));


  $button->addMouseListener(new \Woody\Event\MouseAdapter(function() {
                    var_dump("down");
                  }, function() {
                    var_dump("up");
                  }));

  $button->addActionListener(new \Woody\Event\ActionAdapter(function() {
                    var_dump("ACTION!!!");
                  }));

  $button->addKeyListener(
          new Woody\Event\KeyAdapter(
                  function($ev) {
                    $currentValue = $ev->getSource()->getValue();
                    if(strlen($currentValue) > 3) {
                      $ev->getSource()
                              ->setValue(substr($currentValue, 0, 3))
                              ->setCursor(3);
                    }
                  }
                  , function($ev) {
                    $currentValue = $ev->getSource()->getValue();
                    if(strlen($currentValue) > 3) {
                      $ev->getSource()
                              ->setValue(substr($currentValue, 0, 3))
                              ->setCursor(3);
                    }
                  }));
}



$win->startEventHandler();
//$builtInServer->shutdown();
