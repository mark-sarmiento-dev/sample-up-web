<template>
    <main class="login-container">
        <section class="left" aria-label="Decorative Image">
        </section>
        <section class="right">
            <!-- Logo -->
            <img src="images/logo.png" alt="Company Logo" class="logo" />
            <!-- Title -->
            <h1>
                LOGIN
            </h1>
            <!-- Error Message -->
            <!-- <div class="error-message">
            Invalid username or password
            </div> -->
            <!-- Form -->
            <form>
                <label for="username">
                    Username
                </label>
                <input type="text" id="username" placeholder="Username" required>
                <label for="password">
                    Password
                </label>
                <input type="password" id="password" placeholder="Password" required>
                <!-- Forgot Password link -->
                <div class="forgot-password">
                    <a href="#">
                        Forgot Password?
                    </a>
                </div>
                <button type="submit">
                    Login
                </button>
            </form>
            <!-- Sign up link -->
            <div class="signup">
                Don’t have an account?
                <a href="#">
                    Sign up
                </a>
            </div>
        </section>
    </main>
</template>
<script>
</script>