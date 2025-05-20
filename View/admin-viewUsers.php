<?php
require_once '../Model/db_connection.php';
require_once '../Controller/Admin.php';
$admin = new Admin($pdo);
$users = $admin->listUsers();

$showSuccess = false;
if (isset($_GET['added']) && $_GET['added'] === '1') {
    $showSuccess = true;
}

$showDelete = false;
if (isset($_GET['deleted']) && $_GET['deleted'] === '1') {
    $showDelete = true;
}

$showEdit = false;
if (isset($_GET['edited']) && $_GET['edited'] === '1') {
    $showEdit = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - View Users</title>
    <link rel="stylesheet" href="homepage.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-green-50 via-white to-purple-100 min-h-screen">
    <nav class="bg-white shadow-md mb-8 sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
            <a href="admin_interface.html" class="flex items-center text-green-600 font-bold text-xl hover:underline">
                <svg class="w-6 h-6 mr-2 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                Back to Dashboard
            </a>
            <span class="text-gray-700 font-semibold tracking-wide text-lg">Admin Panel</span>
        </div>
    </nav>
    <main class="max-w-5xl mx-auto bg-white rounded-2xl shadow-xl p-10 mt-8 mb-12">
        <h1 class="text-4xl font-extrabold mb-8 text-center text-green-700 flex items-center justify-center gap-2">
            <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 21v-2a4 4 0 00-3-3.87M4 21v-2a4 4 0 013-3.87m9-7.13a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            User Management
        </h1>
        <div class="overflow-x-auto rounded-lg shadow mb-10">
            <table class="min-w-full border rounded-lg overflow-hidden bg-white">
                <thead>
                    <tr class="bg-gradient-to-r from-green-100 to-purple-100 text-gray-700">
                        <th class="py-3 px-4 border">ID</th>
                        <th class="py-3 px-4 border">Email</th>
                        <th class="py-3 px-4 border">Name</th>
                        <th class="py-3 px-4 border">Discount</th>
                        <th class="py-3 px-4 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($users)): foreach ($users as $user): ?>
                    <tr class="hover:bg-green-50 transition">
                        <td class="py-2 px-4 border text-center font-semibold text-green-700"><?= htmlspecialchars($user['User_ID']) ?></td>
                        <td class="py-2 px-4 border text-center"><?= htmlspecialchars($user['email']) ?></td>
                        <td class="py-2 px-4 border text-center"><?= htmlspecialchars($user['F_name'] . ' ' . $user['L_name']) ?></td>
                        <td class="py-2 px-4 border text-center">
                            <span class="inline-block px-2 py-1 rounded bg-purple-100 text-purple-700 text-xs font-semibold">
                                <?= htmlspecialchars($user['discount_type'] ?? '-') ?>
                            </span>
                        </td>
                        <td class="py-2 px-4 border text-center">
                            <form method="post" action="../Controller/Admin.php" style="display:inline;">
                                <input type="hidden" name="action" value="deleteUser">
                                <input type="hidden" name="userId" value="<?= htmlspecialchars($user['User_ID']) ?>">
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 transition">Delete</button>
                            </form>
                            <button type="button" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 ml-1 transition" data-edit-user
                                data-user-id="<?= htmlspecialchars($user['User_ID']) ?>"
                                data-fname="<?= htmlspecialchars($user['F_name']) ?>"
                                data-lname="<?= htmlspecialchars($user['L_name']) ?>"
                                data-email="<?= htmlspecialchars($user['email']) ?>"
                                data-ssn="<?= htmlspecialchars($user['SSN']) ?>"
                            >Edit</button>
                            <form method="post" action="../Controller/Admin.php" style="display:inline; margin-left:4px;">
                                <input type="hidden" name="action" value="applyDiscount">
                                <input type="hidden" name="userId" value="<?= htmlspecialchars($user['User_ID']) ?>">
                                <input type="text" name="discountType" placeholder="Type" class="border px-1 py-0.5 rounded text-xs w-20 focus:ring-2 focus:ring-purple-200">
                                <button type="submit" class="bg-purple-500 text-white px-2 py-1 rounded hover:bg-purple-600 transition">Discount</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="5" class="py-6 text-center text-gray-400">No users found.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="bg-gradient-to-r from-green-100 to-purple-100 rounded-xl p-8 mb-10 shadow flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h2 class="text-2xl font-bold mb-2 text-green-700">Add New User</h2>
                <p class="text-gray-600 text-sm">Fill in the details to add a new user to the system.</p>
            </div>
            <form method="post" action="../Controller/Admin.php" class="flex flex-wrap gap-2 items-end" onsubmit="return handleAddUserSubmit(event)">
                <input type="hidden" name="action" value="addUser">
                <input type="text" name="F_name" placeholder="First Name" class="border px-2 py-1 rounded focus:ring-2 focus:ring-green-200">
                <input type="text" name="L_name" placeholder="Last Name" class="border px-2 py-1 rounded focus:ring-2 focus:ring-green-200">
                <input type="email" name="email" placeholder="Email" class="border px-2 py-1 rounded focus:ring-2 focus:ring-green-200">
                <input type="password" name="password" placeholder="Password" class="border px-2 py-1 rounded focus:ring-2 focus:ring-green-200">
                <input type="number" name="SSN" placeholder="SSN" class="border px-2 py-1 rounded focus:ring-2 focus:ring-green-200">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">Add User</button>
            </form>
        </div>
    </main>
    <!-- Edit User Modal -->
    <div id="editUserModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md relative">
            <button onclick="closeEditModal()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
            <h2 class="text-xl font-bold mb-4 text-center text-blue-700">Edit User</h2>
            <form id="editUserForm" method="post" action="../Controller/Admin.php" class="space-y-3">
                <input type="hidden" name="action" value="editUserSave">
                <input type="hidden" name="userId" id="editUserId">
                <div>
                    <label class="block text-xs text-gray-500 mb-1">First Name</label>
                    <input type="text" name="F_name" id="editFName" class="w-full border px-2 py-1 rounded focus:ring-2 focus:ring-blue-200">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Last Name</label>
                    <input type="text" name="L_name" id="editLName" class="w-full border px-2 py-1 rounded focus:ring-2 focus:ring-blue-200">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Email</label>
                    <input type="email" name="email" id="editEmail" class="w-full border px-2 py-1 rounded focus:ring-2 focus:ring-blue-200">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Password <span class="text-gray-400">(leave blank to keep unchanged)</span></label>
                    <input type="password" name="password" id="editPassword" class="w-full border px-2 py-1 rounded focus:ring-2 focus:ring-blue-200">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">SSN</label>
                    <input type="number" name="SSN" id="editSSN" class="w-full border px-2 py-1 rounded focus:ring-2 focus:ring-blue-200">
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transition">Save Changes</button>
            </form>
        </div>
    </div>
    <?php if ($showSuccess): ?>
    <div id="successModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
        <div class="bg-white rounded-xl shadow-2xl p-8 max-w-sm w-full flex flex-col items-center">
            <svg class="w-16 h-16 text-green-500 mb-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
            <h3 class="text-2xl font-bold text-green-700 mb-2">User Added!</h3>
            <p class="text-gray-600 mb-6 text-center">The user has been added successfully.</p>
            <button onclick="closeSuccessModal()" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 font-semibold">Confirm</button>
        </div>
    </div>
    <script>
    function closeSuccessModal() {
        document.getElementById('successModal').style.display = 'none';
        window.history.replaceState({}, document.title, window.location.pathname);
    }
    </script>
    <?php endif; ?>
    <?php if ($showDelete): ?>
    <div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
        <div class="bg-white rounded-xl shadow-2xl p-8 max-w-sm w-full flex flex-col items-center">
            <svg class="w-16 h-16 text-red-500 mb-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            <h3 class="text-2xl font-bold text-red-700 mb-2">User Deleted</h3>
            <p class="text-gray-600 mb-6 text-center">The user has been deleted successfully.</p>
            <button onclick="closeDeleteModal()" class="bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600 font-semibold">Confirm</button>
        </div>
    </div>
    <script>
    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
        window.history.replaceState({}, document.title, window.location.pathname);
    }
    </script>
    <?php endif; ?>
    <?php if ($showEdit): ?>
    <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
        <div class="bg-white rounded-xl shadow-2xl p-8 max-w-sm w-full flex flex-col items-center">
            <svg class="w-16 h-16 text-blue-500 mb-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            <h3 class="text-2xl font-bold text-blue-700 mb-2">User Updated</h3>
            <p class="text-gray-600 mb-6 text-center">The user information has been updated successfully.</p>
            <button onclick="closeEditModalSuccess()" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 font-semibold">Confirm</button>
        </div>
    </div>
    <script>
    function closeEditModalSuccess() {
        document.getElementById('editModal').style.display = 'none';
        window.history.replaceState({}, document.title, window.location.pathname);
    }
    </script>
    <?php endif; ?>
    <script>
        function openEditModal(userId, fName, lName, email, ssn) {
            document.getElementById('editUserId').value = userId;
            document.getElementById('editFName').value = fName;
            document.getElementById('editLName').value = lName;
            document.getElementById('editEmail').value = email;
            document.getElementById('editSSN').value = ssn;
            document.getElementById('editPassword').value = '';
            document.getElementById('editUserModal').classList.remove('hidden');
        }
        function closeEditModal() {
            document.getElementById('editUserModal').classList.add('hidden');
        }
        // Attach to edit buttons
        window.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('button[data-edit-user]').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    openEditModal(
                        btn.getAttribute('data-user-id'),
                        btn.getAttribute('data-fname'),
                        btn.getAttribute('data-lname'),
                        btn.getAttribute('data-email'),
                        btn.getAttribute('data-ssn')
                    );
                });
            });
        });
        function handleAddUserSubmit(e) {
            // Let the form submit, but after redirect, show modal
            setTimeout(function() {
                if (window.location.search.indexOf('added=1') === -1) {
                    window.location = window.location.pathname + '?added=1';
                }
            }, 100);
            return true;
        }
    </script>
</body>
</html>
