<template>
  <main class="login-container">
    <section class="left" aria-label="Decorative Image"></section>

    <section class="right">
      <img src="/images/logo.png" alt="Company Logo" class="logo" />
      <h1>LOGIN</h1>

      <!-- Display errors -->
      <div v-if="Object.keys(form.errors).length" class="error-message">
        <ul>
          <li
            v-for="(errorMessages, field) in form.errors"
            :key="field"
          >
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
          <button
            type="button"
            class="toggle-password"
            @click="togglePassword"
            :aria-label="showPassword ? 'Hide password' : 'Show password'"
          >
            <i v-if="showPassword" class="fa fa-eye-slash"></i>
            <i v-else class="fa fa-eye"></i>
          </button>
        </div>

        <div class="forgot-password">
          <a href="#">Forgot Password?</a>
        </div>

        <button type="submit" :disabled="form.processing">
          <span v-if="form.processing">Logging in...</span>
          <span v-else>Login</span>
        </button>
      </form>
    </section>
  </main>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
  gsis_id: '',
  password: '',
});

const showPassword = ref(false);
const togglePassword = () => {
  showPassword.value = !showPassword.value;
};

const submit = () => {
  form.post('/login', {
    onFinish: () => form.reset('password'),
  });
};
</script>

<style scoped>
.password-wrapper {
  position: relative;
  display: flex;
  align-items: center;
}

.password-wrapper input {
  width: 100%;
  padding-right: 40px; /* space for eye icon */
}

.password-wrapper .toggle-password {
  position: absolute;
  right: 10px;
  background: none;
  border: none;
  cursor: pointer;
  color: #555;
  font-size: 16px;
}

.password-wrapper .toggle-password:hover {
  color: #007bff;
}
</style>
