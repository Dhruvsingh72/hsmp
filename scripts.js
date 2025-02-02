function showForm(formId) {
    const forms = document.querySelectorAll('.form-section');
    forms.forEach(form => {
        if (form.id === formId) {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    });
}

function registerPatient(event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    const data = Object.fromEntries(formData.entries());

    fetch('/register-patient', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        alert(result.message);
        if (result.patientId) {
            showForm('patientDashboard');
            loadPatientAppointments(result.patientId);
        }
    });
}

function bookAppointment(event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    const data = Object.fromEntries(formData.entries());

    fetch('/book-appointment', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        alert(result.message);
        loadPatientAppointments(); // Implement this function to reload the patient's appointments
    });
}

function loginDoctor(event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    const data = Object.fromEntries(formData.entries());

    fetch('/login-doctor', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        alert(result.message);
        if (result.doctorId) {
            showForm('doctorDashboard');
            loadAppointments(result.doctorId); // Implement this function to load the doctor's appointments
        }
    });
}

function loginAdmin(event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    const data = Object.fromEntries(formData.entries());

    fetch('/login-admin', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        alert(result.message);
        if (result.adminId) {
            showForm('adminDashboard');
            loadAdminData(); // Implement this function to load all admin data
        }
    });
}

function loadAppointments(doctorId) {
    fetch(`/appointments?doctorId=${doctorId}`)
    .then(response => response.json())
    .then(appointments => {
        const appointmentsList = document.getElementById('appointmentsList');
        appointmentsList.innerHTML = '';

        appointments.forEach(appointment => {
            const listItem = document.createElement('li');
            listItem.textContent = `Patient: ${appointment.patient}, Date: ${appointment.date}, Time: ${appointment.time}`;
            const cancelButton = document.createElement('button');
            cancelButton.textContent = 'Cancel';
            cancelButton.onclick = () => cancelAppointment(appointment.id);
            listItem.appendChild(cancelButton);
            appointmentsList.appendChild(listItem);
        });
    });
}

function cancelAppointment(appointmentId) {
    fetch(`/cancel-appointment/${appointmentId}`, {
        method: 'DELETE'
    })
    .then(response => response.json())
    .then(result => {
        alert(result.message);
        loadAppointments(); // Implement this function to reload the appointments list
    });
}

function loadPatientAppointments(patientId) {
    fetch(`/appointments?patientId=${patientId}`)
    .then(response => response.json())
    .then(appointments => {
        const patientAppointmentsList = document.getElementById('patientAppointmentsList');
        patientAppointmentsList.innerHTML = '';

        appointments.forEach(appointment => {
            const listItem = document.createElement('li');
            listItem.textContent = `Doctor: ${appointment.doctor}, Date: ${appointment.date}, Time: ${appointment.time}`;
            const cancelButton = document.createElement('button');
            cancelButton.textContent = 'Cancel';
            cancelButton.onclick = () => cancelPatientAppointment(appointment.id);
            listItem.appendChild(cancelButton);
            patientAppointmentsList.appendChild(listItem);
        });
    });
}

function cancelPatientAppointment(appointmentId) {
    fetch(`/cancel-appointment/${appointmentId}`, {
        method: 'DELETE'
    })
    .then(response => response.json())
    .then(result => {
        alert(result.message);
        loadPatientAppointments(); // Implement this function to reload the patient's appointments list
    });
}

function loadAdminData() {
    fetch('/admin-data')
    .then(response => response.json())
    .then(data => {
        const { patients, doctors, appointments } = data;

        // Load patients
        const patientList = document.getElementById('patientList');
        patientList.innerHTML = '';
        patients.forEach(patient => {
            const listItem = document.createElement('li');
            listItem.textContent = `Name: ${patient.firstName} ${patient.lastName}, Email: ${patient.email}, Contact: ${patient.contact}`;
            patientList.appendChild(listItem);
        });

        // Load doctors
        const doctorList = document.getElementById('doctorList');
        doctorList.innerHTML = '';
        doctors.forEach(doctor => {
            const listItem = document.createElement('li');
            listItem.textContent = `Name: ${doctor.name}, Email: ${doctor.email}`;
            const removeButton = document.createElement('button');
            removeButton.textContent = 'Remove';
            removeButton.onclick = () => removeDoctor(doctor.id);
            listItem.appendChild(removeButton);
            doctorList.appendChild(listItem);
        });

        // Load appointments
        const adminAppointmentsList = document.getElementById('adminAppointmentsList');
        adminAppointmentsList.innerHTML = '';
        appointments.forEach(appointment => {
            const listItem = document.createElement('li');
            listItem.textContent = `Patient: ${appointment.firstName} ${appointment.lastName}, Email: ${appointment.email}, Contact: ${appointment.contact}, Doctor: ${appointment.doctorName}, Date: ${appointment.date}, Time: ${appointment.time}`;
            adminAppointmentsList.appendChild(listItem);
        });
    });
}

function addDoctor(event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    const data = Object.fromEntries(formData.entries());

    fetch('/add-doctor', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        alert(result.message);
        loadAdminData(); // Refresh the list of doctors
    });
}

function removeDoctor(doctorId) {
    fetch(`/remove-doctor/${doctorId}`, {
        method: 'DELETE'
    })
    .then(response => response.json())
    .then(result => {
        alert(result.message);
        loadAdminData(); // Refresh the list of doctors
    });
}

function logoutDoctor() {
    alert("Doctor logged out successfully!");
    showForm('doctorModule');
}

function logoutAdmin() {
    alert("Admin logged out successfully!");
    showForm('adminModule');
}
