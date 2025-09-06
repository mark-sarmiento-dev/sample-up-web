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
            <Form :active-tab="activeTab"/>
        </div>
    </Modal>
</template>

<script setup>
    import { ref } from "vue";
    import Modal from "@/components/Common/Modal.vue";
    import Form from "@/components/PDSForm/Form.vue";

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
