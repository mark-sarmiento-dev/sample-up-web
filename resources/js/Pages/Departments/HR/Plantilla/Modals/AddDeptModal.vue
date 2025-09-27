<template>
    <Modal class="plantilla-add-dept-modal" v-model="showAddDeptModal" title="Add Department" size="md" height="md">
        <form class="form-section">
            <div class="add-dept-form-grid">
                <div class="input-wrapper span-2">
                    <label>Department Name</label>
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

    const showAddDeptModal = ref(false);
</script>
