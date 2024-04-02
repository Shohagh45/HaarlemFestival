document.addEventListener('DOMContentLoaded', function () {
    var payNowButton = document.getElementById("pay-now");

    if (payNowButton) {
        payNowButton.addEventListener("click", function () {
            checkIfUserExists();
        });
    }

    function checkIfUserExists() {
        fetch('/my-program/payment', {
            method: 'GET',
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'error') {
                swal("Error", data.message, "error").then(() => {
                    payNowButton.disabled = true;
                });
            } else {
                console.log("User exists, proceeding with payment.");
            }
        }).catch(error => {
            console.error('Error:', error);
            swal("Error", "An unexpected error occurred.", "error");
        });
    }
});