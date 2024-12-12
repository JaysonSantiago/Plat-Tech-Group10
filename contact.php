<?php
// Function to read contact information from the user_info.txt file
function getContactInfo() {
    $contactInfo = [];
    $filePath = __DIR__ . "/contact.txt"; // Use absolute path to the file
    
    if (file_exists($filePath)) {
        // Read the entire content of the file
        $fileContent = file_get_contents($filePath);
        
        // Split the file content into lines
        $lines = explode("\n", $fileContent);
        
        // Loop through each line and extract the key-value pairs
        foreach ($lines as $line) {
            $line = trim($line); // Remove any leading or trailing spaces
            if (!empty($line)) {
                // Split the line by the first colon to get key and value
                $parts = explode(":", $line, 2);
                if (count($parts) == 2) {
                    $key = trim($parts[0]);
                    $value = trim($parts[1]);
                    $contactInfo[$key] = $value;
                }
            }
        }
    } else {
        // If the file does not exist, return a 'Not available' message for each field
        $contactInfo = [
            'Phone' => 'Not available',
            'Email' => 'Not available',
            'Birthday' => 'Not available',
            'Age' => 'Not available',
            'Address' => 'Not available'
        ];
    }

    return $contactInfo;
}

// Function to update contact information in the user_info.txt file
function updateContactInfo($phone, $email, $birthday, $age, $address) {
    $data = [
        "Phone" => $phone,
        "Email" => $email,
        "Birthday" => $birthday,
        "Age" => $age,
        "Address" => $address
    ];

    $filePath = __DIR__ . "/contact.txt"; // Use absolute path to the file

    // Open the file for writing (create or overwrite)
    $handle = fopen($filePath, 'w');
    if ($handle) {
        // Write each field to the file, formatted with 'key: value'
        foreach ($data as $key => $value) {
            fwrite($handle, "$key: $value\n");
        }
        // Close the file after writing
        fclose($handle);
    } else {
        // Error handling if unable to write
        echo "Error: Unable to write to $filePath.<br>";
    }
}

// Function to delete contact information from the file
function deleteContactInfo() {
    $filePath = __DIR__ . "/contact.txt";
    
    // Clear the file contents
    if (file_exists($filePath)) {
        file_put_contents($filePath, '');
    } else {
        echo "Error: File does not exist.<br>";
    }
}

// Handle form submission for updating contact info
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        // If the delete button was clicked, delete the contact info
        deleteContactInfo();
    } else {
        // If the form was submitted to update contact info
        $phone = $_POST['phone'] ?? '';
        $email = $_POST['email'] ?? '';
        $birthday = $_POST['birthday'] ?? '';
        $age = $_POST['age'] ?? '';
        $address = $_POST['address'] ?? '';

        if ($phone && $email && $birthday && $age && $address) {
            updateContactInfo($phone, $email, $birthday, $age, $address);
        }
    }
}

$contactInfo = getContactInfo();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Information</title>
    <!-- Link to FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<style>

    /* General Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    background-color: #f4f4f4;
    color: #333;
    padding: 20px;
}

/* Header and Title */
h1, h2 {
    text-align: center;
    color: #444;
    margin-bottom: 20px;
}

/* Contact Information Display */
.contact-items {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
    margin-bottom: 40px;
}

.contact-item {
    background-color: white;
    border-radius: 8px;
    padding: 20px;
    width: 250px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: transform 0.3s;
}

.contact-item:hover {
    transform: scale(1.05);
}

.contact-item i {
    font-size: 2.5em;
    color: #4CAF50  ;
    margin-bottom: 10px;
}

.contact-item h2 {
    font-size: 0.7rem;
    color: blue;
}

/* Form Container */
.form-container {
    max-width: 800px;
    margin: 0 auto;
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.form-container h2 {
    margin-bottom: 20px;
    color: #444;
}

.input-wrapper {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 20px;
}

.input-wrapper div {
    width: 100%;
}

.input-wrapper label {
    display: block;
    margin-bottom: 8px;
    color: #555;
}

.input-wrapper input,
.input-wrapper textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1em;
}

.input-wrapper input:focus,
.input-wrapper textarea:focus {
    outline: none;
    border-color: #4CAF50;
}

textarea {
    resize: vertical;
    min-height: 100px;
}

/* Buttons */
button {
    background-color: #4CAF50;
    color: white;
    padding: 12px 20px;
    font-size: 1em;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
    width: 100%;
}

button:hover {
    background-color: #45a049;
}

button[type="submit"]:not([name="delete"]) {
    margin-bottom: 20px;
}

button[name="delete"] {
    background-color: #f44336;
}

button[name="delete"]:hover {
    background-color: #d32f2f;
}

/* Media Queries */
@media (min-width: 768px) {
    .input-wrapper div {
        width: calc(50% - 15px);
    }

    .contact-items {
        gap: 30px;
    }

    .form-container {
        padding: 30px;
    }
}

@media (min-width: 1024px) {
    .contact-items {
        gap: 40px;
    }
}

</style>



<!-- Displaying current contact information -->
<div class="contact-items">
    <div class="contact-item">
        <i class="fas fa-phone-alt"></i>
        <h2>Phone: <?php echo htmlspecialchars($contactInfo['Phone'] ?? 'Not available'); ?></h2>
    </div>

    <div class="contact-item">
        <i class="fas fa-envelope"></i>
        <h2>Email: <?php echo htmlspecialchars($contactInfo['Email'] ?? 'Not available'); ?></h2>
    </div>

    <div class="contact-item">
        <i class="fas fa-birthday-cake"></i>
        <h2>Birthday: <?php echo htmlspecialchars($contactInfo['Birthday'] ?? 'Not available'); ?></h2>
    </div>

    <div class="contact-item">
        <i class="fas fa-calendar-alt"></i>
        <h2>Age: <?php echo htmlspecialchars($contactInfo['Age'] ?? 'Not available'); ?></h2>
    </div>

    <div class="contact-item">
        <i class="fas fa-home"></i>
        <h2>Address: <?php echo htmlspecialchars($contactInfo['Address'] ?? 'Not available'); ?></h2>
    </div>
</div>

<!-- Compact Form for updating information in a landscape format -->
<div class="form-container">
    <form action="" method="POST">
        <h2>Edit My Information</h2>

        <div class="input-wrapper">
            <div>
                <label for="phone">Phone Number:</label>
                <input type="text" name="phone" id="phone" value="" required>
            </div>

            <div>
                <label for="email">Email Address:</label>
                <input type="email" name="email" id="email" value="" required>
            </div>
        </div>

        <div class="input-wrapper">
            <div>
                <label for="birthday">Date of Birth:</label>
                <input type="date" name="birthday" id="birthday" value="" required>
            </div>

            <div>
                <label for="age">Age:</label>
                <input type="number" name="age" id="age" value="" required>
            </div>
        </div>

        <div class="input-wrapper">
            <div>
                <label for="address">Address:</label>
                <textarea name="address" id="address" required></textarea>
            </div>
        </div>

        <button type="submit">Save Changes</button>
    </form>

    <!-- Delete Button Form -->
    <form action="" method="POST" style="margin-top: 30px;">
        <button type="submit" name="delete">Delete Contact Information</button>
    </form>
</div>

</body>
</html>
<script src="script.js"></script>
