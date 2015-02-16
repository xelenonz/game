<?php 

define("KEY","?????????");
class CreateFile{
    public $tmpfile = 'result.log';
    public function WriteTmp($text){
        file_put_contents($this->tmpfile, $text);
    }
    public function __destruct(){
        readfile(dirname(__FILE__) . '/' . $this->tmpfile);
    }
}

$serialize = unserialize(urldecode($_POST['serialize']));
$result = print_r($serialize,1);
$log = new CreateFile(); 
$log->WriteTmp("<pre>".htmlentities($result)."</pre>");

?>
<h1>PHP Unserializer</h1>
<form action="" method="POST">
    <textarea name="serialize" rows="4" cols="50"></textarea>
    <p><button type="submit" name="submit"/>Unserializer</button>
</form>
