<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Records - Best Medical</title>
    <link rel="stylesheet" href="../assets/css/style.css">
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
            <li><a href="index.php?page=doctorPage">Back to Doctor Dashboard</a></li>
            <li><a href="index.php?page=logout" class="logout">Log Out</a></li>
        </ul>
    </aside>
    <!-- Main Content -->
    <main class="with-sidebar">
        <section id="edit-medical-record">
            <h2>Edit Medical Record</h2>
            <form action="#" method="post">
                <!-- Patient Name Dropdown -->
                <label for="patient-name">Patient Name:</label>
                <select id="patient-name" name="patient-name" required>
                    <option value="" disabled selected>Select a patient</option>
                    <option value="P001">John Doe (P001)</option>
                    <option value="P002">Alice Johnson (P002)</option>
                    <option value="P003">Michael Brown (P003)</option>
                </select>

                <!-- Visit Date -->
                <label for="visit-date">Visit Date:</label>
                <input type="date" id="visit-date" name="visit-date" required>

                <!-- Diagnosis -->
                <label for="diagnosis">Diagnosis:</label>
                <input type="text" id="diagnosis" name="diagnosis" placeholder="Enter diagnosis" required>

                <!-- Prescription -->
                <label for="prescription">Prescription:</label>
                <input type="text" id="prescription" name="prescription" placeholder="Enter prescription" required>

                <!-- Notes -->
                <label for="notes">Notes:</label>
                <textarea id="notes" name="notes" rows="6" placeholder="Add additional notes"></textarea>

                <!-- Submit Button -->
                <button type="submit">Save Changes</button>
            </form>
        </section>
    </main>

</body>
</html>