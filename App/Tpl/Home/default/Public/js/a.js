document.cookie = "js=1; path=/";
function aaa(a) {}
function getUSERID() {
	if (typeof USER !== "undefined" && USER.ID) {
		return USER.ID
	} else {
		return ""
	}
}
function isSTAFF() {
	if (typeof USER !== "undefined" && USER.ISSTAFF) {
		return true
	} else {
		return false
	}
}
if (!Array.prototype.indexOf) {
	Array.prototype.indexOf = function(c, b) {
		if (b == null) {
			b = 0
		} else {
			if (b < 0) {
				b = Math.max(0, this.length + b)
			}
		}
		for (var a = b; a < this.length; a++) {
			if (this[a] === c) {
				return a
			}
		}
		return - 1
	}
}
if (!String.prototype.lenB) {
	String.prototype.lenB = function() {
		return this.replace(/[^\x00-\xff]/g, "**").length
	}
}
if (!String.prototype.leftB) {
	String.prototype.leftB = function(h) {
		var g = this,
		d = g.slice(0, h),
		f = d.replace(/[^\x00-\xff]/g, "**").length;
		if (f <= h) {
			return d
		}
		f -= d.length;
		switch (f) {
		case 0:
			return d;
		case h:
			return g.slice(0, h >> 1);
		default:
			var b = h - f,
			a = g.slice(b, h),
			c = a.replace(/[\x00-\xff]/g, "").length;
			return c ? g.slice(0, b) + a.leftB(c) : g.slice(0, b)
		}
	}
}
if (!String.prototype.cut) {
	String.prototype.cut = function(g, d, c) {
		var f = this;
		r = c ? f.substr(0, g) : f.leftB(g);
		return r == f ? r: r + (typeof d === "undefined" ? "鈥�": d)
	}
}
function blinkIt(d, b, a, f, c) {
	c = c || 1000;
	if (f === 0) {
		a();
		return
	}
	if ($.isFunction(d)) {
		d()
	}
	window.setTimeout(function() {
		blinkIt(b, d, a, --f, c)
	},
	c)
}
function refresh() {
	window.location.href = window.location.href.replace(/#.*$/ig, "")
}
function addURLParam(c, f) {
	var b = c.indexOf("?") == -1 ? "?": "&";
	c += b;
	for (var d in f) {
		c += d.toString() + "=" + encodeURIComponent(f[d]) + "&"
	}
	return c.slice(0, -1)
}
function fromSelector(h, c) {
	var d = h.split(" "),
	g = d[d.length - 1],
	i = g.match(/^[a-z]+/ig) || "div",
	j = (g.match(/\.[a-z_-]+/ig) || "").toString().substr(1),
	f = (g.match(/#[a-z_-]+/ig) || "").toString().substr(1);
	return c ? {
		tagName: i,
		id: f,
		"class": j
	}: $("<" + i + ">").attr({
		"class": j,
		id: f
	})
}
function getNum(a) {
	return a ? parseInt(a.replace(/^([^\d]*)/g, "")) || 0 : 0
}
function getFitSize(d, c) {
	if (d[0] && d[1] && c[0]) {
		if (!c[1]) {
			c[1] = c[0]
		}
		if (d[0] > c[0] || d[1] > c[1]) {
			var g = d[0] / d[1],
			f = g >= c[0] / c[1];
			return f ? [c[0], parseInt(c[0] / g)] : [parseInt(c[1] * g), c[1]]
		}
	}
	return d
}
function setImgSize(b, a, f) {
	b.onload = null;
	b.removeAttribute("width");
	b.removeAttribute("height");
	var c = b;
	if (c && c.width && c.height && a) {
		if (!f) {
			f = a
		}
		if (c.width > a || c.height > f) {
			var g = c.width / c.height,
			d = g >= a / f;
			b[d ? "width": "height"] = d ? a: f;
			if (document.all) {
				b[d ? "height": "width"] = (d ? a: f) * (d ? 1 / g: g)
			}
		}
	}
	b.style.visibility = "visible"
}
function setImgSizeByAncestor(f, b) {
	f.onload = null;
	var d = $(f).parent(b)[0];
	if (d) {
		var c = parseInt($(d).css("width"));
		c = c ? c: d.offsetWidth;
		setImgSize(f, c)
	}
}
function getCursorPosition(b) {
	var a = {
		text: "",
		start: 0,
		end: 0
	};
	if (b.setSelectionRange) {
		a.start = b.selectionStart;
		a.end = b.selectionEnd;
		a.text = (a.start != a.end) ? b.value.substring(a.start, a.end) : ""
	} else {
		if (document.selection) {
			var c, d = document.selection.createRange(),
			f = document.body.createTextRange();
			f.moveToElementText(b);
			a.text = d.text;
			a.bookmark = d.getBookmark();
			for (c = 0; f.compareEndPoints("StartToStart", d) < 0 && d.moveStart("character", -1) !== 0; c++) {
				if (b.value.charAt(c) == "\n") {
					c++
				}
			}
			a.start = c;
			a.end = a.text.length + a.start
		}
	}
	return a
}
function setCursorPosition(b, a) {
	if (!a) {
		alert("You must get cursor position first.")
	}
	if (b.setSelectionRange) {
		b.focus();
		b.setSelectionRange(a.start, a.end)
	} else {
		if (b.createTextRange) {
			var c = b.createTextRange();
			if (b.value.length === a.start) {
				c.collapse(false);
				c.select()
			} else {
				c.moveToBookmark(a.bookmark);
				c.select()
			}
		}
	}
}
function simpleMarqueeW(b, f, i, d) {
	var j = $(b),
	c = j.find(":first-child"),
	h = j.parent();
	if (c.length) {
		var f = f || 4000,
		i = i || 2,
		d = d || 20,
		l, m = false,
		c, k;
		var a = function() {
			k = c.outerWidth(true);
			clearInterval(l);
			l = setInterval(g, d)
		};
		var g = function() {
			if (m) {
				return
			}
			if (h.scrollLeft() + i >= k) {
				clearInterval(l);
				j.append(c);
				h.scrollLeft(0);
				setTimeout(a, f)
			} else {
				h.scrollLeft(h.scrollLeft() + i)
			}
		};
		j.mouseover(function() {
			m = true
		});
		j.mouseout(function() {
			m = false
		});
		setTimeout(a, f)
	}
}
function simpleMarqueeH(b, f, j, h, d) {
	var i = $(b),
	c = i.find(":first-child");
	if (c.length) {
		var f = f || 4000,
		h = h || 2,
		d = d || 20,
		l, m = false,
		c, k;
		var a = function() {
			k = c.outerHeight(true);
			clearInterval(l);
			l = setInterval(g, d)
		};
		var g = function() {
			if (m) {
				return
			}
			if (i.scrollTop() + h >= k) {
				clearInterval(l);
				i.append(c);
				i.scrollTop(0);
				setTimeout(a, f)
			} else {
				i.scrollTop(i.scrollTop() + h)
			}
		};
		i.mouseover(function() {
			m = true
		});
		i.mouseout(function() {
			m = false
		});
		setTimeout(a, j)
	}
}
function bindChecks(j, c, d, i, a) {
	var b = $("input[type=checkbox],[checked],[checked=false]", c),
	h = $(j);
	function g() {
		var l = [],
		k = "",
		f = $("input[type=checkbox],[checked],[checked=false]", c);
		if (h.prop("checked")) {
			f.each(function(o, n) {
				var p = $(n),
				m = p.attr("value");
				p.prop("checked", true);
				if (m !== undefined) {
					p.attr("dvalue", m)
				}
				l.push(p.attr("dvalue"))
			});
			h.prop("checked", true).add(f).addClass("checked")
		} else {
			f.each(function(n, m) {
				$(m).prop("checked", false)
			});
			h.prop("checked", false).add(f).removeClass("checked")
		}
		k = $.trim(l.join(" ")).replace(/ /ig, ",");
		h.attr("dvalue", k);
		if (h.attr("type") == "checkbox") {
			h.val(k)
		}
	}
	if (d) {
		h.prop("checked", true)
	} else {
		if (d !== undefined) {
			h.prop("checked", false)
		} else {
			if (h.attr("dchecked") == "true") {
				h.prop("checked", true)
			} else {
				if (!h.prop("checked")) {
					h.prop("checked", false)
				}
			}
		}
	}
	g();
	if (h.attr("type") != "checkbox") {
		h.click(function(k) {
			var f = true;
			if ($.isFunction(i)) {
				f = i()
			}
			if (f) {
				h.prop("checked", !h.prop("checked"))
			}
		})
	}
	h.click(function(k) {
		k.stopPropagation();
		var f = true;
		if ($.isFunction(i)) {
			f = i()
		}
		if (f) {
			g();
			if ($.isFunction(a)) {
				a()
			}
		}
	});
	b.click(function(o) {
		o.stopPropagation();
		var n = $(this);
		if (n.attr("type") != "checkbox") {
			n.prop("checked", !n.prop("checked"))
		}
		var m = $.trim(h.attr("dvalue")),
		f = m ? m.split(",") : [],
		l = "",
		k = n.attr("value");
		if (k !== undefined) {
			n.attr("dvalue", k)
		}
		k = n.attr("dvalue");
		f = $(f).filter(function(q, p) {
			return p !== k
		}).get();
		if (n.prop("checked")) {
			f.push(k);
			n.addClass("checked")
		} else {
			n.removeClass("checked")
		}
		l = $.trim(f.join(" ")).replace(/ /ig, ",");
		h.attr("dvalue", l);
		if (h.attr("type") == "checkbox") {
			h.val(l)
		}
	})
}
function isLink(a) {
	return !! a.match(/^(?:http(?:s)?:\/\/)(?:(?:[\w-]+\.)+[\w-]+)(?:\:\d+)?(?:\/[\w-\.\/%]*)?(?:[?][\w-\.\/%!*\(\);\:@&=+$,\[\]]*)?(?:#[\w-\.\/%!*\(\);\:@&=+$,\[\]]*)?$/ig)
}
function trimLink(a, b) {
	return a.replace(/(?:http(?:s)?:\/\/)(?:(?:[\w-]+\.)+[\w-]+)(?:\:\d+)?(?:\/[\w-\.\/%]*)?(?:[?][\w-\.\/%!*\(\);\:@&=+$,\[\]]*)?(?:#[\w-\.\/%!*\(\);\:@&=+$,\[\]]*)?/ig,
	function(c) {
		return b ? '<a href="' + c + '" target="_blank">' + c + "</a>": ""
	})
}
function getSelectedText() {
	var a = window,
	b = document;
	if (a.getSelection) {
		return a.getSelection().toString()
	} else {
		if (b.getSelection) {
			return b.getSelection()
		} else {
			if (b.selection) {
				return b.selection.createRange().text
			}
		}
	}
}
function getToken(h) {
	var d = {},
	b = "",
	g = "",
	j = "",
	c = $(window),
	a = c.data("verification") || [],
	i = $("input", "#form-token");
	if (b = $.Bom.getCookie("csrftoken")) {
		g = "csrfmiddlewaretoken=" + b;
		d.csrfmiddlewaretoken = b
	} else {
		if (i.length) {
			b = i.val();
			d.csrfmiddlewaretoken = b;
			g = $.param(d)
		}
	}
	j = '<input type="hidden" name="csrfmiddlewaretoken" value="' + b + '" />';
	if (b && a.length) {
		g += "&recaptcha_response_field=" + a[0];
		g += "&recaptcha_challenge_field=" + a[1];
		d.recaptcha_response_field = a[0];
		d.recaptcha_challenge_field = a[1];
		j += '<input type="hidden" name="recaptcha_response_field" value="' + a[0] + '" /><input type="hidden" name="recaptcha_challenge_field" value="' + a[1] + '" />'
	}
	return h ? h == 3 ? j: h == 2 ? d: g: g
}
function getTokenVal() {
	var a = "",
	b = $("input", "#form-token");
	if (a = $.Bom.getCookie("csrftoken")) {} else {
		if (b.length) {
			a = b.val()
		}
	}
	return a
}
function mergeServerMessage(d) {
	var c = "";
	if ($.isArray(d)) {
		for (var b = 0; b < d.length; b++) {
			if ($.isArray(d[b])) {
				var a = d[b][1] || d[b][0] || "";
				c += a + ","
			}
			c += d[b] + ";"
		}
		c = c.slice(0, -1)
	} else {
		if ($.isPlainObject(d)) {
			for (e in d) {
				c += d[e].toString() + ";"
			}
			c = c.slice(0, -1)
		} else {
			c = d
		}
	}
	return c.split(";")[0].split(",")[0]
}
function dtImageTrans(d, f, a, g, j) {
	var b = $.trim(d).replace(/^http(s)?:\/\//ig, ""),
	b = b.split("/"),
	i = b[0],
	b = b[1];
	if (i.indexOf("duitang.com") == -1 || !b || b != "uploads" && b != "misc") {
		return d
	}
	if (f) {
		a = a || 0;
		g = g || 0;
		j = j ? "_" + j: "";
		return dtImageTrans(d).replace(/(\.[a-z_]+)$/ig, ".thumb." + a + "_" + g + j + "$1")
	} else {
		return d.replace(/(?:\.thumb\.\w+|\.[a-z]+!\w+)(\.[a-z_]+)$/ig, "$1")
	}
}
function parseUrlParams(f) {
	var c = {},
	b = f.replace(/^\?/, "").split("&"),
	a = b.length,
	d = 0,
	g;
	for (; d < a; d++) {
		if (!b[d]) {
			continue
		}
		g = b[d].split("=");
		c[g[0]] = g[1]
	}
	return c
}
function recurseDo(c, a, f, b, d) {
	if (f == 0) {
		if ($.isFunction(d)) {
			d()
		}
		return
	}
	a = c.apply(null, a);
	if (a[0].length) {
		setTimeout(function() {
			recurseDo(c, a, --f, b, d)
		},
		b)
	} else {
		if ($.isFunction(d)) {
			d()
		}
	}
}
function getParams(b) {
	var a = {},
	c, h, f, b = b.split("#")[0],
	j = b.indexOf("?"),
	l = b.substr(j + 1),
	g = l.split("&");
	for (f = 0, len = g.length; f < len; f++) {
		var k = g[f].indexOf("=");
		if (k > 0) {
			c = g[f].substring(0, k);
			h = g[f].substr(k + 1);
			try {
				if (h.indexOf("+") > -1) {
					h = h.replace(/\+/g, " ")
				}
				a[c] = decodeURIComponent(h)
			} catch(d) {}
		}
	}
	return a
}
function addParam(a, d, c) {
	var b = new RegExp("([&\\?])" + d + "=[^& ]*", "g");
	a = a.replace(b,
	function(g, f) {
		return f == "?" ? "?": ""
	});
	a += (a.indexOf("?") > -1 ? "&": "?") + d + "=" + c;
	return a
}
function isFromDomain(a) {
	a = a.replace("http://", "").replace("https://", "");
	a = a.split("?");
	a = a[0].split("/");
	a = a[0];
	for (var b = 1; b < arguments.length; b++) {
		if (a.indexOf(arguments[b]) > -1) {
			return true
		}
	}
	return false
}
$.ajaxSetup({
	type: "POST",
	timeout: 20000,
	wrongmsg: function(b) {
		alert("wrongmsg");
		var a = $.trim(mergeServerMessage(b.message));
		if (a) {
			SUGAR.PopOut.alert('<div class="prompt prompt-fail"><h3>' + a + "</h3></div>");
			$({}).delay(4000).queue(function() {
				SUGAR.PopOut.closeMask()
			})
		}
	},
	errormsg: function() {
		alert("errormsg");
		SUGAR.PopOut.alert('<div class="prompt prompt-fail"><h3>缃戠粶鍑洪棶棰樹簡锛岃绋嶅悗鍐嶈瘯</h3></div>');
		$({}).delay(2000).queue(function() {
			SUGAR.PopOut.closeMask()
		})
	},
	success: function(f, b, a) {
		// if ($.inArray("html", this.dataTypes) != -1) {
		// 	return
		// }

		var d = $.isPlainObject(f) ? f: $.parseJSON(f);
		// if (!d) {
		// 	_gaq.push(["_trackPageview", "/_trc/Error/ajax/json_parse_fail_" + this.url]);
		// 	return
		// }


		if (d.success || d.status == 1) {
			if ($.isFunction(this.mysuccess)) {
				this.mysuccess(d, f)
			}
		} else {
			var c = mergeServerMessage(d.message);
			if ($.isFunction(this.myfailure)) {
				this.myfailure(d, f)
			} else {
				if (c) {
					this.wrongmsg(d)
				}
			}
			if (c) {
				_gaq.push(["_trackPageview", "/_trc/Error/ajax/response_" + c + "_" + this.url])
			}
		}
	},
	error: function(b, a) {
		alert("error");
		_gaq.push(["_trackPageview", "/_trc/Error/ajax/status_" + a + "_" + (this.url ? this.url: "null_" + window.location.href)]);
		if ($.isFunction(this.myerror)) {
			this.myerror(b, a)
		}
	}
}); (function(d) {
	var b = d.event,
	a = b.special;
	function c(f) {
		f.preventDefault();
		f.type = "safeSubmit";
		if (b.handle) {
			b.handle.apply(this, arguments)
		} else {
			if (b.dispatch) {
				b.dispatch.apply(this, arguments)
			}
		}
	}
	b.special.safeSubmit = {
		setup: function() {
			var f = this,
			g = d(f);
			b.add(f, "submit", c)
		},
		teardown: function() {
			var f = this,
			g = d(f);
			b.remove(f, "submit", c)
		}
	};
	d.fn.safeSubmit = function(h, g, f) {
		if (typeof f !== "function") {
			f = g;
			g = h;
			h = null
		}

		f = f ||
		function() {
			alert("请输入内容")
		};

		return arguments.length > 0 ? this.unbind("safeSubmit").bind("safeSubmit", h,
		function(l) {
			var j = this,
			m = d(j),
			k = d("input[type=text],textarea", m).not("[name=]").not("[data-optional]"),
			i = d("[type=submit]", m);
			safe = true;
			k.each(function(n, o) {
				if (d.trim(d(o).val()) === "" && safe) {
					safe = false
				}
			});
			i.each(function(n, o) {
				if (d(o).prop("disabled") && safe) {
					safe = false
				}
			});
			if (safe) {
				g.call(this, arguments)
			} else {
				f.call(this, arguments)
			}
		}) : this.trigger("safeSubmit")
	}
})(jQuery); (function(a) {
	a.fn.getFormAction = function() {
		var c = this,
		b = c[0];
		if (b && b.tagName.toLowerCase() === "form") {
			return encodeURI(c.attr("action"))
		}
		return null
	};
	a.fn.paramForm = function(d) {
		var c = this[0];
		var b = {};
		a("input,select,textarea", c).not("[type=submit]").filter("[name]").each(function(g, f) {
			if ((a(f).attr("type") === "checkbox" || a(f).attr("type") === "radio") && a(f).prop("checked") === true || (a(f).attr("type") !== "checkbox" && a(f).attr("type") !== "radio")) {
				if (a.type(b[f.name]) !== "undefined") {
					b[f.name] += "," + f.value
				} else {
					b[f.name] = f.value
				}
			}
		});
		if (a.isPlainObject(d)) {
			a.extend(b, d)
		}
		return a.param(b)
	};
	a.fn.lengthLimit = function(b) {
		this.filter("textarea,input[type=text]").each(function() {
			var f = a(this),
			d = f.attr("maxlength");
			var c = function(j) {
				var i = j ? j.keyCode: null;
				if (!i || i === 8 || i === 13 || i > 36 && i < 41) {
					return
				}
				var h = this,
				g = h.value,
				k = g.cut(d, "");
				if (k.length < g.length) {
					h.value = k;
					h.scrollTop = h.scrollHeight
				}
			};
			a(this).change(function(g) {
				c.call(this, g)
			}).keyup(function(g) {
				c.call(this, g)
			});
			c.apply(this)
		});
		return this
	};
	a.fn.inputTagLimit = function(b) {
		var c = a.extend(true, {},
		{
			invalid: new RegExp("/"),
			taglen: 20
		},
		b);
		this.filter("textarea,input[type=text]").each(function() {
			var h = a(this),
			g = c.taglen,
			d;
			var f = function(n) {
				var l = n ? n.keyCode: null;
				if (!l || l === 8 || l === 13 || l > 36 && l < 41) {
					return
				}
				var k = h.val(),
				i = k.split(" "),
				i = i[i.length - 1],
				j = k.substring(0, k.length - i.length);
				if (k[k.length - 1] != " " && i && i.lenB() > g) {
					i = i.cut(g, "");
					k = j + i
				}
				h.val(k.replace(c.invalid, ""));
				vl = h.val().length;
				setCursorPosition(h[0], {
					start: vl,
					end: vl
				})
			};
			a(this).change(function(i) {
				f.call(this, i)
			}).keyup(function(i) {
				f.call(this, i)
			});
			f.apply(this)
		});
		return this
	};
	a.fn.pagelimit = function(f) {
		var g = a(this),
		d = f.length || 0;
		function b() {
			var h = parseInt(this.value) || 0;
			var i = d || 0;
			if (h > i) {
				this.value = i
			} else {
				if (h < 1) {
					this.value = 1
				} else {
					this.value = h
				}
			}
		}
		function c(h) {
			if (! (h.keyCode >= 37 && h.keyCode <= 40 || h.keyCode == 46 || h.keyCode == 8)) {
				b.call(this)
			}
		}
		g.change(c).keyup(c);
		b.call(this)
	};
	a.fn.setCursorPosition = function(b) {
		this.each(function(d, f) {
			if (f.setSelectionRange) {
				f.setSelectionRange(b, b)
			} else {
				if (f.createTextRange) {
					var c = f.createTextRange();
					c.collapse(true);
					c.moveEnd("character", b);
					c.moveStart("character", b);
					c.select()
				}
			}
		});
		return this
	}
})(jQuery); (function(a) {
	function b(c, g) {
		for (var d = 0,
		f = ""; d < g; d++) {
			f += c
		}
		return f
	}
	a.fn.autogrow = function(c) {
		this.filter("textarea").each(function() {
			this.timeoutId = null;
			var i = a(this),
			f = i.height();
			var h = a("<div></div>").css({
				position: "absolute",
				wordWrap: "break-word",
				top: 0,
				left: -9999,
				display: "none",
				width: i.width(),
				fontSize: i.css("fontSize"),
				fontFamily: i.css("fontFamily"),
				lineHeight: i.css("lineHeight")
			}).appendTo(document.body);
			var g = function() {
				var j = this.value.replace(/</g, "<").replace(/>/g, ">").replace(/&/g, "&").replace(/\n$/, "<br/>&nbsp;").replace(/\n/g, "<br/>").replace(/ {2,}/g,
				function(k) {
					return b("&nbsp;", k.length - 1) + " "
				});
				h.html(j);
				a(this).css("overflow", "hidden").css("height", Math.max(h.height() + (parseInt(i.css("lineHeight")) || 0), f))
			};
			var d = function() {
				clearTimeout(this.timeoutId);
				var j = this;
				this.timeoutId = setTimeout(function() {
					g.apply(j)
				},
				100)
			};
			a(this).change(g).keyup(d).keydown(d);
			g.apply(this)
		});
		return this
	}
})(jQuery);
/*
* jQuery blockUI plugin
* Version 2.39 (23-MAY-2011)
* @requires jQuery v1.2.3 or later
*
* Examples at: http://malsup.com/jquery/block/
* Copyright (c) 2007-2010 M. Alsup
* Dual licensed under the MIT and GPL licenses:
* http://www.opensource.org/licenses/mit-license.php
* http://www.gnu.org/licenses/gpl.html
*
* Thanks to Amir-Hossein Sobhi for some excellent contributions!
*/
(function(j) {
	j.fn._fadeIn = j.fn.fadeIn;
	var c = function() {};
	var k = document.documentMode || 0;
	var f = j.browser.msie && ((j.browser.version < 8 && !k) || k < 8);
	var g = j.browser.msie && /MSIE 6.0/.test(navigator.userAgent) && !k;
	j.blockUI = function(q) {
		d(window, q)
	};
	j.unblockUI = function(q) {
		i(window, q)
	};
	j.growlUI = function(v, t, u, q) {
		var s = j('<div class="growlUI"></div>');
		if (v) {
			s.append("<h1>" + v + "</h1>")
		}
		if (t) {
			s.append("<h2>" + t + "</h2>")
		}
		if (u == undefined) {
			u = 3000
		}
		j.blockUI({
			message: s,
			fadeIn: 700,
			fadeOut: 1000,
			centerY: false,
			timeout: u,
			showOverlay: false,
			onUnblock: q,
			css: j.blockUI.defaults.growlCSS
		})
	};
	j.fn.block = function(q) {
		return this.unblock({
			fadeOut: 0
		}).each(function() {
			if (j.css(this, "position") == "static") {
				this.style.position = "relative"
			}
			if (j.browser.msie) {
				this.style.zoom = 1
			}
			d(this, q)
		})
	};
	j.fn.unblock = function(q) {
		return this.each(function() {
			i(this, q)
		})
	};
	j.blockUI.version = 2.39;
	j.blockUI.defaults = {
		message: "<h1>Please wait...</h1>",
		title: null,
		draggable: true,
		theme: false,
		css: {
			padding: 0,
			margin: 0,
			width: "30%",
			top: "40%",
			left: "35%",
			textAlign: "center",
			color: "#000",
			border: "none",
			backgroundColor: "#fff"
		},
		themedCSS: {
			width: "30%",
			top: "40%",
			left: "35%"
		},
		overlayCSS: {
			backgroundColor: "#000",
			opacity: 0.4
		},
		growlCSS: {
			width: "350px",
			top: "10px",
			left: "",
			right: "10px",
			border: "none",
			padding: "5px",
			opacity: 0.6,
			cursor: "default",
			color: "#fff",
			backgroundColor: "#000",
			"-webkit-border-radius": "10px",
			"-moz-border-radius": "10px",
			"border-radius": "10px"
		},
		iframeSrc: /^https/i.test(window.location.href || "") ? "javascript:false": "about:blank",
		forceIframe: false,
		baseZ: 1000,
		centerX: true,
		centerY: true,
		allowBodyStretch: true,
		bindEvents: true,
		constrainTabKey: true,
		fadeIn: 200,
		fadeOut: 200,
		timeout: 0,
		showOverlay: true,
		focusInput: false,
		applyPlatformOpacityRules: true,
		onBlock: null,
		onUnblock: null,
		quirksmodeOffsetHack: 4,
		blockMsgClass: "blockMsg"
	};
	var b = null;
	var h = [];
	function d(v, H) {
		var C = (v == window);
		var y = H && H.message !== undefined ? H.message: undefined;
		H = j.extend({},
		j.blockUI.defaults, H || {});
		H.overlayCSS = j.extend({},
		j.blockUI.defaults.overlayCSS, H.overlayCSS || {});
		var E = j.extend({},
		j.blockUI.defaults.css, H.css || {});
		var P = j.extend({},
		j.blockUI.defaults.themedCSS, H.themedCSS || {});
		y = y === undefined ? H.message: y;
		if (C && b) {
			i(window, {
				fadeOut: 0
			})
		}
		if (y && typeof y != "string" && (y.parentNode || y.jquery)) {
			var K = y.jquery ? y[0] : y;
			var R = {};
			j(v).data("blockUI.history", R);
			R.el = K;
			R.parent = K.parentNode;
			R.display = K.style.display;
			R.position = K.style.position;
			if (R.parent) {
				R.parent.removeChild(K)
			}
		}
		j(v).data("blockUI.onUnblock", H.onUnblock);
		var D = H.baseZ;
		var O = (j.browser.msie || H.forceIframe) ? j('<iframe class="blockUI" style="z-index:' + (D++) + ';display:none;border:none;margin:0;padding:0;position:absolute;width:100%;height:100%;top:0;left:0" src="' + H.iframeSrc + '"></iframe>') : j('<div class="blockUI" style="display:none"></div>');
		var N = H.theme ? j('<div class="blockUI blockOverlay ui-widget-overlay" style="z-index:' + (D++) + ';display:none"></div>') : j('<div class="blockUI blockOverlay" style="z-index:' + (D++) + ';display:none;border:none;margin:0;padding:0;width:100%;height:100%;top:0;left:0"></div>');
		var M, I;
		if (H.theme && C) {
			I = '<div class="blockUI ' + H.blockMsgClass + ' blockPage ui-dialog ui-widget ui-corner-all" style="z-index:' + (D + 10) + ';display:none;position:fixed"><div class="ui-widget-header ui-dialog-titlebar ui-corner-all blockTitle">' + (H.title || "&nbsp;") + '</div><div class="ui-widget-content ui-dialog-content"></div></div>'
		} else {
			if (H.theme) {
				I = '<div class="blockUI ' + H.blockMsgClass + ' blockElement ui-dialog ui-widget ui-corner-all" style="z-index:' + (D + 10) + ';display:none;position:absolute"><div class="ui-widget-header ui-dialog-titlebar ui-corner-all blockTitle">' + (H.title || "&nbsp;") + '</div><div class="ui-widget-content ui-dialog-content"></div></div>'
			} else {
				if (C) {
					I = '<div class="blockUI ' + H.blockMsgClass + ' blockPage" style="z-index:' + (D + 10) + ';display:none;position:fixed"></div>'
				} else {
					I = '<div class="blockUI ' + H.blockMsgClass + ' blockElement" style="z-index:' + (D + 10) + ';display:none;position:absolute"></div>'
				}
			}
		}
		M = j(I);
		if (y) {
			if (H.theme) {
				M.css(P);
				M.addClass("ui-widget-content")
			} else {
				M.css(E)
			}
		}
		if (!H.theme && (!H.applyPlatformOpacityRules || !(j.browser.mozilla && /Linux/.test(navigator.platform)))) {
			N.css(H.overlayCSS)
		}
		N.css("position", C ? "fixed": "absolute");
		if (j.browser.msie || H.forceIframe) {
			O.css("opacity", 0)
		}
		var B = [O, N, M],
		Q = C ? j("body") : j(v);
		j.each(B,
		function() {
			this.appendTo(Q)
		});
		if (H.theme && H.draggable && j.fn.draggable) {
			M.draggable({
				handle: ".ui-dialog-titlebar",
				cancel: "li"
			})
		}
		var x = f && (!j.boxModel || j("object,embed", C ? null: v).length > 0);
		if (g || x) {
			if (C && H.allowBodyStretch && j.boxModel) {
				j("html,body").css("height", "100%")
			}
			if ((g || !j.boxModel) && !C) {
				var G = n(v, "borderTopWidth"),
				L = n(v, "borderLeftWidth");
				var A = G ? "(0 - " + G + ")": 0;
				var F = L ? "(0 - " + L + ")": 0
			}
			j.each([O, N, M],
			function(t, U) {
				var z = U[0].style;
				z.position = "absolute";
				if (t < 2) {
					C ? z.setExpression("height", "Math.max(document.body.scrollHeight, document.body.offsetHeight) - (jQuery.boxModel?0:" + H.quirksmodeOffsetHack + ') + "px"') : z.setExpression("height", 'this.parentNode.offsetHeight + "px"');
					C ? z.setExpression("width", 'jQuery.boxModel && document.documentElement.clientWidth || document.body.clientWidth + "px"') : z.setExpression("width", 'this.parentNode.offsetWidth + "px"');
					if (F) {
						z.setExpression("left", F)
					}
					if (A) {
						z.setExpression("top", A)
					}
				} else {
					if (H.centerY) {
						if (C) {
							z.setExpression("top", '(document.documentElement.clientHeight || document.body.clientHeight) / 2 - (this.offsetHeight / 2) + (blah = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop) + "px"')
						}
						z.marginTop = 0
					} else {
						if (!H.centerY && C) {
							var S = (H.css && H.css.top) ? parseInt(H.css.top) : 0;
							var T = "((document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop) + " + S + ') + "px"';
							z.setExpression("top", T)
						}
					}
				}
			})
		}
		if (y) {
			if (H.theme) {
				M.find(".ui-widget-content").append(y)
			} else {
				M.append(y)
			}
			if (y.jquery || y.nodeType) {
				j(y).show()
			}
		}
		if ((j.browser.msie || H.forceIframe) && H.showOverlay) {
			O.show()
		}
		if (H.fadeIn) {
			var J = H.onBlock ? H.onBlock: c;
			var u = (H.showOverlay && !y) ? J: c;
			var q = y ? J: c;
			if (H.showOverlay) {
				N._fadeIn(H.fadeIn, u)
			}
			if (y) {
				M._fadeIn(H.fadeIn, q)
			}
		} else {
			if (H.showOverlay) {
				N.show()
			}
			if (y) {
				M.show()
			}
			if (H.onBlock) {
				H.onBlock()
			}
		}
		m(1, v, H);
		if (C) {
			b = M[0];
			h = j(":input:enabled:visible", b).not("[type=file]");
			if (H.focusInput) {
				setTimeout(p, 20)
			}
		} else {
			a(M[0], H.centerX, H.centerY)
		}
		if (H.timeout) {
			var w = setTimeout(function() {
				C ? j.unblockUI(H) : j(v).unblock(H)
			},
			H.timeout);
			j(v).data("blockUI.timeout", w)
		}
	}
	function i(u, v) {
		var t = (u == window);
		var s = j(u);
		var w = s.data("blockUI.history");
		var x = s.data("blockUI.timeout");
		if (x) {
			clearTimeout(x);
			s.removeData("blockUI.timeout")
		}
		v = j.extend({},
		j.blockUI.defaults, v || {});
		m(0, u, v);
		if (v.onUnblock === null) {
			v.onUnblock = s.data("blockUI.onUnblock");
			s.removeData("blockUI.onUnblock")
		}
		var q;
		if (t) {
			q = j("body").children().filter(".blockUI").add("body > .blockUI")
		} else {
			q = j(".blockUI", u)
		}
		if (t) {
			b = h = null
		}
		if (v.fadeOut) {
			q.fadeOut(v.fadeOut);
			setTimeout(function() {
				l(q, w, v, u)
			},
			v.fadeOut)
		} else {
			l(q, w, v, u)
		}
	}
	function l(q, u, t, s) {
		q.each(function(v, w) {
			if (this.parentNode) {
				this.parentNode.removeChild(this)
			}
		});
		if (u && u.el) {
			u.el.style.display = u.display;
			u.el.style.position = u.position;
			if (u.parent) {
				u.parent.appendChild(u.el)
			}
			j(s).removeData("blockUI.history")
		}
		if (typeof t.onUnblock == "function") {
			t.onUnblock(s, t)
		}
	}
	function m(q, v, w) {
		var u = v == window,
		t = j(v);
		if (!q && (u && !b || !u && !t.data("blockUI.isBlocked"))) {
			return
		}
		if (!u) {
			t.data("blockUI.isBlocked", q)
		}
		if (!w.bindEvents || (q && !w.showOverlay)) {
			return
		}
		var s = "mousedown mouseup keydown keypress";
		q ? j(document).bind(s, w, o) : j(document).unbind(s, o)
	}
	function o(v) {
		if (v.keyCode && v.keyCode == 9) {
			if (b && v.data.constrainTabKey) {
				var t = h;
				var s = !v.shiftKey && v.target === t[t.length - 1];
				var q = v.shiftKey && v.target === t[0];
				if (s || q) {
					setTimeout(function() {
						p(q)
					},
					10);
					return false
				}
			}
		}
		var u = v.data;
		if (j(v.target).parents("div." + u.blockMsgClass).length > 0) {
			return true
		}
		return j(v.target).parents().children().filter("div.blockUI").length == 0
	}
	function p(q) {
		if (!h) {
			return
		}
		var s = h[q === true ? h.length - 1 : 0];
		if (s) {
			s.focus()
		}
	}
	function a(z, q, B) {
		var A = z.parentNode,
		w = z.style;
		var u = ((A.offsetWidth - z.offsetWidth) / 2) - n(A, "borderLeftWidth");
		var v = ((A.offsetHeight - z.offsetHeight) / 2) - n(A, "borderTopWidth");
		if (q) {
			w.left = u > 0 ? (u + "px") : "0"
		}
		if (B) {
			w.top = v > 0 ? (v + "px") : "0"
		}
	}
	function n(q, s) {
		return parseInt(j.css(q, s)) || 0
	}
})(jQuery);
SUGAR = function() {
	var g = $.browser.msie,
	f = $.browser.mozilla,
	d = g && $.browser.version === "6.0",
	c = g && $.browser.version === "7.0",
	a = g && $.browser.version === "8.0",
	h = g && $.browser.version === "9.0",
	b = $.browser.opera;
	return {
		PopOut: function() {
			return {
				fnCloseMask: function() {
					this.closeMask()
				},
				pops: [{},
				{}],
				STR: ['<a href="javascript:;" target="_self" class="abtn l" onclick="SUGAR.PopOut.closeMask();"><button type="button"><u>鍏抽棴</u></button></a>', '<a href="javascript:;" target="_self" class="abtn l" onclick="SUGAR.PopOut.closeMask();"><button type="button"><u>鍙栨秷</u></button></a>'],
				cover: function() {
					var i = $("#blockbglay");
					if (!i.length) {
						$('<div id="blockbglay"></div>').appendTo("body")
					}
					i.css("display", "block")
				},
				alert: function(m, j, p) {
					var t = this,
					j = j === "s" ? 0 : j === "m" ? 1 : j === "l" ? 2 : j,
					j = j || 0,
					k = [400, 484, 660],
					i = $("#win-house");
					if (!i.length) {
						i = $('<div id="win-house" class="h0"></div>').appendTo("body")
					}
					if ($.type(m) === "string" || $.type(m) === "number") {
						m = ["", m + ""]
					}
					m[0] = m[0];
					m[1] = m[1] || "";
					var q = $.type(m[1]) === "string",
					o = m[0] === null ? "": $('<div class="tt-s"><span>' + m[0] + '</span><a class="mask-close" target="_self" href="javascript:;" onclick="SUGAR.PopOut.closeMask();">鍏抽棴</a></div>'),
					s = $('<div class="mask-body"></div>').css("width", k[j]).appendTo(i);
					s.append(o).append($('<div class="mask-cont"></div>').append(m[1]));
					var l = s.outerHeight();
					if (q) {
						s.remove();
						s = '<div class="mask-body">' + s.html() + "</div>"
					}
					$.blockUI({
						message: s,
						baseZ: 9000,
						focusInput: true,
						onUnblock: function() {
							i.find(".mask-cont:empty").closest(".mask-body").remove();
							if ($.isFunction(p)) {
								p()
							}
						},
						css: {
							top: "50%",
							left: "50%",
							textAlign: "left",
							marginLeft: -(k[j] / 2),
							marginTop: -(l / 2) - 20,
							width: k[j],
							height: l,
							border: "none",
							background: "none"
						},
						fadeIn: $(".blockOverlay:visible").length ? 0 : 200
					});
					if (j < 1) {
						t.setOverLay()
					}
				},
				setOverLay: function() {
					if (d) {
						return
					}
					var k = $("div.blockPage"),
					i = k.outerWidth(),
					m = k.outerHeight(),
					l = parseInt(k.css("marginTop")),
					j = parseInt(k.css("marginLeft"));
					$("div.blockOverlay").css({
						width: i + 24,
						height: m + 24,
						top: "50%",
						left: "50%",
						marginTop: l - 12,
						marginLeft: j - 12,
						"border-radius": "8px",
						"-moz-border-radius": "8px",
						"-webkit-border-radius": "8px"
					})
				},
				closePops: function() {
					var k = this,
					l = k.pops,
					i = l.length;
					while (i-->0) {
						$(l[i].dom).css("display", "none")
					}
				},
				closePopN: function(o) {
					var l = this,
					m = l.pops,
					j = m.length,
					k = true;
					if ($.type(o) === "number" && o < m.length) {
						$(m[o].dom).css("display", "none");
						while (j-->0) {
							if ($(m[j].dom).css("display") != "none") {
								k = false
							}
						}
					}
					return k
				},
				setFnCloseMask: function(j) {
					var i = this;
					if (typeof j === "function") {
						i.fnCloseMask = j
					}
				},
				closeMask: function() {
					$.unblockUI()
				},
				unCover: function() {
					$("#blockbglay").css("display", "none")
				},
				jumpOutMask: function() {
					var l = this,
					j = $(document).width(),
					n = $(document).height(),
					m = $("#mask"),
					i = $("#mask-bg"),
					k = $("#mask-fm");
					i.unbind("click");
					$({}).delay(1000).queue(function() {
						i.click(function() {
							l.fnCloseMask()
						})
					});
					if (a || h) {
						j -= 21
					}
					if (m.css("display") === "none") {
						k.css({
							width: j,
							height: n
						});
						i.css({
							height: n
						});
						m.css({
							width: j,
							display: "block"
						})
					}
					$("#mask-tmp").html("")
				}
			}
		} ()
	}
} (); (function(c) {
	var b = c.browser.msie && c.browser.version === "6.0",
	a = c.browser.opera;
	c.fn.sidepop = function(d) {
		var g = {
			_create: function(k, n) {
				var m = n.id,
				j = k.$pop;
				var l = ["none", "none", "none"];
				if (n.btnset == 1) {
					l[2] = ""
				} else {
					if (n.btnset == 2) {
						l[0] = ""
					} else {
						if (n.btnset == 3) {
							l[2] = "";
							l[0] = ""
						}
					}
				}
				k.$bar = c(n.btnset ? ['<div class="', n.btnClass.bars, '" ', n.seat ? "": 'style="display:none;"', '><a  class="', n.btnClass.min, '" style="display:', l[0], '" href="javascript:;" target="_self">-</a><a class="', n.btnClass.max, '" style="display:', l[1], '" href="javascript:;" target="_self">+</a><a class="', n.btnClass.close, '" style="display:', l[2], '" href="javascript:;" target="_self">X</a></div>'].join("") : "");
				if (n.seat) {
					k.$dom = c('<div class="' + m + '"></div>').append(k.$bar).append(c('<div class="' + n.btnClass.cont + '"></div>').append(j.clone(true, true)));
					k.$wrap = c("<div>").append(k.$dom);
					j.replaceWith(k.$wrap)
				} else {
					k.$dom = c('<div class="' + m + '"></div>').append(k.$bar).append(c('<div class="' + n.btnClass.cont + '"></div>').append(j)).appendTo(n.position)
				}
			},
			_feature: function(q, p) {
				var m = q.$pop,
				t = q.$dom,
				k = c(window),
				l = k.width(),
				j = k.height(),
				n = k.scrollTop();
				q.size = [p.width === null ? t.find("." + p.btnClass.cont).outerWidth() : p.width, p.height === null ? t.find("." + p.btnClass.cont).outerHeight() : p.height];
				var s = "absolute";
				if (p.seat) {
					s = "relative";
					var o = t.offset();
					q.inittop = o.top;
					q.initleft = o.left;
					q.$wrap.css({
						width: p.width,
						height: p.height
					})
				} else {
					if (!b && p.isFixed == 1) {
						s = "fixed"
					}
				}
				t.css({
					position: s,
					bottom: "auto",
					zIndex: p.zIndex,
					width: q.size[0],
					height: q.size[1]
				});
				q.bias = p.bias === "middle" ? (j - q.size[1]) / 2 : p.bias;
				q.departure = p.departure === "center" ? (l - q.size[0]) / 2 : p.departure;
				if (b && p.baseline == "bottom" || a && p.baseline == "bottom") {
					q.bias -= 2
				}
				t.css({
					left: p.dockSide === "right" ? "auto": q.departure,
					right: p.dockSide === "left" ? "auto": q.departure
				});
				if (p.baseline == "bottom") {
					if (!p.seat && !b && p.isFixed == 1) {
						t.css({
							top: "auto",
							bottom: q.bias
						})
					}
				} else {
					if (p.baseline == "top") {
						if (!p.seat && !b && p.isFixed == 1) {
							t.css({
								bottom: "auto",
								top: q.bias
							})
						}
					}
				}
			},
			_bindBars: function(j, m) {
				var l = j.$bar,
				k = m.btnClass;
				l.delegate("a", "click",
				function(n) {
					var o = c(this);
					if (o.hasClass(k.close)) {
						g.close(j, m)
					} else {
						if (o.hasClass(k.show)) {
							g.show(j, m)
						} else {
							if (o.hasClass(k.min)) {
								g.min(j, m)
							} else {
								if (o.hasClass(k.max)) {
									g.max(j, m)
								}
							}
						}
					}
				})
			},
			_scrollAnim: function(j, k) {
				if (k.scroll === 2) {
					j.$dom.stop().css({
						opacity: 0,
						top: g._getTop(j, k)[0]
					}).animate({
						opacity: 1
					},
					k.fadeSpeed,
					function() {
						j.$bar.css("display", "block")
					})
				} else {
					j.$dom.animate({
						top: g._getTop(j, k)[0]
					},
					k.floatSpeed,
					function() {
						j.$bar.css("display", "block")
					})
				}
			},
			_eventScroll: function(k) {
				var j = k.data.props,
				l = k.data.c;
				if (l.scroll === 2) {
					j.$dom.not(":animated").css({
						opacity: 0
					})
				}
				if (c.isFunction(l.withScroll)) {
					l.withScroll()
				}
				window.clearTimeout(j.scrollTimer);
				j.scrollTimer = window.setTimeout(function() {
					g._scrollAnim(j, l)
				},
				l.scrollDelayTime)
			},
			_scrollSeatAnim: function(l, m) {
				var j = l.$dom,
				k = g._getTop(l, m);
				if (!l.$wrap.find(":first-child").length) {
					l.$wrap.append(j)
				}
				if (k[0] < l.inittop) {
					j.css({
						position: "relative",
						top: 0,
						left: 0
					})
				} else {
					if (m.seatrange && k[0] > l.inittop + m.seatrange - k[2]) {
						j.css({
							position: "relative",
							top: m.seatrange - k[2],
							left: 0
						})
					} else {
						if (!b && m.isFixed == 1) {
							j.css({
								position: "fixed",
								top: k[0] - k[1],
								left: l.initleft
							})
						} else {
							j.appendTo(m.position).css({
								position: "absolute",
								top: k[0],
								left: l.initleft
							})
						}
					}
				}
			},
			_eventScrollSeat: function(k) {
				var j = k.data.props,
				l = k.data.c;
				if (c.isFunction(l.withScroll)) {
					l.withScroll()
				}
				g._scrollSeatAnim(j, l)
			},
			_bindScroll: function(j, k) {
				if (!k.seat && !b && k.isFixed == 1 || k.scroll === 0) {
					j.$bar.css("display", "block");
					return
				} else {
					if (k.seat) {
						j.$bar.css("display", "block");
						c(window).scroll({
							props: j,
							c: k
						},
						g._eventScrollSeat);
						g._scrollSeatAnim(j, k)
					} else {
						c(window).scroll({
							props: j,
							c: k
						},
						g._eventScroll);
						g._scrollAnim(j, k)
					}
				}
			},
			_unbindScroll: function() {
				c(window).unbind("scroll", g._eventScroll)
			},
			_getTop: function(o, n) {
				var p = o.bias,
				s = o.$dom,
				q = s.outerHeight(true),
				l = c(window).width(),
				j = c(window).height(),
				m = c(window).scrollTop(),
				k = q + p - j;
				k = k < 0 ? 0 : k;
				switch (n.baseline) {
				case "top":
					return [m + p - k, m, q];
				case "bottom":
					return [m + j - q - p + k, m, q]
				}
			},
			close: function(l, n) {
				var j = l.$dom,
				m = n.btnClass;
				j.css("display", "none");
				g._unbindScroll(l, n);
				var k = m.close;
				c("." + k, j).removeClass(k).addClass(m.show);
				if (c.isFunction(n.fnAfterClose)) {
					n.fnAfterClose.call(g, l, n)
				}
			},
			show: function(l, n) {
				var j = l.$dom,
				m = n.btnClass;
				j.css("display", "block");
				g._bindScroll(l, n);
				var k = m.show;
				c("." + k, j).removeClass(k).addClass(m.close)
			},
			min: function(l, o) {
				var k = l.$dom,
				m = o.btnClass,
				n = o.expandDir === "left-right",
				j = n ? {
					width: o.remainArea
				}: {
					height: o.remainArea
				};
				if (!n && o.baseline === "bottom") {
					j.marginTop = l.size[1] - o.remainArea
				}
				k.animate(j,
				function() {
					c("." + m.min, k).css("display", "none");
					c("." + m.max, k).css("display", "inline")
				})
			},
			max: function(l, o) {
				var k = l.$dom,
				m = o.btnClass,
				n = o.expandDir === "left-right",
				j = n ? {
					width: l.size[0]
				}: {
					height: l.size[1]
				};
				if (!n && o.baseline === "bottom") {
					j.marginTop = 0
				}
				k.animate(j,
				function() {
					c("." + m.min, k).css("display", "inline");
					c("." + m.max, k).css("display", "none")
				})
			},
			_noop: c.noop
		};
		var i = c.extend(true, {},
		c.fn.sidepop.defaults, d);
		var f = c(this),
		h = {};
		if (!f.length) {
			return
		}
		h.$pop = f;
		g._create(h, i);
		g._feature(h, i);
		g._bindBars(h, i);
		g._bindScroll(h, i);
		if (c.isFunction(i.fnInitExe)) {
			i.fnInitExe.call(g, h, i)
		}
		return this
	};
	c.fn.sidepop.defaults = {
		id: "",
		position: "body",
		width: null,
		height: null,
		remainArea: 25,
		initTop: null,
		btnClass: {
			min: "SG-sidemin",
			max: "SG-sidemax",
			close: "SG-sideclose",
			show: "SG-sideshow",
			bars: "SG-sidebar",
			cont: "SG-sidecont"
		},
		btnset: 1,
		scroll: 2,
		fnInitExe: null,
		fnAfterClose: null,
		dockSide: "left",
		departure: 0,
		baseline: "bottom",
		seat: false,
		seatrange: null,
		withScroll: null,
		isFixed: 0,
		bias: 100,
		expandDir: "top-down",
		floatSpeed: 150,
		fadeSpeed: 250,
		scrollDelayTime: 350,
		zIndex: 1000
	}
})(jQuery); (function(b) {
	var a = 1;
	b.fn.tippop = function(c) {
		var d = {
			_create: function(h, j) {
				var i = j.id,
				g = h.$pop;
				h.$dom = b('<div class="' + i + ' SG-tippop"></div>').append(b('<div class="pr"><u></u></div>')).append(g).appendTo("body");
				h.size = [j.width, j.height];
				a = Math.max(a, j.zIndex);
				h.$dom.css({
					position: "absolute",
					bottom: "auto",
					zIndex: j.zIndex,
					width: h.size[0],
					height: h.size[1],
					display: "none"
				})
			},
			_bind: function(j, k) {
				var g = j.$dom,
				h = b(k.triger),
				i = k.delegateSelector;
				b(".SG-close", g).click(function(l) {
					l.preventDefault();
					d.close(j)
				});
				b(".SG-close-e", g).click(function(l) {
					l.preventDefault();
					d.close(j);
					h.unbind(k.eventType);
					g.remove()
				});
				g.bind("mouseenter",
				function(l) {
					clearTimeout(g.data("timer"));
					g.css({
						zIndex: ++a
					})
				}).bind("mouseleave",
				function(l) {
					g.data("timer", setTimeout(function() {
						d.close(j)
					},
					k.holdon))
				});
				if (i === null) {
					h.bind(k.eventType,
					function(l) {
						d._show.call(this, j, k)
					}).bind("mouseleave",
					function() {
						g.mouseleave()
					})
				} else {
					h.delegate(i, k.eventType,
					function(l) {
						d._show.call(this, j, k)
					}).delegate(i, "mouseleave",
					function() {
						g.mouseleave()
					})
				}
			},
			close: function(g, h) {
				g.$dom.css("display", "none")
			},
			_show: function(s, p) {
				var l = s.$pop,
				v = s.$dom,
				i = v.outerWidth(),
				u = v.outerHeight(),
				g = b(document).width(),
				q = b(document).height(),
				o = this === d || p.triger0 ? b(p.triger) : b(this),
				t = o.offset(),
				m = o.outerWidth(),
				h = o.outerHeight(),
				j;
				clearTimeout(v.data("timer"));
				s.offset = [t.left + p.biasX, t.top + p.biasY];
				var n = s.offset[0],
				k = s.offset[1];
				s.offset[0] = n + i > g ? g - i - 20 : n;
				s.offset[1] = k + u > q ? q - u - 20 : k;
				v.css({
					left: s.offset[0],
					top: s.offset[1],
					zIndex: ++a,
					display: "block"
				})
			},
			_noop: b.noop
		};
		var f = b.extend(true, {},
		b.fn.tippop.defaults, c);
		return this.each(function() {
			var g = b(this),
			h = {};
			if (!g.data("tippop")) {
				h.$pop = g;
				d._create(h, f);
				d._bind(h, f);
				if (f.loadShow) {
					d._show(h, f)
				}
				if (b.isFunction(f.fnInitExe)) {
					f.fnInitExe.call(d, h, f)
				}
				g.data("tippop", true)
			}
		}).closest("." + f.id)
	};
	b.fn.tippop.defaults = {
		id: "",
		triger: null,
		triger0: false,
		eventType: "mouseover",
		holdon: 1000,
		delegateSelector: null,
		width: "auto",
		height: "auto",
		biasX: 0,
		biasY: 0,
		loadShow: false,
		fnInitExe: null,
		zIndex: 3000
	}
})(jQuery); (function() {
	$.SGAlert = $.SGAlert || {};
	$.SGAlert.show = function(c, g, i, d) {
		var i = i || ".mask-body:visible";
		var a = $(i);
		var d = d || {
			visibility: "hidden",
			position: "absolute",
			zIndex: 999999999,
			width: "auto",
			padding: "4px 12px",
			margin: "4px 0 0",
			lineHeight: "21px",
			fontSize: "12px",
			background: "#4c4c4c",
			borderRadius: "4px",
			color: "#fff"
		};
		if (!a.length) {
			a = $("body")
		}
		var j = parseInt(a.css("width")) || a.outerWidth();
		var b = a.find(".SGAlert-holder");
		if (!b.length) {
			b = $('<div class="SGAlert-holder"></div>').appendTo(a)
		}
		b.css(d).html(c);
		window.clearTimeout(b.data("timer"));
		var k = b.outerWidth(),
		f = b.outerHeight(true),
		h = 200;
		b.css({
			top: -f,
			visibility: "visible",
			left: (j - k) / 2
		}).animate({
			top: 0,
			opacity: 1
		},
		h);
		if (g && g > 0) {
			b.data("timer", window.setTimeout(function() {
				b.animate({
					top: -f,
					opacity: 0
				},
				h,
				function() {
					b.css("visibility", "hidden")
				})
			},
			g))
		}
	};
	$.SGAlert.clean = function() {
		$(".SGAlert-holder").remove()
	}
})();
function setIptFocus(a) {
	function b(d) {
		var c = d.target;
		c.style.color = "#333";
		c.value = "";
		$(a).unbind("focus", arguments.callee)
	}
	$(a).focus(b)
}
function setLabelIptFocus(c, b) {
	function a() {
		if ($.trim($(c).val()) !== "") {
			clearTimeout($(b).data("timer"));
			$(b).css("display", "none")
		} else {
			$(b).data("timer", setTimeout(function() {
				$(b).css("display", "block")
			},
			150))
		}
	}
	$(c).bind("blur",
	function(d) {
		a()
	}).bind("focus click",
	function() {
		clearTimeout($(b).data("timer"));
		$(b).css("display", "none")
	});
	a()
}
function resetTags(a, j) {
	var h = $("a", a),
	g = [];
	for (var d = 0; d < h.length && d < 12; d++) {
		var b = $.trim(h[d].innerHTML);
		g.push(b)
	}
	var c = $(j).val(),
	f = false;
	h.each(function(m, o) {
		var l = $(o),
		k = $.trim(l.text()),
		n = $.inArray(k, g) != -1;
		if ((" " + c + " ").match(new RegExp("\\s" + k + "\\s", "ig"))) {
			$(o).addClass("added");
			if (!f && n) {
				f = true
			}
		} else {
			$(o).removeClass("added")
		}
	});
	if (f) {
		h.each(function(m, o) {
			var l = $(o),
			k = $.trim(l.text()),
			n = $.inArray(k, g) != -1;
			if (f && n) {
				$(o).addClass("added")
			}
		})
	}
}
function tagSelectBind(a, b, c) {
	$(a).delegate("a", "click",
	function(m) {
		m.preventDefault();
		m.stopPropagation();
		var k = $(this),
		h = $.trim(k.text()),
		n = k.parent().find("a"),
		d = [];
		for (var g = 0; g < n.length && g < 12; g++) {
			var p = $.trim(n[g].innerHTML);
			d.push(p)
		}
		if (!k.hasClass("added")) {
			var f = $(b),
			q = $.trim(f.val()),
			o = $.trim(q.replace(/,/ig, " ").replace(/\s{2,}/ig, " ")),
			j = o.split(" "),
			l = j.length;
			if (l >= c) {
				alert("鏈€澶氬彧鑳芥坊鍔 " + c + "涓爣绛惧摝");
				return false
			}
			f.focus();
			f.val(f.val() + (q == "" || q.charAt(q.length - 1) == " " ? k.text() + " ": " " + k.text() + " "));
			k.addClass("added")
		}
		if ($.inArray(h, d) != -1) {
			n.each(function(s, u) {
				var t = $(u);
				if ($.inArray($.trim(t.text()), d) != -1) {
					t.addClass("added")
				}
			})
		}
	});
	$(b).keyup(function(i) {
		i.stopPropagation();
		var g = $.trim(this.value),
		h = $.trim(g.replace(/,/ig, " ").replace(/\s{2,}/ig, " ")),
		f = h.split(" "),
		d = f.length;
		if (d > c) {
			this.value = g.replace(/([ ,])+?[^ ,]*$/ig,
			function(k, j) {
				return j
			});
			i.preventDefault();
			return false
		}
		resetTags(a, this)
	})
}
function setTagsHTML(b, a) {
	var c = [];
	if ($.isArray(a)) {
		$(a).each(function(f, d) {
			if (d !== "|") {
				c.push('<a href="#"><i>' + d + "</i></a>")
			}
		});
		$(b).find("a").remove();
		$(b).append(c.slice(0, 20).join(""))
	}
}
function setDefaultTags(p) {
	var l = $("a", p),
	g = $.Bom.getSubCookie("sgm", "usedtags"),
	m = g ? g.split(";") : [],
	o = l.length,
	h = o > 12 ? 12 : o,
	a;
	var b = [];
	for (var f = 0; f < h; f++) {
		var n = $.trim($(l[f]).text());
		b.push(n)
	}
	b.push("|");
	for (var d = 0,
	c = m.length; d < c; d++) {
		if ($.inArray(m[d], b) === -1) {
			b.push(m[d])
		}
	}
	if (o > 12) {
		for (var f = 12; f < o; f++) {
			var n = $.trim($(l[f]).text());
			if (b.length < 21 && $.inArray(n, b) === -1) {
				b.push(n)
			}
		}
	}
	$.Bom.setSubCookie("sgm", "usedtags", b.join(";"), {
		expires: 30
	});
	setTagsHTML(p, b)
}
function setUsedTags(c, h) {
	var i = $(h);
	var g = $.trim(i.val());
	if (g) {
		var b = $.trim(g.replace(/\s{2,}/g, " ")).split(" "),
		f = $.Bom.getSubCookie("sgm", "usedtags"),
		a = f.split(";"),
		d = $.inArray("|", a);
		$(b).each(function(k, j) {
			if ($.inArray(j, a) === -1) {
				a = $.grep(a,
				function(l) {
					return l !== j && $.trim(l) !== ""
				});
				a = a.slice(0, d).concat([j], a.slice(d))
			}
		});
		a = a.slice(0, 20);
		$.Bom.setSubCookie("sgm", "usedtags", a.join(";"), {
			expires: 30
		});
		setTagsHTML(c, a)
	}
}
function showSelectTags(a, d, c) {
	var f;
	function g() {
		if ($(a).data("mouselock")) {
			return
		}
		window.clearTimeout(f);
		if ($.isFunction(c)) {
			c(a, d, 1)
		} else {
			$(a).css("display", "block")
		}
	}
	function b() {
		if ($(a).data("mouselock")) {
			return
		}
		window.clearTimeout(f);
		f = window.setTimeout(function() {
			if ($.isFunction(c)) {
				c(a, d)
			} else {
				$(a).css("display", "none")
			}
		},
		200)
	}
	$(d).bind("click focus mouseenter", g).blur(b);
	$(a).bind("mouseenter", g);
	$(a).bind("mouseleave", b)
}
function keyupLenLimitForU(b, x, v, t, k) {
	if (!b || typeof b.value == "undefined") {
		return
	}
	var n = /(?:http(?:s)?:\/\/)(?:(?:[\w-]+\.)+[\w-]+)(?:\:\d+)?(?:\/[\w-\.\/%]*)?(?:[?][\w-\.\/%!*\(\);\:@&=+$,\[\]]*)?(?:#[\w-\.\/%!*\(\);\:@&=+$,\[\]]*)?(?=\s)/g,
	w = [],
	a = [],
	x = x || 300,
	v = !!v,
	k = $(k),
	s = 0,
	q = b.value.replace(n,
	function(j, i, l) {
		w.push(j);
		a.push(i - s);
		s += j.length;
		return ""
	}),
	f,
	m = false;
	if (v) {
		f = x - q.length
	} else {
		f = Math.floor((2 * x - q.lenB()) / 2)
	}
	f -= w.length * 8;
	if (f < 0) {
		if (v && t) {
			q = q.substr(0, x)
		} else {
			if (t) {
				q = q.cut(x * 2, "")
			}
		}
		var d = [];
		for (var h = 0,
		g = 0,
		c = w.length; h < c && h < 8; h++) {
			d.push(q.slice(g, a[h]));
			d.push(w[h]);
			g = a[h]
		}
		d.push(q.slice(g, q.length));
		b.value = d.join("");
		$(b).scrollTop(1000);
		m = true
	}
	k.html(t && f < 0 ? 0 : f);
	return m
}
if (SUGAR && SUGAR.PopOut) {
	var ie = $.browser.msie,
	ie6 = ie && $.browser.version === "6.0",
	ie7 = ie && $.browser.version === "7.0",
	ie8 = ie && $.browser.version === "8.0",
	ie9 = ie && $.browser.version === "9.0";
	$.extend(SUGAR.PopOut, {
		login: function(a) {
			var g = this;
			var h = $("#poplogin"),
			c = $("#win-house"),
			b = a;
			if (!b) {
				b = location.pathname + location.search + location.hash
			}
			h.find("[name=next]").val(b);
			if (!c.length) {
				c = $('<div id="win-house" class="h0"></div>').appendTo("body")
			}
			if (!h.length) {
				h = $('<div id="poplogin" class="win-wraper clr"><div class="login clr"><div class="cont"><form method="POST"  action="/login/?next=' + b + '" method="POST" ><div class="unme cnt-i clr"><label for="username"></label><i>鐢ㄦ埛鍚�/閭</i><input type="text" id="p-username" name="login_name" placeholder="鐢ㄦ埛鍚�/閭" /></div><div class="pswd cnt-i clr"><label for="password"></label><i>瀵嗙爜</i><input type="password" id="p-password" name="pswd" placeholder="瀵嗙爜" /></div><div class="submit clr"><a class="abtn l" href="javascript:;" onmousedown="_gaq.push([\'_trackPageview\', \'/_trc/Login/pop/direct\']);"><button id="loginbtn" type="submit"><u>鐧诲綍</u></button></a><div class="u-chk clr"><input class="chk" type="checkbox" name="remember" id="poplogin-rem" value="璁颁綇鎴�" checked /><label for="poplogin-rem" >璁颁綇鎴�</label><u>|&nbsp;</u><a href="/getpasswd/">蹇樿瀵嗙爜锛�</a></div></div></form><div class="toreg clr"><a href="/reg/" onmousedown="_gaq.push([\'_trackPageview\', \'/_trc/Login/pop/reg\']);">娉ㄥ唽</a></div></div><div class="sites"><p>浣跨敤鍚堜綔缃戠珯璐﹀彿鐧诲綍锛�</p><div class="clr"><a class="qqsite" href="/connect/qq/?next=' + b + '" onmousedown="_gaq.push([\'_trackPageview\', \'/_trc/Login/pop/connect_qq\']);">QQ</a><a class="weibo" href="/connect/sina/?next=' + b + '" onmousedown="_gaq.push([\'_trackPageview\', \'/_trc/Login/pop/connect_sina\']);">鏂版氮寰崥</a><a class="douban" href="/connect/douban/?next=' + b + '" onmousedown="_gaq.push([\'_trackPageview\', \'/_trc/Login/pop/connect_douban\']);">璞嗙摚</a><a class="qqweib" href="/connect/qweibo/?next=' + b + '" onmousedown="_gaq.push([\'_trackPageview\', \'/_trc/Login/pop/connect_qweibo\']);">鑵捐寰崥</a><a class="taobao" href="/connect/taobao/?next=' + b + "\" onmousedown=\"_gaq.push(['_trackPageview', '/_trc/Login/pop/connect_taobao']);\">娣樺疂</a></div></div></div></div>");
				c.append(h)
			}
			var d = $("#p-username, #p-password");
			if (d.length && typeof d.get(0).placeholder == "undefined") {
				var f = $("#poplogin").find("i");
				f.css("display", "block");
				f.click(function(i) {
					$(this).css("display", "none");
					$(this).siblings("input").focus()
				});
				d.focusin(function(i) {
					$(this).siblings("i").css("display", "none")
				});
				d.focusout(function(i) {
					if ($.trim(this.value) == "") {
						$(this).siblings("i").css("display", "block")
					}
				});
				if (ie8) {
					d.keydown(function(i) {
						if (i.keyCode == 13 && $.trim($("#p-username").val()) && $.trim($("#p-password").val())) {
							i.preventDefault();
							i.stopPropagation();
							h.find("form").submit()
						}
					})
				}
			}
			g.alert(["鐧诲綍鍫嗙硸缃�", h, ""], 2);
			$({}).delay(100).queue(function() {
				var i;
				if ((i = $("#p-username")[0])) {
					i.focus()
				}
			})
		},
		loading: function(b) {
			var c = this,
			b = b || "";
			c.closePops();
			c.jumpOutMask();
			var a = document.createElement("div");
			a.className = "mask-pop";
			$(a).css("display", "block");
			a.innerHTML = b;
			$("#mask-tmp")[0].appendChild(a)
		}
	})
}
function mblogTagsInit(h) {
	var c = $(h[0]),
	j = $(h[1]),
	k = $(h[2]),
	l = $(h[3]),
	g = $(h[4]),
	b = $(h[5]),
	a = h[6],
	i,
	d;
	g.lengthLimit();
	var f = {
		tags: {
			user_tags: [],
			def_tags: [],
			used_tags: [],
			added_tags: []
		},
		_init: function() {
			var n = c.find(".added-tag"),
			q;
			for (var p = 0,
			m = n.length,
			o; p < m; p++) {
				o = $.trim($(n[p]).text());
				o && this.tags.user_tags.push(o)
			}
			if ($.fn.comtags) {
				l.append(function() {
					var u = "",
					s = $.fn.comtags.tags;
					for (var t = 0; t < s.length; t++) {
						u += '<a href="#">' + s[t] + "</a>"
					}
					return u
				})
			}
			this._initSysTags();
			this._flashHotTagHtml()
		},
		_initSysTags: function() {
			var s = $.Bom.getSubCookie("sgm", "usedtags"),
			q = s ? s.split(";") : [],
			u = l.find("a"),
			w = u.length,
			o = w >= 12 ? 12 : w,
			m;
			for (var p = 0,
			v; p < o; p++) {
				v = $.trim($(u[p]).text());
				v && this.tags.def_tags.push(v)
			}
			for (var p = 0,
			n = q.length,
			v; p < n; p++) {
				v = $.trim(q[p]);
				if (v && $.inArray(v, this.tags.def_tags) === -1 && v !== "|") {
					this.tags.used_tags.push(v)
				}
			}
			if (w > 12) {
				for (var p = 12,
				v; p < w; p++) {
					v = $.trim($(u[p]).text());
					if (this.tags.used_tags.length > 8) {
						break
					}
					if ($.inArray(v, this.tags.used_tags) === -1) {
						this.tags.used_tags.push(v)
					}
				}
			}
			this._saveToCookie()
		},
		_saveToCookie: function() {
			$.Bom.setSubCookie("sgm", "usedtags", this.tags.def_tags.join(";") + ";|;" + this.tags.used_tags.slice(0, 20).join(";"), {
				expires: 30
			})
		},
		_escapeHTML: function(n) {
			var m = {
				"&": "&amp;",
				"<": "&lt;",
				">": "&gt;",
				'"': "&quot;",
				"'": "&#x27;",
				"/": "&#x2F;"
			};
			return n.replace(/[&<>"'\/]/g,
			function(o) {
				return m[o]
			})
		},
		_flashHotTagHtml: function() {
			var u = this.tags.def_tags,
			m = this.tags.used_tags,
			q = this._getCurTags(),
			v = [],
			s = false;
			for (var p = 0,
			n = q.length,
			w; p < n; p++) {
				w = q[p];
				if ($.inArray(w, u) > -1) {
					s = true;
					break
				}
			}
			for (var p = 0,
			n = u.length,
			w, o; p < n; p++) {
				o = "";
				w = u[p];
				o += '<a class="def-tags';
				if ($.inArray(w, q) > -1) {
					o += " locked"
				}
				if (s) {
					o += " locked"
				}
				o += '" href="javascript:;"><i>' + this._escapeHTML(w) + "</i></a>";
				v.push(o)
			}
			for (var p = 0,
			n = m.length,
			w; p < n; p++) {
				w = m[p];
				if ($.inArray(w, q) > -1) {
					v.push('<a class="user-tags locked" href="javascript:;"><i>' + this._escapeHTML(w) + "</i></a>")
				} else {
					v.push('<a class="user-tags" href="javascript:;"><i>' + this._escapeHTML(w) + "</i></a>")
				}
			}
			l.find("a").remove();
			l.append(v.slice(0, 20).join(""))
		},
		_removeFromSelect: function(m) {
			var o = c.find(".added-tag"),
			q = this.tags.user_tags,
			p = this.tags.added_tags,
			s = this.tags.used_tags,
			n = $.inArray(m, q);
			if (n !== -1) {
				this.tags.user_tags = q.slice(0, n).concat(q.slice(n + 1, q.length))
			}
			n = $.inArray(m, p);
			if (n !== -1) {
				this.tags.added_tags = p.slice(0, n).concat(p.slice(n + 1, p.length));
				tf = false
			}
			this._flashHotTagHtml();
			c.find(".added-tag").each(function(u, t) {
				if ($.trim($(t).text()) === m) {
					$(t).remove()
				}
			});
			c.closest("div").find(".tag-tips").removeClass("red")
		},
		_flashPageCnt: function() {
			if (k.length) {
				var n = this._getCurTags(),
				q = [],
				s;
				for (var p = 0,
				o, m = n.length; p < m; p++) {
					q.push('<a href="' + a + n[p] + '/"><i>' + this._escapeHTML(n[p]) + "</i></a>")
				}
				k.find("a").not("#addnewtag").remove();
				k.prepend(q.join(""))
			}
			g.focus()
		},
		_remove: function(m) {
			if (j.hasClass("form-locked")) {
				return
			}
			j.addClass("form-locked");
			if (!m) {
				m = $.trim(g.prev().text())
			}
			if (!m) {
				return
			}
			if ($.inArray(m, this.tags.user_tags) === -1) {
				this._removeFromSelect(m);
				j.removeClass("form-locked");
				return
			}
			if (j.length) {
				c.find(".abtn").addClass("abtn-no");
				$.ajax({
					url: j.getFormAction(),
					data: j.paramForm(getToken(2)) + "&tags=" + encodeURIComponent(m),
					mysuccess: function(n, o) {
						f._removeFromSelect(m);
						f._flashPageCnt()
					}
				}).always(function() {
					j.removeClass("form-locked");
					c.find(".abtn").removeClass("abtn-no")
				})
			} else {
				j.removeClass("form-locked");
				f._removeFromSelect(m);
				f._flashPageCnt()
			}
		},
		_add: function(s) {
			var p = {},
			o = s.split(" "),
			v = [],
			u = this.tags.user_tags.concat(this.tags.added_tags),
			m;
			g.val("");
			for (var q = 0,
			w, n = o.length; q < n; q++) {
				w = o[q];
				if (u.length >= 5) {
					c.closest("div").find(".tag-tips").addClass("red");
					return
				}
				if (w && $.inArray(w, this.tags.user_tags) === -1 && $.inArray(w, this.tags.added_tags) === -1) {
					u.push(w);
					this.tags.added_tags.push(w);
					g.before('<a class="added-tag" href="javascript:;"><i>' + this._escapeHTML(w) + "</i></a>");
					if ($.inArray(w, this.tags.used_tags) === -1 && $.inArray(w, this.tags.def_tags) === -1) {
						this.tags.used_tags.unshift(w)
					}
				}
			}
			this._flashHotTagHtml();
			this._saveToCookie()
		},
		_checkLength: function() {
			return c.find(".added-tag").length
		},
		_getCurTags: function() {
			return this.tags.user_tags.concat(this.tags.added_tags)
		},
		_beforeSubmit: function() {
			var m = $.trim(g.val());
			if (m.length) {
				this._add(m)
			}
		},
		_afterSubmit: function() {
			this.tags.user_tags = this._getCurTags();
			this.tags.added_tags = []
		}
	};
	b.bind("click",
	function(m) {
		f.tags.added_tags = [];
		l.find(".locked").removeClass("locked")
	});
	l.delegate("a", "click",
	function(n) {
		var o = $(this),
		m = $.trim(o.text());
		if (o.hasClass("locked")) {
			return
		}
		if (f._checkLength() >= 5) {
			c.closest("div").find(".tag-tips").addClass("red");
			return
		}
		if (o.hasClass("def-tags")) {
			l.find(".def-tags").each(function() {
				if (!$(this).hasClass("locked")) {
					$(this).addClass("locked")
				}
			})
		} else {
			o.addClass("locked")
		}
		f._add(m);
		g.focus()
	});
	g.bind("keyup",
	function(o) {
		var p = $(this),
		n = p.val().slice( - 1);
		if (o.keyCode === 32 && n === " " || o.keyCode === 188 && n === ",") {
			var m = p.val(),
			m = m.substr(0, m.length - 1),
			m = m.replace(/,/ig, " ");
			p.val(m);
			m.length && f._add(m)
		}
	});
	g.bind("keydown",
	function(n) {
		var o = $(this),
		m = $.trim(o.val());
		if (n.keyCode === 8 && !m && f._getCurTags().length) {
			f._remove()
		}
	});
	c.click(function(m) {
		g.focus()
	});
	c.delegate("a", "click",
	function(m) {
		f._remove($.trim($(this).text()))
	});
	c.submit(function(p) {
		var m = $(this),
		o = m.find(".abtn"),
		n = o.find("[type=submit]");
		var q;
		f._beforeSubmit();
		q = f.tags.added_tags.join(",");
		if (!q) {
			f._flashPageCnt();
			SUGAR.PopOut.closeMask(0);
			return
		}
		if (o.hasClass(".abtn-no")) {
			return
		}
		o.addClass("abtn-no");
		m.find("input[name=tags]").val(q);
		$.ajax({
			url: m.getFormAction(),
			data: m.paramForm(getToken(2)),
			mysuccess: function(s, t) {
				SUGAR.PopOut.closeMask(0);
				f._flashPageCnt();
				f._afterSubmit()
			}
		}).always(function() {
			o.removeClass("abtn-no")
		})
	});
	f._init()
} (function(a) {
	a.fn.comtags = {
		tags: ["瀹跺眳", "璁捐", "鎻掔敾", "鐢靛奖", "鏃呰", "鎵嬪伐", "濂宠", "鐢疯", "閰嶉グ", "缇庨", "鎽勫奖", "鑹烘湳", "灏侀潰", "鍔ㄦ极", "鎬€鏃�", "琛楁媿", "灏忓", "瀹犵墿", "妞嶇墿", "浜虹墿"]
	}
})(jQuery); (function() {
	$.SGColl = function() {
		var h, k, t, m, w, f, D, p, d, x, b, n, s, j, g, q, A, u, v, c, l, z, o, C = {
			upload: "涓婁紶鍥剧墖",
			fetch: "鎶撳彇缃戦〉鍥剧墖"
		},
		B = [],
		y,
		a = 4000,
		i;
		return {
			type: "upload",
			init: function(G, F) {
				var H = this;
				if (!getUSERID()) {
					SUGAR.PopOut.login();
					return
				}
				if (typeof G !== "function") {
					F = G;
					G = $.noop
				}
				z = G;
				if (F && $.isPlainObject(F)) {
					o = $.extend({},
					F)
				}
				if (o && o.type) {
					H.type = o.type
				}
				if (!H.inited) {
					H.inited = true;
					k = $("#sgcoll-up"),
					h = $("#win-house"),
					i;
					if (!h.length) {
						h = $('<div id="win-house" class="h0"></div>').appendTo("body")
					}
					if (!k.length) {
						var K = '<form id="form-sgcoll-poststatus" action="/people/mblog/add/" method="post" target="_blank"><input type="hidden" id="sgcoll-sourcetitle" name="source_title" value=""/><input type="hidden" id="sgcoll-sourcelink"  name="source_link" value=""/><!-- 鍥剧墖鍖哄煙 --> <div id="sgcoll-pics"></div><div id="sgcoll-panel"><!-- 涓撹緫鍖哄煙 --> <div class="sgcoll-album"><div id="sgcoll-albumsel" class="sgcoll-albumsel"><input id="sgcoll-albumsel-v" type="text" name="album" value="" data-optional="1"/><a class="sgcoll-shw" href="javascript:;">榛樿涓撹緫</a></div></div> <!-- 杈撳叆妗� --> <div class="sgcoll-cxa"><textarea name="content" class="txa" id="sgcoll-txa" data-optional="1"></textarea><span class="sgcoll-wremain dn"><b id="sgcoll-rmn">300</b> 瀛�</span><label for="sgcoll-txa" id="sgcoll-txa-lb">鍐欑偣浠嬬粛锛岃鏇村浜哄枩娆a</label></div> <!-- 鏍囩鍖哄煙 --> <div class="sgcoll-tags-wrp"><div id="sgcoll-tags-add" class="da tag-sel-cnt tag-use-cnt clr"><input id="sgcoll-tags-inp" class="tag-edt-ipt" autocomplete="off" type="text" value="" maxlength="20" /></div><label for="sgcoll-tags-inp" id="sgcoll-tags-lb"><i>&nbsp;</i>娣诲姞閫傚悎鐨勬爣绛撅紝鏂逛究澶у鎵惧埌</label><button class="dn" id="dopost-tags-reset" type="button" /><div class="tag-use-cnt tag-def-cnt da" id="sgcoll-tags-sel"><span id="sgcoll-tags-cls"><span>鍏抽棴</span></span><span class="tag-use-desc">鐑棬鏍囩锛�</span></div></div> <!-- 鍙戝竷鎸夐挳 --> <div id="sgcoll-subarea" class="u-chk clr"><a class="abtn l" href="javascript:;" target="_self"><button id="sgcoll-abtnpost" type="submit"><u>鍙戝竷</u></button></a><input type="checkbox" name="syncpost" class="chk s-sina dn" value="sina" id="sgcoll-sync"><label for="sgcoll-sync" title="鍚屾鍒版柊娴井鍗�" class="s-sina dn" >鍚屾</label><div class="sgcoll-mbsite s-sina dn">鏂版氮</div><div id="sgcoll-poststat"></div></div></div><input id="sgcoll-tags-val" type="hidden" name="tags" value=""/><input type="hidden" name="source" value=""/><input type="hidden" value="" name="" id="sgcoll-imgcont" /><input id="sgcoll-grpid" type="hidden" name="group" value/></form>';
						k = $('<div id="sgcoll-up"><div id="sgcoll-fetch-in" class="dn clr"><div class="sgcoll-dbox"><div class="gray sgcoll-fetch-normal" id="sgcoll-fchk">灏嗗浘鐗囨墍鍦ㄩ〉闈㈢綉鍧€瀹屾暣鍦扮矘璐村埌杩欓噷</div><form id="form-sgcoll-fetchpic" class="sgcoll-fetch-normal" action="/mblog/fetch/" method="post" target="_self"><input type="text" value="http://" autocomplete="off" class="ipt" name="url" id="sgcoll-fipt"><div class="tc"><a target="_self" href="javascript:;" class="abtn dib" id="sgcoll-fchab"><button type="submit"><u>纭畾</u></button></a></div></form><div id="sgcoll-fetching" class="l loading3 dn">姝ｅ湪鎶撳彇<br/><a id="sgcoll-fetch-cancel" class="lkl" href="javascript:;">鍙栨秷</a></div></div><a class="sgcoll-botlnk" href="/about/collectit/" target="_blank">鍚浣犱笉浼氫竴閿彂鍥撅紵</a></div><div id="sgcoll-up-in" class="dn clr"><div id="sgcoll-dropimgcov">鎷栨嫿鍥剧墖鍒拌繖閲屽彲鐩存帴涓婁紶</div><div id="sgcoll-dropimg" class="sgcoll-dbox"><a id="sgcoll-upbtn" href="javascript:;" class="abtn abtn-up dib sgcoll-up-normal"><u><i></i>涓婁紶鍥剧墖</u><form id="form-sgcoll-upic" target="alupifr" enctype="multipart/form-data" method="POST" action="/upload/photo/"><input name="img" hidefocus="true" type="file" /><input type="hidden" name="tid" value=""/><input type="hidden" name="callback" value="$.fn.uploadpic.upPicCallBack"><iframe name="alupifr" src="about:blank" class="dn" scrolling="no" frameborder="0" height="0" width="0"></iframe><input type="hidden" name="type" value="blog"/></form></a><div id="sgcoll-up-mess" class="sgcoll-up-normal">鍥剧墖闇€灏忎簬2M锛涘鏈夋潵婧愶紝璇锋敞鏄�</div><div id="sgcoll-uploading" class="l loading3 dn">姝ｅ湪涓婁紶<br/><a id="sgcoll-up-cancel" class="uploadpic-delthepic lkl" href="javascript:;">鍙栨秷</a></div></div></div><div id="sgcoll-uploaded" class="dn">' + K + "</div></div>").appendTo(h);
						m = $("#form-sgcoll-fetchpic"),
						w = $("#sgcoll-fipt"),
						f = $("#sgcoll-pics"),
						D = $("#sgcoll-uploaded"),
						p = $("#sgcoll-txa"),
						d = $("#sgcoll-txa-lb"),
						x = $("#sgcoll-imgcont"),
						b = $("#sgcoll-tags-add"),
						n = $("#sgcoll-tags-val"),
						s = $("#sgcoll-tags-inp"),
						j = $("#sgcoll-tags-lb"),
						g = $("#sgcoll-tags-sel"),
						q = $("#sgcoll-tags-cls").find("span"),
						A = $("#dopost-tags-reset"),
						u = $("#sgcoll-albumsel"),
						v = $("#sgcoll-subarea"),
						c = $("#form-sgcoll-poststatus"),
						l = $("#sgcoll-abtnpost"),
						i;
						if (typeof BIND_SITES == "undefined" || !BIND_SITES.sina) {
							v.find(".s-sina").remove()
						} else {
							v.find(".s-sina").removeClass("dn")
						}
						H.resetType(H.type, true);
						var E = !!($.browser.webkit && navigator.userAgent.toString().match("Chrome"));
						if (E && window.File && window.FileList) {
							var J = $("#sgcoll-dropimg,#sgcoll-dropimgcov");
							J.bind("dragenter",
							function(M) {
								if (M.originalEvent.dataTransfer.types.toString() === "Files") {
									window.clearTimeout(J.data("timer"));
									J.css("backgroundPosition", "0 -300px");
									$("#sgcoll-dropimgcov").css("display", "block")
								}
							}).bind("dragleave",
							function(M) {
								window.clearTimeout(J.data("timer"));
								J.eq(0).data("timer", window.setTimeout(function() {
									J.css("backgroundPosition", "0 0");
									$("#sgcoll-dropimgcov").css("display", "none")
								},
								100))
							}).bind("dragover",
							function(M) {
								M.preventDefault();
								M.stopPropagation();
								window.clearTimeout(J.data("timer"))
							}).bind("drop",
							function(O) {
								O.preventDefault();
								O.stopPropagation();
								$("#sgcoll-dropimgcov").css("display", "none");
								var N = O.originalEvent.dataTransfer.files;
								if (N.length) {
									var M = $("#form-sgcoll-upic input[type=file]").get(0);
									M.files = N
								}
							})
						}
						m.submit(function(M) {
							M.preventDefault();
							$.SGColl.doFetchPic()
						});
						$("#sgcoll-fetch-cancel").click(function(M) {
							M.preventDefault();
							$.SGColl.resetFetch()
						});
						w.focus(function(N) {
							var M = this;
							if ($.browser.webkit) {
								setTimeout(function() {
									M.select()
								},
								10)
							} else {
								M.select()
							}
						});
						$("#sgcoll-upbtn").uploadpic(function(M, O, N) {
							if (M.success) {
								_gaq.push(["_trackPageview", "/_trc/Post/_/uppicok"]);
								$.SGColl.resetPost();
								f.html('<img id="sgcoll-upimg" data-iid="' + M.picid + '" src="' + dtImageTrans(M.src, true, 120, 120, "c") + '" />');
								x.val(M.picid);
								$("#sgcoll-up-in").addClass("dn");
								$.SGColl.repop()
							} else {
								$.SGAlert.show(M.message, a);
								$.SGColl.resetFile();
								$("#sgcoll-upbtn,#sgcoll-up-mess").removeClass("dn")
							}
						},
						{
							onupload: function() {
								_gaq.push(["_trackPageview", "/_trc/Post/_/uppicsubmit"]);
								$.SGAlert.clean()
							},
							sel_holder: "#sgcoll-up",
							sel_form: "#form-sgcoll-upic",
							sel_normal: ".sgcoll-up-normal",
							sel_uploading: "#sgcoll-uploading",
							sel_uploaded: "#sgcoll-uploaded"
						});
						$("#sgcoll-up-cancel").click(function(M) {
							k.find("input[name=tid]").data("uploadpic-tid", "")
						});
						t = $("#sgcoll-albumsel").find("a").myalbums({
							sel_valueipt: $("#sgcoll-albumsel-v"),
							sel_holder: $("#sgcoll-panel")
						});
						mblogTagsInit(["#sgcoll-tags-add", null, null, "#sgcoll-tags-sel", "#sgcoll-tags-inp", "#dopost-tags-reset", ""]);
						p.bind("focus click",
						function(M) {
							M.stopPropagation();
							$.SGColl.showLabel(this, "#sgcoll-txa-lb", true)
						}).blur(function() {
							$.SGColl.showLabel(this, "#sgcoll-txa-lb")
						});
						var I = 300;
						function L(M) {
							keyupLenLimitForU(M.currentTarget, I, true, true)
						}
						p.keyup(L).blur(L).focus(L);
						keyupLenLimitForU(p[0], I, true, true);
						p.keydown(function(M) {
							if (M.metaKey && M.which == 13) {
								c.submit()
							}
						});
						p.at({
							isFixed: true,
							upper: true
						});
						s.bind("focus click",
						function(M) {
							M.stopPropagation();
							window.clearTimeout(y);
							$.SGColl.showTagLabel(b, j, true)
						}).blur(function(M) {
							y = window.setTimeout(function() {
								$.SGColl.showTagLabel(b, j)
							},
							100)
						});
						s.bind("focus",
						function(M) {
							if ($.browser.msie && $.browser.version === "6.0") {
								g.css({
									display: "block",
									visibility: "hidden"
								});
								g.css({
									top: -g.outerHeight() + 1,
									bottom: "auto",
									visibility: "visible"
								})
							} else {
								g.css({
									top: "auto",
									bottom: b.outerHeight() - 1,
									display: "block"
								})
							}
						});
						q.add($(document)).click(function() {
							g.css("display", "none")
						});
						b.add(g).click(function(M) {
							M.stopPropagation()
						});
						c.submit(function(M) {
							M.preventDefault();
							$.SGColl.doPost()
						})
					}
				}
				H.resetType(H.type, true);
				H.repop()
			},
			repop: function() {
				SUGAR.PopOut.alert([C[this.type], k, ""], "m");
				if (w.filter(":visible").length) {
					var E = w.val();
					w.focus().val("").val(E).focus()
				}
			},
			checkFetchUrl: function() {
				var E = $.trim(w.val());
				if (!isLink(E)) {
					$.SGAlert.show("璇疯緭鍏ユ纭殑缃戝潃", a);
					return false
				} else {
					var F = E.split("://")[1].split("/")[0];
					if (F.match(/\bduitang\.com/ig)) {
						$.SGAlert.show("浠呮敮鎸佸绔欑綉鍧€锛岀珯鍐呰鐩存帴鏀堕泦", a);
						return false
					}
					return true
				}
			},
			doFetchPic: function() {
				var F = this;
				_gaq.push(["_trackPageview", "/_trc/Post/_/dofetch"]);
				$.SGAlert.clean();
				var E = $.trim(w.val());
				if (!E.match(/^http(?:s)?:\/\//ig)) {
					E = "http://" + E;
					w.val(E)
				}
				if (!F.checkFetchUrl()) {
					return
				}
				w.blur();
				$("#sgcoll-fetching").removeClass("dn");
				$("#sgcoll-fetch-in").find(".sgcoll-fetch-normal").addClass("dn");
				$.ajax({
					url: m.getFormAction(),
					data: m.paramForm(getToken(2)),
					success: function(I) {
						if (!$("#sgcoll-fetch-cancel:visible").length) {
							return
						}
						var H = $.isPlainObject(I) ? I: $.parseJSON(I);
						if (!H) {
							return
						}
						if (H.success && H.data) {
							var J = H.data.images;
							if (J.length) {
								if (!f.data("choose")) {
									f.data("choose", true).delegate(".vm", "click",
									function(K) {
										K.stopPropagation();
										K.preventDefault();
										var L = $(this);
										f.find(".cur").removeClass("cur");
										x.val(L.addClass("cur").find("img").attr("src"))
									})
								}
								F.resetPost();
								$("#sgcoll-sourcelink").val(E);
								$("#sgcoll-sourcetitle").val(H.data.title);
								var G = J.length < 10 ? J.length: 10;
								f.html(['<div class="sgcoll-finfo"><div><span>鏉ユ簮锛�</span>' + H.data.title.cut(60, "鈥�") + "</div><div><span>閾炬帴锛�</span>" + E.cut(60, "鈥�") + '</div></div><div id="sgcoll-picselect" class="sgcoll-picselect" ', (G > 3 ? 'style="overflow-x:scroll;"': ""), '><div class="sgcoll-piclist clr" style="width:', (147 * G - 13), 'px;"><!-- 寰幆鍗曞厓寮€濮� -->', (function() {
									var L = "";
									for (var K = 0; K < G; K++) {
										var M = J[K],
										M = M.charAt(0) === "/" ? "http://" + window.location.hostname + M: M;
										L += '<div class="vm ct l ' + (K === G - 1 ? "last": "") + " " + (K === 0 ? "cur": "") + '"><div class="vma"><div class="vmb"> <img src="' + M + '" /></div></div></div>'
									}
									return L
								})(), "<!-- 寰幆鍗曞厓缁撴潫 --></div></div>", ].join(""));
								$("#sgcoll-picselect").scrollTop(0);
								x.val(f.find("img:first").attr("src"));
								$("#sgcoll-fetch-in").addClass("dn");
								$("#sgcoll-uploaded").removeClass("dn");
								F.repop();
								_gaq.push(["_trackPageview", "/_trc/Post/_/dofetchok"])
							} else {
								F.resetFetch();
								$.SGAlert.show("寰堟姳姝夛紝鏈兘鎶撳彇鍒板悎閫傚浘鐗�", a)
							}
						} else {
							F.resetFetch();
							$.SGAlert.show(mergeServerMessage(H.message), a)
						}
					},
					myerror: function() {
						F.resetFetch();
						$.SGAlert.show("缃戠粶鍑洪棶棰樹簡锛岃绋嶅悗鍐嶈瘯", a)
					}
				})
			},
			doPost: function() {
				var H = this;
				if (!p.val()) {
					blinkIt(function() {
						p.css({
							backgroundColor: "#ffffcc"
						})
					},
					function() {
						p.css({
							backgroundColor: "transparent"
						})
					},
					function() {
						p.focus()
					},
					4, 200);
					return
				}
				if (!x.val()) {
					$.SGAlert.show("娌℃湁鍥剧墖鏃犳硶鍙戝竷鍝�", a)
				}
				var G = l.closest(".abtn");
				if (G.hasClass("abtn-no")) {
					return
				}
				G.addClass("abtn-no");
				$.SGAlert.show("姝ｅ湪鎻愪氦锛岃绋嶅€�");
				if (window.location.pathname.indexOf("/collect/") === 0) {
					_gaq.push(["_trackPageview", "/_trc/Post/_/dopost_outside"])
				} else {
					_gaq.push(["_trackPageview", "/_trc/Post/_/dopost"])
				}
				var F = [],
				E = $.trim(s.val());
				b.find(".added-tag").each(function(J, K) {
					var I = $(K);
					F.push($.trim(I.text()))
				});
				if ($.inArray(E, F) === -1) {
					F.push(E)
				}
				n.val(F.join(" "));
				$.ajax({
					url: c.getFormAction(),
					data: c.paramForm(getToken(2)),
					mysuccess: function(K, L) {
						_gaq.push(["_trackPageview", "/_trc/Post/_/dopostok"]);
						var P = u.find("[name=album]").val(),
						N = u.find(".sgcoll-shw").html(),
						I;
						if (P && P != "0") {
							$.Bom.removeCookie("sgt");
							$.Bom.setSubCookie("sgt", "ai" + getUSERID(), P, {
								expires: 30
							});
							$.Bom.setSubCookie("sgt", "an" + getUSERID(), N, {
								expires: 30
							})
						}
						B.unshift({
							id: K.data.id,
							val: p.val().cut(10, "鈥�")
						});
						B = B.slice(0, 5);
						var Q = P && P != "0" ? "/album/" + P + "/": "/album/people/" + getUSERID() + "/";
						var M = H.type === "upload" ? "缁х画涓婁紶": "缁х画鎶撳彇";
						var J = '<div id="sgcoll-over"><div class="prompt prompt-success"><h3>鏀堕泦鎴愬姛锛�<a href="' + Q + '" target="_blank">杩涘叆涓撹緫鏌ョ湅 &gt;</a></h3><p></p></div><div class="sgcoll-over-bot lkl"><span>鎴栵細</span><a id="sgcoll-continue" href="javascript:;">' + M + '</a><span>&nbsp;|&nbsp;</span><a href="/about/collectit/" target="_blank">浣跨敤鍫嗙硸鏀堕泦宸ュ叿</a></div></div>';
						SUGAR.PopOut.alert([C[H.type], J, ""], "m");
						$("#sgcoll-continue").click(function(R) {
							H.resetType(H.type, true);
							H.repop()
						});
						if ($.isFunction(z)) {
							z(K)
						} else {
							if ($("#dymcare").length) {
								var O = $.History.getHash();
								if (O != "" && O != "!dym") {
									$.History.setHash("!dym")
								} else {
									$("#dymcare").click()
								}
							}
						}
					},
					myfailure: function(I, K) {
						var J = mergeServerMessage(I.message);
						_gaq.push(["_trackPageview", "/_trc/Post/_/" + J]);
						$.SGAlert.show(J)
					},
					myerror: function() {
						$.SGAlert.show("缃戠粶鍑洪棶棰樹簡锛岃绋嶅悗鍐嶈瘯")
					}
				}).always(function() {
					G.removeClass("abtn-no")
				})
			},
			showLabel: function(H, F, E) {
				var I = $(H),
				G = $(F);
				G.css("display", $.trim(I.val()) !== "" || E ? "none": "block")
			},
			showTagLabel: function(G, F, E) {
				var I = $(G),
				J = I.find("input"),
				H = $(F);
				H.css("display", I.find(".added-tag").length || $.trim(J.val()) || E ? "none": "block")
			},
			resetPost: function() {
				var E = this;
				f.html("");
				p.val("");
				d.css("display", "block");
				b.find(".added-tag").remove();
				n.val("");
				s.val("");
				j.css("display", "block");
				g.find(".locked").removeClass("locked");
				$("#sgcoll-sourcetitle").val("");
				$("#sgcoll-sourcelink").val("");
				if (E.type === "upload") {
					x.attr("name", "photo_id")
				} else {
					if (E.type === "fetch") {
						x.attr("name", "image_src")
					}
				}
				x.val("");
				c.find("[name=source]").attr("value", E.type);
				A.click()
			},
			resetType: function(E, G) {
				var F = this;
				if (E === "upload") {
					F.resetUpload()
				} else {
					if (E === "fetch") {
						F.resetFetch(G)
					}
				}
			},
			resetFetch: function(E) {
				this.type = "fetch";
				$("#sgcoll-up-in,#sgcoll-uploaded,#sgcoll-fetching").addClass("dn");
				$("#sgcoll-fetch-in").removeClass("dn").find(".sgcoll-fetch-normal").removeClass("dn");
				if (E) {
					w.val("http://")
				}
			},
			resetUpload: function() {
				this.type = "upload";
				$("#sgcoll-fetch-in,#sgcoll-uploaded,#sgcoll-uploading").addClass("dn");
				$("#sgcoll-up-in,#sgcoll-upbtn,#sgcoll-up-mess").removeClass("dn abtn-no");
				this.resetFile()
			},
			resetFile: function() {
				var E = $("#form-sgcoll-upic input[type=file]");
				E.after(E.clone(true).val(""));
				E.remove()
			}
		}
	} ()
})();
$(function() {});
$(function() {
	var a = $("#win-house");
	a = a.length ? a: $('<div id="win-house" class="h0"></div>').appendTo("body");
	$("#mynavtools-create,#createalbum-pp,#createalbum").click(function(f) {
		d()
	});
	function d() {
		var f = $("#popcreatealbum");
		if (!f.length) {
			f = $('<div id="popcreatealbum" class="win-wraper popcreatealbum"> <form id="form-popcreatealbum" method="post" action="/album/add/"> <table cellspacing="0" cellpadding="0"> <tr> <td width="60" align="right">涓撹緫鍚�</td> <td><input class="ipt" type="text" name="name" value="" maxlength="40"/></td> <td rowspan="4"> <h6>甯哥敤鏍囩</h6> <div class="usetag da" id="popal-mbaddtagsel"> </div> </td> </tr> <tr> <td align="right">鎻忚堪</td> <td><textarea class="txa" name="desc" maxlength="600" data-optional="1"></textarea></td> </tr> <tr> <td align="right">鏍囩</td> <td> <div class="pr"> <div class="divipt clr"><input id="popal-mbaddtagipt" class="l ipt mr8" autocomplete="off" type="text" name="tags" value=""  maxlength="100" data-optional="1"/></div> <label for="popal-mbaddtagipt" id="popal-mbaddtag-lb">澶氫釜鏍囩鐢ㄧ┖鏍奸殧寮€</label> </div> </td> </tr> <tr> <td>&nbsp;</td> <td><a class="abtn l" href="javascript:;" target="_self"><button type="submit"><u>鍒涘缓</u></button></a></td> </tr> </table> </form> </div>').appendTo(a);
			if ($.fn.comtags) {
				$("#popal-mbaddtagsel").html(function() {
					var j = "",
					g = $.fn.comtags.tags;
					for (var h = 0; h < g.length; h++) {
						j += '<a href="#">' + g[h] + "</a>"
					}
					return j
				})
			}
			tagSelectBind("#popal-mbaddtagsel", "#popal-mbaddtagipt", 5);
			setLabelIptFocus("#popal-mbaddtagipt", "#popal-mbaddtag-lb");
			f.find("[name=name],[name=desc]").lengthLimit();
			$("#form-popcreatealbum").safeSubmit(function(j) {
				if (!getUSERID()) {
					return
				}
				var g = $(this),
				i = g.find("a.abtn"),
				h = i.find("[type=submit]");
				if (i.hasClass("abtn-no")) {
					return
				}
				i.addClass("abtn-no");
				$.ajax({
					url: g.getFormAction(),
					data: g.paramForm(getToken(2)),
					mysuccess: function(k, l) {
						location.href = "/album/" + k.data.id
					},
					myerror: function() {
						this.errormsg()
					}
				}).always(function() {
					i.removeClass("abtn-no")
				})
			})
		}
		f.find("[name=name],[name=desc]").val("");
		SUGAR.PopOut.alert(["鍒涘缓涓撹緫", f, ""], 2)
	}
	var c = null;
	$("#dym-area").delegate("a.delthisalbum", "click",
	function(f) {
		f.preventDefault();
		c = this;
		b()
	});
	$("#albumdelbtn").click(function(f) {
		f.preventDefault();
		c = this;
		b()
	});
	function b() {
		var f = $("#popalbumdel");
		if (!f.length) {
			f = $('<div id="popalbumdel" class="win-wraper popalbumdel"><form id="form-albumdel" method="post" action="/album/delete/"><p class="albumconfirm" >灏嗗垹闄よ涓撹緫浠ュ強鍏朵腑鐨勫浘鐗囥€�</p><div class="album-pop-action clr"><a class="abtn abtn-w4 l" href="javascript:;" target="_self"><button type="submit"><u>纭畾鍒犻櫎</u></button></a></div></form></div>').appendTo(a);
			$("#form-albumdel").delegate(".cancel", "click",
			function(g) {
				SUGAR.PopOut.closeMask(0)
			});
			$("#form-albumdel").safeSubmit(function(i) {
				if (!getUSERID()) {
					return
				}
				var g = $(this),
				h = g.find('button[type="submit"]').closest(".abtn");
				if (h.hasClass("abtn-no")) {
					return
				}
				h.addClass("abtn-no");
				$.ajax({
					cache: false,
					url: g.getFormAction() + c.title + "/",
					data: g.paramForm(getToken(2)),
					mysuccess: function(j) {
						SUGAR.PopOut.alert('<div class="prompt prompt-success"><h3>鍒犻櫎鎴愬姛锛�</h3></div>');
						if ($("#albumdelbtn").length && c.title == $("#albumdelbtn").attr("title")) {
							$({}).delay(1000).queue(function() {
								SUGAR.PopOut.closeMask(0);
								var l = "/people/" + getUSERID() + "/#album",
								k = $("#ppuserlnk");
								if (k.length) {
									l = k.attr("href")
								}
								window.location.href = l
							})
						} else {
							$({}).delay(1000).queue(function() {
								SUGAR.PopOut.closeMask(0)
							});
							$(c).closest("div.dym").remove()
						}
					}
				}).always(function() {
					h.removeClass("abtn-no")
				})
			})
		}
		SUGAR.PopOut.alert(["鍒犻櫎涓撹緫", f, ""])
	}
});
$(function() {
	var c = location.pathname + location.search + location.hash,
	s = "",
	u = $("#forlogin");
	var q = (/ipad/gi).test(navigator.appVersion),
	i;
	if (u.length) {
		s = '<div id="h-m-r" class="h-tip cs-w hd-sa login"><i class="aow"><b>鈼�</b><u>鈼�</u></i><div class="cont clr"><form method="POST"  action="/login/?next=' + c + '" method="POST"><div class="unme cnt-i clr"><label for="nav-username"></label><i>鐢ㄦ埛鍚�/閭</i><input type="text" id="nav-username" name="login_name" placeholder="鐢ㄦ埛鍚�/閭"/></div><div class="pswd cnt-i clr"><label for="nav-password"></label><i>瀵嗙爜</i><input type="password" id="nav-password" name="pswd" placeholder="瀵嗙爜" /></div><div class="submit clr"><a class="abtn l" href="javascript:;" onmousedown="_gaq.push([\'_trackPageview\', \'/_trc/Login/nav/direct\']);"><button id="nav-loginbtn" type="submit"><u>鐧诲綍</u></button></a><div class="u-chk clr"><input class="chk" type="checkbox" name="remember" id="nav-remember" value="璁颁綇鎴�" /><label for="nav-remember">璁颁綇鎴�</label><u>|&nbsp;</u><a href="/getpasswd/">蹇樿瀵嗙爜锛�</a></div></div></form><div class="sites"><p>浣跨敤鍚堜綔缃戠珯璐﹀彿鐧诲綍锛�</p><div class="clr"><a class="weibo" href="/connect/sina/?next=' + c + '">鏂版氮寰崥</a><a class="qqsite" href="/connect/qq/?next=' + c + '">QQ</a><a class="taobao" href="/connect/taobao/?next=' + c + '">娣樺疂</a><a class="qqweib" href="/connect/qweibo/?next=' + c + '">鑵捐寰崥</a><a class="douban" href="/connect/douban/?next=' + c + '">璞嗙摚</a></div></div></div></div>';
		u.before($(s)).remove()
	}
	var p = "";
	var A = $.browser,
	k = !!A.msie && A.version === "6.0",
	B = $("#header"),
	w = $(window);
	if (!B.length) {
		return
	}
	var m, j, n, v;
	m = $("#nbar");
	j = $("#tbar");
	n = $("i", ".cnt-i");
	v = $("#nav-username, #nav-password"); (function() {
		var D;
		$(".apps").hover(function() {
			clearTimeout(D);
			$(this).addClass("hover").find(".apps-pa").removeClass("dn")
		},
		function() {
			var E = $(this);
			clearTimeout(D);
			D = setTimeout(function() {
				E.removeClass("hover").find(".apps-pa").addClass("dn")
			},
			300)
		})
	})();
	$("#prof").delegate("ul", "mouseover mouseout",
	function(G) {
		var F = $(this),
		D = F.closest(".prof"),
		E = F.outerWidth(),
		H;
		if (G.type === "mouseout") {
			clearTimeout(p);
			p = setTimeout(function() {
				D.removeClass("pro-ab")
			},
			200)
		} else {
			if (G.type === "mouseover") {
				clearTimeout(p);
				p = setTimeout(function() {
					D.addClass("pro-ab").css({
						width: E
					})
				},
				100)
			}
		}
	});
	if (v.length && typeof v.get(0).placeholder == "undefined") {
		n.css("display", "block");
		n.click(function(D) {
			$(this).css("display", "none");
			$(this).siblings("input").focus()
		});
		v.focusin(function(D) {
			$(this).siblings("i").css("display", "none")
		});
		v.focusout(function(D) {
			if ($.trim(this.value) == "") {
				$(this).siblings("i").css("display", "block")
			}
		})
	}
	w.scroll(function(F) {
		var E = $(this),
		H = E.scrollTop(),
		D = j.length ? j.offset().top + j.height() : 0,
		G;
		if (!D || k) {
			return
		}
		if (H < D) {
			m.css({
				position: "relative"
			})
		} else {
			m.css({
				position: "fixed"
			})
		}
	});
	m.headBarPop({
		targets: ".m",
		per: "#h-",
		events: "mouseenter mouseleave",
		height: 44
	});
	if (getUSERID()) {
		j.headBarPop({
			targets: ".hd-com",
			per: "#hd-",
			events: "mouseenter mouseleave",
			width: 15,
			height: 32
		})
	}
	if (!getUSERID()) {
		j.headBarPop({
			targets: "#m-r",
			per: "#h-",
			events: "click",
			height: 28,
			width: -25,
			center: 0,
			arrleft: 152
		})
	}
	var g = $("#navsch"),
	y = !!window.location.pathname.match(/^\/(shopping|blogs\/category)/ig),
	o = g.find("input[name=kw]"),
	d = g.find("input[name=type]"),
	f = g.find("button[type=submit]"),
	x = $('<div class="srchsel srchsel-0"></div>').appendTo(g.find(".srch")),
	C = "srchsel",
	t = "srchtyp",
	z = [{
		name: "鍐呭",
		type: "feed"
	},
	{
		name: "鍟嗗搧",
		type: "item"
	},
	{
		name: "涓撹緫",
		type: "album"
	},
	{
		name: "绯栧弸",
		type: "people"
	}],
	b,
	i;
	l(y ? 1 : 0);
	g.submit(function() {
		if (o.val() == "鍐呭 / 鍟嗗搧 / 涓撹緫 / 绯栧弸" || $.trim(o.val()) == "") {
			return false
		}
		_gaq.push(["_trackPageview", "/_trc/Search/nav/total"])
	});
	if (o.length && typeof o.get(0).placeholder == "undefined") {
		var h = $(".search i");
		h.css("display", "block").click(function(D) {
			h.css("display", "none");
			o.focus()
		});
		o.focusin(function(D) {
			h.css("display", "none")
		}).focusout(function(D) {
			if ($.trim(this.value) == "") {
				h.css("display", "block")
			}
		})
	}
	function l(E) {
		if (z[E].type == "item") {
			d.attr("value", "feed");
			var D = $("#navsch-onlypd");
			if (!D.length) {
				D = $('<input id="navsch-onlypd" type="hidden" name="fq" value="1"/>')
			}
			g.append(D)
		} else {
			d.attr("value", z[E].type);
			$("#navsch-onlypd").remove()
		}
		x.addClass(function(F, G) {
			this.className = C + " " + C + "-" + E;
			return ""
		})
	}
	o.bind("keyup click",
	function() {
		var E = this,
		D = $.trim(E.value);
		i;
		if (!D) {
			return
		}
		var F = (function() {
			for (var H = 0,
			G = z.length,
			I = ""; H < G; H++) {
				I += '<div class="' + t + " " + t + "-" + H + '">鎼滅储鍚� <span class="red">' + D.cut(16, "鈥�") + "</span> 鐨�" + z[H].name + "</div>"
			}
			return I
		})();
		$(".srch").addClass("srch-nobd");
		x.html(F).show()
	}).bind("blur",
	function() {
		$(".srch").removeClass("srch-nobd");
		b = window.setTimeout(function() {
			x.hide()
		},
		500)
	}).bind("focus",
	function() {
		$(".srch").addClass("srch-nobd")
	});
	x.click(function(D) {
		window.clearTimeout(b)
	});
	x.delegate("." + t, "click",
	function(E) {
		E.preventDefault();
		var D = this;
		nm = getNum(D.className);
		l(nm);
		_gaq.push(["_trackPageview", "/_trc/Search/nav/select_click_type" + nm]);
		f.click()
	});
	x.delegate("." + t, "mouseover",
	function(E) {
		var D = this;
		nm = getNum(D.className);
		l(nm)
	});
	$(document).bind("keydown",
	function(G) {
		if (x.css("display") != "none") {
			var I = G.keyCode,
			D = getNum(x.attr("class")),
			F = z.length,
			H = (D - 1) % F,
			E = (D + 1) % F,
			H = H < 0 ? 0 : H,
			E = E > F ? F: E;
			if (I == 38) {
				l(H)
			} else {
				if (I == 40) {
					l(E)
				}
			}
		}
	});
	if (!getUSERID()) {
		return
	}
	function a() {
		$.ajax({
			type: "GET",
			cache: false,
			url: "/blog/unread/",
			mysuccess: function(H, J) {
				if (!H.data) {
					return
				}
				var K = H.data;
				var F = 0;
				var D = K.new_inbox_msg_count;
				var G, E;
				if (K.stars) {
					F += parseInt(K.stars)
				}
				if (K.comments) {
					F += parseInt(K.comments)
				}
				if (K.followers) {
					F += parseInt(K.followers)
				}
				if (K.notices) {
					F += parseInt(K.notices)
				}
				if (K.mentions) {
					F += parseInt(K.mentions)
				}
				var L = [["news", F, "i", "/blog/unread/clean/", "hd-", "div"], ["msg", D, "i", "/letter/msg/read/?flag=1", "hd-", "div"]];
				for (var I = 0; I < L.length; I++) { (function() {
						var S = L[I][0],
						Q = $("#" + S),
						P = Q.find(L[I][2]),
						M = Q.attr("href"),
						N = "绯荤粺娑堟伅",
						O = L[I][4] + S,
						R = $("#" + O).find(L[I][5]),
						U = parseInt(L[I][1]);
						var T = [];
						if (U) {
							if (S === "news") {
								if (0 && K.new_system_msg_count > 0) {
									M = "/letter/msg/4/list/1/20/";
									T.push('<a href="/letter/msg/4/list/1/20/">鎮ㄦ湁 <b>' + K.new_system_msg_count + "</b> 涓郴缁熸秷鎭�</a>")
								}
								if (K.stars > 0) {
									M = "/star/list/1/20/";
									N = "鏀跺埌鐨勬彁閱�";
									T.push('<a href="/star/list/1/20/">鎮ㄦ敹鍒� <b>' + K.stars + "</b> 涓彁閱�</a>")
								}
								if (K.comments > 0) {
									M = "/comments/list/1/20/";
									N = "鏀跺埌鐨勫洖澶�";
									T.push('<a href="/comments/list/1/20/">鎮ㄦ湁 <b>' + K.comments + "</b> 涓柊鍥炲</a>")
								}
								if (K.followers > 0) {
									M = "/people/" + getUSERID() + "/fans/list/1/20/";
									N = "鏂扮殑绮変笣";
									T.push('<a href="/people/' + getUSERID() + '/fans/list/1/20/">鎮ㄦ湁 <b>' + K.followers + "</b> 涓柊绮変笣</a>")
								}
								if (K.notices > 0) {
									M = "/systemnotice/";
									N = "鏂扮殑閫氱煡";
									T.push('<a href="/systemnotice/">鎮ㄦ湁 <b>' + K.notices + "</b> 涓柊閫氱煡</a>")
								}
								if (K.mentions > 0) {
									M = "/mentions/";
									N = "鏀跺埌鐨凘娑堟伅";
									T.push('<a href="/mentions/">鎮ㄦ湁 <b>' + K.mentions + "</b> 涓狜娑堟伅</a>")
								}
							} else {
								if (S === "msg") {
									N = "鏀跺埌鐨勬柊绉佷俊";
									T.push('<a href="' + M + '">鎮ㄦ湁 <b>' + U + "</b> 鏉℃柊绉佷俊</a>")
								}
							}
							if (T.length > 0) {
								T.push('<p class="h-ln"></p><a class="SG-close-e i-do" data-read=\'{"index":' + I + ',"url":"' + L[I][3] + '"}\' href="javascript:;">鐭ラ亾浜�</a>')
							}
							T = T.join("");
							R.empty().append(T).find(".SG-close-e").click(function() {
								var V = $(this);
								var W = $(this).data("read");
								P.remove();
								R.empty().closest(".h-tip").css("top", -1000);
								Q.removeClass("hover");
								$.ajax({
									type: "GET",
									url: W.url
								}).always(function() {})
							});
							Q.attr("href", M).attr("title", N);
							if (P.length) {
								P.text(U)
							} else {
								P = $("<" + L[I][2] + ">" + U + "</" + L[I][2] + ">").appendTo(Q)
							}
						}
					})()
				}
			}
		})
	}
	if ($("#msg").length || $("#news").length) {
		window.setTimeout(function() {
			a()
		},
		500);
		if (window.location.href.toString().match(/duitang\.com\/myhome/ig)) {
			window.setInterval(a, 20000)
		}
	}
	$("#tool").one("mouseover",
	function() {
		$("#mynavtools-local").click(function(D) {
			$.SGColl.init({
				type: "upload"
			})
		});
		$("#mynavtools-src").click(function(D) {
			$.SGColl.init({
				type: "fetch"
			})
		})
	})
}); (function(a) {
	a.fn.headBarPop = function(d) {
		var h = a.extend({},
		a.fn.headBarPop.defaults, d);
		var j = a(this);
		var c = "",
		i = "";
		var g = -1000;
		var f = 0;
		var b = a.browser.msie && a.browser.version === "6.0";
		if (h.debug) {
			return false
		}
		if (!h.events && h.fixed) {
			setTimeout(function() {
				var k = a(h.per).length ? a(h.per) : a(h.per + j.attr("id"));
				var l = k.find("u");
				k.css({
					top: h.top ? h.top: h.height,
					left: h.left ? h.left: h.width + j.position().left
				});
				if (h.showtime > 0) {
					setTimeout(function() {
						k.css({
							top: g
						})
					},
					h.showtime)
				}
				l.click(function(m) {
					k.remove()
				})
			},
			h.startTime)
		} !! h.events && j.delegate(h.targets, h.events,
		function(z) {
			var n = a(this),
			v = a(h.per).length ? a(h.per) : a(h.per + n.attr("id")),
			o = v.find("div").find(":first-child"),
			q = v.width(),
			w = v.find(".aow"),
			x = Math.abs(parseInt(w.css("top"))),
			u = w.width(),
			k = w.height(),
			C = n.position(),
			t = C.left,
			B = C.top,
			A = n.outerWidth(true),
			m;
			var D = n.attr("id") === "tool";
			var l = h.width ? D ? t - q / 2 + 22 : t - q / 2 + h.width: t - q / 2 + A / 2;
			var s = B + h.height + x + 4;
			var y = function(E) {
				if (!E && c && i) {
					c.css({
						top: g
					});
					i.removeClass("hover")
				}
				c = v;
				i = n;
				if (o.length) {
					clearTimeout(f);
					f = setTimeout(function() { ! E && v.css({
							left: l,
							top: s
						}); ! E && n.addClass("hover");
						v.find("input:first").focus()
					},
					200)
				}
			},
			p = function(E) {
				clearTimeout(f);
				f = setTimeout(function() {
					v.css({
						top: g
					});
					n.removeClass("hover")
				},
				300)
			};
			z.preventDefault();
			z.stopPropagation();
			if (h.events !== "click") {
				v.hover(function(E) {
					y(1)
				},
				function(E) {
					p(1)
				})
			} else {
				if (h.events === "click") {
					a(document).bind("click",
					function(F) {
						var E = a(F.target);
						if (E.closest("#" + v.attr("id")).length === 0 && E.closest("#" + n.attr("id")).length === 0) {
							p(1)
						}
					})
				}
			}
			if (h.center) {
				w.css({
					left: parseInt((v.width() - w.width()) / 2)
				})
			} else {
				w.css({
					left: h.arrleft
				})
			}
			if (z.type === "mouseenter" || z.type === "click") {
				y()
			} else {
				if (z.type === "mouseleave") {
					p()
				}
			}
		})
	};
	a.fn.headBarPop.defaults = {
		targets: "",
		per: "",
		events: "",
		height: 0,
		width: 0,
		center: 1,
		arrleft: 0,
		showtime: 0,
		startTime: 50,
		fixed: 0,
		top: 0,
		left: 0
	}
})(jQuery);
var DUITANG_REF = $.Bom.getCookie("referer");
if (DUITANG_REF == "qzone" || DUITANG_REF == "pengyou") {
	var bgimg = "http://cdn.duitang.com/uploads/people/201205/21/20120521104218_sSG8E.png",
	hidebuyable = "";
	var str_style = '<style type="text/css"> .side-retotop,.outlogin,.side-popreg,#popreg,#hdreglink,#banreglink,#reglink,#popreglink,#folreglink,#mynavlogin,#socialweb,.cmt-reply,.cmt-area .rreply,.sepcmt,.al-mblog-group, .dt-smplogin .popoutlogin,.idxreg .social a,.idxreg .social div,#popreg .part3,.loreg-r,#header .tologin,.blockalbumreply,.dym ._tb,.dym .collbtn,.albumlikebtn,#changenav,#tomyhome,#ppaccor .tomore,.relation,.blockevent,.follow,.unfollow,.mdtbigimg,.mbtobuy,.mbtolook{display:none !important;} #leavmesstoduitang{visibility:hidden} #side-appentr,#side-toapp-wrap{display:none} .realfoot{background-color:#fff} .idxreg .social{background:url(' + bgimg + ") 0 24px no-repeat}" + hidebuyable + "</style>";
	$("head").append(str_style);
	$(function() {
		if (SUGAR) {
			SUGAR.PopOut.login = function() {}
		}
		$(document).delegate(".dym a.x,.dym a.y,.dym a.z,#js-myblog,#likemblog", "mouseover.qzone",
		function(a) {
			a.preventDefault();
			$(this).attr("title", "鍘诲爢绯栫綉鎵嶅彲浠ヤ娇鐢ㄥ叏閮ㄥ姛鑳藉摝~")
		});
		$(document).delegate("a", "click",
		function(a) {
			var b = $(this);
			if (b.hasClass("tarblank")) {
				return
			}
			if (b.attr("href").indexOf("/") > -1) {
				if (typeof(fusion2) != "undefined" && fusion2.canvas) {
					$("#header,#content,#footer,#side-fullfeed").css("display", "none");
					$("body").css({
						background: "url(/img/0/loading.gif) no-repeat center 120px",
						height: 160
					});
					fusion2.canvas.setScroll({
						top: 0
					})
				}
			}
			if (b.attr("target") == "_blank") {
				a.preventDefault();
				window.location.href = $(this).attr("href")
			}
		}).bind("mouseover.qzonetmp",
		function(b) {
			b.preventDefault();
			var a = $("#mbreslnk").css("visibility", "visible");
			if (a.length) {
				a.replaceWith(function() {
					var d = $(this),
					c = $(this).attr("style");
					return '<span style="' + c + '">' + d.html() + "</span>"
				})
			}
			$(document).unbind("mouseover.qzonetmp")
		})
	})
} else {
	if (DUITANG_REF == "qplus" || DUITANG_REF == "360") {
		var bgimg = "http://cdn.duitang.com/uploads/people/201202/23/20120223194050_vHC2A.jpg",
		hidebuyable = "";
		if (DUITANG_REF == "360") {
			bgimg = "http://cdn.duitang.com/uploads/people/201203/19/20120319121648_KnPVi.png";
			hidebuyable = "u._tb,a.mbtobuy,a.mbtolook,.js-favorite-blogtit a{display:none !important;}#mbreslnk{visibility:hidden}"
		}
		var str_style = '<style type="text/css"> .dt-smplogin .popoutlogin,.idxreg .social a,.idxreg .social div,#popreg .part3,.loreg-r{display:none;} .idxreg .social{background:url(' + bgimg + ") 0 24px no-repeat}" + hidebuyable + ".idxreg .social #banreglink{display:none} .idxreg .social .imdreg{display:block} #poplogin .popreg{height:94px;overflow:hidden;margin-top:24px;} #poplogin .popregbtn:link,#poplogin .popregbtn:visited{width:150px;height:50px;margin:12px 10px 0 0;padding:0;overflow:hidden;line-height:48px;background-image:url(../../../../img/0/dtbutton.gif?20120106);background-repeat:no-repeat;background-position:0 -450px;letter-spacing:2px;text-align:center;font-size:24px;color:#fff;text-indent:0;text-align:center;} #poplogin .popregbtn:hover{background-position:0 -510px;color:#fff;text-decoration:none;} #poplogin .poplogin .u-chk{visibility:hidden;} #login-form .u-chk,.dt-login .u-chk{visibility:hidden;}";
		"</style>";
		$("head").append(str_style);
		$(function() {
			if (DUITANG_REF == "qplus") {
				$("#poplogin-rem,#login-rem").replaceWith('<input type="hidden" name="site" value="qq"/>');
				$("#hdreglink,#banreglink,#reglink,#popreglink,#folreglink").attr("href", "/reg/qq/");
				if (SUGAR) {
					SUGAR.PopOut.login = function() {
						window.location.href = "/reg/qq/login/"
					}
				}
			}
			if (DUITANG_REF == "360") {
				$(document).delegate("a[target=_blank]", "click",
				function(a) {
					a.preventDefault();
					window.location.href = $(this).attr("href")
				}).bind("mouseover.c360",
				function(b) {
					b.preventDefault();
					var a = $("#mbreslnk").css("visibility", "visible");
					if (a.length) {
						a.replaceWith(function() {
							var d = $(this),
							c = $(this).attr("style");
							return '<span style="' + c + '">' + d.html() + "</span>"
						})
					}
					$(document).unbind("mouseover.c360")
				})
			}
		})
	}
} (function(c) {
	function a() {
		var g = this,
		f = g.data("albumlike"),
		j = g.siblings("i"),
		d = g.siblings("span"),
		i = g.siblings(".act-i"),
		h;
		f.cancel = 1;
		if (j.length) {
			if (parseInt(j.html()) >= 0) {
				j.html(parseInt(j.html()) + 1 + "浜哄枩娆�")
			}
		}
		if (d.length) {
			if (parseInt(d.html()) >= 0) {
				d.html(parseInt(d.html()) + 1 + "浜哄枩娆�")
			}
		}
		if (i.length) {
			i.find("em").html(parseInt(i.find("em").html()) + 1)
		}
		g.addClass("albumliked").html("<u>鍙栨秷鍠滄</u>")
	}
	function b() {
		var g = this,
		f = g.data("albumlike"),
		j = g.siblings("i"),
		d = g.siblings("span"),
		i = g.siblings(".act-i"),
		h;
		f.cancel = 0;
		if (j.length) {
			if (parseInt(j.html()) >= 0) {
				j.html(parseInt(j.html()) - 1 + "浜哄枩娆�")
			}
		}
		if (d.length >= 1 && parseInt(d.html()) >= 0) {
			g.siblings("span").html(parseInt(g.siblings("span").html()) - 1 + "浜哄枩娆�")
		}
		if (i.length) {
			i.find("em").html(parseInt(i.find("em").html()) - 1)
		}
		if (g.hasClass("act-o")) {
			g.removeClass("albumliked")
		} else {
			g.removeClass("albumliked").addClass("albumtolike").html("<u>鍠滄</u>")
		}
	}
	c.fn.SGalbumlike = function(h, f, g) {
		if (typeof h !== "function") {
			g = f;
			f = h;
			h = c.noop
		}
		if (typeof f !== "string") {
			g = f;
			f = ""
		}
		g = c.extend({},
		g);
		function d(l) {
			l.stopPropagation();
			l.preventDefault();
			if (!getUSERID()) {
				SUGAR.PopOut.login();
				return
			}
			var o = c(this),
			j = o.data("albumlike"),
			n = j.id,
			k = "",
			i = "/unlike/",
			m = "/like/";
			if (o.data("locked")) {
				return
			}
			o.data("locked", 1);
			if (o.data("like")) {
				k = o.data("like").like_id
			}
			if (j.cancel) {
				c.ajax({
					url: i,
					data: "like_id=" + k,
					mysuccess: function(q, p) {
						b.call(o);
						o.removeData("locked")
					},
					myerror: function() {
						this.errormsg()
					}
				}).always(function() {
					o.removeData("locked")
				})
			} else {
				c.ajax({
					url: m,
					data: "object_id=" + n + "&category=0&" + getToken(1),
					mysuccess: function(p, q) {
						o.data("like", {
							like_id: p.data.like_id + ""
						});
						a.call(o)
					},
					myerror: function() {
						this.errormsg()
					}
				}).always(function() {
					o.removeData("locked")
				})
			}
		}
		if (f) {
			this.delegate(f, "click", d)
		} else {
			this.click(d)
		}
		return this
	}
})(jQuery);
$(function() {
	$(document).SGalbumlike(".albumlikebtn", {})
}); (function(a) {
	a.fn.myalbums = function(m, h, j) {
		var i = this;
		if (i.length <= 0) {
			return
		}
		if (typeof m !== "function") {
			j = h;
			h = m;
			m = a.noop
		}
		if (typeof h !== "string") {
			j = h;
			h = ""
		}
		var b = a.extend({},
		a.fn.myalbums.defaults, j),
		p = !!h,
		f = p ? a(h, i) : i,
		k,
		o,
		c,
		g;
		b.fn = m;
		l();
		function d(q) {
			if (!getUSERID()) {
				return
			}
			if (a(b.sel_holder) != a("body")) {
				k.appendTo(b.sel_holder)
			} else {
				k.css({
					position: "absolute",
					zIndex: 30001,
					left: q.left + b.biasleft,
					top: q.top + b.biasleft
				})
			}
			k.css("display", k.css("display") == "block" ? "none": "block");
			if (!i.data("loaded") && a("a", c).length <= 1) {
				c.addClass("loading");
				a.ajax({
					type: "GET",
					url: "/album/collect/list/?count=0",
					mysuccess: function(u, x) {
						c.removeClass("loading");
						var y = u.data.albums,
						t = o.val();
						if (y && y.length) {
							for (var w = 0,
							s = y.length; w < s; w++) {
								if (!y[w].is_default_album) {
									a("<a " + (t == y[w].id ? 'class="cur"': "") + ' href="#" data-albumid="' + y[w].id + '">' + y[w].name.cut(40, "鈥�") + "</a>").appendTo(c)
								}
							}
							if (t == 0) {
								c.find("a").eq(0).addClass("cur")
							}
						}
						i.data("loaded", 1)
					},
					myfailure: function(s, t) {
						c.removeClass("loading")
					}
				})
			} else {
				k.find(".cur").removeClass("cur").end().find("a[data-albumid=" + o.val() + "]").addClass("cur")
			}
		}
		function n(q, s) {
			o.val(q);
			i.html(s);
			c.find(".cur").removeClass("cur").end().find("a[data-albumid=" + q + "]").addClass("cur").prependTo(c);
			c.scrollTop(0);
			k.css("display", "none")
		}
		function l() {
			o = a(b.sel_valueipt);
			if (!o.length) {
				o = a('<input class="dn" type="text" value="">').appendTo(i)
			}
			k = a("#myalbums-wrap");
			if (!k.length) {
				k = a('<div id="myalbums-wrap" style="display:none"><div id="myalbums-albs"><a data-albumid="0" href="javascript:;">榛樿涓撹緫</a></div><div class="clr"><form action="/album/add/" method="post"><input type="text" value="" name="name" class="ipt l" maxlength="40"><a target="_self" href="javascript:;" class="abtn l"><button type="submit"><u>鍒涘缓</u></button></a></form></div></div>').click(function(s) {
					s.stopPropagation()
				}).appendTo("body");
				k.find("input").lengthLimit()
			}
			a(document).click(function(s) {
				k.css("display", "none")
			});
			c = a("#myalbums-albs");
			c.delegate("a", "click",
			function(u) {
				u.preventDefault();
				var t = this.innerHTML,
				s = a(this).data("albumid") || 0;
				n(s, t)
			});
			var q = a.browser.mozilla ? "DOMMouseScroll": "mousewheel";
			if (navigator.userAgent.toString().match(/ipad/ig)) {
				a('<a id="ipadalbumselectordown" class="ipadalbumsel" href="javascript:;"></a>').appendTo(k).click(function(s) {
					c.get(0).scrollTop += 26
				}).bind("dblclick",
				function(s) {
					s.preventDefault();
					s.stopPropagation()
				});
				a('<a id="ipadalbumselectorup" class="ipadalbumsel" href="javascript:;"></a>').appendTo(k).click(function(s) {
					c.get(0).scrollTop -= 26
				}).bind("dblclick",
				function(s) {
					s.preventDefault();
					s.stopPropagation()
				})
			}
			c.bind(q,
			function(s) {
				if (s.wheelDelta) {
					this.scrollTop += -1 * s.wheelDelta
				} else {
					this.scrollTop += s.detail > 0 ? 60 : -60
				}
				s.preventDefault()
			});
			k.find("input").click(function() {
				a(this).focus()
			});
			k.find("form").safeSubmit(function(w) {
				var v = this,
				s = a(v),
				u = s.find(".abtn"),
				t = u.find("[type=submit]");
				if (u.hasClass("abtn-no")) {
					return
				}
				u.addClass("abtn-no");
				a.ajax({
					url: s.getFormAction(),
					data: s.paramForm(getToken(2)),
					mysuccess: function(y, z) {
						var A = s.find("input"),
						x = a.trim(A.val());
						A.val("");
						c.prepend(a('<a href="#" data-albumid="' + y.data.id + '">' + x.cut(40, "鈥�") + "</a>")).scrollTop(0);
						n(y.data.id, x)
					}
				}).always(function() {
					u.removeClass("abtn-no")
				})
			});
			f.bind(b.event,
			function(s) {
				s.stopPropagation();
				s.preventDefault();
				var t = a(this).offset();
				d(t)
			})
		}
		return k
	};
	a.fn.myalbums.defaults = {
		sel_holder: "body",
		sel_valueipt: "",
		event: "click",
		biastop: 0,
		biasleft: 0
	}
})(jQuery); (function(l) {
	var i, k = false,
	d, o, z, a, u, g, f, y = false,
	p = ["鏀堕泦", "鏀堕泦鍒�", "鏀堕泦"],
	n;
	function q(A) {
		SUGAR.PopOut.alert([null, d, ""], 2)
	}
	function m() {
		g.find("a.abtn").addClass("abtn-no");
		g.find(".s-sina").css({
			opacity: 0.5,
			color: "#aaa"
		})
	}
	function s() {
		g.find("a.abtn").removeClass("abtn-no");
		g.find(".s-sina").css({
			opacity: 1,
			color: "#333"
		})
	}
	function c(A, B) {
		u.find("input[name=album]").val(A).end().find("a,span").html(B)
	}
	function j(B, A) {
		f.html(A).attr("class", B)
	}
	function w() {
		o.val("");
		j("", "")
	}
	function x(A, B) {
		blinkIt(function() {
			j("re-postsuc", p[0] + "鎴愬姛锛�")
		},
		null,
		function() {
			SUGAR.PopOut.closeMask();
			l.isFunction(B) && B(A);
			w()
		},
		1, 800);
		var C = l(".collection").find("em");
		if (C.length === 1 && A.blog) {
			C.each(function() {
				C.html(parseInt(C.html()) + 1)
			})
		}
	}
	function t(E, B) {
		if (E) {
			var F = l(i);
			F.addClass("re-done").attr("href", "/people/mblog/" + E + "/detail/").attr("target", "_blank").attr("title", "鍘荤湅鎴戠殑鏀堕泦");
			if (B) {
				var C = F.closest(".dym").find(".d1"),
				A = "",
				D = parseInt(C.text()) || 0;
				C.html(D + 1).addClass("d1-done")
			}
		}
	}
	function v(K, E, B, I, J) {
		y = false;
		p = ["鏀堕泦", "鏀堕泦鍒�", "鏀堕泦"];
		b("/people/mblog/forward/", J, B);
		d.css("display", "block");
		w();
		s();
		var C = K.closest(".js-favorite-blog");
		var F, H = "";
		if (C.length) {
			F = C.find(".js-favorite-blogtit");
			H = F.text()
		} else {
			F = K.closest(".dym").find("div.g");
			H = l("<div>" + F.html() + "</div>").find("a").remove().end().text()
		}
		o.val(l.trim(H));
		l("#re-inp-parent").attr("name", "parent").val(E);
		z.empty().scrollTop(0);
		var D = C.find("img.js-favorite-blogimg"),
		G,
		A;
		if (D.length) {
			G = D.data("width"),
			A = D.data("height")
		} else {
			D = K.closest("div.dym").find("div.mbpho img");
			G = D.outerWidth(),
			A = parseInt(D.attr("height"))
		}
		if (G > 200) {
			A = A * 200 / G,
			G = 200
		}
		$i = l("<img />").attr("src", D.attr("src")).appendTo(z);
		$i.css({
			width: G,
			height: A,
			marginTop: A <= 200 ? (200 - A) / 2 : 0,
			cursor: A <= 200 ? "default": "move"
		});
		l.data(z[0], "imgProp", {
			height: A
		});
		q(K)
	}
	function h(N, E, B, L, M, K, J, G) {
		y = G;
		p = ["缂栬緫", "杞Щ鍒�", "鎻愪氦"];
		b("/blog/edit/", M, B, K, J, G);
		d.css("display", "block");
		w();
		s();
		var C = N.closest(".js-favorite-blog");
		var F, I = "";
		if (C.length) {
			F = C.find(".js-favorite-blogtit");
			I = F.text()
		} else {
			F = N.closest(".dym").find("div.g");
			I = l("<div>" + F.html() + "</div>").find("a").remove().end().text()
		}
		o.val(l.trim(I));
		l("#re-inp-parent").attr("name", "blog").val(E);
		z.empty().scrollTop(0);
		var D = C.find("img.js-favorite-blogimg");
		if (D.length) {
			var A = D.data("height"),
			H = D.data("width"),
			A = A * 200 / H,
			O = l("<img />").attr("src", D.attr("src")).appendTo(z)
		} else {
			D = N.closest("div.dym").find("div.mbpho img");
			var A = parseInt(D.attr("height")),
			O = l("<img />").attr("src", D.attr("src")).appendTo(z)
		}
		O.css({
			width: 200,
			marginTop: A < 200 ? (200 - A) / 2 : 0,
			cursor: A <= 200 ? "default": "move"
		});
		l.data(z[0], "imgProp", {
			height: A
		});
		q(N)
	}
	function b(A, H, B, F, E, C) {
		if (!d || !d.length) {
			d = l('<div id="re-favorite"><form action="' + A + '" target="_self"><div id="re-head"><a id="re-close" target="_self" href="javascript:;" onclick="SUGAR.PopOut.closeMask();">鍏抽棴</a><h1>' + p[0] + '</h1></div><div id="re-cont" class="clr"><div id="re-left" class="l"></div> <div id="re-right" class="r"> <p>' + p[1] + '</p> <div id="re-albumsel"><input class="dn" type="text" data-optional="1" value="0" name="album"><a id="re-albumtrig" href="javascript:;">榛樿涓撹緫</a><span id="re-onlyeditwds"></span></div><textarea name="content"' + (p[0] == "缂栬緫" && (B == getUSERID() || isSTAFF()) ? ' class="txa" ': ' class="txa txa-no" disabled ') + ' data-optional="1" ></textarea> <div id="re-subpan" class="u-chk clr"> <a href="javascript:;" class="abtn l "><button type="submit"><u>' + p[2] + "</u></button></a>" + (typeof BIND_SITES != n && BIND_SITES.sina ? '<input id="re-sycn-sina" type="checkbox" value="sina" class="chk s-sina" name="syncpost" /><label class="s-sina" title="鍚屾鍒版柊娴井鍗�" for="re-sycn-sina">鍚屾</label><div class="re-mbsite s-sina">鏂版氮</div>': "") + '<div id="re-poststat"></div></div></div></div><input id="re-inp-parent" type="hidden" name="parent" value="" data-optional="1" /></form></div>').appendTo("#win-house");
			var G = l.Bom.getSubCookie("sgm", "sync");
			l("#re-sycn-sina").prop("checked", G.indexOf("sina") === -1 ? false: true).change(function() {
				var L = l(this),
				K = L.attr("value");
				G = G.replace(new RegExp("," + K, "ig"), "");
				if (!L.prop("checked") && G.indexOf(K) === -1) {
					l.Bom.setSubCookie("sgm", "sync", G, {
						expires: 365
					})
				} else {
					if (L.prop("checked")) {
						l.Bom.setSubCookie("sgm", "sync", G + "," + K, {
							expires: 365
						})
					}
				}
			});
			f = l("#re-poststat");
			u = d.find("#re-albumsel");
			u.removeClass("re-onlyedit").find("a").myalbums({
				sel_valueipt: u.find("input[name=album]"),
				sel_holder: d
			});
			z = l("#re-left").mousemove(function(O) {
				O.stopPropagation();
				if (l.data(this, "movelock")) {
					return
				}
				var R = l(this),
				N = l.data(this, "imgProp") || {},
				M = N.height;
				if (M > 200) {
					var Q = O.pageY,
					L = z.offset().top,
					K = Q - L - 50,
					K = K < 0 ? 0 : K,
					P;
					l.data(this, "movelock", true);
					R.stop().animate({
						scrollTop: K * (M - 200) * 2 / 200
					},
					50, "linear",
					function() {
						l.data(R[0], "movelock", false)
					})
				}
			});
			o = d.find("textarea.txa");
			function D(K) {
				keyupLenLimitForU(K.currentTarget, 300, true, true)
			}
			o.keyup(D).blur(D).focus(D);
			keyupLenLimitForU(o[0], 300, true, true);
			o.at({
				isFixed: true
			});
			g = d.find("form").safeSubmit(function(O) {
				var L = l(this),
				Q = o.val(),
				K = u.find("input").val(),
				P = l("#re-albumtrig").text(),
				N = L.find("a.abtn"),
				M = N.find("[type=submit]");
				if (N.hasClass("abtn-no")) {
					return
				}
				m();
				j("re-inpost", "姝ｅ湪鎻愪氦锛岃绋嶅€�");
				l.ajax({
					url: L.getFormAction(),
					data: L.paramForm(getToken(2)),
					success: function(S) {
						var R = l.isPlainObject(S) ? S: l.parseJSON(S);
						if (!R || typeof R != "object") {
							j("re-posterr", "鍑虹幇寮傚父锛屽彲鑳芥槸缃戠粶鍘熷洜");
							return
						}
						if (!R.data) {
							R.data = {}
						}
						R.data.content = Q;
						R.data.albumid = K;
						R.data.albumname = P;
						if (R.success) {
							var T = u.find("[name=album]").val(),
							U = u.find("a").html();
							if (!y && T && T != "0") {
								l.Bom.removeCookie("sgt");
								l.Bom.setSubCookie("sgt", "ai" + getUSERID(), T, {
									expires: 30
								});
								l.Bom.setSubCookie("sgt", "an" + getUSERID(), U, {
									expires: 30
								})
							}
							x(R.data, H);
							t(R.data && R.data.blog, 1)
						} else {
							if (R.data && R.data.robot_check) {
								M.verification({
									w: R.data.robot_check
								})
							} else {
								var V = l.trim(mergeServerMessage(R.message));
								j("re-posterr", V);
								s();
								if (V == "浣犲凡缁忔敹闆嗕簡璇ュ垎浜�") {
									t()
								} else {
									s()
								}
							}
						}
					},
					myerror: function() {
						j("re-posterr", "缃戠粶鍘熷洜瀵艰嚧澶辫触锛岃绋嶅€欏啀璇�");
						s()
					}
				}).always(function() {})
			},
			function(K) {
				blinkIt(function() {
					o.css({
						backgroundColor: "#d7ebf7"
					})
				},
				function() {
					o.css({
						backgroundColor: "#fff"
					})
				},
				function() {
					o.focus()
				},
				4, 200)
			})
		}
		if (C) {
			u.addClass("re-onlyedit");
			l("#re-subpan").find("input,label,div.re-mbsite").css("visibility", "hidden")
		} else {
			u.removeClass("re-onlyedit");
			l("#re-subpan").find("input,label,div.re-mbsite").css("visibility", "visible")
		}
		if (typeof F != "undefined") {
			F = F || "";
			E = E || "榛樿涓撹緫";
			c(F, E)
		} else {
			var J = l.Bom.getSubCookie("sgt", "ai" + getUSERID()) || "",
			I = l.Bom.getSubCookie("sgt", "an" + getUSERID()) || "榛樿涓撹緫";
			c(J, I)
		}
		g.attr("action", A);
		d.find("h1").html(p[0]).end().find("#re-right p").eq(0).html(p[1]).end().find(".abtn u").html(p[2])
	}
	l.fn.SGfavorite = function(B) {
		B = B || {};
		var D = B.etype || "click",
		C = B.callback;
		function A(J) {
			if (l(this).hasClass("re-done")) {
				return true
			}
			J.stopPropagation();
			J.preventDefault();
			var I = l(this),
			M = I.data("favorite"),
			M = M ? M: I.closest(".collbtn").data("favorite"),
			H = M ? M.id: 0,
			K = getUSERID(),
			L = M.owner,
			F = M.rooter,
			G;
			i = this;
			if (M.edit == true && (L == K || isSTAFF())) {
				h(I, H, F, L, C, M.belongalbumid, M.belongalbumname, M.onlyedit)
			} else {
				if (L == K) {
					alert("浣犳敹闆嗚繃鐨勶紝涓嶈兘鍐嶆敹闆嗗摝~");
					return
				}
				if (F == K) {
					alert("浣犵涓€娆″彂甯冪殑锛屼笉鑳藉啀鏀堕泦鍝");
					return
				}
				var E = I.parent();
				if (E.hasClass("collbtn")) {
					_gaq.push(["_trackPageview", "/_trc/Repost/waterfall/popstart"])
				}
				v(I, H, F, L, C)
			}
		}
		if (!getUSERID()) {
			if (!this.attr("title")) {
				this.attr("title", "鐧诲綍鎵嶈兘杩涜鎿嶄綔鍝︼紝鐐瑰嚮灏卞彲浠ョ櫥褰曞暒")
			}
			this.live("click",
			function(E) {
				E.stopPropagation();
				E.preventDefault();
				SUGAR.PopOut.login();
				return
			})
		} else {
			this.live(D, A)
		}
		return this
	};
	l.fn.SGcomment = function(C) {
		C = C || {};
		function B(N, H, K, G, I, J, L, M) {
			var F = I.find(".re-comt");
			I.find(".re-comt").stop().clearQueue().animate({
				height: 0
			},
			200).queue(function() {
				reposCol( - 98, J, L, M);
				l.data(G[0], "comment", -1);
				F.find("textarea").blur()
			});
			l.data(G[0], "comment", 0)
		}
		function E(U, V, I, W, R, G, O, J) {
			if (typeof l.data(W[0], "comment") == "undefined") {
				var X = l('<li class="re-comt"><form action="/comment/add/"><div class="pb8"><textarea class="txa" name="content"></textarea></div><a class="abtn l" href="#"><u>璇勮</u></a><input type="hidden" name="_type" value=""/><input type="hidden" value="' + V + '" name="comment_message_id"></form></li>');
				W.after(X);
				X.find("textarea").at({
					pageMembers: R.find("li p a:first-child")
				});
				X.find("a.abtn").click(function(ab) {
					ab.stopPropagation();
					ab.preventDefault();
					var ac = l(this),
					aa = ac.closest("form"),
					Y = aa.find("textarea"),
					Z = l.trim(Y.val());
					if (!Z) {
						alert("璇疯緭鍏ュ唴瀹癸紒");
						return
					}
					if (ac.hasClass("abtn-no")) {
						return
					}
					ac.addClass("abtn-no");
					l.ajax({
						url: "/comment/add/",
						data: aa.paramForm(getToken(2)),
						mysuccess: function(ae, af) {
							var ad = l(['<li><a href="/myhome/" target="_blank"><img src="', ae.data.replyerImg, '" width="24" height="24"></a><p><a href="/myhome/" target="_blank">鎴�</a> ', ae.data.content.replace(/<br\s*\/?>/i, " ").replace(/@[\u2E80-\u9FFF\d\w]{1,20}/ig, ""), "</p></li>"].join(""));
							X.after(ad.css("display", "none"));
							Y.val("");
							ad.slideDown(200,
							function() {
								reposCol(ad.outerHeight(true), G, O, J)
							});
							var ah = ac.closest(".dym").find(".d3"),
							ag = parseInt(ah.text()) || 0;
							ah.html(++ag)
						},
						myerror: function() {
							this.errormsg()
						}
					}).always(function() {
						ac.removeClass("abtn-no")
					})
				})
			}
			var P = l(window),
			N = P.height(),
			H = P.scrollTop(),
			M = R.find(".re-comt"),
			Q = M.offset(),
			K = Q.top,
			L = K + 98 - (N + H);
			if (L > 0) {
				var S = l.browser,
				F = S.webkit,
				T = F ? l("body") : l("html");
				T.animate({
					scrollTop: "+=" + L
				},
				400,
				function() {})
			}
			M.stop().clearQueue().animate({
				height: 98
			},
			200).queue(function() {
				reposCol(98, G, O, J);
				l.data(W[0], "comment", 1);
				M.find("textarea").focus()
			});
			l.data(W[0], "comment", 0)
		}
		function A(J) {
			J.stopPropagation();
			J.preventDefault();
			var H = l(J.target).closest("a"),
			I = H.closest(".dym"),
			F = I.find(".f").last(),
			R = H.closest(".collbtn").data("favorite"),
			R = R ? R: F.data("favorite"),
			P;
			if (!F.length && R && R.id) {
				window.location.href = "/people/mblog/" + R.id + "/detail/#reply";
				return
			} else {
				P = l.data(F[0], "comment")
			}
			if (P === 0) {
				return
			}
			var G = R.id,
			M = R.owner,
			Q = l.data(l("#dym-area")[0], "zindex") || 10,
			P = P == n || P < 0 ? false: true,
			O = I[0].className,
			K = getNum(O.match(/\bsc\d+\b/ig).toString()),
			L = getNum(O.match(/\bco\d+\b/ig).toString()),
			N = parseInt(I.css("top")) || 0;
			I.css("zIndex", ++Q);
			l.data(l("#dym-area")[0], "zindex", Q);
			if (P) {
				B(H, G, M, F, I, K, L, N)
			} else {
				E(H, G, M, F, I, K, L, N)
			}
		}
		var D = "click";
		if (!getUSERID()) {
			this.attr("title", "鐧诲綍鎵嶈兘璇勮锛岀偣鍑讳笅灏卞彲浠ョ櫥褰曞暒");
			this.live("click",
			function(F) {
				F.stopPropagation();
				F.preventDefault();
				SUGAR.PopOut.login();
				return
			})
		} else {
			this.live(D, A)
		}
		return this
	};
	l.fn.SGlike = function(C) {
		C = C || {};
		function E(G, F) {
			if (G.hasClass("no-sub")) {
				return
			}
			G.addClass("no-sub");
			l.ajax({
				url: "/like/",
				data: "object_id=" + F + "&category=1&" + getToken(1),
				mysuccess: function(J, K) {
					G.addClass("re-zan");
					var M = G.closest(".dym").find(".d2"),
					I = G.closest(".action").find("em"),
					H = M.html(),
					L = 0,
					N;
					if (G.data("like")) {
						G.data("like").likeid = J.data.like_id
					} else {
						G.data("like", {
							likeid: J.data.like_id + ""
						})
					}
					if (H) {
						L = parseInt(H) + 1
					} else {
						L = 1
					}
					M.length && M.add(G).html(L).addClass("d2-done");
					if (I.length) {
						I.each(function() {
							l(this).html(parseInt(I.html()) + 1)
						})
					}
				},
				myerror: function() {
					this.errormsg()
				}
			}).always(function() {
				G.removeClass("no-sub")
			})
		}
		function B(G, F) {
			if (G.hasClass("no-sub")) {
				return
			}
			if (G.data("like")) {
				F = G.data("like").likeid
			}
			if (!F) {
				return
			}
			G.addClass("no-sub");
			l.ajax({
				url: "/unlike/",
				data: "like_id=" + F + "&" + getToken(1),
				mysuccess: function(J, K) {
					G.removeClass("re-zan");
					var M = G.closest(".dym").find(".d2"),
					I = G.closest(".action").find("em"),
					H = M.html(),
					L = 0,
					N;
					if (parseInt(H) > 1) {
						L = parseInt(H) - 1
					} else {}
					M.length && M.add(G).html(L).removeClass("d2-done");
					if (I.length) {
						I.each(function() {
							l(this).html(parseInt(I.html()) - 1 < 0 ? 0 : parseInt(I.html()) - 1)
						})
					}
				},
				myerror: function() {
					this.errormsg()
				}
			}).always(function() {
				G.removeClass("no-sub")
			})
		}
		function A(I) {
			I.stopPropagation();
			I.preventDefault();
			var L = l(this),
			G = L.data("favorite"),
			G = G ? G: L.closest(".collbtn").data("favorite"),
			F = G.id,
			K = G.owner,
			H = G.likeid,
			J;
			if (L.hasClass("re-zan")) {
				B(L, H)
			} else {
				E(L, F)
			}
		}
		var D = "click";
		if (!getUSERID()) {
			if (!this.attr("title")) {
				this.attr("title", "鐧诲綍涔嬪悗鎵嶈兘璧炲摝锛�")
			}
			this.live("click",
			function(F) {
				F.stopPropagation();
				F.preventDefault();
				SUGAR.PopOut.login();
				return
			})
		} else {
			this.live(D, A)
		}
	}
})(jQuery);
function callFavOffset(f) {
	if (f.length) {
		var c = f.find("div.pagecont:visible").offset(),
		b = c.top,
		a = c.left,
		d = parseInt(f.css("marginLeft")) || 0;
		f.data("offset", {
			left: a - d,
			top: b
		})
	}
}
function callFavorite() {
	$("div.dym .collbtn .y").SGfavorite();
	$("div.dym .collbtn .x").SGcomment();
	$("div.dym .collbtn .z").SGlike();
	var d = $("#dym-area"),
	c = $(window);
	if (d.length) {
		var f = $.browser.msie,
		b = f && $.browser.version === "6.0",
		a = 70;
		if (b) {
			d.delegate("div.dym", "mousemove",
			function(k) {
				callFavOffset(d);
				var l = $(this),
				i = parseInt(l.css("top")) || 0,
				j = c.scrollTop(),
				h = d.data("offset"),
				g = h.top;
				l.find(".collbtn").css({
					display: "block",
					top: Math.max(j - (g + i) - 8 + a, 8)
				})
			})
		} else {
			d.delegate("div.dym", "mouseenter",
			function(m) {
				callFavOffset(d);
				var n = $(this),
				i = n.find(".collbtn"),
				k = parseInt(n.css("top")) || 0,
				l = c.scrollTop(),
				j = d.data("offset"),
				h = j.top;
				$("#collbtn").css("display", "none").removeAttr("id").addClass("collbtn");
				i.attr("id", "collbtn").addClass("collbtn");
				if (l - (h + k) - 20 + 8 + a > 0) {
					var g = n.offset().left + 18;
					i.css({
						left: g,
						position: "fixed",
						top: 8 + a,
						display: "block"
					})
				} else {
					i.css({
						position: "absolute",
						left: 6,
						top: 8,
						display: "block"
					})
				}
			});
			d.delegate("div.dym", "mousemove",
			function(h) {
				var i = $(this),
				g = i.find(".collbtn");
				if ($("#collbtn")[0] != g[0]) {
					$("#collbtn").css("display", "none").removeAttr("id").addClass("collbtn")
				}
				g.attr("id", "collbtn").addClass("collbtn")
			})
		}
		d.delegate("div.dym", "mouseleave",
		function(g) {
			var h = $(this);
			h.find(".collbtn").css("display", "none").removeAttr("id").addClass("collbtn")
		})
	}
} (function(a) {
	a.fn.SGfollow = function(g, c, f) {
		if (typeof g !== "function") {
			f = c;
			c = g;
			g = a.noop
		}
		if (typeof c !== "string") {
			f = c;
			c = ""
		}
		f = a.extend({},
		f);
		var h = function() {
			var j = this,
			i = j.data("follow");
			if (i.rel > 1) {
				j.addClass("follow followed").removeClass("unfollow followeo")
			} else {
				j.addClass("follow").removeClass("unfollow")
			}
			i.rel += -1
		};
		var d = function() {
			var j = this,
			i = j.data("follow");
			if (i.rel > 1) {
				j.addClass("unfollow followeo").removeClass("follow followed")
			} else {
				j.addClass("unfollow").removeClass("follow")
			}
			i.rel += 1
		};
		var b = function(k) {
			k.preventDefault();
			if (!getUSERID()) {
				SUGAR.PopOut.login();
				return
			}
			var o = a(this),
			j = o.data("follow"),
			n = j.id,
			i = "/people/follow/del/",
			m = "/people/follow/add/",
			l;
			if (o.data("locked")) {
				return
			}
			o.data("locked", 1);
			a.ajax({
				url: j.rel % 2 ? i: m,
				data: "follow_id=" + n + "&" + getToken(),
				mysuccess: function(p, q) {
					j.rel % 2 ? h.call(o) : d.call(o)
				}
			}).always(function() {
				o.removeData("locked")
			})
		};
		if (c) {
			this.delegate(c, "click", b)
		} else {
			this.click(b)
		}
		return this
	}
})(jQuery);
$(function() {
	if (getUSERID()) {
		return
	}
	var a = $.browser.msie && $.browser.version === "6.0",
	f = $.Bom.getSubCookie("sg", "ie6updated"),
	d;
	if (a && !f) {
		var c = $('<div id="pop-ie6update">鎯宠幏寰楁洿濂界殑娴忚浣撻獙锛屽爢绯栧缓璁綘鏇存柊娴忚鍣ㄣ€傛帹鑽愪娇鐢�細<div class="clr ie6browser"><a target="_blank" class="chrome" href="http://www.google.cn/chrome/intl/zh-CN/landing_chrome.html?hl=zh-cn">Chrome</a><a target="_blank" class="jisu360" href="http://chrome.360.cn/">360鏋侀€�</a><a target="_blank" class="ie9" href=" http://view.atdmt.com/action/mrtiex_FY12IE9StaPrdIE8WWpageforXPFNL_1?href=http://view.atdmt.com/action/mrtiex_FY12IE9StaPrdIE8WWpageforXPFNL_1?href=http://download.microsoft.com/download/1/6/1/16174D37-73C1-4F76-A305-902E9D32BAC9/IE8-WindowsXP-x86-CHS.exe">IE8</a><a target="_blank" class="firefox" href="http://firefox.com.cn/download/">Firefox</a></div><div class="tr SG-sidebar mt8"><a href="javascript:;" class="SG-sideclose r graylk">鐭ラ亾浜�</a></div></div>').sidepop({
			id: "side-ie6update",
			dockSide: "left",
			width: "auto",
			scroll: 2,
			departure: -4,
			baseline: "bottom",
			bias: -4,
			isFixed: true,
			zIndex: 800,
			btnset: 0
		}).closest(".side-ie6update");
		c.find(".SG-sideclose").click(function(g) {
			$.Bom.setSubCookie("sg", "ie6updated", 1)
		})
	}
	var b = function() {
		var i = $(window).scrollTop(),
		g = $(window).height(),
		h;
		if (a && !f) {
			c.css("visibility", i > 1000 ? "visible": "hidden")
		}
	};
	$(window).scroll(b);
	b()
}); (function(b) {
	var c, a;
	b.fn.verificationCallBack = function(d) {
		var f = b(window).data("verification", d.code);
		if (c) {
			a.removeClass("abtn-no");
			b("#ver-box").closest("div.side-ver-box").remove();
			c.click();
			f.removeData("verification")
		}
	};
	b.fn.verification = function(g) {
		var i = b(this),
		h = b.extend(true, {},
		b.fn.verification.defaults, g);
		f();
		function f() {
			c = i;
			a = i.attr("tagName") == "a" ? i: i.closest("a");
			d()
		}
		function d() {
			b("#ver-box").closest(".side-ver-box").remove();
			if (h.w == 2) {
				alert("浣犺緭鍏ョ殑鍐呭鍙兘鍚湁鏁忔劅璇嶆垨骞垮憡鍐呭锛岃淇敼鍚庡啀鎻愪氦銆傜敱姝ゅ甫鏉ョ殑涓嶄究鏁璋呰В銆�")
			} else {
				if (h.w) {
					b('<div id="ver-box"><h6>' + h.verstr + '</h6><iframe id="ver-iframe" name="ver-iframe" src="/iframe/verification.html" frameborder="0" scrolling="no"></iframe></div>').sidepop({
						id: "side-ver-box",
						dockSide: "m",
						width: 474,
						height: 213,
						scroll: 2,
						departure: "center",
						baseline: "top",
						bias: "middle",
						isFixed: true,
						zIndex: 9999999,
						btnset: 1
					})
				}
			}
		}
	};
	b.fn.verification.defaults = {
		verstr: "楠岃瘉鍚庢墠鑳界户缁€傝繎鏈熷箍鍛婄寲鐛楋紝璇疯璋�"
	}
})(jQuery);
$(function() {
	var a = parseUrlParams(window.location.search);
	if (a.srcnm == "qq") {
		$({}).delay(3000).queue(function() {
			SUGAR.PopOut.alert('<div class="myhome-followqzone"><h3>鍏虫敞鎴戜滑鐨凲Q绌洪棿</h3><h4>姣忓ぉ涓轰綘鎺ㄨ崘鏈€绮惧崕鐨勫唴瀹�</h4><div class="followiframe"><iframe src="http://open.qzone.qq.com/like?url=http%3A%2F%2Fuser.qzone.qq.com%2F1846053784&type=button&width=300&height=30&style=3" allowtransparency="true" scrolling="no" border="0" frameborder="0"></iframe></div></div>')
		})
	}
}); (function(a) {
	a.fn.at = function(l, d, b) {
		if (!getUSERID() || 1) {
			return this
		}
		var g;
		if (typeof l !== "function") {
			b = d;
			d = l;
			l = a.noop
		}
		if (typeof d !== "string") {
			b = d;
			d = ""
		}
		b = a.extend({},
		a.fn.at.defaults, b);
		function i() {
			g.css({
				display: "block"
			})
		}
		function c() {
			g.css({
				display: "none"
			})
		}
		function j(q, u) {
			var A = q.offset(),
			s = [];
			if (b.position == 0) {
				s = [A.top + q.outerHeight(true), A.left]
			} else {
				if (b.position == 1) {
					var z = q.val().replace(/ /ig, "f"),
					x = g.data("cursor").pos,
					w = z.substr(0, x),
					x = w.lastIndexOf("@") + 1,
					w = z.substr(0, x),
					t = z.slice(x),
					p;
					var y = a("#testdiv");
					if (!y.length) {
						y = a('<div id="testdiv"></div>').css({
							position: "relative",
							width: q.css("width"),
							height: q.css("height"),
							lineHeight: q.css("lineHeight"),
							paddingLeft: q.css("paddingLeft"),
							paddingRight: q.css("paddingRight"),
							paddingTop: q.css("paddingTop"),
							paddingBottom: q.css("paddingBottom"),
							fontSize: q.css("fontSize"),
							fontFamily: q.css("fontFamily")
						}).insertAfter(q)
					}
					y.html((w + '<span id="at-cursor"></span>' + t).replace(/\n/ig, "<br/>"));
					var o = a("#at-cursor").position();
					s = [o.top + q.offset().top + 20, o.left + q.offset().left];
					if (b.upper) {
						s[0] -= 22 + g.outerHeight()
					}
					y.remove()
				}
			}
			return s
		}
		function k(s, p) {
			var o = j(s, p),
			q;
			if (a.browser.msie && a.browser.version === "6.0" || !b.isFixed) {
				g.css({
					position: "absolute",
					top: o[0],
					left: o[1]
				})
			} else {
				g.css({
					position: "fixed",
					top: o[0] - a(window).scrollTop(),
					left: o[1] - a(window).scrollLeft()
				})
			}
		}
		function m(q) {
			var s = g.data("atlist"),
			p = g.data("pglist"),
			u = a.isArray(p),
			o = [],
			t = [],
			v = b.pCounts;
			if (!q && (!p || !p.length)) {
				g.html('<div class="zero">@绯栧弸 TA鑳芥敹鍒颁綘鐨勬秷鎭�</div>');
				return true
			}
			if (u && !q) {
				s = p
			} else {
				if (u) {
					s = s.concat(p)
				}
			}
			if (s && s.length) {
				a(s).each(function(x, z) {
					var y = new RegExp("^" + q, "ig"),
					w = "<li>" + z.name + "</li>";
					if (z.name.match(y) && a.inArray(w, o) === -1) {
						o.push(w)
					} else {
						if (a.inArray(w, o) === -1) {
							t.push(z)
						}
					}
				});
				if (o.length < v) {
					a(t).each(function(x, z) {
						var y = new RegExp("^" + q, "ig");
						var w = z.search_str.split(" ");
						if (w[1] && w[1].match(y)) {
							o.push("<li>" + z.name + "</li>");
							t.splice(x, 1)
						}
					})
				}
				if (o.length < v) {
					a(t).each(function(x, z) {
						var y = new RegExp(q, "ig");
						var w = z.search_str.split(" ");
						if (z.name.match(y) || q.length > 1 && w[0].match(y)) {
							o.push("<li>" + z.name + "</li>")
						}
					})
				}
				if (o.length) {
					o[0] = o[0].replace("<li>", '<li class="cur">');
					g.html('<div>鎯矦璋侊紵<span class="gray f12">(鏈€澶�10娆�)</span></div><ul>' + o.slice(0, v).join("") + "</ul>");
					return true
				}
			}
			return false
		}
		function f(y) {
			var u = a(this).filter("textarea,input");
			if (!u.length) {
				return
			}
			if (!g) {
				n()
			}
			if (y.type == "blur" || y.type == "focusout") {
				g.delay(150).queue(function() {
					c();
					a(this).dequeue()
				});
				g.removeData("pglist");
				return
			}
			if (y.type === "keydown" && g.css("display") !== "none" && y.keyCode === 13) {
				y.preventDefault();
				a("li:first", g).click();
				return
			} else {
				if (y.type === "keydown" && g.css("display") !== "none" && (y.keyCode === 38 || y.keyCode === 40)) {
					y.preventDefault();
					var w = a("li", g),
					x = w.length,
					B = w.index(a(".cur", g).removeClass("cur")),
					E = y.keyCode - 39,
					s;
					B += E;
					B = B < 0 ? 0 : B > x ? x: B;
					g.find("li").eq(B).addClass("cur");
					return
				} else {
					if (y.type === "keydown" && y.keyCode === 8) {
						var t = u.val(),
						z = getCursorPosition(this).end || 0,
						p = t.charAt(z - 1);
						if (p === " ") {
							var C = t.substr(0, z - 1),
							D = C.match(/@[\u4e00-\u9fa5_a-zA-Z0-9-]*$/ig),
							o = D ? D.toString().length: 0;
							if (o && o <= b.nameLen) {
								y.preventDefault();
								u.val(t.slice(0, z - o) + t.slice(z - 1));
								setCursorPosition(this, {
									start: z - o,
									end: z - o
								})
							}
						}
					}
				}
			}
			if (y.type == "keyup" && y.keyCode != 13 && y.keyCode != 38 && y.keyCode != 40 || y.type == "click") {
				var z = getCursorPosition(this).end || 0,
				C = u.val().substr(0, z),
				D = C.match(/@[\u4e00-\u9fa5_a-zA-Z0-9-]*$/ig),
				o = D ? D.toString().length: 0,
				A,
				q;
				if (C.split("@").length > b.aNumber) {
					c();
					return
				}
				g.data("cursor", {
					target: this,
					pos: z
				});
				if (o && o <= b.nameLen) {
					h();
					D = D ? D.toString().substr(1) : "";
					if (m(D)) {
						k(u, y);
						i()
					} else {
						c()
					}
				} else {
					c()
				}
			}
		}
		function h() {
			var p = "",
			o = [];
			if ((p = b.pageMembers) && !g.data("pglist")) {
				a(p).each(function(q, t) {
					var s = a.trim(a(t).text());
					if (a.inArray(s, o) === -1 && s !== "鎴�") {
						o.push(s)
					}
				});
				g.data("pglist", a.map(o,
				function(s, q) {
					return {
						name: s,
						search_str: ""
					}
				}))
			}
		}
		function n() {
			g = a("#PL-at");
			if (!g.length) {
				g = a('<div id="PL-at" class="PL-at"></div>').appendTo("body");
				g.delegate("li", "mouseover",
				function(o) {
					var p = a(this);
					p.parent().find(".cur").removeClass("cur");
					p.addClass("cur")
				});
				g.delegate("li", "click",
				function(u) {
					g.clearQueue();
					var y = g.data("cursor"),
					q = y.target,
					z = q.value,
					x = y.pos,
					o = a(".cur", g).text(),
					w = z.slice(0, x),
					t = z.slice(x),
					s = w.replace(/@[^@]*$/ig, "@" + o + " ") + t,
					A = s.length - t.length,
					p;
					a(q).val(s);
					setCursorPosition(q, {
						start: A,
						end: A
					});
					c()
				})
			}
			if (!a.isArray(g.data("atlist"))) {
				g.data("atlist", []);
				a.ajax({
					type: "GET",
					url: "/mention/complete/",
					mysuccess: function(o, p) {
						g.data("atlist", o.data)
					},
					myfailure: function(o, p) {
						g.removeData("atlist")
					}
				})
			}
		}
		if (d) {
			this.delegate(d, "keydown keyup click blur", f)
		} else {
			this.bind("keydown keyup click blur", f)
		}
		return this
	};
	a.fn.at.defaults = {
		upper: false,
		isFixed: false,
		pCounts: 10,
		nameLen: 20,
		position: 1,
		pageMembers: "",
		aNumber: 10
	}
})(jQuery); (function(a) {
	a.fn.uploadpic = function(l, g, i) {
		var h = this;
		if (h.length <= 0) {
			return
		}
		if (typeof l !== "function") {
			i = g;
			g = l;
			l = a.noop
		}
		if (typeof g !== "string") {
			i = g;
			g = ""
		}
		var b = a.extend({},
		a.fn.uploadpic.defaults, i),
		f;
		b.fn = l;
		k();
		function k() {
			var n = h;
			if (g) {
				h.delegate(g, "mousemove", d).delegate(g + " " + b.sel_input, "change", c)
			} else {
				h.bind("mousemove", d).find(b.sel_input).bind("change", c);
				n = h.closest(b.sel_holder)
			}
			n.delegate("a.uploadpic-delthepic", "click", m);
			h.delegate(g + " " + b.sel_input, "click", j)
		}
		function m(q) {
			var p = a(this),
			o = p.closest(b.sel_holder),
			n = o.find(b.sel_uploading),
			s = o.find(b.sel_uploaded);
			o.find(b.sel_normal).removeClass("dn");
			n.addClass("dn");
			s.addClass("dn");
			s.find("a.uploadpic-thepic").remove();
			o.find("a.abtn-no").removeClass("abtn-no")
		}
		function j(o) {
			if (!getUSERID()) {
				o.preventDefault();
				o.stopPropagation();
				SUGAR.PopOut.login();
				return
			}
			var n = a(this);
			if (n.closest("a").hasClass("abtn-no")) {
				o.preventDefault();
				o.stopPropagation()
			}
		}
		function d(p) {
			var o = a(this),
			n = o.offset();
			o.find(b.sel_input).css({
				left: p.pageX - n.left - 70,
				top: p.pageY - n.top - 10
			})
		}
		function c() {
			var q = a(this),
			o = q.closest(b.sel_form),
			p = a(getToken(3)),
			n = parseInt(Math.random() * 10000000000);
			b.onupload();
			o.find("input[name=tid]").val(n).attr("uploadpic-tid", n).data("uploadpic-config", b).data("uploadpic-callback",
			function(u, s) {
				var w = u.data("uploadpic-config");
				var x = u.closest(w.sel_holder);
				if (s.success) {
					var t = x.find(w.sel_input),
					v = t.val();
					x.find(w.sel_form).closest("a").addClass("abtn-no").end().find("a.uploadpic-thepic").remove();
					var y = x.find(w.sel_uploaded).removeClass("dn").prepend('<a class="uploadpic-thepic graylk" href="' + s.src + '" target="_blank">' + v.substr(v.lastIndexOf("\\") + 1) + "</a>");
					if (!y.find("a.uploadpic-delthepic").length) {
						y.append('<a class="uploadpic-delthepic ml8 mr8" href="javascript:;">x鍒犻櫎</a>')
					}
					x.find(w.sel_input).val("")
				} else {
					x.find(w.sel_error).removeClass("dn").html(mergeServerMessage(s.message)).end().find("a.abtn-no").removeClass("abtn-no")
				}
				x.find(w.sel_uploading).addClass("dn");
				if (a.isFunction(w.fn)) {
					w.fn(s, x, w)
				}
			}).end().append(p).submit();
			p.remove();
			q.closest(b.sel_holder).find(b.sel_normal).addClass("dn").end().find(b.sel_error).addClass("dn").end().find(b.sel_uploaded).addClass("dn").end().find(b.sel_uploading).removeClass("dn");
			o.closest("a").addClass("abtn-no")
		}
		return this
	};
	a.fn.uploadpic.defaults = {
		onupload: a.noop,
		sel_holder: "",
		sel_form: "",
		sel_input: "input[type=file]",
		sel_normal: "",
		sel_error: "",
		sel_uploading: "",
		sel_uploaded: ""
	};
	a.fn.uploadpic.upPicCallBack = function(b) {
		if (a.isPlainObject(b)) {
			var c = a("input[uploadpic-tid=" + b.tid + "]");
			if (c.length && a.isFunction(c.data("uploadpic-callback"))) {
				c.data("uploadpic-callback")(c, b)
			}
		}
	}
})(jQuery);
var _gaq = _gaq || [];
_gaq.push(["_setAccount", "UA-19056403-7"]);
_gaq.push(["_setDomainName", "duitang.com"]);
_gaq.push(["_trackPageview"]); 
(function() {
	var b = document.createElement("script");
	b.type = "text/javascript";
	b.async = true;
	b.src = ("https:" == document.location.protocol ? "https://ssl": "http://www") + ".google-analytics.com/ga.js";
	var a = document.getElementsByTagName("script")[0];
	a.parentNode.insertBefore(b, a)
})();