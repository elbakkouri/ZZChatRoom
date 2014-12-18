<?php
/** FileHandler Class.
* Class handling a text file like a table in database, Simple ORM usage
* @author webNeat (webneat@gmail.com)
* @version 0.6 Beta
*/
class FileHandler {
    private $filePath;
    private $attributes;
    private $data;
    private $error;

    public function FileHandler(){
        $this->filePath = __DIR__.'/../data/'.strtolower(get_class($this)).'s.txt';
        $input = fopen($this->filePath,'r');
        if($input){
            $this->attributes = explode("#", $this->getLine($input));
            $count = count($this->attributes);
            $line = $this->getLine($input);
            while($line){
                $record = array();
                $values = explode("#",$line);
                for($i = 0; $i < $count; $i ++)
                    $record[$this->attributes[$i]] = $values[$i];
                $this->data[] = $record;
                $line = $this->getLine($input);
            }
            // echo '<pre>'; var_dump($this->data); echo'</pre><p></p><hr>';
            $this->error = false;
            fclose($input);
        }else{
            $this->error = "Input file '".__DIR__.'/../data/'.strtolower(get_class($this))."s.txt' not found !";
        }
    }

    public function add($record){
        $this->data[] = $record;
        $this->save();
    }

    public function save(){
        $output = fopen($this->filePath,'w');
        fwrite($output, implode('#', $this->attributes)."\n");
        $size = count($this->data);
        // echo '<pre>'; var_dump($this->data); echo '</pre><hr>';
        for ($i = 0; $i < $size; $i++){ 
            // echo '<p>'.$i.'</p><pre>'; var_dump($this->data[$i]); echo '</pre><hr>';
            fwrite($output, implode('#', $this->data[$i])."\n");
        }
        // echo '<hr><hr>';
        fclose($output);
    }

    public function __call($method,$args){
        // Get : getByAttribute(value)
        if(substr($method,0,5) == 'getBy'){
            $attrs = explode('And',substr($method, 5));
            if(count($attrs) != count($args)){
                $this->error = 'Arguments number is not equal to attributes !';
                return false;
            }
            foreach($attrs as $key => $attr){
                $attrs[$key] = strtolower($attr);
                if(array_search($attrs[$key], $this->attributes) === false){
                    $this->error = 'Attribute not found !';
                    return false;
                }
            }

            $data = $this->data;
            $count = count($attrs);
            for($i = 0; $i < $count; $i++)
                $data = $this->filter($data, $attrs[$i], $args[$i]);
            return $data;
        }
        // Set : setWhereAttribute(value,record)
        if(substr($method,0,8) == 'setWhere'){
            $attr = strtolower(substr($method,8));
            if(array_search($attr, $this->attributes) === false){
                $this->error = 'Attribute not found !';
                return false;
            }
            $i = 0;
            while($i < count($this->data) && $this->data[$i][$attr] != $args[0])
                $i ++;
            if($i < count($this->data)){
                foreach($args[1] as $key => $value){
                    $this->data[$i][$key] = $value;
                }
                $this->save();
                return true;
            }
            $this->error = "Not Found !";
            return false;
        }
    }

    private function filter($list, $key, $value){
        $newList = array();
        if(count($list)){
            foreach ($list as $item){
                if($item[$key] == $value)
                    $newList[] = $item;
            }
        }
        return $newList;
    }

    public function getError(){
        return $this->error;
    }

    public function getAll(){
        return $this->data;
    }

    private function getLine($res){
        $line = fgets($res);
        return substr($line, 0, strlen($line) - 1);
    }
}
