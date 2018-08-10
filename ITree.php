<?php

// definition of the sheet childreen depth limiter
const W=4;

// Primary (tree) Node Class
class INode{
	protected $nodelist; // base object
	protected $id; // present an unique identifier for each node

	/* Class initialization */
	public function __construct(){
		$this->nodelist=array();
		$this->id=strval(uniqid('', true)); // convert unique identifier for string 'key' persistency in array manipulation
		return $this;
	}

	/* Sorting Function Related to INode.length */
	protected static function _NodeSort($nodeA,$nodeB){
	    if ($nodeA->length == $nodeB->length){
	        return 0;
	    }
	    return ($nodeA->length < $nodeB->length) ? 1 : -1;
	}

	/* Data Input Function (insert a new node in a parent node) */
	public function Add(INode $node){
		$this->nodelist[$node->getID()]=$node;
		@usort($this->nodelist, 'INodeList::_NodeSort'); // sort the nodelist following the custom _NodeSort condition
		return $this;
	}

	/* Start Manipulation Functions */
	public function getID(){
		return $this->id;
	}
	public function Remove($node){
		if($node instanceof INode)
			unset($this->nodelist[$node->getID()]);
		else
			unset($this->nodelist[strval($node)]);
		return $this;
	}
	public function RemoveIndex($index, $callback=null){
		(is_callable($callback)) ? $callback(array_splice($this->nodelist, $index,1)) : array_splice($this->nodelist, $index,1);
		return $this;
	}
	public function Get($node){
		if($node instanceof INode)
			return $this->nodelist[$node->getID()];
		else
			return $this->nodelist[strval($node)];
		return null;
	}
	public function GetIndex($index){
		return @array_values($this->nodelist)[$index];
	}
	public function GetAll(){
		return $this->nodelist;
	}
	public function Clear(){
		$this->nodelist=array();
		return $this;
	}
	/* End Manipulation Functions */

	/* Node Length Property Definition */
	public function __get($name){
		switch ($name) {
			case 'length':
				return count($this->nodelist);
			default:
				throw new Exception("Property does not exist", 1);								
				break;
		}
	}
}

class ISheet extends INode{
	public function __construct(){
		$this->nodelist=array();
		$this->id=strval(uniqid('', true)); // convert unique identifier for string 'key' persistency in array manipulation
		return $this;
	}
	public function Add($key,$value){
		if(count($this->nodelist) < W) $this->nodelist[$key]=serialize($value);
		return $this;
	}
	public function Get($key){
		return unserialize($this->nodelist[$key]);
	}
	public function GetIndex($index){
		return @array_values($this->nodelist)[$index];
	}
	public function GetAll(){
		return $this->nodelist;
	}
}

?>