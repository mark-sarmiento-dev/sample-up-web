<template>
    <div class="playground-container">
        <h1>Playground</h1>
        <div class="playground-content">
            <h3>Modals</h3>

            <!-- Button to open modal -->
            <button class="btn" @click="pdsFormModal.showModal = true">
                Open Small Modal
            </button>

            <Button @click="save">Save</Button>
            <Button variant="secondary" size="sm">Cancel</Button>
            <Button variant="danger" size="lg">Delete</Button>

            <!-- Use the PDSFormModal -->
            <PDSFormModal ref="pdsFormModal" />
        </div>
    </div>
</template>

<script setup>
    import { ref } from "vue";
    import PDSFormModal from "@/Components/Modals/PDSFormModal.vue";
    import Button from "@/components/Button.vue";

    const pdsFormModal = ref(null);

    const save = () => {
        console.log('Save button clicked');
    };
</script>

<style scoped>
    .playground-container {
        margin: 40px;
    }

    .playground-content {
        margin-top: 40px;
    }
</style>
