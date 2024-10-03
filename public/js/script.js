// loading screen
window.addEventListener('load', function () {
    const loadingScreen = document.getElementById('loading-screen');
    loadingScreen.style.display = 'none';
});

//sidebar button
window.onload = function () {
    const sidebar = document.querySelector(".sidebar");
    const closeBtn = document.querySelector("#btn");

    // Cek apakah sidebar sudah terbuka atau tertutup pada halaman sebelumnya
    const isSidebarOpen = localStorage.getItem('sidebarOpen') === 'true';
    if (isSidebarOpen) {
        sidebar.classList.add('open');
        menuBtnChange();
    }

    closeBtn.addEventListener("click", function () {
        sidebar.classList.toggle("open");
        menuBtnChange();

        // Simpan status terbuka atau tertutupnya sidebar pada local storage
        const isOpen = sidebar.classList.contains("open");
        localStorage.setItem('sidebarOpen', isOpen.toString());
    });

    function menuBtnChange() {
        if (sidebar.classList.contains("open")) {
            closeBtn.classList.replace("bi-list", "bi-list-ul");
        } else {
            closeBtn.classList.replace("bi-list-ul", "bi-list");
        }
    }
    
    const sidebarBackdrop = document.querySelector(".sidebar-backdrop");
    sidebarBackdrop.addEventListener("click", function () {
        sidebar.classList.remove("open");
        menuBtnChange();

        // Simpan status terbuka atau tertutupnya sidebar pada local storage
        const isOpen = sidebar.classList.contains("open");
        localStorage.setItem('sidebarOpen', isOpen.toString());
    });

}

// sidebar active
const currentPathname = window.location.pathname;
const menuItems = document.querySelectorAll('.sidebar li a');

menuItems.forEach(item => {
    if (item.pathname === currentPathname) {
        item.parentElement.classList.add('active');
    }
});

// icon swicth theme
const themeSwitch = document.querySelector("#themeSwitch");
const themeIcon = document.querySelector("#themeIcon");

const isLoginPage = currentPathname.includes('login');
const isRegisterPage = currentPathname.includes('register');

// Function to set the theme based on the current page
function setThemeBasedOnPage() {
    if (isLoginPage || isRegisterPage) {
        document.documentElement.setAttribute("data-bs-theme", "light");
        themeSwitch.checked = false;
        themeIcon.classList.replace("bi-sun", "bi-moon");
    } else {
        // Retrieve the theme from local storage or use the preferred theme
        const theme = localStorage.getItem("theme") || getPreferredTheme();
        document.documentElement.setAttribute("data-bs-theme", theme);
        themeSwitch.checked = theme === "dark";
        themeIcon.classList.replace("bi-moon", theme === "dark" ? "bi-sun" : "bi-moon");
    }
}

// Get the preferred theme
function getPreferredTheme() {
    return window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
}

themeSwitch.addEventListener("change", () => {
    if (themeSwitch.checked) {
        document.documentElement.setAttribute("data-bs-theme", "dark");
        localStorage.setItem("theme", "dark");
        themeIcon.classList.replace("bi-moon", "bi-sun");
    } else {
        document.documentElement.setAttribute("data-bs-theme", "light");
        localStorage.setItem("theme", "light");
        themeIcon.classList.replace("bi-sun", "bi-moon");
    }
});

// Set the theme when the page is loaded
setThemeBasedOnPage();

// theme switch
(() => {
    "use strict";

    const storedTheme = localStorage.getItem("theme");

    const getPreferredTheme = () => {
        if (storedTheme) {
            return storedTheme;
        }

        return window.matchMedia("(prefers-color-scheme: dark)").matches
            ? "dark"
            : "light";
    };

    const setTheme = function (theme) {
        if (
            theme === "auto" &&
            window.matchMedia("(prefers-color-scheme: dark)").matches
        ) {
            document.documentElement.setAttribute("data-bs-theme", "dark");
            document.getElementById("themeSwitch").checked = false;
        } else {
            document.documentElement.setAttribute("data-bs-theme", theme);
            document.getElementById("themeSwitch").checked = theme === "dark";
        }

        localStorage.setItem("theme", theme);
    };

    const themeSwitch = document.getElementById("themeSwitch");
    themeSwitch.addEventListener("change", function () {
        setTheme(this.checked ? "dark" : "light");
    });

    setTheme(getPreferredTheme());
})();

// toggle password
function togglePasswordVisibility() {
    var passwordInput = document.getElementById("password");
    var passwordToggle = document.getElementById("password-toggle");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        passwordToggle.innerHTML = '<i class="bi bi-eye-slash"></i>';
    } else {
        passwordInput.type = "password";
        passwordToggle.innerHTML = '<i class="bi bi-eye"></i>';
    }
}

// toggle password
function togglePasswordVisibilityConfirm() {
    var passwordInput = document.getElementById("password-confirm");
    var passwordToggle = document.getElementById("password-toggle-confirm");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        passwordToggle.innerHTML = '<i class="bi bi-eye-slash"></i>';
    } else {
        passwordInput.type = "password";
        passwordToggle.innerHTML = '<i class="bi bi-eye"></i>';
    }
}

// JavaScript to select/deselect all checkboxes
const selectAllCheckbox = document.getElementById('selectAll');
const checkboxes = document.querySelectorAll('input[name="selected[]"]');
selectAllCheckbox.addEventListener('change', function () {
    checkboxes.forEach((checkbox) => {
        checkbox.checked = this.checked;
    });
    updateDeleteSelectedButton(); // Update the button status when "Select All" is used
});

// JavaScript to update the "Delete Selected" button's status based on checkbox selection
checkboxes.forEach((checkbox) => {
    checkbox.addEventListener('change', updateDeleteSelectedButton);
});

function updateDeleteSelectedButton() {
    const checkedCheckboxes = Array.from(checkboxes).filter((checkbox) => checkbox.checked);
    const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');

    if (checkedCheckboxes.length > 0) {
        deleteSelectedBtn.removeAttribute('disabled');
    } else {
        deleteSelectedBtn.setAttribute('disabled', 'disabled');
    }
}

// JavaScript to handle the modal reset
const confirmMultiDeleteModal = document.getElementById('confirmMultiDeleteModal');
const confirmMultiDeleteModalCancelBtn = confirmMultiDeleteModal.querySelector('.btn-secondary');

confirmMultiDeleteModalCancelBtn.addEventListener('click', function () {
    const modal = bootstrap.Modal.getInstance(confirmMultiDeleteModal);
    modal.hide();

    // Manually reset the modal
    setTimeout(() => {
        checkboxes.forEach(checkbox => checkbox.checked = false);
        updateDeleteSelectedButton();
    }, 300);
});