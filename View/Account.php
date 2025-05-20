<?php
session_start();
require_once '../Model/db_connection.php';
require_once '../Controller/User.php';


if (!isset($_SESSION['user_id'])) {
    header('Location: Login.html');
    exit;
}

$userId = $_SESSION['user_id'];

// Fetch user info
$stmt = $pdo->prepare('SELECT * FROM user WHERE User_ID = ?');
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);



// Fetch trip history for the user
$trips = [];
$tripStmt = $pdo->prepare('SELECT * FROM ticket WHERE User_ID = ? ORDER BY Ticket_ID DESC LIMIT 10');
$tripStmt->execute([$userId]);
$trips = $tripStmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="Homepage.html" class="flex items-center">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2L3 7v11a1 1 0 001 1h3a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1V7l-7-5z"/>
                            </svg>
                        </div>
                        <span class="ml-2 text-gray-900 font-bold">C2C</span>
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="Homepage.html" class="text-gray-700 hover:text-purple-600 font-medium transition-colors">Home</a>
                    <a href="FAQ.html" class="text-gray-700 hover:text-purple-600 font-medium transition-colors">FAQ</a>
                    <a href="AboutUs.html" class="text-gray-700 hover:text-purple-600 font-medium transition-colors">About us</a>
                </div>
                <div>
                    <a href="Account.php" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition-colors font-medium">Account</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="max-w-4xl mx-auto mt-8 px-4">
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <div class="flex flex-col md:flex-row">
                <div class="flex-shrink-0 mb-4 md:mb-0">
                    <div class="h-24 w-24 rounded-full bg-gray-300 flex items-center justify-center">
                        <svg class="h-16 w-16 text-gray-200" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"></path>
                        </svg>
                    </div>
                </div>
                <div class="md:ml-6 flex-grow">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800"><?php echo htmlspecialchars($user['F_name'] . ' ' . $user['L_name']); ?></h2>
                            <p class="text-gray-600 text-sm mt-1"><?php echo htmlspecialchars($user['email']); ?></p>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <div class="text-right">
                                <p class="text-sm text-gray-600">Total Points:</p>
                                <p class="text-3xl font-bold text-gray-800"><?php echo htmlspecialchars($user['Points']); ?> <span class="text-sm font-normal">pts</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-green-700 mb-4">Trips History</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="col-span-2">
                    <?php if (!empty($trips)): foreach ($trips as $trip): ?>
                        <div class="bg-gray-50 rounded p-4 mb-4">
                            <p class="text-sm text-gray-700">From: <?php echo htmlspecialchars($trip['start_station']); ?></p>
                            <p class="text-sm text-gray-700">To: <?php echo htmlspecialchars($trip['end_station']); ?></p>
                            <p class="text-xs text-gray-400 mt-1">Date: <?php echo htmlspecialchars($trip['date']); ?></p>
                        </div>
                    <?php endforeach; else: ?>
                        <div class="text-gray-400 text-sm">No trips found.</div>
                    <?php endif; ?>
                </div>
                <div class="col-span-1">
                    <div class="bg-gray-200 rounded h-32 flex items-center justify-center">
                        <p class="text-sm text-gray-600 text-center">travel/city card with info<br>and balance</p>
                    </div>
                </div>
            </div>
            <div class="mt-12 text-right">
                <form method="post" action="../Controller/delete_account.php" onsubmit="return confirm('Are you sure you want to delete your account?');">
                    <button type="submit" class="bg-red-100 text-red-600 px-4 py-2 rounded text-sm hover:bg-red-200">delete account</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
