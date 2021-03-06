<?php

namespace ws\loewe\Woody\Model;

use \ws\loewe\Utils\Model\TreeModel;

/**
 * This class acts as a full TreeModel implementation for the tree view.
 */
class DefaultTreeModel extends TreeModel implements \SplSubject {
  /**
   * the set of observers
   *
   * @var \SplObjectStorage
   */
  protected $observers = null;

  /**
   * This method acts as the constructor of the class.
   *
   * @param ws\loewe\Utils\Tree\TreeNode $root the root of the tree
   */
  public function __construct($root) {
    parent::__construct($root);

    $this->observers = new \SplObjectStorage();
  }

  /**
   * This method returns the child of the given parent at the given index.
   *
   * @param ws\loewe\Utils\Tree\TreeNode $parent the parent node
   * @param int $index the index
   *
   * @return ws\loewe\Utils\Tree\TreeNode the tree node at the given index
   */
  public function getChild($parent, $index) {
    return $parent->getChildAtIndex($index);
  }

  /**
   * This method returns the number of children of the given parent.
   *
   * @param ws\loewe\Utils\Tree\TreeNode $parent the parent node
   * @return int the number of children of the given parent
   */
  public function getChildCount($parent) {
    return $parent->getDegree();
  }

  /**
   * This method returns the index of the given child in the given parent.
   *
   * @param ws\loewe\Utils\Tree\TreeNode $parent the parent node
   * @param ws\loewe\Utils\Tree\TreeNode $child the cild node
   * @return int the index of the given child in the given parent
   */
  public function getIndexOfChild($parent, $child) {
    return $parent->getIndexOfChild($child);
  }

  /**
   * This method returns true if the given node is a leaf.
   *
   * @param ws\loewe\Utils\Tree\TreeNode $node the node
   * @return boolean true, if the the node is a leaf, else false
   */
  public function isLeaf($node) {
    return $node->isLeaf();
  }

  /**
   * This method appends the given child node to the given parent.
   *
   * @param \TreeNode $parent the parent where to append the child on
   * @param \TreeNode $child the child to append
   * @return DefaultTreeModel $this
   */
  public function appendChild($parent, $child) {
    $parent->appendChild($child);

    $this->notify();

    return $this;
  }

  /**
   * This method adds an observer to the model.
   *
   * @param \SplObserver $observer the observer to add
   * @return \ws\loewe\Woody\Model\ListModel $this
   */
  public function attach(\SplObserver $observer) {
    $this->observers->attach($observer);

    return $this;
  }

  /**
   * This method removes an observer to the model.
   *
   * @param \SplObserver $observer the observer to remove
   * @return \ws\loewe\Woody\Model\ListModel $this
   */
  public function detach(\SplObserver $observer) {
    $this->observers->detach($observer);

    return $this;
  }

  /**
   * This method notifies all observer of the model to update themselves.
   *
   * @return \ws\loewe\Woody\Model\ListModel $this
   */
  public function notify() {
    /* if(!$this->isAdjusting) */ {
      foreach($this->observers as $observer) {
        $observer->update($this);
      }
    }

    return $this;
  }
}