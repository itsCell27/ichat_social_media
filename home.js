// navbar start

// search engine
function searchUser() {
    var searchText = $("#search").val();
    if (searchText.length > 0) {
        $.ajax({
            url: 'search_handler.php',
            type: 'GET',
            data: { query: searchText },
            success: function(data) {
                $("#result").html(data);
            }
        });
    } else {
        $("#result").html('');  // Clear the result if the search box is empty
    }
}

// search bar 
function toggleSearch() {

    var searchBarDropdown = document.getElementById("searchBarDropdown");
    var profileDropdown = document.getElementById("profileDropdown");
    var notifDropdown = document.getElementById("notifDropdown");
    var menuDropdown = document.getElementById("menuDropdown");

    // Toggle the search dropdown visibility
    searchBarDropdown.classList.toggle("show");
  
    // Close the notification dropdown if it's open
    if (notifDropdown.classList.contains("show")) {
      notifDropdown.classList.remove("show");
    }

    // Close the menu dropdown if it's open
    if(menuDropdown.classList.contains("show")) {
      menuDropdown.classList.remove("show");
    }

    // Close the profile dropdown if it's open
    if (profileDropdown.classList.contains("show")) {
      profileDropdown.classList.remove("show");
    }
  
    // Close all open option boxes
    document.querySelectorAll(".option_box").forEach((optionBox) => {
      optionBox.classList.remove("show");
    });
}

// profile dropdown button
function toggleProfile() {

    var searchBarDropdown = document.getElementById("searchBarDropdown");
    var profileDropdown = document.getElementById("profileDropdown");
    var notifDropdown = document.getElementById("notifDropdown");
    var menuDropdown = document.getElementById("menuDropdown");
  
    // Toggle the profile dropdown visibility
    profileDropdown.classList.toggle("show");
  
    // Close the notification dropdown if it's open
    if (notifDropdown.classList.contains("show")) {
      notifDropdown.classList.remove("show");
    }

    // Close the menu dropdown if it's open
    if(menuDropdown.classList.contains("show")) {
      menuDropdown.classList.remove("show");
    }

    // Close the search dropdown if it's open
    if(searchBarDropdown.classList.contains("show")) {
      searchBarDropdown.classList.remove("show");
    }
  
    // Close all open option boxes
    document.querySelectorAll(".option_box").forEach((optionBox) => {
      optionBox.classList.remove("show");
    });
  }
  
  // notification dropdown button
  function toggleNotifications() {
    var profileDropdown = document.getElementById("profileDropdown");
    var notifDropdown = document.getElementById("notifDropdown");
    var menuDropdown = document.getElementById("menuDropdown");
  
    // Toggle the notification dropdown visibility
    notifDropdown.classList.toggle("show");
  
    // Close the profile dropdown if it's open
    if (profileDropdown.classList.contains("show")) {
      profileDropdown.classList.remove("show");
    }

    // Close the menu dropdown if it's open
    if(menuDropdown.classList.contains("show")) {
      menuDropdown.classList.remove("show");
    }

    // Close the search dropdown if it's open
    if(searchBarDropdown.classList.contains("show")) {
      searchBarDropdown.classList.remove("show");
    }
  
    // Close all open option boxes
    document.querySelectorAll(".option_box").forEach((optionBox) => {
      optionBox.classList.remove("show");
    });
  }

  // menu dropdown button
  function toggleMenu() {
    var profileDropdown = document.getElementById("profileDropdown");
    var notifDropdown = document.getElementById("notifDropdown");
    var menuDropdown = document.getElementById("menuDropdown");
  
    // Toggle the profile dropdown visibility
    menuDropdown.classList.toggle("show");
  
    // Close the notification dropdown if it's open
    if (notifDropdown.classList.contains("show")) {
      notifDropdown.classList.remove("show");
    }

    // Close the profile dropdown if it's open
    if (profileDropdown.classList.contains("show")) {
      profileDropdown.classList.remove("show");
    }

    // Close the search dropdown if it's open
    if(searchBarDropdown.classList.contains("show")) {
      searchBarDropdown.classList.remove("show");
    }
  
    // Close all open option boxes
    document.querySelectorAll(".option_box").forEach((optionBox) => {
      optionBox.classList.remove("show");
    });
  }

