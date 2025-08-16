(function () {
    // Push fake history state so back button triggers popstate
    history.pushState(null, null, location.href);

    window.addEventListener('popstate', function () {
        if (confirm("Do you want to log out?")) {
            window.location.href = "logout.php";
        } else {
            // Push state again so the user stays here
            history.pushState(null, null, location.href);
        }
    });
})();
