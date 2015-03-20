$(window).load(function () {
    var ModalCache = new Array();
    var hrefID = new Array();
    var NavigationCache = new Array();
    var NavigationTitle = new Array();
    var siteURL = "http://" + top.location.host.toString();
    var free = true;
    page = window.location.pathname;
    $body = $("body");


    NavigationCache[page] = $('.content').html();

    history.pushState({page: page, type: "page"}, update(page), page);

    $("a[href^='" + siteURL + "'], a[href^='/'], a[href^='./'], a[href^='../']").addClass('ajax');

    window.onpopstate = function (e) {
        if (e.state !== null) {
            if (e.state.page !== '/user/userbar/') {
                $('.content').html(NavigationCache[e.state.page]);
                update(e.state.page);
            }
        }
    };

    var checkMsg = setInterval(function () {
        $.post('/message/check/', function (data) {
            result = jQuery.parseJSON(data);
            if (result['login'] === false) {
                clearInterval(checkMsg);
            } else {
                if (result['data'] !== undefined) {
                    if ($('body').find('.msg').html() !== undefined) {
                        $('body').find('.msg').html(result['data']);
                    } else {
                        $('.content').before('<div class="msg">' + result['data'] + '</div>');
                    }
                }
            }
        });
    }, 90000);
    $(document).on('click', '.ajax', function () {
        if (free) {
            free = false;
            id = $(this).attr('id');
            if (id !== 'tab') {
                href = $(this).attr('href');

                if (id === 'gui') {
                    string = '[id="' + href + '"]';
                    if (jQuery.inArray(href, ModalCache) > -1) {
                        id = hrefID[$(this).attr('href')];
                        $('#' + id).modal('show');
                    } else {
                        id = ModalCache.length + 1;
                        $.post(href, {ajaxLoad: true, modal: true, id: id}, function (data) {
                            $('.content').before(data);
                            ModalCache.push(href);
                            $('#' + id).modal('show');
                            hrefID[href] = id;
                        });
                    }
                } else if (id === 'noAjax') {
                    window.location.href = href;
                } else {
                    setPage(href);
                }
            }
            free = true;
        }

        return false;
    });

    $(document).on('submit', 'form', function () {
        if (free) {
            free = false;
            forms = $(this);
            action = forms.attr('action');
            array = new Array();

            forms.find("input,select,textarea,button").each(function () {
                array.push(JSON.stringify([this.name, this.value]));
            });

            data = JSON.stringify(array);

            $.post(action, {form: data}, function (date) {
                id = hrefID[action];
                $('#' + id).modal('hide');
                if (IsJsonString(date)) {
                    jsonFilter(jQuery.parseJSON(date));
                } else {
                    $('.content').html(date);
                    update(action);
                    NavigationCache[action] = date;
                }
            });
            updateCaptcha();
            free = true;
        }
        return false;
    });

    function setPage(page) {
        $.post(page, {ajaxLoad: true}, function (data) {
            if (IsJsonString(data)) {
                json = jQuery.parseJSON(data);
                jsonFilter(json);
            } else {
                $('.content').html(data);
                NavigationCache[page] = data;
                NavigationTitle[page] = $('.content').find('#title').text();
                title = update(page);
                document.title = title;
                updateCaptcha();
                history.pushState({page: page, type: "page"}, title, page);
            }
        });
    }

    function jsonFilter(array) {
        switch (array['type']) {
            case 'fullRefresh':
                window.location.href = array['value'];
                break;
            case 'refresh':
                if (array['value'] === '/admin/dev/') {
                    window.location.replace("/admin/dev/");
                } else {
                    setPage(array['value']);
                }
                break
            case 'error':
                $('.content').before(array['value']);
                break
        }
    }
    function update(action) {
        $('.content').find("a[href^='" + siteURL + "'], a[href^='/'], a[href^='./'], a[href^='../']").addClass('ajax');
        if (NavigationTitle[action] === undefined || NavigationTitle[action] === -1) {
            object = $('.content').find('#title');
            object.css('display', 'none');
            title = object.text();
            if (title.length > 0) {
                NavigationTitle[action] = object.text();
            } else {
                title = false;
            }
        } else {
            object = $('.content').find('#title');
            title = NavigationTitle[action];
            if (title.length > 0) {
                object.css('display', 'none');
            } else {
                title = false;
            }
        }
        if (title !== false) {
            $('.titleContent').text(title);
            document.title = title;
            return title;
        }
    }

    function IsJsonString(str) {
        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }
        return true;
    }

    function updateCaptcha() {
        captcha = $('.content').find('#captcha');
        if (captcha !== undefined) {
            captcha.attr('src', captcha.attr('src') + Math.random());
        }
    }
});