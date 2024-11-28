/* For navbar */

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

  /* navbar end */