<?php
/**
 * txtController
 * 
 * @author    Evrim Altay KOLUAÇIK <evrimaltay@gmail.com>
 * @copyright Copyright (c) Evrim Altay KOLUAÇIK, 2014
 * @link      https://github.com/txtcontroller/txtcontroller
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @package   txtController
*/

class txtController{
	/**
     * Variable which holds txt file path.
     *
     * @var string
     */ 
	private static $txtpath;
	
	/**
     * If any error occurs, system will use this variable to stop.
     *
     * @var boolean
     */ 
	private static $stop = FALSE;
	
	/**
     * If any error occurs, system will use this variable to show error.
     *
     * @var string
     */ 
	private static $error;
	
	/**
   * Check's the file path's name.
   * If file isn't a TXT file, return's FALSE
   *
   * @param string $path
   *   File path
   *
   * @return bool
   *   Returns true if it's a TXT file, and false if it isn't.
   */
	private static function name_check($path){
		$name = substr($path,-4);
		if($name == ".txt"){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	/**
   * Opens or Creates TXT Files
   * It's a primary function for this system.
   * Warning: It can't creates a directory (folder)!!!
   *
   * @param string $path
   *   File path of txt file, if it doesn't exist it creates a new one
   *
   * @param string $data
   *   If the system needs to create a TXT file, you can enter any data to crate TXT file with this data. It's optional.
   *
   * @return bool
   *   Returns true if all is good. When it returns false, look errors.
   */
	public function open($path,$data=FALSE){
		if(self::name_check($path)){
			if(!file_exists($path)){
				if($data){
					$this->create($path,$data);
				}else{
					$this->create($path);
				}
				self::$txtpath = $path;
				return TRUE;
			}else{
				self::$txtpath = $path;
				return TRUE;
			}
		}else{
			self::$stop = TRUE;
			self::$error = "Err: The file that you're trying to create is not a txt file!";
			return FALSE;
		}
	}
	
	/**
   * Reads Currently Opened file
   * If there isn't opened file, it won't work.
   *
   * @param bool $echo
   *   If you want to write the txt data immediately, set as TRUE
   *
   * @param bool $blank
   *   A TXT File uses \n instead of <br /> for new line. And when you want to show it on a Web Browser it shows like one line.
   * If you don't want it, set as TRUE. So system will replace all \n expressions to the <br /> 
   *
   * @return string
   *   Returns the TXT data.
   */
	public function read($echo = FALSE,$blank = FALSE){
		if(!self::$stop && self::$txtpath){
			$data = file_get_contents(self::$txtpath);
			if($blank){
				$data = str_replace("\n","<br />",$data);
			}
			if($echo){
				echo $data;
			}else{
				return $data;
			}
		}else{
			if(!self::$error){
				self::$stop = TRUE;
				self::$error = "Err: You didn't open any file!";
			}
			return FALSE;
		}
	}
	
	/**
   * Creates a TXT File
   * If you use this function you don't need to use open function.
   * Warning: It can't creates a directory (folder)!!!
   *
   * @param string $path
   *   File path of txt file that you want to create.
   *
   * @param string $data
   *   Text data. It's optional.
   *
   * @return bool
   *   Returns true if all is good. When it returns false, look errors.
   */
	public function create($path,$data=FALSE){
		if(self::name_check($path)){
			if(file_exists($path)){
				self::$stop = TRUE;
				self::$error = "Err: The file that you're trying to create is already exists!";
				return FALSE;
			}else{
				file_put_contents($path,$data);
				self::$txtpath = $path;
				return TRUE;
			}
		}else{
			self::$stop = TRUE;
			self::$error = "Err: The file that you're trying to create is not a txt file!";
			return FALSE;
		}
	}
	
	/**
   * Changes Currently Opened file's text
   * If there isn't opened file, it won't work.
   *
   * @param string $data
   *   Text data
   *
   * @return bool
   *   Returns TRUE if it's okay.
   */
	public function change($data){
		if(!self::$stop && self::$txtpath){
			file_put_contents(self::$txtpath,$data);
			return TRUE;
		}else{
			if(!self::$error){
				self::$stop = TRUE;
				self::$error = "Err: You didn't open any file!";
			}
			return FALSE;
		}
	}
	
	/**
   * Appends your text to the txt file
   * If there isn't opened file, it won't work.
   *
   * @param string $data
   *   Text data
   *
   * @param bool $line
   *   If you set it TRUE, It'll automatically appends your data to the new line (with \n).
   *   Default: FALSE
   *
   * @return bool
   *   Returns TRUE if it's okay.
   */	
	public function append($data,$line=FALSE){
		if(!self::$stop && self::$txtpath){
			if($line && $this->read()){
				$data = "\n".$data;
			}
			file_put_contents(self::$txtpath,$data, FILE_APPEND);
			return TRUE;
		}else{
			if(!self::$error){
				self::$stop = TRUE;
				self::$error = "Err: You didn't open any file!";
			}
			return FALSE;
		}
	}
	
	/**
   * Deletes currently opened file.
   * If there isn't opened file, it won't work.
   *
   * @return bool
   *   Returns TRUE if it's okay.
   *
   * It may return FALSE, then check the errors.
   */	
	public function delete(){
		if(!self::$stop && self::$txtpath){
			unlink(self::$txtpath);
			return TRUE;
		}else{
			if(!self::$error){
				self::$stop = TRUE;
				self::$error = "Err: You didn't open any file!";
			}
			return FALSE;
		}
	}
	
	/**
   * Returns error
   * You can catch all system errors with this.
   *
   * @return string
   *   Returns system errors.
   */
	public function error(){
		if(self::$error){
			return self::$error;
		}
	}
	
	/**
   * Gives you a specified line.
   * If there isn't opened file, it won't work.
   *
   * @param int $line_number
   *   Line number that you want to read.
   *
   * @return string
   *   Returns line's text.
   *
   * It may return FALSE, then check the errors.
   */
	public function get_line($line_number){
		if(!self::$stop && self::$txtpath){
			$data = $this->read();
			$lines = explode("\n",$data);
			if(array_key_exists($line_number,$lines)){
				return $lines[$line_number];
			}else{
				self::$stop = TRUE;
				self::$error = "Err: Line does not exist in this file!";
				return FALSE;
			}
		}else{
			if(!self::$error){
				self::$stop = TRUE;
				self::$error = "Err: You didn't open any file!";
			}
			return FALSE;
		}
	}

	/**
   * Deletes specified line.
   * If there isn't opened file, it won't work.
   *
   * @param int $line_number
   *   Line number that you want to delete.
   *
   * @return bool
   *   Returns TRUE if it's okay.
   *
   * It may return FALSE, then check the errors.
   */	
	public function del_line($line_number){
		if(!self::$stop && self::$txtpath){
			$data = $this->read();
			$lines = explode("\n",$data);
			if(array_key_exists($line_number,$lines)){
				unset($lines[$line_number]);
				$newdata = implode("\n",$lines);
				$this->change($newdata);
				return TRUE;
			}else{
				self::$stop = TRUE;
				self::$error = "Err: Line does not exist in this file!";
				return FALSE;
			}
		}else{
			if(!self::$error){
				self::$stop = TRUE;
				self::$error = "Err: You didn't open any file!";
			}
			return FALSE;
		}
	}

	/**
   * Change specified line.
   * If there isn't opened file, it won't work.
   *
   * @param int $line_number
   *   Line number that you want to change.
   *
   * @param string $text
   *   Text data.
   *
   * @return bool
   *   Returns TRUE if it's okay.
   *
   * It may return FALSE, then check the errors.
   */	
	public function change_line($line_number,$text){
		if(!self::$stop && self::$txtpath){
			$data = $this->read();
			$lines = explode("\n",$data);
			if(array_key_exists($line_number,$lines)){
				$lines[$line_number] = $text;
				$newdata = implode("\n",$lines);
				$this->change($newdata);
				return TRUE;
			}else{
				self::$stop = TRUE;
				self::$error = "Err: Line does not exist in this file!";
				return FALSE;
			}
		}else{
			if(!self::$error){
				self::$stop = TRUE;
				self::$error = "Err: You didn't open any file!";
			}
			return FALSE;
		}
	}
}

?>
