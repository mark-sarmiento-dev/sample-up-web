<template>
    <div class="dashboard">
        <!-- Sidebar -->
        <Sidebar :isSidebarOpen="isSidebarOpen" :tabs="tabs" :activeTab="activeTab" @close="isSidebarOpen = false" @switch-tab="switchTab" />

        <!-- Header -->
        <Header @toggle-sidebar="toggleSidebar" />

        <!-- Main content -->
        <main class="main">
            <h1 id="page-title">{{ currentTab.label }}</h1>

            <!-- Dashboard Tab -->
            <section v-show="activeTab === 'dashboard'" class="tab-content">
                <div class="dashboard-grid">
                    <div class="card">
                        <h2>Recruitment Selection and Payment</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                    <div class="card">
                        <h2>Learning and Development</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                    <div class="card">
                        <h2>Performance Management</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                    <div class="card">
                        <h2>Rewards and Recognition</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                </div>
            </section>

            <!-- Employee Tab -->
            <section v-show="activeTab === 'employee'" class="tab-content">
                <p>Employee Management content goes here.</p>
            </section>

            <!-- Plantilla Tab -->
            <section v-show="activeTab === 'plantilla'" class="tab-content">
                <p>Plantilla Management content goes here.</p>
            </section>

            <!-- Salary Tab -->
            <section v-show="activeTab === 'salary'" class="tab-content">
                <p>Salary Schedule content goes here.</p>
            </section>

            <!-- Attendance Tab -->
            <section v-show="activeTab === 'attendance'" class="tab-content">
                <p>Attendance Management content goes here.</p>
            </section>

            <!-- Documents Tab -->
            <section v-show="activeTab === 'documents'" class="tab-content">
                <p>Documents content goes here.</p>
            </section>

            <!-- Leave Tab -->
            <section v-show="activeTab === 'leave'" class="tab-content">
                <p>Leave Management content goes here.</p>
            </section>

            <!-- Logs Tab -->
            <section v-show="activeTab === 'logs'" class="tab-content">
                <p>Audit Logs content goes here.</p>
            </section>

            <!-- Account Tab -->
            <section v-show="activeTab === 'account'" class="tab-content">
                <p>Account Management content goes here.</p>
            </section>
        </main>
    </div>
</template>

<script setup>
    import { ref, computed } from "vue";
    import Header from '@/Components/Header.vue';
    import Sidebar from '@/Components/Sidebar.vue';


    // Sidebar tabs
    const tabs = [
        { id: "dashboard", label: "Dashboard" },
        { id: "employee", label: "Employee Management" },
        { id: "plantilla", label: "Plantilla Management" },
        { id: "salary", label: "Salary Schedule" },
        { id: "attendance", label: "Attendance Management" },
        { id: "documents", label: "Documents" },
        { id: "leave", label: "Leave Management" },
        { id: "logs", label: "Audit Logs" },
        { id: "account", label: "Account Management" },
    ];

    const activeTab = ref("dashboard"); // default tab
    const isSidebarOpen = ref(false);

    // Computed current tab object for header title
    const currentTab = computed(() => tabs.find((tab) => tab.id === activeTab.value));

    function toggleSidebar() {
        isSidebarOpen.value = !isSidebarOpen.value;
    }

    function switchTab(tabId) {
        activeTab.value = tabId;
    }
</script>
