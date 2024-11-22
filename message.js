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
  document.querySelectorAll(".option_box").forEach((optionBox) => {
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
  document.querySelectorAll(".option_box").forEach((optionBox) => {
    optionBox.classList.remove("show");
  });
}

// message option dropdown
function toggleOption() {
  var optionDropdown = document.getElementById("optionDropdown");

  if (optionDropdown.classList.contains("show")) {
    optionDropdown.classList.remove("show");
  } else {
    optionDropdown.classList.add("show");
  }
}

// delete conversation popup
function deleteToggle() {
  var deleteConversation = document.getElementById("deleteConversation");

  if (deleteConversation.classList.contains("show")) {
    deleteConversation.classList.remove("show");
  } else {
    deleteConversation.classList.add("show");
  }
}

// photos tab
function photosToggle() {
  const container = document.querySelector(".message_option_dropdown");
  container.classList.toggle("active");
}

function slideIn() {
  const box2 = document.querySelector(".box2");
  box2.classList.add("active"); // Adds the class to slide in Box 2
}

function slideOut() {
  const box2 = document.querySelector(".box2");
  box2.classList.remove("active"); // Removes the class to slide out Box 2
}


// img upload preview
document.getElementById("uploadImage").addEventListener("change", function () {
  const previewContainer = document.getElementById("imagePreviewContainer");
  const previewGroup = document.querySelector(".message_img_preview_group");

  const files = Array.from(this.files); // Get all files
  if (files.length > 0) {
      previewGroup.classList.add("show"); // Show the container
  }

  // Clear previous previews to prevent duplicates
  //previewContainer.innerHTML = "";

  files.forEach((file) => {
      if (file.type.startsWith("image/")) {
          const reader = new FileReader();

          reader.onload = function (e) {
              // Create a new div for this image
              const imgWrap = document.createElement("div");
              imgWrap.classList.add("img_preview_wrap");

              // Create the image element
              const imgElement = document.createElement("img");
              imgElement.classList.add("message_img_preview");
              imgElement.src = e.target.result;
              imgElement.alt = "Preview";
              imgElement.style.borderRadius = "10px";

              // Create the close button
              const closeWrap = document.createElement("div");
              closeWrap.classList.add("img_close_wrap");
              closeWrap.innerHTML = `<ion-icon class="close_img_preview" name="close"></ion-icon>`;
              closeWrap.addEventListener("click", () => {
                  imgWrap.remove(); // Remove this specific image preview
                  if (previewContainer.children.length === 0) {
                      previewGroup.classList.remove("show"); // Hide if no images left
                  }
              });

              // Append the elements
              imgWrap.appendChild(imgElement);
              imgWrap.appendChild(closeWrap);
              previewContainer.appendChild(imgWrap); // Add to the preview container
          };

          reader.readAsDataURL(file); // Convert the file to a data URL
      }
  });

  // Clear the file input so new uploads don't include previous files
  this.value = "";
});


// Initially hide the preview group
document.querySelector(".message_img_preview_group").classList.remove("show");