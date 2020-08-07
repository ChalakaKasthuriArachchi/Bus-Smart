<?php
	class OrderedList{
		public $keys = array();
		public $values = array();
		public $count = 0;

		public function __contruct(){
			$count = 0;
		}
		public function push($key,$value){
			$i;
			//Find the Position
			for($i = 0; $i < $this->count; $i++)
				if($this->keys[$i] > $key)
					break;
			//Insert
			array_splice($this->keys, $i,0,$key);
			array_splice($this->values, $i,0,$value);
			$this->count++;
		}
		public function print(){
			for($i = 0; $i < $this->count; $i++)
				echo $i.'. ['.$this->keys[$i].']['.$this->values[$i].'] <br>';
		}
	}
?>