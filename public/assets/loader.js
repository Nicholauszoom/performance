var loadingTimeout;

function showLoading() {
    $("#loadingOverlay").show();
    loadingTimeout = setTimeout(function () {
        hideLoading();
    }, 5000); // 5000 milliseconds = 5 seconds
}

// function  to hide the loading spinner
function hideLoading() {
    setTimeout(function () {
        const $elementToRemove = $("#element-to-remove");

        $elementToRemove.addClass("removed");

        $("#loadingOverlay").hide();
    }, 1000);

    clearTimeout(loadingTimeout);
}

var isLoading = false; // Flag to track if the page is still loading

$(window).on("load", function () {
    isLoading = false; // Page loading complete
});

// Intercept all AJAX requests
$(document).on({
    ajaxStart: function () {
        isLoading = true;
        showLoading();
    },
    ajaxStop: function () {
        isLoading = false;
        hideLoading();
    },
    ajaxError: function () {
        isLoading = false;
        hideLoading();
    },
});

// Intercept all form submissions
$(document).on("submit", "form", function () {
    showLoading();
});

// Show loading overlay when the page is refreshed
$(window).on("beforeunload", function () {
    isLoading = true;
    showLoading();
});

// When the document is ready, hide the spinner if the page is not still loading
$(document).ready(function () {
    if (!isLoading) {
        hideLoading();
    }
});
