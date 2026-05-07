function validateForm() {

    let title = document.getElementById("title").value;
    let assigned = document.getElementById("assigned_to").value;

    if(title == "" || assigned == "") {

        document.getElementById("error-msg").innerHTML =
            "All fields are required";

        return false;
    }

    return true;
}

function loadTickets(status) {

    let xhr = new XMLHttpRequest();

    xhr.open("GET", "ajax.php?status=" + status, true);

    xhr.onload = function() {

        if(this.status == 200) {

            document.getElementById("ticket-data").innerHTML =
                this.responseText;
        }
    };

    xhr.send();
}