
// for multiple heart onclick

document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".post_icon_btn").forEach(function(button) {
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
            <path d="M517.5-419.5h22v-124h124v-22h-124v-124h-22v124h-124v22h124v124ZM308-280q-22.24 0-38.12-15.88Q254-311.76 254-334v-440q0-22.24 15.88-38.12Q285.76-828 308-828h440q22.24 0 38.12 15.88Q802-796.24 802-774v440q0 22.24-15.88 38.12Q770.24-280 748-280H308Zm-96 96q-22.24 0-38.12-15.88Q158-215.76 158-238v-462h22v462q0 12 10 22t22 10h462v22H212Z" fill="url(#gradient)"/>`;
    } else {
        followIcon.setAttribute("height", "30px");
        followIcon.setAttribute("width", "30px");
        followIcon.innerHTML = '<path d="M517.5-419.5h22v-124h124v-22h-124v-124h-22v124h-124v22h124v124ZM308-280q-22.24 0-38.12-15.88Q254-311.76 254-334v-440q0-22.24 15.88-38.12Q285.76-828 308-828h440q22.24 0 38.12 15.88Q802-796.24 802-774v440q0 22.24-15.88 38.12Q770.24-280 748-280H308Zm0-22h440q12 0 22-10t10-22v-440q0-12-10-22t-22-10H308q-12 0-22 10t-10 22v440q0 12 10 22t22 10Zm-96 118q-22.24 0-38.12-15.88Q158-215.76 158-238v-462h22v462q0 12 10 22t22 10h462v22H212Zm64-622v504-504Z"/>';
    }
}