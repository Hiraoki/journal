<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user']['id'];
$journal_file = 'journal.txt';

// Ensure the journal file exists
if (!file_exists($journal_file)) {
    file_put_contents($journal_file, ''); // Create an empty file if it does not exist
}

// Handle saving journal entry
if (isset($_POST['save_entry'])) {
    $entry_text = htmlspecialchars($_POST['entry_text']);
    $entry_id = uniqid(); // Generate a unique ID for the entry
    $timestamp = date('Y-m-d H:i:s'); // Get the current date and time
    $entry = "$user_id|$entry_id|$timestamp|$entry_text\n"; // Include timestamp in the entry
    file_put_contents($journal_file, $entry, FILE_APPEND);
}

// Handle AJAX delete request
if (isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['entry_id'])) {
    $entry_id_to_delete = $_POST['entry_id'];

    // Read current entries
    $entries = file($journal_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // Filter entries to remove the one with the matching ID
    $updated_entries = array_filter($entries, function($entry) use ($entry_id_to_delete) {
        $parts = explode('|', $entry, 4);
        return isset($parts[1]) && $parts[1] !== $entry_id_to_delete;
    });

    // Write back updated entries
    if (file_put_contents($journal_file, implode("\n", $updated_entries) . "\n") !== false) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Unable to write to journal file.']);
    }
    exit;
}

// Fetch journal entries for the logged-in user
$entries = file_exists($journal_file) ? file($journal_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
$user_entries = array_filter($entries, function($entry) use ($user_id) {
    $parts = explode('|', $entry, 4);
    return isset($parts[0]) && $parts[0] == $user_id;
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Journal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            transition: background-color 0.3s, color 0.3s;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #f4f4f4;
            border-bottom: 1px solid #ddd;
        }
        .header .icons {
            display: flex;
            align-items: center;
        }
        .header .icons i {
            margin: 0 5px;
            cursor: pointer;
        }
        .header .icons form {
            margin: 0;
        }
        .journal-form {
            margin: 20px;
        }
        .journal-form textarea {
            width: 100%;
            height: 100px;
            margin-bottom: 10px;
        }
        .journal-entry {
            margin: 20px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
        }
        .journal-entry .delete {
            color: red;
            cursor: pointer;
        }
        .dark-mode {
            background-color: #333;
            color: #fff;
        }
        .dark-mode .header {
            background-color: #444;
        }
        .dark-mode .journal-entry {
            background-color: #555;
        }
        .dark-mode .icons .fa-moon {
            color: #fff;
        }
        .dark-mode .icons .fa-sun {
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="icons">
            <i id="darkModeToggle" class="fas fa-moon" title="Toggle Dark Mode"></i>
            <form method="POST" action="home.php">
                <button type="submit" style="background: none; border: none; cursor: pointer; color: black;">
                    <i class="fas fa-sign-out-alt" title="Logout"></i>
                </button>
            </form>
        </div>
    </div>
    <div class="journal-form">
        <form method="POST" action="">
            <textarea name="entry_text" placeholder="Type your journal entry here..."></textarea>
            <button type="submit" name="save_entry">Save Entry</button>
        </form>
    </div>
    <div class="journal-entries">
        <?php foreach ($user_entries as $entry) {
            $parts = explode('|', trim($entry), 4); // Limit to 4 parts
            if (count($parts) === 4) { // Ensure there are exactly 4 parts
                list($entry_user_id, $entry_id, $timestamp, $entry_text) = $parts;
        ?>
            <div class="journal-entry" data-entry-id="<?php echo htmlspecialchars($entry_id); ?>">
                <p><strong>Date:</strong> <?php echo htmlspecialchars($timestamp); ?></p>
                <p><?php echo htmlspecialchars($entry_text); ?></p>
                <a href="#" class="delete">Delete</a>
            </div>
        <?php } } ?>
    </div>

    <script>
        document.querySelectorAll('.delete').forEach(function(deleteLink) {
            deleteLink.addEventListener('click', function(event) {
                event.preventDefault();
                
                var entryDiv = this.closest('.journal-entry');
                var entryId = entryDiv.getAttribute('data-entry-id');

                if (confirm('Are you sure you want to delete this entry?')) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', '', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            var response = JSON.parse(xhr.responseText);
                            if (response.status === 'success') {
                                entryDiv.remove();
                            } else {
                                alert('Error: ' + response.message);
                            }
                        } else {
                            alert('Request failed. Returned status of ' + xhr.status);
                        }
                    };
                    xhr.send('action=delete&entry_id=' + encodeURIComponent(entryId));
                }
            });
        });

        document.getElementById('darkModeToggle').addEventListener('click', function() {
            const body = document.body;
            const isDarkMode = body.classList.toggle('dark-mode');
            this.classList.toggle('fa-sun', isDarkMode);
            this.classList.toggle('fa-moon', !isDarkMode);
            localStorage.setItem('dark-mode', isDarkMode ? 'enabled' : 'disabled');
        });

        // Load the dark mode preference on page load
        document.addEventListener('DOMContentLoaded', function() {
            const darkMode = localStorage.getItem('dark-mode');
            if (darkMode === 'enabled') {
                document.body.classList.add('dark-mode');
                document.getElementById('darkModeToggle').classList.add('fa-sun');
            } else {
                document.getElementById('darkModeToggle').classList.add('fa-moon');
            }
        });
    </script>
</body>
</html>
