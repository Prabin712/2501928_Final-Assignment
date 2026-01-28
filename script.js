// Search vehicles
document.getElementById('search')?.addEventListener('keyup', function() {
    let query = this.value;
    fetch('search.php?q=' + query)
        .then(res => res.text())
        .then(data => document.getElementById('result').innerHTML = data);
});

// Check vehicle availability
function checkAvailability(vehicleId) {
    let start = document.getElementById('start').value;
    let end = document.getElementById('end').value;

    if(!start || !end) return;

    fetch(`ajax_check_availability.php?vehicle_id=${vehicleId}&start=${start}&end=${end}`)
        .then(res => res.text())
        .then(data => document.getElementById('availability').innerText = data);
}
