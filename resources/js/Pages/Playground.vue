<template>
    <div class="playground-container">
        <h1>Playground</h1>
        <div class="playground-content">
            <h3>Modals</h3>
            <button class="btn" @click="showModal = true">Open Small Modal</button>

            <Modal v-model="showModal" title="Small Modal" size="sm">
                <p>This is a small modal.</p>
            </Modal>
        </div>
    </div>
</template>
<script setup>
import { ref } from "vue";

import Modal from "@/Components/Modal.vue"

const showModal = ref(false);
</script>
<style scoped>
    .playground-container {
        margin: 40px;
    }

    .playground-content {
        margin-top: 40px;
    }

    .btn {
        padding:12px;
		margin-top:20px;
		background-color:#5B5B5B;
		/* Theme color */
		border:none;
		color:white;
		font-size:16px;
		cursor:pointer;
		border-radius:0;
    }
</style>
