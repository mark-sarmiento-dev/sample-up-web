<template>
    <Modal class="plantilla-add-div-modal grid" v-model="showAddDivModal" title="Add Division" size="md" height="md">
        <form class="form-section">
            <div class="form-grid">
                <div class="input-wrapper span-2">
                    <label>Division Name</label>
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

    const showAddDivModal = ref(false);
</script>
