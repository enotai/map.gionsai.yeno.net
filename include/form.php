<?php
/**
 * Created by PhpStorm.
 * User: enotai
 * Date: 15/07/09
 * Time: 10:01
 */

/**
 * @param $string
 * @return string
 */
function s($string){
  if(isset($string)){//get処理方法
    // タグを無効にする
    $string = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');

    // debug用
    if (get_magic_quotes_gpc()) {
      $string = stripslashes($string);
    }

    // SQLコマンド用の文字列にエスケープする
    //$string = mysql_real_escape_string($string);
    //非推奨らしい

    return $string;
  } /*else {
    $error = true;
  }*/
}


/**
 * @param $str
 * @return string
 */
function h($str){
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}