var xhr;
var timerCountdown = {};

jQuery('#themeSwitch').click(function() {
    var element = jQuery(this);
    var theme = 'light';
    var logoPath = '/img/logo.png';
    if (!element.hasClass('dark-theme')) {
        theme = 'dark';
        element.addClass('dark-theme');
        logoPath = '/img/light_logo.png';
    } else {
        element.removeClass('dark-theme');
    }

    var logos = document.getElementsByClassName("main-logo");
    var i;
    for (i = 0; i < logos.length; i++) {
        logos[i].src=logoPath;
    }
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);
});

function startClockTimer(element)
{
    clockTimer(element);
    window.setInterval( 'clockTimer("'+element+'")', 999 );
}

function clockTimer(element)
{
    if (!document.all && !document.getElementById) {
        return;
    }
    var Stunden = ServerTime.getHours();
    var Minuten = ServerTime.getMinutes();
    var Sekunden = ServerTime.getSeconds();
    ServerTime.setSeconds(Sekunden + 1);
    if (Stunden <= 9) {
        Stunden = "0" + Stunden;
    }

    if (Minuten <= 9) {
        Minuten = "0" + Minuten;
    }
    if (Sekunden <= 9) {
        Sekunden = "0" + Sekunden;
    }
    jQuery(element).text(Stunden.toString()+':'+Minuten.toString()+':'+Sekunden.toString());
}


function tTimer(iEndTimeStamp, iTimeStamp, sElement)
{
    iTimeStamp = iTimeStamp - Math.round(+new Date() / 1000) - iEndTimeStamp;
    oElement = jQuery('#'+sElement);
    if (iTimeStamp < 0) {
        oElement.html('00:00:00');
        return false;
    }
    diffDay = iTimeStamp / (3600 * 24 );
    diffDay = diffDay.toString();
    diffDay = diffDay.split(".");
    diffHour = iTimeStamp / 3600 % 24;
    diffHour = diffHour.toString();
    diffHour = diffHour.split(".");
    diffMin = iTimeStamp / 60 % 60;
    diffMin = diffMin.toString();
    diffMin = diffMin.split(".");
    diffSek = iTimeStamp % 60;
    diffSek = diffSek.toString();
    diffSek = diffSek.split(".");
    if(diffDay[0] != 0){
        oElement.html(diffDay[0] + 'd ' + checkLength(diffHour[0]) + ':' + checkLength(diffMin[0]) + ':' + checkLength(diffSek[0]));
        return true;
    }
    oElement.text(checkLength(diffHour[0]) + ':' + checkLength(diffMin[0]) + ':' + checkLength(diffSek[0]));
    return true;
}

function checkLength(sString)
{
    sString = sString.toString();
    if (sString.length === 1) {
        sString = '0' + sString;
    }
    return sString;
}

function loadCheck()
{
    jQuery.each(timerCountdown, function(sKey, iEntTime){
        if(!tTimer( iTimeStamp, iEntTime, sKey)){
            clearInterval(timerCountdown[sKey]);
        }
    });
}

function paginatorAjax(element, urlData)
{
    ajaxReload();
    jQuery(element).html('<i class="fas fa-spinner fa-spin"></i>');
    xhr = jQuery.ajax({
        url : urlData,
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "html",
        success : function(data){
            jQuery(element).html(data);
        },
        error: function(e) {
            alert('something wrong, please wait a moment');
        }
    });
}


function ajaxReload()
{
    if(xhr && xhr.readystate !== 4){
        xhr.abort();
    }
}

function itemInfo()
{
    Array.from(document.querySelectorAll('[data-iteminfo]')).forEach(el => {
        let tip = document.createElement('div');
        tip.classList.add('tooltip');

        if (el.parentElement.querySelector('.info').innerHTML === '') {
            return;
        }

        tip.innerHTML = el.parentElement.querySelector('.info').innerHTML;
        tip.style.transform =
            'translate(' +
            (el.hasAttribute('tip-left') ? 'calc(-100% - 5px)' : '15px') + ', ' +
            (el.hasAttribute('tip-top') ? '-100%' : '0') +
            ')';
        el.appendChild(tip);
        el.onmousemove = e => {
            tip.style.left = e.clientX + 'px'
            tip.style.top = e.clientY + 'px';
        };
    });
}

jQuery(document).ready(function(){
    jQuery('.timerCountdown').each(function() {
        sString = jQuery(this).attr('id');
        timerCountdown[sString] = jQuery(this).data('time');
        loadCheck();
    });
    window.setInterval('loadCheck();',999);
    itemInfo();

    jQuery('.captcha-reload').click(function() {
        icon = jQuery(this);
        parent = icon.addClass('fa-spin').parent('div');
        ajaxReload();
        xhr = jQuery.ajax({
            url : jQuery(this).data('url'),
            type: "POST",
            dataType: "json",
            success : function(data){
                parent.find('img').attr('src', data['url']);
                parent.find('input[name=\'captcha[id]\']').val(data['id']);
                parent.find('input[name=\'captcha[input]\']').val('');
                icon.removeClass('fa-spin');
            },
            error: function(e) {
                alert('smth wrong');
                icon.removeClass('fa-spin');
            }
        });
    });

    jQuery('.coins-widget-reload').click(function() {
        icon = jQuery(this);
        parent = icon.addClass('fa-spin').parent('div');
        ajaxReload();
        xhr = jQuery.ajax({
            url : jQuery(this).data('url'),
            type: "POST",
            dataType: "html",
            success : function(data){
                jQuery('#coinsWidgetSidebar').html(data);
                icon.removeClass('fa-spin');
            },
            error: function(e) {
                alert('smth wrong');
                icon.removeClass('fa-spin');
            }
        });
    });

    jQuery('#display-inventory-switch').click(function() {
        var current = jQuery(this).data('type');
        var change = 'set';
        if (current === 'set') {
            change = 'avatar';
        }
        jQuery('#display-inventory-' + current).addClass('d-none');
        jQuery('#display-inventory-' + change).removeClass('d-none');
        jQuery(this).data('type', change);
    });

    jQuery('.ranking-main-button').click(function() {
        jQuery('.ranking-main-button').removeClass('active');
        paginatorAjax('#content-replace', jQuery(this).data('link'));
        jQuery(this).addClass('active');
    });
});
