(function() {
  var b = /\blang(?:uage)?-(?!\*)(\w+)\b/i, d = self.Prism = {
    util : {
      type : function(a) {
        return Object.prototype.toString.call(a).match(/\[object (\w+)\]/)[1]
      },
      clone : function(a) {
        switch(d.util.type(a)) {
          case "Object":
            var k = {}, c;
            for(c in a)a.hasOwnProperty(c) && (k[c] = d.util.clone(a[c]));
            return k;
          case "Array":
            return a.slice()
        }
        return a
      }
    },
    languages : {
      extend : function(a, k) {
        var c = d.util.clone(d.languages[a]), f;
        for(f in k)c[f] = k[f];
        return c
      },
      insertBefore : function(a, k, c, f) {
        f = f || d.languages;
        var e = f[a], b = {}, g;
        for(g in e)if(e.hasOwnProperty(g)) {
          if(g == k)for(var l in c)c.hasOwnProperty(l) && (b[l] = c[l]);
          b[g] = e[g]
        }
        return f[a] = b
      },
      DFS : function(a, k) {
        for(var c in a)k.call(a, c, a[c]), "Object" === d.util.type(a) && d.languages.DFS(a[c], k)
      }
    },
    highlightAll : function(a, k) {
      for(var c = document.querySelectorAll('code[class*="language-"], [class*="language-"] code, code[class*="lang-"], [class*="lang-"] code'), b = 0, e; e = c[b++];)d.highlightElement(e, !0 === a, k)
    },
    highlightElement : function(a, k, c) {
      for(var f, e, h = a; h && !b.test(h.className);)h = h.parentNode;
      h && (f = (h.className.match(b) || [, ""])[1], e = d.languages[f]);
      if(e && (a.className = a.className.replace(b, "").replace(/\s+/g, " ") + " language-" + f, h = a.parentNode, /pre/i.test(h.nodeName) && (h.className = h.className.replace(b, "").replace(/\s+/g, " ") + " language-" + f), h = a.textContent)) {
        var h = h.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/\u00a0/g, " "), g = {
          element : a,
          language : f,
          grammar : e,
          code : h
        };
        d.hooks.run("before-highlight", g);
        k && self.Worker ? (a = new Worker(d.filename), a.onmessage = function(a) {
          g.highlightedCode = l.stringify(
            JSON.parse(a.data), f
          );
          d.hooks.run("before-insert", g);
          g.element.innerHTML = g.highlightedCode;
          c && c.call(g.element);
          d.hooks.run("after-highlight", g)
        }, a.postMessage(
          JSON.stringify(
            {
              language : g.language,
              code : g.code
            }
          )
        )) : (g.highlightedCode = d.highlight(g.code, g.grammar, g.language), d.hooks.run("before-insert", g), g.element.innerHTML = g.highlightedCode, c && c.call(a), d.hooks.run("after-highlight", g))
      }
    },
    highlight : function(a, b, c) {
      return l.stringify(d.tokenize(a, b), c)
    },
    tokenize : function(a, b, c) {
      c = d.Token;
      var f = [a], e = b.rest;
      if(e) {
        for(var h in e)b[h] = e[h];
        delete b.rest
      }
      a:for(h in b)if(b.hasOwnProperty(h) && b[h])for(var e = b[h], g = e.inside, l = !!e.lookbehind, n = 0, e = e.pattern || e, s = 0; s < f.length; s++) {
        var p = f[s];
        if(f.length > a.length)break a;
        if(!(p instanceof c)) {
          e.lastIndex = 0;
          var m = e.exec(p);
          if(m) {
            l && (n = m[1].length);
            var r = m.index - 1 + n, m = m[0].slice(n), q = r + m.length, r = p.slice(0, r + 1), p = p.slice(q + 1), q = [s, 1];
            r && q.push(r);
            m = new c(h, g ? d.tokenize(m, g) : m);
            q.push(m);
            p && q.push(p);
            Array.prototype.splice.apply(f, q)
          }
        }
      }
      return f
    },
    hooks : {
      all : {},
      add : function(a, b) {
        var c = d.hooks.all;
        c[a] = c[a] || array();
        c[a].push(b)
      },
      run : function(a, b) {
        var c = d.hooks.all[a];
        if(c && c.length)for(var f = 0, e; e = c[f++];)e(b)
      }
    }
  }, l = d.Token = function(a, b) {
    this.type = a;
    this.content = b
  };
  l.stringify = function(a, b, c) {
    if("string" == typeof a)return a;
    if("[object Array]" == Object.prototype.toString.call(a))return a.map(
      function(c) {
        return l.stringify(c, b, a)
      }
    ).join("");
    c = {
      type : a.type,
      content : l.stringify(a.content, b, c),
      tag : "span",
      classes : ["token", a.type],
      attributes : {},
      language : b,
      parent : c
    };
    "comment" == c.type && (c.attributes.spellcheck = "true");
    d.hooks.run("wrap", c);
    var f = "", e;
    for(e in c.attributes)f += e + '="' + (c.attributes[e] || "") + '"';
    return "<" + c.tag + ' class="' + c.classes.join(" ") + '" ' + f + ">" + c.content + "</" + c.tag + ">"
  };
  if(self.document) {
    var n = document.getElementsByTagName("script");
    if(n = n[n.length - 1])d.filename = n.src, document.addEventListener && !n.hasAttribute("data-manual") && document.addEventListener("DOMContentLoaded", d.highlightAll)
  } else self.addEventListener(
    "message", function(a) {
      a = JSON.parse(a.data);
      self.postMessage(
        JSON.stringify(
          d.tokenize(
            a.code, d.languages[a.language]
          )
        )
      );
      self.close()
    }, !1
  )
})();
Prism.languages.markup = {
  comment : /&lt;!--[\w\W]*?--\x3e/g,
  prolog : /&lt;\?.+?\?>/,
  doctype : /&lt;!DOCTYPE.+?>/,
  cdata : /&lt;!\[CDATA\[[\w\W]*?]]\x3e/i,
  tag : {
    pattern : /&lt;\/?[\w:-]+\s*(?:\s+[\w:-]+(?:=(?:("|')(\\?[\w\W])*?\1|\w+))?\s*)*\/?>/gi,
    inside : {
      tag : {
        pattern : /^&lt;\/?[\w:-]+/i,
        inside : {
          punctuation : /^&lt;\/?/,
          namespace : /^[\w-]+?:/
        }
      },
      "attr-value" : {
        pattern : /=(?:('|")[\w\W]*?(\1)|[^\s>]+)/gi,
        inside : {punctuation : /=|>|"/g}
      },
      punctuation : /\/?>/g,
      "attr-name" : {
        pattern : /[\w:-]+/g,
        inside : {namespace : /^[\w-]+?:/}
      }
    }
  },
  entity : /&amp;#?[\da-z]{1,8};/gi
};
Prism.hooks.add(
  "wrap", function(b) {
    "entity" === b.type && (b.attributes.title = b.content.replace(/&amp;/, "&"))
  }
);
Prism.languages.css = {
  comment : /\/\*[\w\W]*?\*\//g,
  atrule : {
    pattern : /@[\w-]+?.*?(;|(?=\s*{))/gi,
    inside : {punctuation : /[;:]/g}
  },
  url : /url\((["']?).*?\1\)/gi,
  selector : /[^\{\}\s][^\{\};]*(?=\s*\{)/g,
  property : /(\b|\B)[\w-]+(?=\s*:)/ig,
  string : /("|')(\\?.)*?\1/g,
  important : /\B!important\b/gi,
  ignore : /&(lt|gt|amp);/gi,
  punctuation : /[\{\};:]/g
};
Prism.languages.markup && Prism.languages.insertBefore(
  "markup", "tag", {
    style : {
      pattern : /(&lt;|<)style[\w\W]*?(>|&gt;)[\w\W]*?(&lt;|<)\/style(>|&gt;)/ig,
      inside : {
        tag : {
          pattern : /(&lt;|<)style[\w\W]*?(>|&gt;)|(&lt;|<)\/style(>|&gt;)/ig,
          inside : Prism.languages.markup.tag.inside
        },
        rest : Prism.languages.css
      }
    }
  }
);
Prism.languages.css.selector = {
  pattern : /[^\{\}\s][^\{\}]*(?=\s*\{)/g,
  inside : {
    "pseudo-element" : /:(?:after|before|first-letter|first-line|selection)|::[-\w]+/g,
    "pseudo-class" : /:[-\w]+(?:\(.*\))?/g,
    "class" : /\.[-:\.\w]+/g,
    id : /#[-:\.\w]+/g
  }
};
Prism.languages.insertBefore(
  "css", "ignore", {
    hexcode : /#[\da-f]{3,6}/gi,
    entity : /\\[\da-f]{1,8}/gi,
    number : /[\d%\.]+/g,
    "function" : /(attr|calc|cross-fade|cycle|element|hsla?|image|lang|linear-gradient|matrix3d|matrix|perspective|radial-gradient|repeating-linear-gradient|repeating-radial-gradient|rgba?|rotatex|rotatey|rotatez|rotate3d|rotate|scalex|scaley|scalez|scale3d|scale|skewx|skewy|skew|steps|translatex|translatey|translatez|translate3d|translate|url|var)/ig
  }
);
Prism.languages.clike = {
  comment : {
    pattern : /(^|[^\\])(\/\*[\w\W]*?\*\/|(^|[^:])\/\/.*?(\r?\n|$))/g,
    lookbehind : !0
  },
  string : /("|')(\\?.)*?\1/g,
  "class-name" : {
    pattern : /((?:(?:class|interface|extends|implements|trait|instanceof|new)\s+)|(?:catch\s+\())[a-z0-9_\.\\]+/ig,
    lookbehind : !0,
    inside : {punctuation : /(\.|\\)/}
  },
  keyword : /\b(if|else|while|do|for|return|in|instanceof|function|new|try|throw|catch|finally|null|break|continue)\b/g,
  "boolean" : /\b(true|false)\b/g,
  "function" : {
    pattern : /[a-z0-9_]+\(/ig,
    inside : {punctuation : /\(/}
  },
  number : /\b-?(0x[\dA-Fa-f]+|\d*\.?\d+([Ee]-?\d+)?)\b/g,
  operator : /[-+]{1,2}|!|&lt;=?|>=?|={1,3}|(&amp;){1,2}|\|?\||\?|\*|\/|\~|\^|\%/g,
  ignore : /&(lt|gt|amp);/gi,
  punctuation : /[{}[\];(),.:]/g
};
Prism.languages.javascript = Prism.languages.extend(
  "clike", {
    keyword : /\b(var|let|if|else|while|do|for|return|in|instanceof|function|new|with|typeof|try|throw|catch|finally|null|break|continue)\b/g,
    number : /\b-?(0x[\dA-Fa-f]+|\d*\.?\d+([Ee]-?\d+)?|NaN|-?Infinity)\b/g
  }
);
Prism.languages.insertBefore(
  "javascript", "keyword", {
    regex : {
      pattern : /(^|[^/])\/(?!\/)(\[.+?]|\\.|[^/\r\n])+\/[gim]{0,3}(?=\s*($|[\r\n,.;})]))/g,
      lookbehind : !0
    }
  }
);
Prism.languages.markup && Prism.languages.insertBefore(
  "markup", "tag", {
    script : {
      pattern : /(&lt;|<)script[\w\W]*?(>|&gt;)[\w\W]*?(&lt;|<)\/script(>|&gt;)/ig,
      inside : {
        tag : {
          pattern : /(&lt;|<)script[\w\W]*?(>|&gt;)|(&lt;|<)\/script(>|&gt;)/ig,
          inside : Prism.languages.markup.tag.inside
        },
        rest : Prism.languages.javascript
      }
    }
  }
);
Prism.languages.java = Prism.languages.extend(
  "clike", {
    keyword : /\b(abstract|continue|for|new|switch|assert|default|goto|package|synchronized|boolean|do|if|private|this|break|double|implements|protected|throw|byte|else|import|public|throws|case|enum|instanceof|return|transient|catch|extends|int|short|try|char|final|interface|static|void|class|finally|long|strictfp|volatile|const|float|native|super|while)\b/g,
    number : /\b0b[01]+\b|\b0x[\da-f]*\.?[\da-fp\-]+\b|\b\d*\.?\d+[e]?[\d]*[df]\b|\W\d*\.?\d+\b/gi,
    operator : {
      pattern : /([^\.]|^)([-+]{1,2}|!|=?&lt;|=?&gt;|={1,2}|(&amp;){1,2}|\|?\||\?|\*|\/|%|\^|(&lt;){2}|($gt;){2,3}|:|~)/g,
      lookbehind : !0
    }
  }
);
Prism.languages.php = Prism.languages.extend(
  "clike", {
    keyword : /\b(and|or|xor|array|as|break|case|cfunction|class|const|continue|declare|default|die|do|else|elseif|enddeclare|endfor|endforeach|endif|endswitch|endwhile|extends|for|foreach|function|include|include_once|global|if|new|return|static|switch|use|require|require_once|var|while|abstract|interface|public|implements|extends|private|protected|parent|static|throw|null|echo|print|trait|namespace|use|final|yield|goto|instanceof|finally|try|catch)\b/ig,
    constant : /\b[A-Z0-9_]{2,}\b/g
  }
);
Prism.languages.insertBefore(
  "php", "keyword", {
    delimiter : /(\?>|&lt;\?php|&lt;\?)/ig,
    variable : /(\$\w+)\b/ig,
    "package" : {
      pattern : /(\\|namespace\s+|use\s+)[\w\\]+/g,
      lookbehind : !0,
      inside : {punctuation : /\\/}
    }
  }
);
Prism.languages.insertBefore(
  "php", "operator", {
    property : {
      pattern : /(->)[\w]+/g,
      lookbehind : !0
    }
  }
);
Prism.languages.markup && (Prism.hooks.add(
  "before-highlight", function(b) {
    "php" === b.language && (b.tokenStack = array(), b.code = b.code.replace(
      /(?:&lt;\?php|&lt;\?|<\?php|<\?)[\w\W]*?(?:\?&gt;|\?>)/ig, function(d) {
        b.tokenStack.push(d);
        return "{{{PHP" + b.tokenStack.length + "}}}"
      }
    ))
  }
), Prism.hooks.add(
  "after-highlight", function(b) {
    if("php" === b.language) {
      for(var d = 0, l; l = b.tokenStack[d]; d++)b.highlightedCode = b.highlightedCode.replace("{{{PHP" + (d + 1) + "}}}", Prism.highlight(l, b.grammar, "php"));
      b.element.innerHTML = b.highlightedCode
    }
  }
), Prism.hooks.add(
  "wrap", function(b) {
    "php" === b.language && "markup" === b.type && (b.content = b.content.replace(/(\{\{\{PHP[0-9]+\}\}\})/g, '<span class="token php">$1</span>'))
  }
), Prism.languages.insertBefore(
  "php", "comment", {
    markup : {
      pattern : /(&lt;|<)[^?]\/?(.*?)(>|&gt;)/g,
      inside : Prism.languages.markup
    },
    php : /\{\{\{PHP[0-9]+\}\}\}/g
  }
));
Prism.languages.insertBefore(
  "php", "variable", {
    "this" : /\$this/g,
    global : /\$_?(GLOBALS|SERVER|GET|POST|FILES|REQUEST|SESSION|ENV|COOKIE|HTTP_RAW_POST_DATA|argc|argv|php_errormsg|http_response_header)/g,
    scope : {
      pattern : /\b[\w\\]+::/g,
      inside : {
        keyword : /(static|self|parent)/,
        punctuation : /(::|\\)/
      }
    }
  }
);
Prism.languages.python = {
  comment : {
    pattern : /(^|[^\\])#.*?(\r?\n|$)/g,
    lookbehind : !0
  },
  string : /("|')(\\?.)*?\1/g,
  keyword : /\b(as|assert|break|class|continue|def|del|elif|else|except|exec|finally|for|from|global|if|import|in|is|lambda|pass|print|raise|return|try|while|with|yield)\b/g,
  "boolean" : /\b(True|False)\b/g,
  number : /\b-?(0x)?\d*\.?[\da-f]+\b/g,
  operator : /[-+]{1,2}|=?&lt;|=?&gt;|!|={1,2}|(&){1,2}|(&amp;){1,2}|\|?\||\?|\*|\/|~|\^|%|\b(or|and|not)\b/g,
  ignore : /&(lt|gt|amp);/gi,
  punctuation : /[{}[\];(),.:]/g
};
Prism.languages.http = {
  "request-line" : {
    pattern : /^(POST|GET|PUT|DELETE|OPTIONS)\b\shttps?:\/\/\S+\sHTTP\/[0-9.]+/g,
    inside : {
      property : /^\b(POST|GET|PUT|DELETE|OPTIONS)\b/g,
      "attr-name" : /:\w+/g
    }
  },
  "response-status" : {
    pattern : /^HTTP\/1.[01] [0-9]+.*/g,
    inside : {property : /[0-9]+[A-Z\s-]+$/g}
  },
  keyword : /^[\w-]+:(?=.+)/gm
};
var httpLanguages = {
  "application/json" : Prism.languages.javascript,
  "application/xml" : Prism.languages.markup,
  "text/xml" : Prism.languages.markup,
  "text/html" : Prism.languages.markup
}, contentType;
for(contentType in httpLanguages)if(httpLanguages[contentType]) {
  var options = {};
  options[contentType] = {
    pattern : RegExp("(content-type:\\s*" + contentType + "[\\w\\W]*?)\\n\\n[\\w\\W]*", "gi"),
    lookbehind : !0,
    inside : {rest : httpLanguages[contentType]}
  };
  Prism.languages.insertBefore("http", "keyword", options)
}
Prism.languages.ruby = Prism.languages.extend(
  "clike", {
    comment : /#[^\r\n]*(\r?\n|$)/g,
    keyword : /\b(alias|and|BEGIN|begin|break|case|class|def|define_method|defined|do|each|else|elsif|END|end|ensure|false|for|if|in|module|new|next|nil|not|or|raise|redo|require|rescue|retry|return|self|super|then|throw|true|undef|unless|until|when|while|yield)\b/g,
    builtin : /\b(Array|Bignum|Binding|Class|Continuation|Dir|Exception|FalseClass|File|Stat|File|Fixnum|Fload|Hash|Integer|IO|MatchData|Method|Module|NilClass|Numeric|Object|Proc|Range|Regexp|String|Struct|TMS|Symbol|ThreadGroup|Thread|Time|TrueClass)\b/,
    constant : /\b[A-Z][a-zA-Z_0-9]*[?!]?\b/g
  }
);
Prism.languages.insertBefore(
  "ruby", "keyword", {
    regex : {
      pattern : /(^|[^/])\/(?!\/)(\[.+?]|\\.|[^/\r\n])+\/[gim]{0,3}(?=\s*($|[\r\n,.;})]))/g,
      lookbehind : !0
    },
    variable : /[@$&]+\b[a-zA-Z_][a-zA-Z_0-9]*[?!]?\b/g,
    symbol : /:\b[a-zA-Z_][a-zA-Z_0-9]*[?!]?\b/g
  }
);
