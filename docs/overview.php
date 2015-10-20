<?php
include('template/define.php');
$title.="概要";
//$description="説明文章";
//$keyword="enotai,enotai.com,えのたい,電子工作,チェロ,フルート";
include('template/top.php');
?>

<!-- Page Content -->
<div id="page-content-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <h1>概要</h1>


        <h2>URL</h2>
        <p>BaseURL : <code>http://map.gionsai.yeno.net/api</code></p>


        <h2>使い方</h2>
        <p>GETメソッドで呼び出しを行うとJSONが帰ってきます。各種パラメータは<a href="./endpoint.php">エンドポイント</a>で紹介しています。</p>

        <h2>使用例</h2>
        <h3>① word検索</h3>
        <p><code>http://map.gionsai.yeno.net/api/search?word=製作+電子工作</code>
<code class="language-javascript">[
    {
        "project_type": "A",
        "project_number": "7",
        "project_name": "作って遊ぼう電子工作",
        "group_name": "電気部",
        "group_type": "部活動",
        "building_name": "総合教育棟",
        "room_name": "E4講義室",
        "room_number": "408",
        "category": "製作",
        "contents": "小中学生を対象に電子工作体験を行います。現時点の案では電子オルゴール（8種）です。",
        "item": null,
        "img_address": "..\/img\/project\/A\/A-07.png"
    },
    {
        "project_type": "B",
        "project_number": "3",
        "project_name": "Electrical Communication Space〜人・心・電気〜",
        "group_name": "電気電子工学科1年",
        "group_type": "クラス",
        "building_name": "総合教育棟",
        "room_name": "E1講義室",
        "room_number": "205",
        "category": "展示,体験",
        "contents": "Electrical Communication Space〜人・心・電気〜は、全部で四つのセクションで構成する。~~ 電気電子工学科では、どんなものを製作しているのか見てもらうのが目的である。",
        "item": null,
        "img_address": "..\/img\/project\/B\/B-03.png"
    }
]</code>
        </p>

        <p><code>http://map.gionsai.yeno.net/api/search?price=300-500</code>
<code class="language-javascript">[
    {
        "project_type": "D",
        "project_number": "3",
        "project_name": "イラスト工房",
        "group_name": "美術部",
        "group_type": "部活動",
        "building_name": "総合教育棟",
        "room_name": "D1講義室",
        "room_number": "206",
        "category": "グッズ販売",
        "contents": "オリジナルのしおり・ポストカード・ぬりえの作成販売。",
        "item": {
            "ぬりえ": 300
        },
        "img_address": "..\/img\/project\/D\/D-03.jpeg"
    },
    {
        "project_type": "D",
        "project_number": "4",
        "project_name": "キーホルダー製作所 〜あなたのために削ります〜",
        "group_name": "自動化機構研究室",
        "group_type": "研究室",
        "building_name": "第1研究棟",
        "room_name": "自動化機構第1実験室",
        "room_number": "317",
        "category": "グッズ販売",
        "contents": "研究室内にある工作機械（kitmil,HAKU）をつかって、注文されたデザインのキーホルダーを製作する。また、歯車のキーホルダーの製作販売もおこなう。",
        "item": {
            "ネームプレート": 300,
            "歯車キーホルダ": 400
        },
        "img_address": "..\/img\/project\/D\/D-04.png"
    },
    {
        "project_type": "D",
        "project_number": "6",
        "project_name": "I’LL BE BACK",
        "group_name": "化学研究同好会",
~省略~
</code>
        </p>


        <h3>② 企画表示</h3>
<p><code>http://map.gionsai.yeno.net/api/project/info?type=kikaku&project=c-12</code>
<code class="language-javascript">[
    {
        "project_type": "C",
        "project_number": "12",
        "project_name": "自作コンピューターゲーム体験",
        "group_name": "3年有志",
        "group_type": "有志",
        "building_name": "第三研究棟",
        "room_name": "計算機演習室",
        "room_number": "301",
        "category": "体験",
        "contents": "高専で学習したプログラミングの発展として、オリジナルゲームを作成しました。この企画では、そのゲームがプレイできます。",
        "item": null,
        "img_address": "..\/img\/project\/C\/C-12.jpeg"
    }
]</code>
        </p>

        <p><code>http://map.gionsai.yeno.net/api/project/info?type=kikaku&proj_type=E&proj_number=1</code>
<code class="language-javascript">[
    {
        "project_type": "E",
        "project_number": "1",
        "project_name": "○○ポテト",
        "group_name": "吹奏楽部",
        "group_type": "部活動",
        "building_name": "一般研究棟前",
        "room_name": null,
        "room_number": null,
        "category": {
            "main": "",
            "sub": "ポテト"
        },
        "contents": "ジャガイモをゆでて味付けをして、提供します",
        "item": {
            "じゃがバター": 200,
            "じゃが明太": 200,
            "じゃがチーズ": 200,
            "カリじゃが": 200,
            "塩じゃが": 170,
            "マヨネーズ(トッピング)": 30
        },
        "img_address": "..\/img\/project\/E\/E-01.jpg"
    }
]</code>
        </p>
        <h4>結果の説明 :</h4>
        <ul>
        <li><code>project_type</code> - 企画種別</li>
        <li><code>project_number</code> - 企画番号</li>
        <li><code>project_name</code> - 企画名</li>
        <li><code>group_name</code> - グループ名</li>
        <li><code>group_type</code> - グループ種別</li>
        <li><code>building_name</code> - 建物名</li>
        <li><code>room_name</code> - 部屋名</li>
        <li><code>room_number</code> - 部屋番号</li>
        <li><code>category</code> - </li>
        <li><code>contents</code> - カテゴリ</li>
        <li><code>item</code> - 商品</li>
        <li><code>img_address</code> - 画像リンク (http://map.gionsai.yeno.net/api/につなげてリンクを参照します)</li>
        </ul>


        <h2>エラーコード</h2>
        <p>検索結果が得られない場合やパラメータにエラーがある場合、"errors"キーに"code"と"message"が格納されます。
<code class="language-javascript">{
    "errors": {
        "code":402,
        "message":"指定された条件に該当する企画は存在しません。"
    }
}
</code>
        </p>

        <h2>その他</h2>
        <p>
          <ul>
            <li>企画リストが未完のため、検索結果は不十分なものとなっております。</li>
          </ul>
        </p>
      </div>
    </div>
  </div>
</div>
<!-- /#page-content-wrapper -->
<?php include('template/bottom.php'); ?>


