<template>
  <header class="header">
    <button class="menu-btn" @click="toggleSidebar">☰</button>

    <div class="logo">
      <img src="images/logo.png" alt="Logo" />
      <div class="logo-text">
        <strong>HRMS</strong>
        <small>LGU LIBACAO</small>
      </div>
    </div>

    <div
      class="user-dropdown"
      :class="{ active: isDropdownOpen }"
      ref="dropdownWrapper"
    >
      <div class="user" @click="toggleDropdown" ref="userDiv">
        <span>Hello, {{ user?.name }}</span>
        <img src="images/profile.webp" alt="User Avatar" />
      </div>
      <div class="dropdown-menu" v-if="isDropdownOpen">
        <a href="#">Account Settings</a>
        <a href="#">Account Management</a>
        <a href="#" @click.prevent="logout">Logout</a>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, computed } from "vue";
import axios from "axios";
import { usePage } from "@inertiajs/vue3";

// Correctly read reactive user from Inertia props
const page = usePage();
const user = computed(() => page.props.auth?.user ?? null);

// Dropdown state
const isDropdownOpen = ref(false);

// Emit event to parent
const emit = defineEmits(["toggle-sidebar"]);

function toggleDropdown() {
  isDropdownOpen.value = !isDropdownOpen.value;
}

function toggleSidebar() {
  emit("toggle-sidebar");
}

// Refs for dropdown
const dropdownWrapper = ref(null);

function handleClickOutside(e) {
  if (dropdownWrapper.value && !dropdownWrapper.value.contains(e.target)) {
    isDropdownOpen.value = false;
  }
}

onMounted(() => {
  document.addEventListener("click", handleClickOutside);
});

onBeforeUnmount(() => {
  document.removeEventListener("click", handleClickOutside);
});

async function logout() {
  try {
    await axios.post("/logout");
    window.location.href = "/login";
  } catch (error) {
    console.error("Logout failed:", error);
  }
}
</script>
