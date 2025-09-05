<template>
    <Modal v-model="showModal" title="PDS Form" size="lg" height="full" @save="handleSave">
        <div class="pds-form">
            <!-- Sidebar Navigation -->
            <nav class="pds-nav">
                <ul>
                    <li v-for="(tab, index) in tabs" :key="index" :class="{ active: activeTab === tab.key }" @click="activeTab = tab.key">
                        {{ tab.label }}
                    </li>
                </ul>
            </nav>

            <!-- Form Section -->
            <div class="form-section">
                <div v-if="activeTab === 'personal'">
                    <h3>Personal Details</h3>
                    <div class="form-grid">
                        <div>
                            <label>Lastname</label>
                            <input type="text" value="Montenegro" />
                        </div>
                        <div>
                            <label>Firstname</label>
                            <input type="text" value="Alvin" />
                        </div>
                        <div>
                            <label>Middlename</label>
                            <input type="text" value="Laurel" />
                        </div>
                        <div>
                            <label>Suffix</label>
                            <input type="text" value="Sr" />
                        </div>
                    </div>
                </div>

                <div v-else-if="activeTab === 'family'">
                    <h3>Family Background</h3>
                    <p>Form fields for family background...</p>
                </div>

                <div v-else-if="activeTab === 'education'">
                    <h3>Educational Background</h3>
                    <p>Form fields for education...</p>
                </div>
            </div>
        </div>
    </Modal>
</template>

<script setup>
    import { ref } from "vue";
    import Modal from "@/Components/Modal.vue"; // base modal

    const showModal = ref(false);

    const tabs = [
        { key: "personal", label: "Personal Details" },
        { key: "family", label: "Family Background" },
        { key: "education", label: "Educational Background" },
        { key: "eligibility", label: "Civil Service Eligibility" },
        { key: "work", label: "Work Experience" },
        { key: "voluntary", label: "Voluntary Involvement" },
        { key: "training", label: "Training Attended" },
        { key: "other", label: "Other Relevant Information" },
    ];

    const activeTab = ref("personal");

    function handleSave() {
        alert("Saved successfully!");
        showModal.value = false;
    }

    // expose to parent
    defineExpose({ showModal });
</script>
