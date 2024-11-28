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

$(document).ready(function () {
  // Handle typing in the search input field
  $('#searchInput').on('input', function () {
      const searchTerm = $(this).val();
      if (searchTerm.length > 0) {
          $.ajax({
              url: 'messages_search_handler.php',
              method: 'POST',
              data: { search_term: searchTerm },
              success: function (response) {
                  $('#results').html(response);
              }
          });
      } else {
          $('#results').empty();
      }
  });

  // Event listener for the clickable search results
  $(document).on('click', '.conversation-item', function (e) {
      e.preventDefault();
      const userId = $(this).data('user-id');

      // Load the conversation for the clicked user
      loadConversation(userId);
  });

  function loadConversation(userId) {
      // Use AJAX to load the messages with the selected user
      $.ajax({
          url: 'messages_load.php', // The page that will load the conversation
          method: 'GET',
          data: { user2_id: userId },
          success: function (response) {
              // Insert the loaded conversation into the conversation container
              $('#conversation-container').html(response).show();
          }
      });
  }
});
