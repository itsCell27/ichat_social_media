
// for multiple heart onclick
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".post_icon_btn_heart").forEach(function(button) {
        button.addEventListener("click", function() {
            var heartIcon = this.querySelector("ion-icon");

            // Toggle between heart-outline and filled heart icon
            if (heartIcon.getAttribute("name") === "heart-outline") {
                heartIcon.setAttribute("name", "heart"); // Switch to filled heart
                this.classList.add("clicked"); // Add red color when clicked
            } else {
                heartIcon.setAttribute("name", "heart-outline"); // Switch back to outline heart
                this.classList.remove("clicked"); // Remove red color when unclicked
            }
        });
    });
});


// for multiple follow onclick
function followBtn(button) {
    // Find the SVG inside the clicked button
    const followIcon = button.querySelector('svg');

    // Replace current SVG with the new one based on the condition
    if (followIcon.getAttribute("height") === "30px") {
        followIcon.setAttribute("height", "32px");
        followIcon.setAttribute("width", "32px");
        followIcon.innerHTML = `
            <defs>
                <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" style="stop-color:#a01bf7;stop-opacity:1" />
                    <stop offset="100%" style="stop-color:#598BF1;stop-opacity:1" />
                </linearGradient>
            </defs>
            <path d="M516.92-413.03h33.85v-123.89h123.9v-33.85h-123.9v-123.9h-33.85v123.9H393.03v33.85h123.89v123.89ZM306.15-267.69q-24.57 0-41.52-16.94-16.94-16.95-16.94-41.52v-455.39q0-24.58 16.94-41.52Q281.58-840 306.15-840h455.39q24.58 0 41.52 16.94Q820-806.12 820-781.54v455.39q0 24.57-16.94 41.52-16.94 16.94-41.52 16.94H306.15ZM198.46-160q-24.58 0-41.52-16.94Q140-193.88 140-218.46v-489.23h33.85v489.23q0 9.23 7.69 16.92 7.69 7.69 16.92 7.69h489.23V-160H198.46Z"fill="url(#gradient)"/>`;   
    } else {
        followIcon.setAttribute("height", "30px");
        followIcon.setAttribute("width", "30px");
        followIcon.innerHTML = '<path d="M517.5-419.5h22v-124h124v-22h-124v-124h-22v124h-124v22h124v124ZM308-280q-22.24 0-38.12-15.88Q254-311.76 254-334v-440q0-22.24 15.88-38.12Q285.76-828 308-828h440q22.24 0 38.12 15.88Q802-796.24 802-774v440q0 22.24-15.88 38.12Q770.24-280 748-280H308Zm0-22h440q12 0 22-10t10-22v-440q0-12-10-22t-22-10H308q-12 0-22 10t-10 22v440q0 12 10 22t22 10Zm-96 118q-22.24 0-38.12-15.88Q158-215.76 158-238v-462h22v462q0 12 10 22t22 10h462v22H212Zm64-622v504-504Z"/>';
    }
}


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

// post option button
function toggleOption(toggleButton) {
    // Find the option box within the same post
    var optionBox = toggleButton.closest('.post').querySelector('.option_box');
    var profileDropdown = document.getElementById("profileDropdown");
    var notifDropdown = document.getElementById("notifDropdown");

    // Toggle the specific option box visibility
    optionBox.classList.toggle("show");

    // Close other dropdowns if they're open
    if (profileDropdown.classList.contains("show")) {
        profileDropdown.classList.remove("show");
    }
    if (notifDropdown.classList.contains("show")) {
        notifDropdown.classList.remove("show");
    }

    // Close all other option boxes
    document.querySelectorAll(".option_box").forEach(box => {
        if (box !== optionBox) {
            box.classList.remove("show");
        }
    });
}


// Select all elements with the class 'like-button'
const likeButtons = document.querySelectorAll(".comment_like_btn");

// Loop through each button and add an event listener
likeButtons.forEach(button => {
    button.addEventListener("click", () => {
        button.classList.toggle("liked");
    });
});


