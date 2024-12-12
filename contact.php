<?php
// Function to read contact information from the user_info.txt file
function getContactInfo() {
    $contactInfo = [];
    $filePath = __DIR__ . "/user_info.txt"; // Use absolute path to the file
    
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

    $filePath = __DIR__ . "/user_info.txt"; // Use absolute path to the file

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

// Handle form submission for updating contact info
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    $birthday = $_POST['birthday'] ?? '';
    $age = $_POST['age'] ?? '';
    $address = $_POST['address'] ?? '';

    if ($phone && $email && $birthday && $age && $address) {
        updateContactInfo($phone, $email, $birthday, $age, $address);
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
        <h2>Update My Information</h2>

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
</div>

<style>
    /* General body styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
}

/* Container for contact items */
.contact-items {
    margin-bottom: 20px;
}

/* Individual contact item styles */
.contact-item {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 15px;
    margin: 10px 0;
    display: flex;
    align-items: center;
}

.contact-item i {
    font-size: 24px;
    color: #007BFF;
    margin-right: 15px;
}

/* Form container styling */
.form-container {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

/* Form heading */
.form-container h2 {
    margin-bottom: 20px;
    font-size: 24px;
}

/* Input wrapper styling */
.input-wrapper {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
}

/* Individual input field styling */
.input-wrapper div {
    flex: 1;
    margin-right: 10px;
}

.input-wrapper div:last-child {
    margin-right: 0; /* Remove margin from the last item */
}

/* Input and textarea styling */
input[type="text"],
input[type="email"],
input[type="date"],
input[type="number"],
textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-sizing: border-box; /* Include padding in width calculation */
}

/* Button styling */
button {
    background-color: #007BFF;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

button:hover {
    background-color: #0056b3;
}

/* Responsive adjustments */
@media (max-width: 600px) {
    .input-wrapper {
        flex-direction: column; /* Stack inputs vertically on small screens */
    }

    .input-wrapper div {
        margin-right: 0;
        margin-bottom: 10px; /* Add bottom margin for spacing */
    }
}
</style>


</body>
</html>
