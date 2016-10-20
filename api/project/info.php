<?php
/**
 * Created by PhpStorm.
 * User: enotai
 * Date: 15/10/12
 * Time: 13:26
 *
 * class化: getList?
 */
require_once ('../class-init.php');

require_once ('../class-util.php');

require_once ('../class-error.php');



/**
 * @param $proj_type
 * @param $proj_number
 * @param $project
 *
 * @return string
 * @throws Exception
 */
function checkParam($proj_type, $proj_number, $project) {//なにか違う
}

class CheckParam {
  public $proj_type;
  public $proj_numner;
  public $project;

  public $param_type;


  function unionCheck($project){
    if(!preg_match('/^[a-fA-F]{1}-[0-9]{1,2}$/', $project)) throw new Exception('企画の形式を満たしていない', 107);
  }


  function divCheck($proj_type, $proj_number){//うまく効いていない
    if(!preg_match('/^[a-fA-F]$/', $proj_type) || !preg_match('/^[0-9]{1,2}$/', $proj_number)){
      throw new Exception('企画の形式を満たしていない', 107);
    } else if(!$proj_type || !$proj_number) {
      throw new Exception('typeかnumberのどちらかがない', 102);
    } //elseはswitch
  }
}


function getList() {
  $init = new Initialize();
  $kikaku_all = $init->kikaku_all;

  $i = 0;

  $json_output = '[' . "\n";
  foreach($kikaku_all as $key => $value) {
    /*仕上げ処理*/
    unset($kikaku_all[$key]->comment);//共通

    $kikaku_all[$key]->img_address = getImgUrl($kikaku_all[$key]->project_type, $kikaku_all[$key]->project_number);

    $i++;//カンマ挿入用にループ数をカウント
    $json_output .= json_encode($kikaku_all[$key]);
    if(!(count($kikaku_all) == $i)) $json_output .= ",\n";//最後の行にカンマを挿入しない
  }
  $json_output .= "\n" . ']';


  //必要か!?
  $json_util = new JsonUtil();
  return $json_util->jsonReFormat($json_output);

}

class searchProjectOnly {//一つだけ
  public $kikaku_all;

  public $proj_type;//パラメータの種類
  public $proj_number;//パラメータの値

  /**
   * 検索部分 / 条件と一致したものはkikaku_contentに入る
   * @return array
   * @throws Exception
   */
  public function matchProject() {//thisがおおすぎ / 引数をつかえ / 上のCheckParamを使用
    $kikaku_content = array();
    for ($i = 0; $i < count($this->kikaku_all); $i++) {
      if ($this->kikaku_all[$i]->project_type == strtoupper($this->proj_type) && $this->kikaku_all[$i]->project_number == $this->proj_number) {//検索
        $kikaku_content[$i] = $this->kikaku_all[$i];//該当するものはひとつしか無いし大丈夫でしょう
        break;
      }
    }
    if($kikaku_content == array()) throw new Exception('該当なし', 402);

    $kikaku_json = $this->jsonOutput($kikaku_content);

    return $kikaku_json;
  }


  /**
   * @param $kikaku_content
   * jsonの出力 / 配列に入ったものを結合 / やり方がおかしい
   * @return string
   * @throws Exception
   */
  protected function jsonOutput($kikaku_content) {
    $i = 0;

    $json_output = '[' . "\n";
    foreach($kikaku_content as $key => $value) {
      /*仕上げ処理*/
      unset($this->kikaku_all[$key]->comment);//共通

      $this->kikaku_all[$key]->img_address = getImgUrl($this->kikaku_all[$key]->project_type, $this->kikaku_all[$key]->project_number);

      $i++;//カンマ挿入用にループ数をカウント
      $json_output .= json_encode($this->kikaku_all[$key]);
      if(!(count($kikaku_content) == $i)) $json_output .= ",\n";//最後の行にカンマを挿入しない
    }
    $json_output .= "\n" . ']';


    //必要か!?
    $json_util = new JsonUtil();
    return $json_util->jsonReFormat($json_output);

  }
}

/*=====================================================================*/

try {
//'project', 'proj_type', 'proj_number'を同時に受け付ける->配列取得
  $init = new InitializeArray();
  $init->assignParamArray(['type', 'project', 'proj_type', 'proj_number']);//順番重要

  if($init->type[0] != 'type') throw new Exception('typeが存在しない', 101);

  switch($init->value[0]) {
    case 'list' :
      echo getList();
      break;

    case 'kikaku' :
      if(isset($init->type[1])) {//もろもろ分けたりする処理
        $only_project = new searchProjectOnly();
        $param_check = new CheckParam();
        switch($init->type[1]) {
          case 'project' :
            $param_check->unionCheck($init->value[1]);

            $project_array = explode('-', $init->value[1]);
            $only_project->proj_type = $project_array[0];
            $only_project->proj_number = $project_array[1];

            $only_project->kikaku_all = $init->kikaku_all;
            break;

          case 'proj_type' || 'proj_number' :
            $param_check->divCheck($init->value[1], $init->value[2]);
            $only_project->proj_type = $init->value[1];//projectが無いこと前提
            $only_project->proj_number = $init->value[2];

            $only_project->kikaku_all = $init->kikaku_all;
            break;

          default :
            throw new Exception('パラメータがおかしい', 104);
            break;
        }
      } else {
        throw new Exception('パラメータが変', -1);
      }


      //$only_project = new searchProjectOnly();//新しく作らない!?
      echo $only_project->matchProject();
      break;

    default :
      throw new Exception('そんなtypeは存在しない', 104);
      break;
  }
} catch (Exception $e) {//エラー回収
  $error = new ErrorUtil();
  $error_message =  $error->outputError($e->getCode());
  //echo ($e->getMessage());

  $json_util = new JsonUtil();
  echo $json_util->jsonReFormat($error_message);

}

