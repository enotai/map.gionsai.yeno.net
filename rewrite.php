<?php
/**
 * Created by PhpStorm.
 * User: enotai
 * Date: 2015/10/04
 * Time: 23:32
 */

$json = json_decode(file_get_contents('./json/gionsai2015kiikaku_make3.json'));

/*for($i=0;$i<count($json);$i++) {//削除
  foreach($json[$i] as $key => $value) {
    if($key == 'coordinate') unset($json[$i]->coordinate);
  }
}*/

for($i=0;$i<=count($json);$i++) {//削除
  /*if(isset($json[$i]->sub_category)) {
    unset($json[$i]->category);
    unset($json[$i]->sub_category);
    $json[$i]->category->main = "";
    $json[$i]->category->sub = "";
  }

  if(isset($json[$i]->coordinate)) unset($json[$i]->coordinate);
  if(isset($json[$i]->item[0]->_empty_)) {
    unset($json[$i]->item);
    $json[$i]->item->hoge = "";
  }*/
  //if($json[$i]->item[0] === null) {
    //unset($json[$i]->item);
    //$json[$i]->item = "null";
  //}
}
echo json_encode($json,  JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);