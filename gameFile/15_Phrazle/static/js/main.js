var loginModalCloseEvent = new Event("loginModalCloseEvent");
var registerModalCloseEvent = new Event("registerModalCloseEvent");

$(document).on("click", "#loginForm .submit", function () {
    $.post(
        "/user/login", {
        username: $("#loginForm .username").val(),
        password: $("#loginForm .password").val(),
        nextPage: $("#loginForm #nextPage").val(),
    },
        function (resp) {
            if (resp.status == "error") {
                $("#loginForm .message").text(resp.message).show();
            } else {
                $(".logged-out").hide();
                $(".logged-in").show();
                $("#loginModal").modal("hide");

                if ($("#canvas").length > 0) {
                    if (typeof turns !== "undefined" && turns > 0) {
                        try {
                            save_game();
                        } catch (err) { }
                        removeAdIfSubscriber();
                        window.dispatchEvent(loginModalCloseEvent);
                    } else {
                        location.href = location.href;
                    }
                } else {
                    location.href = "/account";
                }
            }
        }
    );
});

function handleGoogleCredentialResponse(response) {
    $.post(
        "/user/google-login", {
        jwt: response.credential,
    },
        function (resp) {
            if (resp.status == "error") {
                $("#loginForm .message").text(resp.message).show();
            } else {
                $(".logged-out").hide();
                $(".logged-in").show();
                $("#loginModal").modal("hide");

                if (window.GLOBAL?.LOGIN_NO_RELOAD) {
                    return;
                }

                if ($("#canvas").length > 0) {
                    if (typeof turns !== "undefined" && turns > 0) {
                        try {
                            save_game();
                        } catch (err) { }
                        removeAdIfSubscriber();
                        window.dispatchEvent(loginModalCloseEvent);
                    } else {
                        location.href = location.href;
                    }
                } else {
                    location.href = "/account";
                }
            }
        }
    );
}

function removeAdIfSubscriber() {
    $.get("/user/is-subscriber", function (resp) {
        if (resp.status == "ok") {
            $("#adSidebarContainer, #subscribeButton").remove();
        }
    });
}

function showSubscriptionModal() {
    $.get("/subscribe/payment", function (resp) {
        if (resp.status == "error") {
            location.href = location.href;
            return;
        }
        if (resp.upgraded) {
            location.href = location.href;
            return;
        }
        if (resp.redirect == "register") {
            showRegisterModal();
            return;
        }

        if (typeof stripePublishableKey == "undefined") {
            gtag("event", "showSubscribeScreen", {
                event_category: "subscribe",
                event_label: "shown",
                value: 1,
            });
            $("#subscribeModal .modal-body").html(resp);
        }
        $("#subscribeModal").modal("show");
    });
}

$(document).on("click", "#registerForm .submit", function (event) {
    event.preventDefault();
    let newsletter = "";
    if ($("#newsletterCheck").is(":checked")) {
        newsletter = "yes";
    }
    $.post(
        "/user/register", {
        email: $("#registerForm .email").val(),
        username: $("#registerForm .username").val(),
        password: $("#registerForm .password").val(),
        newsletter: newsletter,
        nextPage: $("#registerForm #nextPage").val(),
    },
        function (resp) {
            if (resp.status == "error") {
                $("#registerForm .message")
                    .addClass("alert-danger")
                    .text(resp.message)
                    .show();
            } else {
                $(".logged-out").hide();
                $(".logged-in").show();
                $("#registerModal, #subscribeModal").modal("hide");

                const redirectUrl = $("#registerModal").data("redirectUrl");
                if (redirectUrl) {
                    return (location.href = redirectUrl);
                }
                if ($("#canvas").length > 0) {
                    if (
                        $("#turnCount").length > 0 &&
                        parseInt($("#turnCount").text()) > 0
                    ) {
                        try {
                            save_game();
                        } catch (err) { }
                        removeAdIfSubscriber();
                        window.dispatchEvent(registerModalCloseEvent);
                    } else {
                        location.href = location.href;
                    }
                } else {
                    location.href = "/account";
                }
            }
        }
    );
});

$("#loginModal, #registerModal").on("show.bs.modal", function (e) {
    if (typeof turns !== "undefined" && turns > 0) {
        $(".save-message").show();
    }
});

$(document).on("click", ".registerToLogin", function (event) {
    $("#registerModal").modal("hide");
    showLoginModal();
    return false;
});

$(document).on("click", ".loginToRegister", function (event) {
    $("#loginModal").modal("hide");
    showRegisterModal();
    return false;
});

