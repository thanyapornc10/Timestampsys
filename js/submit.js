document.addEventListener("DOMContentLoaded", function () {
    const attendanceForm = document.getElementById("attendance-form");

    attendanceForm.addEventListener("submit", function (e) {
        e.preventDefault();

        // Get form data
        const formData = new FormData(attendanceForm);
        const action = attendanceForm.querySelector('input[type="submit"]').getAttribute("name");

        // Create an XMLHttpRequest object
        const xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Handle the response from the server
                // You can display a success message or handle errors here
            }
        };

        // Define the method (POST) and the URL to send the data to (the same page)
        xhr.open("POST", window.location.href, true);

        // Send the request
        xhr.send(formData);
    });
});
