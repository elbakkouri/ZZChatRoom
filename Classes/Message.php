<?php
class Message extends FileHandler {
    public function getConversation($me, $other){
        $sent = $this->getByFromAndTo($me,$other);
        $received = $this->getByFromAndTo($other,$me);
        $all =  array();
        $is = 0; $ir = 0;
        while($is < count($sent) && $ir < count($received)){
            if($sent[$is]['time'] < $received[$ir]['time']){
                $all[] = $sent[$is];
                $is ++;
            }else{
                $all[] = $received[$ir];
                $ir ++;
            }
        }
        while($is < count($sent)){
            $all[] = $sent[$is];
            $is ++;
        }
        while($ir < count($received)){
            $all[] = $received[$ir];
            $ir ++;
        }
        return $all;
    }
} 
