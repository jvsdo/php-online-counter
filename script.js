// Set the URL of the PHP file that returns the number of visitors
var url = "counter.php";

// Set the update time in milliseconds (1000 = 1 second)
var refreshInterval = 5000; // Update every 5 seconds

// Update the visitor counter
function updateCounter() {
    $.ajax({
        type: "GET",
        url: url,
        success: function(data) {
            // Update the content of the HTML element that displays the number of visitors
            $("#visitors").html(data);
        }
    });
}

// Call the visitor counter update function at the defined interval
setInterval(updateCounter, refreshInterval);
