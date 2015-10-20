<?php
/**
 * Created by PhpStorm.
 * User: enotai
 * Date: 15/10/12
 * Time: 13:30
 */

class Error {

  public $error_code;


  /**
   * @param $error_code
   * エラーコードに応じてメッセージを返す
   * 1xx : Parameter error
   * 2xx :
   * 3xx : Forbidden
   * 4xx : Not found
   *
   * @return string
   */
  function outputError($error_code){
    switch ($error_code) {
      case 0 :
        return 0;
        break;

      case 101 :
        return '{"errors":{"code":101,"message":" パラメータ\'type\'が存在しません。"}}';
        break;

      case 102 :
        return '{"errors":{"code":102,"message":"企画番号をパラメータで指定してください。"}}';
        break;

      case 103 :
        return '{"errors":{"code":103,"message":"x, y, zのパラメータを必要とします。"}}';
        break;

      case 104 :
        return '{"errors":{"code":104,"message":"要求された\'type\'は存在しません。"}}';
        break;

      case 105 :
        return '{"errors":{"code":105,"message":"複数の\'type\'を指定しています。"}}';//文言を変える
        break;

      case 106 :
        return '{"errors":{"code":106,"message":"座標の形式が不正です。"}}';
        break;

      case 107 :
        return '{"errors":{"code":107,"message":"企画番号の形式が不正です。"}}';
        break;


      case 301 :
        return '{"errors":{"code":301,"message":"検索条件が空です。"}}';
        break;


      case 401 :
        return '{"errors":{"code":401,"message":"指定された企画は存在しません。"}}';
        break;

      case 402 :
        return '{"errors":{"code":402,"message":"指定された条件に該当する企画は存在しません。"}}';
        break;

      default :
        return '{"errors":{"code":-1,"message":"不明なエラーが発生しました。"}}';
    }
  }
} 