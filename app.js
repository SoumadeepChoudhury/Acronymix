window.onload = function () {
    // DOM elements
    const addFormSection = document.getElementById("add-form-section");
    const searchFormSection = document.getElementById("search-form-section");
    const addFormBtn = document.getElementById("addFormBtn");
    const searchFormBtn = document.getElementById("searchFormBtn");
    const logoutBtn = document.getElementById("logout");
    const searchBtn = document.getElementById("searchBtn");

    // Show "Add Form" section initially
    if (!document.cookie.includes("isSearching=")) {
        addFormSection.classList.add('active');
        addFormBtn.classList.add('active');
    } else {
        const cookieData = document.cookie
        searchFormSection.classList.add('active');
        addFormSection.classList.remove('active');
        searchFormBtn.classList.add('active');
        addFormBtn.classList.remove('active');
        var startIndex = cookieData.indexOf("isSearching=") + 12;
        var stopIndex = cookieData.length;
        for (var i = startIndex; i < cookieData.length; i++) {
            if (cookieData.charAt(i) == ";") {
                stopIndex = i;
                break;
            }
        }
        document.getElementById("searchShortForm").value = cookieData.substring(startIndex, stopIndex);
    }

    // Navigation button click event listeners
    addFormBtn.addEventListener('click', () => {
        addFormSection.classList.add('active');
        searchFormSection.classList.remove('active');
        addFormBtn.classList.add('active');
        searchFormBtn.classList.remove('active');
    });

    searchFormBtn.addEventListener('click', () => {
        searchFormSection.classList.add('active');
        addFormSection.classList.remove('active');
        searchFormBtn.classList.add('active');
        addFormBtn.classList.remove('active');
    });

    //Logging out
    logoutBtn.addEventListener('click', () => {
        document.cookie = "USER=; expires=Thu, 01 Jan 1970 00:00:01 GMT;";
        window.location = "/"
    })
}