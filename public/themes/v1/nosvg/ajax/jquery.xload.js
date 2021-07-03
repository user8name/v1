;(function ($) {
    var XLoad = function (xload) {
        var _this = this;
        this.xload = xload;
        this.config = {
            "id": "",
            "file": "",
            "scroll": false,
        };
        if (this.getConfig()) {
            $.extend(this.config, this.getConfig());
        }
        this._x_boLoad = false;
        var config = this.config;
        if (config.file!='' && config.scroll === 'true') {
            _this.scrollLoad(config);
            $(window).scroll(function () {
                _this.scrollLoad(config);
            });
        } else if (config.file!='' && config.scroll === 'false'){
            this.dealData(config);
        }
    };

    XLoad.prototype = {
        scrollLoad: function (config) {
            var scrollTop    = $(document).scrollTop();
            var scrollHeight = $(document).height();
            var windowHeight = $(window).height();
            if ((scrollTop + windowHeight >= (scrollHeight - 500) || (scrollHeight < 1080))) {
                this.dealData(config);
            }
        },
        dealData: function (config) {
            var _this = this;
            var url = config.file + '.js';
            if (this._x_boLoad) return;
            $.ajax({
                url: url,
                dataType: 'html',
                type: 'get',
                success: function (res) {
                    $('#' + config.id).html($.base64.decode(res));
                    _this._x_boLoad = true;
                }
            });
        },
        getConfig: function () {
            var config = {
                id: this.xload.attr("id"),
                file: this.xload.attr("data-file"),
                scroll: this.xload.attr("data-scroll"),
            };
            if (config) {
                return config;
            } else {
                return null;
            }
        }
    };

    $.fn.extend({
        xload: function () {
            new XLoad($(this));
            return this;
        }
    });

    window.XLoad = XLoad;
})(jQuery);