// for opening comment box
function openComment() {

    var commentBox = document.getElementById("commentBox");

    commentBox.classList.toggle("show_comment");
}

// for closing comment box
function closeComment() {

    var commentBox = document.getElementById("commentBox");

    commentBox.classList.remove("show_comment");
}


// comment send button. The color change when user inputs text
const inputField = document.getElementById('enter_comment');
const submitButton = document.getElementById('sendIcon');
const enableSend = document.getElementById('send_comment_btn');

inputField.addEventListener('input', function() {
            
    if (inputField.value.trim() !== '') {

        enableSend.classList.add('send_enabled');
        submitButton.classList.add('color');     
    } else {

        enableSend.classList.remove('send_enabled');
        submitButton.classList.remove('color');     
    }
});

// for opening like box
function openLike() {

    var likeBox = document.getElementById("likeBox");

    likeBox.classList.toggle("show_like");
}

// for closing like box
function closeLike() {

    var likeBox = document.getElementById("likeBox");

    likeBox.classList.remove("show_like");
}

// follow button 
function toggleFollow(button) {
    if (button.innerText === "Follow") {

        button.innerText = "Followed";       // Change text to "Followed"
        button.style.background = "gray";  // Change background to gray
    } else {

        button.innerText = "Follow";         // Reset text to "Follow"
        button.style.background = "linear-gradient(90deg, #595bf1 0%, rgba(148, 134, 241, 0.8) 100%)";
    }
}


// create button
function toggleCreate() {
    var createOverlay = document.getElementById("createOverlay");
    var createBox = document.getElementById("createBox");

    // Toggle visibility of overlay and create box
    if (createOverlay.classList.contains("show_create") && createBox.classList.contains("show_create_box")) {
        // If both are visible, hide them
        createOverlay.classList.remove("show_create");
        createBox.classList.remove("show_create_box");
    } else {
        // If either is hidden, show both
        createOverlay.classList.add("show_create");
        createBox.classList.add("show_create_box");
    }
}

// create post 
function openCreatePost() {

    var createBox = document.getElementById("createBox");
    var createPost = document.getElementById("createPost");

    if (createBox.classList.contains("show_create_box")) {

        createBox.classList.remove("show_create_box");
        createPost.classList.add("show");
    } else {

        createBox.classList.add("show_create_box");
        createPost.classList.remove("show");
    }
}

// create post close
function closeCreateClose() {

    var createOverlay = document.getElementById("createOverlay");
    var createPost = document.getElementById("createPost");
    
    // Toggle visibility of overlay and create box
    if (createOverlay.classList.contains("show_create") && createPost.classList.contains("show")) {
        // If both are visible, hide them
        createOverlay.classList.remove("show_create");
        createPost.classList.remove("show");
    } else {
        // If either is hidden, show both
        createOverlay.classList.add("show_create");
        createPost.classList.add("show");
    }
}


// to preview uploaded images
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById("previewImg");

    if (file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = "block"; // Show the image
        };
        
        reader.readAsDataURL(file); // Convert the file to a data URL
    } else {
        preview.style.display = "none"; // Hide the image if no file is chosen
    }
}

// show tag box
function toggleTag() {

    var tagPost = document.getElementById("tagPost");
    var createPost = document.getElementById("createPost");

    if (createPost.classList.contains("show")) {
        
        createPost.classList.remove("show");
        tagPost.classList.add("show");
    } else {
        
        tagPost.classList.remove("show");
        createPost.classList.add("show");
    }
}

// show story box
function toggleStory() {

    var createStory = document.getElementById("createStory");
    var createBox = document.getElementById("createBox");

    if (createBox.classList.contains("show_create_box")) {
        
        createBox.classList.remove("show_create_box");
        createStory.classList.add("show");
    } else {
        
        createStory.classList.remove("show");
        createBox.classList.add("show_create_box");
    }
}

