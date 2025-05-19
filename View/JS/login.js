 // Check if user is already logged in
 document.addEventListener('DOMContentLoaded', function() {
    // Check if user is already logged in
    const isLoggedIn = localStorage.getItem('isLoggedIn');
    if (isLoggedIn) {
        // Redirect to account page if already logged in
        window.location.href = 'Account.html';
    }
    
    // Set up login form submission handler
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const userIdentifier = document.getElementById('userIdentifier').value;
        const password = document.getElementById('password').value;
        const errorMessage = document.getElementById('errorMessage');
        
        // Simple validation
        if (!userIdentifier || !password) {
            errorMessage.textContent = 'Please enter both identifier and password';
            errorMessage.classList.remove('hidden');
            return;
        }
        
        // This is a demo login - in a real app, you would validate against your backend
        // For demo purposes, let's accept any non-empty values
        if (userIdentifier && password) {
            // Save login state and some user data
            localStorage.setItem('isLoggedIn', 'true');
            
            // Store some dummy user data
            const userData = {
                name: userIdentifier.includes('@') ? userIdentifier.split('@')[0] : 'Jane Doe',
                email: userIdentifier.includes('@') ? userIdentifier : 'jane.doe@example.com',
                phone: '+1 (555) 987-6543',
                id: 'MT-' + Math.floor(100000 + Math.random() * 900000)
            };
            
            localStorage.setItem('userData', JSON.stringify(userData));
            
            // Redirect to account page
            window.location.href = 'Account.html';
        } else {
            errorMessage.textContent = 'Invalid credentials';
            errorMessage.classList.remove('hidden');
        }
    });
});