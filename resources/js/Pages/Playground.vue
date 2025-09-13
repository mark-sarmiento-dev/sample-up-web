<template>
    <div class="playground-container">
        <h1>Playground</h1>
        <div class="playground-content">
            <h3>Modals</h3>
            <div class="components-wrapper">
                <Button variant="secondary" size="md" @click="showModal = true">
                    Open Modal
                </Button>
            </div>

            <h3>Buttons</h3>
            <div class="components-wrapper">
                <Button variant="secondary" size="lg">Button Large</Button>
                <Button variant="secondary" size="md">Button Medium</Button>
                <Button variant="secondary" size="sm">Button Small</Button>
                <Button variant="secondary" size="xs">Button X-Small</Button>
            </div>

            <h3>Cards</h3>
            <div class="components-wrapper">
                <Card size="sm" title="Small Card" footer-text="Last updated: Today">
                    <p>This is a small card.</p>
                </Card>

                <Card size="md">
                    <template #header>Medium Card</template>
                    <p>This is a medium card.</p>
                    <template #footer>Footer</template>
                </Card>

                <Card size="lg" title="Large Card">
                    <p>This is a large card.</p>
                </Card>
            </div>

            <h3>Dropdown</h3>
            <!-- Default bottom-right -->
            <Dropdown style="margin-right: 20px;" label="Bottom Right" placement="bottom-right">
                <a href="#">Account Settings</a>
                <a href="#">Logout</a>
            </Dropdown>

            <!-- Appear on bottom left -->
            <Dropdown style="margin-right: 20px;" label="Bottom Left" placement="bottom-left">
                <a href="#">Message 1</a>
                <a href="#">Message 2</a>
            </Dropdown>

            <!-- Appear on top left -->
            <Dropdown label="Top Left" placement="top-left">
                <a href="#">Message 1</a>
                <a href="#">Message 2</a>
            </Dropdown>

            <!-- Modal -->
            <Modal v-model:modelValue="showModal" />
        </div>
    </div>
</template>

<script setup>
    import { ref, onMounted } from "vue";
    import Modal from "@/components/Common/Modal.vue";
    import Button from "@/components/Common/Button.vue";
    import notify from "@/Services/NotificationService.js";
    import Card from "@/components/Common/Card.vue";
    import Dropdown from "../Components/Common/Dropdown.vue";

    const showModal = ref(false);
    const isSuccessFetch = true;

    // ✅ Show notification automatically on mount
    onMounted(() => {
        /*Sample Notification*/
        /*
    notify("success", "Welcome to the Playground!");
    notify("error", "This is an error example!");
    notify("warning", "This is a warning example!");
    notify("success", "Top Left Example", { position: "top-left" });
    */

        if (isSuccessFetch) {
            notify("success", "Data Fetch Successfully!");
        } else {
            notify("error", "Data Failed to Fetch!");
        }
    });
</script>

<style scoped>
    .playground-container {
        margin: 40px;
    }

    .playground-content {
        margin-top: 40px;
    }

    /* 🔽 Stack buttons vertically */
    .components-wrapper {
        display: flex;
        flex-direction: column;
        gap: 12px; /* spacing between buttons */
        max-width: 200px; /* optional: limit width */
        margin-bottom: 20px;
    }
</style>