//   navbar ending



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


function openModal() {
    document.getElementById("modal").style.display = "flex";
}

// Function to close the Create modal
function closeModal() {
    document.getElementById("modal").style.display = "none";
}

// Function to open the Post form modal
function openPostForm() {
    // Close the Create modal and open the Post form modal
    document.getElementById("modal").style.display = "none";  // Close the Create modal
    document.getElementById("post-modal").style.display = "flex";  // Open the Post modal
}
function openStoryForm() {
    // Close the Create modal and open the Post form modal
    document.getElementById("modal").style.display = "none";  // Close the Create modal
    document.getElementById("story-modal").style.display = "flex";  // Open the Post modal
}


// Function to close the Post form modal
function closePostForm() {
    document.getElementById("post-modal").style.display = "none";  // Close the Post modal
    openModal();  // Reopen the Create modal
}

// Action for uploading a story
function uploadStory() {
    closeModal(); // Close the modal after action
    openStoryForm();
}

// Action for uploading a post
function uploadPost() {
    // Close the Create modal and open the Post creation form
    closeModal();  // Close the Create modal
    openPostForm(); // Open the Post form modal
}

// Action for submitting the post
function submitPost() {
    // Get the data from the form
    const caption = document.getElementById("caption").value;
    const fileInput = document.getElementById("image-upload");
    const file = fileInput.files[0];
    const tags = document.getElementById("tags").value;

    // Check if a caption is provided, a file is selected, and tags are provided
    if (caption.trim() === "" || !file) {
        alert("Please add a caption, select an image/video, and add tags!");
        return;
    }

    // You can add additional validation for tags (optional)
    const tagsArray = tags.split(',').map(tag => tag.trim()).filter(tag => tag.startsWith('#'));
    
    if (tagsArray.length === 0) {
        alert("Please add valid tags!");
        return;
    }

    // Mock post submission (you can replace this with actual API integration)
    alert(`Post submitted with caption: ${caption} \nTags: ${tagsArray.join(", ")} \nFile: ${file.name}`);

    // Close the post modal and reset the form
    closePostForm();
    document.getElementById("post-form").reset(); // Clear the form
}

// Close the modal if clicked outside of the modal content
window.onclick = function(event) {
    if (event.target === document.getElementById("modal")) {
        closeModal();
    }
    if (event.target === document.getElementById("post-modal")) {
        closePostForm();
    }
};


let userStories = {};

// Fetch stories for each user when a profile picture is clicked
document.querySelectorAll('.profile-picture').forEach(pic => {
    pic.addEventListener('click', function () {
        let userId = this.getAttribute('data-user-id');
        showStories(userId);
    });
});

// Function to load and show stories
function showStories(userId) {
    if (!userStories[userId]) {
        // Fetch stories via AJAX if not already fetched
        fetch(`fetch_stories.php?user_id=${userId}`)
            .then(response => response.json())
            .then(data => {
                userStories[userId] = data;
                displayStory(userId, 0);
            });
    } else {
        // Display already fetched stories
        displayStory(userId, 0);
    }
}

// Function to display a single story and handle timing
function displayStory(userId, storyIndex) {
    const stories = userStories[userId];
    if (stories && storyIndex < stories.length) {
        const story = stories[storyIndex];
        
        // Set story content and show overlay
        document.getElementById('storyContent').src = story.content_url;
        document.getElementById('storyCaption').innerText = story.text_caption;
        document.getElementById('storyOverlay').style.display = 'flex';

        // Auto-close after 5 seconds or show the next story
        setTimeout(() => {
            if (storyIndex + 1 < stories.length) {
                displayStory(userId, storyIndex + 1);
            } else {
                closeStory();
            }
        }, 5000);
    }
}

// Function to close the story overlay
function closeStory() {
    document.getElementById('storyOverlay').style.display = 'none';
}

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