window.addEventListener("orientationchange", function () {
    window.setTimeout(function () {
        let mobileAdWidth = $("#adSidebarContainerMobile").width();
        if (typeof mobileAdWidth !== "undefined" && mobileAdWidth == 0) {
            $("#adSidebarContainerMobile").remove();
        }
    }, 1000);
});

$("body").on("click", ".saveUsername", function () {
    showRegisterModal("username=" + $(".congratsUsername").val());
    $("#registerUsername").val($(".congratsUsername").val());
    $("#registerModal .message.alert.alert-danger")
        .removeClass("alert-danger")
        .addClass("alert-primary")
        .html("Finish registering to save your name on the leaderboard.")
        .show();
});

$(".turn-1-btn, .turn-3-btn, .main-logo").on("click", function () {
    let count = parseInt($("#turnCount").text());
    if (count > 0) {
        let confirm = window.confirm("Leave your current game?");
        if (!confirm) {
            return false;
        }
    }
});

//# Ad sidebar
var origWindowWidth = window.innerWidth;
var ad1Removed = false;
var ad2Removed = false;

$(window).resize(function () {
    if (window.innerWidth < 770) {
        if (
            typeof freestar !== "undefined" &&
            typeof freestar.deleteAdSlots !== "undefined" &&
            !ad1Removed
        ) {
            try {
                freestar.deleteAdSlots();
                if (
                    typeof googletag !== "undefined" &&
                    typeof googletag.destroySlots !== "undefined"
                ) {
                    googletag.destroySlots([adSlot3]);
                }
            } catch (e) { }
            $("#adSidebarContainer").remove();
            ad1Removed = true;
            gtag("event", "removeFreestar", {
                event_category: "adRemoval",
                event_label: window.innerWidth,
                value: 1,
            });
        }
    }
    if (origWindowWidth <= 400 && window.innerWidth > 800) {
        try {
            if (
                typeof lngtd !== "undefined" &&
                typeof lngtd.resetAllSlots !== "undefined"
            ) {
                window.lngtd.resetAllSlots();
            }
        } catch (e) { }
    }
    if (origWindowWidth >= 1019 && window.innerWidth < 1019) {
        if (
            typeof googletag !== "undefined" &&
            typeof googletag.destroySlots !== "undefined" &&
            !ad2Removed
        ) {
            googletag.destroySlots([adSlot1]);
            $(
                "#adSidebarContainer #solitaired_desktop_right_rail_2, #adSidebarContainer #solitaired_desktop_right_rail_2_container"
            ).remove();
            ad2Removed = true;
            gtag("event", "removeGAM_1019", {
                event_category: "adRemoval",
                event_label: window.innerWidth,
                value: 1,
            });
        }
    } else if (origWindowWidth >= 920 && window.innerWidth < 920) {
        if (
            typeof googletag !== "undefined" &&
            typeof googletag.destroySlots !== "undefined" &&
            !ad2Removed
        ) {
            googletag.destroySlots();
            $(
                "#adSidebarContainer #solitaired_desktop_right_rail_2, #adSidebarContainer #solitaired_desktop_right_rail_2_container"
            ).remove();
            ad2Removed = true;
            gtag("event", "removeGAM_920", {
                event_category: "adRemoval",
                event_label: window.innerWidth,
                value: 1,
            });
        }
    }
});

//remove sounds on mobile
if (window.innerWidth < 430) {
    $(".audio-toggle-off").click();
    $(".audio-toggle").remove();

    $("#timerContainer .dropdown").addClass("dropup");
}

//persist edition
if (typeof isEdition !== "undefined") {
    $("a").on("click", function (e) {
        let url = e.target.href;
        if (url.length < 1) {
            return;
        }
        if (url.indexOf("?") > -1) {
            if (url.indexOf("edition") == -1) {
                e.target.href = url + "&edition=true";
            }
        } else {
            e.target.href = url + "?edition=true";
        }
    });
}

function showRegisterModal(query, redirectUrl) {
    if (query == undefined) {
        query = "";
    }
    $.get("/user/register?" + query, function (resp) {
        if (resp.status == "paymentRedirect") {
            $("#registerModal").modal("hide");
            showSubscriptionModal();
            return;
        }
        $("#registerModal .modal-body").html(resp);
        if (redirectUrl) {
            $("#registerModal").data("redirectUrl", redirectUrl);
        }
        $("#registerForm .email").focus();
        $("#registerModal").modal("show");
    });
}

