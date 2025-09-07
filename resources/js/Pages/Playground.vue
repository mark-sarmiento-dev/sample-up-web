<template>
    <div class="playground-container">
      <h1>Playground</h1>
      <div class="playground-content">
        <h3>Modals</h3>
        <div class="components-wrapper">
          <Button variant="secondary" size="md" @click="pdsFormModal.showModal = true">
            Open PDS Form
          </Button>
        </div>
  
        <h3>Buttons</h3>
        <div class="components-wrapper">
          <Button variant="secondary" size="lg">Button Large</Button>
          <Button variant="secondary" size="md">Button Medium</Button>
          <Button variant="secondary" size="sm">Button Small</Button>
          <Button variant="secondary" size="xs">Button X-Small</Button>
        </div>
  
        <!-- Use the PDSFormModal -->
        <PDSFormModal ref="pdsFormModal" />
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from "vue";
  import PDSFormModal from "@/components/PDSForm/PDSFormModal.vue";
  import Button from "@/components/Common/Button.vue";
  
  // Import NotificationService
  import notify from "@/Services/NotificationService.js";
  
  const pdsFormModal = ref(null);

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
  