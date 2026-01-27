document.getElementById('search').addEventListener('keyup', function() {
    let query = this.value;
    fetch('ajax_search.php?q=' + query)
        .then(res => res.text())
        .then(data => document.getElementById('result').innerHTML = data);
});

// Auto check availability
function checkAvailability(vehicleId) {
    let start = document.getElementById('start').value;
    let end = document.getElementById('end').value;

    fetch(`ajax_check_availability.php?vehicle_id=${vehicleId}&start=${start}&end=${end}`)
        .then(res => res.text())
        .then(data => document.getElementById('availability').innerText = data);
}
