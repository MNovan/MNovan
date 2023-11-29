// Declare the appName variable in a higher scope
var appName;

// Function to retrieve the app data using AJAX
function fetchAppData() {
    // Retrieve the app name from the HTML element
    var appNameElement = document.getElementById("app-name");
    appName = appNameElement.innerText;

    // Make an AJAX request to the PHP script with the app name
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "./php/ps.php?app_name=" + encodeURIComponent(appName), true); // Include the app_name parameter in the URL
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Handle the response from the PHP script
            var response = JSON.parse(xhr.responseText);
            console.log(response);

            // Update the star rating
            var starRatingElement = document.getElementById("starRating");
            starRatingElement.innerHTML = response.rating + ' <i class="fa fa-star"></i>';

            // Update the number of downloads
            var downloadCountElement = document.getElementById("downloadCount");
            downloadCountElement.innerHTML = response.downloads + ' <br> Downloads';
        }
    };
    xhr.send();
}

// Call the fetchAppData function to update the star rating and number of downloads on page load
fetchAppData();

// Update the number of downloads when the 'Install' button is clicked
var installButton = document.getElementById('installButton');
installButton.addEventListener('click', function() {
    var downloadCountElement = document.getElementById('downloadCount');
    var currentDownloadCount = parseInt(downloadCountElement.innerHTML.split('<br>')[0].trim());
    var newDownloadCount = currentDownloadCount + 1;
    downloadCountElement.innerHTML = newDownloadCount + ' <br> Downloads';

    // Update the download count in the database using AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "./php/update_downloads.php?app_name=" + encodeURIComponent(appName) + "&download_count=" + newDownloadCount, true);
    xhr.send();
});

// Handle the star button click event
var starButton = document.getElementById('starButton');
starButton.addEventListener('click', function() {
    // Update the star rating on the client-side
    var starRatingElement = document.getElementById('starRating');
    var currentRating = parseFloat(starRatingElement.innerHTML);
    var newRating = currentRating + 0.5;
    starRatingElement.innerHTML = newRating.toFixed(1) + ' <i class="fa fa-star"></i>';

    // Update the star rating in the database using AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "./php/update_star_rating.php?app_name=" + encodeURIComponent(appName) + "&star_rating=" + newRating, true);
    xhr.send();
});

// Call the fetchAppData function when the page finishes loading
window.addEventListener("load", fetchAppData);