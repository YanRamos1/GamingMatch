"use strict";

function _classCallCheck(t, s) { if (!(t instanceof s)) throw new TypeError("Cannot call a class as a function") }

function _defineProperties(t, s) {
    for (var e = 0; e < s.length; e++) {
        var i = s[e];
        i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(t, i.key, i)
    }
}

function _createClass(t, s, e) { return s && _defineProperties(t.prototype, s), e && _defineProperties(t, e), t }
var CONTAINER_CLASS = "toast-container",
    WRAPPER_CLASS = "toast-wrapper",
    BsToast = function() {
        function t(s) {
            var e = s.title,
                i = s.subtitle,
                a = s.content,
                o = s.type,
                n = s.delay,
                c = s.position,
                h = s.img,
                l = s.icon,
                r = s.pause_on_hover,
                d = s.customClass;
            _classCallCheck(this, t), this.id = "toast-" + (document.getElementsByClassName("toast").length + 1), this.title = e || "Notice!", this.subtitle = i || "", this.content = a || "", this.type = o || "info", this.delay = n || -1, this.position = c || "top-right", this.img = h, this.icon = l, this.pause_on_hover = r || !1, this.customClass = d || "", this.pause = !1, this.bg_header_class = "", this.fg_header_class = "", this.fg_subtitle_class = "text-muted", this.fg_dismiss_class = "", this.delay_or_autohide = "", this.setupLayout(), this.createToast()
        }
        return _createClass(t, [{
            key: "setupLayout",
            value: function() {
                if (!document.getElementsByClassName(CONTAINER_CLASS + " " + this.position).length) {
                    var t = document.createElement("div");
                    t.className = CONTAINER_CLASS + " " + this.position, document.body.insertBefore(t, document.body.firstChild)
                }
                if (!document.getElementsByClassName(CONTAINER_CLASS + " " + this.position)[0].hasChildNodes()) {
                    var s = document.createElement("div");
                    s.className = WRAPPER_CLASS, document.getElementsByClassName(CONTAINER_CLASS + " " + this.position)[0].append(s)
                }
            }
        }, {
            key: "createToast",
            value: function() {
                var s = this;
                if (!1 !== this.pause_on_hover) {
                    var e = Math.floor(Date.now() / 1e3) + this.delay / 1e3;
                    this.delay_or_autohide = 'data-autohide="false"', this.pause_on_hover = 'data-hide-timestamp="'.concat(e, '"')
                } else -1 === this.delay ? this.delay_or_autohide = 'data-autohide="false"' : this.delay_or_autohide = 'data-delay="'.concat(this.delay, '"');
                if (!this.customClass) switch (this.type) {
                    case "info":
                        this.bg_header_class = "bg-info", this.fg_header_class = "text-white", this.fg_subtitle_class = "text-white", this.fg_dismiss_class = "text-white";
                        break;
                    case "success":
                        this.bg_header_class = "bg-success", this.fg_header_class = "text-white", this.fg_subtitle_class = "text-white", this.fg_dismiss_class = "text-white";
                        break;
                    case "warning":
                    case "warn":
                        this.bg_header_class = "bg-warning", this.fg_header_class = "text-white", this.fg_subtitle_class = "text-white", this.fg_dismiss_class = "text-white";
                        break;
                    case "error":
                    case "danger":
                        this.bg_header_class = "bg-danger", this.fg_header_class = "text-white", this.fg_subtitle_class = "text-white", this.fg_dismiss_class = "text-white"
                }
                var i = '\n<div id="'.concat(this.id, '" class="toast').concat(" " + this.customClass, '" role="alert" aria-live="assertive" aria-atomic="true" ').concat(this.delay_or_autohide, " ").concat(this.pause_on_hover, '>\n  <div class="toast-header ').concat(this.bg_header_class, " ").concat(this.fg_header_class, '">');
                void 0 !== this.img && void 0 === this.icon && (i += '<img src="'.concat(this.img.src, '" class="').concat(this.img.class || "", ' mr-2" alt="').concat(this.img.alt || "Image", '" ').concat(void 0 !== this.img.title ? 'data-toggle="tooltip" title="' + this.img.title + '"' : "", ">")), void 0 !== this.icon && void 0 === this.img && (i += this.icon), i += '\n    <strong class="me-auto mr-auto '.concat(void 0 !== this.icon ? "ml-2" : "", '">').concat(this.title, '</strong>\n    <small class="').concat(this.fg_subtitle_class, '">').concat(this.subtitle, '</small>\n    <button type="button" class="btn-close" data-dismiss="toast" data-bs-dismiss="toast" aria-label="Close"></button>\n  </div>'), "" !== this.content && (i += '<div class="toast-body">\n                        '.concat(this.content, "\n                      </div>")), i += "\n</div>\n";
                var a = document.createElement("div");
                a.innerHTML = i;
                var o = document.getElementsByClassName(CONTAINER_CLASS + " " + this.position)[0].firstChild.appendChild(a);
                if (t.toggleToast(this.id), !1 !== this.pause_on_hover) {
                    setTimeout(function() { s.pause || t.toggleToast(s.id, !0) }, this.delay), o.addEventListener("mouseover", function() { s.pause = !0 });
                    o.addEventListener("mouseleave", function() {
                        var e = Math.floor(Date.now() / 1e3),
                            i = parseInt(o.children[0].dataset.hideTimestamp);
                        s.pause = !1, e >= i && t.toggleToast(s.id, !0)
                    })
                }
            }
        }], [{
            key: "toggleToast",
            value: function(t) {
                var s = arguments.length > 1 && void 0 !== arguments[1] && arguments[1];
                // if (window.jQuery || window.$) $("#".concat(t)).toast(s ? "hide" : "show");
                // else {
                var e = new bootstrap.Toast(document.getElementById(t));
                s ? e.hide() : e.show()
                    // }
            }
        }]), t
    }();