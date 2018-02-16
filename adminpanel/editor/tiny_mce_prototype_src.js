(function(win) {
	var whiteSpaceRe = /^\s*|\s*$/g,
		undefined;

	var tinymce = {
		majorVersion : '3',

		minorVersion : '3.4',

		releaseDate : '2010-04-27',

		_init : function() {
			var t = this, d = document, na = navigator, ua = na.userAgent, i, nl, n, base, p, v;

			t.isOpera = win.opera && opera.buildNumber;

			t.isWebKit = /WebKit/.test(ua);

			t.isIE = !t.isWebKit && !t.isOpera && (/MSIE/gi).test(ua) && (/Explorer/gi).test(na.appName);

			t.isIE6 = t.isIE && /MSIE [56]/.test(ua);

			t.isGecko = !t.isWebKit && /Gecko/.test(ua);

			t.isMac = ua.indexOf('Mac') != -1;

			t.isAir = /adobeair/i.test(ua);

			t.isIDevice = /(iPad|iPhone)/.test(ua);

			// TinyMCE .NET webcontrol might be setting the values for TinyMCE
			if (win.tinyMCEPreInit) {
				t.suffix = tinyMCEPreInit.suffix;
				t.baseURL = tinyMCEPreInit.base;
				t.query = tinyMCEPreInit.query;
				return;
			}

			// Get suffix and base
			t.suffix = '';

			// If base element found, add that infront of baseURL
			nl = d.getElementsByTagName('base');
			for (i=0; i<nl.length; i++) {
				if (v = nl[i].href) {
					// Host only value like http://site.com or http://site.com:8008
					if (/^https?:\/\/[^\/]+$/.test(v))
						v += '/';

					base = v ? v.match(/.*\//)[0] : ''; // Get only directory
				}
			}

			function getBase(n) {
				if (n.src && /tiny_mce(|_gzip|_jquery|_prototype)(_dev|_src)?.js/.test(n.src)) {
					if (/_(src|dev)\.js/g.test(n.src))
						t.suffix = '_src';

					if ((p = n.src.indexOf('?')) != -1)
						t.query = n.src.substring(p + 1);

					t.baseURL = n.src.substring(0, n.src.lastIndexOf('/'));

					// If path to script is relative and a base href was found add that one infront
					// the src property will always be an absolute one on non IE browsers and IE 8
					// so this logic will basically only be executed on older IE versions
					if (base && t.baseURL.indexOf('://') == -1 && t.baseURL.indexOf('/') !== 0)
						t.baseURL = base + t.baseURL;

					return t.baseURL;
				}

				return null;
			};

			// Check document
			nl = d.getElementsByTagName('script');
			for (i=0; i<nl.length; i++) {
				if (getBase(nl[i]))
					return;
			}

			// Check head
			n = d.getElementsByTagName('head')[0];
			if (n) {
				nl = n.getElementsByTagName('script');
				for (i=0; i<nl.length; i++) {
					if (getBase(nl[i]))
						return;
				}
			}

			return;
		},

		is : function(o, t) {
			if (!t)
				return o !== undefined;

			if (t == 'array' && (o.hasOwnProperty && o instanceof Array))
				return true;

			return typeof(o) == t;
		},

		each : function(o, cb, s) {
			var n, l;

			if (!o)
				return 0;

			s = s || o;

			if (o.length !== undefined) {
				// Indexed arrays, needed for Safari
				for (n=0, l = o.length; n < l; n++) {
					if (cb.call(s, o[n], n, o) === false)
						return 0;
				}
			} else {
				// Hashtables
				for (n in o) {
					if (o.hasOwnProperty(n)) {
						if (cb.call(s, o[n], n, o) === false)
							return 0;
					}
				}
			}

			return 1;
		},


		map : function(a, f) {
			var o = [];

			tinymce.each(a, function(v) {
				o.push(f(v));
			});

			return o;
		},

		grep : function(a, f) {
			var o = [];

			tinymce.each(a, function(v) {
				if (!f || f(v))
					o.push(v);
			});

			return o;
		},

		inArray : function(a, v) {
			var i, l;

			if (a) {
				for (i = 0, l = a.length; i < l; i++) {
					if (a[i] === v)
						return i;
				}
			}

			return -1;
		},

		extend : function(o, e) {
			var i, l, a = arguments;

			for (i = 1, l = a.length; i < l; i++) {
				e = a[i];

				tinymce.each(e, function(v, n) {
					if (v !== undefined)
						o[n] = v;
				});
			}

			return o;
		},


		trim : function(s) {
			return (s ? '' + s : '').replace(whiteSpaceRe, '');
		},

		create : function(s, p) {
			var t = this, sp, ns, cn, scn, c, de = 0;

			// Parse : <prefix> <class>:<super class>
			s = /^((static) )?([\w.]+)(:([\w.]+))?/.exec(s);
			cn = s[3].match(/(^|\.)(\w+)$/i)[2]; // Class name

			// Create namespace for new class
			ns = t.createNS(s[3].replace(/\.\w+$/, ''));

			// Class already exists
			if (ns[cn])
				return;

			// Make pure static class
			if (s[2] == 'static') {
				ns[cn] = p;

				if (this.onCreate)
					this.onCreate(s[2], s[3], ns[cn]);

				return;
			}

			// Create default constructor
			if (!p[cn]) {
				p[cn] = function() {};
				de = 1;
			}

			// Add constructor and methods
			ns[cn] = p[cn];
			t.extend(ns[cn].prototype, p);

			// Extend
			if (s[5]) {
				sp = t.resolve(s[5]).prototype;
				scn = s[5].match(/\.(\w+)$/i)[1]; // Class name

				// Extend constructor
				c = ns[cn];
				if (de) {
					// Add passthrough constructor
					ns[cn] = function() {
						return sp[scn].apply(this, arguments);
					};
				} else {
					// Add inherit constructor
					ns[cn] = function() {
						this.parent = sp[scn];
						return c.apply(this, arguments);
					};
				}
				ns[cn].prototype[cn] = ns[cn];

				// Add super methods
				t.each(sp, function(f, n) {
					ns[cn].prototype[n] = sp[n];
				});

				// Add overridden methods
				t.each(p, function(f, n) {
					// Extend methods if needed
					if (sp[n]) {
						ns[cn].prototype[n] = function() {
							this.parent = sp[n];
							return f.apply(this, arguments);
						};
					} else {
						if (n != cn)
							ns[cn].prototype[n] = f;
					}
				});
			}

			// Add static methods
			t.each(p['static'], function(f, n) {
				ns[cn][n] = f;
			});

			if (this.onCreate)
				this.onCreate(s[2], s[3], ns[cn].prototype);
		},

		walk : function(o, f, n, s) {
			s = s || this;

			if (o) {
				if (n)
					o = o[n];

				tinymce.each(o, function(o, i) {
					if (f.call(s, o, i, n) === false)
						return false;

					tinymce.walk(o, f, n, s);
				});
			}
		},

		createNS : function(n, o) {
			var i, v;

			o = o || win;

			n = n.split('.');
			for (i=0; i<n.length; i++) {
				v = n[i];

				if (!o[v])
					o[v] = {};

				o = o[v];
			}

			return o;
		},

		resolve : function(n, o) {
			var i, l;

			o = o || win;

			n = n.split('.');
			for (i = 0, l = n.length; i < l; i++) {
				o = o[n[i]];

				if (!o)
					break;
			}

			return o;
		},

		addUnload : function(f, s) {
			var t = this;

			f = {func : f, scope : s || this};

			if (!t.unloads) {
				function unload() {
					var li = t.unloads, o, n;

					if (li) {
						// Call unload handlers
						for (n in li) {
							o = li[n];

							if (o && o.func)
								o.func.call(o.scope, 1); // Send in one arg to distinct unload and user destroy
						}

						// Detach unload function
						if (win.detachEvent) {
							win.detachEvent('onbeforeunload', fakeUnload);
							win.detachEvent('onunload', unload);
						} else if (win.removeEventListener)
							win.removeEventListener('unload', unload, false);

						// Destroy references
						t.unloads = o = li = w = unload = 0;

						// Run garbarge collector on IE
						if (win.CollectGarbage)
							CollectGarbage();
					}
				};

				function fakeUnload() {
					var d = document;

					// Is there things still loading, then do some magic
					if (d.readyState == 'interactive') {
						function stop() {
							// Prevent memory leak
							d.detachEvent('onstop', stop);

							// Call unload handler
							if (unload)
								unload();

							d = 0;
						};

						// Fire unload when the currently loading page is stopped
						if (d)
							d.attachEvent('onstop', stop);

						// Remove onstop listener after a while to prevent the unload function
						// to execute if the user presses cancel in an onbeforeunload
						// confirm dialog and then presses the browser stop button
						win.setTimeout(function() {
							if (d)
								d.detachEvent('onstop', stop);
						}, 0);
					}
				};

				// Attach unload handler
				if (win.attachEvent) {
					win.attachEvent('onunload', unload);
					win.attachEvent('onbeforeunload', fakeUnload);
				} else if (win.addEventListener)
					win.addEventListener('unload', unload, false);

				// Setup initial unload handler array
				t.unloads = [f];
			} else
				t.unloads.push(f);

			return f;
		},

		removeUnload : function(f) {
			var u = this.unloads, r = null;

			tinymce.each(u, function(o, i) {
				if (o && o.func == f) {
					u.splice(i, 1);
					r = f;
					return false;
				}
			});

			return r;
		},

		explode : function(s, d) {
			return s ? tinymce.map(s.split(d || ','), tinymce.trim) : s;
		},

		_addVer : function(u) {
			var v;

			if (!this.query)
				return u;

			v = (u.indexOf('?') == -1 ? '?' : '&') + this.query;

			if (u.indexOf('#') == -1)
				return u + v;

			return u.replace('#', v + '#');
		}

		};

	// Initialize the API
	tinymce._init();

	// Expose tinymce namespace to the global namespace (window)
	win.tinymce = win.tinyMCE = tinymce;
})(window);


(function() {
	if (!window.Prototype)
		return alert("Load prototype first!");

	// Patch in core NS functions
	tinymce.extend(tinymce, {
		trim : function(s) {return s ? s.strip() : '';},
		inArray : function(a, v) {return a && a.indexOf ? a.indexOf(v) : -1;}
	});

	// Patch in functions in various clases
	// Add a "#ifndefjquery" statement around each core API function you add below
	var patches = {
		'tinymce.util.JSON' : {
			/*serialize : function(o) {
				return o.toJSON();
			}*/
		},
	};

	// Patch functions after a class is created
	tinymce.onCreate = function(ty, c, p) {
		tinymce.extend(p, patches[c]);
	};
})();


tinymce.create('tinymce.util.Dispatcher', {
	scope : null,
	listeners : null,

	Dispatcher : function(s) {
		this.scope = s || this;
		this.listeners = [];
	},

	add : function(cb, s) {
		this.listeners.push({cb : cb, scope : s || this.scope});

		return cb;
	},

	addToTop : function(cb, s) {
		this.listeners.unshift({cb : cb, scope : s || this.scope});

		return cb;
	},

	remove : function(cb) {
		var l = this.listeners, o = null;

		tinymce.each(l, function(c, i) {
			if (cb == c.cb) {
				o = cb;
				l.splice(i, 1);
				return false;
			}
		});

		return o;
	},

	dispatch : function() {
		var s, a = arguments, i, li = this.listeners, c;

		// Needs to be a real loop since the listener count might change while looping
		// And this is also more efficient
		for (i = 0; i<li.length; i++) {
			c = li[i];
			s = c.cb.apply(c.scope, a);

			if (s === false)
				break;
		}

		return s;
	}

	});

(function() {
	var each = tinymce.each;

	tinymce.create('tinymce.util.URI', {
		URI : function(u, s) {
			var t = this, o, a, b;

			// Trim whitespace
			u = tinymce.trim(u);

			// Default settings
			s = t.settings = s || {};

			// Strange app protocol or local anchor
			if (/^(mailto|tel|news|javascript|about|data):/i.test(u) || /^\s*#/.test(u)) {
				t.source = u;
				return;
			}

			// Absolute path with no host, fake host and protocol
			if (u.indexOf('/') === 0 && u.indexOf('//') !== 0)
				u = (s.base_uri ? s.base_uri.protocol || 'http' : 'http') + '://mce_host' + u;

			// Relative path http:// or protocol relative //path
			if (!/^\w*:?\/\//.test(u))
				u = (s.base_uri.protocol || 'http') + '://mce_host' + t.toAbsPath(s.base_uri.path, u);

			// Parse URL (Credits goes to Steave, http://blog.stevenlevithan.com/archives/parseuri)
			u = u.replace(/@@/g, '(mce_at)'); // Zope 3 workaround, they use @@something
			u = /^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/)?((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/.exec(u);
			each(["source","protocol","authority","userInfo","user","password","host","port","relative","path","directory","file","query","anchor"], function(v, i) {
				var s = u[i];

				// Zope 3 workaround, they use @@something
				if (s)
					s = s.replace(/\(mce_at\)/g, '@@');

				t[v] = s;
			});

			if (b = s.base_uri) {
				if (!t.protocol)
					t.protocol = b.protocol;

				if (!t.userInfo)
					t.userInfo = b.userInfo;

				if (!t.port && t.host == 'mce_host')
					t.port = b.port;

				if (!t.host || t.host == 'mce_host')
					t.host = b.host;

				t.source = '';
			}

			//t.path = t.path || '/';
		},

		setPath : function(p) {
			var t = this;

			p = /^(.*?)\/?(\w+)?$/.exec(p);

			// Update path parts
			t.path = p[0];
			t.directory = p[1];
			t.file = p[2];

			// Rebuild source
			t.source = '';
			t.getURI();
		},

		toRelative : function(u) {
			var t = this, o;

			if (u === "./")
				return u;

			u = new tinymce.util.URI(u, {base_uri : t});

			// Not on same domain/port or protocol
			if ((u.host != 'mce_host' && t.host != u.host && u.host) || t.port != u.port || t.protocol != u.protocol)
				return u.getURI();

			o = t.toRelPath(t.path, u.path);

			// Add query
			if (u.query)
				o += '?' + u.query;

			// Add anchor
			if (u.anchor)
				o += '#' + u.anchor;

			return o;
		},
	
		toAbsolute : function(u, nh) {
			var u = new tinymce.util.URI(u, {base_uri : this});

			return u.getURI(this.host == u.host && this.protocol == u.protocol ? nh : 0);
		},

		toRelPath : function(base, path) {
			var items, bp = 0, out = '', i, l;

			// Split the paths
			base = base.substring(0, base.lastIndexOf('/'));
			base = base.split('/');
			items = path.split('/');

			if (base.length >= items.length) {
				for (i = 0, l = base.length; i < l; i++) {
					if (i >= items.length || base[i] != items[i]) {
						bp = i + 1;
						break;
					}
				}
			}

			if (base.length < items.length) {
				for (i = 0, l = items.length; i < l; i++) {
					if (i >= base.length || base[i] != items[i]) {
						bp = i + 1;
						break;
					}
				}
			}

			if (bp == 1)
				return path;

			for (i = 0, l = base.length - (bp - 1); i < l; i++)
				out += "../";

			for (i = bp - 1, l = items.length; i < l; i++) {
				if (i != bp - 1)
					out += "/" + items[i];
				else
					out += items[i];
			}

			return out;
		},

		toAbsPath : function(base, path) {
			var i, nb = 0, o = [], tr, outPath;

			// Split paths
			tr = /\/$/.test(path) ? '/' : '';
			base = base.split('/');
			path = path.split('/');

			// Remove empty chunks
			each(base, function(k) {
				if (k)
					o.push(k);
			});

			base = o;

			// Merge relURLParts chunks
			for (i = path.length - 1, o = []; i >= 0; i--) {
				// Ignore empty or .
				if (path[i].length == 0 || path[i] == ".")
					continue;

				// Is parent
				if (path[i] == '..') {
					nb++;
					continue;
				}

				// Move up
				if (nb > 0) {
					nb--;
					continue;
				}

				o.push(path[i]);
			}

			i = base.length - nb;

			// If /a/b/c or /
			if (i <= 0)
				outPath = o.reverse().join('/');
			else
				outPath = base.slice(0, i).join('/') + '/' + o.reverse().join('/');

			// Add front / if it's needed
			if (outPath.indexOf('/') !== 0)
				outPath = '/' + outPath;

			// Add traling / if it's needed
			if (tr && outPath.lastIndexOf('/') !== outPath.length - 1)
				outPath += tr;

			return outPath;
		},

		getURI : function(nh) {
			var s, t = this;

			// Rebuild source
			if (!t.source || nh) {
				s = '';

				if (!nh) {
					if (t.protocol)
						s += t.protocol + '://';

					if (t.userInfo)
						s += t.userInfo + '@';

					if (t.host)
						s += t.host;

					if (t.port)
						s += ':' + t.port;
				}

				if (t.path)
					s += t.path;

				if (t.query)
					s += '?' + t.query;

				if (t.anchor)
					s += '#' + t.anchor;

				t.source = s;
			}

			return t.source;
		}
	});
})();

(function() {
	var each = tinymce.each;

	tinymce.create('static tinymce.util.Cookie', {
		getHash : function(n) {
			var v = this.get(n), h;

			if (v) {
				each(v.split('&'), function(v) {
					v = v.split('=');
					h = h || {};
					h[unescape(v[0])] = unescape(v[1]);
				});
			}

			return h;
		},

		setHash : function(n, v, e, p, d, s) {
			var o = '';

			each(v, function(v, k) {
				o += (!o ? '' : '&') + escape(k) + '=' + escape(v);
			});

			this.set(n, o, e, p, d, s);
		},

		get : function(n) {
			var c = document.cookie, e, p = n + "=", b;

			// Strict mode
			if (!c)
				return;

			b = c.indexOf("; " + p);

			if (b == -1) {
				b = c.indexOf(p);

				if (b != 0)
					return null;
			} else
				b += 2;

			e = c.indexOf(";", b);

			if (e == -1)
				e = c.length;

			return unescape(c.substring(b + p.length, e));
		},

		set : function(n, v, e, p, d, s) {
			document.cookie = n + "=" + escape(v) +
				((e) ? "; expires=" + e.toGMTString() : "") +
				((p) ? "; path=" + escape(p) : "") +
				((d) ? "; domain=" + d : "") +
				((s) ? "; secure" : "");
		},

		remove : function(n, p) {
			var d = new Date();

			d.setTime(d.getTime() - 1000);

			this.set(n, '', d, p, d);
		}
	});
})();

tinymce.create('static tinymce.util.JSON', {
	serialize : function(o) {
		var i, v, s = tinymce.util.JSON.serialize, t;

		if (o == null)
			return 'null';

		t = typeof o;

		if (t == 'string') {
			v = '\bb\tt\nn\ff\rr\""\'\'\\\\';

			return '"' + o.replace(/([\u0080-\uFFFF\x00-\x1f\"])/g, function(a, b) {
				i = v.indexOf(b);

				if (i + 1)
					return '\\' + v.charAt(i + 1);

				a = b.charCodeAt().toString(16);

				return '\\u' + '0000'.substring(a.length) + a;
			}) + '"';
		}

		if (t == 'object') {
			if (o.hasOwnProperty && o instanceof Array) {
					for (i=0, v = '['; i<o.length; i++)
						v += (i > 0 ? ',' : '') + s(o[i]);

					return v + ']';
				}

				v = '{';

				for (i in o)
					v += typeof o[i] != 'function' ? (v.length > 1 ? ',"' : '"') + i + '":' + s(o[i]) : '';

				return v + '}';
		}

		return '' + o;
	},

	parse : function(s) {
		try {
			return eval('(' + s + ')');
		} catch (ex) {
			// Ignore
		}
	}

	});

tinymce.create('static tinymce.util.XHR', {
	send : function(o) {
		var x, t, w = window, c = 0;

		// Default settings
		o.scope = o.scope || this;
		o.success_scope = o.success_scope || o.scope;
		o.error_scope = o.error_scope || o.scope;
		o.async = o.async === false ? false : true;
		o.data = o.data || '';

		function get(s) {
			x = 0;

			try {
				x = new ActiveXObject(s);
			} catch (ex) {
			}

			return x;
		};

		x = w.XMLHttpRequest ? new XMLHttpRequest() : get('Microsoft.XMLHTTP') || get('Msxml2.XMLHTTP');

		if (x) {
			if (x.overrideMimeType)
				x.overrideMimeType(o.content_type);

			x.open(o.type || (o.data ? 'POST' : 'GET'), o.url, o.async);

			if (o.content_type)
				x.setRequestHeader('Content-Type', o.content_type);

			x.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

			x.send(o.data);

			function ready() {
				if (!o.async || x.readyState == 4 || c++ > 10000) {
					if (o.success && c < 10000 && x.status == 200)
						o.success.call(o.success_scope, '' + x.responseText, x, o);
					else if (o.error)
						o.error.call(o.error_scope, c > 10000 ? 'TIMED_OUT' : 'GENERAL', x, o);

					x = null;
				} else
					w.setTimeout(ready, 10);
			};

			// Syncronous request
			if (!o.async)
				return ready();

			// Wait for response, onReadyStateChange can not be used since it leaks memory in IE
			t = w.setTimeout(ready, 10);
		}
	}
});

(function() {
	var extend = tinymce.extend, JSON = tinymce.util.JSON, XHR = tinymce.util.XHR;

	tinymce.create('tinymce.util.JSONRequest', {
		JSONRequest : function(s) {
			this.settings = extend({
			}, s);
			this.count = 0;
		},

		send : function(o) {
			var ecb = o.error, scb = o.success;

			o = extend(this.settings, o);

			o.success = function(c, x) {
				c = JSON.parse(c);

				if (typeof(c) == 'undefined') {
					c = {
						error : 'JSON Parse error.'
					};
				}

				if (c.error)
					ecb.call(o.error_scope || o.scope, c.error, x);
				else
					scb.call(o.success_scope || o.scope, c.result);
			};

			o.error = function(ty, x) {
				ecb.call(o.error_scope || o.scope, ty, x);
			};

			o.data = JSON.serialize({
				id : o.id || 'c' + (this.count++),
				method : o.method,
				params : o.params
			});

			// JSON content type for Ruby on rails. Bug: #1883287
			o.content_type = 'application/json';

			XHR.send(o);
		},

		'static' : {
			sendRPC : function(o) {
				return new tinymce.util.JSONRequest().send(o);
			}
		}
	});
}());
(function(tinymce) {
	// Shorten names
	var each = tinymce.each,
		is = tinymce.is,
		isWebKit = tinymce.isWebKit,
		isIE = tinymce.isIE,
		blockRe = /^(H[1-6R]|P|DIV|ADDRESS|PRE|FORM|T(ABLE|BODY|HEAD|FOOT|H|R|D)|LI|OL|UL|CAPTION|BLOCKQUOTE|CENTER|DL|DT|DD|DIR|FIELDSET|NOSCRIPT|MENU|ISINDEX|SAMP)$/,
		boolAttrs = makeMap('checked,compact,declare,defer,disabled,ismap,multiple,nohref,noresize,noshade,nowrap,readonly,selected'),
		mceAttribs = makeMap('src,href,style,coords,shape'),
		encodedChars = {'&' : '&amp;', '"' : '&quot;', '<' : '&lt;', '>' : '&gt;'},
		encodeCharsRe = /[<>&\"]/g,
		simpleSelectorRe = /^([a-z0-9],?)+$/i,
		tagRegExp = /<(\w+)((?:\s+\w+(?:\s*=\s*(?:(?:"[^"]*")|(?:'[^']*')|[^>\s]+))?)*)(\s*\/?)>/g,
		attrRegExp = /(\w+)(?:\s*=\s*(?:(?:"((?:\\.|[^"])*)")|(?:'((?:\\.|[^'])*)')|([^>\s]+)))?/g;

	function makeMap(str) {
		var map = {}, i;

		str = str.split(',');
		for (i = str.length; i >= 0; i--)
			map[str[i]] = 1;

		return map;
	};

	tinymce.create('tinymce.dom.DOMUtils', {
		doc : null,
		root : null,
		files : null,
		pixelStyles : /^(top|left|bottom|right|width|height|borderWidth)$/,
		props : {
			"for" : "htmlFor",
			"class" : "className",
			className : "className",
			checked : "checked",
			disabled : "disabled",
			maxlength : "maxLength",
			readonly : "readOnly",
			selected : "selected",
			value : "value",
			id : "id",
			name : "name",
			type : "type"
		},

		DOMUtils : function(d, s) {
			var t = this, globalStyle;

			t.doc = d;
			t.win = window;
			t.files = {};
			t.cssFlicker = false;
			t.counter = 0;
			t.boxModel = !tinymce.isIE || d.compatMode == "CSS1Compat"; 
			t.stdMode = d.documentMode === 8;

			t.settings = s = tinymce.extend({
				keep_values : false,
				hex_colors : 1,
				process_html : 1
			}, s);

			// Fix IE6SP2 flicker and check it failed for pre SP2
			if (tinymce.isIE6) {
				try {
					d.execCommand('BackgroundImageCache', false, true);
				} catch (e) {
					t.cssFlicker = true;
				}
			}

			// Build styles list
			if (s.valid_styles) {
				t._styles = {};

				// Convert styles into a rule list
				each(s.valid_styles, function(value, key) {
					t._styles[key] = tinymce.explode(value);
				});
			}

			tinymce.addUnload(t.destroy, t);
		},

		getRoot : function() {
			var t = this, s = t.settings;

			return (s && t.get(s.root_element)) || t.doc.body;
		},

		getViewPort : function(w) {
			var d, b;

			w = !w ? this.win : w;
			d = w.document;
			b = this.boxModel ? d.documentElement : d.body;

			// Returns viewport size excluding scrollbars
			return {
				x : w.pageXOffset || b.scrollLeft,
				y : w.pageYOffset || b.scrollTop,
				w : w.innerWidth || b.clientWidth,
				h : w.innerHeight || b.clientHeight
			};
		},

		getRect : function(e) {
			var p, t = this, sr;

			e = t.get(e);
			p = t.getPos(e);
			sr = t.getSize(e);

			return {
				x : p.x,
				y : p.y,
				w : sr.w,
				h : sr.h
			};
		},

		getSize : function(e) {
			var t = this, w, h;

			e = t.get(e);
			w = t.getStyle(e, 'width');
			h = t.getStyle(e, 'height');

			// Non pixel value, then force offset/clientWidth
			if (w.indexOf('px') === -1)
				w = 0;

			// Non pixel value, then force offset/clientWidth
			if (h.indexOf('px') === -1)
				h = 0;

			return {
				w : parseInt(w) || e.offsetWidth || e.clientWidth,
				h : parseInt(h) || e.offsetHeight || e.clientHeight
			};
		},

		getParent : function(n, f, r) {
			return this.getParents(n, f, r, false);
		},

		getParents : function(n, f, r, c) {
			var t = this, na, se = t.settings, o = [];

			n = t.get(n);
			c = c === undefined;

			if (se.strict_root)
				r = r || t.getRoot();

			// Wrap node name as func
			if (is(f, 'string')) {
				na = f;

				if (f === '*') {
					f = function(n) {return n.nodeType == 1;};
				} else {
					f = function(n) {
						return t.is(n, na);
					};
				}
			}

			while (n) {
				if (n == r || !n.nodeType || n.nodeType === 9)
					break;

				if (!f || f(n)) {
					if (c)
						o.push(n);
					else
						return n;
				}

				n = n.parentNode;
			}

			return c ? o : null;
		},

		get : function(e) {
			var n;

			if (e && this.doc && typeof(e) == 'string') {
				n = e;
				e = this.doc.getElementById(e);

				// IE and Opera returns meta elements when they match the specified input ID, but getElementsByName seems to do the trick
				if (e && e.id !== n)
					return this.doc.getElementsByName(n)[1];
			}

			return e;
		},

		getNext : function(node, selector) {
			return this._findSib(node, selector, 'nextSibling');
		},

		getPrev : function(node, selector) {
			return this._findSib(node, selector, 'previousSibling');
		},


		select : function(pa, s) {
			var t = this;

			return tinymce.dom.Sizzle(pa, t.get(s) || t.get(t.settings.root_element) || t.doc, []);
		},

		is : function(n, selector) {
			var i;

			// If it isn't an array then try to do some simple selectors instead of Sizzle for to boost performance
			if (n.length === undefined) {
				// Simple all selector
				if (selector === '*')
					return n.nodeType == 1;

				// Simple selector just elements
				if (simpleSelectorRe.test(selector)) {
					selector = selector.toLowerCase().split(/,/);
					n = n.nodeName.toLowerCase();

					for (i = selector.length - 1; i >= 0; i--) {
						if (selector[i] == n)
							return true;
					}

					return false;
				}
			}

			return tinymce.dom.Sizzle.matches(selector, n.nodeType ? [n] : n).length > 0;
		},


		add : function(p, n, a, h, c) {
			var t = this;

			return this.run(p, function(p) {
				var e, k;

				e = is(n, 'string') ? t.doc.createElement(n) : n;
				t.setAttribs(e, a);

				if (h) {
					if (h.nodeType)
						e.appendChild(h);
					else
						t.setHTML(e, h);
				}

				return !c ? p.appendChild(e) : e;
			});
		},

		create : function(n, a, h) {
			return this.add(this.doc.createElement(n), n, a, h, 1);
		},

		createHTML : function(n, a, h) {
			var o = '', t = this, k;

			o += '<' + n;

			for (k in a) {
				if (a.hasOwnProperty(k))
					o += ' ' + k + '="' + t.encode(a[k]) + '"';
			}

			if (tinymce.is(h))
				return o + '>' + h + '</' + n + '>';

			return o + ' />';
		},

		remove : function(node, keep_children) {
			return this.run(node, function(node) {
				var parent, child;

				parent = node.parentNode;

				if (!parent)
					return null;

				if (keep_children) {
					while (child = node.firstChild) {
						// IE 8 will crash if you don't remove completely empty text nodes
						if (child.nodeType !== 3 || child.nodeValue)
							parent.insertBefore(child, node);
						else
							node.removeChild(child);
					}
				}

				return parent.removeChild(node);
			});
		},

		setStyle : function(n, na, v) {
			var t = this;

			return t.run(n, function(e) {
				var s, i;

				s = e.style;

				// Camelcase it, if needed
				na = na.replace(/-(\D)/g, function(a, b){
					return b.toUpperCase();
				});

				// Default px suffix on these
				if (t.pixelStyles.test(na) && (tinymce.is(v, 'number') || /^[\-0-9\.]+$/.test(v)))
					v += 'px';

				switch (na) {
					case 'opacity':
						// IE specific opacity
						if (isIE) {
							s.filter = v === '' ? '' : "alpha(opacity=" + (v * 100) + ")";

							if (!n.currentStyle || !n.currentStyle.hasLayout)
								s.display = 'inline-block';
						}

						// Fix for older browsers
						s[na] = s['-moz-opacity'] = s['-khtml-opacity'] = v || '';
						break;

					case 'float':
						isIE ? s.styleFloat = v : s.cssFloat = v;
						break;
					
					default:
						s[na] = v || '';
				}

				// Force update of the style data
				if (t.settings.update_styles)
					t.setAttrib(e, '_mce_style');
			});
		},

		getStyle : function(n, na, c) {
			n = this.get(n);

			if (!n)
				return false;

			// Gecko
			if (this.doc.defaultView && c) {
				// Remove camelcase
				na = na.replace(/[A-Z]/g, function(a){
					return '-' + a;
				});

				try {
					return this.doc.defaultView.getComputedStyle(n, null).getPropertyValue(na);
				} catch (ex) {
					// Old safari might fail
					return null;
				}
			}

			// Camelcase it, if needed
			na = na.replace(/-(\D)/g, function(a, b){
				return b.toUpperCase();
			});

			if (na == 'float')
				na = isIE ? 'styleFloat' : 'cssFloat';

			// IE & Opera
			if (n.currentStyle && c)
				return n.currentStyle[na];

			return n.style[na];
		},

		setStyles : function(e, o) {
			var t = this, s = t.settings, ol;

			ol = s.update_styles;
			s.update_styles = 0;

			each(o, function(v, n) {
				t.setStyle(e, n, v);
			});

			// Update style info
			s.update_styles = ol;
			if (s.update_styles)
				t.setAttrib(e, s.cssText);
		},

		setAttrib : function(e, n, v) {
			var t = this;

			// Whats the point
			if (!e || !n)
				return;

			// Strict XML mode
			if (t.settings.strict)
				n = n.toLowerCase();

			return this.run(e, function(e) {
				var s = t.settings;

				switch (n) {
					case "style":
						if (!is(v, 'string')) {
							each(v, function(v, n) {
								t.setStyle(e, n, v);
							});

							return;
						}

						// No mce_style for elements with these since they might get resized by the user
						if (s.keep_values) {
							if (v && !t._isRes(v))
								e.setAttribute('_mce_style', v, 2);
							else
								e.removeAttribute('_mce_style', 2);
						}

						e.style.cssText = v;
						break;

					case "class":
						e.className = v || ''; // Fix IE null bug
						break;

					case "src":
					case "href":
						if (s.keep_values) {
							if (s.url_converter)
								v = s.url_converter.call(s.url_converter_scope || t, v, n, e);

							t.setAttrib(e, '_mce_' + n, v, 2);
						}

						break;
					
					case "shape":
						e.setAttribute('_mce_style', v);
						break;
				}

				if (is(v) && v !== null && v.length !== 0)
					e.setAttribute(n, '' + v, 2);
				else
					e.removeAttribute(n, 2);
			});
		},

		setAttribs : function(e, o) {
			var t = this;

			return this.run(e, function(e) {
				each(o, function(v, n) {
					t.setAttrib(e, n, v);
				});
			});
		},

		getAttrib : function(e, n, dv) {
			var v, t = this;

			e = t.get(e);

			if (!e || e.nodeType !== 1)
				return false;

			if (!is(dv))
				dv = '';

			// Try the mce variant for these
			if (/^(src|href|style|coords|shape)$/.test(n)) {
				v = e.getAttribute("_mce_" + n);

				if (v)
					return v;
			}

			if (isIE && t.props[n]) {
				v = e[t.props[n]];
				v = v && v.nodeValue ? v.nodeValue : v;
			}

			if (!v)
				v = e.getAttribute(n, 2);

			// Check boolean attribs
			if (/^(checked|compact|declare|defer|disabled|ismap|multiple|nohref|noshade|nowrap|readonly|selected)$/.test(n)) {
				if (e[t.props[n]] === true && v === '')
					return n;

				return v ? n : '';
			}

			// Inner input elements will override attributes on form elements
			if (e.nodeName === "FORM" && e.getAttributeNode(n))
				return e.getAttributeNode(n).nodeValue;

			if (n === 'style') {
				v = v || e.style.cssText;

				if (v) {
					v = t.serializeStyle(t.parseStyle(v), e.nodeName);

					if (t.settings.keep_values && !t._isRes(v))
						e.setAttribute('_mce_style', v);
				}
			}

			// Remove Apple and WebKit stuff
			if (isWebKit && n === "class" && v)
				v = v.replace(/(apple|webkit)\-[a-z\-]+/gi, '');

			// Handle IE issues
			if (isIE) {
				switch (n) {
					case 'rowspan':
					case 'colspan':
						// IE returns 1 as default value
						if (v === 1)
							v = '';

						break;

					case 'size':
						// IE returns +0 as default value for size
						if (v === '+0' || v === 20 || v === 0)
							v = '';

						break;

					case 'width':
					case 'height':
					case 'vspace':
					case 'checked':
					case 'disabled':
					case 'readonly':
						if (v === 0)
							v = '';

						break;

					case 'hspace':
						// IE returns -1 as default value
						if (v === -1)
							v = '';

						break;

					case 'maxlength':
					case 'tabindex':
						// IE returns default value
						if (v === 32768 || v === 2147483647 || v === '32768')
							v = '';

						break;

					case 'multiple':
					case 'compact':
					case 'noshade':
					case 'nowrap':
						if (v === 65535)
							return n;

						return dv;

					case 'shape':
						v = v.toLowerCase();
						break;

					default:
						// IE has odd anonymous function for event attributes
						if (n.indexOf('on') === 0 && v)
							v = ('' + v).replace(/^function\s+\w+\(\)\s+\{\s+(.*)\s+\}$/, '$1');
				}
			}

			return (v !== undefined && v !== null && v !== '') ? '' + v : dv;
		},

		getPos : function(n, ro) {
			var t = this, x = 0, y = 0, e, d = t.doc, r;

			n = t.get(n);
			ro = ro || d.body;

			if (n) {
				// Use getBoundingClientRect on IE, Opera has it but it's not perfect
				if (isIE && !t.stdMode) {
					n = n.getBoundingClientRect();
					e = t.boxModel ? d.documentElement : d.body;
					x = t.getStyle(t.select('html')[0], 'borderWidth'); // Remove border
					x = (x == 'medium' || t.boxModel && !t.isIE6) && 2 || x;
					n.top += t.win.self != t.win.top ? 2 : 0; // IE adds some strange extra cord if used in a frameset

					return {x : n.left + e.scrollLeft - x, y : n.top + e.scrollTop - x};
				}

				r = n;
				while (r && r != ro && r.nodeType) {
					x += r.offsetLeft || 0;
					y += r.offsetTop || 0;
					r = r.offsetParent;
				}

				r = n.parentNode;
				while (r && r != ro && r.nodeType) {
					x -= r.scrollLeft || 0;
					y -= r.scrollTop || 0;
					r = r.parentNode;
				}
			}

			return {x : x, y : y};
		},

		parseStyle : function(st) {
			var t = this, s = t.settings, o = {};

			if (!st)
				return o;

			function compress(p, s, ot) {
				var t, r, b, l;

				// Get values and check it it needs compressing
				t = o[p + '-top' + s];
				if (!t)
					return;

				r = o[p + '-right' + s];
				if (t != r)
					return;

				b = o[p + '-bottom' + s];
				if (r != b)
					return;

				l = o[p + '-left' + s];
				if (b != l)
					return;

				// Compress
				o[ot] = l;
				delete o[p + '-top' + s];
				delete o[p + '-right' + s];
				delete o[p + '-bottom' + s];
				delete o[p + '-left' + s];
			};

			function compress2(ta, a, b, c) {
				var t;

				t = o[a];
				if (!t)
					return;

				t = o[b];
				if (!t)
					return;

				t = o[c];
				if (!t)
					return;

				// Compress
				o[ta] = o[a] + ' ' + o[b] + ' ' + o[c];
				delete o[a];
				delete o[b];
				delete o[c];
			};

			st = st.replace(/&(#?[a-z0-9]+);/g, '&$1_MCE_SEMI_'); // Protect entities

			each(st.split(';'), function(v) {
				var sv, ur = [];

				if (v) {
					v = v.replace(/_MCE_SEMI_/g, ';'); // Restore entities
					v = v.replace(/url\([^\)]+\)/g, function(v) {ur.push(v);return 'url(' + ur.length + ')';});
					v = v.split(':');
					sv = tinymce.trim(v[1]);
					sv = sv.replace(/url\(([^\)]+)\)/g, function(a, b) {return ur[parseInt(b) - 1];});

					sv = sv.replace(/rgb\([^\)]+\)/g, function(v) {
						return t.toHex(v);
					});

					if (s.url_converter) {
						sv = sv.replace(/url\([\'\"]?([^\)\'\"]+)[\'\"]?\)/g, function(x, c) {
							return 'url(' + s.url_converter.call(s.url_converter_scope || t, t.decode(c), 'style', null) + ')';
						});
					}

					o[tinymce.trim(v[0]).toLowerCase()] = sv;
				}
			});

			compress("border", "", "border");
			compress("border", "-width", "border-width");
			compress("border", "-color", "border-color");
			compress("border", "-style", "border-style");
			compress("padding", "", "padding");
			compress("margin", "", "margin");
			compress2('border', 'border-width', 'border-style', 'border-color');

			if (isIE) {
				// Remove pointless border
				if (o.border == 'medium none')
					o.border = '';
			}

			return o;
		},

		serializeStyle : function(o, name) {
			var t = this, s = '';

			function add(v, k) {
				if (k && v) {
					// Remove browser specific styles like -moz- or -webkit-
					if (k.indexOf('-') === 0)
						return;

					switch (k) {
						case 'font-weight':
							// Opera will output bold as 700
							if (v == 700)
								v = 'bold';

							break;

						case 'color':
						case 'background-color':
							v = v.toLowerCase();
							break;
					}

					s += (s ? ' ' : '') + k + ': ' + v + ';';
				}
			};

			// Validate style output
			if (name && t._styles) {
				each(t._styles['*'], function(name) {
					add(o[name], name);
				});

				each(t._styles[name.toLowerCase()], function(name) {
					add(o[name], name);
				});
			} else
				each(o, add);

			return s;
		},

		loadCSS : function(u) {
			var t = this, d = t.doc, head;

			if (!u)
				u = '';

			head = t.select('head')[0];

			each(u.split(','), function(u) {
				var link;

				if (t.files[u])
					return;

				t.files[u] = true;
				link = t.create('link', {rel : 'stylesheet', href : tinymce._addVer(u)});

				// IE 8 has a bug where dynamically loading stylesheets would produce a 1 item remaining bug
				// This fix seems to resolve that issue by realcing the document ones a stylesheet finishes loading
				// It's ugly but it seems to work fine.
				if (isIE && d.documentMode) {
					link.onload = function() {
						d.recalc();
						link.onload = null;
					};
				}

				head.appendChild(link);
			});
		},

		addClass : function(e, c) {
			return this.run(e, function(e) {
				var o;

				if (!c)
					return 0;

				if (this.hasClass(e, c))
					return e.className;

				o = this.removeClass(e, c);

				return e.className = (o != '' ? (o + ' ') : '') + c;
			});
		},

		removeClass : function(e, c) {
			var t = this, re;

			return t.run(e, function(e) {
				var v;

				if (t.hasClass(e, c)) {
					if (!re)
						re = new RegExp("(^|\\s+)" + c + "(\\s+|$)", "g");

					v = e.className.replace(re, ' ');
					v = tinymce.trim(v != ' ' ? v : '');

					e.className = v;

					// Empty class attr
					if (!v) {
						e.removeAttribute('class');
						e.removeAttribute('className');
					}

					return v;
				}

				return e.className;
			});
		},

		hasClass : function(n, c) {
			n = this.get(n);

			if (!n || !c)
				return false;

			return (' ' + n.className + ' ').indexOf(' ' + c + ' ') !== -1;
		},

		show : function(e) {
			return this.setStyle(e, 'display', 'block');
		},

		hide : function(e) {
			return this.setStyle(e, 'display', 'none');
		},

		isHidden : function(e) {
			e = this.get(e);

			return !e || e.style.display == 'none' || this.getStyle(e, 'display') == 'none';
		},

		uniqueId : function(p) {
			return (!p ? 'mce_' : p) + (this.counter++);
		},

		setHTML : function(e, h) {
			var t = this;

			return this.run(e, function(e) {
				var x, i, nl, n, p, x;

				h = t.processHTML(h);

				if (isIE) {
					function set() {
						// Remove all child nodes
						while (e.firstChild)
							e.firstChild.removeNode();

						try {
							// IE will remove comments from the beginning
							// unless you padd the contents with something
							e.innerHTML = '<br />' + h;
							e.removeChild(e.firstChild);
						} catch (ex) {
							// IE sometimes produces an unknown runtime error on innerHTML if it's an block element within a block element for example a div inside a p
							// This seems to fix this problem

							// Create new div with HTML contents and a BR infront to keep comments
							x = t.create('div');
							x.innerHTML = '<br />' + h;

							// Add all children from div to target
							each (x.childNodes, function(n, i) {
								// Skip br element
								if (i)
									e.appendChild(n);
							});
						}
					};

					// IE has a serious bug when it comes to paragraphs it can produce an invalid
					// DOM tree if contents like this <p><ul><li>Item 1</li></ul></p> is inserted
					// It seems to be that IE doesn't like a root block element placed inside another root block element
					if (t.settings.fix_ie_paragraphs)
						h = h.replace(/<p><\/p>|<p([^>]+)><\/p>|<p[^\/+]\/>/gi, '<p$1 _mce_keep="true">&nbsp;</p>');

					set();

					if (t.settings.fix_ie_paragraphs) {
						// Check for odd paragraphs this is a sign of a broken DOM
						nl = e.getElementsByTagName("p");
						for (i = nl.length - 1, x = 0; i >= 0; i--) {
							n = nl[i];

							if (!n.hasChildNodes()) {
								if (!n._mce_keep) {
									x = 1; // Is broken
									break;
								}

								n.removeAttribute('_mce_keep');
							}
						}
					}

					// Time to fix the madness IE left us
					if (x) {
						// So if we replace the p elements with divs and mark them and then replace them back to paragraphs
						// after we use innerHTML we can fix the DOM tree
						h = h.replace(/<p ([^>]+)>|<p>/ig, '<div $1 _mce_tmp="1">');
						h = h.replace(/<\/p>/g, '</div>');

						// Set the new HTML with DIVs
						set();

						// Replace all DIV elements with the _mce_tmp attibute back to paragraphs
						// This is needed since IE has a annoying bug see above for details
						// This is a slow process but it has to be done. :(
						if (t.settings.fix_ie_paragraphs) {
							nl = e.getElementsByTagName("DIV");
							for (i = nl.length - 1; i >= 0; i--) {
								n = nl[i];

								// Is it a temp div
								if (n._mce_tmp) {
									// Create new paragraph
									p = t.doc.createElement('p');

									// Copy all attributes
									n.cloneNode(false).outerHTML.replace(/([a-z0-9\-_]+)=/gi, function(a, b) {
										var v;

										if (b !== '_mce_tmp') {
											v = n.getAttribute(b);

											if (!v && b === 'class')
												v = n.className;

											p.setAttribute(b, v);
										}
									});

									// Append all children to new paragraph
									for (x = 0; x<n.childNodes.length; x++)
										p.appendChild(n.childNodes[x].cloneNode(true));

									// Replace div with new paragraph
									n.swapNode(p);
								}
							}
						}
					}
				} else
					e.innerHTML = h;

				return h;
			});
		},

		processHTML : function(h) {
			var t = this, s = t.settings, codeBlocks = [];

			if (!s.process_html)
				return h;

			if (isIE) {
				h = h.replace(/&apos;/g, '&#39;'); // IE can't handle apos
				h = h.replace(/\s+(disabled|checked|readonly|selected)\s*=\s*[\"\']?(false|0)[\"\']?/gi, ''); // IE doesn't handle default values correct
			}

			// Fix some issues
			h = h.replace(/<a( )([^>]+)\/>|<a\/>/gi, '<a$1$2></a>'); // Force open

			// Store away src and href in _mce_src and mce_href since browsers mess them up
			if (s.keep_values) {
				// Wrap scripts and styles in comments for serialization purposes
				if (/<script|noscript|style/i.test(h)) {
					function trim(s) {
						// Remove prefix and suffix code for element
						s = s.replace(/(<!--\[CDATA\[|\]\]-->)/g, '\n');
						s = s.replace(/^[\r\n]*|[\r\n]*$/g, '');
						s = s.replace(/^\s*(\/\/\s*<!--|\/\/\s*<!\[CDATA\[|<!--|<!\[CDATA\[)[\r\n]*/g, '');
						s = s.replace(/\s*(\/\/\s*\]\]>|\/\/\s*-->|\]\]>|-->|\]\]-->)\s*$/g, '');

						return s;
					};

					// Wrap the script contents in CDATA and keep them from executing
					h = h.replace(/<script([^>]+|)>([\s\S]*?)<\/script>/gi, function(v, attribs, text) {
						// Force type attribute
						if (!attribs)
							attribs = ' type="text/javascript"';

						// Convert the src attribute of the scripts
						attribs = attribs.replace(/src=\"([^\"]+)\"?/i, function(a, url) {
							if (s.url_converter)
								url = t.encode(s.url_converter.call(s.url_converter_scope || t, t.decode(url), 'src', 'script'));

							return '_mce_src="' + url + '"';
						});

						// Wrap text contents
						if (tinymce.trim(text)) {
							codeBlocks.push(trim(text));
							text = '<!--\nMCE_SCRIPT:' + (codeBlocks.length - 1) + '\n// -->';
						}

						return '<mce:script' + attribs + '>' + text + '</mce:script>';
					});

					// Wrap style elements
					h = h.replace(/<style([^>]+|)>([\s\S]*?)<\/style>/gi, function(v, attribs, text) {
						// Wrap text contents
						if (text) {
							codeBlocks.push(trim(text));
							text = '<!--\nMCE_SCRIPT:' + (codeBlocks.length - 1) + '\n-->';
						}

						return '<mce:style' + attribs + '>' + text + '</mce:style><style ' + attribs + ' _mce_bogus="1">' + text + '</style>';
					});

					// Wrap noscript elements
					h = h.replace(/<noscript([^>]+|)>([\s\S]*?)<\/noscript>/g, function(v, attribs, text) {
						return '<mce:noscript' + attribs + '><!--' + t.encode(text).replace(/--/g, '&#45;&#45;') + '--></mce:noscript>';
					});
				}

				h = h.replace(/<!\[CDATA\[([\s\S]+)\]\]>/g, '<!--[CDATA[$1]]-->');

				// This function processes the attributes in the HTML string to force boolean
				// attributes to the attr="attr" format and convert style, src and href to _mce_ versions
				function processTags(html) {
					return html.replace(tagRegExp, function(match, elm_name, attrs, end) {
						return '<' + elm_name + attrs.replace(attrRegExp, function(match, name, value, val2, val3) {
							var mceValue;

							name = name.toLowerCase();
							value = value || val2 || val3 || "";

							// Treat boolean attributes
							if (boolAttrs[name]) {
								// false or 0 is treated as a missing attribute
								if (value === 'false' || value === '0')
									return;

								return name + '="' + name + '"';
							}

							// Is attribute one that needs special treatment
							if (mceAttribs[name] && attrs.indexOf('_mce_' + name) == -1) {
								mceValue = t.decode(value);

								// Convert URLs to relative/absolute ones
								if (s.url_converter && (name == "src" || name == "href"))
									mceValue = s.url_converter.call(s.url_converter_scope || t, mceValue, name, elm_name);

								// Process styles lowercases them and compresses them
								if (name == 'style')
									mceValue = t.serializeStyle(t.parseStyle(mceValue), name);

								return name + '="' + value + '"' + ' _mce_' + name + '="' + t.encode(mceValue) + '"';
							}

							return match;
						}) + end + '>';
					});
				};

				h = processTags(h);

				// Restore script blocks
				h = h.replace(/MCE_SCRIPT:([0-9]+)/g, function(val, idx) {
					return codeBlocks[idx];
				});
			}

			return h;
		},

		getOuterHTML : function(e) {
			var d;

			e = this.get(e);

			if (!e)
				return null;

			if (e.outerHTML !== undefined)
				return e.outerHTML;

			d = (e.ownerDocument || this.doc).createElement("body");
			d.appendChild(e.cloneNode(true));

			return d.innerHTML;
		},

		setOuterHTML : function(e, h, d) {
			var t = this;

			function setHTML(e, h, d) {
				var n, tp;

				tp = d.createElement("body");
				tp.innerHTML = h;

				n = tp.lastChild;
				while (n) {
					t.insertAfter(n.cloneNode(true), e);
					n = n.previousSibling;
				}

				t.remove(e);
			};

			return this.run(e, function(e) {
				e = t.get(e);

				// Only set HTML on elements
				if (e.nodeType == 1) {
					d = d || e.ownerDocument || t.doc;

					if (isIE) {
						try {
							// Try outerHTML for IE it sometimes produces an unknown runtime error
							if (isIE && e.nodeType == 1)
								e.outerHTML = h;
							else
								setHTML(e, h, d);
						} catch (ex) {
							// Fix for unknown runtime error
							setHTML(e, h, d);
						}
					} else
						setHTML(e, h, d);
				}
			});
		},

		decode : function(s) {
			var e, n, v;

			// Look for entities to decode
			if (/&[\w#]+;/.test(s)) {
				// Decode the entities using a div element not super efficient but less code
				e = this.doc.createElement("div");
				e.innerHTML = s;
				n = e.firstChild;
				v = '';

				if (n) {
					do {
						v += n.nodeValue;
					} while (n = n.nextSibling);
				}

				return v || s;
			}

			return s;
		},

		encode : function(str) {
			return ('' + str).replace(encodeCharsRe, function(chr) {
				return encodedChars[chr];
			});
		},

		insertAfter : function(node, reference_node) {
			reference_node = this.get(reference_node);

			return this.run(node, function(node) {
				var parent, nextSibling;

				parent = reference_node.parentNode;
				nextSibling = reference_node.nextSibling;

				if (nextSibling)
					parent.insertBefore(node, nextSibling);
				else
					parent.appendChild(node);

				return node;
			});
		},

		isBlock : function(n) {
			if (n.nodeType && n.nodeType !== 1)
				return false;

			n = n.nodeName || n;

			return blockRe.test(n);
		},

		replace : function(n, o, k) {
			var t = this;

			if (is(o, 'array'))
				n = n.cloneNode(true);

			return t.run(o, function(o) {
				if (k) {
					each(tinymce.grep(o.childNodes), function(c) {
						n.appendChild(c);
					});
				}

				return o.parentNode.replaceChild(n, o);
			});
		},

		rename : function(elm, name) {
			var t = this, newElm;

			if (elm.nodeName != name.toUpperCase()) {
				// Rename block element
				newElm = t.create(name);

				// Copy attribs to new block
				each(t.getAttribs(elm), function(attr_node) {
					t.setAttrib(newElm, attr_node.nodeName, t.getAttrib(elm, attr_node.nodeName));
				});

				// Replace block
				t.replace(newElm, elm, 1);
			}

			return newElm || elm;
		},

		findCommonAncestor : function(a, b) {
			var ps = a, pe;

			while (ps) {
				pe = b;

				while (pe && ps != pe)
					pe = pe.parentNode;

				if (ps == pe)
					break;

				ps = ps.parentNode;
			}

			if (!ps && a.ownerDocument)
				return a.ownerDocument.documentElement;

			return ps;
		},

		toHex : function(s) {
			var c = /^\s*rgb\s*?\(\s*?([0-9]+)\s*?,\s*?([0-9]+)\s*?,\s*?([0-9]+)\s*?\)\s*$/i.exec(s);

			function hex(s) {
				s = parseInt(s).toString(16);

				return s.length > 1 ? s : '0' + s; // 0 -> 00
			};

			if (c) {
				s = '#' + hex(c[1]) + hex(c[2]) + hex(c[3]);

				return s;
			}

			return s;
		},

		getClasses : function() {
			var t = this, cl = [], i, lo = {}, f = t.settings.class_filter, ov;

			if (t.classes)
				return t.classes;

			function addClasses(s) {
				// IE style imports
				each(s.imports, function(r) {
					addClasses(r);
				});

				each(s.cssRules || s.rules, function(r) {
					// Real type or fake it on IE
					switch (r.type || 1) {
						// Rule
						case 1:
							if (r.selectorText) {
								each(r.selectorText.split(','), function(v) {
									v = v.replace(/^\s*|\s*$|^\s\./g, "");

									// Is internal or it doesn't contain a class
									if (/\.mce/.test(v) || !/\.[\w\-]+$/.test(v))
										return;

									// Remove everything but class name
									ov = v;
									v = v.replace(/.*\.([a-z0-9_\-]+).*/i, '$1');

									// Filter classes
									if (f && !(v = f(v, ov)))
										return;

									if (!lo[v]) {
										cl.push({'class' : v});
										lo[v] = 1;
									}
								});
							}
							break;

						// Import
						case 3:
							addClasses(r.styleSheet);
							break;
					}
				});
			};

			try {
				each(t.doc.styleSheets, addClasses);
			} catch (ex) {
				// Ignore
			}

			if (cl.length > 0)
				t.classes = cl;

			return cl;
		},

		run : function(e, f, s) {
			var t = this, o;

			if (t.doc && typeof(e) === 'string')
				e = t.get(e);

			if (!e)
				return false;

			s = s || this;
			if (!e.nodeType && (e.length || e.length === 0)) {
				o = [];

				each(e, function(e, i) {
					if (e) {
						if (typeof(e) == 'string')
							e = t.doc.getElementById(e);

						o.push(f.call(s, e, i));
					}
				});

				return o;
			}

			return f.call(s, e);
		},

		getAttribs : function(n) {
			var o;

			n = this.get(n);

			if (!n)
				return [];

			if (isIE) {
				o = [];

				// Object will throw exception in IE
				if (n.nodeName == 'OBJECT')
					return n.attributes;

				// IE doesn't keep the selected attribute if you clone option elements
				if (n.nodeName === 'OPTION' && this.getAttrib(n, 'selected'))
					o.push({specified : 1, nodeName : 'selected'});

				// It's crazy that this is faster in IE but it's because it returns all attributes all the time
				n.cloneNode(false).outerHTML.replace(/<\/?[\w:\-]+ ?|=[\"][^\"]+\"|=\'[^\']+\'|=[\w\-]+|>/gi, '').replace(/[\w:\-]+/gi, function(a) {
					o.push({specified : 1, nodeName : a});
				});

				return o;
			}

			return n.attributes;
		},

		destroy : function(s) {
			var t = this;

			if (t.events)
				t.events.destroy();

			t.win = t.doc = t.root = t.events = null;

			// Manual destroy then remove unload handler
			if (!s)
				tinymce.removeUnload(t.destroy);
		},

		createRng : function() {
			var d = this.doc;

			return d.createRange ? d.createRange() : new tinymce.dom.Range(this);
		},

		nodeIndex : function(node, normalized) {
			var idx = 0, lastNodeType, lastNode, nodeType;

			if (node) {
				for (lastNodeType = node.nodeType, node = node.previousSibling, lastNode = node; node; node = node.previousSibling) {
					nodeType = node.nodeType;

					// Handle normalization of text nodes
					if (!normalized || nodeType != 3 || (lastNodeType != nodeType && node.nodeValue.length))
						idx++;

					lastNodeType = nodeType;
				}
			}

			return idx;
		},

		split : function(pe, e, re) {
			var t = this, r = t.createRng(), bef, aft, pa;

			// W3C valid browsers tend to leave empty nodes to the left/right side of the contents, this makes sense
			// but we don't want that in our code since it serves no purpose for the end user
			// For example if this is chopped:
			//   <p>text 1<span><b>CHOP</b></span>text 2</p>
			// would produce:
			//   <p>text 1<span></span></p><b>CHOP</b><p><span></span>text 2</p>
			// this function will then trim of empty edges and produce:
			//   <p>text 1</p><b>CHOP</b><p>text 2</p>
			function trim(node) {
				var i, children = node.childNodes;

				if (node.nodeType == 1 && node.getAttribute('_mce_type') == 'bookmark')
					return;

				for (i = children.length - 1; i >= 0; i--)
					trim(children[i]);

				if (node.nodeType != 9) {
					// Keep non whitespace text nodes
					if (node.nodeType == 3 && node.nodeValue.length > 0)
						return;

					if (node.nodeType == 1) {
						// If the only child is a bookmark then move it up
						children = node.childNodes;
						if (children.length == 1 && children[0] && children[0].nodeType == 1 && children[0].getAttribute('_mce_type') == 'bookmark')
							node.parentNode.insertBefore(children[0], node);

						// Keep non empty elements or img, hr etc
						if (children.length || /^(br|hr|input|img)$/i.test(node.nodeName))
							return;
					}

					t.remove(node);
				}

				return node;
			};

			if (pe && e) {
				// Get before chunk
				r.setStart(pe.parentNode, t.nodeIndex(pe));
				r.setEnd(e.parentNode, t.nodeIndex(e));
				bef = r.extractContents();

				// Get after chunk
				r = t.createRng();
				r.setStart(e.parentNode, t.nodeIndex(e) + 1);
				r.setEnd(pe.parentNode, t.nodeIndex(pe) + 1);
				aft = r.extractContents();

				// Insert before chunk
				pa = pe.parentNode;
				pa.insertBefore(trim(bef), pe);

				// Insert middle chunk
				if (re)
					pa.replaceChild(re, e);
				else
					pa.insertBefore(e, pe);

				// Insert after chunk
				pa.insertBefore(trim(aft), pe);
				t.remove(pe);

				return re || e;
			}
		},

		bind : function(target, name, func, scope) {
			var t = this;

			if (!t.events)
				t.events = new tinymce.dom.EventUtils();

			return t.events.add(target, name, func, scope || this);
		},

		unbind : function(target, name, func) {
			var t = this;

			if (!t.events)
				t.events = new tinymce.dom.EventUtils();

			return t.events.remove(target, name, func);
		},


		_findSib : function(node, selector, name) {
			var t = this, f = selector;

			if (node) {
				// If expression make a function of it using is
				if (is(f, 'string')) {
					f = function(node) {
						return t.is(node, selector);
					};
				}

				// Loop all siblings
				for (node = node[name]; node; node = node[name]) {
					if (f(node))
						return node;
				}
			}

			return null;
		},

		_isRes : function(c) {
			// Is live resizble element
			return /^(top|left|bottom|right|width|height)/i.test(c) || /;\s*(top|left|bottom|right|width|height)/i.test(c);
		}

		/*
		walk : function(n, f, s) {
			var d = this.doc, w;

			if (d.createTreeWalker) {
				w = d.createTreeWalker(n, NodeFilter.SHOW_TEXT, null, false);

				while ((n = w.nextNode()) != null)
					f.call(s || this, n);
			} else
				tinymce.walk(n, f, 'childNodes', s);
		}
		*/

		/*
		toRGB : function(s) {
			var c = /^\s*?#([0-9A-F]{2})([0-9A-F]{1,2})([0-9A-F]{2})?\s*?$/.exec(s);

			if (c) {
				// #FFF -> #FFFFFF
				if (!is(c[3]))
					c[3] = c[2] = c[1];

				return "rgb(" + parseInt(c[1], 16) + "," + parseInt(c[2], 16) + "," + parseInt(c[3], 16) + ")";
			}

			return s;
		}
		*/
	});

	tinymce.DOM = new tinymce.dom.DOMUtils(document, {process_html : 0});
})(tinymce);

(function(ns) {
	// Range constructor
	function Range(dom) {
		var t = this,
			doc = dom.doc,
			EXTRACT = 0,
			CLONE = 1,
			DELETE = 2,
			TRUE = true,
			FALSE = false,
			START_OFFSET = 'startOffset',
			START_CONTAINER = 'startContainer',
			END_CONTAINER = 'endContainer',
			END_OFFSET = 'endOffset',
			extend = tinymce.extend,
			nodeIndex = dom.nodeIndex;

		extend(t, {
			// Inital states
			startContainer : doc,
			startOffset : 0,
			endContainer : doc,
			endOffset : 0,
			collapsed : TRUE,
			commonAncestorContainer : doc,

			// Range constants
			START_TO_START : 0,
			START_TO_END : 1,
			END_TO_END : 2,
			END_TO_START : 3,

			// Public methods
			setStart : setStart,
			setEnd : setEnd,
			setStartBefore : setStartBefore,
			setStartAfter : setStartAfter,
			setEndBefore : setEndBefore,
			setEndAfter : setEndAfter,
			collapse : collapse,
			selectNode : selectNode,
			selectNodeContents : selectNodeContents,
			compareBoundaryPoints : compareBoundaryPoints,
			deleteContents : deleteContents,
			extractContents : extractContents,
			cloneContents : cloneContents,
			insertNode : insertNode,
			surroundContents : surroundContents,
			cloneRange : cloneRange
		});

		function setStart(n, o) {
			_setEndPoint(TRUE, n, o);
		};

		function setEnd(n, o) {
			_setEndPoint(FALSE, n, o);
		};

		function setStartBefore(n) {
			setStart(n.parentNode, nodeIndex(n));
		};

		function setStartAfter(n) {
			setStart(n.parentNode, nodeIndex(n) + 1);
		};

		function setEndBefore(n) {
			setEnd(n.parentNode, nodeIndex(n));
		};

		function setEndAfter(n) {
			setEnd(n.parentNode, nodeIndex(n) + 1);
		};

		function collapse(ts) {
			if (ts) {
				t[END_CONTAINER] = t[START_CONTAINER];
				t[END_OFFSET] = t[START_OFFSET];
			} else {
				t[START_CONTAINER] = t[END_CONTAINER];
				t[START_OFFSET] = t[END_OFFSET];
			}

			t.collapsed = TRUE;
		};

		function selectNode(n) {
			setStartBefore(n);
			setEndAfter(n);
		};

		function selectNodeContents(n) {
			setStart(n, 0);
			setEnd(n, n.nodeType === 1 ? n.childNodes.length : n.nodeValue.length);
		};

		function compareBoundaryPoints(h, r) {
			var sc = t[START_CONTAINER], so = t[START_OFFSET], ec = t[END_CONTAINER], eo = t[END_OFFSET];

			// Check START_TO_START
			if (h === 0)
				return _compareBoundaryPoints(sc, so, sc, so);

			// Check START_TO_END
			if (h === 1)
				return _compareBoundaryPoints(sc, so, ec, eo);

			// Check END_TO_END
			if (h === 2)
				return _compareBoundaryPoints(ec, eo, ec, eo);

			// Check END_TO_START
			if (h === 3)
				return _compareBoundaryPoints(ec, eo, sc, so);
		};

		function deleteContents() {
			_traverse(DELETE);
		};

		function extractContents() {
			return _traverse(EXTRACT);
		};

		function cloneContents() {
			return _traverse(CLONE);
		};

		function insertNode(n) {
			var startContainer = this[START_CONTAINER],
				startOffset = this[START_OFFSET], nn, o;

			// Node is TEXT_NODE or CDATA
			if ((startContainer.nodeType === 3 || startContainer.nodeType === 4) && startContainer.nodeValue) {
				if (!startOffset) {
					// At the start of text
					startContainer.parentNode.insertBefore(n, startContainer);
				} else if (startOffset >= startContainer.nodeValue.length) {
					// At the end of text
					dom.insertAfter(n, startContainer);
				} else {
					// Middle, need to split
					nn = startContainer.splitText(startOffset);
					startContainer.parentNode.insertBefore(n, nn);
				}
			} else {
				// Insert element node
				if (startContainer.childNodes.length > 0)
					o = startContainer.childNodes[startOffset];

				if (o)
					startContainer.insertBefore(n, o);
				else
					startContainer.appendChild(n);
			}
		};

		function surroundContents(n) {
			var f = t.extractContents();

			t.insertNode(n);
			n.appendChild(f);
			t.selectNode(n);
		};

		function cloneRange() {
			return extend(new Range(dom), {
				startContainer : t[START_CONTAINER],
				startOffset : t[START_OFFSET],
				endContainer : t[END_CONTAINER],
				endOffset : t[END_OFFSET],
				collapsed : t.collapsed,
				commonAncestorContainer : t.commonAncestorContainer
			});
		};

		// Private methods

		function _getSelectedNode(container, offset) {
			var child;

			if (container.nodeType == 3 /* TEXT_NODE */)
				return container;

			if (offset < 0)
				return container;

			child = container.firstChild;
			while (child && offset > 0) {
				--offset;
				child = child.nextSibling;
			}

			if (child)
				return child;

			return container;
		};

		function _isCollapsed() {
			return (t[START_CONTAINER] == t[END_CONTAINER] && t[START_OFFSET] == t[END_OFFSET]);
		};

		function _compareBoundaryPoints(containerA, offsetA, containerB, offsetB) {
			var c, offsetC, n, cmnRoot, childA, childB;

			// In the first case the boundary-points have the same container. A is before B
			// if its offset is less than the offset of B, A is equal to B if its offset is
			// equal to the offset of B, and A is after B if its offset is greater than the
			// offset of B.
			if (containerA == containerB) {
				if (offsetA == offsetB)
					return 0; // equal

				if (offsetA < offsetB)
					return -1; // before

				return 1; // after
			}

			// In the second case a child node C of the container of A is an ancestor
			// container of B. In this case, A is before B if the offset of A is less than or
			// equal to the index of the child node C and A is after B otherwise.
			c = containerB;
			while (c && c.parentNode != containerA)
				c = c.parentNode;

			if (c) {
				offsetC = 0;
				n = containerA.firstChild;

				while (n != c && offsetC < offsetA) {
					offsetC++;
					n = n.nextSibling;
				}

				if (offsetA <= offsetC)
					return -1; // before

				return 1; // after
			}

			// In the third case a child node C of the container of B is an ancestor container
			// of A. In this case, A is before B if the index of the child node C is less than
			// the offset of B and A is after B otherwise.
			c = containerA;
			while (c && c.parentNode != containerB) {
				c = c.parentNode;
			}

			if (c) {
				offsetC = 0;
				n = containerB.firstChild;

				while (n != c && offsetC < offsetB) {
					offsetC++;
					n = n.nextSibling;
				}

				if (offsetC < offsetB)
					return -1; // before

				return 1; // after
			}

			// In the fourth case, none of three other cases hold: the containers of A and B
			// are siblings or descendants of sibling nodes. In this case, A is before B if
			// the container of A is before the container of B in a pre-order traversal of the
			// Ranges' context tree and A is after B otherwise.
			cmnRoot = dom.findCommonAncestor(containerA, containerB);
			childA = containerA;

			while (childA && childA.parentNode != cmnRoot)
				childA = childA.parentNode;

			if (!childA)
				childA = cmnRoot;

			childB = containerB;
			while (childB && childB.parentNode != cmnRoot)
				childB = childB.parentNode;

			if (!childB)
				childB = cmnRoot;

			if (childA == childB)
				return 0; // equal

			n = cmnRoot.firstChild;
			while (n) {
				if (n == childA)
					return -1; // before

				if (n == childB)
					return 1; // after

				n = n.nextSibling;
			}
		};

		function _setEndPoint(st, n, o) {
			var ec, sc;

			if (st) {
				t[START_CONTAINER] = n;
				t[START_OFFSET] = o;
			} else {
				t[END_CONTAINER] = n;
				t[END_OFFSET] = o;
			}

			// If one boundary-point of a Range is set to have a root container
			// other than the current one for the Range, the Range is collapsed to
			// the new position. This enforces the restriction that both boundary-
			// points of a Range must have the same root container.
			ec = t[END_CONTAINER];
			while (ec.parentNode)
				ec = ec.parentNode;

			sc = t[START_CONTAINER];
			while (sc.parentNode)
				sc = sc.parentNode;

			if (sc == ec) {
				// The start position of a Range is guaranteed to never be after the
				// end position. To enforce this restriction, if the start is set to
				// be at a position after the end, the Range is collapsed to that
				// position.
				if (_compareBoundaryPoints(t[START_CONTAINER], t[START_OFFSET], t[END_CONTAINER], t[END_OFFSET]) > 0)
					t.collapse(st);
			} else
				t.collapse(st);

			t.collapsed = _isCollapsed();
			t.commonAncestorContainer = dom.findCommonAncestor(t[START_CONTAINER], t[END_CONTAINER]);
		};

		function _traverse(how) {
			var c, endContainerDepth = 0, startContainerDepth = 0, p, depthDiff, startNode, endNode, sp, ep;

			if (t[START_CONTAINER] == t[END_CONTAINER])
				return _traverseSameContainer(how);

			for (c = t[END_CONTAINER], p = c.parentNode; p; c = p, p = p.parentNode) {
				if (p == t[START_CONTAINER])
					return _traverseCommonStartContainer(c, how);

				++endContainerDepth;
			}

			for (c = t[START_CONTAINER], p = c.parentNode; p; c = p, p = p.parentNode) {
				if (p == t[END_CONTAINER])
					return _traverseCommonEndContainer(c, how);

				++startContainerDepth;
			}

			depthDiff = startContainerDepth - endContainerDepth;

			startNode = t[START_CONTAINER];
			while (depthDiff > 0) {
				startNode = startNode.parentNode;
				depthDiff--;
			}

			endNode = t[END_CONTAINER];
			while (depthDiff < 0) {
				endNode = endNode.parentNode;
				depthDiff++;
			}

			// ascend the ancestor hierarchy until we have a common parent.
			for (sp = startNode.parentNode, ep = endNode.parentNode; sp != ep; sp = sp.parentNode, ep = ep.parentNode) {
				startNode = sp;
				endNode = ep;
			}

			return _traverseCommonAncestors(startNode, endNode, how);
		};

		 function _traverseSameContainer(how) {
			var frag, s, sub, n, cnt, sibling, xferNode;

			if (how != DELETE)
				frag = doc.createDocumentFragment();

			// If selection is empty, just return the fragment
			if (t[START_OFFSET] == t[END_OFFSET])
				return frag;

			// Text node needs special case handling
			if (t[START_CONTAINER].nodeType == 3 /* TEXT_NODE */) {
				// get the substring
				s = t[START_CONTAINER].nodeValue;
				sub = s.substring(t[START_OFFSET], t[END_OFFSET]);

				// set the original text node to its new value
				if (how != CLONE) {
					t[START_CONTAINER].deleteData(t[START_OFFSET], t[END_OFFSET] - t[START_OFFSET]);

					// Nothing is partially selected, so collapse to start point
					t.collapse(TRUE);
				}

				if (how == DELETE)
					return;

				frag.appendChild(doc.createTextNode(sub));
				return frag;
			}

			// Copy nodes between the start/end offsets.
			n = _getSelectedNode(t[START_CONTAINER], t[START_OFFSET]);
			cnt = t[END_OFFSET] - t[START_OFFSET];

			while (cnt > 0) {
				sibling = n.nextSibling;
				xferNode = _traverseFullySelected(n, how);

				if (frag)
					frag.appendChild( xferNode );

				--cnt;
				n = sibling;
			}

			// Nothing is partially selected, so collapse to start point
			if (how != CLONE)
				t.collapse(TRUE);

			return frag;
		};

		function _traverseCommonStartContainer(endAncestor, how) {
			var frag, n, endIdx, cnt, sibling, xferNode;

			if (how != DELETE)
				frag = doc.createDocumentFragment();

			n = _traverseRightBoundary(endAncestor, how);

			if (frag)
				frag.appendChild(n);

			endIdx = nodeIndex(endAncestor);
			cnt = endIdx - t[START_OFFSET];

			if (cnt <= 0) {
				// Collapse to just before the endAncestor, which
				// is partially selected.
				if (how != CLONE) {
					t.setEndBefore(endAncestor);
					t.collapse(FALSE);
				}

				return frag;
			}

			n = endAncestor.previousSibling;
			while (cnt > 0) {
				sibling = n.previousSibling;
				xferNode = _traverseFullySelected(n, how);

				if (frag)
					frag.insertBefore(xferNode, frag.firstChild);

				--cnt;
				n = sibling;
			}

			// Collapse to just before the endAncestor, which
			// is partially selected.
			if (how != CLONE) {
				t.setEndBefore(endAncestor);
				t.collapse(FALSE);
			}

			return frag;
		};

		function _traverseCommonEndContainer(startAncestor, how) {
			var frag, startIdx, n, cnt, sibling, xferNode;

			if (how != DELETE)
				frag = doc.createDocumentFragment();

			n = _traverseLeftBoundary(startAncestor, how);
			if (frag)
				frag.appendChild(n);

			startIdx = nodeIndex(startAncestor);
			++startIdx;  // Because we already traversed it....

			cnt = t[END_OFFSET] - startIdx;
			n = startAncestor.nextSibling;
			while (cnt > 0) {
				sibling = n.nextSibling;
				xferNode = _traverseFullySelected(n, how);

				if (frag)
					frag.appendChild(xferNode);

				--cnt;
				n = sibling;
			}

			if (how != CLONE) {
				t.setStartAfter(startAncestor);
				t.collapse(TRUE);
			}

			return frag;
		};

		function _traverseCommonAncestors(startAncestor, endAncestor, how) {
			var n, frag, commonParent, startOffset, endOffset, cnt, sibling, nextSibling;

			if (how != DELETE)
				frag = doc.createDocumentFragment();

			n = _traverseLeftBoundary(startAncestor, how);
			if (frag)
				frag.appendChild(n);

			commonParent = startAncestor.parentNode;
			startOffset = nodeIndex(startAncestor);
			endOffset = nodeIndex(endAncestor);
			++startOffset;

			cnt = endOffset - startOffset;
			sibling = startAncestor.nextSibling;

			while (cnt > 0) {
				nextSibling = sibling.nextSibling;
				n = _traverseFullySelected(sibling, how);

				if (frag)
					frag.appendChild(n);

				sibling = nextSibling;
				--cnt;
			}

			n = _traverseRightBoundary(endAncestor, how);

			if (frag)
				frag.appendChild(n);

			if (how != CLONE) {
				t.setStartAfter(startAncestor);
				t.collapse(TRUE);
			}

			return frag;
		};

		function _traverseRightBoundary(root, how) {
			var next = _getSelectedNode(t[END_CONTAINER], t[END_OFFSET] - 1), parent, clonedParent, prevSibling, clonedChild, clonedGrandParent, isFullySelected = next != t[END_CONTAINER];

			if (next == root)
				return _traverseNode(next, isFullySelected, FALSE, how);

			parent = next.parentNode;
			clonedParent = _traverseNode(parent, FALSE, FALSE, how);

			while (parent) {
				while (next) {
					prevSibling = next.previousSibling;
					clonedChild = _traverseNode(next, isFullySelected, FALSE, how);

					if (how != DELETE)
						clonedParent.insertBefore(clonedChild, clonedParent.firstChild);

					isFullySelected = TRUE;
					next = prevSibling;
				}

				if (parent == root)
					return clonedParent;

				next = parent.previousSibling;
				parent = parent.parentNode;

				clonedGrandParent = _traverseNode(parent, FALSE, FALSE, how);

				if (how != DELETE)
					clonedGrandParent.appendChild(clonedParent);

				clonedParent = clonedGrandParent;
			}
		};

		function _traverseLeftBoundary(root, how) {
			var next = _getSelectedNode(t[START_CONTAINER], t[START_OFFSET]), isFullySelected = next != t[START_CONTAINER], parent, clonedParent, nextSibling, clonedChild, clonedGrandParent;

			if (next == root)
				return _traverseNode(next, isFullySelected, TRUE, how);

			parent = next.parentNode;
			clonedParent = _traverseNode(parent, FALSE, TRUE, how);

			while (parent) {
				while (next) {
					nextSibling = next.nextSibling;
					clonedChild = _traverseNode(next, isFullySelected, TRUE, how);

					if (how != DELETE)
						clonedParent.appendChild(clonedChild);

					isFullySelected = TRUE;
					next = nextSibling;
				}

				if (parent == root)
					return clonedParent;

				next = parent.nextSibling;
				parent = parent.parentNode;

				clonedGrandParent = _traverseNode(parent, FALSE, TRUE, how);

				if (how != DELETE)
					clonedGrandParent.appendChild(clonedParent);

				clonedParent = clonedGrandParent;
			}
		};

		function _traverseNode(n, isFullySelected, isLeft, how) {
			var txtValue, newNodeValue, oldNodeValue, offset, newNode;

			if (isFullySelected)
				return _traverseFullySelected(n, how);

			if (n.nodeType == 3 /* TEXT_NODE */) {
				txtValue = n.nodeValue;

				if (isLeft) {
					offset = t[START_OFFSET];
					newNodeValue = txtValue.substring(offset);
					oldNodeValue = txtValue.substring(0, offset);
				} else {
					offset = t[END_OFFSET];
					newNodeValue = txtValue.substring(0, offset);
					oldNodeValue = txtValue.substring(offset);
				}

				if (how != CLONE)
					n.nodeValue = oldNodeValue;

				if (how == DELETE)
					return;

				newNode = n.cloneNode(FALSE);
				newNode.nodeValue = newNodeValue;

				return newNode;
			}

			if (how == DELETE)
				return;

			return n.cloneNode(FALSE);
		};

		function _traverseFullySelected(n, how) {
			if (how != DELETE)
				return how == CLONE ? n.cloneNode(TRUE) : n;

			n.parentNode.removeChild(n);
		};
	};

	ns.Range = Range;
})(tinymce.dom);

(function() {
	function Selection(selection) {
		var t = this, invisibleChar = '\uFEFF', range, lastIERng, dom = selection.dom, TRUE = true, FALSE = false;

		// Returns a W3C DOM compatible range object by using the IE Range API
		function getRange() {
			var ieRange = selection.getRng(), domRange = dom.createRng(), element, collapsed;

			// If selection is outside the current document just return an empty range
			element = ieRange.item ? ieRange.item(0) : ieRange.parentElement();
			if (element.ownerDocument != dom.doc)
				return domRange;

			// Handle control selection or text selection of a image
			if (ieRange.item || !element.hasChildNodes()) {
				domRange.setStart(element.parentNode, dom.nodeIndex(element));
				domRange.setEnd(domRange.startContainer, domRange.startOffset + 1);

				return domRange;
			}

			collapsed = selection.isCollapsed();

			function findEndPoint(start) {
				var marker, container, offset, nodes, startIndex = 0, endIndex, index, parent, checkRng, position;

				// Setup temp range and collapse it
				checkRng = ieRange.duplicate();
				checkRng.collapse(start);

				// Create marker and insert it at the end of the endpoints parent
				marker = dom.create('a');
				parent = checkRng.parentElement();
				parent.appendChild(marker);

				// Setup node list and endIndex
				nodes = tinymce.grep(parent.childNodes);
				endIndex = nodes.length - 1;

				// Perform a binary search for the position
				while (startIndex <= endIndex) {
					index = Math.floor((startIndex + endIndex) / 2);

					// Insert marker and check it's position relative to the selection
					parent.insertBefore(marker, nodes[index]);
					checkRng.moveToElementText(marker);
					position = ieRange.compareEndPoints(start ? 'StartToStart' : 'EndToEnd', checkRng);

					if (position > 0) {
						// Marker is to the right
						startIndex = index + 1;
					} else if (position < 0) {
						// Marker is to the left
						endIndex = index - 1;
					} else {
						// Maker is where we are
						break;
					}
				}

				// Setup container
				container = position > 0 || index == 0 ? marker.nextSibling : marker.previousSibling;

				// Handle element selection
				if (container.nodeType == 1) {
					dom.remove(marker);

					// Find offset and container
					offset = dom.nodeIndex(container);
					container = container.parentNode;

					// Move the offset if we are setting the end or the position is after an element
					if (!start || index > 0)
						offset++;
				} else {
					// Calculate offset within text node
					if (position > 0 || index == 0) {
						checkRng.setEndPoint(start ? 'StartToStart' : 'EndToEnd', ieRange);
						offset = checkRng.text.length;
					} else {
						checkRng.setEndPoint(start ? 'StartToStart' : 'EndToEnd', ieRange);
						offset = container.nodeValue.length - checkRng.text.length;
					}

					dom.remove(marker);
				}

				domRange[start ? 'setStart' : 'setEnd'](container, offset);
			};

			// Find start point
			findEndPoint(true);

			// Find end point if needed
			if (!collapsed)
				findEndPoint();

			return domRange;
		};

		this.addRange = function(rng) {
			var ieRng, ieRng2, doc = selection.dom.doc, body = doc.body, startPos, endPos, sc, so, ec, eo, marker, lastIndex, skipStart, skipEnd;

			this.destroy();

			// Setup some shorter versions
			sc = rng.startContainer;
			so = rng.startOffset;
			ec = rng.endContainer;
			eo = rng.endOffset;
			ieRng = body.createTextRange();

			// If document selection move caret to first node in document
			if (sc == doc || ec == doc) {
				ieRng = body.createTextRange();
				ieRng.collapse();
				ieRng.select();
				return;
			}

			// If child index resolve it
			if (sc.nodeType == 1 && sc.hasChildNodes()) {
				lastIndex = sc.childNodes.length - 1;

				// Index is higher that the child count then we need to jump over the start container
				if (so > lastIndex) {
					skipStart = 1;
					sc = sc.childNodes[lastIndex];
				} else
					sc = sc.childNodes[so];

				// Child was text node then move offset to start of it
				if (sc.nodeType == 3)
					so = 0;
			}

			// If child index resolve it
			if (ec.nodeType == 1 && ec.hasChildNodes()) {
				lastIndex = ec.childNodes.length - 1;

				if (eo == 0) {
					skipEnd = 1;
					ec = ec.childNodes[0];
				} else {
					ec = ec.childNodes[Math.min(lastIndex, eo - 1)];

					// Child was text node then move offset to end of text node
					if (ec.nodeType == 3)
						eo = ec.nodeValue.length;
				}
			}

			// Single element selection
			if (sc == ec && sc.nodeType == 1) {
				// Make control selection for some elements
				if (/^(IMG|TABLE)$/.test(sc.nodeName) && so != eo) {
					ieRng = body.createControlRange();
					ieRng.addElement(sc);
				} else {
					ieRng = body.createTextRange();

					// Padd empty elements with invisible character
					if (!sc.hasChildNodes() && sc.canHaveHTML)
						sc.innerHTML = invisibleChar;

					// Select element contents
					ieRng.moveToElementText(sc);

					// If it's only containing a padding remove it so the caret remains
					if (sc.innerHTML == invisibleChar) {
						ieRng.collapse(TRUE);
						sc.removeChild(sc.firstChild);
					}
				}

				if (so == eo)
					ieRng.collapse(eo <= rng.endContainer.childNodes.length - 1);

				ieRng.select();
				ieRng.scrollIntoView();
				return;
			}

			// Create range and marker
			ieRng = body.createTextRange();
			marker = doc.createElement('span');
			marker.innerHTML = ' ';

			// Set start of range to startContainer/startOffset
			if (sc.nodeType == 3) {
				// Insert marker after/before startContainer
				if (skipStart)
					dom.insertAfter(marker, sc);
				else
					sc.parentNode.insertBefore(marker, sc);

				// Select marker the caret to offset position
				ieRng.moveToElementText(marker);
				marker.parentNode.removeChild(marker);
				ieRng.move('character', so);
			} else {
				ieRng.moveToElementText(sc);

				if (skipStart)
					ieRng.collapse(FALSE);
			}

			// If same text container then we can do a more simple move
			if (sc == ec && sc.nodeType == 3) {
				ieRng.moveEnd('character', eo - so);
				ieRng.select();
				ieRng.scrollIntoView();
				return;
			}

			// Set end of range to endContainer/endOffset
			ieRng2 = body.createTextRange();
			if (ec.nodeType == 3) {
				// Insert marker after/before startContainer
				ec.parentNode.insertBefore(marker, ec);

				// Move selection to end marker and move caret to end offset
				ieRng2.moveToElementText(marker);
				marker.parentNode.removeChild(marker);
				ieRng2.move('character', eo);
				ieRng.setEndPoint('EndToStart', ieRng2);
			} else {
				ieRng2.moveToElementText(ec);
				ieRng2.collapse(!!skipEnd);
				ieRng.setEndPoint('EndToEnd', ieRng2);
			}

			ieRng.select();
			ieRng.scrollIntoView();
		};

		this.getRangeAt = function() {
			// Setup new range if the cache is empty
			if (!range || !tinymce.dom.RangeUtils.compareRanges(lastIERng, selection.getRng())) {
				range = getRange();

				// Store away text range for next call
				lastIERng = selection.getRng();
			}

			// IE will say that the range is equal then produce an invalid argument exception
			// if you perform specific operations in a keyup event. For example Ctrl+Del.
			// This hack will invalidate the range cache if the exception occurs
			try {
				range.startContainer.nextSibling;
			} catch (ex) {
				range = getRange();
				lastIERng = null;
			}

			// Return cached range
			return range;
		};

		this.destroy = function() {
			// Destroy cached range and last IE range to avoid memory leaks
			lastIERng = range = null;
		};

		// IE has an issue where you can't select/move the caret by clicking outside the body if the document is in standards mode
		if (selection.dom.boxModel) {
			(function() {
				var doc = dom.doc, body = doc.body, started, startRng;

				// Make HTML element unselectable since we are going to handle selection by hand
				doc.documentElement.unselectable = TRUE;

				// Return range from point or null if it failed
				function rngFromPoint(x, y) {
					var rng = body.createTextRange();

					try {
						rng.moveToPoint(x, y);
					} catch (ex) {
						// IE sometimes throws and exception, so lets just ignore it
						rng = null;
					}

					return rng;
				};

				// Fires while the selection is changing
				function selectionChange(e) {
					var pointRng;

					// Check if the button is down or not
					if (e.button) {
						// Create range from mouse position
						pointRng = rngFromPoint(e.x, e.y);

						if (pointRng) {
							// Check if pointRange is before/after selection then change the endPoint
							if (pointRng.compareEndPoints('StartToStart', startRng) > 0)
								pointRng.setEndPoint('StartToStart', startRng);
							else
								pointRng.setEndPoint('EndToEnd', startRng);

							pointRng.select();
						}
					} else
						endSelection();
				}

				// Removes listeners
				function endSelection() {
					dom.unbind(doc, 'mouseup', endSelection);
					dom.unbind(doc, 'mousemove', selectionChange);
					started = 0;
				};

				// Detect when user selects outside BODY
				dom.bind(doc, 'mousedown', function(e) {
					if (e.target.nodeName === 'HTML') {
						if (started)
							endSelection();

						started = 1;

						// Setup start position
						startRng = rngFromPoint(e.x, e.y);
						if (startRng) {
							// Listen for selection change events
							dom.bind(doc, 'mouseup', endSelection);
							dom.bind(doc, 'mousemove', selectionChange);

							startRng.select();
						}
					}
				});
			})();
		}
	};

	// Expose the selection object
	tinymce.dom.TridentSelection = Selection;
})();


/*
 * Sizzle CSS Selector Engine - v1.0
 *  Copyright 2009, The Dojo Foundation
 *  Released under the MIT, BSD, and GPL Licenses.
 *  More information: http://sizzlejs.com/
 */
(function(){

var chunker = /((?:\((?:\([^()]+\)|[^()]+)+\)|\[(?:\[[^[\]]*\]|['"][^'"]*['"]|[^[\]'"]+)+\]|\\.|[^ >+~,(\[\\]+)+|[>+~])(\s*,\s*)?/g,
	done = 0,
	toString = Object.prototype.toString,
	hasDuplicate = false;

var Sizzle = function(selector, context, results, seed) {
	results = results || [];
	var origContext = context = context || document;

	if ( context.nodeType !== 1 && context.nodeType !== 9 ) {
		return [];
	}
	
	if ( !selector || typeof selector !== "string" ) {
		return results;
	}

	var parts = [], m, set, checkSet, check, mode, extra, prune = true, contextXML = isXML(context);
	
	// Reset the position of the chunker regexp (start from head)
	chunker.lastIndex = 0;
	
	while ( (m = chunker.exec(selector)) !== null ) {
		parts.push( m[1] );
		
		if ( m[2] ) {
			extra = RegExp.rightContext;
			break;
		}
	}

	if ( parts.length > 1 && origPOS.exec( selector ) ) {
		if ( parts.length === 2 && Expr.relative[ parts[0] ] ) {
			set = posProcess( parts[0] + parts[1], context );
		} else {
			set = Expr.relative[ parts[0] ] ?
				[ context ] :
				Sizzle( parts.shift(), context );

			while ( parts.length ) {
				selector = parts.shift();

				if ( Expr.relative[ selector ] )
					selector += parts.shift();

				set = posProcess( selector, set );
			}
		}
	} else {
		// Take a shortcut and set the context if the root selector is an ID
		// (but not if it'll be faster if the inner selector is an ID)
		if ( !seed && parts.length > 1 && context.nodeType === 9 && !contextXML &&
				Expr.match.ID.test(parts[0]) && !Expr.match.ID.test(parts[parts.length - 1]) ) {
			var ret = Sizzle.find( parts.shift(), context, contextXML );
			context = ret.expr ? Sizzle.filter( ret.expr, ret.set )[0] : ret.set[0];
		}

		if ( context ) {
			var ret = seed ?
				{ expr: parts.pop(), set: makeArray(seed) } :
				Sizzle.find( parts.pop(), parts.length === 1 && (parts[0] === "~" || parts[0] === "+") && context.parentNode ? context.parentNode : context, contextXML );
			set = ret.expr ? Sizzle.filter( ret.expr, ret.set ) : ret.set;

			if ( parts.length > 0 ) {
				checkSet = makeArray(set);
			} else {
				prune = false;
			}

			while ( parts.length ) {
				var cur = parts.pop(), pop = cur;

				if ( !Expr.relative[ cur ] ) {
					cur = "";
				} else {
					pop = parts.pop();
				}

				if ( pop == null ) {
					pop = context;
				}

				Expr.relative[ cur ]( checkSet, pop, contextXML );
			}
		} else {
			checkSet = parts = [];
		}
	}

	if ( !checkSet ) {
		checkSet = set;
	}

	if ( !checkSet ) {
		throw "Syntax error, unrecognized expression: " + (cur || selector);
	}

	if ( toString.call(checkSet) === "[object Array]" ) {
		if ( !prune ) {
			results.push.apply( results, checkSet );
		} else if ( context && context.nodeType === 1 ) {
			for ( var i = 0; checkSet[i] != null; i++ ) {
				if ( checkSet[i] && (checkSet[i] === true || checkSet[i].nodeType === 1 && contains(context, checkSet[i])) ) {
					results.push( set[i] );
				}
			}
		} else {
			for ( var i = 0; checkSet[i] != null; i++ ) {
				if ( checkSet[i] && checkSet[i].nodeType === 1 ) {
					results.push( set[i] );
				}
			}
		}
	} else {
		makeArray( checkSet, results );
	}

	if ( extra ) {
		Sizzle( extra, origContext, results, seed );
		Sizzle.uniqueSort( results );
	}

	return results;
};

Sizzle.uniqueSort = function(results){
	if ( sortOrder ) {
		hasDuplicate = false;
		results.sort(sortOrder);

		if ( hasDuplicate ) {
			for ( var i = 1; i < results.length; i++ ) {
				if ( results[i] === results[i-1] ) {
					results.splice(i--, 1);
				}
			}
		}
	}
};

Sizzle.matches = function(expr, set){
	return Sizzle(expr, null, null, set);
};

Sizzle.find = function(expr, context, isXML){
	var set, match;

	if ( !expr ) {
		return [];
	}

	for ( var i = 0, l = Expr.order.length; i < l; i++ ) {
		var type = Expr.order[i], match;
		
		if ( (match = Expr.match[ type ].exec( expr )) ) {
			var left = RegExp.leftContext;

			if ( left.substr( left.length - 1 ) !== "\\" ) {
				match[1] = (match[1] || "").replace(/\\/g, "");
				set = Expr.find[ type ]( match, context, isXML );
				if ( set != null ) {
					expr = expr.replace( Expr.match[ type ], "" );
					break;
				}
			}
		}
	}

	if ( !set ) {
		set = context.getElementsByTagName("*");
	}

	return {set: set, expr: expr};
};

Sizzle.filter = function(expr, set, inplace, not){
	var old = expr, result = [], curLoop = set, match, anyFound,
		isXMLFilter = set && set[0] && isXML(set[0]);

	while ( expr && set.length ) {
		for ( var type in Expr.filter ) {
			if ( (match = Expr.match[ type ].exec( expr )) != null ) {
				var filter = Expr.filter[ type ], found, item;
				anyFound = false;

				if ( curLoop == result ) {
					result = [];
				}

				if ( Expr.preFilter[ type ] ) {
					match = Expr.preFilter[ type ]( match, curLoop, inplace, result, not, isXMLFilter );

					if ( !match ) {
						anyFound = found = true;
					} else if ( match === true ) {
						continue;
					}
				}

				if ( match ) {
					for ( var i = 0; (item = curLoop[i]) != null; i++ ) {
						if ( item ) {
							found = filter( item, match, i, curLoop );
							var pass = not ^ !!found;

							if ( inplace && found != null ) {
								if ( pass ) {
									anyFound = true;
								} else {
									curLoop[i] = false;
								}
							} else if ( pass ) {
								result.push( item );
								anyFound = true;
							}
						}
					}
				}

				if ( found !== undefined ) {
					if ( !inplace ) {
						curLoop = result;
					}

					expr = expr.replace( Expr.match[ type ], "" );

					if ( !anyFound ) {
						return [];
					}

					break;
				}
			}
		}

		// Improper expression
		if ( expr == old ) {
			if ( anyFound == null ) {
				throw "Syntax error, unrecognized expression: " + expr;
			} else {
				break;
			}
		}

		old = expr;
	}

	return curLoop;
};

var Expr = Sizzle.selectors = {
	order: [ "ID", "NAME", "TAG" ],
	match: {
		ID: /#((?:[\w\u00c0-\uFFFF_-]|\\.)+)/,
		CLASS: /\.((?:[\w\u00c0-\uFFFF_-]|\\.)+)/,
		NAME: /\[name=['"]*((?:[\w\u00c0-\uFFFF_-]|\\.)+)['"]*\]/,
		ATTR: /\[\s*((?:[\w\u00c0-\uFFFF_-]|\\.)+)\s*(?:(\S?=)\s*(['"]*)(.*?)\3|)\s*\]/,
		TAG: /^((?:[\w\u00c0-\uFFFF\*_-]|\\.)+)/,
		CHILD: /:(only|nth|last|first)-child(?:\((even|odd|[\dn+-]*)\))?/,
		POS: /:(nth|eq|gt|lt|first|last|even|odd)(?:\((\d*)\))?(?=[^-]|$)/,
		PSEUDO: /:((?:[\w\u00c0-\uFFFF_-]|\\.)+)(?:\((['"]*)((?:\([^\)]+\)|[^\2\(\)]*)+)\2\))?/
	},
	attrMap: {
		"class": "className",
		"for": "htmlFor"
	},
	attrHandle: {
		href: function(elem){
			return elem.getAttribute("href");
		}
	},
	relative: {
		"+": function(checkSet, part, isXML){
			var isPartStr = typeof part === "string",
				isTag = isPartStr && !/\W/.test(part),
				isPartStrNotTag = isPartStr && !isTag;

			if ( isTag && !isXML ) {
				part = part.toUpperCase();
			}

			for ( var i = 0, l = checkSet.length, elem; i < l; i++ ) {
				if ( (elem = checkSet[i]) ) {
					while ( (elem = elem.previousSibling) && elem.nodeType !== 1 ) {}

					checkSet[i] = isPartStrNotTag || elem && elem.nodeName === part ?
						elem || false :
						elem === part;
				}
			}

			if ( isPartStrNotTag ) {
				Sizzle.filter( part, checkSet, true );
			}
		},
		">": function(checkSet, part, isXML){
			var isPartStr = typeof part === "string";

			if ( isPartStr && !/\W/.test(part) ) {
				part = isXML ? part : part.toUpperCase();

				for ( var i = 0, l = checkSet.length; i < l; i++ ) {
					var elem = checkSet[i];
					if ( elem ) {
						var parent = elem.parentNode;
						checkSet[i] = parent.nodeName === part ? parent : false;
					}
				}
			} else {
				for ( var i = 0, l = checkSet.length; i < l; i++ ) {
					var elem = checkSet[i];
					if ( elem ) {
						checkSet[i] = isPartStr ?
							elem.parentNode :
							elem.parentNode === part;
					}
				}

				if ( isPartStr ) {
					Sizzle.filter( part, checkSet, true );
				}
			}
		},
		"": function(checkSet, part, isXML){
			var doneName = done++, checkFn = dirCheck;

			if ( !part.match(/\W/) ) {
				var nodeCheck = part = isXML ? part : part.toUpperCase();
				checkFn = dirNodeCheck;
			}

			checkFn("parentNode", part, doneName, checkSet, nodeCheck, isXML);
		},
		"~": function(checkSet, part, isXML){
			var doneName = done++, checkFn = dirCheck;

			if ( typeof part === "string" && !part.match(/\W/) ) {
				var nodeCheck = part = isXML ? part : part.toUpperCase();
				checkFn = dirNodeCheck;
			}

			checkFn("previousSibling", part, doneName, checkSet, nodeCheck, isXML);
		}
	},
	find: {
		ID: function(match, context, isXML){
			if ( typeof context.getElementById !== "undefined" && !isXML ) {
				var m = context.getElementById(match[1]);
				return m ? [m] : [];
			}
		},
		NAME: function(match, context, isXML){
			if ( typeof context.getElementsByName !== "undefined" ) {
				var ret = [], results = context.getElementsByName(match[1]);

				for ( var i = 0, l = results.length; i < l; i++ ) {
					if ( results[i].getAttribute("name") === match[1] ) {
						ret.push( results[i] );
					}
				}

				return ret.length === 0 ? null : ret;
			}
		},
		TAG: function(match, context){
			return context.getElementsByTagName(match[1]);
		}
	},
	preFilter: {
		CLASS: function(match, curLoop, inplace, result, not, isXML){
			match = " " + match[1].replace(/\\/g, "") + " ";

			if ( isXML ) {
				return match;
			}

			for ( var i = 0, elem; (elem = curLoop[i]) != null; i++ ) {
				if ( elem ) {
					if ( not ^ (elem.className && (" " + elem.className + " ").indexOf(match) >= 0) ) {
						if ( !inplace )
							result.push( elem );
					} else if ( inplace ) {
						curLoop[i] = false;
					}
				}
			}

			return false;
		},
		ID: function(match){
			return match[1].replace(/\\/g, "");
		},
		TAG: function(match, curLoop){
			for ( var i = 0; curLoop[i] === false; i++ ){}
			return curLoop[i] && isXML(curLoop[i]) ? match[1] : match[1].toUpperCase();
		},
		CHILD: function(match){
			if ( match[1] == "nth" ) {
				// parse equations like 'even', 'odd', '5', '2n', '3n+2', '4n-1', '-n+6'
				var test = /(-?)(\d*)n((?:\+|-)?\d*)/.exec(
					match[2] == "even" && "2n" || match[2] == "odd" && "2n+1" ||
					!/\D/.test( match[2] ) && "0n+" + match[2] || match[2]);

				// calculate the numbers (first)n+(last) including if they are negative
				match[2] = (test[1] + (test[2] || 1)) - 0;
				match[3] = test[3] - 0;
			}

			// TODO: Move to normal caching system
			match[0] = done++;

			return match;
		},
		ATTR: function(match, curLoop, inplace, result, not, isXML){
			var name = match[1].replace(/\\/g, "");
			
			if ( !isXML && Expr.attrMap[name] ) {
				match[1] = Expr.attrMap[name];
			}

			if ( match[2] === "~=" ) {
				match[4] = " " + match[4] + " ";
			}

			return match;
		},
		PSEUDO: function(match, curLoop, inplace, result, not){
			if ( match[1] === "not" ) {
				// If we're dealing with a complex expression, or a simple one
				if ( match[3].match(chunker).length > 1 || /^\w/.test(match[3]) ) {
					match[3] = Sizzle(match[3], null, null, curLoop);
				} else {
					var ret = Sizzle.filter(match[3], curLoop, inplace, true ^ not);
					if ( !inplace ) {
						result.push.apply( result, ret );
					}
					return false;
				}
			} else if ( Expr.match.POS.test( match[0] ) || Expr.match.CHILD.test( match[0] ) ) {
				return true;
			}
			
			return match;
		},
		POS: function(match){
			match.unshift( true );
			return match;
		}
	},
	filters: {
		enabled: function(elem){
			return elem.disabled === false && elem.type !== "hidden";
		},
		disabled: function(elem){
			return elem.disabled === true;
		},
		checked: function(elem){
			return elem.checked === true;
		},
		selected: function(elem){
			// Accessing this property makes selected-by-default
			// options in Safari work properly
			elem.parentNode.selectedIndex;
			return elem.selected === true;
		},
		parent: function(elem){
			return !!elem.firstChild;
		},
		empty: function(elem){
			return !elem.firstChild;
		},
		has: function(elem, i, match){
			return !!Sizzle( match[3], elem ).length;
		},
		header: function(elem){
			return /h\d/i.test( elem.nodeName );
		},
		text: function(elem){
			return "text" === elem.type;
		},
		radio: function(elem){
			return "radio" === elem.type;
		},
		checkbox: function(elem){
			return "checkbox" === elem.type;
		},
		file: function(elem){
			return "file" === elem.type;
		},
		password: function(elem){
			return "password" === elem.type;
		},
		submit: function(elem){
			return "submit" === elem.type;
		},
		image: function(elem){
			return "image" === elem.type;
		},
		reset: function(elem){
			return "reset" === elem.type;
		},
		button: function(elem){
			return "button" === elem.type || elem.nodeName.toUpperCase() === "BUTTON";
		},
		input: function(elem){
			return /input|select|textarea|button/i.test(elem.nodeName);
		}
	},
	setFilters: {
		first: function(elem, i){
			return i === 0;
		},
		last: function(elem, i, match, array){
			return i === array.length - 1;
		},
		even: function(elem, i){
			return i % 2 === 0;
		},
		odd: function(elem, i){
			return i % 2 === 1;
		},
		lt: function(elem, i, match){
			return i < match[3] - 0;
		},
		gt: function(elem, i, match){
			return i > match[3] - 0;
		},
		nth: function(elem, i, match){
			return match[3] - 0 == i;
		},
		eq: function(elem, i, match){
			return match[3] - 0 == i;
		}
	},
	filter: {
		PSEUDO: function(elem, match, i, array){
			var name = match[1], filter = Expr.filters[ name ];

			if ( filter ) {
				return filter( elem, i, match, array );
			} else if ( name === "contains" ) {
				return (elem.textContent || elem.innerText || "").indexOf(match[3]) >= 0;
			} else if ( name === "not" ) {
				var not = match[3];

				for ( var i = 0, l = not.length; i < l; i++ ) {
					if ( not[i] === elem ) {
						return false;
					}
				}

				return true;
			}
		},
		CHILD: function(elem, match){
			var type = match[1], node = elem;
			switch (type) {
				case 'only':
				case 'first':
					while (node = node.previousSibling)  {
						if ( node.nodeType === 1 ) return false;
					}
					if ( type == 'first') return true;
					node = elem;
				case 'last':
					while (node = node.nextSibling)  {
						if ( node.nodeType === 1 ) return false;
					}
					return true;
				case 'nth':
					var first = match[2], last = match[3];

					if ( first == 1 && last == 0 ) {
						return true;
					}
					
					var doneName = match[0],
						parent = elem.parentNode;
	
					if ( parent && (parent.sizcache !== doneName || !elem.nodeIndex) ) {
						var count = 0;
						for ( node = parent.firstChild; node; node = node.nextSibling ) {
							if ( node.nodeType === 1 ) {
								node.nodeIndex = ++count;
							}
						} 
						parent.sizcache = doneName;
					}
					
					var diff = elem.nodeIndex - last;
					if ( first == 0 ) {
						return diff == 0;
					} else {
						return ( diff % first == 0 && diff / first >= 0 );
					}
			}
		},
		ID: function(elem, match){
			return elem.nodeType === 1 && elem.getAttribute("id") === match;
		},
		TAG: function(elem, match){
			return (match === "*" && elem.nodeType === 1) || elem.nodeName === match;
		},
		CLASS: function(elem, match){
			return (" " + (elem.className || elem.getAttribute("class")) + " ")
				.indexOf( match ) > -1;
		},
		ATTR: function(elem, match){
			var name = match[1],
				result = Expr.attrHandle[ name ] ?
					Expr.attrHandle[ name ]( elem ) :
					elem[ name ] != null ?
						elem[ name ] :
						elem.getAttribute( name ),
				value = result + "",
				type = match[2],
				check = match[4];

			return result == null ?
				type === "!=" :
				type === "=" ?
				value === check :
				type === "*=" ?
				value.indexOf(check) >= 0 :
				type === "~=" ?
				(" " + value + " ").indexOf(check) >= 0 :
				!check ?
				value && result !== false :
				type === "!=" ?
				value != check :
				type === "^=" ?
				value.indexOf(check) === 0 :
				type === "$=" ?
				value.substr(value.length - check.length) === check :
				type === "|=" ?
				value === check || value.substr(0, check.l