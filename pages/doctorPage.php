<!DOCTYPE html>
<html lang="en">
<h1>Doctor Page</h1>

<?php 
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit;
    }
    
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard - Best Medical</title>
    <link rel="stylesheet" href="..\assets\css\style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="logo">
            <img src="../assets/images/logo.png" alt="Best Medical Logo">
            <h1>Best Medical</h1>
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar">
        <ul>
            <li><a href="index.php?page=logout" class="logout">Log Out</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main>
        <section id="profile">
            <h2>Doctor Profile</h2>
            <div class="profile-card">
                <h3>Name: Dr. Jane Smith</h3>
                <p>ID: D001</p>
                <p>Specialization: Cardiology</p>
                <p>Email: jane.smith@example.com</p>
            </div>
        </section>

        <section id="patients">
            <h2>Patients Under Care</h2>
            <ul class="patient-list">
                <li>
                    <h3>Patient: John Doe</h3>
                    <p>ID: P001</p>
                    <a href="#" class="view-details" data-patient-id="P001">View Medical Records</a>
                </li>
                <li>
                    <h3>Patient: Alice Johnson</h3>
                    <p>ID: P002</p>
                    <a href="#" class="view-details" data-patient-id="P002">View Medical Records</a>
                </li>
            </ul>
        </section>
    </main>

    <!-- Modal for Medical Records -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Medical Records</h2>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Diagnosis</th>
                    </tr>
                </thead>
                <tbody id="modal-body">
                    <!-- Dynamic content will be inserted here -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2023 Best Medical. All rights reserved.</p>
    </footer>

    <script>
        // Modal functionality
        const modal = document.getElementById("modal");
        const closeBtn = document.querySelector(".close");

        // Close modal when clicking the close button or outside the modal
        closeBtn.onclick = () => modal.style.display = "none";
        window.onclick = (event) => {
            if (event.target === modal) modal.style.display = "none";
        };

        // Handle "View Medical Records" clicks
        document.querySelectorAll(".view-details").forEach(link => {
            link.addEventListener("click", (e) => {
                e.preventDefault();
                const patientId = e.target.dataset.patientId;

                // Mock data for demonstration
                const records = {
                    "P001": [
                        { date: "2023-01-15", description: "Annual Checkup", diagnosis: "Healthy" },
                        { date: "2023-02-20", description: "Flu Symptoms", diagnosis: "Influenza" }
                    ],
                    "P002": [
                        { date: "2023-03-10", description: "Routine Blood Test", diagnosis: "Normal" },
                        { date: "2023-04-05", description: "Allergy Test", diagnosis: "Allergic to Pollen" }
                    ]
                };

                // Populate modal with data
                const modalBody = document.getElementById("modal-body");
                modalBody.innerHTML = "";
                records[patientId].forEach(record => {
                    const row = `<tr>
                                    <td>${record.date}</td>
                                    <td>${record.description}</td>
                                    <td>${record.diagnosis}</td>
                                 </tr>`;
                    modalBody.insertAdjacentHTML("beforeend", row);
                });

                // Show modal
                modal.style.display = "block";
            });
        });
    </script>



</body>
</html>