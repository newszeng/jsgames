/*!For license information please see main.6e9c3629.js.LICENSE.txt*/ ! function() {
	var e = {
			725: function(e) {
				"use strict";
				var t = Object.getOwnPropertySymbols,
					n = Object.prototype.hasOwnProperty,
					r = Object.prototype.propertyIsEnumerable;
				e.exports = function() {
					try {
						if (!Object.assign) return !1;
						var e = new String("abc");
						if (e[5] = "de", "5" === Object.getOwnPropertyNames(e)[0]) return !1;
						for (var t = {}, n = 0; n < 10; n++) t["_" + String.fromCharCode(n)] = n;
						if ("0123456789" !== Object.getOwnPropertyNames(t).map((function(e) {
								return t[e]
							})).join("")) return !1;
						var r = {};
						return "abcdefghijklmnopqrst".split("").forEach((function(e) {
							r[e] = e
						})), "abcdefghijklmnopqrst" === Object.keys(Object.assign({}, r)).join("")
					} catch (l) {
						return !1
					}
				}() ? Object.assign : function(e, l) {
					for (var a, o, i = function(e) {
							if (null === e || void 0 === e) throw new TypeError("Object.assign cannot be called with null or undefined");
							return Object(e)
						}(e), u = 1; u < arguments.length; u++) {
						for (var s in a = Object(arguments[u])) n.call(a, s) && (i[s] = a[s]);
						if (t) {
							o = t(a);
							for (var c = 0; c < o.length; c++) r.call(a, o[c]) && (i[o[c]] = a[o[c]])
						}
					}
					return i
				}
			},
			888: function(e, t, n) {
				"use strict";
				var r = n(47);

				function l() {}

				function a() {}
				a.resetWarningCache = l, e.exports = function() {
					function e(e, t, n, l, a, o) {
						if (o !== r) {
							var i = new Error("Calling PropTypes validators directly is not supported by the `prop-types` package. Use PropTypes.checkPropTypes() to call them. Read more at http://fb.me/use-check-prop-types");
							throw i.name = "Invariant Violation", i
						}
					}

					function t() {
						return e
					}
					e.isRequired = e;
					var n = {
						array: e,
						bigint: e,
						bool: e,
						func: e,
						number: e,
						object: e,
						string: e,
						symbol: e,
						any: e,
						arrayOf: t,
						element: e,
						elementType: e,
						instanceOf: t,
						node: e,
						objectOf: t,
						oneOf: t,
						oneOfType: t,
						shape: t,
						exact: t,
						checkPropTypes: a,
						resetWarningCache: l
					};
					return n.PropTypes = n, n
				}
			},
			7: function(e, t, n) {
				e.exports = n(888)()
			},
			47: function(e) {
				"use strict";
				e.exports = "SECRET_DO_NOT_PASS_THIS_OR_YOU_WILL_BE_FIRED"
			},
			463: function(e, t, n) {
				"use strict";
				var r = n(791),
					l = n(296);

				function a(e) {
					for (var t = "https://reactjs.org/docs/error-decoder.html?invariant=" + e, n = 1; n < arguments.length; n++) t += "&args[]=" + encodeURIComponent(arguments[n]);
					return "Minified React error #" + e + "; visit " + t + " for the full message or use the non-minified dev environment for full errors and additional helpful warnings."
				}
				var o = new Set,
					i = {};

				function u(e, t) {
					s(e, t), s(e + "Capture", t)
				}

				function s(e, t) {
					for (i[e] = t, e = 0; e < t.length; e++) o.add(t[e])
				}
				var c = !("undefined" === typeof window || "undefined" === typeof window.document || "undefined" === typeof window.document.createElement),
					f = Object.prototype.hasOwnProperty,
					d = /^[:A-Z_a-z\u00C0-\u00D6\u00D8-\u00F6\u00F8-\u02FF\u0370-\u037D\u037F-\u1FFF\u200C-\u200D\u2070-\u218F\u2C00-\u2FEF\u3001-\uD7FF\uF900-\uFDCF\uFDF0-\uFFFD][:A-Z_a-z\u00C0-\u00D6\u00D8-\u00F6\u00F8-\u02FF\u0370-\u037D\u037F-\u1FFF\u200C-\u200D\u2070-\u218F\u2C00-\u2FEF\u3001-\uD7FF\uF900-\uFDCF\uFDF0-\uFFFD\-.0-9\u00B7\u0300-\u036F\u203F-\u2040]*$/,
					E = {},
					m = {};

				function p(e, t, n, r, l, a, o) {
					this.acceptsBooleans = 2 === t || 3 === t || 4 === t, this.attributeName = r, this.attributeNamespace = l, this.mustUseProperty = n, this.propertyName = e, this.type = t, this.sanitizeURL = a, this.removeEmptyString = o
				}
				var S = {};
				"children dangerouslySetInnerHTML defaultValue defaultChecked innerHTML suppressContentEditableWarning suppressHydrationWarning style".split(" ").forEach((function(e) {
					S[e] = new p(e, 0, !1, e, null, !1, !1)
				})), [
					["acceptCharset", "accept-charset"],
					["className", "class"],
					["htmlFor", "for"],
					["httpEquiv", "http-equiv"]
				].forEach((function(e) {
					var t = e[0];
					S[t] = new p(t, 1, !1, e[1], null, !1, !1)
				})), ["contentEditable", "draggable", "spellCheck", "value"].forEach((function(e) {
					S[e] = new p(e, 2, !1, e.toLowerCase(), null, !1, !1)
				})), ["autoReverse", "externalResourcesRequired", "focusable", "preserveAlpha"].forEach((function(e) {
					S[e] = new p(e, 2, !1, e, null, !1, !1)
				})), "allowFullScreen async autoFocus autoPlay controls default defer disabled disablePictureInPicture disableRemotePlayback formNoValidate hidden loop noModule noValidate open playsInline readOnly required reversed scoped seamless itemScope".split(" ").forEach((function(e) {
					S[e] = new p(e, 3, !1, e.toLowerCase(), null, !1, !1)
				})), ["checked", "multiple", "muted", "selected"].forEach((function(e) {
					S[e] = new p(e, 3, !0, e, null, !1, !1)
				})), ["capture", "download"].forEach((function(e) {
					S[e] = new p(e, 4, !1, e, null, !1, !1)
				})), ["cols", "rows", "size", "span"].forEach((function(e) {
					S[e] = new p(e, 6, !1, e, null, !1, !1)
				})), ["rowSpan", "start"].forEach((function(e) {
					S[e] = new p(e, 5, !1, e.toLowerCase(), null, !1, !1)
				}));
				var A = /[\-:]([a-z])/g;

				function O(e) {
					return e[1].toUpperCase()
				}

				function R(e, t, n, r) {
					var l = S.hasOwnProperty(t) ? S[t] : null;
					(null !== l ? 0 !== l.type : r || !(2 < t.length) || "o" !== t[0] && "O" !== t[0] || "n" !== t[1] && "N" !== t[1]) && (function(e, t, n, r) {
						if (null === t || "undefined" === typeof t || function(e, t, n, r) {
								if (null !== n && 0 === n.type) return !1;
								switch (typeof t) {
									case "function":
									case "symbol":
										return !0;
									case "boolean":
										return !r && (null !== n ? !n.acceptsBooleans : "data-" !== (e = e.toLowerCase().slice(0, 5)) && "aria-" !== e);
									default:
										return !1
								}
							}(e, t, n, r)) return !0;
						if (r) return !1;
						if (null !== n) switch (n.type) {
							case 3:
								return !t;
							case 4:
								return !1 === t;
							case 5:
								return isNaN(t);
							case 6:
								return isNaN(t) || 1 > t
						}
						return !1
					}(t, n, l, r) && (n = null), r || null === l ? function(e) {
						return !!f.call(m, e) || !f.call(E, e) && (d.test(e) ? m[e] = !0 : (E[e] = !0, !1))
					}(t) && (null === n ? e.removeAttribute(t) : e.setAttribute(t, "" + n)) : l.mustUseProperty ? e[l.propertyName] = null === n ? 3 !== l.type && "" : n : (t = l.attributeName, r = l.attributeNamespace, null === n ? e.removeAttribute(t) : (n = 3 === (l = l.type) || 4 === l && !0 === n ? "" : "" + n, r ? e.setAttributeNS(r, t, n) : e.setAttribute(t, n))))
				}
				"accent-height alignment-baseline arabic-form baseline-shift cap-height clip-path clip-rule color-interpolation color-interpolation-filters color-profile color-rendering dominant-baseline enable-background fill-opacity fill-rule flood-color flood-opacity font-family font-size font-size-adjust font-stretch font-style font-variant font-weight glyph-name glyph-orientation-horizontal glyph-orientation-vertical horiz-adv-x horiz-origin-x image-rendering letter-spacing lighting-color marker-end marker-mid marker-start overline-position overline-thickness paint-order panose-1 pointer-events rendering-intent shape-rendering stop-color stop-opacity strikethrough-position strikethrough-thickness stroke-dasharray stroke-dashoffset stroke-linecap stroke-linejoin stroke-miterlimit stroke-opacity stroke-width text-anchor text-decoration text-rendering underline-position underline-thickness unicode-bidi unicode-range units-per-em v-alphabetic v-hanging v-ideographic v-mathematical vector-effect vert-adv-y vert-origin-x vert-origin-y word-spacing writing-mode xmlns:xlink x-height".split(" ").forEach((function(e) {
					var t = e.replace(A, O);
					S[t] = new p(t, 1, !1, e, null, !1, !1)
				})), "xlink:actuate xlink:arcrole xlink:role xlink:show xlink:title xlink:type".split(" ").forEach((function(e) {
					var t = e.replace(A, O);
					S[t] = new p(t, 1, !1, e, "http://www.w3.org/1999/xlink", !1, !1)
				})), ["xml:base", "xml:lang", "xml:space"].forEach((function(e) {
					var t = e.replace(A, O);
					S[t] = new p(t, 1, !1, e, "http://www.w3.org/XML/1998/namespace", !1, !1)
				})), ["tabIndex", "crossOrigin"].forEach((function(e) {
					S[e] = new p(e, 1, !1, e.toLowerCase(), null, !1, !1)
				})), S.xlinkHref = new p("xlinkHref", 1, !1, "xlink:href", "http://www.w3.org/1999/xlink", !0, !1), ["src", "href", "action", "formAction"].forEach((function(e) {
					S[e] = new p(e, 1, !1, e.toLowerCase(), null, !0, !0)
				}));
				var T = r.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED,
					N = Symbol.for("react.element"),
					I = Symbol.for("react.portal"),
					v = Symbol.for("react.fragment"),
					h = Symbol.for("react.strict_mode"),
					g = Symbol.for("react.profiler"),
					b = Symbol.for("react.provider"),
					C = Symbol.for("react.context"),
					L = Symbol.for("react.forward_ref"),
					y = Symbol.for("react.suspense"),
					P = Symbol.for("react.suspense_list"),
					M = Symbol.for("react.memo"),
					U = Symbol.for("react.lazy");
				Symbol.for("react.scope"), Symbol.for("react.debug_trace_mode");
				var D = Symbol.for("react.offscreen");
				Symbol.for("react.legacy_hidden"), Symbol.for("react.cache"), Symbol.for("react.tracing_marker");
				var H = Symbol.iterator;

				function w(e) {
					return null === e || "object" !== typeof e ? null : "function" === typeof(e = H && e[H] || e["@@iterator"]) ? e : null
				}
				var G, k = Object.assign;

				function B(e) {
					if (void 0 === G) try {
						throw Error()
					} catch (n) {
						var t = n.stack.trim().match(/\n( *(at )?)/);
						G = t && t[1] || ""
					}
					return "\n" + G + e
				}
				var x = !1;

				function F(e, t) {
					if (!e || x) return "";
					x = !0;
					var n = Error.prepareStackTrace;
					Error.prepareStackTrace = void 0;
					try {
						if (t)
							if (t = function() {
									throw Error()
								}, Object.defineProperty(t.prototype, "props", {
									set: function() {
										throw Error()
									}
								}), "object" === typeof Reflect && Reflect.construct) {
								try {
									Reflect.construct(t, [])
								} catch (s) {
									var r = s
								}
								Reflect.construct(e, [], t)
							} else {
								try {
									t.call()
								} catch (s) {
									r = s
								}
								e.call(t.prototype)
							}
						else {
							try {
								throw Error()
							} catch (s) {
								r = s
							}
							e()
						}
					} catch (s) {
						if (s && r && "string" === typeof s.stack) {
							for (var l = s.stack.split("\n"), a = r.stack.split("\n"), o = l.length - 1, i = a.length - 1; 1 <= o && 0 <= i && l[o] !== a[i];) i--;
							for (; 1 <= o && 0 <= i; o--, i--)
								if (l[o] !== a[i]) {
									if (1 !== o || 1 !== i)
										do {
											if (o--, 0 > --i || l[o] !== a[i]) {
												var u = "\n" + l[o].replace(" at new ", " at ");
												return e.displayName && u.includes("<anonymous>") && (u = u.replace("<anonymous>", e.displayName)), u
											}
										} while (1 <= o && 0 <= i);
									break
								}
						}
					} finally {
						x = !1, Error.prepareStackTrace = n
					}
					return (e = e ? e.displayName || e.name : "") ? B(e) : ""
				}

				function Y(e) {
					switch (e.tag) {
						case 5:
							return B(e.type);
						case 16:
							return B("Lazy");
						case 13:
							return B("Suspense");
						case 19:
							return B("SuspenseList");
						case 0:
						case 2:
						case 15:
							return e = F(e.type, !1);
						case 11:
							return e = F(e.type.render, !1);
						case 1:
							return e = F(e.type, !0);
						default:
							return ""
					}
				}

				function _(e) {
					if (null == e) return null;
					if ("function" === typeof e) return e.displayName || e.name || null;
					if ("string" === typeof e) return e;
					switch (e) {
						case v:
							return "Fragment";
						case I:
							return "Portal";
						case g:
							return "Profiler";
						case h:
							return "StrictMode";
						case y:
							return "Suspense";
						case P:
							return "SuspenseList"
					}
					if ("object" === typeof e) switch (e.$$typeof) {
						case C:
							return (e.displayName || "Context") + ".Consumer";
						case b:
							return (e._context.displayName || "Context") + ".Provider";
						case L:
							var t = e.render;
							return (e = e.displayName) || (e = "" !== (e = t.displayName || t.name || "") ? "ForwardRef(" + e + ")" : "ForwardRef"), e;
						case M:
							return null !== (t = e.displayName || null) ? t : _(e.type) || "Memo";
						case U:
							t = e._payload, e = e._init;
							try {
								return _(e(t))
							} catch (n) {}
					}
					return null
				}

				function K(e) {
					var t = e.type;
					switch (e.tag) {
						case 24:
							return "Cache";
						case 9:
							return (t.displayName || "Context") + ".Consumer";
						case 10:
							return (t._context.displayName || "Context") + ".Provider";
						case 18:
							return "DehydratedFragment";
						case 11:
							return e = (e = t.render).displayName || e.name || "", t.displayName || ("" !== e ? "ForwardRef(" + e + ")" : "ForwardRef");
						case 7:
							return "Fragment";
						case 5:
							return t;
						case 4:
							return "Portal";
						case 3:
							return "Root";
						case 6:
							return "Text";
						case 16:
							return _(t);
						case 8:
							return t === h ? "StrictMode" : "Mode";
						case 22:
							return "Offscreen";
						case 12:
							return "Profiler";
						case 21:
							return "Scope";
						case 13:
							return "Suspense";
						case 19:
							return "SuspenseList";
						case 25:
							return "TracingMarker";
						case 1:
						case 0:
						case 17:
						case 2:
						case 14:
						case 15:
							if ("function" === typeof t) return t.displayName || t.name || null;
							if ("string" === typeof t) return t
					}
					return null
				}

				function W(e) {
					switch (typeof e) {
						case "boolean":
						case "number":
						case "string":
						case "undefined":
						case "object":
							return e;
						default:
							return ""
					}
				}

				function j(e) {
					var t = e.type;
					return (e = e.nodeName) && "input" === e.toLowerCase() && ("checkbox" === t || "radio" === t)
				}

				function V(e) {
					e._valueTracker || (e._valueTracker = function(e) {
						var t = j(e) ? "checked" : "value",
							n = Object.getOwnPropertyDescriptor(e.constructor.prototype, t),
							r = "" + e[t];
						if (!e.hasOwnProperty(t) && "undefined" !== typeof n && "function" === typeof n.get && "function" === typeof n.set) {
							var l = n.get,
								a = n.set;
							return Object.defineProperty(e, t, {
								configurable: !0,
								get: function() {
									return l.call(this)
								},
								set: function(e) {
									r = "" + e, a.call(this, e)
								}
							}), Object.defineProperty(e, t, {
								enumerable: n.enumerable
							}), {
								getValue: function() {
									return r
								},
								setValue: function(e) {
									r = "" + e
								},
								stopTracking: function() {
									e._valueTracker = null, delete e[t]
								}
							}
						}
					}(e))
				}

				function z(e) {
					if (!e) return !1;
					var t = e._valueTracker;
					if (!t) return !0;
					var n = t.getValue(),
						r = "";
					return e && (r = j(e) ? e.checked ? "true" : "false" : e.value), (e = r) !== n && (t.setValue(e), !0)
				}

				function Q(e) {
					if ("undefined" === typeof(e = e || ("undefined" !== typeof document ? document : void 0))) return null;
					try {
						return e.activeElement || e.body
					} catch (t) {
						return e.body
					}
				}

				function J(e, t) {
					var n = t.checked;
					return k({}, t, {
						defaultChecked: void 0,
						defaultValue: void 0,
						value: void 0,
						checked: null != n ? n : e._wrapperState.initialChecked
					})
				}

				function Z(e, t) {
					var n = null == t.defaultValue ? "" : t.defaultValue,
						r = null != t.checked ? t.checked : t.defaultChecked;
					n = W(null != t.value ? t.value : n), e._wrapperState = {
						initialChecked: r,
						initialValue: n,
						controlled: "checkbox" === t.type || "radio" === t.type ? null != t.checked : null != t.value
					}
				}

				function $(e, t) {
					null != (t = t.checked) && R(e, "checked", t, !1)
				}

				function X(e, t) {
					$(e, t);
					var n = W(t.value),
						r = t.type;
					if (null != n) "number" === r ? (0 === n && "" === e.value || e.value != n) && (e.value = "" + n) : e.value !== "" + n && (e.value = "" + n);
					else if ("submit" === r || "reset" === r) return void e.removeAttribute("value");
					t.hasOwnProperty("value") ? ee(e, t.type, n) : t.hasOwnProperty("defaultValue") && ee(e, t.type, W(t.defaultValue)), null == t.checked && null != t.defaultChecked && (e.defaultChecked = !!t.defaultChecked)
				}

				function q(e, t, n) {
					if (t.hasOwnProperty("value") || t.hasOwnProperty("defaultValue")) {
						var r = t.type;
						if (!("submit" !== r && "reset" !== r || void 0 !== t.value && null !== t.value)) return;
						t = "" + e._wrapperState.initialValue, n || t === e.value || (e.value = t), e.defaultValue = t
					}
					"" !== (n = e.name) && (e.name = ""), e.defaultChecked = !!e._wrapperState.initialChecked, "" !== n && (e.name = n)
				}

				function ee(e, t, n) {
					"number" === t && Q(e.ownerDocument) === e || (null == n ? e.defaultValue = "" + e._wrapperState.initialValue : e.defaultValue !== "" + n && (e.defaultValue = "" + n))
				}
				var te = Array.isArray;

				function ne(e, t, n, r) {
					if (e = e.options, t) {
						t = {};
						for (var l = 0; l < n.length; l++) t["$" + n[l]] = !0;
						for (n = 0; n < e.length; n++) l = t.hasOwnProperty("$" + e[n].value), e[n].selected !== l && (e[n].selected = l), l && r && (e[n].defaultSelected = !0)
					} else {
						for (n = "" + W(n), t = null, l = 0; l < e.length; l++) {
							if (e[l].value === n) return e[l].selected = !0, void(r && (e[l].defaultSelected = !0));
							null !== t || e[l].disabled || (t = e[l])
						}
						null !== t && (t.selected = !0)
					}
				}

				function re(e, t) {
					if (null != t.dangerouslySetInnerHTML) throw Error(a(91));
					return k({}, t, {
						value: void 0,
						defaultValue: void 0,
						children: "" + e._wrapperState.initialValue
					})
				}

				function le(e, t) {
					var n = t.value;
					if (null == n) {
						if (n = t.children, t = t.defaultValue, null != n) {
							if (null != t) throw Error(a(92));
							if (te(n)) {
								if (1 < n.length) throw Error(a(93));
								n = n[0]
							}
							t = n
						}
						null == t && (t = ""), n = t
					}
					e._wrapperState = {
						initialValue: W(n)
					}
				}

				function ae(e, t) {
					var n = W(t.value),
						r = W(t.defaultValue);
					null != n && ((n = "" + n) !== e.value && (e.value = n), null == t.defaultValue && e.defaultValue !== n && (e.defaultValue = n)), null != r && (e.defaultValue = "" + r)
				}

				function oe(e) {
					var t = e.textContent;
					t === e._wrapperState.initialValue && "" !== t && null !== t && (e.value = t)
				}

				function ie(e) {
					switch (e) {
						case "svg":
							return "http://www.w3.org/2000/svg";
						case "math":
							return "http://www.w3.org/1998/Math/MathML";
						default:
							return "http://www.w3.org/1999/xhtml"
					}
				}

				function ue(e, t) {
					return null == e || "http://www.w3.org/1999/xhtml" === e ? ie(t) : "http://www.w3.org/2000/svg" === e && "foreignObject" === t ? "http://www.w3.org/1999/xhtml" : e
				}
				var se, ce, fe = (ce = function(e, t) {
					if ("http://www.w3.org/2000/svg" !== e.namespaceURI || "innerHTML" in e) e.innerHTML = t;
					else {
						for ((se = se || document.createElement("div")).innerHTML = "<svg>" + t.valueOf().toString() + "</svg>", t = se.firstChild; e.firstChild;) e.removeChild(e.firstChild);
						for (; t.firstChild;) e.appendChild(t.firstChild)
					}
				}, "undefined" !== typeof MSApp && MSApp.execUnsafeLocalFunction ? function(e, t, n, r) {
					MSApp.execUnsafeLocalFunction((function() {
						return ce(e, t)
					}))
				} : ce);

				function de(e, t) {
					if (t) {
						var n = e.firstChild;
						if (n && n === e.lastChild && 3 === n.nodeType) return void(n.nodeValue = t)
					}
					e.textContent = t
				}
				var Ee = {
						animationIterationCount: !0,
						aspectRatio: !0,
						borderImageOutset: !0,
						borderImageSlice: !0,
						borderImageWidth: !0,
						boxFlex: !0,
						boxFlexGroup: !0,
						boxOrdinalGroup: !0,
						columnCount: !0,
						columns: !0,
						flex: !0,
						flexGrow: !0,
						flexPositive: !0,
						flexShrink: !0,
						flexNegative: !0,
						flexOrder: !0,
						gridArea: !0,
						gridRow: !0,
						gridRowEnd: !0,
						gridRowSpan: !0,
						gridRowStart: !0,
						gridColumn: !0,
						gridColumnEnd: !0,
						gridColumnSpan: !0,
						gridColumnStart: !0,
						fontWeight: !0,
						lineClamp: !0,
						lineHeight: !0,
						opacity: !0,
						order: !0,
						orphans: !0,
						tabSize: !0,
						widows: !0,
						zIndex: !0,
						zoom: !0,
						fillOpacity: !0,
						floodOpacity: !0,
						stopOpacity: !0,
						strokeDasharray: !0,
						strokeDashoffset: !0,
						strokeMiterlimit: !0,
						strokeOpacity: !0,
						strokeWidth: !0
					},
					me = ["Webkit", "ms", "Moz", "O"];

				function pe(e, t, n) {
					return null == t || "boolean" === typeof t || "" === t ? "" : n || "number" !== typeof t || 0 === t || Ee.hasOwnProperty(e) && Ee[e] ? ("" + t).trim() : t + "px"
				}

				function Se(e, t) {
					for (var n in e = e.style, t)
						if (t.hasOwnProperty(n)) {
							var r = 0 === n.indexOf("--"),
								l = pe(n, t[n], r);
							"float" === n && (n = "cssFloat"), r ? e.setProperty(n, l) : e[n] = l
						}
				}
				Object.keys(Ee).forEach((function(e) {
					me.forEach((function(t) {
						t = t + e.charAt(0).toUpperCase() + e.substring(1), Ee[t] = Ee[e]
					}))
				}));
				var Ae = k({
					menuitem: !0
				}, {
					area: !0,
					base: !0,
					br: !0,
					col: !0,
					embed: !0,
					hr: !0,
					img: !0,
					input: !0,
					keygen: !0,
					link: !0,
					meta: !0,
					param: !0,
					source: !0,
					track: !0,
					wbr: !0
				});

				function Oe(e, t) {
					if (t) {
						if (Ae[e] && (null != t.children || null != t.dangerouslySetInnerHTML)) throw Error(a(137, e));
						if (null != t.dangerouslySetInnerHTML) {
							if (null != t.children) throw Error(a(60));
							if ("object" !== typeof t.dangerouslySetInnerHTML || !("__html" in t.dangerouslySetInnerHTML)) throw Error(a(61))
						}
						if (null != t.style && "object" !== typeof t.style) throw Error(a(62))
					}
				}

				function Re(e, t) {
					if (-1 === e.indexOf("-")) return "string" === typeof t.is;
					switch (e) {
						case "annotation-xml":
						case "color-profile":
						case "font-face":
						case "font-face-src":
						case "font-face-uri":
						case "font-face-format":
						case "font-face-name":
						case "missing-glyph":
							return !1;
						default:
							return !0
					}
				}
				var Te = null;

				function Ne(e) {
					return (e = e.target || e.srcElement || window).correspondingUseElement && (e = e.correspondingUseElement), 3 === e.nodeType ? e.parentNode : e
				}
				var Ie = null,
					ve = null,
					he = null;

				function ge(e) {
					if (e = Rl(e)) {
						if ("function" !== typeof Ie) throw Error(a(280));
						var t = e.stateNode;
						t && (t = Nl(t), Ie(e.stateNode, e.type, t))
					}
				}

				function be(e) {
					ve ? he ? he.push(e) : he = [e] : ve = e
				}

				function Ce() {
					if (ve) {
						var e = ve,
							t = he;
						if (he = ve = null, ge(e), t)
							for (e = 0; e < t.length; e++) ge(t[e])
					}
				}

				function Le(e, t) {
					return e(t)
				}

				function ye() {}
				var Pe = !1;

				function Me(e, t, n) {
					if (Pe) return e(t, n);
					Pe = !0;
					try {
						return Le(e, t, n)
					} finally {
						Pe = !1, (null !== ve || null !== he) && (ye(), Ce())
					}
				}

				function Ue(e, t) {
					var n = e.stateNode;
					if (null === n) return null;
					var r = Nl(n);
					if (null === r) return null;
					n = r[t];
					e: switch (t) {
						case "onClick":
						case "onClickCapture":
						case "onDoubleClick":
						case "onDoubleClickCapture":
						case "onMouseDown":
						case "onMouseDownCapture":
						case "onMouseMove":
						case "onMouseMoveCapture":
						case "onMouseUp":
						case "onMouseUpCapture":
						case "onMouseEnter":
							(r = !r.disabled) || (r = !("button" === (e = e.type) || "input" === e || "select" === e || "textarea" === e)), e = !r;
							break e;
						default:
							e = !1
					}
					if (e) return null;
					if (n && "function" !== typeof n) throw Error(a(231, t, typeof n));
					return n
				}
				var De = !1;
				if (c) try {
					var He = {};
					Object.defineProperty(He, "passive", {
						get: function() {
							De = !0
						}
					}), window.addEventListener("test", He, He), window.removeEventListener("test", He, He)
				} catch (ce) {
					De = !1
				}

				function we(e, t, n, r, l, a, o, i, u) {
					var s = Array.prototype.slice.call(arguments, 3);
					try {
						t.apply(n, s)
					} catch (c) {
						this.onError(c)
					}
				}
				var Ge = !1,
					ke = null,
					Be = !1,
					xe = null,
					Fe = {
						onError: function(e) {
							Ge = !0, ke = e
						}
					};

				function Ye(e, t, n, r, l, a, o, i, u) {
					Ge = !1, ke = null, we.apply(Fe, arguments)
				}

				function _e(e) {
					var t = e,
						n = e;
					if (e.alternate)
						for (; t.return;) t = t.return;
					else {
						e = t;
						do {
							0 !== (4098 & (t = e).flags) && (n = t.return), e = t.return
						} while (e)
					}
					return 3 === t.tag ? n : null
				}

				function Ke(e) {
					if (13 === e.tag) {
						var t = e.memoizedState;
						if (null === t && (null !== (e = e.alternate) && (t = e.memoizedState)), null !== t) return t.dehydrated
					}
					return null
				}

				function We(e) {
					if (_e(e) !== e) throw Error(a(188))
				}

				function je(e) {
					return null !== (e = function(e) {
						var t = e.alternate;
						if (!t) {
							if (null === (t = _e(e))) throw Error(a(188));
							return t !== e ? null : e
						}
						for (var n = e, r = t;;) {
							var l = n.return;
							if (null === l) break;
							var o = l.alternate;
							if (null === o) {
								if (null !== (r = l.return)) {
									n = r;
									continue
								}
								break
							}
							if (l.child === o.child) {
								for (o = l.child; o;) {
									if (o === n) return We(l), e;
									if (o === r) return We(l), t;
									o = o.sibling
								}
								throw Error(a(188))
							}
							if (n.return !== r.return) n = l, r = o;
							else {
								for (var i = !1, u = l.child; u;) {
									if (u === n) {
										i = !0, n = l, r = o;
										break
									}
									if (u === r) {
										i = !0, r = l, n = o;
										break
									}
									u = u.sibling
								}
								if (!i) {
									for (u = o.child; u;) {
										if (u === n) {
											i = !0, n = o, r = l;
											break
										}
										if (u === r) {
											i = !0, r = o, n = l;
											break
										}
										u = u.sibling
									}
									if (!i) throw Error(a(189))
								}
							}
							if (n.alternate !== r) throw Error(a(190))
						}
						if (3 !== n.tag) throw Error(a(188));
						return n.stateNode.current === n ? e : t
					}(e)) ? Ve(e) : null
				}

				function Ve(e) {
					if (5 === e.tag || 6 === e.tag) return e;
					for (e = e.child; null !== e;) {
						var t = Ve(e);
						if (null !== t) return t;
						e = e.sibling
					}
					return null
				}
				var ze = l.unstable_scheduleCallback,
					Qe = l.unstable_cancelCallback,
					Je = l.unstable_shouldYield,
					Ze = l.unstable_requestPaint,
					$e = l.unstable_now,
					Xe = l.unstable_getCurrentPriorityLevel,
					qe = l.unstable_ImmediatePriority,
					et = l.unstable_UserBlockingPriority,
					tt = l.unstable_NormalPriority,
					nt = l.unstable_LowPriority,
					rt = l.unstable_IdlePriority,
					lt = null,
					at = null;
				var ot = Math.clz32 ? Math.clz32 : function(e) {
						return e >>>= 0, 0 === e ? 32 : 31 - (it(e) / ut | 0) | 0
					},
					it = Math.log,
					ut = Math.LN2;
				var st = 64,
					ct = 4194304;

				function ft(e) {
					switch (e & -e) {
						case 1:
							return 1;
						case 2:
							return 2;
						case 4:
							return 4;
						case 8:
							return 8;
						case 16:
							return 16;
						case 32:
							return 32;
						case 64:
						case 128:
						case 256:
						case 512:
						case 1024:
						case 2048:
						case 4096:
						case 8192:
						case 16384:
						case 32768:
						case 65536:
						case 131072:
						case 262144:
						case 524288:
						case 1048576:
						case 2097152:
							return 4194240 & e;
						case 4194304:
						case 8388608:
						case 16777216:
						case 33554432:
						case 67108864:
							return 130023424 & e;
						case 134217728:
							return 134217728;
						case 268435456:
							return 268435456;
						case 536870912:
							return 536870912;
						case 1073741824:
							return 1073741824;
						default:
							return e
					}
				}

				function dt(e, t) {
					var n = e.pendingLanes;
					if (0 === n) return 0;
					var r = 0,
						l = e.suspendedLanes,
						a = e.pingedLanes,
						o = 268435455 & n;
					if (0 !== o) {
						var i = o & ~l;
						0 !== i ? r = ft(i) : 0 !== (a &= o) && (r = ft(a))
					} else 0 !== (o = n & ~l) ? r = ft(o) : 0 !== a && (r = ft(a));
					if (0 === r) return 0;
					if (0 !== t && t !== r && 0 === (t & l) && ((l = r & -r) >= (a = t & -t) || 16 === l && 0 !== (4194240 & a))) return t;
					if (0 !== (4 & r) && (r |= 16 & n), 0 !== (t = e.entangledLanes))
						for (e = e.entanglements, t &= r; 0 < t;) l = 1 << (n = 31 - ot(t)), r |= e[n], t &= ~l;
					return r
				}

				function Et(e, t) {
					switch (e) {
						case 1:
						case 2:
						case 4:
							return t + 250;
						case 8:
						case 16:
						case 32:
						case 64:
						case 128:
						case 256:
						case 512:
						case 1024:
						case 2048:
						case 4096:
						case 8192:
						case 16384:
						case 32768:
						case 65536:
						case 131072:
						case 262144:
						case 524288:
						case 1048576:
						case 2097152:
							return t + 5e3;
						default:
							return -1
					}
				}

				function mt(e) {
					return 0 !== (e = -1073741825 & e.pendingLanes) ? e : 1073741824 & e ? 1073741824 : 0
				}

				function pt() {
					var e = st;
					return 0 === (4194240 & (st <<= 1)) && (st = 64), e
				}

				function St(e) {
					for (var t = [], n = 0; 31 > n; n++) t.push(e);
					return t
				}

				function At(e, t, n) {
					e.pendingLanes |= t, 536870912 !== t && (e.suspendedLanes = 0, e.pingedLanes = 0), (e = e.eventTimes)[t = 31 - ot(t)] = n
				}

				function Ot(e, t) {
					var n = e.entangledLanes |= t;
					for (e = e.entanglements; n;) {
						var r = 31 - ot(n),
							l = 1 << r;
						l & t | e[r] & t && (e[r] |= t), n &= ~l
					}
				}
				var Rt = 0;

				function Tt(e) {
					return 1 < (e &= -e) ? 4 < e ? 0 !== (268435455 & e) ? 16 : 536870912 : 4 : 1
				}
				var Nt, It, vt, ht, gt, bt = !1,
					Ct = [],
					Lt = null,
					yt = null,
					Pt = null,
					Mt = new Map,
					Ut = new Map,
					Dt = [],
					Ht = "mousedown mouseup touchcancel touchend touchstart auxclick dblclick pointercancel pointerdown pointerup dragend dragstart drop compositionend compositionstart keydown keypress keyup input textInput copy cut paste click change contextmenu reset submit".split(" ");

				function wt(e, t) {
					switch (e) {
						case "focusin":
						case "focusout":
							Lt = null;
							break;
						case "dragenter":
						case "dragleave":
							yt = null;
							break;
						case "mouseover":
						case "mouseout":
							Pt = null;
							break;
						case "pointerover":
						case "pointerout":
							Mt.delete(t.pointerId);
							break;
						case "gotpointercapture":
						case "lostpointercapture":
							Ut.delete(t.pointerId)
					}
				}

				function Gt(e, t, n, r, l, a) {
					return null === e || e.nativeEvent !== a ? (e = {
						blockedOn: t,
						domEventName: n,
						eventSystemFlags: r,
						nativeEvent: a,
						targetContainers: [l]
					}, null !== t && (null !== (t = Rl(t)) && It(t)), e) : (e.eventSystemFlags |= r, t = e.targetContainers, null !== l && -1 === t.indexOf(l) && t.push(l), e)
				}

				function kt(e) {
					var t = Ol(e.target);
					if (null !== t) {
						var n = _e(t);
						if (null !== n)
							if (13 === (t = n.tag)) {
								if (null !== (t = Ke(n))) return e.blockedOn = t, void gt(e.priority, (function() {
									vt(n)
								}))
							} else if (3 === t && n.stateNode.current.memoizedState.isDehydrated) return void(e.blockedOn = 3 === n.tag ? n.stateNode.containerInfo : null)
					}
					e.blockedOn = null
				}

				function Bt(e) {
					if (null !== e.blockedOn) return !1;
					for (var t = e.targetContainers; 0 < t.length;) {
						var n = Jt(e.domEventName, e.eventSystemFlags, t[0], e.nativeEvent);
						if (null !== n) return null !== (t = Rl(n)) && It(t), e.blockedOn = n, !1;
						var r = new(n = e.nativeEvent).constructor(n.type, n);
						Te = r, n.target.dispatchEvent(r), Te = null, t.shift()
					}
					return !0
				}

				function xt(e, t, n) {
					Bt(e) && n.delete(t)
				}

				function Ft() {
					bt = !1, null !== Lt && Bt(Lt) && (Lt = null), null !== yt && Bt(yt) && (yt = null), null !== Pt && Bt(Pt) && (Pt = null), Mt.forEach(xt), Ut.forEach(xt)
				}

				function Yt(e, t) {
					e.blockedOn === t && (e.blockedOn = null, bt || (bt = !0, l.unstable_scheduleCallback(l.unstable_NormalPriority, Ft)))
				}

				function _t(e) {
					function t(t) {
						return Yt(t, e)
					}
					if (0 < Ct.length) {
						Yt(Ct[0], e);
						for (var n = 1; n < Ct.length; n++) {
							var r = Ct[n];
							r.blockedOn === e && (r.blockedOn = null)
						}
					}
					for (null !== Lt && Yt(Lt, e), null !== yt && Yt(yt, e), null !== Pt && Yt(Pt, e), Mt.forEach(t), Ut.forEach(t), n = 0; n < Dt.length; n++)(r = Dt[n]).blockedOn === e && (r.blockedOn = null);
					for (; 0 < Dt.length && null === (n = Dt[0]).blockedOn;) kt(n), null === n.blockedOn && Dt.shift()
				}
				var Kt = T.ReactCurrentBatchConfig,
					Wt = !0;

				function jt(e, t, n, r) {
					var l = Rt,
						a = Kt.transition;
					Kt.transition = null;
					try {
						Rt = 1, zt(e, t, n, r)
					} finally {
						Rt = l, Kt.transition = a
					}
				}

				function Vt(e, t, n, r) {
					var l = Rt,
						a = Kt.transition;
					Kt.transition = null;
					try {
						Rt = 4, zt(e, t, n, r)
					} finally {
						Rt = l, Kt.transition = a
					}
				}

				function zt(e, t, n, r) {
					if (Wt) {
						var l = Jt(e, t, n, r);
						if (null === l) Wr(e, t, r, Qt, n), wt(e, r);
						else if (function(e, t, n, r, l) {
								switch (t) {
									case "focusin":
										return Lt = Gt(Lt, e, t, n, r, l), !0;
									case "dragenter":
										return yt = Gt(yt, e, t, n, r, l), !0;
									case "mouseover":
										return Pt = Gt(Pt, e, t, n, r, l), !0;
									case "pointerover":
										var a = l.pointerId;
										return Mt.set(a, Gt(Mt.get(a) || null, e, t, n, r, l)), !0;
									case "gotpointercapture":
										return a = l.pointerId, Ut.set(a, Gt(Ut.get(a) || null, e, t, n, r, l)), !0
								}
								return !1
							}(l, e, t, n, r)) r.stopPropagation();
						else if (wt(e, r), 4 & t && -1 < Ht.indexOf(e)) {
							for (; null !== l;) {
								var a = Rl(l);
								if (null !== a && Nt(a), null === (a = Jt(e, t, n, r)) && Wr(e, t, r, Qt, n), a === l) break;
								l = a
							}
							null !== l && r.stopPropagation()
						} else Wr(e, t, r, null, n)
					}
				}
				var Qt = null;

				function Jt(e, t, n, r) {
					if (Qt = null, null !== (e = Ol(e = Ne(r))))
						if (null === (t = _e(e))) e = null;
						else if (13 === (n = t.tag)) {
						if (null !== (e = Ke(t))) return e;
						e = null
					} else if (3 === n) {
						if (t.stateNode.current.memoizedState.isDehydrated) return 3 === t.tag ? t.stateNode.containerInfo : null;
						e = null
					} else t !== e && (e = null);
					return Qt = e, null
				}

				function Zt(e) {
					switch (e) {
						case "cancel":
						case "click":
						case "close":
						case "contextmenu":
						case "copy":
						case "cut":
						case "auxclick":
						case "dblclick":
						case "dragend":
						case "dragstart":
						case "drop":
						case "focusin":
						case "focusout":
						case "input":
						case "invalid":
						case "keydown":
						case "keypress":
						case "keyup":
						case "mousedown":
						case "mouseup":
						case "paste":
						case "pause":
						case "play":
						case "pointercancel":
						case "pointerdown":
						case "pointerup":
						case "ratechange":
						case "reset":
						case "resize":
						case "seeked":
						case "submit":
						case "touchcancel":
						case "touchend":
						case "touchstart":
						case "volumechange":
						case "change":
						case "selectionchange":
						case "textInput":
						case "compositionstart":
						case "compositionend":
						case "compositionupdate":
						case "beforeblur":
						case "afterblur":
						case "beforeinput":
						case "blur":
						case "fullscreenchange":
						case "focus":
						case "hashchange":
						case "popstate":
						case "select":
						case "selectstart":
							return 1;
						case "drag":
						case "dragenter":
						case "dragexit":
						case "dragleave":
						case "dragover":
						case "mousemove":
						case "mouseout":
						case "mouseover":
						case "pointermove":
						case "pointerout":
						case "pointerover":
						case "scroll":
						case "toggle":
						case "touchmove":
						case "wheel":
						case "mouseenter":
						case "mouseleave":
						case "pointerenter":
						case "pointerleave":
							return 4;
						case "message":
							switch (Xe()) {
								case qe:
									return 1;
								case et:
									return 4;
								case tt:
								case nt:
									return 16;
								case rt:
									return 536870912;
								default:
									return 16
							}
						default:
							return 16
					}
				}
				var $t = null,
					Xt = null,
					qt = null;

				function en() {
					if (qt) return qt;
					var e, t, n = Xt,
						r = n.length,
						l = "value" in $t ? $t.value : $t.textContent,
						a = l.length;
					for (e = 0; e < r && n[e] === l[e]; e++);
					var o = r - e;
					for (t = 1; t <= o && n[r - t] === l[a - t]; t++);
					return qt = l.slice(e, 1 < t ? 1 - t : void 0)
				}

				function tn(e) {
					var t = e.keyCode;
					return "charCode" in e ? 0 === (e = e.charCode) && 13 === t && (e = 13) : e = t, 10 === e && (e = 13), 32 <= e || 13 === e ? e : 0
				}

				function nn() {
					return !0
				}

				function rn() {
					return !1
				}

				function ln(e) {
					function t(t, n, r, l, a) {
						for (var o in this._reactName = t, this._targetInst = r, this.type = n, this.nativeEvent = l, this.target = a, this.currentTarget = null, e) e.hasOwnProperty(o) && (t = e[o], this[o] = t ? t(l) : l[o]);
						return this.isDefaultPrevented = (null != l.defaultPrevented ? l.defaultPrevented : !1 === l.returnValue) ? nn : rn, this.isPropagationStopped = rn, this
					}
					return k(t.prototype, {
						preventDefault: function() {
							this.defaultPrevented = !0;
							var e = this.nativeEvent;
							e && (e.preventDefault ? e.preventDefault() : "unknown" !== typeof e.returnValue && (e.returnValue = !1), this.isDefaultPrevented = nn)
						},
						stopPropagation: function() {
							var e = this.nativeEvent;
							e && (e.stopPropagation ? e.stopPropagation() : "unknown" !== typeof e.cancelBubble && (e.cancelBubble = !0), this.isPropagationStopped = nn)
						},
						persist: function() {},
						isPersistent: nn
					}), t
				}
				var an, on, un, sn = {
						eventPhase: 0,
						bubbles: 0,
						cancelable: 0,
						timeStamp: function(e) {
							return e.timeStamp || Date.now()
						},
						defaultPrevented: 0,
						isTrusted: 0
					},
					cn = ln(sn),
					fn = k({}, sn, {
						view: 0,
						detail: 0
					}),
					dn = ln(fn),
					En = k({}, fn, {
						screenX: 0,
						screenY: 0,
						clientX: 0,
						clientY: 0,
						pageX: 0,
						pageY: 0,
						ctrlKey: 0,
						shiftKey: 0,
						altKey: 0,
						metaKey: 0,
						getModifierState: gn,
						button: 0,
						buttons: 0,
						relatedTarget: function(e) {
							return void 0 === e.relatedTarget ? e.fromElement === e.srcElement ? e.toElement : e.fromElement : e.relatedTarget
						},
						movementX: function(e) {
							return "movementX" in e ? e.movementX : (e !== un && (un && "mousemove" === e.type ? (an = e.screenX - un.screenX, on = e.screenY - un.screenY) : on = an = 0, un = e), an)
						},
						movementY: function(e) {
							return "movementY" in e ? e.movementY : on
						}
					}),
					mn = ln(En),
					pn = ln(k({}, En, {
						dataTransfer: 0
					})),
					Sn = ln(k({}, fn, {
						relatedTarget: 0
					})),
					An = ln(k({}, sn, {
						animationName: 0,
						elapsedTime: 0,
						pseudoElement: 0
					})),
					On = k({}, sn, {
						clipboardData: function(e) {
							return "clipboardData" in e ? e.clipboardData : window.clipboardData
						}
					}),
					Rn = ln(On),
					Tn = ln(k({}, sn, {
						data: 0
					})),
					Nn = {
						Esc: "Escape",
						Spacebar: " ",
						Left: "ArrowLeft",
						Up: "ArrowUp",
						Right: "ArrowRight",
						Down: "ArrowDown",
						Del: "Delete",
						Win: "OS",
						Menu: "ContextMenu",
						Apps: "ContextMenu",
						Scroll: "ScrollLock",
						MozPrintableKey: "Unidentified"
					},
					In = {
						8: "Backspace",
						9: "Tab",
						12: "Clear",
						13: "Enter",
						16: "Shift",
						17: "Control",
						18: "Alt",
						19: "Pause",
						20: "CapsLock",
						27: "Escape",
						32: " ",
						33: "PageUp",
						34: "PageDown",
						35: "End",
						36: "Home",
						37: "ArrowLeft",
						38: "ArrowUp",
						39: "ArrowRight",
						40: "ArrowDown",
						45: "Insert",
						46: "Delete",
						112: "F1",
						113: "F2",
						114: "F3",
						115: "F4",
						116: "F5",
						117: "F6",
						118: "F7",
						119: "F8",
						120: "F9",
						121: "F10",
						122: "F11",
						123: "F12",
						144: "NumLock",
						145: "ScrollLock",
						224: "Meta"
					},
					vn = {
						Alt: "altKey",
						Control: "ctrlKey",
						Meta: "metaKey",
						Shift: "shiftKey"
					};

				function hn(e) {
					var t = this.nativeEvent;
					return t.getModifierState ? t.getModifierState(e) : !!(e = vn[e]) && !!t[e]
				}

				function gn() {
					return hn
				}
				var bn = k({}, fn, {
						key: function(e) {
							if (e.key) {
								var t = Nn[e.key] || e.key;
								if ("Unidentified" !== t) return t
							}
							return "keypress" === e.type ? 13 === (e = tn(e)) ? "Enter" : String.fromCharCode(e) : "keydown" === e.type || "keyup" === e.type ? In[e.keyCode] || "Unidentified" : ""
						},
						code: 0,
						location: 0,
						ctrlKey: 0,
						shiftKey: 0,
						altKey: 0,
						metaKey: 0,
						repeat: 0,
						locale: 0,
						getModifierState: gn,
						charCode: function(e) {
							return "keypress" === e.type ? tn(e) : 0
						},
						keyCode: function(e) {
							return "keydown" === e.type || "keyup" === e.type ? e.keyCode : 0
						},
						which: function(e) {
							return "keypress" === e.type ? tn(e) : "keydown" === e.type || "keyup" === e.type ? e.keyCode : 0
						}
					}),
					Cn = ln(bn),
					Ln = ln(k({}, En, {
						pointerId: 0,
						width: 0,
						height: 0,
						pressure: 0,
						tangentialPressure: 0,
						tiltX: 0,
						tiltY: 0,
						twist: 0,
						pointerType: 0,
						isPrimary: 0
					})),
					yn = ln(k({}, fn, {
						touches: 0,
						targetTouches: 0,
						changedTouches: 0,
						altKey: 0,
						metaKey: 0,
						ctrlKey: 0,
						shiftKey: 0,
						getModifierState: gn
					})),
					Pn = ln(k({}, sn, {
						propertyName: 0,
						elapsedTime: 0,
						pseudoElement: 0
					})),
					Mn = k({}, En, {
						deltaX: function(e) {
							return "deltaX" in e ? e.deltaX : "wheelDeltaX" in e ? -e.wheelDeltaX : 0
						},
						deltaY: function(e) {
							return "deltaY" in e ? e.deltaY : "wheelDeltaY" in e ? -e.wheelDeltaY : "wheelDelta" in e ? -e.wheelDelta : 0
						},
						deltaZ: 0,
						deltaMode: 0
					}),
					Un = ln(Mn),
					Dn = [9, 13, 27, 32],
					Hn = c && "CompositionEvent" in window,
					wn = null;
				c && "documentMode" in document && (wn = document.documentMode);
				var Gn = c && "TextEvent" in window && !wn,
					kn = c && (!Hn || wn && 8 < wn && 11 >= wn),
					Bn = String.fromCharCode(32),
					xn = !1;

				function Fn(e, t) {
					switch (e) {
						case "keyup":
							return -1 !== Dn.indexOf(t.keyCode);
						case "keydown":
							return 229 !== t.keyCode;
						case "keypress":
						case "mousedown":
						case "focusout":
							return !0;
						default:
							return !1
					}
				}

				function Yn(e) {
					return "object" === typeof(e = e.detail) && "data" in e ? e.data : null
				}
				var _n = !1;
				var Kn = {
					color: !0,
					date: !0,
					datetime: !0,
					"datetime-local": !0,
					email: !0,
					month: !0,
					number: !0,
					password: !0,
					range: !0,
					search: !0,
					tel: !0,
					text: !0,
					time: !0,
					url: !0,
					week: !0
				};

				function Wn(e) {
					var t = e && e.nodeName && e.nodeName.toLowerCase();
					return "input" === t ? !!Kn[e.type] : "textarea" === t
				}

				function jn(e, t, n, r) {
					be(r), 0 < (t = Vr(t, "onChange")).length && (n = new cn("onChange", "change", null, n, r), e.push({
						event: n,
						listeners: t
					}))
				}
				var Vn = null,
					zn = null;

				function Qn(e) {
					Br(e, 0)
				}

				function Jn(e) {
					if (z(Tl(e))) return e
				}

				function Zn(e, t) {
					if ("change" === e) return t
				}
				var $n = !1;
				if (c) {
					var Xn;
					if (c) {
						var qn = "oninput" in document;
						if (!qn) {
							var er = document.createElement("div");
							er.setAttribute("oninput", "return;"), qn = "function" === typeof er.oninput
						}
						Xn = qn
					} else Xn = !1;
					$n = Xn && (!document.documentMode || 9 < document.documentMode)
				}

				function tr() {
					Vn && (Vn.detachEvent("onpropertychange", nr), zn = Vn = null)
				}

				function nr(e) {
					if ("value" === e.propertyName && Jn(zn)) {
						var t = [];
						jn(t, zn, e, Ne(e)), Me(Qn, t)
					}
				}

				function rr(e, t, n) {
					"focusin" === e ? (tr(), zn = n, (Vn = t).attachEvent("onpropertychange", nr)) : "focusout" === e && tr()
				}

				function lr(e) {
					if ("selectionchange" === e || "keyup" === e || "keydown" === e) return Jn(zn)
				}

				function ar(e, t) {
					if ("click" === e) return Jn(t)
				}

				function or(e, t) {
					if ("input" === e || "change" === e) return Jn(t)
				}
				var ir = "function" === typeof Object.is ? Object.is : function(e, t) {
					return e === t && (0 !== e || 1 / e === 1 / t) || e !== e && t !== t
				};

				function ur(e, t) {
					if (ir(e, t)) return !0;
					if ("object" !== typeof e || null === e || "object" !== typeof t || null === t) return !1;
					var n = Object.keys(e),
						r = Object.keys(t);
					if (n.length !== r.length) return !1;
					for (r = 0; r < n.length; r++) {
						var l = n[r];
						if (!f.call(t, l) || !ir(e[l], t[l])) return !1
					}
					return !0
				}

				function sr(e) {
					for (; e && e.firstChild;) e = e.firstChild;
					return e
				}

				function cr(e, t) {
					var n, r = sr(e);
					for (e = 0; r;) {
						if (3 === r.nodeType) {
							if (n = e + r.textContent.length, e <= t && n >= t) return {
								node: r,
								offset: t - e
							};
							e = n
						}
						e: {
							for (; r;) {
								if (r.nextSibling) {
									r = r.nextSibling;
									break e
								}
								r = r.parentNode
							}
							r = void 0
						}
						r = sr(r)
					}
				}

				function fr(e, t) {
					return !(!e || !t) && (e === t || (!e || 3 !== e.nodeType) && (t && 3 === t.nodeType ? fr(e, t.parentNode) : "contains" in e ? e.contains(t) : !!e.compareDocumentPosition && !!(16 & e.compareDocumentPosition(t))))
				}

				function dr() {
					for (var e = window, t = Q(); t instanceof e.HTMLIFrameElement;) {
						try {
							var n = "string" === typeof t.contentWindow.location.href
						} catch (r) {
							n = !1
						}
						if (!n) break;
						t = Q((e = t.contentWindow).document)
					}
					return t
				}

				function Er(e) {
					var t = e && e.nodeName && e.nodeName.toLowerCase();
					return t && ("input" === t && ("text" === e.type || "search" === e.type || "tel" === e.type || "url" === e.type || "password" === e.type) || "textarea" === t || "true" === e.contentEditable)
				}

				function mr(e) {
					var t = dr(),
						n = e.focusedElem,
						r = e.selectionRange;
					if (t !== n && n && n.ownerDocument && fr(n.ownerDocument.documentElement, n)) {
						if (null !== r && Er(n))
							if (t = r.start, void 0 === (e = r.end) && (e = t), "selectionStart" in n) n.selectionStart = t, n.selectionEnd = Math.min(e, n.value.length);
							else if ((e = (t = n.ownerDocument || document) && t.defaultView || window).getSelection) {
							e = e.getSelection();
							var l = n.textContent.length,
								a = Math.min(r.start, l);
							r = void 0 === r.end ? a : Math.min(r.end, l), !e.extend && a > r && (l = r, r = a, a = l), l = cr(n, a);
							var o = cr(n, r);
							l && o && (1 !== e.rangeCount || e.anchorNode !== l.node || e.anchorOffset !== l.offset || e.focusNode !== o.node || e.focusOffset !== o.offset) && ((t = t.createRange()).setStart(l.node, l.offset), e.removeAllRanges(), a > r ? (e.addRange(t), e.extend(o.node, o.offset)) : (t.setEnd(o.node, o.offset), e.addRange(t)))
						}
						for (t = [], e = n; e = e.parentNode;) 1 === e.nodeType && t.push({
							element: e,
							left: e.scrollLeft,
							top: e.scrollTop
						});
						for ("function" === typeof n.focus && n.focus(), n = 0; n < t.length; n++)(e = t[n]).element.scrollLeft = e.left, e.element.scrollTop = e.top
					}
				}
				var pr = c && "documentMode" in document && 11 >= document.documentMode,
					Sr = null,
					Ar = null,
					Or = null,
					Rr = !1;

				function Tr(e, t, n) {
					var r = n.window === n ? n.document : 9 === n.nodeType ? n : n.ownerDocument;
					Rr || null == Sr || Sr !== Q(r) || ("selectionStart" in (r = Sr) && Er(r) ? r = {
						start: r.selectionStart,
						end: r.selectionEnd
					} : r = {
						anchorNode: (r = (r.ownerDocument && r.ownerDocument.defaultView || window).getSelection()).anchorNode,
						anchorOffset: r.anchorOffset,
						focusNode: r.focusNode,
						focusOffset: r.focusOffset
					}, Or && ur(Or, r) || (Or = r, 0 < (r = Vr(Ar, "onSelect")).length && (t = new cn("onSelect", "select", null, t, n), e.push({
						event: t,
						listeners: r
					}), t.target = Sr)))
				}

				function Nr(e, t) {
					var n = {};
					return n[e.toLowerCase()] = t.toLowerCase(), n["Webkit" + e] = "webkit" + t, n["Moz" + e] = "moz" + t, n
				}
				var Ir = {
						animationend: Nr("Animation", "AnimationEnd"),
						animationiteration: Nr("Animation", "AnimationIteration"),
						animationstart: Nr("Animation", "AnimationStart"),
						transitionend: Nr("Transition", "TransitionEnd")
					},
					vr = {},
					hr = {};

				function gr(e) {
					if (vr[e]) return vr[e];
					if (!Ir[e]) return e;
					var t, n = Ir[e];
					for (t in n)
						if (n.hasOwnProperty(t) && t in hr) return vr[e] = n[t];
					return e
				}
				c && (hr = document.createElement("div").style, "AnimationEvent" in window || (delete Ir.animationend.animation, delete Ir.animationiteration.animation, delete Ir.animationstart.animation), "TransitionEvent" in window || delete Ir.transitionend.transition);
				var br = gr("animationend"),
					Cr = gr("animationiteration"),
					Lr = gr("animationstart"),
					yr = gr("transitionend"),
					Pr = new Map,
					Mr = "abort auxClick cancel canPlay canPlayThrough click close contextMenu copy cut drag dragEnd dragEnter dragExit dragLeave dragOver dragStart drop durationChange emptied encrypted ended error gotPointerCapture input invalid keyDown keyPress keyUp load loadedData loadedMetadata loadStart lostPointerCapture mouseDown mouseMove mouseOut mouseOver mouseUp paste pause play playing pointerCancel pointerDown pointerMove pointerOut pointerOver pointerUp progress rateChange reset resize seeked seeking stalled submit suspend timeUpdate touchCancel touchEnd touchStart volumeChange scroll toggle touchMove waiting wheel".split(" ");

				function Ur(e, t) {
					Pr.set(e, t), u(t, [e])
				}
				for (var Dr = 0; Dr < Mr.length; Dr++) {
					var Hr = Mr[Dr];
					Ur(Hr.toLowerCase(), "on" + (Hr[0].toUpperCase() + Hr.slice(1)))
				}
				Ur(br, "onAnimationEnd"), Ur(Cr, "onAnimationIteration"), Ur(Lr, "onAnimationStart"), Ur("dblclick", "onDoubleClick"), Ur("focusin", "onFocus"), Ur("focusout", "onBlur"), Ur(yr, "onTransitionEnd"), s("onMouseEnter", ["mouseout", "mouseover"]), s("onMouseLeave", ["mouseout", "mouseover"]), s("onPointerEnter", ["pointerout", "pointerover"]), s("onPointerLeave", ["pointerout", "pointerover"]), u("onChange", "change click focusin focusout input keydown keyup selectionchange".split(" ")), u("onSelect", "focusout contextmenu dragend focusin keydown keyup mousedown mouseup selectionchange".split(" ")), u("onBeforeInput", ["compositionend", "keypress", "textInput", "paste"]), u("onCompositionEnd", "compositionend focusout keydown keypress keyup mousedown".split(" ")), u("onCompositionStart", "compositionstart focusout keydown keypress keyup mousedown".split(" ")), u("onCompositionUpdate", "compositionupdate focusout keydown keypress keyup mousedown".split(" "));
				var wr = "abort canplay canplaythrough durationchange emptied encrypted ended error loadeddata loadedmetadata loadstart pause play playing progress ratechange resize seeked seeking stalled suspend timeupdate volumechange waiting".split(" "),
					Gr = new Set("cancel close invalid load scroll toggle".split(" ").concat(wr));

				function kr(e, t, n) {
					var r = e.type || "unknown-event";
					e.currentTarget = n,
						function(e, t, n, r, l, o, i, u, s) {
							if (Ye.apply(this, arguments), Ge) {
								if (!Ge) throw Error(a(198));
								var c = ke;
								Ge = !1, ke = null, Be || (Be = !0, xe = c)
							}
						}(r, t, void 0, e), e.currentTarget = null
				}

				function Br(e, t) {
					t = 0 !== (4 & t);
					for (var n = 0; n < e.length; n++) {
						var r = e[n],
							l = r.event;
						r = r.listeners;
						e: {
							var a = void 0;
							if (t)
								for (var o = r.length - 1; 0 <= o; o--) {
									var i = r[o],
										u = i.instance,
										s = i.currentTarget;
									if (i = i.listener, u !== a && l.isPropagationStopped()) break e;
									kr(l, i, s), a = u
								} else
									for (o = 0; o < r.length; o++) {
										if (u = (i = r[o]).instance, s = i.currentTarget, i = i.listener, u !== a && l.isPropagationStopped()) break e;
										kr(l, i, s), a = u
									}
						}
					}
					if (Be) throw e = xe, Be = !1, xe = null, e
				}

				function xr(e, t) {
					var n = t[pl];
					void 0 === n && (n = t[pl] = new Set);
					var r = e + "__bubble";
					n.has(r) || (Kr(t, e, 2, !1), n.add(r))
				}

				function Fr(e, t, n) {
					var r = 0;
					t && (r |= 4), Kr(n, e, r, t)
				}
				var Yr = "_reactListening" + Math.random().toString(36).slice(2);

				function _r(e) {
					if (!e[Yr]) {
						e[Yr] = !0, o.forEach((function(t) {
							"selectionchange" !== t && (Gr.has(t) || Fr(t, !1, e), Fr(t, !0, e))
						}));
						var t = 9 === e.nodeType ? e : e.ownerDocument;
						null === t || t[Yr] || (t[Yr] = !0, Fr("selectionchange", !1, t))
					}
				}

				function Kr(e, t, n, r) {
					switch (Zt(t)) {
						case 1:
							var l = jt;
							break;
						case 4:
							l = Vt;
							break;
						default:
							l = zt
					}
					n = l.bind(null, t, n, e), l = void 0, !De || "touchstart" !== t && "touchmove" !== t && "wheel" !== t || (l = !0), r ? void 0 !== l ? e.addEventListener(t, n, {
						capture: !0,
						passive: l
					}) : e.addEventListener(t, n, !0) : void 0 !== l ? e.addEventListener(t, n, {
						passive: l
					}) : e.addEventListener(t, n, !1)
				}

				function Wr(e, t, n, r, l) {
					var a = r;
					if (0 === (1 & t) && 0 === (2 & t) && null !== r) e: for (;;) {
						if (null === r) return;
						var o = r.tag;
						if (3 === o || 4 === o) {
							var i = r.stateNode.containerInfo;
							if (i === l || 8 === i.nodeType && i.parentNode === l) break;
							if (4 === o)
								for (o = r.return; null !== o;) {
									var u = o.tag;
									if ((3 === u || 4 === u) && ((u = o.stateNode.containerInfo) === l || 8 === u.nodeType && u.parentNode === l)) return;
									o = o.return
								}
							for (; null !== i;) {
								if (null === (o = Ol(i))) return;
								if (5 === (u = o.tag) || 6 === u) {
									r = a = o;
									continue e
								}
								i = i.parentNode
							}
						}
						r = r.return
					}
					Me((function() {
						var r = a,
							l = Ne(n),
							o = [];
						e: {
							var i = Pr.get(e);
							if (void 0 !== i) {
								var u = cn,
									s = e;
								switch (e) {
									case "keypress":
										if (0 === tn(n)) break e;
									case "keydown":
									case "keyup":
										u = Cn;
										break;
									case "focusin":
										s = "focus", u = Sn;
										break;
									case "focusout":
										s = "blur", u = Sn;
										break;
									case "beforeblur":
									case "afterblur":
										u = Sn;
										break;
									case "click":
										if (2 === n.button) break e;
									case "auxclick":
									case "dblclick":
									case "mousedown":
									case "mousemove":
									case "mouseup":
									case "mouseout":
									case "mouseover":
									case "contextmenu":
										u = mn;
										break;
									case "drag":
									case "dragend":
									case "dragenter":
									case "dragexit":
									case "dragleave":
									case "dragover":
									case "dragstart":
									case "drop":
										u = pn;
										break;
									case "touchcancel":
									case "touchend":
									case "touchmove":
									case "touchstart":
										u = yn;
										break;
									case br:
									case Cr:
									case Lr:
										u = An;
										break;
									case yr:
										u = Pn;
										break;
									case "scroll":
										u = dn;
										break;
									case "wheel":
										u = Un;
										break;
									case "copy":
									case "cut":
									case "paste":
										u = Rn;
										break;
									case "gotpointercapture":
									case "lostpointercapture":
									case "pointercancel":
									case "pointerdown":
									case "pointermove":
									case "pointerout":
									case "pointerover":
									case "pointerup":
										u = Ln
								}
								var c = 0 !== (4 & t),
									f = !c && "scroll" === e,
									d = c ? null !== i ? i + "Capture" : null : i;
								c = [];
								for (var E, m = r; null !== m;) {
									var p = (E = m).stateNode;
									if (5 === E.tag && null !== p && (E = p, null !== d && (null != (p = Ue(m, d)) && c.push(jr(m, p, E)))), f) break;
									m = m.return
								}
								0 < c.length && (i = new u(i, s, null, n, l), o.push({
									event: i,
									listeners: c
								}))
							}
						}
						if (0 === (7 & t)) {
							if (u = "mouseout" === e || "pointerout" === e, (!(i = "mouseover" === e || "pointerover" === e) || n === Te || !(s = n.relatedTarget || n.fromElement) || !Ol(s) && !s[ml]) && (u || i) && (i = l.window === l ? l : (i = l.ownerDocument) ? i.defaultView || i.parentWindow : window, u ? (u = r, null !== (s = (s = n.relatedTarget || n.toElement) ? Ol(s) : null) && (s !== (f = _e(s)) || 5 !== s.tag && 6 !== s.tag) && (s = null)) : (u = null, s = r), u !== s)) {
								if (c = mn, p = "onMouseLeave", d = "onMouseEnter", m = "mouse", "pointerout" !== e && "pointerover" !== e || (c = Ln, p = "onPointerLeave", d = "onPointerEnter", m = "pointer"), f = null == u ? i : Tl(u), E = null == s ? i : Tl(s), (i = new c(p, m + "leave", u, n, l)).target = f, i.relatedTarget = E, p = null, Ol(l) === r && ((c = new c(d, m + "enter", s, n, l)).target = E, c.relatedTarget = f, p = c), f = p, u && s) e: {
									for (d = s, m = 0, E = c = u; E; E = zr(E)) m++;
									for (E = 0, p = d; p; p = zr(p)) E++;
									for (; 0 < m - E;) c = zr(c),
									m--;
									for (; 0 < E - m;) d = zr(d),
									E--;
									for (; m--;) {
										if (c === d || null !== d && c === d.alternate) break e;
										c = zr(c), d = zr(d)
									}
									c = null
								}
								else c = null;
								null !== u && Qr(o, i, u, c, !1), null !== s && null !== f && Qr(o, f, s, c, !0)
							}
							if ("select" === (u = (i = r ? Tl(r) : window).nodeName && i.nodeName.toLowerCase()) || "input" === u && "file" === i.type) var S = Zn;
							else if (Wn(i))
								if ($n) S = or;
								else {
									S = lr;
									var A = rr
								}
							else(u = i.nodeName) && "input" === u.toLowerCase() && ("checkbox" === i.type || "radio" === i.type) && (S = ar);
							switch (S && (S = S(e, r)) ? jn(o, S, n, l) : (A && A(e, i, r), "focusout" === e && (A = i._wrapperState) && A.controlled && "number" === i.type && ee(i, "number", i.value)), A = r ? Tl(r) : window, e) {
								case "focusin":
									(Wn(A) || "true" === A.contentEditable) && (Sr = A, Ar = r, Or = null);
									break;
								case "focusout":
									Or = Ar = Sr = null;
									break;
								case "mousedown":
									Rr = !0;
									break;
								case "contextmenu":
								case "mouseup":
								case "dragend":
									Rr = !1, Tr(o, n, l);
									break;
								case "selectionchange":
									if (pr) break;
								case "keydown":
								case "keyup":
									Tr(o, n, l)
							}
							var O;
							if (Hn) e: {
								switch (e) {
									case "compositionstart":
										var R = "onCompositionStart";
										break e;
									case "compositionend":
										R = "onCompositionEnd";
										break e;
									case "compositionupdate":
										R = "onCompositionUpdate";
										break e
								}
								R = void 0
							}
							else _n ? Fn(e, n) && (R = "onCompositionEnd") : "keydown" === e && 229 === n.keyCode && (R = "onCompositionStart");
							R && (kn && "ko" !== n.locale && (_n || "onCompositionStart" !== R ? "onCompositionEnd" === R && _n && (O = en()) : (Xt = "value" in ($t = l) ? $t.value : $t.textContent, _n = !0)), 0 < (A = Vr(r, R)).length && (R = new Tn(R, e, null, n, l), o.push({
								event: R,
								listeners: A
							}), O ? R.data = O : null !== (O = Yn(n)) && (R.data = O))), (O = Gn ? function(e, t) {
								switch (e) {
									case "compositionend":
										return Yn(t);
									case "keypress":
										return 32 !== t.which ? null : (xn = !0, Bn);
									case "textInput":
										return (e = t.data) === Bn && xn ? null : e;
									default:
										return null
								}
							}(e, n) : function(e, t) {
								if (_n) return "compositionend" === e || !Hn && Fn(e, t) ? (e = en(), qt = Xt = $t = null, _n = !1, e) : null;
								switch (e) {
									case "paste":
									default:
										return null;
									case "keypress":
										if (!(t.ctrlKey || t.altKey || t.metaKey) || t.ctrlKey && t.altKey) {
											if (t.char && 1 < t.char.length) return t.char;
											if (t.which) return String.fromCharCode(t.which)
										}
										return null;
									case "compositionend":
										return kn && "ko" !== t.locale ? null : t.data
								}
							}(e, n)) && (0 < (r = Vr(r, "onBeforeInput")).length && (l = new Tn("onBeforeInput", "beforeinput", null, n, l), o.push({
								event: l,
								listeners: r
							}), l.data = O))
						}
						Br(o, t)
					}))
				}

				function jr(e, t, n) {
					return {
						instance: e,
						listener: t,
						currentTarget: n
					}
				}

				function Vr(e, t) {
					for (var n = t + "Capture", r = []; null !== e;) {
						var l = e,
							a = l.stateNode;
						5 === l.tag && null !== a && (l = a, null != (a = Ue(e, n)) && r.unshift(jr(e, a, l)), null != (a = Ue(e, t)) && r.push(jr(e, a, l))), e = e.return
					}
					return r
				}

				function zr(e) {
					if (null === e) return null;
					do {
						e = e.return
					} while (e && 5 !== e.tag);
					return e || null
				}

				function Qr(e, t, n, r, l) {
					for (var a = t._reactName, o = []; null !== n && n !== r;) {
						var i = n,
							u = i.alternate,
							s = i.stateNode;
						if (null !== u && u === r) break;
						5 === i.tag && null !== s && (i = s, l ? null != (u = Ue(n, a)) && o.unshift(jr(n, u, i)) : l || null != (u = Ue(n, a)) && o.push(jr(n, u, i))), n = n.return
					}
					0 !== o.length && e.push({
						event: t,
						listeners: o
					})
				}
				var Jr = /\r\n?/g,
					Zr = /\u0000|\uFFFD/g;

				function $r(e) {
					return ("string" === typeof e ? e : "" + e).replace(Jr, "\n").replace(Zr, "")
				}

				function Xr(e, t, n) {
					if (t = $r(t), $r(e) !== t && n) throw Error(a(425))
				}

				function qr() {}
				var el = null,
					tl = null;

				function nl(e, t) {
					return "textarea" === e || "noscript" === e || "string" === typeof t.children || "number" === typeof t.children || "object" === typeof t.dangerouslySetInnerHTML && null !== t.dangerouslySetInnerHTML && null != t.dangerouslySetInnerHTML.__html
				}
				var rl = "function" === typeof setTimeout ? setTimeout : void 0,
					ll = "function" === typeof clearTimeout ? clearTimeout : void 0,
					al = "function" === typeof Promise ? Promise : void 0,
					ol = "function" === typeof queueMicrotask ? queueMicrotask : "undefined" !== typeof al ? function(e) {
						return al.resolve(null).then(e).catch(il)
					} : rl;

				function il(e) {
					setTimeout((function() {
						throw e
					}))
				}

				function ul(e, t) {
					var n = t,
						r = 0;
					do {
						var l = n.nextSibling;
						if (e.removeChild(n), l && 8 === l.nodeType)
							if ("/$" === (n = l.data)) {
								if (0 === r) return e.removeChild(l), void _t(t);
								r--
							} else "$" !== n && "$?" !== n && "$!" !== n || r++;
						n = l
					} while (n);
					_t(t)
				}

				function sl(e) {
					for (; null != e; e = e.nextSibling) {
						var t = e.nodeType;
						if (1 === t || 3 === t) break;
						if (8 === t) {
							if ("$" === (t = e.data) || "$!" === t || "$?" === t) break;
							if ("/$" === t) return null
						}
					}
					return e
				}

				function cl(e) {
					e = e.previousSibling;
					for (var t = 0; e;) {
						if (8 === e.nodeType) {
							var n = e.data;
							if ("$" === n || "$!" === n || "$?" === n) {
								if (0 === t) return e;
								t--
							} else "/$" === n && t++
						}
						e = e.previousSibling
					}
					return null
				}
				var fl = Math.random().toString(36).slice(2),
					dl = "__reactFiber$" + fl,
					El = "__reactProps$" + fl,
					ml = "__reactContainer$" + fl,
					pl = "__reactEvents$" + fl,
					Sl = "__reactListeners$" + fl,
					Al = "__reactHandles$" + fl;

				function Ol(e) {
					var t = e[dl];
					if (t) return t;
					for (var n = e.parentNode; n;) {
						if (t = n[ml] || n[dl]) {
							if (n = t.alternate, null !== t.child || null !== n && null !== n.child)
								for (e = cl(e); null !== e;) {
									if (n = e[dl]) return n;
									e = cl(e)
								}
							return t
						}
						n = (e = n).parentNode
					}
					return null
				}

				function Rl(e) {
					return !(e = e[dl] || e[ml]) || 5 !== e.tag && 6 !== e.tag && 13 !== e.tag && 3 !== e.tag ? null : e
				}

				function Tl(e) {
					if (5 === e.tag || 6 === e.tag) return e.stateNode;
					throw Error(a(33))
				}

				function Nl(e) {
					return e[El] || null
				}
				var Il = [],
					vl = -1;

				function hl(e) {
					return {
						current: e
					}
				}

				function gl(e) {
					0 > vl || (e.current = Il[vl], Il[vl] = null, vl--)
				}

				function bl(e, t) {
					vl++, Il[vl] = e.current, e.current = t
				}
				var Cl = {},
					Ll = hl(Cl),
					yl = hl(!1),
					Pl = Cl;

				function Ml(e, t) {
					var n = e.type.contextTypes;
					if (!n) return Cl;
					var r = e.stateNode;
					if (r && r.__reactInternalMemoizedUnmaskedChildContext === t) return r.__reactInternalMemoizedMaskedChildContext;
					var l, a = {};
					for (l in n) a[l] = t[l];
					return r && ((e = e.stateNode).__reactInternalMemoizedUnmaskedChildContext = t, e.__reactInternalMemoizedMaskedChildContext = a), a
				}

				function Ul(e) {
					return null !== (e = e.childContextTypes) && void 0 !== e
				}

				function Dl() {
					gl(yl), gl(Ll)
				}

				function Hl(e, t, n) {
					if (Ll.current !== Cl) throw Error(a(168));
					bl(Ll, t), bl(yl, n)
				}

				function wl(e, t, n) {
					var r = e.stateNode;
					if (t = t.childContextTypes, "function" !== typeof r.getChildContext) return n;
					for (var l in r = r.getChildContext())
						if (!(l in t)) throw Error(a(108, K(e) || "Unknown", l));
					return k({}, n, r)
				}

				function Gl(e) {
					return e = (e = e.stateNode) && e.__reactInternalMemoizedMergedChildContext || Cl, Pl = Ll.current, bl(Ll, e), bl(yl, yl.current), !0
				}

				function kl(e, t, n) {
					var r = e.stateNode;
					if (!r) throw Error(a(169));
					n ? (e = wl(e, t, Pl), r.__reactInternalMemoizedMergedChildContext = e, gl(yl), gl(Ll), bl(Ll, e)) : gl(yl), bl(yl, n)
				}
				var Bl = null,
					xl = !1,
					Fl = !1;

				function Yl(e) {
					null === Bl ? Bl = [e] : Bl.push(e)
				}

				function _l() {
					if (!Fl && null !== Bl) {
						Fl = !0;
						var e = 0,
							t = Rt;
						try {
							var n = Bl;
							for (Rt = 1; e < n.length; e++) {
								var r = n[e];
								do {
									r = r(!0)
								} while (null !== r)
							}
							Bl = null, xl = !1
						} catch (l) {
							throw null !== Bl && (Bl = Bl.slice(e + 1)), ze(qe, _l), l
						} finally {
							Rt = t, Fl = !1
						}
					}
					return null
				}
				var Kl = [],
					Wl = 0,
					jl = null,
					Vl = 0,
					zl = [],
					Ql = 0,
					Jl = null,
					Zl = 1,
					$l = "";

				function Xl(e, t) {
					Kl[Wl++] = Vl, Kl[Wl++] = jl, jl = e, Vl = t
				}

				function ql(e, t, n) {
					zl[Ql++] = Zl, zl[Ql++] = $l, zl[Ql++] = Jl, Jl = e;
					var r = Zl;
					e = $l;
					var l = 32 - ot(r) - 1;
					r &= ~(1 << l), n += 1;
					var a = 32 - ot(t) + l;
					if (30 < a) {
						var o = l - l % 5;
						a = (r & (1 << o) - 1).toString(32), r >>= o, l -= o, Zl = 1 << 32 - ot(t) + l | n << l | r, $l = a + e
					} else Zl = 1 << a | n << l | r, $l = e
				}

				function ea(e) {
					null !== e.return && (Xl(e, 1), ql(e, 1, 0))
				}

				function ta(e) {
					for (; e === jl;) jl = Kl[--Wl], Kl[Wl] = null, Vl = Kl[--Wl], Kl[Wl] = null;
					for (; e === Jl;) Jl = zl[--Ql], zl[Ql] = null, $l = zl[--Ql], zl[Ql] = null, Zl = zl[--Ql], zl[Ql] = null
				}
				var na = null,
					ra = null,
					la = !1,
					aa = null;

				function oa(e, t) {
					var n = Us(5, null, null, 0);
					n.elementType = "DELETED", n.stateNode = t, n.return = e, null === (t = e.deletions) ? (e.deletions = [n], e.flags |= 16) : t.push(n)
				}

				function ia(e, t) {
					switch (e.tag) {
						case 5:
							var n = e.type;
							return null !== (t = 1 !== t.nodeType || n.toLowerCase() !== t.nodeName.toLowerCase() ? null : t) && (e.stateNode = t, na = e, ra = sl(t.firstChild), !0);
						case 6:
							return null !== (t = "" === e.pendingProps || 3 !== t.nodeType ? null : t) && (e.stateNode = t, na = e, ra = null, !0);
						case 13:
							return null !== (t = 8 !== t.nodeType ? null : t) && (n = null !== Jl ? {
								id: Zl,
								overflow: $l
							} : null, e.memoizedState = {
								dehydrated: t,
								treeContext: n,
								retryLane: 1073741824
							}, (n = Us(18, null, null, 0)).stateNode = t, n.return = e, e.child = n, na = e, ra = null, !0);
						default:
							return !1
					}
				}

				function ua(e) {
					return 0 !== (1 & e.mode) && 0 === (128 & e.flags)
				}

				function sa(e) {
					if (la) {
						var t = ra;
						if (t) {
							var n = t;
							if (!ia(e, t)) {
								if (ua(e)) throw Error(a(418));
								t = sl(n.nextSibling);
								var r = na;
								t && ia(e, t) ? oa(r, n) : (e.flags = -4097 & e.flags | 2, la = !1, na = e)
							}
						} else {
							if (ua(e)) throw Error(a(418));
							e.flags = -4097 & e.flags | 2, la = !1, na = e
						}
					}
				}

				function ca(e) {
					for (e = e.return; null !== e && 5 !== e.tag && 3 !== e.tag && 13 !== e.tag;) e = e.return;
					na = e
				}

				function fa(e) {
					if (e !== na) return !1;
					if (!la) return ca(e), la = !0, !1;
					var t;
					if ((t = 3 !== e.tag) && !(t = 5 !== e.tag) && (t = "head" !== (t = e.type) && "body" !== t && !nl(e.type, e.memoizedProps)), t && (t = ra)) {
						if (ua(e)) throw da(), Error(a(418));
						for (; t;) oa(e, t), t = sl(t.nextSibling)
					}
					if (ca(e), 13 === e.tag) {
						if (!(e = null !== (e = e.memoizedState) ? e.dehydrated : null)) throw Error(a(317));
						e: {
							for (e = e.nextSibling, t = 0; e;) {
								if (8 === e.nodeType) {
									var n = e.data;
									if ("/$" === n) {
										if (0 === t) {
											ra = sl(e.nextSibling);
											break e
										}
										t--
									} else "$" !== n && "$!" !== n && "$?" !== n || t++
								}
								e = e.nextSibling
							}
							ra = null
						}
					} else ra = na ? sl(e.stateNode.nextSibling) : null;
					return !0
				}

				function da() {
					for (var e = ra; e;) e = sl(e.nextSibling)
				}

				function Ea() {
					ra = na = null, la = !1
				}

				function ma(e) {
					null === aa ? aa = [e] : aa.push(e)
				}
				var pa = T.ReactCurrentBatchConfig;

				function Sa(e, t) {
					if (e && e.defaultProps) {
						for (var n in t = k({}, t), e = e.defaultProps) void 0 === t[n] && (t[n] = e[n]);
						return t
					}
					return t
				}
				var Aa = hl(null),
					Oa = null,
					Ra = null,
					Ta = null;

				function Na() {
					Ta = Ra = Oa = null
				}

				function Ia(e) {
					var t = Aa.current;
					gl(Aa), e._currentValue = t
				}

				function va(e, t, n) {
					for (; null !== e;) {
						var r = e.alternate;
						if ((e.childLanes & t) !== t ? (e.childLanes |= t, null !== r && (r.childLanes |= t)) : null !== r && (r.childLanes & t) !== t && (r.childLanes |= t), e === n) break;
						e = e.return
					}
				}

				function ha(e, t) {
					Oa = e, Ta = Ra = null, null !== (e = e.dependencies) && null !== e.firstContext && (0 !== (e.lanes & t) && (Ti = !0), e.firstContext = null)
				}

				function ga(e) {
					var t = e._currentValue;
					if (Ta !== e)
						if (e = {
								context: e,
								memoizedValue: t,
								next: null
							}, null === Ra) {
							if (null === Oa) throw Error(a(308));
							Ra = e, Oa.dependencies = {
								lanes: 0,
								firstContext: e
							}
						} else Ra = Ra.next = e;
					return t
				}
				var ba = null;

				function Ca(e) {
					null === ba ? ba = [e] : ba.push(e)
				}

				function La(e, t, n, r) {
					var l = t.interleaved;
					return null === l ? (n.next = n, Ca(t)) : (n.next = l.next, l.next = n), t.interleaved = n, ya(e, r)
				}

				function ya(e, t) {
					e.lanes |= t;
					var n = e.alternate;
					for (null !== n && (n.lanes |= t), n = e, e = e.return; null !== e;) e.childLanes |= t, null !== (n = e.alternate) && (n.childLanes |= t), n = e, e = e.return;
					return 3 === n.tag ? n.stateNode : null
				}
				var Pa = !1;

				function Ma(e) {
					e.updateQueue = {
						baseState: e.memoizedState,
						firstBaseUpdate: null,
						lastBaseUpdate: null,
						shared: {
							pending: null,
							interleaved: null,
							lanes: 0
						},
						effects: null
					}
				}

				function Ua(e, t) {
					e = e.updateQueue, t.updateQueue === e && (t.updateQueue = {
						baseState: e.baseState,
						firstBaseUpdate: e.firstBaseUpdate,
						lastBaseUpdate: e.lastBaseUpdate,
						shared: e.shared,
						effects: e.effects
					})
				}

				function Da(e, t) {
					return {
						eventTime: e,
						lane: t,
						tag: 0,
						payload: null,
						callback: null,
						next: null
					}
				}

				function Ha(e, t, n) {
					var r = e.updateQueue;
					if (null === r) return null;
					if (r = r.shared, 0 !== (2 & yu)) {
						var l = r.pending;
						return null === l ? t.next = t : (t.next = l.next, l.next = t), r.pending = t, ya(e, n)
					}
					return null === (l = r.interleaved) ? (t.next = t, Ca(r)) : (t.next = l.next, l.next = t), r.interleaved = t, ya(e, n)
				}

				function wa(e, t, n) {
					if (null !== (t = t.updateQueue) && (t = t.shared, 0 !== (4194240 & n))) {
						var r = t.lanes;
						n |= r &= e.pendingLanes, t.lanes = n, Ot(e, n)
					}
				}

				function Ga(e, t) {
					var n = e.updateQueue,
						r = e.alternate;
					if (null !== r && n === (r = r.updateQueue)) {
						var l = null,
							a = null;
						if (null !== (n = n.firstBaseUpdate)) {
							do {
								var o = {
									eventTime: n.eventTime,
									lane: n.lane,
									tag: n.tag,
									payload: n.payload,
									callback: n.callback,
									next: null
								};
								null === a ? l = a = o : a = a.next = o, n = n.next
							} while (null !== n);
							null === a ? l = a = t : a = a.next = t
						} else l = a = t;
						return n = {
							baseState: r.baseState,
							firstBaseUpdate: l,
							lastBaseUpdate: a,
							shared: r.shared,
							effects: r.effects
						}, void(e.updateQueue = n)
					}
					null === (e = n.lastBaseUpdate) ? n.firstBaseUpdate = t : e.next = t, n.lastBaseUpdate = t
				}

				function ka(e, t, n, r) {
					var l = e.updateQueue;
					Pa = !1;
					var a = l.firstBaseUpdate,
						o = l.lastBaseUpdate,
						i = l.shared.pending;
					if (null !== i) {
						l.shared.pending = null;
						var u = i,
							s = u.next;
						u.next = null, null === o ? a = s : o.next = s, o = u;
						var c = e.alternate;
						null !== c && ((i = (c = c.updateQueue).lastBaseUpdate) !== o && (null === i ? c.firstBaseUpdate = s : i.next = s, c.lastBaseUpdate = u))
					}
					if (null !== a) {
						var f = l.baseState;
						for (o = 0, c = s = u = null, i = a;;) {
							var d = i.lane,
								E = i.eventTime;
							if ((r & d) === d) {
								null !== c && (c = c.next = {
									eventTime: E,
									lane: 0,
									tag: i.tag,
									payload: i.payload,
									callback: i.callback,
									next: null
								});
								e: {
									var m = e,
										p = i;
									switch (d = t, E = n, p.tag) {
										case 1:
											if ("function" === typeof(m = p.payload)) {
												f = m.call(E, f, d);
												break e
											}
											f = m;
											break e;
										case 3:
											m.flags = -65537 & m.flags | 128;
										case 0:
											if (null === (d = "function" === typeof(m = p.payload) ? m.call(E, f, d) : m) || void 0 === d) break e;
											f = k({}, f, d);
											break e;
										case 2:
											Pa = !0
									}
								}
								null !== i.callback && 0 !== i.lane && (e.flags |= 64, null === (d = l.effects) ? l.effects = [i] : d.push(i))
							} else E = {
								eventTime: E,
								lane: d,
								tag: i.tag,
								payload: i.payload,
								callback: i.callback,
								next: null
							}, null === c ? (s = c = E, u = f) : c = c.next = E, o |= d;
							if (null === (i = i.next)) {
								if (null === (i = l.shared.pending)) break;
								i = (d = i).next, d.next = null, l.lastBaseUpdate = d, l.shared.pending = null
							}
						}
						if (null === c && (u = f), l.baseState = u, l.firstBaseUpdate = s, l.lastBaseUpdate = c, null !== (t = l.shared.interleaved)) {
							l = t;
							do {
								o |= l.lane, l = l.next
							} while (l !== t)
						} else null === a && (l.shared.lanes = 0);
						ku |= o, e.lanes = o, e.memoizedState = f
					}
				}

				function Ba(e, t, n) {
					if (e = t.effects, t.effects = null, null !== e)
						for (t = 0; t < e.length; t++) {
							var r = e[t],
								l = r.callback;
							if (null !== l) {
								if (r.callback = null, r = n, "function" !== typeof l) throw Error(a(191, l));
								l.call(r)
							}
						}
				}
				var xa = (new r.Component).refs;

				function Fa(e, t, n, r) {
					n = null === (n = n(r, t = e.memoizedState)) || void 0 === n ? t : k({}, t, n), e.memoizedState = n, 0 === e.lanes && (e.updateQueue.baseState = n)
				}
				var Ya = {
					isMounted: function(e) {
						return !!(e = e._reactInternals) && _e(e) === e
					},
					enqueueSetState: function(e, t, n) {
						e = e._reactInternals;
						var r = ts(),
							l = ns(e),
							a = Da(r, l);
						a.payload = t, void 0 !== n && null !== n && (a.callback = n), null !== (t = Ha(e, a, l)) && (rs(t, e, l, r), wa(t, e, l))
					},
					enqueueReplaceState: function(e, t, n) {
						e = e._reactInternals;
						var r = ts(),
							l = ns(e),
							a = Da(r, l);
						a.tag = 1, a.payload = t, void 0 !== n && null !== n && (a.callback = n), null !== (t = Ha(e, a, l)) && (rs(t, e, l, r), wa(t, e, l))
					},
					enqueueForceUpdate: function(e, t) {
						e = e._reactInternals;
						var n = ts(),
							r = ns(e),
							l = Da(n, r);
						l.tag = 2, void 0 !== t && null !== t && (l.callback = t), null !== (t = Ha(e, l, r)) && (rs(t, e, r, n), wa(t, e, r))
					}
				};

				function _a(e, t, n, r, l, a, o) {
					return "function" === typeof(e = e.stateNode).shouldComponentUpdate ? e.shouldComponentUpdate(r, a, o) : !t.prototype || !t.prototype.isPureReactComponent || (!ur(n, r) || !ur(l, a))
				}

				function Ka(e, t, n) {
					var r = !1,
						l = Cl,
						a = t.contextType;
					return "object" === typeof a && null !== a ? a = ga(a) : (l = Ul(t) ? Pl : Ll.current, a = (r = null !== (r = t.contextTypes) && void 0 !== r) ? Ml(e, l) : Cl), t = new t(n, a), e.memoizedState = null !== t.state && void 0 !== t.state ? t.state : null, t.updater = Ya, e.stateNode = t, t._reactInternals = e, r && ((e = e.stateNode).__reactInternalMemoizedUnmaskedChildContext = l, e.__reactInternalMemoizedMaskedChildContext = a), t
				}

				function Wa(e, t, n, r) {
					e = t.state, "function" === typeof t.componentWillReceiveProps && t.componentWillReceiveProps(n, r), "function" === typeof t.UNSAFE_componentWillReceiveProps && t.UNSAFE_componentWillReceiveProps(n, r), t.state !== e && Ya.enqueueReplaceState(t, t.state, null)
				}

				function ja(e, t, n, r) {
					var l = e.stateNode;
					l.props = n, l.state = e.memoizedState, l.refs = xa, Ma(e);
					var a = t.contextType;
					"object" === typeof a && null !== a ? l.context = ga(a) : (a = Ul(t) ? Pl : Ll.current, l.context = Ml(e, a)), l.state = e.memoizedState, "function" === typeof(a = t.getDerivedStateFromProps) && (Fa(e, t, a, n), l.state = e.memoizedState), "function" === typeof t.getDerivedStateFromProps || "function" === typeof l.getSnapshotBeforeUpdate || "function" !== typeof l.UNSAFE_componentWillMount && "function" !== typeof l.componentWillMount || (t = l.state, "function" === typeof l.componentWillMount && l.componentWillMount(), "function" === typeof l.UNSAFE_componentWillMount && l.UNSAFE_componentWillMount(), t !== l.state && Ya.enqueueReplaceState(l, l.state, null), ka(e, n, l, r), l.state = e.memoizedState), "function" === typeof l.componentDidMount && (e.flags |= 4194308)
				}

				function Va(e, t, n) {
					if (null !== (e = n.ref) && "function" !== typeof e && "object" !== typeof e) {
						if (n._owner) {
							if (n = n._owner) {
								if (1 !== n.tag) throw Error(a(309));
								var r = n.stateNode
							}
							if (!r) throw Error(a(147, e));
							var l = r,
								o = "" + e;
							return null !== t && null !== t.ref && "function" === typeof t.ref && t.ref._stringRef === o ? t.ref : (t = function(e) {
								var t = l.refs;
								t === xa && (t = l.refs = {}), null === e ? delete t[o] : t[o] = e
							}, t._stringRef = o, t)
						}
						if ("string" !== typeof e) throw Error(a(284));
						if (!n._owner) throw Error(a(290, e))
					}
					return e
				}

				function za(e, t) {
					throw e = Object.prototype.toString.call(t), Error(a(31, "[object Object]" === e ? "object with keys {" + Object.keys(t).join(", ") + "}" : e))
				}

				function Qa(e) {
					return (0, e._init)(e._payload)
				}

				function Ja(e) {
					function t(t, n) {
						if (e) {
							var r = t.deletions;
							null === r ? (t.deletions = [n], t.flags |= 16) : r.push(n)
						}
					}

					function n(n, r) {
						if (!e) return null;
						for (; null !== r;) t(n, r), r = r.sibling;
						return null
					}

					function r(e, t) {
						for (e = new Map; null !== t;) null !== t.key ? e.set(t.key, t) : e.set(t.index, t), t = t.sibling;
						return e
					}

					function l(e, t) {
						return (e = Hs(e, t)).index = 0, e.sibling = null, e
					}

					function o(t, n, r) {
						return t.index = r, e ? null !== (r = t.alternate) ? (r = r.index) < n ? (t.flags |= 2, n) : r : (t.flags |= 2, n) : (t.flags |= 1048576, n)
					}

					function i(t) {
						return e && null === t.alternate && (t.flags |= 2), t
					}

					function u(e, t, n, r) {
						return null === t || 6 !== t.tag ? ((t = Bs(n, e.mode, r)).return = e, t) : ((t = l(t, n)).return = e, t)
					}

					function s(e, t, n, r) {
						var a = n.type;
						return a === v ? f(e, t, n.props.children, r, n.key) : null !== t && (t.elementType === a || "object" === typeof a && null !== a && a.$$typeof === U && Qa(a) === t.type) ? ((r = l(t, n.props)).ref = Va(e, t, n), r.return = e, r) : ((r = ws(n.type, n.key, n.props, null, e.mode, r)).ref = Va(e, t, n), r.return = e, r)
					}

					function c(e, t, n, r) {
						return null === t || 4 !== t.tag || t.stateNode.containerInfo !== n.containerInfo || t.stateNode.implementation !== n.implementation ? ((t = xs(n, e.mode, r)).return = e, t) : ((t = l(t, n.children || [])).return = e, t)
					}

					function f(e, t, n, r, a) {
						return null === t || 7 !== t.tag ? ((t = Gs(n, e.mode, r, a)).return = e, t) : ((t = l(t, n)).return = e, t)
					}

					function d(e, t, n) {
						if ("string" === typeof t && "" !== t || "number" === typeof t) return (t = Bs("" + t, e.mode, n)).return = e, t;
						if ("object" === typeof t && null !== t) {
							switch (t.$$typeof) {
								case N:
									return (n = ws(t.type, t.key, t.props, null, e.mode, n)).ref = Va(e, null, t), n.return = e, n;
								case I:
									return (t = xs(t, e.mode, n)).return = e, t;
								case U:
									return d(e, (0, t._init)(t._payload), n)
							}
							if (te(t) || w(t)) return (t = Gs(t, e.mode, n, null)).return = e, t;
							za(e, t)
						}
						return null
					}

					function E(e, t, n, r) {
						var l = null !== t ? t.key : null;
						if ("string" === typeof n && "" !== n || "number" === typeof n) return null !== l ? null : u(e, t, "" + n, r);
						if ("object" === typeof n && null !== n) {
							switch (n.$$typeof) {
								case N:
									return n.key === l ? s(e, t, n, r) : null;
								case I:
									return n.key === l ? c(e, t, n, r) : null;
								case U:
									return E(e, t, (l = n._init)(n._payload), r)
							}
							if (te(n) || w(n)) return null !== l ? null : f(e, t, n, r, null);
							za(e, n)
						}
						return null
					}

					function m(e, t, n, r, l) {
						if ("string" === typeof r && "" !== r || "number" === typeof r) return u(t, e = e.get(n) || null, "" + r, l);
						if ("object" === typeof r && null !== r) {
							switch (r.$$typeof) {
								case N:
									return s(t, e = e.get(null === r.key ? n : r.key) || null, r, l);
								case I:
									return c(t, e = e.get(null === r.key ? n : r.key) || null, r, l);
								case U:
									return m(e, t, n, (0, r._init)(r._payload), l)
							}
							if (te(r) || w(r)) return f(t, e = e.get(n) || null, r, l, null);
							za(t, r)
						}
						return null
					}

					function p(l, a, i, u) {
						for (var s = null, c = null, f = a, p = a = 0, S = null; null !== f && p < i.length; p++) {
							f.index > p ? (S = f, f = null) : S = f.sibling;
							var A = E(l, f, i[p], u);
							if (null === A) {
								null === f && (f = S);
								break
							}
							e && f && null === A.alternate && t(l, f), a = o(A, a, p), null === c ? s = A : c.sibling = A, c = A, f = S
						}
						if (p === i.length) return n(l, f), la && Xl(l, p), s;
						if (null === f) {
							for (; p < i.length; p++) null !== (f = d(l, i[p], u)) && (a = o(f, a, p), null === c ? s = f : c.sibling = f, c = f);
							return la && Xl(l, p), s
						}
						for (f = r(l, f); p < i.length; p++) null !== (S = m(f, l, p, i[p], u)) && (e && null !== S.alternate && f.delete(null === S.key ? p : S.key), a = o(S, a, p), null === c ? s = S : c.sibling = S, c = S);
						return e && f.forEach((function(e) {
							return t(l, e)
						})), la && Xl(l, p), s
					}

					function S(l, i, u, s) {
						var c = w(u);
						if ("function" !== typeof c) throw Error(a(150));
						if (null == (u = c.call(u))) throw Error(a(151));
						for (var f = c = null, p = i, S = i = 0, A = null, O = u.next(); null !== p && !O.done; S++, O = u.next()) {
							p.index > S ? (A = p, p = null) : A = p.sibling;
							var R = E(l, p, O.value, s);
							if (null === R) {
								null === p && (p = A);
								break
							}
							e && p && null === R.alternate && t(l, p), i = o(R, i, S), null === f ? c = R : f.sibling = R, f = R, p = A
						}
						if (O.done) return n(l, p), la && Xl(l, S), c;
						if (null === p) {
							for (; !O.done; S++, O = u.next()) null !== (O = d(l, O.value, s)) && (i = o(O, i, S), null === f ? c = O : f.sibling = O, f = O);
							return la && Xl(l, S), c
						}
						for (p = r(l, p); !O.done; S++, O = u.next()) null !== (O = m(p, l, S, O.value, s)) && (e && null !== O.alternate && p.delete(null === O.key ? S : O.key), i = o(O, i, S), null === f ? c = O : f.sibling = O, f = O);
						return e && p.forEach((function(e) {
							return t(l, e)
						})), la && Xl(l, S), c
					}
					return function e(r, a, o, u) {
						if ("object" === typeof o && null !== o && o.type === v && null === o.key && (o = o.props.children), "object" === typeof o && null !== o) {
							switch (o.$$typeof) {
								case N:
									e: {
										for (var s = o.key, c = a; null !== c;) {
											if (c.key === s) {
												if ((s = o.type) === v) {
													if (7 === c.tag) {
														n(r, c.sibling), (a = l(c, o.props.children)).return = r, r = a;
														break e
													}
												} else if (c.elementType === s || "object" === typeof s && null !== s && s.$$typeof === U && Qa(s) === c.type) {
													n(r, c.sibling), (a = l(c, o.props)).ref = Va(r, c, o), a.return = r, r = a;
													break e
												}
												n(r, c);
												break
											}
											t(r, c), c = c.sibling
										}
										o.type === v ? ((a = Gs(o.props.children, r.mode, u, o.key)).return = r, r = a) : ((u = ws(o.type, o.key, o.props, null, r.mode, u)).ref = Va(r, a, o), u.return = r, r = u)
									}
									return i(r);
								case I:
									e: {
										for (c = o.key; null !== a;) {
											if (a.key === c) {
												if (4 === a.tag && a.stateNode.containerInfo === o.containerInfo && a.stateNode.implementation === o.implementation) {
													n(r, a.sibling), (a = l(a, o.children || [])).return = r, r = a;
													break e
												}
												n(r, a);
												break
											}
											t(r, a), a = a.sibling
										}(a = xs(o, r.mode, u)).return = r,
										r = a
									}
									return i(r);
								case U:
									return e(r, a, (c = o._init)(o._payload), u)
							}
							if (te(o)) return p(r, a, o, u);
							if (w(o)) return S(r, a, o, u);
							za(r, o)
						}
						return "string" === typeof o && "" !== o || "number" === typeof o ? (o = "" + o, null !== a && 6 === a.tag ? (n(r, a.sibling), (a = l(a, o)).return = r, r = a) : (n(r, a), (a = Bs(o, r.mode, u)).return = r, r = a), i(r)) : n(r, a)
					}
				}
				var Za = Ja(!0),
					$a = Ja(!1),
					Xa = {},
					qa = hl(Xa),
					eo = hl(Xa),
					to = hl(Xa);

				function no(e) {
					if (e === Xa) throw Error(a(174));
					return e
				}

				function ro(e, t) {
					switch (bl(to, t), bl(eo, e), bl(qa, Xa), e = t.nodeType) {
						case 9:
						case 11:
							t = (t = t.documentElement) ? t.namespaceURI : ue(null, "");
							break;
						default:
							t = ue(t = (e = 8 === e ? t.parentNode : t).namespaceURI || null, e = e.tagName)
					}
					gl(qa), bl(qa, t)
				}

				function lo() {
					gl(qa), gl(eo), gl(to)
				}

				function ao(e) {
					no(to.current);
					var t = no(qa.current),
						n = ue(t, e.type);
					t !== n && (bl(eo, e), bl(qa, n))
				}

				function oo(e) {
					eo.current === e && (gl(qa), gl(eo))
				}
				var io = hl(0);

				function uo(e) {
					for (var t = e; null !== t;) {
						if (13 === t.tag) {
							var n = t.memoizedState;
							if (null !== n && (null === (n = n.dehydrated) || "$?" === n.data || "$!" === n.data)) return t
						} else if (19 === t.tag && void 0 !== t.memoizedProps.revealOrder) {
							if (0 !== (128 & t.flags)) return t
						} else if (null !== t.child) {
							t.child.return = t, t = t.child;
							continue
						}
						if (t === e) break;
						for (; null === t.sibling;) {
							if (null === t.return || t.return === e) return null;
							t = t.return
						}
						t.sibling.return = t.return, t = t.sibling
					}
					return null
				}
				var so = [];

				function co() {
					for (var e = 0; e < so.length; e++) so[e]._workInProgressVersionPrimary = null;
					so.length = 0
				}
				var fo = T.ReactCurrentDispatcher,
					Eo = T.ReactCurrentBatchConfig,
					mo = 0,
					po = null,
					So = null,
					Ao = null,
					Oo = !1,
					Ro = !1,
					To = 0,
					No = 0;

				function Io() {
					throw Error(a(321))
				}

				function vo(e, t) {
					if (null === t) return !1;
					for (var n = 0; n < t.length && n < e.length; n++)
						if (!ir(e[n], t[n])) return !1;
					return !0
				}

				function ho(e, t, n, r, l, o) {
					if (mo = o, po = t, t.memoizedState = null, t.updateQueue = null, t.lanes = 0, fo.current = null === e || null === e.memoizedState ? ii : ui, e = n(r, l), Ro) {
						o = 0;
						do {
							if (Ro = !1, To = 0, 25 <= o) throw Error(a(301));
							o += 1, Ao = So = null, t.updateQueue = null, fo.current = si, e = n(r, l)
						} while (Ro)
					}
					if (fo.current = oi, t = null !== So && null !== So.next, mo = 0, Ao = So = po = null, Oo = !1, t) throw Error(a(300));
					return e
				}

				function go() {
					var e = 0 !== To;
					return To = 0, e
				}

				function bo() {
					var e = {
						memoizedState: null,
						baseState: null,
						baseQueue: null,
						queue: null,
						next: null
					};
					return null === Ao ? po.memoizedState = Ao = e : Ao = Ao.next = e, Ao
				}

				function Co() {
					if (null === So) {
						var e = po.alternate;
						e = null !== e ? e.memoizedState : null
					} else e = So.next;
					var t = null === Ao ? po.memoizedState : Ao.next;
					if (null !== t) Ao = t, So = e;
					else {
						if (null === e) throw Error(a(310));
						e = {
							memoizedState: (So = e).memoizedState,
							baseState: So.baseState,
							baseQueue: So.baseQueue,
							queue: So.queue,
							next: null
						}, null === Ao ? po.memoizedState = Ao = e : Ao = Ao.next = e
					}
					return Ao
				}

				function Lo(e, t) {
					return "function" === typeof t ? t(e) : t
				}

				function yo(e) {
					var t = Co(),
						n = t.queue;
					if (null === n) throw Error(a(311));
					n.lastRenderedReducer = e;
					var r = So,
						l = r.baseQueue,
						o = n.pending;
					if (null !== o) {
						if (null !== l) {
							var i = l.next;
							l.next = o.next, o.next = i
						}
						r.baseQueue = l = o, n.pending = null
					}
					if (null !== l) {
						o = l.next, r = r.baseState;
						var u = i = null,
							s = null,
							c = o;
						do {
							var f = c.lane;
							if ((mo & f) === f) null !== s && (s = s.next = {
								lane: 0,
								action: c.action,
								hasEagerState: c.hasEagerState,
								eagerState: c.eagerState,
								next: null
							}), r = c.hasEagerState ? c.eagerState : e(r, c.action);
							else {
								var d = {
									lane: f,
									action: c.action,
									hasEagerState: c.hasEagerState,
									eagerState: c.eagerState,
									next: null
								};
								null === s ? (u = s = d, i = r) : s = s.next = d, po.lanes |= f, ku |= f
							}
							c = c.next
						} while (null !== c && c !== o);
						null === s ? i = r : s.next = u, ir(r, t.memoizedState) || (Ti = !0), t.memoizedState = r, t.baseState = i, t.baseQueue = s, n.lastRenderedState = r
					}
					if (null !== (e = n.interleaved)) {
						l = e;
						do {
							o = l.lane, po.lanes |= o, ku |= o, l = l.next
						} while (l !== e)
					} else null === l && (n.lanes = 0);
					return [t.memoizedState, n.dispatch]
				}

				function Po(e) {
					var t = Co(),
						n = t.queue;
					if (null === n) throw Error(a(311));
					n.lastRenderedReducer = e;
					var r = n.dispatch,
						l = n.pending,
						o = t.memoizedState;
					if (null !== l) {
						n.pending = null;
						var i = l = l.next;
						do {
							o = e(o, i.action), i = i.next
						} while (i !== l);
						ir(o, t.memoizedState) || (Ti = !0), t.memoizedState = o, null === t.baseQueue && (t.baseState = o), n.lastRenderedState = o
					}
					return [o, r]
				}

				function Mo() {}

				function Uo(e, t) {
					var n = po,
						r = Co(),
						l = t(),
						o = !ir(r.memoizedState, l);
					if (o && (r.memoizedState = l, Ti = !0), r = r.queue, Wo(wo.bind(null, n, r, e), [e]), r.getSnapshot !== t || o || null !== Ao && 1 & Ao.memoizedState.tag) {
						if (n.flags |= 2048, xo(9, Ho.bind(null, n, r, l, t), void 0, null), null === Pu) throw Error(a(349));
						0 !== (30 & mo) || Do(n, t, l)
					}
					return l
				}

				function Do(e, t, n) {
					e.flags |= 16384, e = {
						getSnapshot: t,
						value: n
					}, null === (t = po.updateQueue) ? (t = {
						lastEffect: null,
						stores: null
					}, po.updateQueue = t, t.stores = [e]) : null === (n = t.stores) ? t.stores = [e] : n.push(e)
				}

				function Ho(e, t, n, r) {
					t.value = n, t.getSnapshot = r, Go(t) && ko(e)
				}

				function wo(e, t, n) {
					return n((function() {
						Go(t) && ko(e)
					}))
				}

				function Go(e) {
					var t = e.getSnapshot;
					e = e.value;
					try {
						var n = t();
						return !ir(e, n)
					} catch (r) {
						return !0
					}
				}

				function ko(e) {
					var t = ya(e, 1);
					null !== t && rs(t, e, 1, -1)
				}

				function Bo(e) {
					var t = bo();
					return "function" === typeof e && (e = e()), t.memoizedState = t.baseState = e, e = {
						pending: null,
						interleaved: null,
						lanes: 0,
						dispatch: null,
						lastRenderedReducer: Lo,
						lastRenderedState: e
					}, t.queue = e, e = e.dispatch = ni.bind(null, po, e), [t.memoizedState, e]
				}

				function xo(e, t, n, r) {
					return e = {
						tag: e,
						create: t,
						destroy: n,
						deps: r,
						next: null
					}, null === (t = po.updateQueue) ? (t = {
						lastEffect: null,
						stores: null
					}, po.updateQueue = t, t.lastEffect = e.next = e) : null === (n = t.lastEffect) ? t.lastEffect = e.next = e : (r = n.next, n.next = e, e.next = r, t.lastEffect = e), e
				}

				function Fo() {
					return Co().memoizedState
				}

				function Yo(e, t, n, r) {
					var l = bo();
					po.flags |= e, l.memoizedState = xo(1 | t, n, void 0, void 0 === r ? null : r)
				}

				function _o(e, t, n, r) {
					var l = Co();
					r = void 0 === r ? null : r;
					var a = void 0;
					if (null !== So) {
						var o = So.memoizedState;
						if (a = o.destroy, null !== r && vo(r, o.deps)) return void(l.memoizedState = xo(t, n, a, r))
					}
					po.flags |= e, l.memoizedState = xo(1 | t, n, a, r)
				}

				function Ko(e, t) {
					return Yo(8390656, 8, e, t)
				}

				function Wo(e, t) {
					return _o(2048, 8, e, t)
				}

				function jo(e, t) {
					return _o(4, 2, e, t)
				}

				function Vo(e, t) {
					return _o(4, 4, e, t)
				}

				function zo(e, t) {
					return "function" === typeof t ? (e = e(), t(e), function() {
						t(null)
					}) : null !== t && void 0 !== t ? (e = e(), t.current = e, function() {
						t.current = null
					}) : void 0
				}

				function Qo(e, t, n) {
					return n = null !== n && void 0 !== n ? n.concat([e]) : null, _o(4, 4, zo.bind(null, t, e), n)
				}

				function Jo() {}

				function Zo(e, t) {
					var n = Co();
					t = void 0 === t ? null : t;
					var r = n.memoizedState;
					return null !== r && null !== t && vo(t, r[1]) ? r[0] : (n.memoizedState = [e, t], e)
				}

				function $o(e, t) {
					var n = Co();
					t = void 0 === t ? null : t;
					var r = n.memoizedState;
					return null !== r && null !== t && vo(t, r[1]) ? r[0] : (e = e(), n.memoizedState = [e, t], e)
				}

				function Xo(e, t, n) {
					return 0 === (21 & mo) ? (e.baseState && (e.baseState = !1, Ti = !0), e.memoizedState = n) : (ir(n, t) || (n = pt(), po.lanes |= n, ku |= n, e.baseState = !0), t)
				}

				function qo(e, t) {
					var n = Rt;
					Rt = 0 !== n && 4 > n ? n : 4, e(!0);
					var r = Eo.transition;
					Eo.transition = {};
					try {
						e(!1), t()
					} finally {
						Rt = n, Eo.transition = r
					}
				}

				function ei() {
					return Co().memoizedState
				}

				function ti(e, t, n) {
					var r = ns(e);
					if (n = {
							lane: r,
							action: n,
							hasEagerState: !1,
							eagerState: null,
							next: null
						}, ri(e)) li(t, n);
					else if (null !== (n = La(e, t, n, r))) {
						rs(n, e, r, ts()), ai(n, t, r)
					}
				}

				function ni(e, t, n) {
					var r = ns(e),
						l = {
							lane: r,
							action: n,
							hasEagerState: !1,
							eagerState: null,
							next: null
						};
					if (ri(e)) li(t, l);
					else {
						var a = e.alternate;
						if (0 === e.lanes && (null === a || 0 === a.lanes) && null !== (a = t.lastRenderedReducer)) try {
							var o = t.lastRenderedState,
								i = a(o, n);
							if (l.hasEagerState = !0, l.eagerState = i, ir(i, o)) {
								var u = t.interleaved;
								return null === u ? (l.next = l, Ca(t)) : (l.next = u.next, u.next = l), void(t.interleaved = l)
							}
						} catch (s) {}
						null !== (n = La(e, t, l, r)) && (rs(n, e, r, l = ts()), ai(n, t, r))
					}
				}

				function ri(e) {
					var t = e.alternate;
					return e === po || null !== t && t === po
				}

				function li(e, t) {
					Ro = Oo = !0;
					var n = e.pending;
					null === n ? t.next = t : (t.next = n.next, n.next = t), e.pending = t
				}

				function ai(e, t, n) {
					if (0 !== (4194240 & n)) {
						var r = t.lanes;
						n |= r &= e.pendingLanes, t.lanes = n, Ot(e, n)
					}
				}
				var oi = {
						readContext: ga,
						useCallback: Io,
						useContext: Io,
						useEffect: Io,
						useImperativeHandle: Io,
						useInsertionEffect: Io,
						useLayoutEffect: Io,
						useMemo: Io,
						useReducer: Io,
						useRef: Io,
						useState: Io,
						useDebugValue: Io,
						useDeferredValue: Io,
						useTransition: Io,
						useMutableSource: Io,
						useSyncExternalStore: Io,
						useId: Io,
						unstable_isNewReconciler: !1
					},
					ii = {
						readContext: ga,
						useCallback: function(e, t) {
							return bo().memoizedState = [e, void 0 === t ? null : t], e
						},
						useContext: ga,
						useEffect: Ko,
						useImperativeHandle: function(e, t, n) {
							return n = null !== n && void 0 !== n ? n.concat([e]) : null, Yo(4194308, 4, zo.bind(null, t, e), n)
						},
						useLayoutEffect: function(e, t) {
							return Yo(4194308, 4, e, t)
						},
						useInsertionEffect: function(e, t) {
							return Yo(4, 2, e, t)
						},
						useMemo: function(e, t) {
							var n = bo();
							return t = void 0 === t ? null : t, e = e(), n.memoizedState = [e, t], e
						},
						useReducer: function(e, t, n) {
							var r = bo();
							return t = void 0 !== n ? n(t) : t, r.memoizedState = r.baseState = t, e = {
								pending: null,
								interleaved: null,
								lanes: 0,
								dispatch: null,
								lastRenderedReducer: e,
								lastRenderedState: t
							}, r.queue = e, e = e.dispatch = ti.bind(null, po, e), [r.memoizedState, e]
						},
						useRef: function(e) {
							return e = {
								current: e
							}, bo().memoizedState = e
						},
						useState: Bo,
						useDebugValue: Jo,
						useDeferredValue: function(e) {
							return bo().memoizedState = e
						},
						useTransition: function() {
							var e = Bo(!1),
								t = e[0];
							return e = qo.bind(null, e[1]), bo().memoizedState = e, [t, e]
						},
						useMutableSource: function() {},
						useSyncExternalStore: function(e, t, n) {
							var r = po,
								l = bo();
							if (la) {
								if (void 0 === n) throw Error(a(407));
								n = n()
							} else {
								if (n = t(), null === Pu) throw Error(a(349));
								0 !== (30 & mo) || Do(r, t, n)
							}
							l.memoizedState = n;
							var o = {
								value: n,
								getSnapshot: t
							};
							return l.queue = o, Ko(wo.bind(null, r, o, e), [e]), r.flags |= 2048, xo(9, Ho.bind(null, r, o, n, t), void 0, null), n
						},
						useId: function() {
							var e = bo(),
								t = Pu.identifierPrefix;
							if (la) {
								var n = $l;
								t = ":" + t + "R" + (n = (Zl & ~(1 << 32 - ot(Zl) - 1)).toString(32) + n), 0 < (n = To++) && (t += "H" + n.toString(32)), t += ":"
							} else t = ":" + t + "r" + (n = No++).toString(32) + ":";
							return e.memoizedState = t
						},
						unstable_isNewReconciler: !1
					},
					ui = {
						readContext: ga,
						useCallback: Zo,
						useContext: ga,
						useEffect: Wo,
						useImperativeHandle: Qo,
						useInsertionEffect: jo,
						useLayoutEffect: Vo,
						useMemo: $o,
						useReducer: yo,
						useRef: Fo,
						useState: function() {
							return yo(Lo)
						},
						useDebugValue: Jo,
						useDeferredValue: function(e) {
							return Xo(Co(), So.memoizedState, e)
						},
						useTransition: function() {
							return [yo(Lo)[0], Co().memoizedState]
						},
						useMutableSource: Mo,
						useSyncExternalStore: Uo,
						useId: ei,
						unstable_isNewReconciler: !1
					},
					si = {
						readContext: ga,
						useCallback: Zo,
						useContext: ga,
						useEffect: Wo,
						useImperativeHandle: Qo,
						useInsertionEffect: jo,
						useLayoutEffect: Vo,
						useMemo: $o,
						useReducer: Po,
						useRef: Fo,
						useState: function() {
							return Po(Lo)
						},
						useDebugValue: Jo,
						useDeferredValue: function(e) {
							var t = Co();
							return null === So ? t.memoizedState = e : Xo(t, So.memoizedState, e)
						},
						useTransition: function() {
							return [Po(Lo)[0], Co().memoizedState]
						},
						useMutableSource: Mo,
						useSyncExternalStore: Uo,
						useId: ei,
						unstable_isNewReconciler: !1
					};

				function ci(e, t) {
					try {
						var n = "",
							r = t;
						do {
							n += Y(r), r = r.return
						} while (r);
						var l = n
					} catch (a) {
						l = "\nError generating stack: " + a.message + "\n" + a.stack
					}
					return {
						value: e,
						source: t,
						stack: l,
						digest: null
					}
				}

				function fi(e, t, n) {
					return {
						value: e,
						source: null,
						stack: null != n ? n : null,
						digest: null != t ? t : null
					}
				}

				function di(e, t) {
					try {
						console.error(t.value)
					} catch (n) {
						setTimeout((function() {
							throw n
						}))
					}
				}
				var Ei = "function" === typeof WeakMap ? WeakMap : Map;

				function mi(e, t, n) {
					(n = Da(-1, n)).tag = 3, n.payload = {
						element: null
					};
					var r = t.value;
					return n.callback = function() {
						ju || (ju = !0, Vu = r), di(0, t)
					}, n
				}

				function pi(e, t, n) {
					(n = Da(-1, n)).tag = 3;
					var r = e.type.getDerivedStateFromError;
					if ("function" === typeof r) {
						var l = t.value;
						n.payload = function() {
							return r(l)
						}, n.callback = function() {
							di(0, t)
						}
					}
					var a = e.stateNode;
					return null !== a && "function" === typeof a.componentDidCatch && (n.callback = function() {
						di(0, t), "function" !== typeof r && (null === zu ? zu = new Set([this]) : zu.add(this));
						var e = t.stack;
						this.componentDidCatch(t.value, {
							componentStack: null !== e ? e : ""
						})
					}), n
				}

				function Si(e, t, n) {
					var r = e.pingCache;
					if (null === r) {
						r = e.pingCache = new Ei;
						var l = new Set;
						r.set(t, l)
					} else void 0 === (l = r.get(t)) && (l = new Set, r.set(t, l));
					l.has(n) || (l.add(n), e = bs.bind(null, e, t, n), t.then(e, e))
				}

				function Ai(e) {
					do {
						var t;
						if ((t = 13 === e.tag) && (t = null === (t = e.memoizedState) || null !== t.dehydrated), t) return e;
						e = e.return
					} while (null !== e);
					return null
				}

				function Oi(e, t, n, r, l) {
					return 0 === (1 & e.mode) ? (e === t ? e.flags |= 65536 : (e.flags |= 128, n.flags |= 131072, n.flags &= -52805, 1 === n.tag && (null === n.alternate ? n.tag = 17 : ((t = Da(-1, 1)).tag = 2, Ha(n, t, 1))), n.lanes |= 1), e) : (e.flags |= 65536, e.lanes = l, e)
				}
				var Ri = T.ReactCurrentOwner,
					Ti = !1;

				function Ni(e, t, n, r) {
					t.child = null === e ? $a(t, null, n, r) : Za(t, e.child, n, r)
				}

				function Ii(e, t, n, r, l) {
					n = n.render;
					var a = t.ref;
					return ha(t, l), r = ho(e, t, n, r, a, l), n = go(), null === e || Ti ? (la && n && ea(t), t.flags |= 1, Ni(e, t, r, l), t.child) : (t.updateQueue = e.updateQueue, t.flags &= -2053, e.lanes &= ~l, ji(e, t, l))
				}

				function vi(e, t, n, r, l) {
					if (null === e) {
						var a = n.type;
						return "function" !== typeof a || Ds(a) || void 0 !== a.defaultProps || null !== n.compare || void 0 !== n.defaultProps ? ((e = ws(n.type, null, r, t, t.mode, l)).ref = t.ref, e.return = t, t.child = e) : (t.tag = 15, t.type = a, hi(e, t, a, r, l))
					}
					if (a = e.child, 0 === (e.lanes & l)) {
						var o = a.memoizedProps;
						if ((n = null !== (n = n.compare) ? n : ur)(o, r) && e.ref === t.ref) return ji(e, t, l)
					}
					return t.flags |= 1, (e = Hs(a, r)).ref = t.ref, e.return = t, t.child = e
				}

				function hi(e, t, n, r, l) {
					if (null !== e) {
						var a = e.memoizedProps;
						if (ur(a, r) && e.ref === t.ref) {
							if (Ti = !1, t.pendingProps = r = a, 0 === (e.lanes & l)) return t.lanes = e.lanes, ji(e, t, l);
							0 !== (131072 & e.flags) && (Ti = !0)
						}
					}
					return Ci(e, t, n, r, l)
				}

				function gi(e, t, n) {
					var r = t.pendingProps,
						l = r.children,
						a = null !== e ? e.memoizedState : null;
					if ("hidden" === r.mode)
						if (0 === (1 & t.mode)) t.memoizedState = {
							baseLanes: 0,
							cachePool: null,
							transitions: null
						}, bl(Hu, Du), Du |= n;
						else {
							if (0 === (1073741824 & n)) return e = null !== a ? a.baseLanes | n : n, t.lanes = t.childLanes = 1073741824, t.memoizedState = {
								baseLanes: e,
								cachePool: null,
								transitions: null
							}, t.updateQueue = null, bl(Hu, Du), Du |= e, null;
							t.memoizedState = {
								baseLanes: 0,
								cachePool: null,
								transitions: null
							}, r = null !== a ? a.baseLanes : n, bl(Hu, Du), Du |= r
						}
					else null !== a ? (r = a.baseLanes | n, t.memoizedState = null) : r = n, bl(Hu, Du), Du |= r;
					return Ni(e, t, l, n), t.child
				}

				function bi(e, t) {
					var n = t.ref;
					(null === e && null !== n || null !== e && e.ref !== n) && (t.flags |= 512, t.flags |= 2097152)
				}

				function Ci(e, t, n, r, l) {
					var a = Ul(n) ? Pl : Ll.current;
					return a = Ml(t, a), ha(t, l), n = ho(e, t, n, r, a, l), r = go(), null === e || Ti ? (la && r && ea(t), t.flags |= 1, Ni(e, t, n, l), t.child) : (t.updateQueue = e.updateQueue, t.flags &= -2053, e.lanes &= ~l, ji(e, t, l))
				}

				function Li(e, t, n, r, l) {
					if (Ul(n)) {
						var a = !0;
						Gl(t)
					} else a = !1;
					if (ha(t, l), null === t.stateNode) Wi(e, t), Ka(t, n, r), ja(t, n, r, l), r = !0;
					else if (null === e) {
						var o = t.stateNode,
							i = t.memoizedProps;
						o.props = i;
						var u = o.context,
							s = n.contextType;
						"object" === typeof s && null !== s ? s = ga(s) : s = Ml(t, s = Ul(n) ? Pl : Ll.current);
						var c = n.getDerivedStateFromProps,
							f = "function" === typeof c || "function" === typeof o.getSnapshotBeforeUpdate;
						f || "function" !== typeof o.UNSAFE_componentWillReceiveProps && "function" !== typeof o.componentWillReceiveProps || (i !== r || u !== s) && Wa(t, o, r, s), Pa = !1;
						var d = t.memoizedState;
						o.state = d, ka(t, r, o, l), u = t.memoizedState, i !== r || d !== u || yl.current || Pa ? ("function" === typeof c && (Fa(t, n, c, r), u = t.memoizedState), (i = Pa || _a(t, n, i, r, d, u, s)) ? (f || "function" !== typeof o.UNSAFE_componentWillMount && "function" !== typeof o.componentWillMount || ("function" === typeof o.componentWillMount && o.componentWillMount(), "function" === typeof o.UNSAFE_componentWillMount && o.UNSAFE_componentWillMount()), "function" === typeof o.componentDidMount && (t.flags |= 4194308)) : ("function" === typeof o.componentDidMount && (t.flags |= 4194308), t.memoizedProps = r, t.memoizedState = u), o.props = r, o.state = u, o.context = s, r = i) : ("function" === typeof o.componentDidMount && (t.flags |= 4194308), r = !1)
					} else {
						o = t.stateNode, Ua(e, t), i = t.memoizedProps, s = t.type === t.elementType ? i : Sa(t.type, i), o.props = s, f = t.pendingProps, d = o.context, "object" === typeof(u = n.contextType) && null !== u ? u = ga(u) : u = Ml(t, u = Ul(n) ? Pl : Ll.current);
						var E = n.getDerivedStateFromProps;
						(c = "function" === typeof E || "function" === typeof o.getSnapshotBeforeUpdate) || "function" !== typeof o.UNSAFE_componentWillReceiveProps && "function" !== typeof o.componentWillReceiveProps || (i !== f || d !== u) && Wa(t, o, r, u), Pa = !1, d = t.memoizedState, o.state = d, ka(t, r, o, l);
						var m = t.memoizedState;
						i !== f || d !== m || yl.current || Pa ? ("function" === typeof E && (Fa(t, n, E, r), m = t.memoizedState), (s = Pa || _a(t, n, s, r, d, m, u) || !1) ? (c || "function" !== typeof o.UNSAFE_componentWillUpdate && "function" !== typeof o.componentWillUpdate || ("function" === typeof o.componentWillUpdate && o.componentWillUpdate(r, m, u), "function" === typeof o.UNSAFE_componentWillUpdate && o.UNSAFE_componentWillUpdate(r, m, u)), "function" === typeof o.componentDidUpdate && (t.flags |= 4), "function" === typeof o.getSnapshotBeforeUpdate && (t.flags |= 1024)) : ("function" !== typeof o.componentDidUpdate || i === e.memoizedProps && d === e.memoizedState || (t.flags |= 4), "function" !== typeof o.getSnapshotBeforeUpdate || i === e.memoizedProps && d === e.memoizedState || (t.flags |= 1024), t.memoizedProps = r, t.memoizedState = m), o.props = r, o.state = m, o.context = u, r = s) : ("function" !== typeof o.componentDidUpdate || i === e.memoizedProps && d === e.memoizedState || (t.flags |= 4), "function" !== typeof o.getSnapshotBeforeUpdate || i === e.memoizedProps && d === e.memoizedState || (t.flags |= 1024), r = !1)
					}
					return yi(e, t, n, r, a, l)
				}

				function yi(e, t, n, r, l, a) {
					bi(e, t);
					var o = 0 !== (128 & t.flags);
					if (!r && !o) return l && kl(t, n, !1), ji(e, t, a);
					r = t.stateNode, Ri.current = t;
					var i = o && "function" !== typeof n.getDerivedStateFromError ? null : r.render();
					return t.flags |= 1, null !== e && o ? (t.child = Za(t, e.child, null, a), t.child = Za(t, null, i, a)) : Ni(e, t, i, a), t.memoizedState = r.state, l && kl(t, n, !0), t.child
				}

				function Pi(e) {
					var t = e.stateNode;
					t.pendingContext ? Hl(0, t.pendingContext, t.pendingContext !== t.context) : t.context && Hl(0, t.context, !1), ro(e, t.containerInfo)
				}

				function Mi(e, t, n, r, l) {
					return Ea(), ma(l), t.flags |= 256, Ni(e, t, n, r), t.child
				}
				var Ui, Di, Hi, wi, Gi = {
					dehydrated: null,
					treeContext: null,
					retryLane: 0
				};

				function ki(e) {
					return {
						baseLanes: e,
						cachePool: null,
						transitions: null
					}
				}

				function Bi(e, t, n) {
					var r, l = t.pendingProps,
						o = io.current,
						i = !1,
						u = 0 !== (128 & t.flags);
					if ((r = u) || (r = (null === e || null !== e.memoizedState) && 0 !== (2 & o)), r ? (i = !0, t.flags &= -129) : null !== e && null === e.memoizedState || (o |= 1), bl(io, 1 & o), null === e) return sa(t), null !== (e = t.memoizedState) && null !== (e = e.dehydrated) ? (0 === (1 & t.mode) ? t.lanes = 1 : "$!" === e.data ? t.lanes = 8 : t.lanes = 1073741824, null) : (u = l.children, e = l.fallback, i ? (l = t.mode, i = t.child, u = {
						mode: "hidden",
						children: u
					}, 0 === (1 & l) && null !== i ? (i.childLanes = 0, i.pendingProps = u) : i = ks(u, l, 0, null), e = Gs(e, l, n, null), i.return = t, e.return = t, i.sibling = e, t.child = i, t.child.memoizedState = ki(n), t.memoizedState = Gi, e) : xi(t, u));
					if (null !== (o = e.memoizedState) && null !== (r = o.dehydrated)) return function(e, t, n, r, l, o, i) {
						if (n) return 256 & t.flags ? (t.flags &= -257, Fi(e, t, i, r = fi(Error(a(422))))) : null !== t.memoizedState ? (t.child = e.child, t.flags |= 128, null) : (o = r.fallback, l = t.mode, r = ks({
							mode: "visible",
							children: r.children
						}, l, 0, null), (o = Gs(o, l, i, null)).flags |= 2, r.return = t, o.return = t, r.sibling = o, t.child = r, 0 !== (1 & t.mode) && Za(t, e.child, null, i), t.child.memoizedState = ki(i), t.memoizedState = Gi, o);
						if (0 === (1 & t.mode)) return Fi(e, t, i, null);
						if ("$!" === l.data) {
							if (r = l.nextSibling && l.nextSibling.dataset) var u = r.dgst;
							return r = u, Fi(e, t, i, r = fi(o = Error(a(419)), r, void 0))
						}
						if (u = 0 !== (i & e.childLanes), Ti || u) {
							if (null !== (r = Pu)) {
								switch (i & -i) {
									case 4:
										l = 2;
										break;
									case 16:
										l = 8;
										break;
									case 64:
									case 128:
									case 256:
									case 512:
									case 1024:
									case 2048:
									case 4096:
									case 8192:
									case 16384:
									case 32768:
									case 65536:
									case 131072:
									case 262144:
									case 524288:
									case 1048576:
									case 2097152:
									case 4194304:
									case 8388608:
									case 16777216:
									case 33554432:
									case 67108864:
										l = 32;
										break;
									case 536870912:
										l = 268435456;
										break;
									default:
										l = 0
								}
								0 !== (l = 0 !== (l & (r.suspendedLanes | i)) ? 0 : l) && l !== o.retryLane && (o.retryLane = l, ya(e, l), rs(r, e, l, -1))
							}
							return Ss(), Fi(e, t, i, r = fi(Error(a(421))))
						}
						return "$?" === l.data ? (t.flags |= 128, t.child = e.child, t = Ls.bind(null, e), l._reactRetry = t, null) : (e = o.treeContext, ra = sl(l.nextSibling), na = t, la = !0, aa = null, null !== e && (zl[Ql++] = Zl, zl[Ql++] = $l, zl[Ql++] = Jl, Zl = e.id, $l = e.overflow, Jl = t), t = xi(t, r.children), t.flags |= 4096, t)
					}(e, t, u, l, r, o, n);
					if (i) {
						i = l.fallback, u = t.mode, r = (o = e.child).sibling;
						var s = {
							mode: "hidden",
							children: l.children
						};
						return 0 === (1 & u) && t.child !== o ? ((l = t.child).childLanes = 0, l.pendingProps = s, t.deletions = null) : (l = Hs(o, s)).subtreeFlags = 14680064 & o.subtreeFlags, null !== r ? i = Hs(r, i) : (i = Gs(i, u, n, null)).flags |= 2, i.return = t, l.return = t, l.sibling = i, t.child = l, l = i, i = t.child, u = null === (u = e.child.memoizedState) ? ki(n) : {
							baseLanes: u.baseLanes | n,
							cachePool: null,
							transitions: u.transitions
						}, i.memoizedState = u, i.childLanes = e.childLanes & ~n, t.memoizedState = Gi, l
					}
					return e = (i = e.child).sibling, l = Hs(i, {
						mode: "visible",
						children: l.children
					}), 0 === (1 & t.mode) && (l.lanes = n), l.return = t, l.sibling = null, null !== e && (null === (n = t.deletions) ? (t.deletions = [e], t.flags |= 16) : n.push(e)), t.child = l, t.memoizedState = null, l
				}

				function xi(e, t) {
					return (t = ks({
						mode: "visible",
						children: t
					}, e.mode, 0, null)).return = e, e.child = t
				}

				function Fi(e, t, n, r) {
					return null !== r && ma(r), Za(t, e.child, null, n), (e = xi(t, t.pendingProps.children)).flags |= 2, t.memoizedState = null, e
				}

				function Yi(e, t, n) {
					e.lanes |= t;
					var r = e.alternate;
					null !== r && (r.lanes |= t), va(e.return, t, n)
				}

				function _i(e, t, n, r, l) {
					var a = e.memoizedState;
					null === a ? e.memoizedState = {
						isBackwards: t,
						rendering: null,
						renderingStartTime: 0,
						last: r,
						tail: n,
						tailMode: l
					} : (a.isBackwards = t, a.rendering = null, a.renderingStartTime = 0, a.last = r, a.tail = n, a.tailMode = l)
				}

				function Ki(e, t, n) {
					var r = t.pendingProps,
						l = r.revealOrder,
						a = r.tail;
					if (Ni(e, t, r.children, n), 0 !== (2 & (r = io.current))) r = 1 & r | 2, t.flags |= 128;
					else {
						if (null !== e && 0 !== (128 & e.flags)) e: for (e = t.child; null !== e;) {
							if (13 === e.tag) null !== e.memoizedState && Yi(e, n, t);
							else if (19 === e.tag) Yi(e, n, t);
							else if (null !== e.child) {
								e.child.return = e, e = e.child;
								continue
							}
							if (e === t) break e;
							for (; null === e.sibling;) {
								if (null === e.return || e.return === t) break e;
								e = e.return
							}
							e.sibling.return = e.return, e = e.sibling
						}
						r &= 1
					}
					if (bl(io, r), 0 === (1 & t.mode)) t.memoizedState = null;
					else switch (l) {
						case "forwards":
							for (n = t.child, l = null; null !== n;) null !== (e = n.alternate) && null === uo(e) && (l = n), n = n.sibling;
							null === (n = l) ? (l = t.child, t.child = null) : (l = n.sibling, n.sibling = null), _i(t, !1, l, n, a);
							break;
						case "backwards":
							for (n = null, l = t.child, t.child = null; null !== l;) {
								if (null !== (e = l.alternate) && null === uo(e)) {
									t.child = l;
									break
								}
								e = l.sibling, l.sibling = n, n = l, l = e
							}
							_i(t, !0, n, null, a);
							break;
						case "together":
							_i(t, !1, null, null, void 0);
							break;
						default:
							t.memoizedState = null
					}
					return t.child
				}

				function Wi(e, t) {
					0 === (1 & t.mode) && null !== e && (e.alternate = null, t.alternate = null, t.flags |= 2)
				}

				function ji(e, t, n) {
					if (null !== e && (t.dependencies = e.dependencies), ku |= t.lanes, 0 === (n & t.childLanes)) return null;
					if (null !== e && t.child !== e.child) throw Error(a(153));
					if (null !== t.child) {
						for (n = Hs(e = t.child, e.pendingProps), t.child = n, n.return = t; null !== e.sibling;) e = e.sibling, (n = n.sibling = Hs(e, e.pendingProps)).return = t;
						n.sibling = null
					}
					return t.child
				}

				function Vi(e, t) {
					if (!la) switch (e.tailMode) {
						case "hidden":
							t = e.tail;
							for (var n = null; null !== t;) null !== t.alternate && (n = t), t = t.sibling;
							null === n ? e.tail = null : n.sibling = null;
							break;
						case "collapsed":
							n = e.tail;
							for (var r = null; null !== n;) null !== n.alternate && (r = n), n = n.sibling;
							null === r ? t || null === e.tail ? e.tail = null : e.tail.sibling = null : r.sibling = null
					}
				}

				function zi(e) {
					var t = null !== e.alternate && e.alternate.child === e.child,
						n = 0,
						r = 0;
					if (t)
						for (var l = e.child; null !== l;) n |= l.lanes | l.childLanes, r |= 14680064 & l.subtreeFlags, r |= 14680064 & l.flags, l.return = e, l = l.sibling;
					else
						for (l = e.child; null !== l;) n |= l.lanes | l.childLanes, r |= l.subtreeFlags, r |= l.flags, l.return = e, l = l.sibling;
					return e.subtreeFlags |= r, e.childLanes = n, t
				}

				function Qi(e, t, n) {
					var r = t.pendingProps;
					switch (ta(t), t.tag) {
						case 2:
						case 16:
						case 15:
						case 0:
						case 11:
						case 7:
						case 8:
						case 12:
						case 9:
						case 14:
							return zi(t), null;
						case 1:
						case 17:
							return Ul(t.type) && Dl(), zi(t), null;
						case 3:
							return r = t.stateNode, lo(), gl(yl), gl(Ll), co(), r.pendingContext && (r.context = r.pendingContext, r.pendingContext = null), null !== e && null !== e.child || (fa(t) ? t.flags |= 4 : null === e || e.memoizedState.isDehydrated && 0 === (256 & t.flags) || (t.flags |= 1024, null !== aa && (is(aa), aa = null))), Di(e, t), zi(t), null;
						case 5:
							oo(t);
							var l = no(to.current);
							if (n = t.type, null !== e && null != t.stateNode) Hi(e, t, n, r, l), e.ref !== t.ref && (t.flags |= 512, t.flags |= 2097152);
							else {
								if (!r) {
									if (null === t.stateNode) throw Error(a(166));
									return zi(t), null
								}
								if (e = no(qa.current), fa(t)) {
									r = t.stateNode, n = t.type;
									var o = t.memoizedProps;
									switch (r[dl] = t, r[El] = o, e = 0 !== (1 & t.mode), n) {
										case "dialog":
											xr("cancel", r), xr("close", r);
											break;
										case "iframe":
										case "object":
										case "embed":
											xr("load", r);
											break;
										case "video":
										case "audio":
											for (l = 0; l < wr.length; l++) xr(wr[l], r);
											break;
										case "source":
											xr("error", r);
											break;
										case "img":
										case "image":
										case "link":
											xr("error", r), xr("load", r);
											break;
										case "details":
											xr("toggle", r);
											break;
										case "input":
											Z(r, o), xr("invalid", r);
											break;
										case "select":
											r._wrapperState = {
												wasMultiple: !!o.multiple
											}, xr("invalid", r);
											break;
										case "textarea":
											le(r, o), xr("invalid", r)
									}
									for (var u in Oe(n, o), l = null, o)
										if (o.hasOwnProperty(u)) {
											var s = o[u];
											"children" === u ? "string" === typeof s ? r.textContent !== s && (!0 !== o.suppressHydrationWarning && Xr(r.textContent, s, e), l = ["children", s]) : "number" === typeof s && r.textContent !== "" + s && (!0 !== o.suppressHydrationWarning && Xr(r.textContent, s, e), l = ["children", "" + s]) : i.hasOwnProperty(u) && null != s && "onScroll" === u && xr("scroll", r)
										}
									switch (n) {
										case "input":
											V(r), q(r, o, !0);
											break;
										case "textarea":
											V(r), oe(r);
											break;
										case "select":
										case "option":
											break;
										default:
											"function" === typeof o.onClick && (r.onclick = qr)
									}
									r = l, t.updateQueue = r, null !== r && (t.flags |= 4)
								} else {
									u = 9 === l.nodeType ? l : l.ownerDocument, "http://www.w3.org/1999/xhtml" === e && (e = ie(n)), "http://www.w3.org/1999/xhtml" === e ? "script" === n ? ((e = u.createElement("div")).innerHTML = "<script><\/script>", e = e.removeChild(e.firstChild)) : "string" === typeof r.is ? e = u.createElement(n, {
										is: r.is
									}) : (e = u.createElement(n), "select" === n && (u = e, r.multiple ? u.multiple = !0 : r.size && (u.size = r.size))) : e = u.createElementNS(e, n), e[dl] = t, e[El] = r, Ui(e, t, !1, !1), t.stateNode = e;
									e: {
										switch (u = Re(n, r), n) {
											case "dialog":
												xr("cancel", e), xr("close", e), l = r;
												break;
											case "iframe":
											case "object":
											case "embed":
												xr("load", e), l = r;
												break;
											case "video":
											case "audio":
												for (l = 0; l < wr.length; l++) xr(wr[l], e);
												l = r;
												break;
											case "source":
												xr("error", e), l = r;
												break;
											case "img":
											case "image":
											case "link":
												xr("error", e), xr("load", e), l = r;
												break;
											case "details":
												xr("toggle", e), l = r;
												break;
											case "input":
												Z(e, r), l = J(e, r), xr("invalid", e);
												break;
											case "option":
											default:
												l = r;
												break;
											case "select":
												e._wrapperState = {
													wasMultiple: !!r.multiple
												}, l = k({}, r, {
													value: void 0
												}), xr("invalid", e);
												break;
											case "textarea":
												le(e, r), l = re(e, r), xr("invalid", e)
										}
										for (o in Oe(n, l), s = l)
											if (s.hasOwnProperty(o)) {
												var c = s[o];
												"style" === o ? Se(e, c) : "dangerouslySetInnerHTML" === o ? null != (c = c ? c.__html : void 0) && fe(e, c) : "children" === o ? "string" === typeof c ? ("textarea" !== n || "" !== c) && de(e, c) : "number" === typeof c && de(e, "" + c) : "suppressContentEditableWarning" !== o && "suppressHydrationWarning" !== o && "autoFocus" !== o && (i.hasOwnProperty(o) ? null != c && "onScroll" === o && xr("scroll", e) : null != c && R(e, o, c, u))
											}
										switch (n) {
											case "input":
												V(e), q(e, r, !1);
												break;
											case "textarea":
												V(e), oe(e);
												break;
											case "option":
												null != r.value && e.setAttribute("value", "" + W(r.value));
												break;
											case "select":
												e.multiple = !!r.multiple, null != (o = r.value) ? ne(e, !!r.multiple, o, !1) : null != r.defaultValue && ne(e, !!r.multiple, r.defaultValue, !0);
												break;
											default:
												"function" === typeof l.onClick && (e.onclick = qr)
										}
										switch (n) {
											case "button":
											case "input":
											case "select":
											case "textarea":
												r = !!r.autoFocus;
												break e;
											case "img":
												r = !0;
												break e;
											default:
												r = !1
										}
									}
									r && (t.flags |= 4)
								}
								null !== t.ref && (t.flags |= 512, t.flags |= 2097152)
							}
							return zi(t), null;
						case 6:
							if (e && null != t.stateNode) wi(e, t, e.memoizedProps, r);
							else {
								if ("string" !== typeof r && null === t.stateNode) throw Error(a(166));
								if (n = no(to.current), no(qa.current), fa(t)) {
									if (r = t.stateNode, n = t.memoizedProps, r[dl] = t, (o = r.nodeValue !== n) && null !== (e = na)) switch (e.tag) {
										case 3:
											Xr(r.nodeValue, n, 0 !== (1 & e.mode));
											break;
										case 5:
											!0 !== e.memoizedProps.suppressHydrationWarning && Xr(r.nodeValue, n, 0 !== (1 & e.mode))
									}
									o && (t.flags |= 4)
								} else(r = (9 === n.nodeType ? n : n.ownerDocument).createTextNode(r))[dl] = t, t.stateNode = r
							}
							return zi(t), null;
						case 13:
							if (gl(io), r = t.memoizedState, null === e || null !== e.memoizedState && null !== e.memoizedState.dehydrated) {
								if (la && null !== ra && 0 !== (1 & t.mode) && 0 === (128 & t.flags)) da(), Ea(), t.flags |= 98560, o = !1;
								else if (o = fa(t), null !== r && null !== r.dehydrated) {
									if (null === e) {
										if (!o) throw Error(a(318));
										if (!(o = null !== (o = t.memoizedState) ? o.dehydrated : null)) throw Error(a(317));
										o[dl] = t
									} else Ea(), 0 === (128 & t.flags) && (t.memoizedState = null), t.flags |= 4;
									zi(t), o = !1
								} else null !== aa && (is(aa), aa = null), o = !0;
								if (!o) return 65536 & t.flags ? t : null
							}
							return 0 !== (128 & t.flags) ? (t.lanes = n, t) : ((r = null !== r) !== (null !== e && null !== e.memoizedState) && r && (t.child.flags |= 8192, 0 !== (1 & t.mode) && (null === e || 0 !== (1 & io.current) ? 0 === wu && (wu = 3) : Ss())), null !== t.updateQueue && (t.flags |= 4), zi(t), null);
						case 4:
							return lo(), Di(e, t), null === e && _r(t.stateNode.containerInfo), zi(t), null;
						case 10:
							return Ia(t.type._context), zi(t), null;
						case 19:
							if (gl(io), null === (o = t.memoizedState)) return zi(t), null;
							if (r = 0 !== (128 & t.flags), null === (u = o.rendering))
								if (r) Vi(o, !1);
								else {
									if (0 !== wu || null !== e && 0 !== (128 & e.flags))
										for (e = t.child; null !== e;) {
											if (null !== (u = uo(e))) {
												for (t.flags |= 128, Vi(o, !1), null !== (r = u.updateQueue) && (t.updateQueue = r, t.flags |= 4), t.subtreeFlags = 0, r = n, n = t.child; null !== n;) e = r, (o = n).flags &= 14680066, null === (u = o.alternate) ? (o.childLanes = 0, o.lanes = e, o.child = null, o.subtreeFlags = 0, o.memoizedProps = null, o.memoizedState = null, o.updateQueue = null, o.dependencies = null, o.stateNode = null) : (o.childLanes = u.childLanes, o.lanes = u.lanes, o.child = u.child, o.subtreeFlags = 0, o.deletions = null, o.memoizedProps = u.memoizedProps, o.memoizedState = u.memoizedState, o.updateQueue = u.updateQueue, o.type = u.type, e = u.dependencies, o.dependencies = null === e ? null : {
													lanes: e.lanes,
													firstContext: e.firstContext
												}), n = n.sibling;
												return bl(io, 1 & io.current | 2), t.child
											}
											e = e.sibling
										}
									null !== o.tail && $e() > Ku && (t.flags |= 128, r = !0, Vi(o, !1), t.lanes = 4194304)
								}
							else {
								if (!r)
									if (null !== (e = uo(u))) {
										if (t.flags |= 128, r = !0, null !== (n = e.updateQueue) && (t.updateQueue = n, t.flags |= 4), Vi(o, !0), null === o.tail && "hidden" === o.tailMode && !u.alternate && !la) return zi(t), null
									} else 2 * $e() - o.renderingStartTime > Ku && 1073741824 !== n && (t.flags |= 128, r = !0, Vi(o, !1), t.lanes = 4194304);
								o.isBackwards ? (u.sibling = t.child, t.child = u) : (null !== (n = o.last) ? n.sibling = u : t.child = u, o.last = u)
							}
							return null !== o.tail ? (t = o.tail, o.rendering = t, o.tail = t.sibling, o.renderingStartTime = $e(), t.sibling = null, n = io.current, bl(io, r ? 1 & n | 2 : 1 & n), t) : (zi(t), null);
						case 22:
						case 23:
							return ds(), r = null !== t.memoizedState, null !== e && null !== e.memoizedState !== r && (t.flags |= 8192), r && 0 !== (1 & t.mode) ? 0 !== (1073741824 & Du) && (zi(t), 6 & t.subtreeFlags && (t.flags |= 8192)) : zi(t), null;
						case 24:
						case 25:
							return null
					}
					throw Error(a(156, t.tag))
				}

				function Ji(e, t) {
					switch (ta(t), t.tag) {
						case 1:
							return Ul(t.type) && Dl(), 65536 & (e = t.flags) ? (t.flags = -65537 & e | 128, t) : null;
						case 3:
							return lo(), gl(yl), gl(Ll), co(), 0 !== (65536 & (e = t.flags)) && 0 === (128 & e) ? (t.flags = -65537 & e | 128, t) : null;
						case 5:
							return oo(t), null;
						case 13:
							if (gl(io), null !== (e = t.memoizedState) && null !== e.dehydrated) {
								if (null === t.alternate) throw Error(a(340));
								Ea()
							}
							return 65536 & (e = t.flags) ? (t.flags = -65537 & e | 128, t) : null;
						case 19:
							return gl(io), null;
						case 4:
							return lo(), null;
						case 10:
							return Ia(t.type._context), null;
						case 22:
						case 23:
							return ds(), null;
						default:
							return null
					}
				}
				Ui = function(e, t) {
					for (var n = t.child; null !== n;) {
						if (5 === n.tag || 6 === n.tag) e.appendChild(n.stateNode);
						else if (4 !== n.tag && null !== n.child) {
							n.child.return = n, n = n.child;
							continue
						}
						if (n === t) break;
						for (; null === n.sibling;) {
							if (null === n.return || n.return === t) return;
							n = n.return
						}
						n.sibling.return = n.return, n = n.sibling
					}
				}, Di = function() {}, Hi = function(e, t, n, r) {
					var l = e.memoizedProps;
					if (l !== r) {
						e = t.stateNode, no(qa.current);
						var a, o = null;
						switch (n) {
							case "input":
								l = J(e, l), r = J(e, r), o = [];
								break;
							case "select":
								l = k({}, l, {
									value: void 0
								}), r = k({}, r, {
									value: void 0
								}), o = [];
								break;
							case "textarea":
								l = re(e, l), r = re(e, r), o = [];
								break;
							default:
								"function" !== typeof l.onClick && "function" === typeof r.onClick && (e.onclick = qr)
						}
						for (c in Oe(n, r), n = null, l)
							if (!r.hasOwnProperty(c) && l.hasOwnProperty(c) && null != l[c])
								if ("style" === c) {
									var u = l[c];
									for (a in u) u.hasOwnProperty(a) && (n || (n = {}), n[a] = "")
								} else "dangerouslySetInnerHTML" !== c && "children" !== c && "suppressContentEditableWarning" !== c && "suppressHydrationWarning" !== c && "autoFocus" !== c && (i.hasOwnProperty(c) ? o || (o = []) : (o = o || []).push(c, null));
						for (c in r) {
							var s = r[c];
							if (u = null != l ? l[c] : void 0, r.hasOwnProperty(c) && s !== u && (null != s || null != u))
								if ("style" === c)
									if (u) {
										for (a in u) !u.hasOwnProperty(a) || s && s.hasOwnProperty(a) || (n || (n = {}), n[a] = "");
										for (a in s) s.hasOwnProperty(a) && u[a] !== s[a] && (n || (n = {}), n[a] = s[a])
									} else n || (o || (o = []), o.push(c, n)), n = s;
							else "dangerouslySetInnerHTML" === c ? (s = s ? s.__html : void 0, u = u ? u.__html : void 0, null != s && u !== s && (o = o || []).push(c, s)) : "children" === c ? "string" !== typeof s && "number" !== typeof s || (o = o || []).push(c, "" + s) : "suppressContentEditableWarning" !== c && "suppressHydrationWarning" !== c && (i.hasOwnProperty(c) ? (null != s && "onScroll" === c && xr("scroll", e), o || u === s || (o = [])) : (o = o || []).push(c, s))
						}
						n && (o = o || []).push("style", n);
						var c = o;
						(t.updateQueue = c) && (t.flags |= 4)
					}
				}, wi = function(e, t, n, r) {
					n !== r && (t.flags |= 4)
				};
				var Zi = !1,
					$i = !1,
					Xi = "function" === typeof WeakSet ? WeakSet : Set,
					qi = null;

				function eu(e, t) {
					var n = e.ref;
					if (null !== n)
						if ("function" === typeof n) try {
							n(null)
						} catch (r) {
							gs(e, t, r)
						} else n.current = null
				}

				function tu(e, t, n) {
					try {
						n()
					} catch (r) {
						gs(e, t, r)
					}
				}
				var nu = !1;

				function ru(e, t, n) {
					var r = t.updateQueue;
					if (null !== (r = null !== r ? r.lastEffect : null)) {
						var l = r = r.next;
						do {
							if ((l.tag & e) === e) {
								var a = l.destroy;
								l.destroy = void 0, void 0 !== a && tu(t, n, a)
							}
							l = l.next
						} while (l !== r)
					}
				}

				function lu(e, t) {
					if (null !== (t = null !== (t = t.updateQueue) ? t.lastEffect : null)) {
						var n = t = t.next;
						do {
							if ((n.tag & e) === e) {
								var r = n.create;
								n.destroy = r()
							}
							n = n.next
						} while (n !== t)
					}
				}

				function au(e) {
					var t = e.ref;
					if (null !== t) {
						var n = e.stateNode;
						e.tag, e = n, "function" === typeof t ? t(e) : t.current = e
					}
				}

				function ou(e) {
					var t = e.alternate;
					null !== t && (e.alternate = null, ou(t)), e.child = null, e.deletions = null, e.sibling = null, 5 === e.tag && (null !== (t = e.stateNode) && (delete t[dl], delete t[El], delete t[pl], delete t[Sl], delete t[Al])), e.stateNode = null, e.return = null, e.dependencies = null, e.memoizedProps = null, e.memoizedState = null, e.pendingProps = null, e.stateNode = null, e.updateQueue = null
				}

				function iu(e) {
					return 5 === e.tag || 3 === e.tag || 4 === e.tag
				}

				function uu(e) {
					e: for (;;) {
						for (; null === e.sibling;) {
							if (null === e.return || iu(e.return)) return null;
							e = e.return
						}
						for (e.sibling.return = e.return, e = e.sibling; 5 !== e.tag && 6 !== e.tag && 18 !== e.tag;) {
							if (2 & e.flags) continue e;
							if (null === e.child || 4 === e.tag) continue e;
							e.child.return = e, e = e.child
						}
						if (!(2 & e.flags)) return e.stateNode
					}
				}

				function su(e, t, n) {
					var r = e.tag;
					if (5 === r || 6 === r) e = e.stateNode, t ? 8 === n.nodeType ? n.parentNode.insertBefore(e, t) : n.insertBefore(e, t) : (8 === n.nodeType ? (t = n.parentNode).insertBefore(e, n) : (t = n).appendChild(e), null !== (n = n._reactRootContainer) && void 0 !== n || null !== t.onclick || (t.onclick = qr));
					else if (4 !== r && null !== (e = e.child))
						for (su(e, t, n), e = e.sibling; null !== e;) su(e, t, n), e = e.sibling
				}

				function cu(e, t, n) {
					var r = e.tag;
					if (5 === r || 6 === r) e = e.stateNode, t ? n.insertBefore(e, t) : n.appendChild(e);
					else if (4 !== r && null !== (e = e.child))
						for (cu(e, t, n), e = e.sibling; null !== e;) cu(e, t, n), e = e.sibling
				}
				var fu = null,
					du = !1;

				function Eu(e, t, n) {
					for (n = n.child; null !== n;) mu(e, t, n), n = n.sibling
				}

				function mu(e, t, n) {
					if (at && "function" === typeof at.onCommitFiberUnmount) try {
						at.onCommitFiberUnmount(lt, n)
					} catch (i) {}
					switch (n.tag) {
						case 5:
							$i || eu(n, t);
						case 6:
							var r = fu,
								l = du;
							fu = null, Eu(e, t, n), du = l, null !== (fu = r) && (du ? (e = fu, n = n.stateNode, 8 === e.nodeType ? e.parentNode.removeChild(n) : e.removeChild(n)) : fu.removeChild(n.stateNode));
							break;
						case 18:
							null !== fu && (du ? (e = fu, n = n.stateNode, 8 === e.nodeType ? ul(e.parentNode, n) : 1 === e.nodeType && ul(e, n), _t(e)) : ul(fu, n.stateNode));
							break;
						case 4:
							r = fu, l = du, fu = n.stateNode.containerInfo, du = !0, Eu(e, t, n), fu = r, du = l;
							break;
						case 0:
						case 11:
						case 14:
						case 15:
							if (!$i && (null !== (r = n.updateQueue) && null !== (r = r.lastEffect))) {
								l = r = r.next;
								do {
									var a = l,
										o = a.destroy;
									a = a.tag, void 0 !== o && (0 !== (2 & a) || 0 !== (4 & a)) && tu(n, t, o), l = l.next
								} while (l !== r)
							}
							Eu(e, t, n);
							break;
						case 1:
							if (!$i && (eu(n, t), "function" === typeof(r = n.stateNode).componentWillUnmount)) try {
								r.props = n.memoizedProps, r.state = n.memoizedState, r.componentWillUnmount()
							} catch (i) {
								gs(n, t, i)
							}
							Eu(e, t, n);
							break;
						case 21:
							Eu(e, t, n);
							break;
						case 22:
							1 & n.mode ? ($i = (r = $i) || null !== n.memoizedState, Eu(e, t, n), $i = r) : Eu(e, t, n);
							break;
						default:
							Eu(e, t, n)
					}
				}

				function pu(e) {
					var t = e.updateQueue;
					if (null !== t) {
						e.updateQueue = null;
						var n = e.stateNode;
						null === n && (n = e.stateNode = new Xi), t.forEach((function(t) {
							var r = ys.bind(null, e, t);
							n.has(t) || (n.add(t), t.then(r, r))
						}))
					}
				}

				function Su(e, t) {
					var n = t.deletions;
					if (null !== n)
						for (var r = 0; r < n.length; r++) {
							var l = n[r];
							try {
								var o = e,
									i = t,
									u = i;
								e: for (; null !== u;) {
									switch (u.tag) {
										case 5:
											fu = u.stateNode, du = !1;
											break e;
										case 3:
										case 4:
											fu = u.stateNode.containerInfo, du = !0;
											break e
									}
									u = u.return
								}
								if (null === fu) throw Error(a(160));
								mu(o, i, l), fu = null, du = !1;
								var s = l.alternate;
								null !== s && (s.return = null), l.return = null
							} catch (c) {
								gs(l, t, c)
							}
						}
					if (12854 & t.subtreeFlags)
						for (t = t.child; null !== t;) Au(t, e), t = t.sibling
				}

				function Au(e, t) {
					var n = e.alternate,
						r = e.flags;
					switch (e.tag) {
						case 0:
						case 11:
						case 14:
						case 15:
							if (Su(t, e), Ou(e), 4 & r) {
								try {
									ru(3, e, e.return), lu(3, e)
								} catch (S) {
									gs(e, e.return, S)
								}
								try {
									ru(5, e, e.return)
								} catch (S) {
									gs(e, e.return, S)
								}
							}
							break;
						case 1:
							Su(t, e), Ou(e), 512 & r && null !== n && eu(n, n.return);
							break;
						case 5:
							if (Su(t, e), Ou(e), 512 & r && null !== n && eu(n, n.return), 32 & e.flags) {
								var l = e.stateNode;
								try {
									de(l, "")
								} catch (S) {
									gs(e, e.return, S)
								}
							}
							if (4 & r && null != (l = e.stateNode)) {
								var o = e.memoizedProps,
									i = null !== n ? n.memoizedProps : o,
									u = e.type,
									s = e.updateQueue;
								if (e.updateQueue = null, null !== s) try {
									"input" === u && "radio" === o.type && null != o.name && $(l, o), Re(u, i);
									var c = Re(u, o);
									for (i = 0; i < s.length; i += 2) {
										var f = s[i],
											d = s[i + 1];
										"style" === f ? Se(l, d) : "dangerouslySetInnerHTML" === f ? fe(l, d) : "children" === f ? de(l, d) : R(l, f, d, c)
									}
									switch (u) {
										case "input":
											X(l, o);
											break;
										case "textarea":
											ae(l, o);
											break;
										case "select":
											var E = l._wrapperState.wasMultiple;
											l._wrapperState.wasMultiple = !!o.multiple;
											var m = o.value;
											null != m ? ne(l, !!o.multiple, m, !1) : E !== !!o.multiple && (null != o.defaultValue ? ne(l, !!o.multiple, o.defaultValue, !0) : ne(l, !!o.multiple, o.multiple ? [] : "", !1))
									}
									l[El] = o
								} catch (S) {
									gs(e, e.return, S)
								}
							}
							break;
						case 6:
							if (Su(t, e), Ou(e), 4 & r) {
								if (null === e.stateNode) throw Error(a(162));
								l = e.stateNode, o = e.memoizedProps;
								try {
									l.nodeValue = o
								} catch (S) {
									gs(e, e.return, S)
								}
							}
							break;
						case 3:
							if (Su(t, e), Ou(e), 4 & r && null !== n && n.memoizedState.isDehydrated) try {
								_t(t.containerInfo)
							} catch (S) {
								gs(e, e.return, S)
							}
							break;
						case 4:
						default:
							Su(t, e), Ou(e);
							break;
						case 13:
							Su(t, e), Ou(e), 8192 & (l = e.child).flags && (o = null !== l.memoizedState, l.stateNode.isHidden = o, !o || null !== l.alternate && null !== l.alternate.memoizedState || (_u = $e())), 4 & r && pu(e);
							break;
						case 22:
							if (f = null !== n && null !== n.memoizedState, 1 & e.mode ? ($i = (c = $i) || f, Su(t, e), $i = c) : Su(t, e), Ou(e), 8192 & r) {
								if (c = null !== e.memoizedState, (e.stateNode.isHidden = c) && !f && 0 !== (1 & e.mode))
									for (qi = e, f = e.child; null !== f;) {
										for (d = qi = f; null !== qi;) {
											switch (m = (E = qi).child, E.tag) {
												case 0:
												case 11:
												case 14:
												case 15:
													ru(4, E, E.return);
													break;
												case 1:
													eu(E, E.return);
													var p = E.stateNode;
													if ("function" === typeof p.componentWillUnmount) {
														r = E, n = E.return;
														try {
															t = r, p.props = t.memoizedProps, p.state = t.memoizedState, p.componentWillUnmount()
														} catch (S) {
															gs(r, n, S)
														}
													}
													break;
												case 5:
													eu(E, E.return);
													break;
												case 22:
													if (null !== E.memoizedState) {
														Iu(d);
														continue
													}
											}
											null !== m ? (m.return = E, qi = m) : Iu(d)
										}
										f = f.sibling
									}
								e: for (f = null, d = e;;) {
									if (5 === d.tag) {
										if (null === f) {
											f = d;
											try {
												l = d.stateNode, c ? "function" === typeof(o = l.style).setProperty ? o.setProperty("display", "none", "important") : o.display = "none" : (u = d.stateNode, i = void 0 !== (s = d.memoizedProps.style) && null !== s && s.hasOwnProperty("display") ? s.display : null, u.style.display = pe("display", i))
											} catch (S) {
												gs(e, e.return, S)
											}
										}
									} else if (6 === d.tag) {
										if (null === f) try {
											d.stateNode.nodeValue = c ? "" : d.memoizedProps
										} catch (S) {
											gs(e, e.return, S)
										}
									} else if ((22 !== d.tag && 23 !== d.tag || null === d.memoizedState || d === e) && null !== d.child) {
										d.child.return = d, d = d.child;
										continue
									}
									if (d === e) break e;
									for (; null === d.sibling;) {
										if (null === d.return || d.return === e) break e;
										f === d && (f = null), d = d.return
									}
									f === d && (f = null), d.sibling.return = d.return, d = d.sibling
								}
							}
							break;
						case 19:
							Su(t, e), Ou(e), 4 & r && pu(e);
						case 21:
					}
				}

				function Ou(e) {
					var t = e.flags;
					if (2 & t) {
						try {
							e: {
								for (var n = e.return; null !== n;) {
									if (iu(n)) {
										var r = n;
										break e
									}
									n = n.return
								}
								throw Error(a(160))
							}
							switch (r.tag) {
								case 5:
									var l = r.stateNode;
									32 & r.flags && (de(l, ""), r.flags &= -33), cu(e, uu(e), l);
									break;
								case 3:
								case 4:
									var o = r.stateNode.containerInfo;
									su(e, uu(e), o);
									break;
								default:
									throw Error(a(161))
							}
						}
						catch (i) {
							gs(e, e.return, i)
						}
						e.flags &= -3
					}
					4096 & t && (e.flags &= -4097)
				}

				function Ru(e, t, n) {
					qi = e, Tu(e, t, n)
				}

				function Tu(e, t, n) {
					for (var r = 0 !== (1 & e.mode); null !== qi;) {
						var l = qi,
							a = l.child;
						if (22 === l.tag && r) {
							var o = null !== l.memoizedState || Zi;
							if (!o) {
								var i = l.alternate,
									u = null !== i && null !== i.memoizedState || $i;
								i = Zi;
								var s = $i;
								if (Zi = o, ($i = u) && !s)
									for (qi = l; null !== qi;) u = (o = qi).child, 22 === o.tag && null !== o.memoizedState ? vu(l) : null !== u ? (u.return = o, qi = u) : vu(l);
								for (; null !== a;) qi = a, Tu(a, t, n), a = a.sibling;
								qi = l, Zi = i, $i = s
							}
							Nu(e)
						} else 0 !== (8772 & l.subtreeFlags) && null !== a ? (a.return = l, qi = a) : Nu(e)
					}
				}

				function Nu(e) {
					for (; null !== qi;) {
						var t = qi;
						if (0 !== (8772 & t.flags)) {
							var n = t.alternate;
							try {
								if (0 !== (8772 & t.flags)) switch (t.tag) {
									case 0:
									case 11:
									case 15:
										$i || lu(5, t);
										break;
									case 1:
										var r = t.stateNode;
										if (4 & t.flags && !$i)
											if (null === n) r.componentDidMount();
											else {
												var l = t.elementType === t.type ? n.memoizedProps : Sa(t.type, n.memoizedProps);
												r.componentDidUpdate(l, n.memoizedState, r.__reactInternalSnapshotBeforeUpdate)
											}
										var o = t.updateQueue;
										null !== o && Ba(t, o, r);
										break;
									case 3:
										var i = t.updateQueue;
										if (null !== i) {
											if (n = null, null !== t.child) switch (t.child.tag) {
												case 5:
												case 1:
													n = t.child.stateNode
											}
											Ba(t, i, n)
										}
										break;
									case 5:
										var u = t.stateNode;
										if (null === n && 4 & t.flags) {
											n = u;
											var s = t.memoizedProps;
											switch (t.type) {
												case "button":
												case "input":
												case "select":
												case "textarea":
													s.autoFocus && n.focus();
													break;
												case "img":
													s.src && (n.src = s.src)
											}
										}
										break;
									case 6:
									case 4:
									case 12:
									case 19:
									case 17:
									case 21:
									case 22:
									case 23:
									case 25:
										break;
									case 13:
										if (null === t.memoizedState) {
											var c = t.alternate;
											if (null !== c) {
												var f = c.memoizedState;
												if (null !== f) {
													var d = f.dehydrated;
													null !== d && _t(d)
												}
											}
										}
										break;
									default:
										throw Error(a(163))
								}
								$i || 512 & t.flags && au(t)
							} catch (E) {
								gs(t, t.return, E)
							}
						}
						if (t === e) {
							qi = null;
							break
						}
						if (null !== (n = t.sibling)) {
							n.return = t.return, qi = n;
							break
						}
						qi = t.return
					}
				}

				function Iu(e) {
					for (; null !== qi;) {
						var t = qi;
						if (t === e) {
							qi = null;
							break
						}
						var n = t.sibling;
						if (null !== n) {
							n.return = t.return, qi = n;
							break
						}
						qi = t.return
					}
				}

				function vu(e) {
					for (; null !== qi;) {
						var t = qi;
						try {
							switch (t.tag) {
								case 0:
								case 11:
								case 15:
									var n = t.return;
									try {
										lu(4, t)
									} catch (u) {
										gs(t, n, u)
									}
									break;
								case 1:
									var r = t.stateNode;
									if ("function" === typeof r.componentDidMount) {
										var l = t.return;
										try {
											r.componentDidMount()
										} catch (u) {
											gs(t, l, u)
										}
									}
									var a = t.return;
									try {
										au(t)
									} catch (u) {
										gs(t, a, u)
									}
									break;
								case 5:
									var o = t.return;
									try {
										au(t)
									} catch (u) {
										gs(t, o, u)
									}
							}
						} catch (u) {
							gs(t, t.return, u)
						}
						if (t === e) {
							qi = null;
							break
						}
						var i = t.sibling;
						if (null !== i) {
							i.return = t.return, qi = i;
							break
						}
						qi = t.return
					}
				}
				var hu, gu = Math.ceil,
					bu = T.ReactCurrentDispatcher,
					Cu = T.ReactCurrentOwner,
					Lu = T.ReactCurrentBatchConfig,
					yu = 0,
					Pu = null,
					Mu = null,
					Uu = 0,
					Du = 0,
					Hu = hl(0),
					wu = 0,
					Gu = null,
					ku = 0,
					Bu = 0,
					xu = 0,
					Fu = null,
					Yu = null,
					_u = 0,
					Ku = 1 / 0,
					Wu = null,
					ju = !1,
					Vu = null,
					zu = null,
					Qu = !1,
					Ju = null,
					Zu = 0,
					$u = 0,
					Xu = null,
					qu = -1,
					es = 0;

				function ts() {
					return 0 !== (6 & yu) ? $e() : -1 !== qu ? qu : qu = $e()
				}

				function ns(e) {
					return 0 === (1 & e.mode) ? 1 : 0 !== (2 & yu) && 0 !== Uu ? Uu & -Uu : null !== pa.transition ? (0 === es && (es = pt()), es) : 0 !== (e = Rt) ? e : e = void 0 === (e = window.event) ? 16 : Zt(e.type)
				}

				function rs(e, t, n, r) {
					if (50 < $u) throw $u = 0, Xu = null, Error(a(185));
					At(e, n, r), 0 !== (2 & yu) && e === Pu || (e === Pu && (0 === (2 & yu) && (Bu |= n), 4 === wu && us(e, Uu)), ls(e, r), 1 === n && 0 === yu && 0 === (1 & t.mode) && (Ku = $e() + 500, xl && _l()))
				}

				function ls(e, t) {
					var n = e.callbackNode;
					! function(e, t) {
						for (var n = e.suspendedLanes, r = e.pingedLanes, l = e.expirationTimes, a = e.pendingLanes; 0 < a;) {
							var o = 31 - ot(a),
								i = 1 << o,
								u = l[o]; - 1 === u ? 0 !== (i & n) && 0 === (i & r) || (l[o] = Et(i, t)) : u <= t && (e.expiredLanes |= i), a &= ~i
						}
					}(e, t);
					var r = dt(e, e === Pu ? Uu : 0);
					if (0 === r) null !== n && Qe(n), e.callbackNode = null, e.callbackPriority = 0;
					else if (t = r & -r, e.callbackPriority !== t) {
						if (null != n && Qe(n), 1 === t) 0 === e.tag ? function(e) {
							xl = !0, Yl(e)
						}(ss.bind(null, e)) : Yl(ss.bind(null, e)), ol((function() {
							0 === (6 & yu) && _l()
						})), n = null;
						else {
							switch (Tt(r)) {
								case 1:
									n = qe;
									break;
								case 4:
									n = et;
									break;
								case 16:
								default:
									n = tt;
									break;
								case 536870912:
									n = rt
							}
							n = Ps(n, as.bind(null, e))
						}
						e.callbackPriority = t, e.callbackNode = n
					}
				}

				function as(e, t) {
					if (qu = -1, es = 0, 0 !== (6 & yu)) throw Error(a(327));
					var n = e.callbackNode;
					if (vs() && e.callbackNode !== n) return null;
					var r = dt(e, e === Pu ? Uu : 0);
					if (0 === r) return null;
					if (0 !== (30 & r) || 0 !== (r & e.expiredLanes) || t) t = As(e, r);
					else {
						t = r;
						var l = yu;
						yu |= 2;
						var o = ps();
						for (Pu === e && Uu === t || (Wu = null, Ku = $e() + 500, Es(e, t));;) try {
							Rs();
							break
						} catch (u) {
							ms(e, u)
						}
						Na(), bu.current = o, yu = l, null !== Mu ? t = 0 : (Pu = null, Uu = 0, t = wu)
					}
					if (0 !== t) {
						if (2 === t && (0 !== (l = mt(e)) && (r = l, t = os(e, l))), 1 === t) throw n = Gu, Es(e, 0), us(e, r), ls(e, $e()), n;
						if (6 === t) us(e, r);
						else {
							if (l = e.current.alternate, 0 === (30 & r) && ! function(e) {
									for (var t = e;;) {
										if (16384 & t.flags) {
											var n = t.updateQueue;
											if (null !== n && null !== (n = n.stores))
												for (var r = 0; r < n.length; r++) {
													var l = n[r],
														a = l.getSnapshot;
													l = l.value;
													try {
														if (!ir(a(), l)) return !1
													} catch (i) {
														return !1
													}
												}
										}
										if (n = t.child, 16384 & t.subtreeFlags && null !== n) n.return = t, t = n;
										else {
											if (t === e) break;
											for (; null === t.sibling;) {
												if (null === t.return || t.return === e) return !0;
												t = t.return
											}
											t.sibling.return = t.return, t = t.sibling
										}
									}
									return !0
								}(l) && (2 === (t = As(e, r)) && (0 !== (o = mt(e)) && (r = o, t = os(e, o))), 1 === t)) throw n = Gu, Es(e, 0), us(e, r), ls(e, $e()), n;
							switch (e.finishedWork = l, e.finishedLanes = r, t) {
								case 0:
								case 1:
									throw Error(a(345));
								case 2:
								case 5:
									Is(e, Yu, Wu);
									break;
								case 3:
									if (us(e, r), (130023424 & r) === r && 10 < (t = _u + 500 - $e())) {
										if (0 !== dt(e, 0)) break;
										if (((l = e.suspendedLanes) & r) !== r) {
											ts(), e.pingedLanes |= e.suspendedLanes & l;
											break
										}
										e.timeoutHandle = rl(Is.bind(null, e, Yu, Wu), t);
										break
									}
									Is(e, Yu, Wu);
									break;
								case 4:
									if (us(e, r), (4194240 & r) === r) break;
									for (t = e.eventTimes, l = -1; 0 < r;) {
										var i = 31 - ot(r);
										o = 1 << i, (i = t[i]) > l && (l = i), r &= ~o
									}
									if (r = l, 10 < (r = (120 > (r = $e() - r) ? 120 : 480 > r ? 480 : 1080 > r ? 1080 : 1920 > r ? 1920 : 3e3 > r ? 3e3 : 4320 > r ? 4320 : 1960 * gu(r / 1960)) - r)) {
										e.timeoutHandle = rl(Is.bind(null, e, Yu, Wu), r);
										break
									}
									Is(e, Yu, Wu);
									break;
								default:
									throw Error(a(329))
							}
						}
					}
					return ls(e, $e()), e.callbackNode === n ? as.bind(null, e) : null
				}

				function os(e, t) {
					var n = Fu;
					return e.current.memoizedState.isDehydrated && (Es(e, t).flags |= 256), 2 !== (e = As(e, t)) && (t = Yu, Yu = n, null !== t && is(t)), e
				}

				function is(e) {
					null === Yu ? Yu = e : Yu.push.apply(Yu, e)
				}

				function us(e, t) {
					for (t &= ~xu, t &= ~Bu, e.suspendedLanes |= t, e.pingedLanes &= ~t, e = e.expirationTimes; 0 < t;) {
						var n = 31 - ot(t),
							r = 1 << n;
						e[n] = -1, t &= ~r
					}
				}

				function ss(e) {
					if (0 !== (6 & yu)) throw Error(a(327));
					vs();
					var t = dt(e, 0);
					if (0 === (1 & t)) return ls(e, $e()), null;
					var n = As(e, t);
					if (0 !== e.tag && 2 === n) {
						var r = mt(e);
						0 !== r && (t = r, n = os(e, r))
					}
					if (1 === n) throw n = Gu, Es(e, 0), us(e, t), ls(e, $e()), n;
					if (6 === n) throw Error(a(345));
					return e.finishedWork = e.current.alternate, e.finishedLanes = t, Is(e, Yu, Wu), ls(e, $e()), null
				}

				function cs(e, t) {
					var n = yu;
					yu |= 1;
					try {
						return e(t)
					} finally {
						0 === (yu = n) && (Ku = $e() + 500, xl && _l())
					}
				}

				function fs(e) {
					null !== Ju && 0 === Ju.tag && 0 === (6 & yu) && vs();
					var t = yu;
					yu |= 1;
					var n = Lu.transition,
						r = Rt;
					try {
						if (Lu.transition = null, Rt = 1, e) return e()
					} finally {
						Rt = r, Lu.transition = n, 0 === (6 & (yu = t)) && _l()
					}
				}

				function ds() {
					Du = Hu.current, gl(Hu)
				}

				function Es(e, t) {
					e.finishedWork = null, e.finishedLanes = 0;
					var n = e.timeoutHandle;
					if (-1 !== n && (e.timeoutHandle = -1, ll(n)), null !== Mu)
						for (n = Mu.return; null !== n;) {
							var r = n;
							switch (ta(r), r.tag) {
								case 1:
									null !== (r = r.type.childContextTypes) && void 0 !== r && Dl();
									break;
								case 3:
									lo(), gl(yl), gl(Ll), co();
									break;
								case 5:
									oo(r);
									break;
								case 4:
									lo();
									break;
								case 13:
								case 19:
									gl(io);
									break;
								case 10:
									Ia(r.type._context);
									break;
								case 22:
								case 23:
									ds()
							}
							n = n.return
						}
					if (Pu = e, Mu = e = Hs(e.current, null), Uu = Du = t, wu = 0, Gu = null, xu = Bu = ku = 0, Yu = Fu = null, null !== ba) {
						for (t = 0; t < ba.length; t++)
							if (null !== (r = (n = ba[t]).interleaved)) {
								n.interleaved = null;
								var l = r.next,
									a = n.pending;
								if (null !== a) {
									var o = a.next;
									a.next = l, r.next = o
								}
								n.pending = r
							}
						ba = null
					}
					return e
				}

				function ms(e, t) {
					for (;;) {
						var n = Mu;
						try {
							if (Na(), fo.current = oi, Oo) {
								for (var r = po.memoizedState; null !== r;) {
									var l = r.queue;
									null !== l && (l.pending = null), r = r.next
								}
								Oo = !1
							}
							if (mo = 0, Ao = So = po = null, Ro = !1, To = 0, Cu.current = null, null === n || null === n.return) {
								wu = 1, Gu = t, Mu = null;
								break
							}
							e: {
								var o = e,
									i = n.return,
									u = n,
									s = t;
								if (t = Uu, u.flags |= 32768, null !== s && "object" === typeof s && "function" === typeof s.then) {
									var c = s,
										f = u,
										d = f.tag;
									if (0 === (1 & f.mode) && (0 === d || 11 === d || 15 === d)) {
										var E = f.alternate;
										E ? (f.updateQueue = E.updateQueue, f.memoizedState = E.memoizedState, f.lanes = E.lanes) : (f.updateQueue = null, f.memoizedState = null)
									}
									var m = Ai(i);
									if (null !== m) {
										m.flags &= -257, Oi(m, i, u, 0, t), 1 & m.mode && Si(o, c, t), s = c;
										var p = (t = m).updateQueue;
										if (null === p) {
											var S = new Set;
											S.add(s), t.updateQueue = S
										} else p.add(s);
										break e
									}
									if (0 === (1 & t)) {
										Si(o, c, t), Ss();
										break e
									}
									s = Error(a(426))
								} else if (la && 1 & u.mode) {
									var A = Ai(i);
									if (null !== A) {
										0 === (65536 & A.flags) && (A.flags |= 256), Oi(A, i, u, 0, t), ma(ci(s, u));
										break e
									}
								}
								o = s = ci(s, u),
								4 !== wu && (wu = 2),
								null === Fu ? Fu = [o] : Fu.push(o),
								o = i;do {
									switch (o.tag) {
										case 3:
											o.flags |= 65536, t &= -t, o.lanes |= t, Ga(o, mi(0, s, t));
											break e;
										case 1:
											u = s;
											var O = o.type,
												R = o.stateNode;
											if (0 === (128 & o.flags) && ("function" === typeof O.getDerivedStateFromError || null !== R && "function" === typeof R.componentDidCatch && (null === zu || !zu.has(R)))) {
												o.flags |= 65536, t &= -t, o.lanes |= t, Ga(o, pi(o, u, t));
												break e
											}
									}
									o = o.return
								} while (null !== o)
							}
							Ns(n)
						} catch (T) {
							t = T, Mu === n && null !== n && (Mu = n = n.return);
							continue
						}
						break
					}
				}

				function ps() {
					var e = bu.current;
					return bu.current = oi, null === e ? oi : e
				}

				function Ss() {
					0 !== wu && 3 !== wu && 2 !== wu || (wu = 4), null === Pu || 0 === (268435455 & ku) && 0 === (268435455 & Bu) || us(Pu, Uu)
				}

				function As(e, t) {
					var n = yu;
					yu |= 2;
					var r = ps();
					for (Pu === e && Uu === t || (Wu = null, Es(e, t));;) try {
						Os();
						break
					} catch (l) {
						ms(e, l)
					}
					if (Na(), yu = n, bu.current = r, null !== Mu) throw Error(a(261));
					return Pu = null, Uu = 0, wu
				}

				function Os() {
					for (; null !== Mu;) Ts(Mu)
				}

				function Rs() {
					for (; null !== Mu && !Je();) Ts(Mu)
				}

				function Ts(e) {
					var t = hu(e.alternate, e, Du);
					e.memoizedProps = e.pendingProps, null === t ? Ns(e) : Mu = t, Cu.current = null
				}

				function Ns(e) {
					var t = e;
					do {
						var n = t.alternate;
						if (e = t.return, 0 === (32768 & t.flags)) {
							if (null !== (n = Qi(n, t, Du))) return void(Mu = n)
						} else {
							if (null !== (n = Ji(n, t))) return n.flags &= 32767, void(Mu = n);
							if (null === e) return wu = 6, void(Mu = null);
							e.flags |= 32768, e.subtreeFlags = 0, e.deletions = null
						}
						if (null !== (t = t.sibling)) return void(Mu = t);
						Mu = t = e
					} while (null !== t);
					0 === wu && (wu = 5)
				}

				function Is(e, t, n) {
					var r = Rt,
						l = Lu.transition;
					try {
						Lu.transition = null, Rt = 1,
							function(e, t, n, r) {
								do {
									vs()
								} while (null !== Ju);
								if (0 !== (6 & yu)) throw Error(a(327));
								n = e.finishedWork;
								var l = e.finishedLanes;
								if (null === n) return null;
								if (e.finishedWork = null, e.finishedLanes = 0, n === e.current) throw Error(a(177));
								e.callbackNode = null, e.callbackPriority = 0;
								var o = n.lanes | n.childLanes;
								if (function(e, t) {
										var n = e.pendingLanes & ~t;
										e.pendingLanes = t, e.suspendedLanes = 0, e.pingedLanes = 0, e.expiredLanes &= t, e.mutableReadLanes &= t, e.entangledLanes &= t, t = e.entanglements;
										var r = e.eventTimes;
										for (e = e.expirationTimes; 0 < n;) {
											var l = 31 - ot(n),
												a = 1 << l;
											t[l] = 0, r[l] = -1, e[l] = -1, n &= ~a
										}
									}(e, o), e === Pu && (Mu = Pu = null, Uu = 0), 0 === (2064 & n.subtreeFlags) && 0 === (2064 & n.flags) || Qu || (Qu = !0, Ps(tt, (function() {
										return vs(), null
									}))), o = 0 !== (15990 & n.flags), 0 !== (15990 & n.subtreeFlags) || o) {
									o = Lu.transition, Lu.transition = null;
									var i = Rt;
									Rt = 1;
									var u = yu;
									yu |= 4, Cu.current = null,
										function(e, t) {
											if (el = Wt, Er(e = dr())) {
												if ("selectionStart" in e) var n = {
													start: e.selectionStart,
													end: e.selectionEnd
												};
												else e: {
													var r = (n = (n = e.ownerDocument) && n.defaultView || window).getSelection && n.getSelection();
													if (r && 0 !== r.rangeCount) {
														n = r.anchorNode;
														var l = r.anchorOffset,
															o = r.focusNode;
														r = r.focusOffset;
														try {
															n.nodeType, o.nodeType
														} catch (N) {
															n = null;
															break e
														}
														var i = 0,
															u = -1,
															s = -1,
															c = 0,
															f = 0,
															d = e,
															E = null;
														t: for (;;) {
															for (var m; d !== n || 0 !== l && 3 !== d.nodeType || (u = i + l), d !== o || 0 !== r && 3 !== d.nodeType || (s = i + r), 3 === d.nodeType && (i += d.nodeValue.length), null !== (m = d.firstChild);) E = d, d = m;
															for (;;) {
																if (d === e) break t;
																if (E === n && ++c === l && (u = i), E === o && ++f === r && (s = i), null !== (m = d.nextSibling)) break;
																E = (d = E).parentNode
															}
															d = m
														}
														n = -1 === u || -1 === s ? null : {
															start: u,
															end: s
														}
													} else n = null
												}
												n = n || {
													start: 0,
													end: 0
												}
											} else n = null;
											for (tl = {
													focusedElem: e,
													selectionRange: n
												}, Wt = !1, qi = t; null !== qi;)
												if (e = (t = qi).child, 0 !== (1028 & t.subtreeFlags) && null !== e) e.return = t, qi = e;
												else
													for (; null !== qi;) {
														t = qi;
														try {
															var p = t.alternate;
															if (0 !== (1024 & t.flags)) switch (t.tag) {
																case 0:
																case 11:
																case 15:
																case 5:
																case 6:
																case 4:
																case 17:
																	break;
																case 1:
																	if (null !== p) {
																		var S = p.memoizedProps,
																			A = p.memoizedState,
																			O = t.stateNode,
																			R = O.getSnapshotBeforeUpdate(t.elementType === t.type ? S : Sa(t.type, S), A);
																		O.__reactInternalSnapshotBeforeUpdate = R
																	}
																	break;
																case 3:
																	var T = t.stateNode.containerInfo;
																	1 === T.nodeType ? T.textContent = "" : 9 === T.nodeType && T.documentElement && T.removeChild(T.documentElement);
																	break;
																default:
																	throw Error(a(163))
															}
														} catch (N) {
															gs(t, t.return, N)
														}
														if (null !== (e = t.sibling)) {
															e.return = t.return, qi = e;
															break
														}
														qi = t.return
													}
											p = nu, nu = !1
										}(e, n), Au(n, e), mr(tl), Wt = !!el, tl = el = null, e.current = n, Ru(n, e, l), Ze(), yu = u, Rt = i, Lu.transition = o
								} else e.current = n;
								if (Qu && (Qu = !1, Ju = e, Zu = l), o = e.pendingLanes, 0 === o && (zu = null), function(e) {
										if (at && "function" === typeof at.onCommitFiberRoot) try {
											at.onCommitFiberRoot(lt, e, void 0, 128 === (128 & e.current.flags))
										} catch (t) {}
									}(n.stateNode), ls(e, $e()), null !== t)
									for (r = e.onRecoverableError, n = 0; n < t.length; n++) l = t[n], r(l.value, {
										componentStack: l.stack,
										digest: l.digest
									});
								if (ju) throw ju = !1, e = Vu, Vu = null, e;
								0 !== (1 & Zu) && 0 !== e.tag && vs(), o = e.pendingLanes, 0 !== (1 & o) ? e === Xu ? $u++ : ($u = 0, Xu = e) : $u = 0, _l()
							}(e, t, n, r)
					} finally {
						Lu.transition = l, Rt = r
					}
					return null
				}

				function vs() {
					if (null !== Ju) {
						var e = Tt(Zu),
							t = Lu.transition,
							n = Rt;
						try {
							if (Lu.transition = null, Rt = 16 > e ? 16 : e, null === Ju) var r = !1;
							else {
								if (e = Ju, Ju = null, Zu = 0, 0 !== (6 & yu)) throw Error(a(331));
								var l = yu;
								for (yu |= 4, qi = e.current; null !== qi;) {
									var o = qi,
										i = o.child;
									if (0 !== (16 & qi.flags)) {
										var u = o.deletions;
										if (null !== u) {
											for (var s = 0; s < u.length; s++) {
												var c = u[s];
												for (qi = c; null !== qi;) {
													var f = qi;
													switch (f.tag) {
														case 0:
														case 11:
														case 15:
															ru(8, f, o)
													}
													var d = f.child;
													if (null !== d) d.return = f, qi = d;
													else
														for (; null !== qi;) {
															var E = (f = qi).sibling,
																m = f.return;
															if (ou(f), f === c) {
																qi = null;
																break
															}
															if (null !== E) {
																E.return = m, qi = E;
																break
															}
															qi = m
														}
												}
											}
											var p = o.alternate;
											if (null !== p) {
												var S = p.child;
												if (null !== S) {
													p.child = null;
													do {
														var A = S.sibling;
														S.sibling = null, S = A
													} while (null !== S)
												}
											}
											qi = o
										}
									}
									if (0 !== (2064 & o.subtreeFlags) && null !== i) i.return = o, qi = i;
									else e: for (; null !== qi;) {
										if (0 !== (2048 & (o = qi).flags)) switch (o.tag) {
											case 0:
											case 11:
											case 15:
												ru(9, o, o.return)
										}
										var O = o.sibling;
										if (null !== O) {
											O.return = o.return, qi = O;
											break e
										}
										qi = o.return
									}
								}
								var R = e.current;
								for (qi = R; null !== qi;) {
									var T = (i = qi).child;
									if (0 !== (2064 & i.subtreeFlags) && null !== T) T.return = i, qi = T;
									else e: for (i = R; null !== qi;) {
										if (0 !== (2048 & (u = qi).flags)) try {
											switch (u.tag) {
												case 0:
												case 11:
												case 15:
													lu(9, u)
											}
										} catch (I) {
											gs(u, u.return, I)
										}
										if (u === i) {
											qi = null;
											break e
										}
										var N = u.sibling;
										if (null !== N) {
											N.return = u.return, qi = N;
											break e
										}
										qi = u.return
									}
								}
								if (yu = l, _l(), at && "function" === typeof at.onPostCommitFiberRoot) try {
									at.onPostCommitFiberRoot(lt, e)
								} catch (I) {}
								r = !0
							}
							return r
						} finally {
							Rt = n, Lu.transition = t
						}
					}
					return !1
				}

				function hs(e, t, n) {
					e = Ha(e, t = mi(0, t = ci(n, t), 1), 1), t = ts(), null !== e && (At(e, 1, t), ls(e, t))
				}

				function gs(e, t, n) {
					if (3 === e.tag) hs(e, e, n);
					else
						for (; null !== t;) {
							if (3 === t.tag) {
								hs(t, e, n);
								break
							}
							if (1 === t.tag) {
								var r = t.stateNode;
								if ("function" === typeof t.type.getDerivedStateFromError || "function" === typeof r.componentDidCatch && (null === zu || !zu.has(r))) {
									t = Ha(t, e = pi(t, e = ci(n, e), 1), 1), e = ts(), null !== t && (At(t, 1, e), ls(t, e));
									break
								}
							}
							t = t.return
						}
				}

				function bs(e, t, n) {
					var r = e.pingCache;
					null !== r && r.delete(t), t = ts(), e.pingedLanes |= e.suspendedLanes & n, Pu === e && (Uu & n) === n && (4 === wu || 3 === wu && (130023424 & Uu) === Uu && 500 > $e() - _u ? Es(e, 0) : xu |= n), ls(e, t)
				}

				function Cs(e, t) {
					0 === t && (0 === (1 & e.mode) ? t = 1 : (t = ct, 0 === (130023424 & (ct <<= 1)) && (ct = 4194304)));
					var n = ts();
					null !== (e = ya(e, t)) && (At(e, t, n), ls(e, n))
				}

				function Ls(e) {
					var t = e.memoizedState,
						n = 0;
					null !== t && (n = t.retryLane), Cs(e, n)
				}

				function ys(e, t) {
					var n = 0;
					switch (e.tag) {
						case 13:
							var r = e.stateNode,
								l = e.memoizedState;
							null !== l && (n = l.retryLane);
							break;
						case 19:
							r = e.stateNode;
							break;
						default:
							throw Error(a(314))
					}
					null !== r && r.delete(t), Cs(e, n)
				}

				function Ps(e, t) {
					return ze(e, t)
				}

				function Ms(e, t, n, r) {
					this.tag = e, this.key = n, this.sibling = this.child = this.return = this.stateNode = this.type = this.elementType = null, this.index = 0, this.ref = null, this.pendingProps = t, this.dependencies = this.memoizedState = this.updateQueue = this.memoizedProps = null, this.mode = r, this.subtreeFlags = this.flags = 0, this.deletions = null, this.childLanes = this.lanes = 0, this.alternate = null
				}

				function Us(e, t, n, r) {
					return new Ms(e, t, n, r)
				}

				function Ds(e) {
					return !(!(e = e.prototype) || !e.isReactComponent)
				}

				function Hs(e, t) {
					var n = e.alternate;
					return null === n ? ((n = Us(e.tag, t, e.key, e.mode)).elementType = e.elementType, n.type = e.type, n.stateNode = e.stateNode, n.alternate = e, e.alternate = n) : (n.pendingProps = t, n.type = e.type, n.flags = 0, n.subtreeFlags = 0, n.deletions = null), n.flags = 14680064 & e.flags, n.childLanes = e.childLanes, n.lanes = e.lanes, n.child = e.child, n.memoizedProps = e.memoizedProps, n.memoizedState = e.memoizedState, n.updateQueue = e.updateQueue, t = e.dependencies, n.dependencies = null === t ? null : {
						lanes: t.lanes,
						firstContext: t.firstContext
					}, n.sibling = e.sibling, n.index = e.index, n.ref = e.ref, n
				}

				function ws(e, t, n, r, l, o) {
					var i = 2;
					if (r = e, "function" === typeof e) Ds(e) && (i = 1);
					else if ("string" === typeof e) i = 5;
					else e: switch (e) {
						case v:
							return Gs(n.children, l, o, t);
						case h:
							i = 8, l |= 8;
							break;
						case g:
							return (e = Us(12, n, t, 2 | l)).elementType = g, e.lanes = o, e;
						case y:
							return (e = Us(13, n, t, l)).elementType = y, e.lanes = o, e;
						case P:
							return (e = Us(19, n, t, l)).elementType = P, e.lanes = o, e;
						case D:
							return ks(n, l, o, t);
						default:
							if ("object" === typeof e && null !== e) switch (e.$$typeof) {
								case b:
									i = 10;
									break e;
								case C:
									i = 9;
									break e;
								case L:
									i = 11;
									break e;
								case M:
									i = 14;
									break e;
								case U:
									i = 16, r = null;
									break e
							}
							throw Error(a(130, null == e ? e : typeof e, ""))
					}
					return (t = Us(i, n, t, l)).elementType = e, t.type = r, t.lanes = o, t
				}

				function Gs(e, t, n, r) {
					return (e = Us(7, e, r, t)).lanes = n, e
				}

				function ks(e, t, n, r) {
					return (e = Us(22, e, r, t)).elementType = D, e.lanes = n, e.stateNode = {
						isHidden: !1
					}, e
				}

				function Bs(e, t, n) {
					return (e = Us(6, e, null, t)).lanes = n, e
				}

				function xs(e, t, n) {
					return (t = Us(4, null !== e.children ? e.children : [], e.key, t)).lanes = n, t.stateNode = {
						containerInfo: e.containerInfo,
						pendingChildren: null,
						implementation: e.implementation
					}, t
				}

				function Fs(e, t, n, r, l) {
					this.tag = t, this.containerInfo = e, this.finishedWork = this.pingCache = this.current = this.pendingChildren = null, this.timeoutHandle = -1, this.callbackNode = this.pendingContext = this.context = null, this.callbackPriority = 0, this.eventTimes = St(0), this.expirationTimes = St(-1), this.entangledLanes = this.finishedLanes = this.mutableReadLanes = this.expiredLanes = this.pingedLanes = this.suspendedLanes = this.pendingLanes = 0, this.entanglements = St(0), this.identifierPrefix = r, this.onRecoverableError = l, this.mutableSourceEagerHydrationData = null
				}

				function Ys(e, t, n, r, l, a, o, i, u) {
					return e = new Fs(e, t, n, i, u), 1 === t ? (t = 1, !0 === a && (t |= 8)) : t = 0, a = Us(3, null, null, t), e.current = a, a.stateNode = e, a.memoizedState = {
						element: r,
						isDehydrated: n,
						cache: null,
						transitions: null,
						pendingSuspenseBoundaries: null
					}, Ma(a), e
				}

				function _s(e) {
					if (!e) return Cl;
					e: {
						if (_e(e = e._reactInternals) !== e || 1 !== e.tag) throw Error(a(170));
						var t = e;do {
							switch (t.tag) {
								case 3:
									t = t.stateNode.context;
									break e;
								case 1:
									if (Ul(t.type)) {
										t = t.stateNode.__reactInternalMemoizedMergedChildContext;
										break e
									}
							}
							t = t.return
						} while (null !== t);
						throw Error(a(171))
					}
					if (1 === e.tag) {
						var n = e.type;
						if (Ul(n)) return wl(e, n, t)
					}
					return t
				}

				function Ks(e, t, n, r, l, a, o, i, u) {
					return (e = Ys(n, r, !0, e, 0, a, 0, i, u)).context = _s(null), n = e.current, (a = Da(r = ts(), l = ns(n))).callback = void 0 !== t && null !== t ? t : null, Ha(n, a, l), e.current.lanes = l, At(e, l, r), ls(e, r), e
				}

				function Ws(e, t, n, r) {
					var l = t.current,
						a = ts(),
						o = ns(l);
					return n = _s(n), null === t.context ? t.context = n : t.pendingContext = n, (t = Da(a, o)).payload = {
						element: e
					}, null !== (r = void 0 === r ? null : r) && (t.callback = r), null !== (e = Ha(l, t, o)) && (rs(e, l, o, a), wa(e, l, o)), o
				}

				function js(e) {
					return (e = e.current).child ? (e.child.tag, e.child.stateNode) : null
				}

				function Vs(e, t) {
					if (null !== (e = e.memoizedState) && null !== e.dehydrated) {
						var n = e.retryLane;
						e.retryLane = 0 !== n && n < t ? n : t
					}
				}

				function zs(e, t) {
					Vs(e, t), (e = e.alternate) && Vs(e, t)
				}
				hu = function(e, t, n) {
					if (null !== e)
						if (e.memoizedProps !== t.pendingProps || yl.current) Ti = !0;
						else {
							if (0 === (e.lanes & n) && 0 === (128 & t.flags)) return Ti = !1,
								function(e, t, n) {
									switch (t.tag) {
										case 3:
											Pi(t), Ea();
											break;
										case 5:
											ao(t);
											break;
										case 1:
											Ul(t.type) && Gl(t);
											break;
										case 4:
											ro(t, t.stateNode.containerInfo);
											break;
										case 10:
											var r = t.type._context,
												l = t.memoizedProps.value;
											bl(Aa, r._currentValue), r._currentValue = l;
											break;
										case 13:
											if (null !== (r = t.memoizedState)) return null !== r.dehydrated ? (bl(io, 1 & io.current), t.flags |= 128, null) : 0 !== (n & t.child.childLanes) ? Bi(e, t, n) : (bl(io, 1 & io.current), null !== (e = ji(e, t, n)) ? e.sibling : null);
											bl(io, 1 & io.current);
											break;
										case 19:
											if (r = 0 !== (n & t.childLanes), 0 !== (128 & e.flags)) {
												if (r) return Ki(e, t, n);
												t.flags |= 128
											}
											if (null !== (l = t.memoizedState) && (l.rendering = null, l.tail = null, l.lastEffect = null), bl(io, io.current), r) break;
											return null;
										case 22:
										case 23:
											return t.lanes = 0, gi(e, t, n)
									}
									return ji(e, t, n)
								}(e, t, n);
							Ti = 0 !== (131072 & e.flags)
						}
					else Ti = !1, la && 0 !== (1048576 & t.flags) && ql(t, Vl, t.index);
					switch (t.lanes = 0, t.tag) {
						case 2:
							var r = t.type;
							Wi(e, t), e = t.pendingProps;
							var l = Ml(t, Ll.current);
							ha(t, n), l = ho(null, t, r, e, l, n);
							var o = go();
							return t.flags |= 1, "object" === typeof l && null !== l && "function" === typeof l.render && void 0 === l.$$typeof ? (t.tag = 1, t.memoizedState = null, t.updateQueue = null, Ul(r) ? (o = !0, Gl(t)) : o = !1, t.memoizedState = null !== l.state && void 0 !== l.state ? l.state : null, Ma(t), l.updater = Ya, t.stateNode = l, l._reactInternals = t, ja(t, r, e, n), t = yi(null, t, r, !0, o, n)) : (t.tag = 0, la && o && ea(t), Ni(null, t, l, n), t = t.child), t;
						case 16:
							r = t.elementType;
							e: {
								switch (Wi(e, t), e = t.pendingProps, r = (l = r._init)(r._payload), t.type = r, l = t.tag = function(e) {
									if ("function" === typeof e) return Ds(e) ? 1 : 0;
									if (void 0 !== e && null !== e) {
										if ((e = e.$$typeof) === L) return 11;
										if (e === M) return 14
									}
									return 2
								}(r), e = Sa(r, e), l) {
									case 0:
										t = Ci(null, t, r, e, n);
										break e;
									case 1:
										t = Li(null, t, r, e, n);
										break e;
									case 11:
										t = Ii(null, t, r, e, n);
										break e;
									case 14:
										t = vi(null, t, r, Sa(r.type, e), n);
										break e
								}
								throw Error(a(306, r, ""))
							}
							return t;
						case 0:
							return r = t.type, l = t.pendingProps, Ci(e, t, r, l = t.elementType === r ? l : Sa(r, l), n);
						case 1:
							return r = t.type, l = t.pendingProps, Li(e, t, r, l = t.elementType === r ? l : Sa(r, l), n);
						case 3:
							e: {
								if (Pi(t), null === e) throw Error(a(387));r = t.pendingProps,
								l = (o = t.memoizedState).element,
								Ua(e, t),
								ka(t, r, null, n);
								var i = t.memoizedState;
								if (r = i.element, o.isDehydrated) {
									if (o = {
											element: r,
											isDehydrated: !1,
											cache: i.cache,
											pendingSuspenseBoundaries: i.pendingSuspenseBoundaries,
											transitions: i.transitions
										}, t.updateQueue.baseState = o, t.memoizedState = o, 256 & t.flags) {
										t = Mi(e, t, r, n, l = ci(Error(a(423)), t));
										break e
									}
									if (r !== l) {
										t = Mi(e, t, r, n, l = ci(Error(a(424)), t));
										break e
									}
									for (ra = sl(t.stateNode.containerInfo.firstChild), na = t, la = !0, aa = null, n = $a(t, null, r, n), t.child = n; n;) n.flags = -3 & n.flags | 4096, n = n.sibling
								} else {
									if (Ea(), r === l) {
										t = ji(e, t, n);
										break e
									}
									Ni(e, t, r, n)
								}
								t = t.child
							}
							return t;
						case 5:
							return ao(t), null === e && sa(t), r = t.type, l = t.pendingProps, o = null !== e ? e.memoizedProps : null, i = l.children, nl(r, l) ? i = null : null !== o && nl(r, o) && (t.flags |= 32), bi(e, t), Ni(e, t, i, n), t.child;
						case 6:
							return null === e && sa(t), null;
						case 13:
							return Bi(e, t, n);
						case 4:
							return ro(t, t.stateNode.containerInfo), r = t.pendingProps, null === e ? t.child = Za(t, null, r, n) : Ni(e, t, r, n), t.child;
						case 11:
							return r = t.type, l = t.pendingProps, Ii(e, t, r, l = t.elementType === r ? l : Sa(r, l), n);
						case 7:
							return Ni(e, t, t.pendingProps, n), t.child;
						case 8:
						case 12:
							return Ni(e, t, t.pendingProps.children, n), t.child;
						case 10:
							e: {
								if (r = t.type._context, l = t.pendingProps, o = t.memoizedProps, i = l.value, bl(Aa, r._currentValue), r._currentValue = i, null !== o)
									if (ir(o.value, i)) {
										if (o.children === l.children && !yl.current) {
											t = ji(e, t, n);
											break e
										}
									} else
										for (null !== (o = t.child) && (o.return = t); null !== o;) {
											var u = o.dependencies;
											if (null !== u) {
												i = o.child;
												for (var s = u.firstContext; null !== s;) {
													if (s.context === r) {
														if (1 === o.tag) {
															(s = Da(-1, n & -n)).tag = 2;
															var c = o.updateQueue;
															if (null !== c) {
																var f = (c = c.shared).pending;
																null === f ? s.next = s : (s.next = f.next, f.next = s), c.pending = s
															}
														}
														o.lanes |= n, null !== (s = o.alternate) && (s.lanes |= n), va(o.return, n, t), u.lanes |= n;
														break
													}
													s = s.next
												}
											} else if (10 === o.tag) i = o.type === t.type ? null : o.child;
											else if (18 === o.tag) {
												if (null === (i = o.return)) throw Error(a(341));
												i.lanes |= n, null !== (u = i.alternate) && (u.lanes |= n), va(i, n, t), i = o.sibling
											} else i = o.child;
											if (null !== i) i.return = o;
											else
												for (i = o; null !== i;) {
													if (i === t) {
														i = null;
														break
													}
													if (null !== (o = i.sibling)) {
														o.return = i.return, i = o;
														break
													}
													i = i.return
												}
											o = i
										}
								Ni(e, t, l.children, n),
								t = t.child
							}
							return t;
						case 9:
							return l = t.type, r = t.pendingProps.children, ha(t, n), r = r(l = ga(l)), t.flags |= 1, Ni(e, t, r, n), t.child;
						case 14:
							return l = Sa(r = t.type, t.pendingProps), vi(e, t, r, l = Sa(r.type, l), n);
						case 15:
							return hi(e, t, t.type, t.pendingProps, n);
						case 17:
							return r = t.type, l = t.pendingProps, l = t.elementType === r ? l : Sa(r, l), Wi(e, t), t.tag = 1, Ul(r) ? (e = !0, Gl(t)) : e = !1, ha(t, n), Ka(t, r, l), ja(t, r, l, n), yi(null, t, r, !0, e, n);
						case 19:
							return Ki(e, t, n);
						case 22:
							return gi(e, t, n)
					}
					throw Error(a(156, t.tag))
				};
				var Qs = "function" === typeof reportError ? reportError : function(e) {
					console.error(e)
				};

				function Js(e) {
					this._internalRoot = e
				}

				function Zs(e) {
					this._internalRoot = e
				}

				function $s(e) {
					return !(!e || 1 !== e.nodeType && 9 !== e.nodeType && 11 !== e.nodeType)
				}

				function Xs(e) {
					return !(!e || 1 !== e.nodeType && 9 !== e.nodeType && 11 !== e.nodeType && (8 !== e.nodeType || " react-mount-point-unstable " !== e.nodeValue))
				}

				function qs() {}

				function ec(e, t, n, r, l) {
					var a = n._reactRootContainer;
					if (a) {
						var o = a;
						if ("function" === typeof l) {
							var i = l;
							l = function() {
								var e = js(o);
								i.call(e)
							}
						}
						Ws(t, o, e, l)
					} else o = function(e, t, n, r, l) {
						if (l) {
							if ("function" === typeof r) {
								var a = r;
								r = function() {
									var e = js(o);
									a.call(e)
								}
							}
							var o = Ks(t, r, e, 0, null, !1, 0, "", qs);
							return e._reactRootContainer = o, e[ml] = o.current, _r(8 === e.nodeType ? e.parentNode : e), fs(), o
						}
						for (; l = e.lastChild;) e.removeChild(l);
						if ("function" === typeof r) {
							var i = r;
							r = function() {
								var e = js(u);
								i.call(e)
							}
						}
						var u = Ys(e, 0, !1, null, 0, !1, 0, "", qs);
						return e._reactRootContainer = u, e[ml] = u.current, _r(8 === e.nodeType ? e.parentNode : e), fs((function() {
							Ws(t, u, n, r)
						})), u
					}(n, t, e, l, r);
					return js(o)
				}
				Zs.prototype.render = Js.prototype.render = function(e) {
					var t = this._internalRoot;
					if (null === t) throw Error(a(409));
					Ws(e, t, null, null)
				}, Zs.prototype.unmount = Js.prototype.unmount = function() {
					var e = this._internalRoot;
					if (null !== e) {
						this._internalRoot = null;
						var t = e.containerInfo;
						fs((function() {
							Ws(null, e, null, null)
						})), t[ml] = null
					}
				}, Zs.prototype.unstable_scheduleHydration = function(e) {
					if (e) {
						var t = ht();
						e = {
							blockedOn: null,
							target: e,
							priority: t
						};
						for (var n = 0; n < Dt.length && 0 !== t && t < Dt[n].priority; n++);
						Dt.splice(n, 0, e), 0 === n && kt(e)
					}
				}, Nt = function(e) {
					switch (e.tag) {
						case 3:
							var t = e.stateNode;
							if (t.current.memoizedState.isDehydrated) {
								var n = ft(t.pendingLanes);
								0 !== n && (Ot(t, 1 | n), ls(t, $e()), 0 === (6 & yu) && (Ku = $e() + 500, _l()))
							}
							break;
						case 13:
							fs((function() {
								var t = ya(e, 1);
								if (null !== t) {
									var n = ts();
									rs(t, e, 1, n)
								}
							})), zs(e, 1)
					}
				}, It = function(e) {
					if (13 === e.tag) {
						var t = ya(e, 134217728);
						if (null !== t) rs(t, e, 134217728, ts());
						zs(e, 134217728)
					}
				}, vt = function(e) {
					if (13 === e.tag) {
						var t = ns(e),
							n = ya(e, t);
						if (null !== n) rs(n, e, t, ts());
						zs(e, t)
					}
				}, ht = function() {
					return Rt
				}, gt = function(e, t) {
					var n = Rt;
					try {
						return Rt = e, t()
					} finally {
						Rt = n
					}
				}, Ie = function(e, t, n) {
					switch (t) {
						case "input":
							if (X(e, n), t = n.name, "radio" === n.type && null != t) {
								for (n = e; n.parentNode;) n = n.parentNode;
								for (n = n.querySelectorAll("input[name=" + JSON.stringify("" + t) + '][type="radio"]'), t = 0; t < n.length; t++) {
									var r = n[t];
									if (r !== e && r.form === e.form) {
										var l = Nl(r);
										if (!l) throw Error(a(90));
										z(r), X(r, l)
									}
								}
							}
							break;
						case "textarea":
							ae(e, n);
							break;
						case "select":
							null != (t = n.value) && ne(e, !!n.multiple, t, !1)
					}
				}, Le = cs, ye = fs;
				var tc = {
						usingClientEntryPoint: !1,
						Events: [Rl, Tl, Nl, be, Ce, cs]
					},
					nc = {
						findFiberByHostInstance: Ol,
						bundleType: 0,
						version: "18.2.0",
						rendererPackageName: "react-dom"
					},
					rc = {
						bundleType: nc.bundleType,
						version: nc.version,
						rendererPackageName: nc.rendererPackageName,
						rendererConfig: nc.rendererConfig,
						overrideHookState: null,
						overrideHookStateDeletePath: null,
						overrideHookStateRenamePath: null,
						overrideProps: null,
						overridePropsDeletePath: null,
						overridePropsRenamePath: null,
						setErrorHandler: null,
						setSuspenseHandler: null,
						scheduleUpdate: null,
						currentDispatcherRef: T.ReactCurrentDispatcher,
						findHostInstanceByFiber: function(e) {
							return null === (e = je(e)) ? null : e.stateNode
						},
						findFiberByHostInstance: nc.findFiberByHostInstance || function() {
							return null
						},
						findHostInstancesForRefresh: null,
						scheduleRefresh: null,
						scheduleRoot: null,
						setRefreshHandler: null,
						getCurrentFiber: null,
						reconcilerVersion: "18.2.0-next-9e3b772b8-20220608"
					};
				if ("undefined" !== typeof __REACT_DEVTOOLS_GLOBAL_HOOK__) {
					var lc = __REACT_DEVTOOLS_GLOBAL_HOOK__;
					if (!lc.isDisabled && lc.supportsFiber) try {
						lt = lc.inject(rc), at = lc
					} catch (ce) {}
				}
				t.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED = tc, t.createPortal = function(e, t) {
					var n = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : null;
					if (!$s(t)) throw Error(a(200));
					return function(e, t, n) {
						var r = 3 < arguments.length && void 0 !== arguments[3] ? arguments[3] : null;
						return {
							$$typeof: I,
							key: null == r ? null : "" + r,
							children: e,
							containerInfo: t,
							implementation: n
						}
					}(e, t, null, n)
				}, t.createRoot = function(e, t) {
					if (!$s(e)) throw Error(a(299));
					var n = !1,
						r = "",
						l = Qs;
					return null !== t && void 0 !== t && (!0 === t.unstable_strictMode && (n = !0), void 0 !== t.identifierPrefix && (r = t.identifierPrefix), void 0 !== t.onRecoverableError && (l = t.onRecoverableError)), t = Ys(e, 1, !1, null, 0, n, 0, r, l), e[ml] = t.current, _r(8 === e.nodeType ? e.parentNode : e), new Js(t)
				}, t.findDOMNode = function(e) {
					if (null == e) return null;
					if (1 === e.nodeType) return e;
					var t = e._reactInternals;
					if (void 0 === t) {
						if ("function" === typeof e.render) throw Error(a(188));
						throw e = Object.keys(e).join(","), Error(a(268, e))
					}
					return e = null === (e = je(t)) ? null : e.stateNode
				}, t.flushSync = function(e) {
					return fs(e)
				}, t.hydrate = function(e, t, n) {
					if (!Xs(t)) throw Error(a(200));
					return ec(null, e, t, !0, n)
				}, t.hydrateRoot = function(e, t, n) {
					if (!$s(e)) throw Error(a(405));
					var r = null != n && n.hydratedSources || null,
						l = !1,
						o = "",
						i = Qs;
					if (null !== n && void 0 !== n && (!0 === n.unstable_strictMode && (l = !0), void 0 !== n.identifierPrefix && (o = n.identifierPrefix), void 0 !== n.onRecoverableError && (i = n.onRecoverableError)), t = Ks(t, null, e, 1, null != n ? n : null, l, 0, o, i), e[ml] = t.current, _r(e), r)
						for (e = 0; e < r.length; e++) l = (l = (n = r[e])._getVersion)(n._source), null == t.mutableSourceEagerHydrationData ? t.mutableSourceEagerHydrationData = [n, l] : t.mutableSourceEagerHydrationData.push(n, l);
					return new Zs(t)
				}, t.render = function(e, t, n) {
					if (!Xs(t)) throw Error(a(200));
					return ec(null, e, t, !1, n)
				}, t.unmountComponentAtNode = function(e) {
					if (!Xs(e)) throw Error(a(40));
					return !!e._reactRootContainer && (fs((function() {
						ec(null, null, e, !1, (function() {
							e._reactRootContainer = null, e[ml] = null
						}))
					})), !0)
				}, t.unstable_batchedUpdates = cs, t.unstable_renderSubtreeIntoContainer = function(e, t, n, r) {
					if (!Xs(n)) throw Error(a(200));
					if (null == e || void 0 === e._reactInternals) throw Error(a(38));
					return ec(e, t, n, !1, r)
				}, t.version = "18.2.0-next-9e3b772b8-20220608"
			},
			250: function(e, t, n) {
				"use strict";
				var r = n(164);
				t.createRoot = r.createRoot, t.hydrateRoot = r.hydrateRoot
			},
			164: function(e, t, n) {
				"use strict";
				! function e() {
					if ("undefined" !== typeof __REACT_DEVTOOLS_GLOBAL_HOOK__ && "function" === typeof __REACT_DEVTOOLS_GLOBAL_HOOK__.checkDCE) try {
						__REACT_DEVTOOLS_GLOBAL_HOOK__.checkDCE(e)
					} catch (t) {
						console.error(t)
					}
				}(), e.exports = n(463)
			},
			77: function(e) {
				var t = "undefined" !== typeof Element,
					n = "function" === typeof Map,
					r = "function" === typeof Set,
					l = "function" === typeof ArrayBuffer && !!ArrayBuffer.isView;

				function a(e, o) {
					if (e === o) return !0;
					if (e && o && "object" == typeof e && "object" == typeof o) {
						if (e.constructor !== o.constructor) return !1;
						var i, u, s, c;
						if (Array.isArray(e)) {
							if ((i = e.length) != o.length) return !1;
							for (u = i; 0 !== u--;)
								if (!a(e[u], o[u])) return !1;
							return !0
						}
						if (n && e instanceof Map && o instanceof Map) {
							if (e.size !== o.size) return !1;
							for (c = e.entries(); !(u = c.next()).done;)
								if (!o.has(u.value[0])) return !1;
							for (c = e.entries(); !(u = c.next()).done;)
								if (!a(u.value[1], o.get(u.value[0]))) return !1;
							return !0
						}
						if (r && e instanceof Set && o instanceof Set) {
							if (e.size !== o.size) return !1;
							for (c = e.entries(); !(u = c.next()).done;)
								if (!o.has(u.value[0])) return !1;
							return !0
						}
						if (l && ArrayBuffer.isView(e) && ArrayBuffer.isView(o)) {
							if ((i = e.length) != o.length) return !1;
							for (u = i; 0 !== u--;)
								if (e[u] !== o[u]) return !1;
							return !0
						}
						if (e.constructor === RegExp) return e.source === o.source && e.flags === o.flags;
						if (e.valueOf !== Object.prototype.valueOf && "function" === typeof e.valueOf && "function" === typeof o.valueOf) return e.valueOf() === o.valueOf();
						if (e.toString !== Object.prototype.toString && "function" === typeof e.toString && "function" === typeof o.toString) return e.toString() === o.toString();
						if ((i = (s = Object.keys(e)).length) !== Object.keys(o).length) return !1;
						for (u = i; 0 !== u--;)
							if (!Object.prototype.hasOwnProperty.call(o, s[u])) return !1;
						if (t && e instanceof Element) return !1;
						for (u = i; 0 !== u--;)
							if (("_owner" !== s[u] && "__v" !== s[u] && "__o" !== s[u] || !e.$$typeof) && !a(e[s[u]], o[s[u]])) return !1;
						return !0
					}
					return e !== e && o !== o
				}
				e.exports = function(e, t) {
					try {
						return a(e, t)
					} catch (n) {
						if ((n.message || "").match(/stack|recursion/i)) return console.warn("react-fast-compare cannot handle circular refs"), !1;
						throw n
					}
				}
			},
			475: function(e, t, n) {
				"use strict";
				var r, l = n(791),
					a = (r = l) && "object" === typeof r && "default" in r ? r.default : r;

				function o(e, t, n) {
					return t in e ? Object.defineProperty(e, t, {
						value: n,
						enumerable: !0,
						configurable: !0,
						writable: !0
					}) : e[t] = n, e
				}
				var i = !("undefined" === typeof window || !window.document || !window.document.createElement);
				e.exports = function(e, t, n) {
					if ("function" !== typeof e) throw new Error("Expected reducePropsToState to be a function.");
					if ("function" !== typeof t) throw new Error("Expected handleStateChangeOnClient to be a function.");
					if ("undefined" !== typeof n && "function" !== typeof n) throw new Error("Expected mapStateOnServer to either be undefined or a function.");
					return function(r) {
						if ("function" !== typeof r) throw new Error("Expected WrappedComponent to be a React component.");
						var u, s = [];

						function c() {
							u = e(s.map((function(e) {
								return e.props
							}))), f.canUseDOM ? t(u) : n && (u = n(u))
						}
						var f = function(e) {
							var t, n;

							function l() {
								return e.apply(this, arguments) || this
							}
							n = e, (t = l).prototype = Object.create(n.prototype), t.prototype.constructor = t, t.__proto__ = n, l.peek = function() {
								return u
							}, l.rewind = function() {
								if (l.canUseDOM) throw new Error("You may only call rewind() on the server. Call peek() to read the current state.");
								var e = u;
								return u = void 0, s = [], e
							};
							var o = l.prototype;
							return o.UNSAFE_componentWillMount = function() {
								s.push(this), c()
							}, o.componentDidUpdate = function() {
								c()
							}, o.componentWillUnmount = function() {
								var e = s.indexOf(this);
								s.splice(e, 1), c()
							}, o.render = function() {
								return a.createElement(r, this.props)
							}, l
						}(l.PureComponent);
						return o(f, "displayName", "SideEffect(" + function(e) {
							return e.displayName || e.name || "Component"
						}(r) + ")"), o(f, "canUseDOM", i), f
					}
				}
			},
			374: function(e, t, n) {
				"use strict";
				var r = n(791),
					l = Symbol.for("react.element"),
					a = Symbol.for("react.fragment"),
					o = Object.prototype.hasOwnProperty,
					i = r.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED.ReactCurrentOwner,
					u = {
						key: !0,
						ref: !0,
						__self: !0,
						__source: !0
					};

				function s(e, t, n) {
					var r, a = {},
						s = null,
						c = null;
					for (r in void 0 !== n && (s = "" + n), void 0 !== t.key && (s = "" + t.key), void 0 !== t.ref && (c = t.ref), t) o.call(t, r) && !u.hasOwnProperty(r) && (a[r] = t[r]);
					if (e && e.defaultProps)
						for (r in t = e.defaultProps) void 0 === a[r] && (a[r] = t[r]);
					return {
						$$typeof: l,
						type: e,
						key: s,
						ref: c,
						props: a,
						_owner: i.current
					}
				}
				t.Fragment = a, t.jsx = s, t.jsxs = s
			},
			117: function(e, t) {
				"use strict";
				var n = Symbol.for("react.element"),
					r = Symbol.for("react.portal"),
					l = Symbol.for("react.fragment"),
					a = Symbol.for("react.strict_mode"),
					o = Symbol.for("react.profiler"),
					i = Symbol.for("react.provider"),
					u = Symbol.for("react.context"),
					s = Symbol.for("react.forward_ref"),
					c = Symbol.for("react.suspense"),
					f = Symbol.for("react.memo"),
					d = Symbol.for("react.lazy"),
					E = Symbol.iterator;
				var m = {
						isMounted: function() {
							return !1
						},
						enqueueForceUpdate: function() {},
						enqueueReplaceState: function() {},
						enqueueSetState: function() {}
					},
					p = Object.assign,
					S = {};

				function A(e, t, n) {
					this.props = e, this.context = t, this.refs = S, this.updater = n || m
				}

				function O() {}

				function R(e, t, n) {
					this.props = e, this.context = t, this.refs = S, this.updater = n || m
				}
				A.prototype.isReactComponent = {}, A.prototype.setState = function(e, t) {
					if ("object" !== typeof e && "function" !== typeof e && null != e) throw Error("setState(...): takes an object of state variables to update or a function which returns an object of state variables.");
					this.updater.enqueueSetState(this, e, t, "setState")
				}, A.prototype.forceUpdate = function(e) {
					this.updater.enqueueForceUpdate(this, e, "forceUpdate")
				}, O.prototype = A.prototype;
				var T = R.prototype = new O;
				T.constructor = R, p(T, A.prototype), T.isPureReactComponent = !0;
				var N = Array.isArray,
					I = Object.prototype.hasOwnProperty,
					v = {
						current: null
					},
					h = {
						key: !0,
						ref: !0,
						__self: !0,
						__source: !0
					};

				function g(e, t, r) {
					var l, a = {},
						o = null,
						i = null;
					if (null != t)
						for (l in void 0 !== t.ref && (i = t.ref), void 0 !== t.key && (o = "" + t.key), t) I.call(t, l) && !h.hasOwnProperty(l) && (a[l] = t[l]);
					var u = arguments.length - 2;
					if (1 === u) a.children = r;
					else if (1 < u) {
						for (var s = Array(u), c = 0; c < u; c++) s[c] = arguments[c + 2];
						a.children = s
					}
					if (e && e.defaultProps)
						for (l in u = e.defaultProps) void 0 === a[l] && (a[l] = u[l]);
					return {
						$$typeof: n,
						type: e,
						key: o,
						ref: i,
						props: a,
						_owner: v.current
					}
				}

				function b(e) {
					return "object" === typeof e && null !== e && e.$$typeof === n
				}
				var C = /\/+/g;

				function L(e, t) {
					return "object" === typeof e && null !== e && null != e.key ? function(e) {
						var t = {
							"=": "=0",
							":": "=2"
						};
						return "$" + e.replace(/[=:]/g, (function(e) {
							return t[e]
						}))
					}("" + e.key) : t.toString(36)
				}

				function y(e, t, l, a, o) {
					var i = typeof e;
					"undefined" !== i && "boolean" !== i || (e = null);
					var u = !1;
					if (null === e) u = !0;
					else switch (i) {
						case "string":
						case "number":
							u = !0;
							break;
						case "object":
							switch (e.$$typeof) {
								case n:
								case r:
									u = !0
							}
					}
					if (u) return o = o(u = e), e = "" === a ? "." + L(u, 0) : a, N(o) ? (l = "", null != e && (l = e.replace(C, "$&/") + "/"), y(o, t, l, "", (function(e) {
						return e
					}))) : null != o && (b(o) && (o = function(e, t) {
						return {
							$$typeof: n,
							type: e.type,
							key: t,
							ref: e.ref,
							props: e.props,
							_owner: e._owner
						}
					}(o, l + (!o.key || u && u.key === o.key ? "" : ("" + o.key).replace(C, "$&/") + "/") + e)), t.push(o)), 1;
					if (u = 0, a = "" === a ? "." : a + ":", N(e))
						for (var s = 0; s < e.length; s++) {
							var c = a + L(i = e[s], s);
							u += y(i, t, l, c, o)
						} else if (c = function(e) {
								return null === e || "object" !== typeof e ? null : "function" === typeof(e = E && e[E] || e["@@iterator"]) ? e : null
							}(e), "function" === typeof c)
							for (e = c.call(e), s = 0; !(i = e.next()).done;) u += y(i = i.value, t, l, c = a + L(i, s++), o);
						else if ("object" === i) throw t = String(e), Error("Objects are not valid as a React child (found: " + ("[object Object]" === t ? "object with keys {" + Object.keys(e).join(", ") + "}" : t) + "). If you meant to render a collection of children, use an array instead.");
					return u
				}

				function P(e, t, n) {
					if (null == e) return e;
					var r = [],
						l = 0;
					return y(e, r, "", "", (function(e) {
						return t.call(n, e, l++)
					})), r
				}

				function M(e) {
					if (-1 === e._status) {
						var t = e._result;
						(t = t()).then((function(t) {
							0 !== e._status && -1 !== e._status || (e._status = 1, e._result = t)
						}), (function(t) {
							0 !== e._status && -1 !== e._status || (e._status = 2, e._result = t)
						})), -1 === e._status && (e._status = 0, e._result = t)
					}
					if (1 === e._status) return e._result.default;
					throw e._result
				}
				var U = {
						current: null
					},
					D = {
						transition: null
					},
					H = {
						ReactCurrentDispatcher: U,
						ReactCurrentBatchConfig: D,
						ReactCurrentOwner: v
					};
				t.Children = {
					map: P,
					forEach: function(e, t, n) {
						P(e, (function() {
							t.apply(this, arguments)
						}), n)
					},
					count: function(e) {
						var t = 0;
						return P(e, (function() {
							t++
						})), t
					},
					toArray: function(e) {
						return P(e, (function(e) {
							return e
						})) || []
					},
					only: function(e) {
						if (!b(e)) throw Error("React.Children.only expected to receive a single React element child.");
						return e
					}
				}, t.Component = A, t.Fragment = l, t.Profiler = o, t.PureComponent = R, t.StrictMode = a, t.Suspense = c, t.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED = H, t.cloneElement = function(e, t, r) {
					if (null === e || void 0 === e) throw Error("React.cloneElement(...): The argument must be a React element, but you passed " + e + ".");
					var l = p({}, e.props),
						a = e.key,
						o = e.ref,
						i = e._owner;
					if (null != t) {
						if (void 0 !== t.ref && (o = t.ref, i = v.current), void 0 !== t.key && (a = "" + t.key), e.type && e.type.defaultProps) var u = e.type.defaultProps;
						for (s in t) I.call(t, s) && !h.hasOwnProperty(s) && (l[s] = void 0 === t[s] && void 0 !== u ? u[s] : t[s])
					}
					var s = arguments.length - 2;
					if (1 === s) l.children = r;
					else if (1 < s) {
						u = Array(s);
						for (var c = 0; c < s; c++) u[c] = arguments[c + 2];
						l.children = u
					}
					return {
						$$typeof: n,
						type: e.type,
						key: a,
						ref: o,
						props: l,
						_owner: i
					}
				}, t.createContext = function(e) {
					return (e = {
						$$typeof: u,
						_currentValue: e,
						_currentValue2: e,
						_threadCount: 0,
						Provider: null,
						Consumer: null,
						_defaultValue: null,
						_globalName: null
					}).Provider = {
						$$typeof: i,
						_context: e
					}, e.Consumer = e
				}, t.createElement = g, t.createFactory = function(e) {
					var t = g.bind(null, e);
					return t.type = e, t
				}, t.createRef = function() {
					return {
						current: null
					}
				}, t.forwardRef = function(e) {
					return {
						$$typeof: s,
						render: e
					}
				}, t.isValidElement = b, t.lazy = function(e) {
					return {
						$$typeof: d,
						_payload: {
							_status: -1,
							_result: e
						},
						_init: M
					}
				}, t.memo = function(e, t) {
					return {
						$$typeof: f,
						type: e,
						compare: void 0 === t ? null : t
					}
				}, t.startTransition = function(e) {
					var t = D.transition;
					D.transition = {};
					try {
						e()
					} finally {
						D.transition = t
					}
				}, t.unstable_act = function() {
					throw Error("act(...) is not supported in production builds of React.")
				}, t.useCallback = function(e, t) {
					return U.current.useCallback(e, t)
				}, t.useContext = function(e) {
					return U.current.useContext(e)
				}, t.useDebugValue = function() {}, t.useDeferredValue = function(e) {
					return U.current.useDeferredValue(e)
				}, t.useEffect = function(e, t) {
					return U.current.useEffect(e, t)
				}, t.useId = function() {
					return U.current.useId()
				}, t.useImperativeHandle = function(e, t, n) {
					return U.current.useImperativeHandle(e, t, n)
				}, t.useInsertionEffect = function(e, t) {
					return U.current.useInsertionEffect(e, t)
				}, t.useLayoutEffect = function(e, t) {
					return U.current.useLayoutEffect(e, t)
				}, t.useMemo = function(e, t) {
					return U.current.useMemo(e, t)
				}, t.useReducer = function(e, t, n) {
					return U.current.useReducer(e, t, n)
				}, t.useRef = function(e) {
					return U.current.useRef(e)
				}, t.useState = function(e) {
					return U.current.useState(e)
				}, t.useSyncExternalStore = function(e, t, n) {
					return U.current.useSyncExternalStore(e, t, n)
				}, t.useTransition = function() {
					return U.current.useTransition()
				}, t.version = "18.2.0"
			},
			791: function(e, t, n) {
				"use strict";
				e.exports = n(117)
			},
			184: function(e, t, n) {
				"use strict";
				e.exports = n(374)
			},
			813: function(e, t) {
				"use strict";

				function n(e, t) {
					var n = e.length;
					e.push(t);
					e: for (; 0 < n;) {
						var r = n - 1 >>> 1,
							l = e[r];
						if (!(0 < a(l, t))) break e;
						e[r] = t, e[n] = l, n = r
					}
				}

				function r(e) {
					return 0 === e.length ? null : e[0]
				}

				function l(e) {
					if (0 === e.length) return null;
					var t = e[0],
						n = e.pop();
					if (n !== t) {
						e[0] = n;
						e: for (var r = 0, l = e.length, o = l >>> 1; r < o;) {
							var i = 2 * (r + 1) - 1,
								u = e[i],
								s = i + 1,
								c = e[s];
							if (0 > a(u, n)) s < l && 0 > a(c, u) ? (e[r] = c, e[s] = n, r = s) : (e[r] = u, e[i] = n, r = i);
							else {
								if (!(s < l && 0 > a(c, n))) break e;
								e[r] = c, e[s] = n, r = s
							}
						}
					}
					return t
				}

				function a(e, t) {
					var n = e.sortIndex - t.sortIndex;
					return 0 !== n ? n : e.id - t.id
				}
				if ("object" === typeof performance && "function" === typeof performance.now) {
					var o = performance;
					t.unstable_now = function() {
						return o.now()
					}
				} else {
					var i = Date,
						u = i.now();
					t.unstable_now = function() {
						return i.now() - u
					}
				}
				var s = [],
					c = [],
					f = 1,
					d = null,
					E = 3,
					m = !1,
					p = !1,
					S = !1,
					A = "function" === typeof setTimeout ? setTimeout : null,
					O = "function" === typeof clearTimeout ? clearTimeout : null,
					R = "undefined" !== typeof setImmediate ? setImmediate : null;

				function T(e) {
					for (var t = r(c); null !== t;) {
						if (null === t.callback) l(c);
						else {
							if (!(t.startTime <= e)) break;
							l(c), t.sortIndex = t.expirationTime, n(s, t)
						}
						t = r(c)
					}
				}

				function N(e) {
					if (S = !1, T(e), !p)
						if (null !== r(s)) p = !0, D(I);
						else {
							var t = r(c);
							null !== t && H(N, t.startTime - e)
						}
				}

				function I(e, n) {
					p = !1, S && (S = !1, O(b), b = -1), m = !0;
					var a = E;
					try {
						for (T(n), d = r(s); null !== d && (!(d.expirationTime > n) || e && !y());) {
							var o = d.callback;
							if ("function" === typeof o) {
								d.callback = null, E = d.priorityLevel;
								var i = o(d.expirationTime <= n);
								n = t.unstable_now(), "function" === typeof i ? d.callback = i : d === r(s) && l(s), T(n)
							} else l(s);
							d = r(s)
						}
						if (null !== d) var u = !0;
						else {
							var f = r(c);
							null !== f && H(N, f.startTime - n), u = !1
						}
						return u
					} finally {
						d = null, E = a, m = !1
					}
				}
				"undefined" !== typeof navigator && void 0 !== navigator.scheduling && void 0 !== navigator.scheduling.isInputPending && navigator.scheduling.isInputPending.bind(navigator.scheduling);
				var v, h = !1,
					g = null,
					b = -1,
					C = 5,
					L = -1;

				function y() {
					return !(t.unstable_now() - L < C)
				}

				function P() {
					if (null !== g) {
						var e = t.unstable_now();
						L = e;
						var n = !0;
						try {
							n = g(!0, e)
						} finally {
							n ? v() : (h = !1, g = null)
						}
					} else h = !1
				}
				if ("function" === typeof R) v = function() {
					R(P)
				};
				else if ("undefined" !== typeof MessageChannel) {
					var M = new MessageChannel,
						U = M.port2;
					M.port1.onmessage = P, v = function() {
						U.postMessage(null)
					}
				} else v = function() {
					A(P, 0)
				};

				function D(e) {
					g = e, h || (h = !0, v())
				}

				function H(e, n) {
					b = A((function() {
						e(t.unstable_now())
					}), n)
				}
				t.unstable_IdlePriority = 5, t.unstable_ImmediatePriority = 1, t.unstable_LowPriority = 4, t.unstable_NormalPriority = 3, t.unstable_Profiling = null, t.unstable_UserBlockingPriority = 2, t.unstable_cancelCallback = function(e) {
					e.callback = null
				}, t.unstable_continueExecution = function() {
					p || m || (p = !0, D(I))
				}, t.unstable_forceFrameRate = function(e) {
					0 > e || 125 < e ? console.error("forceFrameRate takes a positive int between 0 and 125, forcing frame rates higher than 125 fps is not supported") : C = 0 < e ? Math.floor(1e3 / e) : 5
				}, t.unstable_getCurrentPriorityLevel = function() {
					return E
				}, t.unstable_getFirstCallbackNode = function() {
					return r(s)
				}, t.unstable_next = function(e) {
					switch (E) {
						case 1:
						case 2:
						case 3:
							var t = 3;
							break;
						default:
							t = E
					}
					var n = E;
					E = t;
					try {
						return e()
					} finally {
						E = n
					}
				}, t.unstable_pauseExecution = function() {}, t.unstable_requestPaint = function() {}, t.unstable_runWithPriority = function(e, t) {
					switch (e) {
						case 1:
						case 2:
						case 3:
						case 4:
						case 5:
							break;
						default:
							e = 3
					}
					var n = E;
					E = e;
					try {
						return t()
					} finally {
						E = n
					}
				}, t.unstable_scheduleCallback = function(e, l, a) {
					var o = t.unstable_now();
					switch ("object" === typeof a && null !== a ? a = "number" === typeof(a = a.delay) && 0 < a ? o + a : o : a = o, e) {
						case 1:
							var i = -1;
							break;
						case 2:
							i = 250;
							break;
						case 5:
							i = 1073741823;
							break;
						case 4:
							i = 1e4;
							break;
						default:
							i = 5e3
					}
					return e = {
						id: f++,
						callback: l,
						priorityLevel: e,
						startTime: a,
						expirationTime: i = a + i,
						sortIndex: -1
					}, a > o ? (e.sortIndex = a, n(c, e), null === r(s) && e === r(c) && (S ? (O(b), b = -1) : S = !0, H(N, a - o))) : (e.sortIndex = i, n(s, e), p || m || (p = !0, D(I))), e
				}, t.unstable_shouldYield = y, t.unstable_wrapCallback = function(e) {
					var t = E;
					return function() {
						var n = E;
						E = t;
						try {
							return e.apply(this, arguments)
						} finally {
							E = n
						}
					}
				}
			},
			296: function(e, t, n) {
				"use strict";
				e.exports = n(813)
			},
			699: function(e, t, n) {
				var r = n(501),
					l = n(112),
					a = n(132),
					o = n(890),
					i = n(113),
					u = n(350),
					s = n(411);
				s.alea = r, s.xor128 = l, s.xorwow = a, s.xorshift7 = o, s.xor4096 = i, s.tychei = u, e.exports = s
			},
			501: function(e, t, n) {
				var r;
				! function(e, l, a) {
					function o(e) {
						var t = this,
							n = function() {
								var e = 4022871197,
									t = function(t) {
										t = String(t);
										for (var n = 0; n < t.length; n++) {
											var r = .02519603282416938 * (e += t.charCodeAt(n));
											r -= e = r >>> 0, e = (r *= e) >>> 0, e += 4294967296 * (r -= e)
										}
										return 2.3283064365386963e-10 * (e >>> 0)
									};
								return t
							}();
						t.next = function() {
							var e = 2091639 * t.s0 + 2.3283064365386963e-10 * t.c;
							return t.s0 = t.s1, t.s1 = t.s2, t.s2 = e - (t.c = 0 | e)
						}, t.c = 1, t.s0 = n(" "), t.s1 = n(" "), t.s2 = n(" "), t.s0 -= n(e), t.s0 < 0 && (t.s0 += 1), t.s1 -= n(e), t.s1 < 0 && (t.s1 += 1), t.s2 -= n(e), t.s2 < 0 && (t.s2 += 1), n = null
					}

					function i(e, t) {
						return t.c = e.c, t.s0 = e.s0, t.s1 = e.s1, t.s2 = e.s2, t
					}

					function u(e, t) {
						var n = new o(e),
							r = t && t.state,
							l = n.next;
						return l.int32 = function() {
							return 4294967296 * n.next() | 0
						}, l.double = function() {
							return l() + 11102230246251565e-32 * (2097152 * l() | 0)
						}, l.quick = l, r && ("object" == typeof r && i(r, n), l.state = function() {
							return i(n, {})
						}), l
					}
					l && l.exports ? l.exports = u : n.amdD && n.amdO ? void 0 === (r = function() {
						return u
					}.call(t, n, t, l)) || (l.exports = r) : this.alea = u
				}(0, e = n.nmd(e), n.amdD)
			},
			350: function(e, t, n) {
				var r;
				! function(e, l, a) {
					function o(e) {
						var t = this,
							n = "";
						t.next = function() {
							var e = t.b,
								n = t.c,
								r = t.d,
								l = t.a;
							return e = e << 25 ^ e >>> 7 ^ n, n = n - r | 0, r = r << 24 ^ r >>> 8 ^ l, l = l - e | 0, t.b = e = e << 20 ^ e >>> 12 ^ n, t.c = n = n - r | 0, t.d = r << 16 ^ n >>> 16 ^ l, t.a = l - e | 0
						}, t.a = 0, t.b = 0, t.c = -1640531527, t.d = 1367130551, e === Math.floor(e) ? (t.a = e / 4294967296 | 0, t.b = 0 | e) : n += e;
						for (var r = 0; r < n.length + 20; r++) t.b ^= 0 | n.charCodeAt(r), t.next()
					}

					function i(e, t) {
						return t.a = e.a, t.b = e.b, t.c = e.c, t.d = e.d, t
					}

					function u(e, t) {
						var n = new o(e),
							r = t && t.state,
							l = function() {
								return (n.next() >>> 0) / 4294967296
							};
						return l.double = function() {
							do {
								var e = ((n.next() >>> 11) + (n.next() >>> 0) / 4294967296) / (1 << 21)
							} while (0 === e);
							return e
						}, l.int32 = n.next, l.quick = l, r && ("object" == typeof r && i(r, n), l.state = function() {
							return i(n, {})
						}), l
					}
					l && l.exports ? l.exports = u : n.amdD && n.amdO ? void 0 === (r = function() {
						return u
					}.call(t, n, t, l)) || (l.exports = r) : this.tychei = u
				}(0, e = n.nmd(e), n.amdD)
			},
			112: function(e, t, n) {
				var r;
				! function(e, l, a) {
					function o(e) {
						var t = this,
							n = "";
						t.x = 0, t.y = 0, t.z = 0, t.w = 0, t.next = function() {
							var e = t.x ^ t.x << 11;
							return t.x = t.y, t.y = t.z, t.z = t.w, t.w ^= t.w >>> 19 ^ e ^ e >>> 8
						}, e === (0 | e) ? t.x = e : n += e;
						for (var r = 0; r < n.length + 64; r++) t.x ^= 0 | n.charCodeAt(r), t.next()
					}

					function i(e, t) {
						return t.x = e.x, t.y = e.y, t.z = e.z, t.w = e.w, t
					}

					function u(e, t) {
						var n = new o(e),
							r = t && t.state,
							l = function() {
								return (n.next() >>> 0) / 4294967296
							};
						return l.double = function() {
							do {
								var e = ((n.next() >>> 11) + (n.next() >>> 0) / 4294967296) / (1 << 21)
							} while (0 === e);
							return e
						}, l.int32 = n.next, l.quick = l, r && ("object" == typeof r && i(r, n), l.state = function() {
							return i(n, {})
						}), l
					}
					l && l.exports ? l.exports = u : n.amdD && n.amdO ? void 0 === (r = function() {
						return u
					}.call(t, n, t, l)) || (l.exports = r) : this.xor128 = u
				}(0, e = n.nmd(e), n.amdD)
			},
			113: function(e, t, n) {
				var r;
				! function(e, l, a) {
					function o(e) {
						var t = this;
						t.next = function() {
								var e, n, r = t.w,
									l = t.X,
									a = t.i;
								return t.w = r = r + 1640531527 | 0, n = l[a + 34 & 127], e = l[a = a + 1 & 127], n ^= n << 13, e ^= e << 17, n ^= n >>> 15, e ^= e >>> 12, n = l[a] = n ^ e, t.i = a, n + (r ^ r >>> 16) | 0
							},
							function(e, t) {
								var n, r, l, a, o, i = [],
									u = 128;
								for (t === (0 | t) ? (r = t, t = null) : (t += "\0", r = 0, u = Math.max(u, t.length)), l = 0, a = -32; a < u; ++a) t && (r ^= t.charCodeAt((a + 32) % t.length)), 0 === a && (o = r), r ^= r << 10, r ^= r >>> 15, r ^= r << 4, r ^= r >>> 13, a >= 0 && (o = o + 1640531527 | 0, l = 0 == (n = i[127 & a] ^= r + o) ? l + 1 : 0);
								for (l >= 128 && (i[127 & (t && t.length || 0)] = -1), l = 127, a = 512; a > 0; --a) r = i[l + 34 & 127], n = i[l = l + 1 & 127], r ^= r << 13, n ^= n << 17, r ^= r >>> 15, n ^= n >>> 12, i[l] = r ^ n;
								e.w = o, e.X = i, e.i = l
							}(t, e)
					}

					function i(e, t) {
						return t.i = e.i, t.w = e.w, t.X = e.X.slice(), t
					}

					function u(e, t) {
						null == e && (e = +new Date);
						var n = new o(e),
							r = t && t.state,
							l = function() {
								return (n.next() >>> 0) / 4294967296
							};
						return l.double = function() {
							do {
								var e = ((n.next() >>> 11) + (n.next() >>> 0) / 4294967296) / (1 << 21)
							} while (0 === e);
							return e
						}, l.int32 = n.next, l.quick = l, r && (r.X && i(r, n), l.state = function() {
							return i(n, {})
						}), l
					}
					l && l.exports ? l.exports = u : n.amdD && n.amdO ? void 0 === (r = function() {
						return u
					}.call(t, n, t, l)) || (l.exports = r) : this.xor4096 = u
				}(0, e = n.nmd(e), n.amdD)
			},
			890: function(e, t, n) {
				var r;
				! function(e, l, a) {
					function o(e) {
						var t = this;
						t.next = function() {
								var e, n, r = t.x,
									l = t.i;
								return e = r[l], n = (e ^= e >>> 7) ^ e << 24, n ^= (e = r[l + 1 & 7]) ^ e >>> 10, n ^= (e = r[l + 3 & 7]) ^ e >>> 3, n ^= (e = r[l + 4 & 7]) ^ e << 7, e = r[l + 7 & 7], n ^= (e ^= e << 13) ^ e << 9, r[l] = n, t.i = l + 1 & 7, n
							},
							function(e, t) {
								var n, r = [];
								if (t === (0 | t)) r[0] = t;
								else
									for (t = "" + t, n = 0; n < t.length; ++n) r[7 & n] = r[7 & n] << 15 ^ t.charCodeAt(n) + r[n + 1 & 7] << 13;
								for (; r.length < 8;) r.push(0);
								for (n = 0; n < 8 && 0 === r[n]; ++n);
								for (8 == n ? r[7] = -1 : r[n], e.x = r, e.i = 0, n = 256; n > 0; --n) e.next()
							}(t, e)
					}

					function i(e, t) {
						return t.x = e.x.slice(), t.i = e.i, t
					}

					function u(e, t) {
						null == e && (e = +new Date);
						var n = new o(e),
							r = t && t.state,
							l = function() {
								return (n.next() >>> 0) / 4294967296
							};
						return l.double = function() {
							do {
								var e = ((n.next() >>> 11) + (n.next() >>> 0) / 4294967296) / (1 << 21)
							} while (0 === e);
							return e
						}, l.int32 = n.next, l.quick = l, r && (r.x && i(r, n), l.state = function() {
							return i(n, {})
						}), l
					}
					l && l.exports ? l.exports = u : n.amdD && n.amdO ? void 0 === (r = function() {
						return u
					}.call(t, n, t, l)) || (l.exports = r) : this.xorshift7 = u
				}(0, e = n.nmd(e), n.amdD)
			},
			132: function(e, t, n) {
				var r;
				! function(e, l, a) {
					function o(e) {
						var t = this,
							n = "";
						t.next = function() {
							var e = t.x ^ t.x >>> 2;
							return t.x = t.y, t.y = t.z, t.z = t.w, t.w = t.v, (t.d = t.d + 362437 | 0) + (t.v = t.v ^ t.v << 4 ^ e ^ e << 1) | 0
						}, t.x = 0, t.y = 0, t.z = 0, t.w = 0, t.v = 0, e === (0 | e) ? t.x = e : n += e;
						for (var r = 0; r < n.length + 64; r++) t.x ^= 0 | n.charCodeAt(r), r == n.length && (t.d = t.x << 10 ^ t.x >>> 4), t.next()
					}

					function i(e, t) {
						return t.x = e.x, t.y = e.y, t.z = e.z, t.w = e.w, t.v = e.v, t.d = e.d, t
					}

					function u(e, t) {
						var n = new o(e),
							r = t && t.state,
							l = function() {
								return (n.next() >>> 0) / 4294967296
							};
						return l.double = function() {
							do {
								var e = ((n.next() >>> 11) + (n.next() >>> 0) / 4294967296) / (1 << 21)
							} while (0 === e);
							return e
						}, l.int32 = n.next, l.quick = l, r && ("object" == typeof r && i(r, n), l.state = function() {
							return i(n, {})
						}), l
					}
					l && l.exports ? l.exports = u : n.amdD && n.amdO ? void 0 === (r = function() {
						return u
					}.call(t, n, t, l)) || (l.exports = r) : this.xorwow = u
				}(0, e = n.nmd(e), n.amdD)
			},
			411: function(e, t, n) {
				var r;
				! function(l, a, o) {
					var i, u = 256,
						s = o.pow(u, 6),
						c = o.pow(2, 52),
						f = 2 * c,
						d = u - 1;

					function E(e, t, n) {
						var r = [],
							d = A(S((t = 1 == t ? {
								entropy: !0
							} : t || {}).entropy ? [e, O(a)] : null == e ? function() {
								try {
									var e;
									return i && (e = i.randomBytes) ? e = e(u) : (e = new Uint8Array(u), (l.crypto || l.msCrypto).getRandomValues(e)), O(e)
								} catch (r) {
									var t = l.navigator,
										n = t && t.plugins;
									return [+new Date, l, n, l.screen, O(a)]
								}
							}() : e, 3), r),
							E = new m(r),
							R = function() {
								for (var e = E.g(6), t = s, n = 0; e < c;) e = (e + n) * u, t *= u, n = E.g(1);
								for (; e >= f;) e /= 2, t /= 2, n >>>= 1;
								return (e + n) / t
							};
						return R.int32 = function() {
							return 0 | E.g(4)
						}, R.quick = function() {
							return E.g(4) / 4294967296
						}, R.double = R, A(O(E.S), a), (t.pass || n || function(e, t, n, r) {
							return r && (r.S && p(r, E), e.state = function() {
								return p(E, {})
							}), n ? (o.random = e, t) : e
						})(R, d, "global" in t ? t.global : this == o, t.state)
					}

					function m(e) {
						var t, n = e.length,
							r = this,
							l = 0,
							a = r.i = r.j = 0,
							o = r.S = [];
						for (n || (e = [n++]); l < u;) o[l] = l++;
						for (l = 0; l < u; l++) o[l] = o[a = d & a + e[l % n] + (t = o[l])], o[a] = t;
						(r.g = function(e) {
							for (var t, n = 0, l = r.i, a = r.j, o = r.S; e--;) t = o[l = d & l + 1], n = n * u + o[d & (o[l] = o[a = d & a + t]) + (o[a] = t)];
							return r.i = l, r.j = a, n
						})(u)
					}

					function p(e, t) {
						return t.i = e.i, t.j = e.j, t.S = e.S.slice(), t
					}

					function S(e, t) {
						var n, r = [],
							l = typeof e;
						if (t && "object" == l)
							for (n in e) try {
								r.push(S(e[n], t - 1))
							} catch (a) {}
						return r.length ? r : "string" == l ? e : e + "\0"
					}

					function A(e, t) {
						for (var n, r = e + "", l = 0; l < r.length;) t[d & l] = d & (n ^= 19 * t[d & l]) + r.charCodeAt(l++);
						return O(t)
					}

					function O(e) {
						return String.fromCharCode.apply(0, e)
					}
					if (A(o.random(), a), e.exports) {
						e.exports = E;
						try {
							i = n(42)
						} catch (R) {}
					} else void 0 === (r = function() {
						return E
					}.call(t, n, t, e)) || (e.exports = r)
				}("undefined" !== typeof self ? self : this, [], Math)
			},
			42: function() {}
		},
		t = {};

	function n(r) {
		var l = t[r];
		if (void 0 !== l) return l.exports;
		var a = t[r] = {
			id: r,
			loaded: !1,
			exports: {}
		};
		return e[r].call(a.exports, a, a.exports, n), a.loaded = !0, a.exports
	}
	n.m = e, n.amdD = function() {
			throw new Error("define cannot be used indirect")
		}, n.amdO = {}, n.n = function(e) {
			var t = e && e.__esModule ? function() {
				return e.default
			} : function() {
				return e
			};
			return n.d(t, {
				a: t
			}), t
		}, n.d = function(e, t) {
			for (var r in t) n.o(t, r) && !n.o(e, r) && Object.defineProperty(e, r, {
				enumerable: !0,
				get: t[r]
			})
		}, n.f = {}, n.e = function(e) {
			return Promise.all(Object.keys(n.f).reduce((function(t, r) {
				return n.f[r](e, t), t
			}), []))
		}, n.u = function(e) {
			return "static/js/" + e + ".bc16e069.chunk.js"
		}, n.miniCssF = function(e) {}, n.g = function() {
			if ("object" === typeof globalThis) return globalThis;
			try {
				return this || new Function("return this")()
			} catch (e) {
				if ("object" === typeof window) return window
			}
		}(), n.o = function(e, t) {
			return Object.prototype.hasOwnProperty.call(e, t)
		},
		function() {
			var e = {},
				t = "connections-unlimited:";
			n.l = function(r, l, a, o) {
				if (e[r]) e[r].push(l);
				else {
					var i, u;
					if (void 0 !== a)
						for (var s = document.getElementsByTagName("script"), c = 0; c < s.length; c++) {
							var f = s[c];
							if (f.getAttribute("src") == r || f.getAttribute("data-webpack") == t + a) {
								i = f;
								break
							}
						}
					i || (u = !0, (i = document.createElement("script")).charset = "utf-8", i.timeout = 120, n.nc && i.setAttribute("nonce", n.nc), i.setAttribute("data-webpack", t + a), i.src = r), e[r] = [l];
					var d = function(t, n) {
							i.onerror = i.onload = null, clearTimeout(E);
							var l = e[r];
							if (delete e[r], i.parentNode && i.parentNode.removeChild(i), l && l.forEach((function(e) {
									return e(n)
								})), t) return t(n)
						},
						E = setTimeout(d.bind(null, void 0, {
							type: "timeout",
							target: i
						}), 12e4);
					i.onerror = d.bind(null, i.onerror), i.onload = d.bind(null, i.onload), u && document.head.appendChild(i)
				}
			}
		}(), n.r = function(e) {
			"undefined" !== typeof Symbol && Symbol.toStringTag && Object.defineProperty(e, Symbol.toStringTag, {
				value: "Module"
			}), Object.defineProperty(e, "__esModule", {
				value: !0
			})
		}, n.nmd = function(e) {
			return e.paths = [], e.children || (e.children = []), e
		}, n.p = "/",
		function() {
			var e = {
				179: 0
			};
			n.f.j = function(t, r) {
				var l = n.o(e, t) ? e[t] : void 0;
				if (0 !== l)
					if (l) r.push(l[2]);
					else {
						var a = new Promise((function(n, r) {
							l = e[t] = [n, r]
						}));
						r.push(l[2] = a);
						var o = n.p + n.u(t),
							i = new Error;
						n.l(o, (function(r) {
							if (n.o(e, t) && (0 !== (l = e[t]) && (e[t] = void 0), l)) {
								var a = r && ("load" === r.type ? "missing" : r.type),
									o = r && r.target && r.target.src;
								i.message = "Loading chunk " + t + " failed.\n(" + a + ": " + o + ")", i.name = "ChunkLoadError", i.type = a, i.request = o, l[1](i)
							}
						}), "chunk-" + t, t)
					}
			};
			var t = function(t, r) {
					var l, a, o = r[0],
						i = r[1],
						u = r[2],
						s = 0;
					if (o.some((function(t) {
							return 0 !== e[t]
						}))) {
						for (l in i) n.o(i, l) && (n.m[l] = i[l]);
						if (u) u(n)
					}
					for (t && t(r); s < o.length; s++) a = o[s], n.o(e, a) && e[a] && e[a][0](), e[a] = 0
				},
				r = self.webpackChunkconnections_unlimited = self.webpackChunkconnections_unlimited || [];
			r.forEach(t.bind(null, 0)), r.push = t.bind(null, r.push.bind(r))
		}(),
		function() {
			"use strict";
			var e = n(791),
				t = n(250);

			function r(e) {
				return r = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(e) {
					return typeof e
				} : function(e) {
					return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
				}, r(e)
			}

			function l(e) {
				var t = function(e, t) {
					if ("object" !== r(e) || null === e) return e;
					var n = e[Symbol.toPrimitive];
					if (void 0 !== n) {
						var l = n.call(e, t || "default");
						if ("object" !== r(l)) return l;
						throw new TypeError("@@toPrimitive must return a primitive value.")
					}
					return ("string" === t ? String : Number)(e)
				}(e, "string");
				return "symbol" === r(t) ? t : String(t)
			}

			function a(e, t, n) {
				return (t = l(t)) in e ? Object.defineProperty(e, t, {
					value: n,
					enumerable: !0,
					configurable: !0,
					writable: !0
				}) : e[t] = n, e
			}

			function o(e, t) {
				var n = Object.keys(e);
				if (Object.getOwnPropertySymbols) {
					var r = Object.getOwnPropertySymbols(e);
					t && (r = r.filter((function(t) {
						return Object.getOwnPropertyDescriptor(e, t).enumerable
					}))), n.push.apply(n, r)
				}
				return n
			}

			function i(e) {
				for (var t = 1; t < arguments.length; t++) {
					var n = null != arguments[t] ? arguments[t] : {};
					t % 2 ? o(Object(n), !0).forEach((function(t) {
						a(e, t, n[t])
					})) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(n)) : o(Object(n)).forEach((function(t) {
						Object.defineProperty(e, t, Object.getOwnPropertyDescriptor(n, t))
					}))
				}
				return e
			}

			function u(e, t) {
				(null == t || t > e.length) && (t = e.length);
				for (var n = 0, r = new Array(t); n < t; n++) r[n] = e[n];
				return r
			}

			function s(e, t) {
				if (e) {
					if ("string" === typeof e) return u(e, t);
					var n = Object.prototype.toString.call(e).slice(8, -1);
					return "Object" === n && e.constructor && (n = e.constructor.name), "Map" === n || "Set" === n ? Array.from(e) : "Arguments" === n || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n) ? u(e, t) : void 0
				}
			}

			function c(e) {
				return function(e) {
					if (Array.isArray(e)) return u(e)
				}(e) || function(e) {
					if ("undefined" !== typeof Symbol && null != e[Symbol.iterator] || null != e["@@iterator"]) return Array.from(e)
				}(e) || s(e) || function() {
					throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")
				}()
			}

			function f(e, t) {
				return function(e) {
					if (Array.isArray(e)) return e
				}(e) || function(e, t) {
					var n = null == e ? null : "undefined" != typeof Symbol && e[Symbol.iterator] || e["@@iterator"];
					if (null != n) {
						var r, l, a, o, i = [],
							u = !0,
							s = !1;
						try {
							if (a = (n = n.call(e)).next, 0 === t) {
								if (Object(n) !== n) return;
								u = !1
							} else
								for (; !(u = (r = a.call(n)).done) && (i.push(r.value), i.length !== t); u = !0);
						} catch (c) {
							s = !0, l = c
						} finally {
							try {
								if (!u && null != n.return && (o = n.return(), Object(o) !== o)) return
							} finally {
								if (s) throw l
							}
						}
						return i
					}
				}(e, t) || s(e, t) || function() {
					throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")
				}()
			}
			var d = JSON.parse('[{"groups":{"WET WEATHER":{"level":0,"members":["HAIL","RAIN","SLEET","SNOW"]},"NBA TEAMS":{"level":1,"members":["BUCKS","HEAT","JAZZ","NETS"]},"KEYBOARD KEYS":{"level":2,"members":["OPTION","RETURN","SHIFT","TAB"]},"PALINDROMES":{"level":3,"members":["KAYAK","LEVEL","MOM","RACE CAR"]}},"startingGroups":[["SNOW","LEVEL","SHIFT","KAYAK"],["HEAT","TAB","BUCKS","RETURN"],["JAZZ","HAIL","OPTION","RAIN"],["SLEET","RACE CAR","MOM","NETS"]]},{"groups":{"FOOTWEAR":{"level":0,"members":["BOOT","LOAFER","PUMP","SNEAKER"]},"UNITS OF LENGTH":{"level":1,"members":["FOOT","LEAGUE","MILE","YARD"]},"MAGAZINES":{"level":2,"members":["ESSENCE","PEOPLE","TIME","US"]},"LETTER HOMOPHONES":{"level":3,"members":["ARE","QUEUE","SEA","WHY"]}},"startingGroups":[["PUMP","FOOT","TIME","SEA"],["LEAGUE","LOAFER","WHY","US"],["BOOT","YARD","PEOPLE","ARE"],["MILE","SNEAKER","QUEUE","ESSENCE"]]},{"groups":{"FACIAL FEATURES":{"level":0,"members":["CHEEK","EYE","MOUTH","NOSE"]},"SYNONYMS FOR EAT":{"level":1,"members":["CHOW","GOBBLE","SCARF","WOLF"]},"DOG BREEDS, INFORMALLY":{"level":2,"members":["LAB","PEKE","PIT","POM"]},"MEMBERS OF A TRIO":{"level":3,"members":["AMIGO","KING","STOOGE","TENOR"]}},"startingGroups":[["AMIGO","MOUTH","LAB","STOOGE"],["WOLF","KING","NOSE","CHOW"],["TENOR","POM","SCARF","EYE"],["PIT","GOBBLE","PEKE","CHEEK"]]},{"groups":{"SNEAKER BRANDS":{"level":0,"members":["ADIDAS","NIKE","PUMA","REEBOK"]},"MUSICALS BEGINNING WITH \\"C\\"":{"level":1,"members":["CABARET","CAROUSEL","CATS","CHICAGO"]},"CLEANING VERBS":{"level":2,"members":["DUST","MOP","SWEEP","VACUUM"]},"___ MAN SUPERHEROES":{"level":3,"members":["BAT","IRON","SPIDER","SUPER"]}},"startingGroups":[["DUST","CATS","SPIDER","CAROUSEL"],["PUMA","IRON","NIKE","MOP"],["CHICAGO","SWEEP","SUPER","BAT"],["REEBOK","CABARET","VACUUM","ADIDAS"]]},{"groups":{"STREAMING SERVICES":{"level":0,"members":["HULU","NETFLIX","PEACOCK","PRIME"]},"CONDIMENTS":{"level":1,"members":["KETCHUP","MAYO","RELISH","TARTAR"]},"SYNONYMS FOR SAD":{"level":2,"members":["BLUE","DOWN","GLUM","LOW"]},"CLUE CHARACTERS":{"level":3,"members":["GREEN","MUSTARD","PLUM","SCARLET"]}},"startingGroups":[["MUSTARD","TARTAR","PLUM","BLUE"],["GREEN","PRIME","GLUM","RELISH"],["DOWN","PEACOCK","KETCHUP","LOW"],["HULU","SCARLET","MAYO","NETFLIX"]]},{"groups":{"MONOPOLY SQUARES":{"level":0,"members":["BOARDWALK","CHANCE","GO","JAIL"]},"SHADES OF BLUE":{"level":1,"members":["BABY","MIDNIGHT","POWDER","ROYAL"]},"RAPPERS":{"level":2,"members":["COMMON","FUTURE","ICE CUBE","Q-TIP"]},"MEMBERS OF A SEPTET":{"level":3,"members":["SEA","SIN","SISTER","WONDER"]}},"startingGroups":[["WONDER","FUTURE","BABY","GO"],["SIN","CHANCE","ROYAL","ICE CUBE"],["MIDNIGHT","JAIL","SEA","POWDER"],["Q-TIP","SISTER","BOARDWALK","COMMON"]]},{"groups":{"LEG PARTS":{"level":0,"members":["ANKLE","KNEE","SHIN","THIGH"]},"BABY ANIMALS":{"level":1,"members":["CALF","CUB","JOEY","KID"]},"SLANG FOR TOILET":{"level":2,"members":["CAN","HEAD","JOHN","THRONE"]},"___ FISH THAT AREN\'T FISH":{"level":3,"members":["CRAY","JELLY","SILVER","STAR"]}},"startingGroups":[["JOHN","CUB","STAR","SILVER"],["KNEE","THRONE","JOEY","JELLY"],["CALF","ANKLE","CRAY","HEAD"],["SHIN","CAN","KID","THIGH"]]},{"groups":{"BOARD GAMES":{"level":0,"members":["BACKGAMMON","CHECKERS","CHESS","GO"]},"MATTRESS SIZES":{"level":1,"members":["FULL","KING","QUEEN","TWIN"]},"THINGS THAT ARE RED":{"level":2,"members":["CHERRY","FIRE TRUCK","RUBY","STOP SIGN"]},"THINGS WITH KEYS":{"level":3,"members":["CRYPTOGRAPHY","FLORIDA","LOCKSMITH","PIANO"]}},"startingGroups":[["LOCKSMITH","FIRE TRUCK","KING","PIANO"],["CHESS","RUBY","FLORIDA","TWIN"],["CHERRY","QUEEN","STOP SIGN","GO"],["CHECKERS","CRYPTOGRAPHY","FULL","BACKGAMMON"]]},{"groups":{"SPORTS":{"level":0,"members":["CRICKET","FENCING","POLO","SQUASH"]},"TOPS":{"level":1,"members":["CAMI","HALTER","TANK","TEE"]},"VEGETABLES":{"level":2,"members":["BEET","CARROT","CORN","ONION"]},"INSECTS":{"level":3,"members":["ANT","BEETLE","MANTIS","TERMITE"]}},"startingGroups":[["SQUASH","TEE","CARROT","ANT"],["TANK","CORN","CRICKET","MANTIS"],["POLO","ONION","BEETLE","BEET"],["CAMI","TERMITE","HALTER","FENCING"]]},{"groups":{"FRUIT":{"level":0,"members":["DATE","KIWI","LEMON","ORANGE"]},"COUNTRIES":{"level":1,"members":["CHAD","GEORGIA","JORDAN","TOGO"]},"BIRDS":{"level":2,"members":["CRANE","JAY","SWALLOW","TURKEY"]},"ZODIAC SYMBOLS":{"level":3,"members":["FISH","GOAT","SCALES","TWINS"]}},"startingGroups":[["TWINS","TURKEY","GOAT","KIWI"],["SCALES","FISH","JORDAN","JAY"],["ORANGE","GEORGIA","DATE","CRANE"],["TOGO","SWALLOW","LEMON","CHAD"]]},{"groups":{"SPICES BEGINNING WITH \\"C\\"":{"level":0,"members":["CARDAMOM","CLOVE","CORIANDER","CUMIN"]},"TERMS OF ENDEARMENT":{"level":1,"members":["BOO","HONEY","SUGAR","SWEETIE"]},"THINGS WITH WINGS":{"level":2,"members":["AIRPLANE","ANGEL","BIRD","PEGASUS"]},"SPICE GIRLS":{"level":3,"members":["BABY","GINGER","POSH","SCARY"]}},"startingGroups":[["SUGAR","ANGEL","GINGER","BIRD"],["BABY","CUMIN","BOO","SCARY"],["SWEETIE","CORIANDER","AIRPLANE","CLOVE"],["PEGASUS","HONEY","CARDAMOM","POSH"]]},{"groups":{"ANIMAL GROUP NAMES":{"level":0,"members":["FLOCK","PACK","POD","SCHOOL"]},"DEADLY SINS":{"level":1,"members":["ENVY","GREED","LUST","PRIDE"]},"SLOW ANIMALS":{"level":2,"members":["LORIS","SLOTH","SNAIL","TORTOISE"]},"TRIG FUNCTIONS":{"level":3,"members":["COT","SEC","SIN","TAN"]}},"startingGroups":[["LUST","PRIDE","TAN","SCHOOL"],["SLOTH","SEC","PACK","COT"],["SNAIL","GREED","SIN","FLOCK"],["POD","LORIS","ENVY","TORTOISE"]]},{"groups":{"AIRLINES":{"level":0,"members":["FRONTIER","SPIRIT","UNITED","VIRGIN"]},"GREEK LETTERS":{"level":1,"members":["BETA","CHI","DELTA","IOTA"]},"SILENT \\"G\\"":{"level":2,"members":["GNAT","GNAW","GNOCCHI","GNOME"]},"HOMOPHONES":{"level":3,"members":["GNU","KNEW","NEW","NU"]}},"startingGroups":[["KNEW","GNOME","IOTA","FRONTIER"],["DELTA","CHI","GNOCCHI","NEW"],["SPIRIT","BETA","VIRGIN","GNAW"],["NU","GNAT","UNITED","GNU"]]},{"groups":{"BEDS":{"level":0,"members":["BUNK","CANOPY","MURPHY","TRUNDLE"]},"FAMOUS BROTHERS":{"level":1,"members":["JONAS","MARX","WARNER","WRIGHT"]},"HONDAS":{"level":2,"members":["ACCORD","CIVIC","PASSPORT","PILOT"]},"VIDEO GAME CHARACTERS":{"level":3,"members":["CRASH","LINK","MARIO","SONIC"]}},"startingGroups":[["CANOPY","LINK","PASSPORT","MARX"],["PILOT","SONIC","WRIGHT","ACCORD"],["MURPHY","CRASH","CIVIC","BUNK"],["MARIO","JONAS","TRUNDLE","WARNER"]]},{"groups":{"BIRD SOUNDS":{"level":0,"members":["CAW","CHIRP","CLUCK","TWEET"]},"COLORS":{"level":1,"members":["BROWN","PINK","TURQUOISE","VIOLET"]},"FISHING GEAR":{"level":2,"members":["LURE","REEL","ROD","TACKLE"]},"FICTIONAL PIRATES":{"level":3,"members":["HOOK","JONES","SILVER","SPARROW"]}},"startingGroups":[["SILVER","TWEET","ROD","SPARROW"],["BROWN","TACKLE","HOOK","PINK"],["CAW","JONES","VIOLET","REEL"],["TURQUOISE","CHIRP","LURE","CLUCK"]]},{"groups":{"COFFEE DRINKS":{"level":0,"members":["AMERICANO","CAPPUCCINO","ESPRESSO","LATTE"]},"TREE NUTS":{"level":1,"members":["ALMOND","CASHEW","PECAN","WALNUT"]},"SHADES OF GREEN":{"level":2,"members":["EMERALD","FOREST","KELLY","OLIVE"]},"MR. ___":{"level":3,"members":["BEAN","CLEAN","FOX","PEANUT"]}},"startingGroups":[["BEAN","ESPRESSO","ALMOND","FOREST"],["PECAN","CLEAN","KELLY","LATTE"],["PEANUT","EMERALD","AMERICANO","FOX"],["OLIVE","WALNUT","CAPPUCCINO","CASHEW"]]},{"groups":{"NECKWEAR":{"level":0,"members":["ASCOT","BOLO","SCARF","TIE"]},"SHIP DIRECTIONS":{"level":1,"members":["BOW","PORT","STARBOARD","STERN"]},"DETERGENTS":{"level":2,"members":["ALL","ERA","GAIN","TIDE"]},"___ TRIANGLE":{"level":3,"members":["ACUTE","BERMUDA","LOVE","RIGHT"]}},"startingGroups":[["TIDE","BERMUDA","STERN","SCARF"],["LOVE","ASCOT","GAIN","BOW"],["RIGHT","ERA","PORT","BOLO"],["ACUTE","TIE","ALL","STARBOARD"]]},{"groups":{"MUSCLES, INFORMALLY":{"level":0,"members":["LAT","PEC","QUAD","TRI"]},"AWARDS":{"level":1,"members":["CUP","MEDAL","RIBBON","TROPHY"]},"TITLE TV DOCTORS":{"level":2,"members":["GREY","HOUSE","HOWSER","QUINN"]},"NFL PLAYERS":{"level":3,"members":["BEAR","BILL","BROWN","COMMANDER"]}},"startingGroups":[["GREY","CUP","BILL","RIBBON"],["QUAD","BEAR","HOUSE","LAT"],["QUINN","TRI","MEDAL","COMMANDER"],["BROWN","TROPHY","PEC","HOWSER"]]},{"groups":{"OFF-WHITE SHADES":{"level":0,"members":["CREAM","EGGSHELL","IVORY","VANILLA"]},"ANTI-VAMPIRE":{"level":1,"members":["CRUCIFIX","GARLIC","MIRROR","STAKE"]},"KINDS OF MEAT":{"level":2,"members":["BEEF","PORK","POULTRY","VENISON"]},"SYNONYMS FOR ARGUMENT":{"level":3,"members":["ROW","QUARREL","SPAT","TIFF"]}},"startingGroups":[["CREAM","GARLIC","PORK","ROW"],["MIRROR","BEEF","SPAT","EGGSHELL"],["POULTRY","STAKE","TIFF","VANILLA"],["IVORY","QUARREL","VENISON","CRUCIFIX"]]},{"groups":{"GRAINS":{"level":0,"members":["BARLEY","OAT","RYE","SPELT"]},"ROYAL TITLES":{"level":1,"members":["BARON","EARL","KING","PRINCE"]},"UNIVERSITIES":{"level":2,"members":["BROWN","DUKE","HOWARD","RICE"]},"BEST DIRECTOR OSCAR WINNERS":{"level":3,"members":["BONG","FORD","LEE","STONE"]}},"startingGroups":[["KING","OAT","STONE","RICE"],["BARLEY","BONG","DUKE","FORD"],["BROWN","SPELT","LEE","EARL"],["HOWARD","BARON","RYE","PRINCE"]]},{"groups":{"MUSIC GENRES":{"level":0,"members":["JAZZ","POP","PUNK","RAP"]},"WEB BROWSERS":{"level":1,"members":["CHROME","EDGE","OPERA","SAFARI"]},"\\"LITTLE WOMEN\\" SISTERS":{"level":2,"members":["AMY","BETH","JO","MEG"]},"LIL ___ RAPPERS":{"level":3,"members":["BABY","JON","KIM","WAYNE"]}},"startingGroups":[["OPERA","BABY","WAYNE","JO"],["POP","MEG","SAFARI","KIM"],["RAP","CHROME","BETH","JAZZ"],["PUNK","JON","AMY","EDGE"]]},{"groups":{"DOG BREEDS":{"level":0,"members":["BOXER","DALMATIAN","HUSKY","POODLE"]},"ANIMAL NOSES":{"level":1,"members":["BEAK","MUZZLE","SNOUT","TRUNK"]},"TRAFFIC SIGNS":{"level":2,"members":["DETOUR","SLOW","STOP","YIELD"]},"SOUND ___":{"level":3,"members":["ASLEEP","BARRIER","BITE","WAVE"]}},"startingGroups":[["BITE","STOP","TRUNK","BOXER"],["WAVE","YIELD","MUZZLE","BARRIER"],["DETOUR","HUSKY","SNOUT","ASLEEP"],["DALMATIAN","BEAK","SLOW","POODLE"]]},{"groups":{"60\'s BAND MEMBERS":{"level":0,"members":["BEACH BOY","BEATLE","BYRD","MONKEE"]},"DANCE FADS":{"level":1,"members":["DOUGIE","MACARENA","MASHED POTATO","TWIST"]},"MAGAZINES":{"level":2,"members":["FORTUNE","ROLLING STONE","VOGUE","WIRED"]},"THINGS WITH LINKS":{"level":3,"members":["CHAIN","GOLF COURSE","SAUSAGE","WEBSITE"]}},"startingGroups":[["BEACH BOY","TWIST","CHAIN","ROLLING STONE"],["MASHED POTATO","WIRED","WEBSITE","BEATLE"],["SAUSAGE","BYRD","DOUGIE","FORTUNE"],["MACARENA","VOGUE","GOLF COURSE","MONKEE"]]},{"groups":{"CANDY BARS":{"level":0,"members":["BOUNTY","CRUNCH","HEATH","MILKY WAY"]},"VIDEO GAME CONSOLES":{"level":1,"members":["DREAMCAST","GENESIS","SWITCH","WII"]},"EAR PARTS":{"level":2,"members":["ANVIL","COCHLEA","HAMMER","STIRRUP"]},"BAND NAMES MINUS NUMBERS":{"level":3,"members":["BLINK","MAROON","SUM","U"]}},"startingGroups":[["MILKY WAY","GENESIS","HAMMER","SUM"],["SWITCH","MAROON","BOUNTY","U"],["ANVIL","CRUNCH","BLINK","STIRRUP"],["HEATH","WII","COCHLEA","DREAMCAST"]]},{"groups":{"DESSERTS":{"level":0,"members":["CHEESECAKE","FLAN","MOUSSE","TIRAMISU"]},"MILD OATHS":{"level":1,"members":["DARN","FUDGE","HECK","SHOOT"]},"ANIMALS WITH TUSKS":{"level":2,"members":["ELEPHANT","HIPPO","NARWHAL","WARTHOG"]},"MUSTACHES":{"level":3,"members":["HANDLEBAR","HORSESHOE","PENCIL","WALRUS"]}},"startingGroups":[["MOUSSE","WALRUS","FUDGE","HORSESHOE"],["SHOOT","PENCIL","ELEPHANT","FLAN"],["NARWHAL","HIPPO","HECK","HANDLEBAR"],["TIRAMISU","DARN","WARTHOG","CHEESECAKE"]]},{"groups":{"EUROPEAN COUNTRIES":{"level":0,"members":["DENMARK","GREECE","POLAND","PORTUGAL"]},"SYNONYMS FOR IMITATE":{"level":1,"members":["COPY","ECHO","MIMIC","PARROT"]},"TOMS":{"level":2,"members":["CRUISE","HOLLAND","PETTY","WAITS"]},"WORDS SPELLED WITH ROMAN NUMERALS":{"level":3,"members":["DILL","LIVID","MILD","MIX"]}},"startingGroups":[["PETTY","PARROT","POLAND","CRUISE"],["MIX","MIMIC","HOLLAND","GREECE"],["ECHO","MILD","LIVID","COPY"],["PORTUGAL","WAITS","DENMARK","DILL"]]},{"groups":{"HATS":{"level":0,"members":["BERET","BOWLER","FEDORA","FEZ"]},"ORGANS":{"level":1,"members":["HEART","KIDNEY","LIVER","LUNG"]},"PARTS OF A BOOK":{"level":2,"members":["COVER","JACKET","PAGE","SPINE"]},"JACK ___":{"level":3,"members":["ASS","KNIFE","POT","RABBIT"]}},"startingGroups":[["HEART","BERET","SPINE","POT"],["ASS","KIDNEY","FEZ","JACKET"],["BOWLER","RABBIT","LIVER","COVER"],["LUNG","PAGE","FEDORA","KNIFE"]]},{"groups":{"SEVEN DWARFS":{"level":0,"members":["BASHFUL","DOC","GRUMPY","HAPPY"]},"FILE EXTENSIONS":{"level":1,"members":["GIF","PDF","TIFF","ZIP"]},"FLIGHTLESS BIRDS":{"level":2,"members":["EMU","KIWI","OSTRICH","PENGUIN"]},"TROPICAL FRUITS":{"level":3,"members":["BANANA","COCONUT","MANGO","PINEAPPLE"]}},"startingGroups":[["COCONUT","ZIP","PENGUIN","DOC"],["KIWI","HAPPY","TIFF","BANANA"],["EMU","GRUMPY","MANGO","GIF"],["PDF","OSTRICH","BASHFUL","PINEAPPLE"]]},{"groups":{"WINGED INSECTS":{"level":0,"members":["FLY","GNAT","MOTH","WASP"]},"ARITHMETIC OPERATIONS":{"level":1,"members":["ADD","DIVIDE","MULTIPLY","SUBTRACT"]},"FISH":{"level":2,"members":["TANG","TETRA","SKATE","SOLE"]},"___ CAT":{"level":3,"members":["ALLEY","COOL","COPY","LAP"]}},"startingGroups":[["SKATE","ADD","COPY","FLY"],["ALLEY","TANG","MOTH","COOL"],["DIVIDE","SOLE","LAP","SUBTRACT"],["TETRA","GNAT","MULTIPLY","WASP"]]},{"groups":{"NFL PLAYERS":{"level":0,"members":["BRONCO","COWBOY","PACKER","RAVEN"]},"PASTA SHAPES":{"level":1,"members":["BOWTIE","ELBOW","SHELL","SPIRAL"]},"JOINTS":{"level":2,"members":["HIP","KNEE","SHOULDER","WRIST"]},"MOVIES WITH \\"!\\"":{"level":3,"members":["AIRPLANE","MOTHER","OKLAHOMA","THEM"]}},"startingGroups":[["SPIRAL","HIP","MOTHER","RAVEN"],["ELBOW","AIRPLANE","KNEE","SHELL"],["COWBOY","SHOULDER","OKLAHOMA","BOWTIE"],["THEM","PACKER","WRIST","BRONCO"]]},{"groups":{"VEGETABLES THAT ARE ALSO FRUITS":{"level":0,"members":["CUCUMBER","EGGPLANT","PEPPER","TOMATO"]},"3-D SHAPES":{"level":1,"members":["CONE","CUBE","PYRAMID","SPHERE"]},"WORDS WITH \\"i\\"":{"level":2,"members":["MAC","PAD","PHONE","POD"]},"WORDS WITH TWO PRONUNCIATIONS":{"level":3,"members":["JOB","LIMA","MOBILE","POLISH"]}},"startingGroups":[["PAD","LIMA","CONE","TOMATO"],["POLISH","PEPPER","PHONE","PYRAMID"],["CUBE","MOBILE","JOB","CUCUMBER"],["EGGPLANT","MAC","SPHERE","POD"]]},{"groups":{"SHOE PARTS":{"level":0,"members":["HEEL","LACE","SOLE","TONGUE"]},"BOARD GAMES":{"level":1,"members":["CLUE","RISK","SORRY","TROUBLE"]},"FICTIONAL SPIES":{"level":2,"members":["BOND","HUNT","RYAN","SMART"]},"RUBBER ___":{"level":3,"members":["BAND","CEMENT","DUCKIE","SOUL"]}},"startingGroups":[["SOLE","TROUBLE","HUNT","CEMENT"],["SMART","TONGUE","SOUL","BOND"],["LACE","BAND","SORRY","RYAN"],["CLUE","HEEL","DUCKIE","RISK"]]},{"groups":{"BOATS":{"level":0,"members":["FERRY","JUNK","TUG","YACHT"]},"SANDWICHES":{"level":1,"members":["CLUB","CUBAN","MELT","SUB"]},"CUTS OF BEEF":{"level":2,"members":["FLANK","LOIN","ROUND","SHANK"]},"NICKNAMES THAT ARE VERBS":{"level":3,"members":["CHUCK","JOSH","ROB","SUE"]}},"startingGroups":[["TUG","CHUCK","JUNK","CLUB"],["SHANK","ROB","SUB","FLANK"],["CUBAN","FERRY","LOIN","SUE"],["JOSH","ROUND","MELT","YACHT"]]},{"groups":{"PLEASANT SMELLS":{"level":0,"members":["AROMA","BOUQUET","FRAGRANCE","SCENT"]},"MUSIC GENRES":{"level":1,"members":["BLUES","COUNTRY","FUNK","SOUL"]},"ROCK PAPER SCISSORS":{"level":2,"members":["PAPER","ROCK","SCISSORS","SHOOT"]},"MALE ANIMALS":{"level":3,"members":["BOAR","BUCK","BULL","JACK"]}},"startingGroups":[["ROCK","FUNK","BUCK","BOUQUET"],["SHOOT","BULL","COUNTRY","JACK"],["SOUL","SCENT","SCISSORS","BOAR"],["FRAGRANCE","PAPER","BLUES","AROMA"]]},{"groups":{"U.S. COINS":{"level":0,"members":["DIME","NICKEL","PENNY","QUARTER"]},"METAL ELEMENTS":{"level":1,"members":["IRON","LEAD","TIN","ZINC"]},"LUCKY CHARMS MARSHMALLOWS":{"level":2,"members":["CLOVER","HORSESHOE","MOON","RAINBOW"]},"___ AND ___":{"level":3,"members":["AGAIN","HALF","NECK","SO"]}},"startingGroups":[["NICKEL","HALF","HORSESHOE","TIN"],["RAINBOW","QUARTER","NECK","LEAD"],["PENNY","CLOVER","IRON","SO"],["ZINC","AGAIN","DIME","MOON"]]},{"groups":{"MARSUPIALS":{"level":0,"members":["KANGAROO","KOALA","WALLABY","WOMBAT"]},"CHOCOLATE BARS":{"level":1,"members":["CHUNKY","CRUNCH","MARS","MOUNDS"]},"SLANG FOR MONEY":{"level":2,"members":["CHEDDAR","DOUGH","PAPER","STACKS"]},"NAKED ___":{"level":3,"members":["EYE","GUN","MOLE RAT","TRUTH"]}},"startingGroups":[["EYE","MARS","PAPER","TRUTH"],["WOMBAT","GUN","MOLE RAT","CHUNKY"],["CHEDDAR","CRUNCH","KANGAROO","DOUGH"],["KOALA","STACKS","MOUNDS","WALLABY"]]},{"groups":{"MARINE MAMMALS":{"level":0,"members":["DOLPHIN","MANATEE","OTTER","SEAL"]},"BIKE PARTS":{"level":1,"members":["BRAKE","CHAIN","SADDLE","SPOKE"]},"SYNONYMS FOR SELL":{"level":2,"members":["HAWK","MOVE","PEDDLE","VEND"]},"COUNTRIES WHEN \\"A\\" IS ADDED":{"level":3,"members":["CHIN","CUB","MALT","TONG"]}},"startingGroups":[["SPOKE","MOVE","CUB","SEAL"],["HAWK","CHAIN","DOLPHIN","CHIN"],["SADDLE","PEDDLE","MALT","OTTER"],["MANATEE","BRAKE","VEND","TONG"]]},{"groups":{"TREES":{"level":0,"members":["ASH","CEDAR","MAPLE","PINE"]},"LAND FORMATIONS":{"level":1,"members":["HILL","MOUNTAIN","PLATEAU","VALLEY"]},"BAGEL FLAVORS":{"level":2,"members":["EVERYTHING","ONION","PLAIN","POPPY"]},"STREETS ON SCREEN":{"level":3,"members":["ELM","FEAR","JUMP","SESAME"]}},"startingGroups":[["MOUNTAIN","ELM","ONION","JUMP"],["PLAIN","VALLEY","MAPLE","POPPY"],["PINE","SESAME","HILL","FEAR"],["PLATEAU","ASH","EVERYTHING","CEDAR"]]},{"groups":{"TIMEKEEPING DEVICES":{"level":0,"members":["CLOCK","HOURGLASS","SUNDIAL","WATCH"]},"HAIRSTYLES":{"level":1,"members":["BOB","CROP","PIXIE","SHAG"]},"UNITS OF MEASURE":{"level":2,"members":["HERTZ","MOLE","NEWTON","SECOND"]},"DR. ___":{"level":3,"members":["EVIL","J","NO","PEPPER"]}},"startingGroups":[["PEPPER","MOLE","WATCH","BOB"],["SECOND","EVIL","CROP","CLOCK"],["NO","NEWTON","SUNDIAL","PIXIE"],["HERTZ","HOURGLASS","SHAG","J"]]},{"groups":{"WOODWINDS":{"level":0,"members":["BASSOON","CLARINET","FLUTE","OBOE"]},"COVERINGS":{"level":1,"members":["CAP","COVER","LID","TOP"]},"SUNGLASSES":{"level":2,"members":["AVIATOR","CAT EYE","WAYFARER","WRAPAROUND"]},"SEALS":{"level":3,"members":["HARBOR","HARP","HOODED","MONK"]}},"startingGroups":[["AVIATOR","FLUTE","MONK","LID"],["HARBOR","HARP","CLARINET","CAT EYE"],["TOP","HOODED","BASSOON","COVER"],["OBOE","WAYFARER","CAP","WRAPAROUND"]]},{"groups":{"BOTTLED WATER BRANDS":{"level":0,"members":["DASANI","EVIAN","FIJI","VOSS"]},"SLANG FOR COFFEE":{"level":1,"members":["BREW","JAVA","JOE","MUD"]},"ISLAND COUNTRIES":{"level":2,"members":["CUBA","JAPAN","MALTA","PALAU"]},"CEREAL MASCOTS":{"level":3,"members":["LUCKY","POP","SAM","TONY"]}},"startingGroups":[["FIJI","MUD","POP","PALAU"],["JOE","SAM","JAPAN","BREW"],["CUBA","VOSS","TONY","JAVA"],["DASANI","MALTA","EVIAN","LUCKY"]]},{"groups":{"SCUBA GEAR":{"level":0,"members":["FINS","MASK","SNORKEL","TANK"]},"PUNCTUATION MARKS":{"level":1,"members":["COLON","COMMA","HYPHEN","PERIOD"]},"RUN QUICKLY":{"level":2,"members":["BOLT","DASH","RACE","SPRINT"]},"___ CAT":{"level":3,"members":["DOJA","FAT","HOUSE","JUNGLE"]}},"startingGroups":[["DASH","MASK","JUNGLE","PERIOD"],["HOUSE","HYPHEN","SNORKEL","BOLT"],["FAT","TANK","COLON","RACE"],["FINS","SPRINT","DOJA","COMMA"]]},{"groups":{"SYNONYMS FOR ANGRY":{"level":0,"members":["FURIOUS","INCENSED","IRATE","LIVID"]},"THINGS THAT ARE YELLOW":{"level":1,"members":["BANANA","CANARY","SCHOOL BUS","SUNFLOWER"]},"MARINE BIRDS":{"level":2,"members":["BOOBY","GULL","PELICAN","PUFFIN"]},"___ BOYS":{"level":3,"members":["BEACH","BEASTIE","HARDY","LOST"]}},"startingGroups":[["CANARY","IRATE","LOST","SCHOOL BUS"],["BEACH","GULL","FURIOUS","BOOBY"],["BANANA","BEASTIE","SUNFLOWER","LIVID"],["HARDY","PELICAN","INCENSED","PUFFIN"]]},{"groups":{"STATES OF MATTER":{"level":0,"members":["GAS","LIQUID","PLASMA","SOLID"]},"EDIT MENU COMMANDS":{"level":1,"members":["COPY","CUT","PASTE","UNDO"]},"DEFEAT BADLY":{"level":2,"members":["CRUSH","ROUT","SHELLAC","TRASH"]},"ANAGRAMS":{"level":3,"members":["LEAST","SLATE","STALE","TESLA"]}},"startingGroups":[["SOLID","PASTE","SLATE","TRASH"],["TESLA","CUT","PLASMA","CRUSH"],["GAS","SHELLAC","STALE","UNDO"],["COPY","LIQUID","ROUT","LEAST"]]},{"groups":{"MODES OF TRANSPORTATION":{"level":0,"members":["BOAT","CAR","PLANE","TRAIN"]},"NBA PLAYERS":{"level":1,"members":["KING","MAGIC","SUN","THUNDER"]},"FAST FOOD CHAINS":{"level":2,"members":["CHECKERS","OUTBACK","SONIC","SUBWAY"]},"BAND NAMES MINUS COLORS":{"level":3,"members":["DAY","FLOYD","SABBATH","STRIPES"]}},"startingGroups":[["PLANE","SUN","DAY","THUNDER"],["SONIC","BOAT","STRIPES","CHECKERS"],["CAR","SUBWAY","FLOYD","TRAIN"],["OUTBACK","KING","SABBATH","MAGIC"]]},{"groups":{"MOVIE TITLE CITIES":{"level":0,"members":["CHICAGO","MUNICH","PHILADELPHIA","RIO"]},"FASHION MAGAZINES":{"level":1,"members":["ALLURE","ELLE","GLAMOUR","W"]},"STORMS":{"level":2,"members":["BLIZZARD","CYCLONE","SQUALL","TORNADO"]},"COCKTAILS":{"level":3,"members":["COSMOPOLITAN","HURRICANE","MANHATTAN","SCREWDRIVER"]}},"startingGroups":[["HURRICANE","CYCLONE","CHICAGO","W"],["MANHATTAN","GLAMOUR","TORNADO","PHILADELPHIA"],["COSMOPOLITAN","SQUALL","ALLURE","SCREWDRIVER"],["RIO","BLIZZARD","MUNICH","ELLE"]]},{"groups":{"BIOMES":{"level":0,"members":["DESERT","FOREST","GRASSLAND","TUNDRA"]},"LIZARDS":{"level":1,"members":["CHAMELEON","GECKO","IGUANA","MONITOR"]},"YOGA POSES":{"level":2,"members":["COBRA","LOTUS","TREE","WARRIOR"]},"DANCES WHEN DOUBLED":{"level":3,"members":["CAN","CHA","GO","NAE"]}},"startingGroups":[["TREE","GECKO","FOREST","GO"],["MONITOR","DESERT","LOTUS","CAN"],["IGUANA","CHA","TUNDRA","COBRA"],["GRASSLAND","WARRIOR","NAE","CHAMELEON"]]},{"groups":{"FABRICS":{"level":0,"members":["CORDUROY","DENIM","LINEN","TWEED"]},"APPARITIONS":{"level":1,"members":["GHOST","PHANTOM","SPECTER","SPIRIT"]},"SYNONYMS FOR BOTHER":{"level":2,"members":["NEEDLE","POKE","RIB","TEASE"]},"DISNEY CHARACTERS":{"level":3,"members":["BEAST","GENIE","SCAR","STITCH"]}},"startingGroups":[["RIB","SPECTER","TWEED","SCAR"],["SPIRIT","BEAST","NEEDLE","LINEN"],["STITCH","POKE","DENIM","GENIE"],["CORDUROY","GHOST","TEASE","PHANTOM"]]},{"groups":{"RELATIVES":{"level":0,"members":["AUNT","COUSIN","MOTHER","NEPHEW"]},"SYNONYMS FOR OFFBEAT":{"level":1,"members":["DAFFY","KOOKY","QUIRKY","WACKY"]},"DISNEY DUCKS":{"level":2,"members":["DAISY","DEWEY","DONALD","SCROOGE"]},"___ CLOCK":{"level":3,"members":["ALARM","BIOLOGICAL","CUCKOO","GRANDFATHER"]}},"startingGroups":[["DAISY","AUNT","ALARM","QUIRKY"],["SCROOGE","GRANDFATHER","KOOKY","BIOLOGICAL"],["NEPHEW","DAFFY","CUCKOO","MOTHER"],["DEWEY","WACKY","COUSIN","DONALD"]]},{"groups":{"UNITS OF LENGTH":{"level":0,"members":["FOOT","INCH","MILE","YARD"]},"TYPES OF PAINT":{"level":1,"members":["ACRYLIC","OIL","TEMPERA","WATERCOLOR"]},"DEEP-FRIED FOOD":{"level":2,"members":["FALAFEL","KATSU","SAMOSA","SCHNITZEL"]},"STARTS OF U.S. COINS":{"level":3,"members":["DIM","NICK","PEN","QUART"]}},"startingGroups":[["OIL","FOOT","SAMOSA","DIM"],["QUART","KATSU","MILE","WATERCOLOR"],["PEN","INCH","ACRYLIC","FALAFEL"],["YARD","NICK","SCHNITZEL","TEMPERA"]]},{"groups":{"LONG SANDWICHES":{"level":0,"members":["HERO","HOAGIE","GRINDER","SUB"]},"DATING APPS":{"level":1,"members":["BUMBLE","HINGE","MATCH","TINDER"]},"VAMPIRE MOVIES":{"level":2,"members":["BLADE","LOST BOYS","NEAR DARK","TWILIGHT"]},"ADAMS":{"level":3,"members":["ANT","DRIVER","SCOTT","WEST"]}},"startingGroups":[["MATCH","HERO","BLADE","DRIVER"],["GRINDER","SCOTT","HINGE","TWILIGHT"],["WEST","TINDER","ANT","SUB"],["BUMBLE","LOST BOYS","HOAGIE","NEAR DARK"]]},{"groups":{"COMPUTER EQUIPMENT":{"level":0,"members":["KEYBOARD","MONITOR","MOUSE","SPEAKER"]},"RODENTS":{"level":1,"members":["GERBIL","HAMSTER","RAT","VOLE"]},"MUSICAL INSTRUMENTS":{"level":2,"members":["HARP","HORN","ORGAN","TRIANGLE"]},"SYNONYMS FOR COMPLAIN":{"level":3,"members":["CARP","GRIPE","GROUSE","MOAN"]}},"startingGroups":[["RAT","HORN","SPEAKER","TRIANGLE"],["CARP","HARP","ORGAN","VOLE"],["GROUSE","HAMSTER","MOUSE","MONITOR"],["KEYBOARD","MOAN","GERBIL","GRIPE"]]},{"groups":{"ANIMAL GROUP NAMES":{"level":0,"members":["COLONY","HERD","PRIDE","SWARM"]},"STONED":{"level":1,"members":["BAKED","BLAZED","HIGH","LIT"]},"AP CLASSES":{"level":2,"members":["BIO","CHEM","GOV","STATS"]},"TAXONOMY RANKS":{"level":3,"members":["CLASS","DOMAIN","FAMILY","ORDER"]}},"startingGroups":[["HIGH","PRIDE","CLASS","GOV"],["ORDER","CHEM","LIT","FAMILY"],["SWARM","DOMAIN","BIO","COLONY"],["BAKED","STATS","HERD","BLAZED"]]},{"groups":{"PLACES FOR WORSHIP":{"level":0,"members":["ALTAR","RELIQUARY","SHRINE","TEMPLE"]},"CARTOON CATS":{"level":1,"members":["FELIX","GARFIELD","SYLVESTER","TOM"]},"PRESIDENTIAL FIRST NAMES":{"level":2,"members":["CALVIN","CHESTER","GROVER","HARRY"]},"___ ROAD":{"level":3,"members":["ABBEY","HIGH","ROCKY","SILK"]}},"startingGroups":[["TOM","ROCKY","TEMPLE","HARRY"],["HIGH","ALTAR","SYLVESTER","GROVER"],["SILK","CALVIN","ABBEY","GARFIELD"],["CHESTER","RELIQUARY","FELIX","SHRINE"]]},{"groups":{"CLASSIC TOYS":{"level":0,"members":["BLOCKS","DOLL","TOP","YO-YO"]},"WORDS WITH THREE G\'S":{"level":1,"members":["BAGGAGE","EGGNOG","GIGGLE","LEGGINGS"]},"SHAKESPEARE CHARACTERS":{"level":2,"members":["DUNCAN","JULIET","PUCK","VIOLA"]},"___ STICK":{"level":3,"members":["FISH","HOCKEY","MEMORY","SELFIE"]}},"startingGroups":[["VIOLA","TOP","GIGGLE","MEMORY"],["EGGNOG","BLOCKS","SELFIE","PUCK"],["DOLL","HOCKEY","DUNCAN","LEGGINGS"],["JULIET","BAGGAGE","YO-YO","FISH"]]},{"groups":{"CLASSIC ARCADE GAMES":{"level":0,"members":["ASTEROIDS","BREAKOUT","FROGGER","PONG"]},"DANCES":{"level":1,"members":["HUSTLE","SALSA","SWING","TANGO"]},"TOUCHSCREEN GESTURES":{"level":2,"members":["PINCH","SPREAD","SWIPE","TAP"]},"RAPPERS MINUS NUMBERS":{"level":3,"members":["CENT","CHAINZ","PAC","SAVAGE"]}},"startingGroups":[["PINCH","SALSA","SAVAGE","BREAKOUT"],["CENT","SWIPE","SWING","TAP"],["ASTEROIDS","PAC","PONG","HUSTLE"],["TANGO","SPREAD","CHAINZ","FROGGER"]]},{"groups":{"MOVIE GENRES":{"level":0,"members":["HORROR","MUSICAL","ROMANCE","WESTERN"]},"PATTERNS":{"level":1,"members":["HOUNDSTOOTH","PAISLEY","PLAID","STRIPES"]},"SYNONYMS FOR FALSEHOOD":{"level":2,"members":["FIB","FICTION","LIE","TALE"]},"CANDY PIECES":{"level":3,"members":["DOT","GOOBER","KISS","WHOPPER"]}},"startingGroups":[["KISS","ROMANCE","STRIPES","FICTION"],["PAISLEY","HORROR","DOT","LIE"],["MUSICAL","WHOPPER","PLAID","FIB"],["GOOBER","TALE","WESTERN","HOUNDSTOOTH"]]},{"groups":{"ARACHNIDS":{"level":0,"members":["MITE","SCORPION","SPIDER","TICK"]},"FISH":{"level":1,"members":["CHAR","EEL","PERCH","SHARK"]},"SUPERHEROES":{"level":2,"members":["BLACK WIDOW","BLADE","FLASH","STORM"]},"MTV SHOWS":{"level":3,"members":["CATFISH","CRIBS","JACKASS","STATE"]}},"startingGroups":[["BLADE","CATFISH","TICK","CHAR"],["STATE","EEL","STORM","FLASH"],["BLACK WIDOW","JACKASS","PERCH","SCORPION"],["MITE","SHARK","SPIDER","CRIBS"]]},{"groups":{"UNSPECIFIED QUANTITIES":{"level":0,"members":["FEW","HANDFUL","SEVERAL","SOME"]},"NEWSPAPERS":{"level":2,"members":["GLOBE","JOURNAL","POST","SUN"]},"CELESTIAL OBJECTS":{"level":1,"members":["ASTEROID","COMET","MOON","PLANET"]},"FRUIT HOMOPHONES":{"level":3,"members":["LYME","MELLON","PAIR","PLUMB"]}},"startingGroups":[["MOON","GLOBE","SOME","LYME"],["FEW","PAIR","POST","COMET"],["PLUMB","HANDFUL","SUN","PLANET"],["JOURNAL","MELLON","ASTEROID","SEVERAL"]]},{"groups":{"HORROR FRANCHISES":{"level":0,"members":["PURGE","RING","SAW","SCREAM"]},"SPORTS VENUES":{"level":1,"members":["COURT","DIAMOND","FIELD","RINK"]},"MAKE HAPPY":{"level":2,"members":["CHARM","DELIGHT","PLEASE","TICKLE"]},"JEWELRY":{"level":3,"members":["ANKLET","BANGLE","BROOCH","PENDANT"]}},"startingGroups":[["DIAMOND","PENDANT","CHARM","SAW"],["PLEASE","COURT","SCREAM","TICKLE"],["BANGLE","RING","FIELD","DELIGHT"],["PURGE","ANKLET","RINK","BROOCH"]]},{"groups":{"THEORETICAL PHYSICISTS":{"level":0,"members":["EINSTEIN","FEYNMAN","HAWKING","OPPENHEIMER"]},"TALENT":{"level":1,"members":["FACULTY","FLAIR","GENIUS","GIFT"]},"AUSTRALIAN TERMS":{"level":2,"members":["BARBIE","BUSH","CRIKEY","MATE"]},"___ POINT":{"level":3,"members":["MATCH","MOOT","SELLING","WEST"]}},"startingGroups":[["BARBIE","OPPENHEIMER","MATCH","GENIUS"],["WEST","BUSH","SELLING","HAWKING"],["FACULTY","EINSTEIN","MATE","MOOT"],["CRIKEY","GIFT","FEYNMAN","FLAIR"]]},{"groups":{"STATE ABBREVIATIONS":{"level":0,"members":["CO","MA","ME","PA"]},"MUSICAL NOTES":{"level":1,"members":["DO","FA","LA","TI"]},"GREEK LETTERS":{"level":2,"members":["MU","NU","PI","XI"]},"PERIODIC TABLE SYMBOLS":{"level":3,"members":["FE","HE","NA","NI"]}},"startingGroups":[["MA","LA","NA","NU"],["PI","NI","TI","HE"],["FA","XI","PA","FE"],["DO","CO","MU","ME"]]},{"groups":{"FASTENING VERBS":{"level":0,"members":["BUCKLE","BUTTON","SNAP","ZIP"]},"SLANG FOR ZERO":{"level":1,"members":["JACK","NADA","NOTHING","SQUAT"]},"GYM EXERCISES":{"level":2,"members":["CURL","LUNGE","PLANK","PRESS"]},"\\"CAPTAINS\\"":{"level":3,"members":["CRUNCH","KANGAROO","OBVIOUS","PLANET"]}},"startingGroups":[["JACK","PRESS","PLANET","BUTTON"],["PLANK","SQUAT","SNAP","OBVIOUS"],["CRUNCH","BUCKLE","NOTHING","CURL"],["ZIP","KANGAROO","LUNGE","NADA"]]},{"groups":{"CLASSIC DOG NAMES":{"level":0,"members":["FIDO","LUCKY","ROVER","SPOT"]},"PERCEIVE":{"level":1,"members":["CATCH","NOTICE","OBSERVE","SEE"]},"FISHING TERMS":{"level":2,"members":["BAIT","CHUM","FLY","SINKER"]},"T-___":{"level":3,"members":["BONE","REX","SHIRT","STORM"]}},"startingGroups":[["CATCH","SPOT","BONE","LUCKY"],["SEE","SHIRT","FLY","STORM"],["CHUM","NOTICE","REX","BAIT"],["FIDO","SINKER","OBSERVE","ROVER"]]},{"groups":{"STATES OF MATTER":{"level":0,"members":["GAS","LIQUID","PLASMA","SOLID"]},"ENERGY":{"level":1,"members":["JUICE","SPIRIT","STEAM","VIGOR"]},"CLASSICAL ELEMENTS":{"level":2,"members":["AIR","EARTH","FIRE","WATER"]},"THINGS WITH RINGS":{"level":3,"members":["CIRCUS","SATURN","TREE","WEDDING"]}},"startingGroups":[["JUICE","WATER","TREE","EARTH"],["GAS","CIRCUS","STEAM","LIQUID"],["SATURN","FIRE","SOLID","SPIRIT"],["PLASMA","VIGOR","AIR","WEDDING"]]},{"groups":{"TIME PERIODS":{"level":0,"members":["CENTURY","DECADE","MILLENNIUM","YEAR"]},"BREAKFAST FOODS":{"level":1,"members":["CEREAL","OMELET","PANCAKE","WAFFLE"]},"PAINTERS":{"level":2,"members":["BACON","CLOSE","MUNCH","WHISTLER"]},"ONE IN A DOZEN":{"level":3,"members":["EGG","JUROR","MONTH","ROSE"]}},"startingGroups":[["ROSE","CLOSE","BACON","YEAR"],["PANCAKE","MONTH","MUNCH","EGG"],["DECADE","CEREAL","CENTURY","OMELET"],["WHISTLER","MILLENNIUM","JUROR","WAFFLE"]]},{"groups":{"DESSERTS":{"level":0,"members":["CAKE","COBBLER","PIE","TART"]},"OCCUPATIONAL SURNAMES":{"level":1,"members":["FISHER","MASON","MILLER","SMITH"]},"ALTER DECEPTIVELY":{"level":2,"members":["DISTORT","DOCTOR","FUDGE","TWIST"]},"SQUARE ___":{"level":3,"members":["DANCE","MEAL","ONE","ROOT"]}},"startingGroups":[["FUDGE","MEAL","COBBLER","SMITH"],["PIE","DOCTOR","ROOT","TWIST"],["DANCE","ONE","FISHER","TART"],["MASON","CAKE","DISTORT","MILLER"]]},{"groups":{"UNITS OF VOLUME":{"level":0,"members":["CUP","GALLON","PINT","QUART"]},"EXTREMELY":{"level":1,"members":["AWFUL","QUITE","SUPER","VERY"]},"WORLD CURRENCIES":{"level":2,"members":["RAND","REAL","STERLING","WON"]},"___ CAKE":{"level":3,"members":["CARROT","COFFEE","POUND","SPONGE"]}},"startingGroups":[["PINT","REAL","CARROT","AWFUL"],["SPONGE","CUP","WON","SUPER"],["GALLON","COFFEE","VERY","POUND"],["RAND","QUITE","QUART","STERLING"]]},{"groups":{"FRIEND":{"level":0,"members":["BUD","CHUM","MATE","PAL"]},"COOKWEAR":{"level":1,"members":["CROCK","POT","SKILLET","WOK"]},"SHOES":{"level":2,"members":["CLOG","PUMP","SLIDE","WEDGE"]},"SLANG FOR CANNABIS":{"level":3,"members":["GRASS","HERB","MARY JANE","WEED"]}},"startingGroups":[["BUD","PUMP","CROCK","HERB"],["POT","MATE","WEDGE","GRASS"],["WOK","MARY JANE","CHUM","SLIDE"],["CLOG","PAL","SKILLET","WEED"]]},{"groups":{"CAMPING SUPPLIES":{"level":0,"members":["COOLER","LANTERN","SLEEPING BAG","TENT"]},"INSULT":{"level":1,"members":["BARB","DIG","DISS","JAB"]},"TINY":{"level":2,"members":["MINUTE","SLIGHT","SMALL","WEE"]},"HAPPY ___":{"level":3,"members":["CAMPER","HOUR","MEAL","MEDIUM"]}},"startingGroups":[["MINUTE","DIG","MEAL","COOLER"],["HOUR","TENT","SLIGHT","MEDIUM"],["SMALL","BARB","CAMPER","LANTERN"],["JAB","SLEEPING BAG","DISS","WEE"]]},{"groups":{"ANCIENT PHILOSOPHERS":{"level":0,"members":["SOCRATES","PLATO","ARISTOTLE","CONFUCIUS"]},"GEOLOGICAL PERIODS":{"level":1,"members":["CRETACEOUS","JURASSIC","TRIASSIC","PERMIAN"]},"RARE EARTH ELEMENTS":{"level":2,"members":["EUROPIUM","TERBIUM","PROMETHIUM","THULIUM"]},"ASTRONOMICAL TERMS":{"level":3,"members":["NEBULA","QUASAR","PULSAR","GALAXY"]}},"startingGroups":[["SOCRATES","CRETACEOUS","EUROPIUM","NEBULA"],["PLATO","JURASSIC","TERBIUM","QUASAR"],["ARISTOTLE","TRIASSIC","PROMETHIUM","PULSAR"],["CONFUCIUS","PERMIAN","THULIUM","GALAXY"]]},{"groups":{"ANCIENT ROMAN ARCHITECTURE":{"level":0,"members":["COLOSSEUM","PANTHEON","AQUEDUCT","FORUM"]},"SHAKESPEARE PLAYS":{"level":1,"members":["HAMLET","OTHELLO","MACBETH","TEMPLEST"]},"CRYPTOGRAPHY TERMS":{"level":2,"members":["ENIGMA","CYBORG","HASH","CIPHER"]},"POISONOUS PLANTS":{"level":3,"members":["HEMLOCK","BELLADONNA","OLEANDER","CASTOR"]}},"startingGroups":[["COLOSSEUM","HAMLET","ENIGMA","HEMLOCK"],["PANTHEON","OTHELLO","CYBORG","BELLADONNA"],["AQUEDUCT","MACBETH","HASH","OLEANDER"],["FORUM","TEMPLEST","CIPHER","CASTOR"]]},{"groups":{"ASTRONOMICAL OBJECTS":{"level":0,"members":["GALAXY","PULSAR","NEBULA","QUASAR"]},"MUSICAL TERMS":{"level":1,"members":["ALLEGRO","FUGUE","CADENCE","FORTISSIMO"]},"ENTOMOLOGY (STUDY OF INSECTS)":{"level":2,"members":["BEETLE","MANTIS","FIREFLY","DRAGONFLY"]},"ARCHAIC ENGLISH TERMS":{"level":3,"members":["BESMIRCH","GAINSAY","YCLEPT","WIGHT"]}},"startingGroups":[["GALAXY","ALLEGRO","BEETLE","BESMIRCH"],["PULSAR","FUGUE","MANTIS","GAINSAY"],["NEBULA","CADENCE","FIREFLY","YCLEPT"],["QUASAR","FORTISSIMO","DRAGONFLY","WIGHT"]]},{"groups":{"DINOSAURS":{"level":0,"members":["TYRANNOSAURUS","VELOCIRAPTOR","STEGOSAURUS","TRICERATOPS"]},"MATHEMATICAL THEOREMS":{"level":1,"members":["PYTHAGOREAN","FERMAT","GAUSS","RIEMANN"]},"CRYPTOCURRENCY TERMS":{"level":2,"members":["BLOCKCHAIN","ETHER","LITECOIN","RIPPLE"]},"RARE GEMS":{"level":3,"members":["TANZANITE","GRANDIDIERITE","ALEXANDRITE","PAINITE"]}},"startingGroups":[["TYRANNOSAURUS","PYTHAGOREAN","BLOCKCHAIN","TANZANITE"],["VELOCIRAPTOR","FERMAT","ETHER","GRANDIDIERITE"],["STEGOSAURUS","GAUSS","LITECOIN","ALEXANDRITE"],["TRICERATOPS","RIEMANN","RIPPLE","PAINITE"]]},{"groups":{"FAMOUS COMPOSERS":{"level":0,"members":["BEETHOVEN","MOZART","BACH","VIVALDI"]},"MEDIEVAL WEAPONS":{"level":1,"members":["HALBERD","TREBUCHET","LONGSWORD","CROSSBOW"]},"ARCHAEOLOGICAL SITES":{"level":2,"members":["STONEHENGE","MACHUPICCHU","PYRAMIDS","PETRA"]},"QUANTUM PHYSICS TERMS":{"level":3,"members":["ENTANGLEMENT","SUPERPOSITION","QUARK","BOSON"]}},"startingGroups":[["BEETHOVEN","HALBERD","STONEHENGE","ENTANGLEMENT"],["MOZART","TREBUCHET","MACHUPICCHU","SUPERPOSITION"],["BACH","LONGSWORD","PYRAMIDS","QUARK"],["VIVALDI","CROSSBOW","PETRA","BOSON"]]},{"groups":{"ANCIENT CIVILIZATIONS":{"level":0,"members":["SUMERIANS","EGYPTIANS","MAYANS","ROMANS"]},"LINGUISTIC TERMS":{"level":1,"members":["MORPHEME","SYNTAX","SEMIOTICS","PHONEME"]},"RARE DISEASES":{"level":2,"members":["FIBRODYSPLASIA","PANTOTHENATE","OCHRONOSIS","HYPER IgM"]},"CELESTIAL OBJECTS":{"level":3,"members":["COMET","PULSAR","NEBULA","QUASAR"]}},"startingGroups":[["SUMERIANS","MORPHEME","FIBRODYSPLASIA","COMET"],["EGYPTIANS","SYNTAX","PANTOTHENATE","PULSAR"],["MAYANS","SEMIOTICS","OCHRONOSIS","NEBULA"],["ROMANS","PHONEME","HYPER IgM","QUASAR"]]},{"groups":{"OBSCURE GREEK GODS":{"level":0,"members":["AETHER","EREBUS","HYPERION","THEMIS"]},"TYPES OF WINE":{"level":1,"members":["MALBEC","RIESLING","SYRAH","ZINFANDEL"]},"COMPUTER PROGRAMMING LANGUAGES":{"level":2,"members":["FORTRAN","LISP","RUBY","SWIFT"]},"FAMOUS SCIENTISTS":{"level":3,"members":["CURIE","EINSTEIN","HAWKING","TESLA"]}},"startingGroups":[["MALBEC","LISP","HAWKING","AETHER"],["EINSTEIN","RUBY","EREBUS","SYRAH"],["CURIE","FORTRAN","THEMIS","ZINFANDEL"],["HYPERION","SWIFT","RIESLING","TESLA"]]},{"groups":{"HITCHCOCK MOVIES":{"level":0,"members":["PSYCHO","ROPE","VERTIGO","REBECCA"]},"MUSIC SCALES":{"level":1,"members":["PENTATONIC","CHROMATIC","MAJOR","MINOR"]},"TOOL BRANDS":{"level":2,"members":["BOSCH","DEWALT","MAKITA","RYOBI"]},"THE FOUR HORSEMEN OF THE APOCALYPSE":{"level":3,"members":["CONQUEST","DEATH","FAMINE","WAR"]}},"startingGroups":[["PENTATONIC","DEWALT","WAR","PSYCHO"],["VERTIGO","MAKITA","FAMINE","MAJOR"],["CONQUEST","CHROMATIC","RYOBI","REBECCA"],["ROPE","BOSCH","DEATH","MINOR"]]},{"groups":{"UNCOMMON GEOLOGICAL TERMS":{"level":0,"members":["BATHOLITH","CRETACEOUS","PENEPLAIN","TALUS"]},"ANCIENT CIVILIZATIONS":{"level":1,"members":["ASSYRIA","BABYLON","CARTHAGE","SUMER"]},"LESSER KNOWN SHAKESPEARE PLAYS":{"level":2,"members":["CORIOLANUS","CYMBELINE","PERICLES","TITUS"]},"RENOWNED CLASSICAL COMPOSERS":{"level":3,"members":["BEETHOVEN","HAYDN","MOZART","VERDI"]}},"startingGroups":[["BATHOLITH","ASSYRIA","CYMBELINE","HAYDN"],["TITUS","BABYLON","BEETHOVEN","CRETACEOUS"],["PENEPLAIN","MOZART","CARTHAGE","CORIOLANUS"],["SUMER","TALUS","VERDI","PERICLES"]]},{"groups":{"UNUSUAL PANTONE COLORS":{"level":0,"members":["FLAME","MARSALA","SERENITY","TANGERINE"]},"RARE CHEMICAL ELEMENTS":{"level":1,"members":["BERKELIUM","HAFNIUM","RHENIUM","THULIUM"]},"TYPES OF CLOUDS":{"level":2,"members":["CUMULUS","NIMBUS","STRATUS","CIRROCUMULUS"]},"LATIN DANCE STYLES":{"level":3,"members":["BACHATA","MERENGUE","RUMBA","SALSA"]}},"startingGroups":[["RHENIUM","SERENITY","MERENGUE","CUMULUS"],["RUMBA","FLAME","BERKELIUM","STRATUS"],["BACHATA","TANGERINE","THULIUM","NIMBUS"],["SALSA","MARSALA","HAFNIUM","CIRROCUMULUS"]]},{"groups":{"FOSSIL FUEL PRODUCTS":{"level":0,"members":["COAL","GASOLINE","KEROSENE","NATURAL GAS"]},"SHAPES IN GEOMETRY":{"level":1,"members":["HEXAGON","PARALLELOGRAM","RHOMBUS","TRIANGLE"]},"ANCIENT PHILOSOPHERS":{"level":2,"members":["ARISTOTLE","CONFUCIUS","PLATO","SOCRATES"]},"INFAMOUS DICTATORS":{"level":3,"members":["FRANCO","HITLER","STALIN","MUSSOLINI"]}},"startingGroups":[["HEXAGON","GASOLINE","HITLER","CONFUCIUS"],["NATURAL GAS","TRIANGLE","SOCRATES","MUSSOLINI"],["PLATO","KEROSENE","RHOMBUS","STALIN"],["ARISTOTLE","PARALLELOGRAM","COAL","FRANCO"]]},{"groups":{"TYPES OF BRIDGES":{"level":0,"members":["ARCH","BEAM","CANTILEVER","SUSPENSION"]},"NOBEL PRIZE CATEGORIES":{"level":1,"members":["CHEMISTRY","LITERATURE","PEACE","PHYSICS"]},"FAMOUS LITERARY DETECTIVES":{"level":2,"members":["HOLMES","MARLOWE","POIROT","SAM SPADE"]},"OBSOLETE SCIENTIFIC THEORIES":{"level":3,"members":["ETHER","FLAT EARTH","PHLOGISTON","SPONTANEOUS GENERATION"]}},"startingGroups":[["CANTILEVER","PEACE","HOLMES","SPONTANEOUS GENERATION"],["SUSPENSION","PHYSICS","SAM SPADE","PHLOGISTON"],["ARCH","LITERATURE","POIROT","ETHER"],["BEAM","CHEMISTRY","MARLOWE","FLAT EARTH"]]},{"groups":{"LESSER-KNOWN VITAMINS":{"level":0,"members":["BIOTIN","FOLATE","NIACIN","RIBOFLAVIN"]},"NORDIC COUNTRIES":{"level":1,"members":["DENMARK","FINLAND","ICELAND","SWEDEN"]},"CLASSIC BOARD GAMES":{"level":2,"members":["CHESS","RISK","SORRY","TWISTER"]},"UNUSUAL SPORTS":{"level":3,"members":["BOCCIA","JAI-ALAI","KABADDI","SEPAK"]}},"startingGroups":[["BIOTIN","DENMARK","SORRY","SEPAK"],["FOLATE","FINLAND","RISK","KABADDI"],["NIACIN","ICELAND","CHESS","JAI-ALAI"],["RIBOFLAVIN","SWEDEN","TWISTER","BOCCIA"]]},{"groups":{"RARE EARTH ELEMENTS":{"level":0,"members":["CERIUM","ERBIUM","NEODYMIUM","THULIUM"]},"GLOBE THEATRE PLAYS":{"level":1,"members":["HAMLET","MACBETH","OTHELLO","TEMPEST"]},"COMMON MAMMALS":{"level":2,"members":["DOLPHIN","ELEPHANT","KANGAROO","RACCOON"]},"UNUSUAL PHOBIAS":{"level":3,"members":["ARACHNOPHOBIA","CLAUSTROPHOBIA","GERASCOPHOBIA","TRICHOPHOBIA"]}},"startingGroups":[["CERIUM","HAMLET","DOLPHIN","ARACHNOPHOBIA"],["ERBIUM","MACBETH","ELEPHANT","CLAUSTROPHOBIA"],["NEODYMIUM","OTHELLO","KANGAROO","GERASCOPHOBIA"],["THULIUM","TEMPEST","RACCOON","TRICHOPHOBIA"]]},{"groups":{"FAMOUS SCULPTORS":{"level":0,"members":["BRODZKY","DAVID","RODIN","MICHELANGELO"]},"FOOD PREPARATION METHODS":{"level":1,"members":["BAKE","GRILL","SAUTE","STEAM"]},"ARCHITECTURAL STYLES":{"level":2,"members":["GOTHIC","MODERN","NEOCLASSICAL","ROMANESQUE"]},"TYPES OF BIRDS":{"level":3,"members":["EAGLE","HERON","KIWI","SPARROW"]}},"startingGroups":[["BRODZKY","BAKE","GOTHIC","EAGLE"],["DAVID","GRILL","MODERN","HERON"],["RODIN","SAUTE","NEOCLASSICAL","KIWI"],["MICHELANGELO","STEAM","ROMANESQUE","SPARROW"]]},{"groups":{"TYPES OF WINDS":{"level":0,"members":["BREEZE","GUST","MONSOON","ZEPHYR"]},"MAJOR WORLD RIVERS":{"level":1,"members":["AMAZON","GANGES","NILE","VOLGA"]},"SIGNIFICANT ARCHAEOLOGICAL SITES":{"level":2,"members":["POMPEII","PYRAMIDS","STONEHENGE","TROY"]},"GEMS AND PRECIOUS STONES":{"level":3,"members":["DIAMOND","EMERALD","RUBY","SAPPHIRE"]}},"startingGroups":[["BREEZE","AMAZON","POMPEII","DIAMOND"],["GUST","GANGES","PYRAMIDS","EMERALD"],["MONSOON","NILE","STONEHENGE","RUBY"],["ZEPHYR","VOLGA","TROY","SAPPHIRE"]]},{"groups":{"COMMON FRUITS":{"level":0,"members":["APPLE","BANANA","ORANGE","PEAR"]},"FAMOUS PAINTERS":{"level":1,"members":["MONET","PICASSO","REMBRANDT","VANGOGH"]},"SYNONYMS FOR BEAUTIFUL":{"level":2,"members":["ALLURING","EXQUISITE","GORGEOUS","RADIANT"]},"GREEK PHILOSOPHERS":{"level":3,"members":["ARISTOTLE","HERACLITUS","PLATO","SOPHOCLES"]}},"startingGroups":[["APPLE","MONET","ALLURING","ARISTOTLE"],["BANANA","PICASSO","EXQUISITE","HERACLITUS"],["ORANGE","REMBRANDT","GORGEOUS","PLATO"],["PEAR","VANGOGH","RADIANT","SOPHOCLES"]]},{"groups":{"BASIC COLORS":{"level":0,"members":["BLUE","GREEN","RED","YELLOW"]},"TYPES OF MUSICAL INSTRUMENTS":{"level":1,"members":["CELLO","FLUTE","HARP","VIOLIN"]},"ELEMENTS OF THE PERIODIC TABLE":{"level":2,"members":["HELIUM","MERCURY","OXYGEN","XENON"]},"LATIN PHRASES":{"level":3,"members":["CARPEDIEM","QUOVADIS","VENIVIDIVICI","INCOGNITO"]}},"startingGroups":[["BLUE","CELLO","HELIUM","CARPEDIEM"],["GREEN","FLUTE","MERCURY","QUOVADIS"],["RED","HARP","OXYGEN","VENIVIDIVICI"],["YELLOW","VIOLIN","XENON","INCOGNITO"]]},{"groups":{"COLORS":{"level":0,"members":["BLUE","GREEN","RED","YELLOW"]},"FAMOUS BRAND LOGOS":{"level":1,"members":["APPLE","STARBUCKS","TARGET","SUBWAY"]},"SYNONYMS FOR FAST":{"level":2,"members":["RAPID","SWIFT","EXPRESS","QUICK"]},"PUBLIC TRANSPORTATION":{"level":3,"members":["BUS","TRAIN","SUBWAY","TRAM"]}},"startingGroups":[["BLUE","APPLE","RAPID","BUS"],["GREEN","STARBUCKS","SWIFT","TRAIN"],["RED","TARGET","EXPRESS","SUBWAY"],["YELLOW","SUBWAY","QUICK","TRAM"]]},{"groups":{"TYPES OF DANCES":{"level":0,"members":["WALTZ","TANGO","SALSA","JAZZ"]},"MUSICAL TERMS":{"level":1,"members":["NOTE","BEAT","SCALE","JAZZ"]},"TYPES OF SAUCES":{"level":2,"members":["BBQ","SALSA","MAYO","SOY"]},"MEASUREMENT TERMS":{"level":3,"members":["FOOT","MILE","SCALE","YARD"]}},"startingGroups":[["WALTZ","NOTE","BBQ","FOOT"],["TANGO","BEAT","SALSA","MILE"],["SALSA","SCALE","MAYO","SCALE"],["JAZZ","JAZZ","SOY","YARD"]]},{"groups":{"COOKING TERMS":{"level":0,"members":["BAKE","ROAST","GRILL","STEAM"]},"WATER ACTIVITIES":{"level":1,"members":["SWIM","DIVE","SURF","KAYAK"]},"SYNONYMS FOR HOT":{"level":2,"members":["BLAZING","SCORCHING","SEARING","TORRID"]},"SAILING TERMS":{"level":3,"members":["KEEL","MAST","RIG","JIB"]}},"startingGroups":[["BAKE","SWIM","BLAZING","KEEL"],["ROAST","DIVE","SCORCHING","MAST"],["GRILL","SURF","SEARING","RIG"],["STEAM","KAYAK","TORRID","JIB"]]},{"groups":{"ZOO ANIMALS":{"level":0,"members":["GIRAFFE","ELEPHANT","ZEBRA","BEAR"]},"CAR BRANDS":{"level":1,"members":["FORD","SUBARU","FIAT","JAGUAR"]},"BIG FIVE GAME ANIMALS":{"level":2,"members":["LEOPARD","RHINO","BUFFALO","LION"]},"TECH COMPANIES":{"level":3,"members":["APPLE","GOOGLE","MICROSOFT","INTEL"]}},"startingGroups":[["GIRAFFE","FORD","LEOPARD","APPLE"],["ELEPHANT","SUBARU","RHINO","GOOGLE"],["ZEBRA","FIAT","BUFFALO","MICROSOFT"],["BEAR","JAGUAR","LION","INTEL"]]},{"groups":{"COLORS":{"level":0,"members":["RED","BLUE","GREEN","BLACK"]},"UNITS OF TIME":{"level":1,"members":["SECOND","MINUTE","HOUR","DAY"]},"MUSICAL INSTRUMENTS":{"level":2,"members":["FLUTE","DRUM","HARP","BELL"]},"FAMOUS BRANDS":{"level":3,"members":["APPLE","AMAZON","NIKE","DISNEY"]}},"startingGroups":[["RED","SECOND","FLUTE","APPLE"],["BLUE","MINUTE","DRUM","AMAZON"],["GREEN","HOUR","HARP","NIKE"],["BLACK","DAY","BELL","DISNEY"]]},{"groups":{"US STATES":{"level":0,"members":["TEXAS","ALASKA","FLORIDA","OHIO"]},"TYPES OF LIQUID":{"level":1,"members":["WATER","JUICE","OIL","MILK"]},"MATHEMATICAL TERMS":{"level":2,"members":["ANGLE","RADIUS","VOLUME","LENGTH"]},"FAMOUS AUTHORS":{"level":3,"members":["ORWELL","HEMINGWAY","AUSTEN","DICKENS"]}},"startingGroups":[["TEXAS","WATER","ANGLE","ORWELL"],["ALASKA","JUICE","RADIUS","HEMINGWAY"],["FLORIDA","OIL","VOLUME","AUSTEN"],["OHIO","MILK","LENGTH","DICKENS"]]},{"groups":{"CAR BRANDS":{"level":0,"members":["AUDI","TOYOTA","HYUNDAI","FORD"]},"ANIMALS":{"level":1,"members":["BEAR","EAGLE","FOX","JAGUAR"]},"APPLE PRODUCTS":{"level":2,"members":["IPHONE","MACBOOK","IPAD","AIRPODS"]},"TELEVISION NETWORKS":{"level":3,"members":["HBO","NBC","CBS","FOX"]}},"startingGroups":[["AUDI","BEAR","IPHONE","HBO"],["TOYOTA","EAGLE","MACBOOK","NBC"],["HYUNDAI","FOX","IPAD","CBS"],["FORD","JAGUAR","AIRPODS","FOX"]]},{"groups":{"COUNTRIES":{"level":0,"members":["FRANCE","BRAZIL","CHINA","CANADA"]},"COFFEE TYPES":{"level":1,"members":["ESPRESSO","LATTE","AMERICANO","CAPPUCINO"]},"ZODIAC SIGNS":{"level":2,"members":["ARIES","LEO","CANCER","CAPRICORN"]},"FAMOUS PAINTERS":{"level":3,"members":["MONET","PICASSO","DAVINCI","VANGOGH"]}},"startingGroups":[["FRANCE","ESPRESSO","ARIES","MONET"],["BRAZIL","LATTE","LEO","PICASSO"],["CHINA","AMERICANO","CANCER","DAVINCI"],["CANADA","CAPPUCINO","CAPRICORN","VANGOGH"]]},{"groups":{"SPORTS":{"level":0,"members":["BASEBALL","TENNIS","BASKETBALL","SOCCER"]},"CHESS PIECES":{"level":1,"members":["KING","QUEEN","BISHOP","KNIGHT"]},"MUSIC INSTRUMENTS":{"level":2,"members":["GUITAR","PIANO","DRUM","FLUTE"]},"VIDEO GAME TITLES":{"level":3,"members":["HALO","ZELDA","PACMAN","TETRIS"]}},"startingGroups":[["BASEBALL","KING","GUITAR","HALO"],["TENNIS","QUEEN","PIANO","ZELDA"],["BASKETBALL","BISHOP","DRUM","PACMAN"],["SOCCER","KNIGHT","FLUTE","TETRIS"]]},{"groups":{"COUNTRIES IN ASIA":{"level":0,"members":["CHINA","JAPAN","INDIA","THAILAND"]},"FAMOUS SCI-FI MOVIES":{"level":1,"members":["ALIEN","BLADE","MATRIX","INCEPTION"]},"TYPES OF FLOWERS":{"level":2,"members":["ROSE","TULIP","DAISY","LILY"]},"CAPITAL CITIES":{"level":3,"members":["LONDON","PARIS","ROME","BERLIN"]}},"startingGroups":[["CHINA","ALIEN","ROSE","LONDON"],["JAPAN","BLADE","TULIP","PARIS"],["INDIA","MATRIX","DAISY","ROME"],["THAILAND","INCEPTION","LILY","BERLIN"]]},{"groups":{"EUROPEAN CITIES":{"level":0,"members":["LONDON","PARIS","ROME","BERLIN"]},"FAMOUS BRANDS":{"level":1,"members":["APPLE","NIKE","GUCCI","TESLA"]},"PLANETS IN OUR SOLAR SYSTEM":{"level":2,"members":["MARS","VENUS","EARTH","JUPITER"]},"WORLD LEADERS":{"level":3,"members":["PUTIN","MACRON","BIDEN","MERKEL"]}},"startingGroups":[["LONDON","APPLE","MARS","PUTIN"],["PARIS","NIKE","VENUS","MACRON"],["ROME","GUCCI","EARTH","BIDEN"],["BERLIN","TESLA","JUPITER","MERKEL"]]},{"groups":{"CHEMICAL ELEMENTS":{"level":0,"members":["HYDROGEN","OXYGEN","IRON","SILICON"]},"FAMOUS AUTHORS":{"level":1,"members":["ORWELL","DICKENS","HEMINGWAY","SHAKESPEARE"]},"MUSIC GENRES":{"level":2,"members":["ROCK","JAZZ","POP","CLASSICAL"]},"FAMOUS PAINTERS":{"level":3,"members":["VANGOGH","PICASSO","REMBRANDT","MONET"]}},"startingGroups":[["HYDROGEN","ORWELL","ROCK","VANGOGH"],["OXYGEN","DICKENS","JAZZ","PICASSO"],["IRON","HEMINGWAY","POP","REMBRANDT"],["SILICON","SHAKESPEARE","CLASSICAL","MONET"]]},{"groups":{"FAMOUS DIRECTORS":{"level":0,"members":["TARANTINO","SPIELBERG","HITCHCOCK","KUBRICK"]},"RIVER SYSTEMS":{"level":1,"members":["AMAZON","NILE","YANGTZE","MISSISSIPPI"]},"CLASSICAL COMPOSERS":{"level":2,"members":["MOZART","BACH","BEETHOVEN","VIVALDI"]},"TECHNOLOGICAL INNOVATIONS":{"level":3,"members":["INTERNET","SMARTPHONE","ROBOTICS","AI"]}},"startingGroups":[["TARANTINO","AMAZON","MOZART","INTERNET"],["SPIELBERG","NILE","BACH","SMARTPHONE"],["HITCHCOCK","YANGTZE","BEETHOVEN","ROBOTICS"],["KUBRICK","MISSISSIPPI","VIVALDI","AI"]]},{"groups":{"EPIC POEMS":{"level":0,"members":["ILIAD","ODYSSEY","BEOWULF","AENEID"]},"ART MOVEMENTS":{"level":1,"members":["IMPRESSIONISM","CUBISM","SURREALISM","BAROQUE"]},"LINGUISTIC CONCEPTS":{"level":2,"members":["MORPHEME","SYNTAX","PHONEME","SEMANTICS"]},"INVENTORS AND SCIENTISTS":{"level":3,"members":["TESLA","EINSTEIN","CURIE","NEWTON"]}},"startingGroups":[["ILIAD","IMPRESSIONISM","MORPHEME","TESLA"],["ODYSSEY","CUBISM","SYNTAX","EINSTEIN"],["BEOWULF","SURREALISM","PHONEME","CURIE"],["AENEID","BAROQUE","SEMANTICS","NEWTON"]]},{"groups":{"POETIC FORMS":{"level":0,"members":["SONNET","HAIKU","EPIC","LIMERICK"]},"RENEWABLE ENERGY SOURCES":{"level":1,"members":["SOLAR","WIND","HYDRO","GEOTHERMAL"]},"ANCIENT CITIES":{"level":2,"members":["PETRA","MACHU PICCHU","POMPEII","TROY"]},"OBSCURE MUSICAL INSTRUMENTS":{"level":3,"members":["HURDY-GURDY","THEREMIN","ZITHER","SHENG"]}},"startingGroups":[["SONNET","SOLAR","PETRA","HURDY-GURDY"],["HAIKU","WIND","MACHU PICCHU","THEREMIN"],["EPIC","HYDRO","POMPEII","ZITHER"],["LIMERICK","GEOTHERMAL","TROY","SHENG"]]}]'),
				E = n(7),
				m = n.n(E),
				p = n(475),
				S = n.n(p),
				A = n(77),
				O = n.n(A),
				R = n(725),
				T = n.n(R),
				N = "bodyAttributes",
				I = "htmlAttributes",
				v = "titleAttributes",
				h = {
					BASE: "base",
					BODY: "body",
					HEAD: "head",
					HTML: "html",
					LINK: "link",
					META: "meta",
					NOSCRIPT: "noscript",
					SCRIPT: "script",
					STYLE: "style",
					TITLE: "title"
				},
				g = (Object.keys(h).map((function(e) {
					return h[e]
				})), "charset"),
				b = "cssText",
				C = "href",
				L = "http-equiv",
				y = "innerHTML",
				P = "itemprop",
				M = "name",
				U = "property",
				D = "rel",
				H = "src",
				w = "target",
				G = {
					accesskey: "accessKey",
					charset: "charSet",
					class: "className",
					contenteditable: "contentEditable",
					contextmenu: "contextMenu",
					"http-equiv": "httpEquiv",
					itemprop: "itemProp",
					tabindex: "tabIndex"
				},
				k = "defaultTitle",
				B = "defer",
				x = "encodeSpecialCharacters",
				F = "onChangeClientState",
				Y = "titleTemplate",
				_ = Object.keys(G).reduce((function(e, t) {
					return e[G[t]] = t, e
				}), {}),
				K = [h.NOSCRIPT, h.SCRIPT, h.STYLE],
				W = "data-react-helmet",
				j = "function" === typeof Symbol && "symbol" === typeof Symbol.iterator ? function(e) {
					return typeof e
				} : function(e) {
					return e && "function" === typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
				},
				V = function() {
					function e(e, t) {
						for (var n = 0; n < t.length; n++) {
							var r = t[n];
							r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(e, r.key, r)
						}
					}
					return function(t, n, r) {
						return n && e(t.prototype, n), r && e(t, r), t
					}
				}(),
				z = Object.assign || function(e) {
					for (var t = 1; t < arguments.length; t++) {
						var n = arguments[t];
						for (var r in n) Object.prototype.hasOwnProperty.call(n, r) && (e[r] = n[r])
					}
					return e
				},
				Q = function(e, t) {
					var n = {};
					for (var r in e) t.indexOf(r) >= 0 || Object.prototype.hasOwnProperty.call(e, r) && (n[r] = e[r]);
					return n
				},
				J = function(e) {
					return !1 === (!(arguments.length > 1 && void 0 !== arguments[1]) || arguments[1]) ? String(e) : String(e).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#x27;")
				},
				Z = function(e) {
					var t = te(e, h.TITLE),
						n = te(e, Y);
					if (n && t) return n.replace(/%s/g, (function() {
						return Array.isArray(t) ? t.join("") : t
					}));
					var r = te(e, k);
					return t || r || void 0
				},
				$ = function(e) {
					return te(e, F) || function() {}
				},
				X = function(e, t) {
					return t.filter((function(t) {
						return "undefined" !== typeof t[e]
					})).map((function(t) {
						return t[e]
					})).reduce((function(e, t) {
						return z({}, e, t)
					}), {})
				},
				q = function(e, t) {
					return t.filter((function(e) {
						return "undefined" !== typeof e[h.BASE]
					})).map((function(e) {
						return e[h.BASE]
					})).reverse().reduce((function(t, n) {
						if (!t.length)
							for (var r = Object.keys(n), l = 0; l < r.length; l++) {
								var a = r[l].toLowerCase();
								if (-1 !== e.indexOf(a) && n[a]) return t.concat(n)
							}
						return t
					}), [])
				},
				ee = function(e, t, n) {
					var r = {};
					return n.filter((function(t) {
						return !!Array.isArray(t[e]) || ("undefined" !== typeof t[e] && oe("Helmet: " + e + ' should be of type "Array". Instead found type "' + j(t[e]) + '"'), !1)
					})).map((function(t) {
						return t[e]
					})).reverse().reduce((function(e, n) {
						var l = {};
						n.filter((function(e) {
							for (var n = void 0, a = Object.keys(e), o = 0; o < a.length; o++) {
								var i = a[o],
									u = i.toLowerCase(); - 1 === t.indexOf(u) || n === D && "canonical" === e[n].toLowerCase() || u === D && "stylesheet" === e[u].toLowerCase() || (n = u), -1 === t.indexOf(i) || i !== y && i !== b && i !== P || (n = i)
							}
							if (!n || !e[n]) return !1;
							var s = e[n].toLowerCase();
							return r[n] || (r[n] = {}), l[n] || (l[n] = {}), !r[n][s] && (l[n][s] = !0, !0)
						})).reverse().forEach((function(t) {
							return e.push(t)
						}));
						for (var a = Object.keys(l), o = 0; o < a.length; o++) {
							var i = a[o],
								u = T()({}, r[i], l[i]);
							r[i] = u
						}
						return e
					}), []).reverse()
				},
				te = function(e, t) {
					for (var n = e.length - 1; n >= 0; n--) {
						var r = e[n];
						if (r.hasOwnProperty(t)) return r[t]
					}
					return null
				},
				ne = function() {
					var e = Date.now();
					return function(t) {
						var n = Date.now();
						n - e > 16 ? (e = n, t(n)) : setTimeout((function() {
							ne(t)
						}), 0)
					}
				}(),
				re = function(e) {
					return clearTimeout(e)
				},
				le = "undefined" !== typeof window ? window.requestAnimationFrame && window.requestAnimationFrame.bind(window) || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || ne : n.g.requestAnimationFrame || ne,
				ae = "undefined" !== typeof window ? window.cancelAnimationFrame || window.webkitCancelAnimationFrame || window.mozCancelAnimationFrame || re : n.g.cancelAnimationFrame || re,
				oe = function(e) {
					return console && "function" === typeof console.warn && console.warn(e)
				},
				ie = null,
				ue = function(e, t) {
					var n = e.baseTag,
						r = e.bodyAttributes,
						l = e.htmlAttributes,
						a = e.linkTags,
						o = e.metaTags,
						i = e.noscriptTags,
						u = e.onChangeClientState,
						s = e.scriptTags,
						c = e.styleTags,
						f = e.title,
						d = e.titleAttributes;
					fe(h.BODY, r), fe(h.HTML, l), ce(f, d);
					var E = {
							baseTag: de(h.BASE, n),
							linkTags: de(h.LINK, a),
							metaTags: de(h.META, o),
							noscriptTags: de(h.NOSCRIPT, i),
							scriptTags: de(h.SCRIPT, s),
							styleTags: de(h.STYLE, c)
						},
						m = {},
						p = {};
					Object.keys(E).forEach((function(e) {
						var t = E[e],
							n = t.newTags,
							r = t.oldTags;
						n.length && (m[e] = n), r.length && (p[e] = E[e].oldTags)
					})), t && t(), u(e, m, p)
				},
				se = function(e) {
					return Array.isArray(e) ? e.join("") : e
				},
				ce = function(e, t) {
					"undefined" !== typeof e && document.title !== e && (document.title = se(e)), fe(h.TITLE, t)
				},
				fe = function(e, t) {
					var n = document.getElementsByTagName(e)[0];
					if (n) {
						for (var r = n.getAttribute(W), l = r ? r.split(",") : [], a = [].concat(l), o = Object.keys(t), i = 0; i < o.length; i++) {
							var u = o[i],
								s = t[u] || "";
							n.getAttribute(u) !== s && n.setAttribute(u, s), -1 === l.indexOf(u) && l.push(u);
							var c = a.indexOf(u); - 1 !== c && a.splice(c, 1)
						}
						for (var f = a.length - 1; f >= 0; f--) n.removeAttribute(a[f]);
						l.length === a.length ? n.removeAttribute(W) : n.getAttribute(W) !== o.join(",") && n.setAttribute(W, o.join(","))
					}
				},
				de = function(e, t) {
					var n = document.head || document.querySelector(h.HEAD),
						r = n.querySelectorAll(e + "[" + W + "]"),
						l = Array.prototype.slice.call(r),
						a = [],
						o = void 0;
					return t && t.length && t.forEach((function(t) {
						var n = document.createElement(e);
						for (var r in t)
							if (t.hasOwnProperty(r))
								if (r === y) n.innerHTML = t.innerHTML;
								else if (r === b) n.styleSheet ? n.styleSheet.cssText = t.cssText : n.appendChild(document.createTextNode(t.cssText));
						else {
							var i = "undefined" === typeof t[r] ? "" : t[r];
							n.setAttribute(r, i)
						}
						n.setAttribute(W, "true"), l.some((function(e, t) {
							return o = t, n.isEqualNode(e)
						})) ? l.splice(o, 1) : a.push(n)
					})), l.forEach((function(e) {
						return e.parentNode.removeChild(e)
					})), a.forEach((function(e) {
						return n.appendChild(e)
					})), {
						oldTags: l,
						newTags: a
					}
				},
				Ee = function(e) {
					return Object.keys(e).reduce((function(t, n) {
						var r = "undefined" !== typeof e[n] ? n + '="' + e[n] + '"' : "" + n;
						return t ? t + " " + r : r
					}), "")
				},
				me = function(e) {
					var t = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {};
					return Object.keys(e).reduce((function(t, n) {
						return t[G[n] || n] = e[n], t
					}), t)
				},
				pe = function(t, n, r) {
					switch (t) {
						case h.TITLE:
							return {
								toComponent: function() {
									return function(t, n, r) {
										var l, a = ((l = {
												key: n
											})[W] = !0, l),
											o = me(r, a);
										return [e.createElement(h.TITLE, o, n)]
									}(0, n.title, n.titleAttributes)
								},
								toString: function() {
									return function(e, t, n, r) {
										var l = Ee(n),
											a = se(t);
										return l ? "<" + e + " " + W + '="true" ' + l + ">" + J(a, r) + "</" + e + ">" : "<" + e + " " + W + '="true">' + J(a, r) + "</" + e + ">"
									}(t, n.title, n.titleAttributes, r)
								}
							};
						case N:
						case I:
							return {
								toComponent: function() {
									return me(n)
								},
								toString: function() {
									return Ee(n)
								}
							};
						default:
							return {
								toComponent: function() {
									return function(t, n) {
										return n.map((function(n, r) {
											var l, a = ((l = {
												key: r
											})[W] = !0, l);
											return Object.keys(n).forEach((function(e) {
												var t = G[e] || e;
												if (t === y || t === b) {
													var r = n.innerHTML || n.cssText;
													a.dangerouslySetInnerHTML = {
														__html: r
													}
												} else a[t] = n[e]
											})), e.createElement(t, a)
										}))
									}(t, n)
								},
								toString: function() {
									return function(e, t, n) {
										return t.reduce((function(t, r) {
											var l = Object.keys(r).filter((function(e) {
													return !(e === y || e === b)
												})).reduce((function(e, t) {
													var l = "undefined" === typeof r[t] ? t : t + '="' + J(r[t], n) + '"';
													return e ? e + " " + l : l
												}), ""),
												a = r.innerHTML || r.cssText || "",
												o = -1 === K.indexOf(e);
											return t + "<" + e + " " + W + '="true" ' + l + (o ? "/>" : ">" + a + "</" + e + ">")
										}), "")
									}(t, n, r)
								}
							}
					}
				},
				Se = function(e) {
					var t = e.baseTag,
						n = e.bodyAttributes,
						r = e.encode,
						l = e.htmlAttributes,
						a = e.linkTags,
						o = e.metaTags,
						i = e.noscriptTags,
						u = e.scriptTags,
						s = e.styleTags,
						c = e.title,
						f = void 0 === c ? "" : c,
						d = e.titleAttributes;
					return {
						base: pe(h.BASE, t, r),
						bodyAttributes: pe(N, n, r),
						htmlAttributes: pe(I, l, r),
						link: pe(h.LINK, a, r),
						meta: pe(h.META, o, r),
						noscript: pe(h.NOSCRIPT, i, r),
						script: pe(h.SCRIPT, u, r),
						style: pe(h.STYLE, s, r),
						title: pe(h.TITLE, {
							title: f,
							titleAttributes: d
						}, r)
					}
				},
				Ae = function(t) {
					var n, r;
					return r = n = function(n) {
						function r() {
							return function(e, t) {
									if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
								}(this, r),
								function(e, t) {
									if (!e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
									return !t || "object" !== typeof t && "function" !== typeof t ? e : t
								}(this, n.apply(this, arguments))
						}
						return function(e, t) {
							if ("function" !== typeof t && null !== t) throw new TypeError("Super expression must either be null or a function, not " + typeof t);
							e.prototype = Object.create(t && t.prototype, {
								constructor: {
									value: e,
									enumerable: !1,
									writable: !0,
									configurable: !0
								}
							}), t && (Object.setPrototypeOf ? Object.setPrototypeOf(e, t) : e.__proto__ = t)
						}(r, n), r.prototype.shouldComponentUpdate = function(e) {
							return !O()(this.props, e)
						}, r.prototype.mapNestedChildrenToProps = function(e, t) {
							if (!t) return null;
							switch (e.type) {
								case h.SCRIPT:
								case h.NOSCRIPT:
									return {
										innerHTML: t
									};
								case h.STYLE:
									return {
										cssText: t
									}
							}
							throw new Error("<" + e.type + " /> elements are self-closing and can not contain children. Refer to our API for more information.")
						}, r.prototype.flattenArrayTypeChildren = function(e) {
							var t, n = e.child,
								r = e.arrayTypeChildren,
								l = e.newChildProps,
								a = e.nestedChildren;
							return z({}, r, ((t = {})[n.type] = [].concat(r[n.type] || [], [z({}, l, this.mapNestedChildrenToProps(n, a))]), t))
						}, r.prototype.mapObjectTypeChildren = function(e) {
							var t, n, r = e.child,
								l = e.newProps,
								a = e.newChildProps,
								o = e.nestedChildren;
							switch (r.type) {
								case h.TITLE:
									return z({}, l, ((t = {})[r.type] = o, t.titleAttributes = z({}, a), t));
								case h.BODY:
									return z({}, l, {
										bodyAttributes: z({}, a)
									});
								case h.HTML:
									return z({}, l, {
										htmlAttributes: z({}, a)
									})
							}
							return z({}, l, ((n = {})[r.type] = z({}, a), n))
						}, r.prototype.mapArrayTypeChildrenToProps = function(e, t) {
							var n = z({}, t);
							return Object.keys(e).forEach((function(t) {
								var r;
								n = z({}, n, ((r = {})[t] = e[t], r))
							})), n
						}, r.prototype.warnOnInvalidChildren = function(e, t) {
							return !0
						}, r.prototype.mapChildrenToProps = function(t, n) {
							var r = this,
								l = {};
							return e.Children.forEach(t, (function(e) {
								if (e && e.props) {
									var t = e.props,
										a = t.children,
										o = function(e) {
											var t = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {};
											return Object.keys(e).reduce((function(t, n) {
												return t[_[n] || n] = e[n], t
											}), t)
										}(Q(t, ["children"]));
									switch (r.warnOnInvalidChildren(e, a), e.type) {
										case h.LINK:
										case h.META:
										case h.NOSCRIPT:
										case h.SCRIPT:
										case h.STYLE:
											l = r.flattenArrayTypeChildren({
												child: e,
												arrayTypeChildren: l,
												newChildProps: o,
												nestedChildren: a
											});
											break;
										default:
											n = r.mapObjectTypeChildren({
												child: e,
												newProps: n,
												newChildProps: o,
												nestedChildren: a
											})
									}
								}
							})), n = this.mapArrayTypeChildrenToProps(l, n)
						}, r.prototype.render = function() {
							var n = this.props,
								r = n.children,
								l = Q(n, ["children"]),
								a = z({}, l);
							return r && (a = this.mapChildrenToProps(r, a)), e.createElement(t, a)
						}, V(r, null, [{
							key: "canUseDOM",
							set: function(e) {
								t.canUseDOM = e
							}
						}]), r
					}(e.Component), n.propTypes = {
						base: m().object,
						bodyAttributes: m().object,
						children: m().oneOfType([m().arrayOf(m().node), m().node]),
						defaultTitle: m().string,
						defer: m().bool,
						encodeSpecialCharacters: m().bool,
						htmlAttributes: m().object,
						link: m().arrayOf(m().object),
						meta: m().arrayOf(m().object),
						noscript: m().arrayOf(m().object),
						onChangeClientState: m().func,
						script: m().arrayOf(m().object),
						style: m().arrayOf(m().object),
						title: m().string,
						titleAttributes: m().object,
						titleTemplate: m().string
					}, n.defaultProps = {
						defer: !0,
						encodeSpecialCharacters: !0
					}, n.peek = t.peek, n.rewind = function() {
						var e = t.rewind();
						return e || (e = Se({
							baseTag: [],
							bodyAttributes: {},
							encodeSpecialCharacters: !0,
							htmlAttributes: {},
							linkTags: [],
							metaTags: [],
							noscriptTags: [],
							scriptTags: [],
							styleTags: [],
							title: "",
							titleAttributes: {}
						})), e
					}, r
				}(S()((function(e) {
					return {
						baseTag: q([C, w], e),
						bodyAttributes: X(N, e),
						defer: te(e, B),
						encode: te(e, x),
						htmlAttributes: X(I, e),
						linkTags: ee(h.LINK, [D, C], e),
						metaTags: ee(h.META, [M, g, L, U, P], e),
						noscriptTags: ee(h.NOSCRIPT, [y], e),
						onChangeClientState: $(e),
						scriptTags: ee(h.SCRIPT, [H, y], e),
						styleTags: ee(h.STYLE, [b], e),
						title: Z(e),
						titleAttributes: X(v, e)
					}
				}), (function(e) {
					ie && ae(ie), e.defer ? ie = le((function() {
						ue(e, (function() {
							ie = null
						}))
					})) : (ue(e), ie = null)
				}), Se)((function() {
					return null
				})));
			Ae.renderStatic = Ae.rewind;
			var Oe = n(699),
				Re = n.n(Oe),
				Te = n(184);

			function Ne(e, t) {
				for (var n = [], r = 0; r < e.length; r += t) n.push(e.slice(r, r + t));
				return n
			}
			var Ie = function() {
				var t = f((0, e.useState)([]), 2),
					n = (t[0], t[1]),
					r = f((0, e.useState)("Medium"), 2),
					l = r[0],
					o = r[1],
					u = f((0, e.useState)([]), 2),
					s = u[0],
					E = u[1],
					m = f((0, e.useState)(null), 2),
					p = m[0],
					S = m[1],
					A = f((0, e.useState)([]), 2),
					O = A[0],
					R = A[1],
					T = f((0, e.useState)({}), 2),
					N = T[0],
					I = T[1],
					v = f((0, e.useState)(4), 2),
					h = v[0],
					g = v[1],
					b = f((0, e.useState)(""), 2),
					C = b[0],
					L = b[1],
					y = f((0, e.useState)(null), 2),
					P = y[0],
					M = y[1],
					U = f((0, e.useState)([]), 2),
					D = U[0],
					H = U[1],
					w = f((0, e.useState)(!1), 2),
					G = w[0],
					k = w[1],
					B = f((0, e.useState)(null), 2),
					x = B[0],
					F = B[1],
					Y = f((0, e.useState)(0), 2),
					_ = Y[0],
					K = Y[1],
					W = f((0, e.useState)([]), 2),
					j = W[0],
					V = W[1],
					z = f((0, e.useState)(!1), 2),
					Q = z[0],
					J = z[1],
					Z = ["#fbd400", "#b5e352", "#729eeb", "#bc70c4"],
					$ = ["\ud83d\udd35", "\ud83d\udfe2", "\ud83d\udfe1", "\ud83d\udd34", "\ud83d\udfe3"];
				(0, e.useEffect)((function() {
					K(0);
					var e = setInterval((function() {
						K((function(e) {
							return e + 1
						}))
					}), 1e3);
					return function() {
						return clearInterval(e)
					}
				}), [x]), (0, e.useEffect)((function() {
					var e;
					n(d), K(0), E(c(Array(d.length).keys()));
					var t = new URLSearchParams(window.location.search),
						r = t.get("gameId"),
						l = t.get("archive");
					F(r);
					var u = t.get("difficulty") || "Medium";
					if (o(u), r) {
						var s = function(e, t) {
							var n, r = Re()(e),
								l = {
									groups: {},
									startingGroups: [
										[],
										[],
										[],
										[]
									]
								},
								o = new Set;
							switch (t) {
								case "Easy":
									n = [0, 1];
									break;
								case "Hard":
									n = [2, 3];
									break;
								default:
									n = [0, 1, 2, 3]
							}
							"Easy" !== t && "Hard" !== t || (n = [].concat(c(n), c(n))), "Medium" === t && (n = n.sort((function() {
								return .5 - r()
							})));
							for (var u = 0; u < 4; u++) {
								var s = void 0,
									f = void 0,
									E = void 0;
								do {
									do {
										s = Math.floor(r() * d.length)
									} while (s === e);
									f = d[s];
									for (var m = 0, p = Object.keys(f.groups); m < p.length; m++) {
										var S = p[m];
										if (f.groups[S].level === n[u] && !f.groups[S].members.some((function(e) {
												return o.has(e)
											}))) {
											E = S;
											break
										}
									}
								} while (!E);
								l.groups = i(i({}, l.groups), {}, a({}, E, f.groups[E])), f.groups[E].members.forEach((function(e, t) {
									var n;
									o.add(e);
									do {
										n = Math.floor(4 * r())
									} while (4 === l.startingGroups[n].length);
									l.startingGroups[n].push(e)
								}))
							}
							return l
						}(e = r, u);
						S(s)
					} else l ? (F(1), J(!0), e = q(l) % d.length) : e = q() % d.length, S(d[e]);
					E((function(t) {
						return t.filter((function(t) {
							return t !== e
						}))
					})), V([])
				}), [x]);
				var X = function(e) {
					var t = Math.floor(Math.random() * s.length),
						n = s[t];
					x && (n = x), window.location.href = window.location.origin + "?gameId=" + n + "&difficulty=" + e
				};

				function q(e) {
					var t = new Date("6/12/2023"),
						n = !1,
						r = new Date;
					if (r.setHours(0, 0, 0, 0), e) {
						var l = new Date(e);
						l.setHours(0, 0, 0, 0), n = l.getTime() > r.getTime() ? r - t.setHours(0, 0, 0, 0) : l - t.setHours(0, 0, 0, 0)
					} else n = r - t.setHours(0, 0, 0, 0);
					var a = Math.round(n / 864e5);
					return a < 0 ? Math.abs(a) : a
				}
				var ee = function() {
						if (0 !== s.length) {
							var e = Math.floor(500 * Math.random());
							window.location.href = window.location.origin + "?gameId=" + e
						} else L("No more games left!")
					},
					te = function(e, t) {
						for (var n = new Date(e), r = new Date(t), l = []; n <= r;) l.push(new Date(n)), n.setDate(n.getDate() + 1);
						return l.reverse()
					}("6/12/2023", new Date);
				return (0, Te.jsxs)(Te.Fragment, {
					children: [(0, Te.jsx), (0, Te.jsx), (0, Te.jsxs)("div", {
						className: "game-container",
						children: [x && (0, Te.jsx)(Ae, {
							children: (0, Te.jsx)("meta", {
								name: "robots",
								content: "noindex"
							})
						}), (0, Te.jsx)(Ae, {
							children: (0, Te.jsx)("script", {
								type: "application/ld+json",
								children: '\n      {\n        "@context": "https://schema.org",\n        "@graph": [\n          {\n            "@type": "Organization",\n            "@id": "https://connectionsgame.com/#organization",\n            "name": "Connections Unlimited",\n            "url": "https://www.connectionsgame.com/",\n            "sameAs": []\n          },\n          {\n            "@type": "WebSite",\n            "@id": "https://connectionsgame.com/#website",\n            "url": "https://connectionsgame.com/",\n            "name": "Connections Unlimited",\n            "publisher": {\n              "@id": "https://connectionsgame.com/#organization"\n            }\n          }\n        ]\n      }\n    '
							})
						}), Object.entries(N).map((function(e, t) {
							var n = f(e, 2),
								r = n[0],
								l = n[1];
							return (0, Te.jsxs)("div", {
								className: "game-group",
								style: {
									backgroundColor: Z[t % Z.length]
								},
								children: [(0, Te.jsx)("h3", {
									className: "group-name",
									children: r
								}), (0, Te.jsx)("div", {
									className: "group-members",
									children: l.join(", ")
								})]
							}, r)
						})), (0, Te.jsxs)("div", {
							className: "top-g",
							children: [(0, Te.jsxs), (0, Te.jsxs)("div", {
								className: "game-time",
								children: ["Time: ", "".concat(Math.floor(_ / 60).toString().padStart(2, "0"), ":").concat((_ % 60).toString().padStart(2, "0"))]
							})]
						}), p && p.startingGroups.map((function(e, t) {
							return (0, Te.jsx)("div", {
								className: "game-board",
								children: e.map((function(e, t) {
									return (0, Te.jsx)("button", {
										className: "game-item \n              ".concat(O.includes(e) ? "selected" : "", " \n              ").concat(D.includes(e) ? "".concat(P, "-animation") : "", " \n              ").concat(8 === e.length ? "size-8" : "", " \n              ").concat(e.length > 8 ? "size-more" : ""),
										onClick: function() {
											return function(e) {
												if (O.includes(e)) R(O.filter((function(t) {
													return t !== e
												})));
												else {
													if (!(O.length < 4)) return;
													R([].concat(c(O), [e]))
												}
											}(e)
										},
										children: e || " "
									}, t)
								}))
							}, t)
						})), C && (0, Te.jsx)("div", {
							className: "message",
							children: C
						}), (0, Te.jsxs)("div", {
							className: "game-attempts",
							children: ["Mistakes remaining: ", h]
						}), G ? (0, Te.jsxs)(Te.Fragment, {
							children: [(0, Te.jsx)("button", {
								className: "game-btn",
								onClick: function() {
									window.location.reload()
								},
								children: "Restart the same Game"
							}), (0, Te.jsx)("button", {
								className: "game-btn",
								onClick: ee,
								children: "Start New Game"
							})]
						}) : (0, Te.jsxs)(Te.Fragment, {
							children: [p && Object.keys(N).length === Object.keys(p.groups).length ? (0, Te.jsxs)(Te.Fragment, {
								children: [(0, Te.jsxs)("div", {
									className: "congratulations",
									children: [(0, Te.jsx)("h2", {
										children: "Congratulations!"
									}), (0, Te.jsx)("p", {
										children: "You have found all groups!"
									}), (0, Te.jsx)("div", {
										className: "share",
										children: j.map((function(e, t) {
											return (0, Te.jsx)("div", {
												className: "share-row",
												children: e.map((function(e, t) {
													return (0, Te.jsx)("span", {
														style: {
															backgroundColor: Z[e.level]
														}
													}, t)
												}))
											}, t)
										}))
									}), (0, Te.jsx)("button", {
										className: "game-btn",
										style: {
											backgroundColor: "#000000",
											color: "#fff",
											marginTop: "10px"
										},
										onClick: function() {
											var e = j.map((function(e, t) {
												return e.map((function(e) {
													return "".concat($[e.level])
												})).join("")
											})).join("");
											window.focus(), navigator.clipboard.writeText("connectionsgame.com - " + e).then((function() {
												alert("Copied to Clipboard, you can now share the result in social media.")
											}))
										},
										children: "Share Results"
									})]
								}), (0, Te.jsx)("button", {
									className: "game-btn",
									onClick: ee,
									children: "Start New Game"
								})]
							}) : (0, Te.jsxs)("div", {
								className: "btn-wrapper",
								children: [(0, Te.jsx)("button", {
									className: "game-btn submit-btn",
									onClick: function() {
										if (4 === O.length) {
											console.log(p);
											var e = Object.entries(p.groups).find((function(e) {
												var t = f(e, 2),
													n = (t[0], t[1]);
												return JSON.stringify(n.members.sort()) === JSON.stringify(O.sort())
											}));
											if (e) {
												I(i(i({}, N), {}, a({}, e[0], e[1].members)));
												var t = p.startingGroups.flat().filter((function(e) {
													return !O.includes(e)
												}));
												S(i(i({}, p), {}, {
													startingGroups: Ne(t, 4)
												})), L("Congratulations! You have found a group!"), M("success"), H(O), setTimeout((function() {
													R([]), M(null), H([])
												}), 1e3)
											} else M("error"), H(O), setTimeout((function() {
												M(null), H([])
											}), 1e3), L("Incorrect guess, please try again"), g((function(e) {
												return e - 1 === 0 && (k(!0), L("Game Over! All attempts used up!")), e - 1
											}));
											var n = O.map((function(e) {
												var t = Object.keys(p.groups).find((function(t) {
														return p.groups[t].members.includes(e)
													})),
													n = p.groups[t].level;
												return {
													word: e,
													level: n
												}
											}));
											V([].concat(c(j), [n]))
										} else L("You need to select 4 items before submitting")
									},
									children: "Submit"
								}), (0, Te.jsx)("button", {
									className: "game-btn",
									onClick: function() {
										R([])
									},
									children: "Deselect"
								}), (0, Te.jsx)("button", {
									className: "game-btn",
									onClick: ee,
									children: "Start New Game"
								})]
							}), (0, Te.jsxs)("div", {
								className: "difficulty-wrapper",
								children: [(0, Te.jsx)("button", {
									onClick: function() {
										return X("Easy")
									},
									className: "Easy" === l ? "selected" : "",
									children: "Easy"
								}), (0, Te.jsx)("button", {
									onClick: function() {
										return X("Medium")
									},
									className: "Medium" === l ? "selected" : "",
									children: "Medium"
								}), (0, Te.jsx)("button", {
									onClick: function() {
										return X("Hard")
									},
									className: "Hard" === l ? "selected" : "",
									children: "Hard"
								})]
							}), (0, Te.jsx)("div", {
								className: "archive-wrapper",
								children: (0, Te.jsxs)("select", {
									onChange: function(e) {
										return function(e) {
											var t = "".concat(e.getMonth() + 1, "/").concat(e.getDate(), "/").concat(e.getFullYear());
											window.location.href = "".concat(window.location.origin, "?archive=").concat(t)
										}(new Date(e.target.value))
									},
									children: [(0, Te.jsx)("option", {
										value: "",
										children: "--Select an archive date--"
									}, ""), te.map((function(e) {
										var t = "".concat(e.getMonth() + 1, "/").concat(e.getDate(), "/").concat(e.getFullYear());
										return (0, Te.jsx)("option", {
											value: t,
											children: t
										}, t)
									}))]
								})
							})]
						}), (0, Te.jsxs)]
					}), (0, Te.jsx), (0, Te.jsx)]
				})
			};
			var ve = function() {
					return (0, Te.jsx)("div", {
						className: "App",
						children: (0, Te.jsx)(Ie, {})
					})
				},
				he = function(e) {
					e && e instanceof Function && n.e(787).then(n.bind(n, 787)).then((function(t) {
						var n = t.getCLS,
							r = t.getFID,
							l = t.getFCP,
							a = t.getLCP,
							o = t.getTTFB;
						n(e), r(e), l(e), a(e), o(e)
					}))
				};
			t.createRoot(document.getElementById("root")).render((0, Te.jsx)(e.StrictMode, {
				children: (0, Te.jsx)(ve, {})
			})), he()
		}()
}();