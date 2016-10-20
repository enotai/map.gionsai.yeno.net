/**
 * Created by enotai on 2015/10/20 by @takunokko.
 */

// ページがロードされた時に実行される内容
function page_load_do(src) {
  set_data(src)
}

var map_data = {};
// JSONのデータを配列に保存しておく
function set_data(data_src) {
  $.getJSON("map_data/" + data_src + ".json", function (data) {
    for (i = 0; i < data.length; i++) {
      map_data[data[i].id] = {};
      map_data[data[i].id] = data[i];
    }
  }).done(function () {
    add_link(data_src);
    set_page();
  });
}

/* details変更に関する処理 */
//jQuery(document).on("click", "#project", function(){
// セレクタはclassとかidのほうが良さそう。端末Firefoxでの動作がよろしくない。
jQuery(document).on("click", ".project", function () {
  // 現在の状態を保持
  var now_visibility = $("#details").css("visibility");

  update_details(this.id);

  $('#details').css('visibility', 'visible');
});

function update_details(id) {
  // detailsの内容を書き換える
  // if('hoge' in 'moge') は、mogeにhoge要素がある場合にtrueを返す
  if ('href' in map_data[id]) { // hrefの値があった場合
    if ('kikaku_name' in map_data[id]) {
      $('#kikaku_name').html('<a href=?building=' + map_data[id]['href'] + '>' + map_data[id]['kikaku_name'] + '</a>');
    } else {
      $('#kikaku_name').html('<a href=?building=' + map_data[id]['href'] + '>' + map_data[id]['alt'] + '</a>');
    }
  } else { // hrefの値が無かった場合
    if ('kikaku_name' in map_data[id]) {
      $('#kikaku_name').html(map_data[id]['kikaku_name']);
    } else {
      $('#kikaku_name').html(map_data[id]['alt']);
    }
  }

  // group_nameについて
  if ('group_name' in map_data[id]) {
    $('#group_name').html("Group: " + map_data[id]['group_name']);
  } else {
    $('#group_name').html("");
  }

  // contentについて
  if ('content' in map_data[id]) {
    $('#kikaku_content').html(map_data[id]['content']);
  } else {
    $('#kikaku_content').html("");
  }

  if ('description' in map_data[id]) {
    $('#details_inner').html(map_data[id]['description'] + "<br />");
  } else {
    $('#details_inner').html("詳細情報はありません。<br />");
  }

  // 画像データへのリンクがあった場合
  if ('pic' in map_data[id]) {
    $('#details_pic').html('<img class="details_img" src="' + map_data[id]["pic"] + '" alt="' + id + '">');
  } else {
    $('#details_pic').html('<img class="details_img" src="img/NoImg.png" alt="NoImg">');
  }
  if ('pic2' in map_data[id]) {
    $('#details_pic').append('<img class="details_img" src="' + map_data[id]["pic2"] + '" alt="' + id + '">');
  } else {
  }
}


// クリックされた場合に半透明の黒色の説明を表示する。
jQuery(document).on("click", "#none_map", function () {
  $('#details').css('visibility', 'hidden');
});

// JSONデータから、マップに対してリンクを作成する。　
function add_link(img_src) {
  var img = new Image();
  img.src = $("img").attr("src");
  var resize = $("img").width() / img.width;
  // resize(縮尺比) = 表示する画像サイズ / オリジナルの画像サイズ

  for (var id in map_data) {
    var a_tag = "<area ";
    a_tag += "id=\"" + map_data[id]['id'] + "\" ";
    a_tag += "class=\"project\"";
    a_tag += 'href="#"';
    //a_tag += "nohref=\"nohref\" "; // Chromeでデバッグするときに境界線が出て便利
    //a_tag += "alt=\"" + data[i].alt + "\" ";
    a_tag += "shape=\"" + map_data[id]['shape'] + "\" ";
    a_tag += "coords=\"" + resize_link(map_data[id]['coords'], resize) + "\" ";
    a_tag += "/>";
    $("map").append(a_tag);
  }
  //});
}

// GETの内容で最初からdetailsを表示してみたりする
function set_page() {
  var select;
  if ((select = getParam("select")) != false) {
    update_details(select);
    $('#details').css('visibility', 'visible');
  }
}

// getParam関数は"http://javatechnology.net/jquery/get-parameter/"様から引用
function getParam(param) {
  var url = location.href;
  var categoryKey;
  parameters = url.split("?");
  if (parameters.length >= 2) { // ?要素がなかったら入らない
    params = parameters[1].split("&");
    var paramsArray = array();
    for (i = 0; i < params.length; i++) {
      neet = params[i].split("=");
      paramsArray.push(neet[0]);
      paramsArray[neet[0]] = neet[1];
    }
    if (param in paramsArray) {
      // 要素があるかどうか
      categoryKey = paramsArray[param];
    } else {
      // 欲しい要素が無い
      categoryKey = false;
    }
  } else {
    // そもそもGETの要素が無い
    categoryKey = false;
  }
  return categoryKey;
}

// リンクの領域のサイズを変更する
function resize_link(link_val, resize) {
  var new_link_val = "";
  if (link_val) {
    $(link_val.split(',')).each(function (index) {
      // 必要なのは、横幅が何%小さくなったかということだけ。
      new_link_val += Math.round(((this) - 0) * resize) + ',';
    });
  }
  new_link_val = new_link_val.slice(0, -1);	//最後の , を削除
  return new_link_val;
}
