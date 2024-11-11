// profile dropdown button
function toggleProfile() {
    var profileDropdown = document.getElementById("profileDropdown");
    var notifDropdown = document.getElementById("notifDropdown");

    // Toggle the profile dropdown visibility
    profileDropdown.classList.toggle("show");

    // Close the notification dropdown if it's open
    if (notifDropdown.classList.contains("show")) {
        notifDropdown.classList.remove("show");
    }

    // Close all open option boxes
    document.querySelectorAll(".option_box").forEach(optionBox => {
        optionBox.classList.remove("show");
    });
}

// notification dropdown button
function toggleNotifications() {
    var profileDropdown = document.getElementById("profileDropdown");
    var notifDropdown = document.getElementById("notifDropdown");

    // Toggle the notification dropdown visibility
    notifDropdown.classList.toggle("show");

    // Close the profile dropdown if it's open
    if (profileDropdown.classList.contains("show")) {
        profileDropdown.classList.remove("show");
    }

    // Close all open option boxes
    document.querySelectorAll(".option_box").forEach(optionBox => {
        optionBox.classList.remove("show");
    });
}


// message option dropdown
function toggleOption() {

    var optionDropdown = document.getElementById("optionDropdown");
    var chatBox = document.getElementById("chatBox");

    if (optionDropdown.classList.contains("show") && chatBox.classList.contains("shrink")) {

        optionDropdown.classList.remove("show");
        chatBox.classList.remove("shrink");
    } else {

        optionDropdown.classList.add("show");
        chatBox.classList.add("shrink");
    }
}