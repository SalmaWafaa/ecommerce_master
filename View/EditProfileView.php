<?php
class EditProfileView {
    public function render($user, $error = null) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Edit Profile</title>
            <style>
                .profile-form {
                    max-width: 500px;
                    margin: 20px auto;
                    padding: 20px;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                }
                .error { color: red; }
            </style>
        </head>
        <body>
            <div class="profile-form">
                <h2>Edit Profile</h2>
                <?php if ($error): ?>
                    <div class="error"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                
                <form method="POST" action="?controller=User&action=updateProfile">
                    <input type="hidden" name="id" value="<?= $user->getId() ?>">
                    
                    <div>
                        <label>First Name:</label>
                        <input type="text" name="firstName" 
                               value="<?= htmlspecialchars($user->getFirstName()) ?>" required>
                    </div>
                    
                    <div>
                        <label>Last Name:</label>
                        <input type="text" name="lastName" 
                               value="<?= htmlspecialchars($user->getLastName()) ?>" required>
                    </div>
                    
                    <div>
                        <label>Email:</label>
                        <input type="email" name="email" 
                               value="<?= htmlspecialchars($user->getEmail()) ?>" required>
                    </div>
                    
                    <div>
                        <label>New Password (leave blank to keep current):</label>
                        <input type="password" name="password">
                    </div>
                    
                    <button type="submit">Save Changes</button>
                </form>
            </div>
        </body>
        </html>
        <?php
    }
}
?>