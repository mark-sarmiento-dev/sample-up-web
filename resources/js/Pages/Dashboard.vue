<template>
    <div class="dashboard">
        <!-- Sidebar -->
        <aside class="sidebar" :class="{ open: isSidebarOpen }">
            <button class="close-btn" @click="toggleSidebar(false)">
                ×
            </button>
            <div class="logo">
                <img src="/images/logo.png" alt="Logo" />
                <div class="logo-text">
                    <strong>HRMS</strong>
                    <small>LGU LIBACAO</small>
                </div>
            </div>
            <nav>
                <a v-for="tab in tabs" :key="tab.id" :class="{ active: activeTab === tab.id }"
                @click="setActiveTab(tab.id)">
                    {{ tab.label }}
                </a>
            </nav>
        </aside>
        <!-- Header -->
        <header class="header">
            <button class="menu-btn" @click="toggleSidebar(true)">
                ☰
            </button>

            <h1 id="page-title">{{ pageTitle }}</h1>

            <div class="user">
                <span>Hello, Jowin</span>
                <img src="images/profile.webp" alt="User Avatar" />
            </div>
        </header>
        <!-- Main content -->
        <main class="main">
            <!-- Dashboard Tab -->
            <section v-if="activeTab === 'dashboard'" class="tab-content active">
                <div class="dashboard-grid">
                    <div class="card" v-for="card in dashboardCards" :key="card.title">
                        <h2>{{ card.title }}</h2>
                        <p>{{ card.description }}</p>
                    </div>
                </div>
            </section>
            <!-- Other Tabs -->
            <section v-if="activeTab === 'employee'" class="tab-content">
                <div class="card">
                    <h2>Employee Management</h2>
                    <p>Manage employee records, profiles, and details here.</p>
                </div>
            </section>
            <section v-if="activeTab === 'plantilla'" class="tab-content">
                <div class="card">
                    <h2>Plantilla Management</h2>
                    <p>Configure plantilla positions and structure here.</p>
                </div>
            </section>
            <section v-if="activeTab === 'salary'" class="tab-content">
                <div class="card">
                    <h2>Salary Schedule</h2>
                    <p>View and manage salary grades and compensation details.</p>
                </div>
            </section>
            <section v-if="activeTab === 'attendance'" class="tab-content">
                <div class="card">
                    <h2>Attendance Management</h2>
                    <p>Track and monitor employee attendance.</p>
                </div>
            </section>
            <section v-if="activeTab === 'documents'" class="tab-content">
                <div class="card">
                    <h2>Documents</h2>
                    <p>Upload and manage HR documents here.</p>
                </div>
            </section>
            <section v-if="activeTab === 'leave'" class="tab-content">
                <div class="card">
                    <h2>Leave Management</h2>
                    <p>Apply, approve, and monitor employee leaves.</p>
                </div>
            </section>
            <section v-if="activeTab === 'logs'" class="tab-content">
                <div class="card">
                    <h2>Audit Logs</h2>
                    <p>View system activity and logs.</p>
                </div>
            </section>
            <section v-if="activeTab === 'account'" class="tab-content">
                <div class="card">
                    <h2>Account Management</h2>
                    <p>Manage user accounts and roles.</p>
                </div>
            </section>
        </main>
    </div>
</template>
<script setup>
    import { ref } from "vue";

    const isSidebarOpen = ref(false);
    const activeTab = ref("dashboard"); 
    const pageTitle = ref("Dashboard");

    const tabs = [{
        id: "dashboard",
        label: "Dashboard"
    },
    {
        id: "employee",
        label: "Employee Management"
    },
    {
        id: "plantilla",
        label: "Plantilla Management"
    },
    {
        id: "salary",
        label: "Salary Schedule"
    },
    {
        id: "attendance",
        label: "Attendance Management"
    },
    {
        id: "documents",
        label: "Documents"
    },
    {
        id: "leave",
        label: "Leave Management"
    },
    {
        id: "logs",
        label: "Audit Logs"
    },
    {
        id: "account",
        label: "Account Management"
    },
    ]

    const dashboardCards = [{
        title: "Recruitment Selection and Payment",
        description: "Lorem ipsum dolor sit amet consectetur adipisicing elit."
    },
    {
        title: "Learning and Development",
        description: "Lorem ipsum dolor sit amet consectetur adipisicing elit."
    },
    {
        title: "Performance Management",
        description: "Lorem ipsum dolor sit amet consectetur adipisicing elit."
    },
    {
        title: "Rewards and Recognition",
        description: "Lorem ipsum dolor sit amet consectetur adipisicing elit."
    },
    ]

    function setActiveTab(tabId) {
        activeTab.value = tabId; 

        const tab = tabs.find((t) => t.id === tabId); 

        pageTitle.value = tab ? tab.label: "Dashboard";

        if (window.innerWidth <= 768) {
            isSidebarOpen.value = false;
        }
    }

    function toggleSidebar(state) {
        isSidebarOpen.value = state;
    }
</script>