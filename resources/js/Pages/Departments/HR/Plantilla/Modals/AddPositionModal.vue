<template>
    <Modal class="plantilla-add-position-modal" v-model="showAddPositionModal" title="Add Position" size="md" height="md">
        <form class="form-section">
            <div class="add-position-form-grid">
                <div class="input-wrapper">
                    <label>Plantilla Item No.</label>
                    <Input type="text" />
                </div>
                <div>
                    <label>Salary Grade</label>
                    <select>
                        <option value="">Select</option>
                        <option value="">1</option>
                        <option value="">2</option>
                        <option value="">3</option>
                    </select>
                </div>
                <div>
                    <label>Monthly Rate</label>
                    <Input type="text" />
                </div>
                <div>
                    <label>Eligibility</label>
                    <select>
                        <option value="">Select</option>
                        <option value="">First Level</option>
                        <option value="">Second Level</option>
                    </select>
                </div>
                <div class="input-wrapper span-2">
                    <label>Department</label>
                    <select>
                        <option value="">Select</option>
                        <option value="elementary">Office A</option>
                    </select>
                </div>
                <div class="input-wrapper span-2">
                    <label>Division</label>
                    <select>
                        <option value="">Select</option>
                        <option value="elementary">Division 1</option>
                    </select>
                </div>
                <div class="input-wrapper span-2">
                    <label>Educational Requirement</label>
                    <select>
                        <option value="">Select</option>
                        <option value="">Elementary Graduate</option>
                        <option value="">College Graduate</option>
                        <option value="">Highschool Graduate</option>
                    </select>
                </div>
                <div class="input-wrapper span-2">
                    <label>Experience</label>
                    <Input type="text" />
                </div>
            </div>
        </form>
        <template #footer>
            <Button variant="secondary" size="md" @click="$emit('update:modelValue', false)">Cancel</Button>
            <Button variant="primary" size="md">Save</Button>
        </template>
    </Modal>
</template>

<script setup>
    import { ref } from "vue";
    import Modal from "@/components/Common/Modal.vue";
    import Button from "@/components/Common/Button.vue";
    import Input from "@/Components/Common/Input.vue";

    const showAddPositionModal = ref(false);
</script>
