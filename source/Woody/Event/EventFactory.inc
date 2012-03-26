<?php

namespace Woody\Event;



class EventFactory {
    private static $previousFocusedWindow = null;
    private static $previousFocusedControl = null;

    /**
     * identifier for a focus event (WBC_GETFOCUS)
     *
     * @var int
     */
    private static $FOCUS_EVENT = 0x00001000;

    /**
     * identifier for a key-up event (WBC_KEYUP)
     *
     * @var int
     */
    private static $KEY_UP_EVENT = 0x00000800;

    public static function createEvent($windowID, $id, $controlID, $typeID, $propertyID) {

        $source = \Woody\Components\Component::getComponentByID($controlID);

        // window close button does not have a control, so create a window close event
        if(self::isWindowCloseEvent($id)) {
            $source->destroy();
            $event = 'WindowCloseEvent';
        }

        else if(self::isTimerEvent($windowID, $controlID, $id)) {
            \Woody\Components\Timer\Timer::getTimerByID($id)->run();
            $event = 'TimerEvent';
        }

        else if(self::isFocusEvent($typeID)) {
            $event = new FocusEvent($windowID, $id, $controlID, $typeID, $propertyID, self::$previousFocusedControl);
            self::$previousFocusedControl = $source;

            foreach($source->getFocusListeners() as $focusListener) {
                $focusListener->focusGained($event);
            }
        }

        else if(self::isMouseEvent($typeID)) {
            $event = new MouseEvent($windowID, $id, $controlID, $typeID, $propertyID);

            foreach($source->getMouseListeners() as $mouseListener) {
                ($typeID === WBC_MOUSEDOWN)
                    ? $mouseListener->keyPressed($event)
                    : $mouseListener->keyReleased($event);
            }
        }

        else if(self::isKeyEvent($typeID)) {
            $event = new KeyEvent($windowID, $id, $controlID, $typeID, $propertyID);

            foreach($source->getKeyListeners() as $keyListener) {
                ($typeID === WBC_KEYDOWN)
                    ? $keyListener->keyPressed($event)
                    : $keyListener->keyReleased($event);
            }
        }

        // additionally, fire a ActionEvent if appropriate
        if(self::isControlEvent($id)) {
            $actionEvent = null;

            // handled before
            if(!self::isFocusEvent($typeID))  {

                if(/*self::isKeyUpEvent($typeID) && */$source instanceof \Woody\Components\Controls\PushButton) {
                    $actionEvent = new ActionEvent($windowID, $id, $controlID, $typeID, $propertyID);
                }

                else if (is_a($propertyID, 'Utils\Http\HttpGetRequest')) {
                    $actionEvent = new ActionEvent($windowID, $id, $controlID, $typeID, $propertyID);
                }

                if($actionEvent !== null) {
                    foreach($source->getActionListeners() as $actionListener) {
                        $actionListener->actionPerformed($actionEvent);
                    }
                }
            }
        }
    }

    private static function isWindowCloseEvent($id) {
        return $id === IDCLOSE;
    }

    private static function isMouseEvent($typeID) {
        return is_int($typeID)
            && (($typeID & WBC_MOUSEDOWN) || ($typeID & WBC_MOUSEUP) || ($typeID === WBC_DBLCLICK));
    }

    private static function isKeyEvent($typeID) {
        return is_int($typeID)
            && (($typeID === WBC_KEYDOWN) || ($typeID === WBC_KEYUP));
    }

    private static function isKeyUpEvent($typeID) {
        return is_int($typeID) && ($typeID === self::$KEY_UP_EVENT);
    }

    private static function isFocusEvent($typeID) {
        return is_int($typeID) && ($typeID === self::$FOCUS_EVENT);
    }

    private static function isTimerEvent($windowID, $controlID, $id) {
        return self::isWindowEvent($windowID, $controlID) && $id != 0 && $id != IDCLOSE;
    }

    private static function isWindowEvent($windowID, $controlID) {
        return $windowID == $controlID;
    }

    private static function isControlEvent($id) {
        return $id !== 0;
    }
}