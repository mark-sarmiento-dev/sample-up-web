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
            <section v-show="activeTab === 'employee'" id="employee">
                <div class="employee-header">
                    <input type="text" placeholder="Search employee ..." class="search-bar" />
                    <Button variant="primary">
                        <img class="icon" src="images/icons/plus.png"/> Add Employee
                    </Button>
                </div>
                <div class="employee-table-wrapper">
                    <table class="employee-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Date of Birth</th>
                                <th>Agency Employee No.</th>
                                <th>Sex</th>
                                <th>Civil Status</th>
                                <th>Citizenship</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>John Doe</td>
                                <td>03/24/2001</td>
                                <td>EMP-001234</td>
                                <td>Male</td>
                                <td>Single</td>
                                <td>Filipino</td>
                                <td>
                                    <Button variant="secondary" size="xs">
                                        <img class="icon" src="images/icons/view.png"/>
                                    </Button>
                                    <Button variant="secondary" size="xs">
                                        <img class="icon" src="images/icons/edit.png"/>
                                    </Button>
                                    <Button variant="secondary" size="xs">
                                        <img class="icon" src="images/icons/delete.png"/>
                                    </Button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- <div class="pagination">
                    <button>&laquo;</button>
                    <span>Page 22</span>
                    <button>&raquo;</button>
                </div> -->
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
    import Header from '@/components/Header/Header.vue';
    import Sidebar from '@/components/Sidebar/Sidebar.vue';
    import Button from "@/components/Common/Button.vue";


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