function showLoginModal(action) {
    if (action == undefined) {
        action = "";
    }
    $.get("/user/login?action=" + action, function (resp) {
        if (resp.status == "paymentRedirect") {
            showSubscriptionModal();
            return;
        }

        $("#loginModal .modal-body").html(resp);
        $("#loginModal").modal("show");
    });
}

function copyToClipboard(el) {
    let copyText = document.getElementById(el);
    copyText.select();
    copyText.setSelectionRange(0, 99999); /* For mobile devices */
    document.execCommand("copy");
    alert("Copied the text: " + copyText.value);
}

$("#tiktokUrl .close").on("click", function () {
    $("#tiktokUrl").remove();
});

$("#registerModal").on("show.bs.modal", function (event) {
    showRegisterModal();
});

$("#loginModal").on("show.bs.modal", function (event) {
    showLoginModal();
});

// $('#loginLink').on('click', function() {
//   showLoginModal();
// });

//subscription
$(".subscribeTrigger, #subscribeButton, #subscribeButtonMobile").on(
    "click",
    function () {
        // (function(h,o,t,j,a,r){
        //     h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        //     h._hjSettings={hjid:1612361,hjsv:6};
        //     a=o.getElementsByTagName('head')[0];
        //     r=o.createElement('script');r.async=1;
        //     r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        //     a.appendChild(r);
        // })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');

        gtag("event", "showRegLoginScreen", {
            event_category: "subscribe",
            event_label: "shown",
            value: 1,
        });
        showSubscriptionModal();
        //showRegisterModal('subscribe');
    }
);

//sounds
$("#moreMenuDropdown").on("click", ".audio-toggle-off", function () {
    $(this).removeClass("audio-toggle-off");
    $(this).addClass("audio-toggle-on");
    $(this).text("Turn sounds off");
    $.post("/settings/save", {
        sounds: "on",
    });
});

//sounds
$("#moreMenuDropdown").on("click", ".audio-toggle-on", function () {
    $(this).removeClass("audio-toggle-on");
    $(this).addClass("audio-toggle-off");
    $(this).text("Turn sounds on");
    $.post("/settings/save", {
        sounds: "off",
    });
});

$(".menu-buttons").on("click", ".left-hand-mode", function () {
    $(this).removeClass("left-hand-mode");
    $(this).addClass("right-hand-mode");
    $(this).text("Right hand");
    $.post(
        "/settings/save", {
        handmode: "left",
    },
        function () {
            location.href = location.href;
        }
    );
});

$(".menu-buttons").on("click", ".right-hand-mode", function () {
    $(this).removeClass("right-hand-mode");
    $(this).addClass("left-hand-mode");
    $(this).text("Left hand");
    $.post(
        "/settings/save", {
        handmode: "right",
    },
        function () {
            location.href = location.href;
        }
    );
});

$("#playAnotherGame").on("click", function () {
    //$('#gotdOffsetUnselected').dropdown('hide');
    window.setTimeout(function () {
        $("#dropdownMenuOffset").dropdown("toggle");
    }, 50);
});

$("#fullscreenBtn").on("click", function () {
    /* Get the element you want displayed in fullscreen mode (a video in this example): */
    var elem = document.getElementById("gameContainer");

    if ($(this).hasClass("show")) {
        $(this).removeClass("show");
        $(this).text("Exit Fullscreen");
        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.webkitRequestFullscreen) {
            /* Safari */
            elem.webkitRequestFullscreen();
        } else if (elem.msRequestFullscreen) {
            /* IE11 */
            elem.msRequestFullscreen();
        }
        window.setTimeout(function () {
            $(window).resize();
        }, 100);
    } else {
        $(this).text("Fullscreen");

        $(this).addClass("show");
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
            /* Safari */
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
            /* IE11 */
            document.msExitFullscreen();
        }
        window.setTimeout(function () {
            $(window).resize();
        }, 100);
    }
});

$('[data-toggle="popover"]').popover();$("#playStore").on("click", function () {
    gtag("event", "click", {
        event_category: "android",
        event_label: "shown",
        value: 1,
    });
});

// Log clicks on these menu buttons to GA.
const loggingClickHandler = function (e) {
    const label = $(e.target).data("label");
    gtag("event", "click", {
        event_category: "moments",
        event_label: label,
        value: 1,
    });
};
$(document).on(
    "click",
    "#moreMenuDropdown a, #newGameDropdown a, #undoBtn, #redoBtn, #hintBtn, #multiplayerBtn, #gameOfDayBtn",
    loggingClickHandler
);

