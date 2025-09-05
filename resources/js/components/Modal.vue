<template>
    <div v-if="modelValue" class="modal" @click.self="close">
        <div :class="['modal-content', sizeClass, heightClass]">
            <!-- Header -->
            <div class="modal-header">
                <h2>{{ title }}</h2>
                <span class="close" @click="close">&times;</span>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <slot />
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <slot name="footer">
                    <Button variant="secondary" size="md" @click="close">Cancel</Button>
                    <Button variant="primary" size="md" @click="$emit('save')">Save</Button>
                </slot>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { computed } from "vue";
    import Button from "@/components/Button.vue";

    const props = defineProps({
        modelValue: { type: Boolean, default: false },
        title: { type: String, default: "Modal Title" },
        size: { type: String, default: "md" }, // sm, md, lg, full (width)
        height: { type: String, default: "auto" }, // sm, md, lg, full, auto
    });

    const emit = defineEmits(["update:modelValue"]);

    const close = () => emit("update:modelValue", false);

    // Width class
    const sizeClass = computed(() => {
        switch (props.size) {
            case "sm":
                return "modal-sm";
            case "lg":
                return "modal-lg";
            case "full":
                return "modal-full";
            default:
                return "modal-md";
        }
    });

    // Height class
    const heightClass = computed(() => {
        switch (props.height) {
            case "sm":
                return "modal-h-sm";
            case "lg":
                return "modal-h-lg";
            case "full":
                return "modal-h-full";
            case "md":
                return "modal-h-md";
            default:
                return "";
        }
    });
</script>
