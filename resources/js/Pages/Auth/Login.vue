<template>
    <main class="login-container">
        <section class="left" aria-label="Decorative Image"></section>

        <section class="right">
            <img src="/images/logo.png" alt="Company Logo" class="logo" />
            <h1>LOGIN</h1>

            <!-- Display errors -->
            <div v-if="Object.keys(form.errors).length" class="error-message">
                <ul>
                    <li v-for="(errorMessages, field) in form.errors" :key="field">
                        <span v-for="(error, index) in [].concat(errorMessages)" :key="index">
                            {{ error }}
                        </span>
                    </li>
                </ul>
            </div>

            <!-- Login form -->
            <form @submit.prevent="submit">
                <label for="gsis_id">GSIS ID</label>
                <input
                    type="text"
                    id="gsis_id"
                    v-model="form.gsis_id"
                    placeholder="GSIS ID"
                    required
                    autocomplete="username"
                />

                <label for="password">Password</label>
                <div class="password-wrapper">
                    <input
                        :type="showPassword ? 'text' : 'password'"
                        id="password"
                        v-model="form.password"
                        placeholder="Password"
                        required
                        autocomplete="current-password"
                    />
                    <span class="toggle-password" @click="togglePassword">
                        <img src="images/icons/hide-pass.png" v-if="!showPassword" />
                        <img src="images/icons/show-pass.png" v-else />
                    </span>
                </div>

                <div class="forgot-password">
                    <a @click="openForgotPasswordModal" href="#">Forgot Password?</a>
                </div>

                <!-- Use Button component instead of native button -->
                <Button
                    variant="primary"
                    size="lg"
                    type="submit"
                    :disabled="form.processing"
                >
                    <span v-if="form.processing">Logging in...</span>
                    <span v-else>Login</span>
                </Button>
            </form>
            <ForgotPasswordModal v-model="showForgotPasswordModal" />
        </section>
    </main>
</template>


<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import axios from "axios";

const form = useForm({
  gsis_id: "",
  password: "",
});

const showPassword = ref(false);

const togglePassword = () => {
  showPassword.value = !showPassword.value;
};

const submit = async () => {
  form.post("/login", {
    onFinish: async () => {
      // only try createToken if there are no errors
      if (Object.keys(form.errors).length === 0) {
        try {
          const { data } = await axios.post("/api/createToken", {
            gsis_id: form.gsis_id,
            password: form.password,
          });

          if (data.token) {
            localStorage.setItem("api_token", data.token);
          }
        } catch (err) {
          console.error("Failed to create token:", err.response?.data || err.message);
        }
      }
    },
  });
};
</script>