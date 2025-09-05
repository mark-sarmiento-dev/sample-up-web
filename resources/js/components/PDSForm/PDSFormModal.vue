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
                        <div class="personal-info">
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
                                <label>Suffix (e.g., Jr., Sr., II)</label>
                                <input type="text" value="Sr" />
                            </div>
                            <div>
                                <label>Date of Birth</label>
                                <input type="date" value="Sr" />
                            </div>
                            <div class="input-wrapper span-3">
                                <label>Place of Birth</label>
                                <input type="text" value="Sr" />
                            </div>
                            <div>
                                <label>Sex</label>
                                <select>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div>
                                <label>Civil Status</label>
                                <input type="text" value="Married" />
                            </div>
                            <div>
                                <label>Height (cm)</label>
                                <input type="text" value="167.3" />
                            </div>
                            <div>
                                <label>Weight (kg)</label>
                                <input type="text" value="68" />
                            </div>
                            <div>
                                <label>Blood Type</label>
                                <input type="text" value="O+" />
                            </div>
                        </div>
                        <div class="govt-info">
                            <div>
                                <label>GSIS ID No.</label>
                                <input type="text" value="00012345678" />
                            </div>
                            <div>
                                <label>Pag-Ibig ID No.</label>
                                <input type="text" value="1210-1234-5678" />
                            </div>
                            <div>
                                <label>Phil-Health No.</label>
                                <input type="text" value="12-345678901-2" />
                            </div>
                            <div>
                                <label>SSS No.</label>
                                <input type="text" value="34-123456789-0" />
                            </div>
                            <div>
                                <label>Tin No.</label>
                                <input type="text" value="123-456-789-000" />
                            </div>
                            <div>
                                <label>Agency Employee No.</label>
                                <input type="text" value="EMP-001234" />
                            </div>
                            <div>
                                <label>Citizenship</label>
                                <input type="text" value="Filipino" />
                            </div>
                        </div>
                        <div class="contact-address-info">
                            <div class="input-wrapper span-3">
                                <label>Residential Address</label>
                                <input type="text" value="123 Block 5 Lot 12" />
                            </div>
                            <div>
                                <label>Residential Zip</label>
                                <input type="text" value="2016" />
                            </div>
                            <div class="input-wrapper span-3">
                                <label>Permanent Address</label>
                                <input type="text" value="123 Block 5 Lot 12" />
                            </div>
                            <div>
                                <label>Permanent Zip</label>
                                <input type="text" value="34-123456789-0" />
                            </div>
                            <div class="input-wrapper span-2">
                                <label>Email Address</label>
                                <input type="text" value="sample@gmail.com" />
                            </div>
                            <div>
                                <label>Telephone No.</label>
                                <input type="text" value="(045) 123-4567" />
                            </div>
                            <div>
                                <label>Mobile No.</label>
                                <input type="text" value="09087656766" />
                            </div>
                            <div class="input-wrapper span-2">
                                <label>CTC Place of Issuance</label>
                                <input type="text" value="Sampaloc Apalit Pampanga" />
                            </div>
                            <div>
                                <label>CTC No.</label>
                                <input type="text" value="2025-0001234" />
                            </div>
                            <div>
                                <label>CTC Date of Issuance</label>
                                <input type="date" value="09087656766" />
                            </div>
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
import Modal from "@/components/Common/Modal.vue";

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
