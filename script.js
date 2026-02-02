function checkAvailability(vehicleId) {
    let start = document.getElementById('start').value;
    let end = document.getElementById('end').value;

    if (!start || !end) return;

    fetch(`ajax_check_availability.php?vehicle_id=${vehicleId}&start=${start}&end=${end}`)
        .then(res => res.text())
        .then(data => document.getElementById('availability').innerText = data);
}
