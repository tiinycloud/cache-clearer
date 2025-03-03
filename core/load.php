<?php
if(!class_exists('WPCC')){
	class WPCC{
		
		public $path = '';

		public function __construct($temp='', $init = '') {
			$this->path = !empty($init) ? $init.'/' : $this->path;
			$this->path = WPCC_CLEANER_PATH.$this->path.$temp;
		}
		public function inc($file, $part='', $one=true){
				if(!empty($part)){
					$path = $this->path.'/'.$part.'/'.$file.'.php';
				}else{
					$path = $this->path.'/'.$file.'.php';
				}
				if(file_exists($path)){
					if($one) require_once( $path );
					else require( $path ); 
				}
		}
	}
}
(new wpcc('core'))->inc('init');
(new wpcc('core'))->inc('functions');
(new wpcc('core'))->inc('gen', 'hooks');
(new wpcc('core'))->inc('inc', 'menu');
