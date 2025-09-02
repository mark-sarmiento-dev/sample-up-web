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

        <!-- User profile with dropdown -->
        <div class="user-dropdown" :class="{ active: isDropdownOpen }">
            <div class="user" @click="toggleDropdown">
                <span>Hello, Joe</span>
                <img src="images/profile.webp" alt="User Avatar" />
            </div>
            <div class="dropdown-menu">
                <a href="#">Account Settings</a>
                <a href="#">Account Management</a>
                <a href="#">Logout</a>
            </div>
        </div>
    </header>
</template>
<script setup>
    import { ref, onMounted } from "vue";
    
    // User dropdown
    const isDropdownOpen = ref(false);
    const emit = defineEmits(["toggle-sidebar"]);

    function toggleDropdown() {
        isDropdownOpen.value = !isDropdownOpen.value;
    }

    // Emit event to parent when menu button clicked
    function toggleSidebar() {
        // emit event
        emit("toggle-sidebar");
    }

    // Close dropdown when clicking outside
    onMounted(() => {
        document.addEventListener("click", (e) => {
            const userDiv = document.querySelector(".user-dropdown .user");
            const dropdown = document.querySelector(".dropdown-menu");
            if (!userDiv.contains(e.target) && !dropdown.contains(e.target)) {
                isDropdownOpen.value = false;
            }
        });
    });
</script>