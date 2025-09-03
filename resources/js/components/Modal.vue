<template>
    <div 
      v-if="modelValue" 
      class="modal" 
      @click.self="close"
    >
      <div :class="['modal-content', sizeClass]">
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
            <button class="btn cancel" @click="close">Cancel</button>
          </slot>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { computed } from "vue"
  
  const props = defineProps({
    modelValue: { type: Boolean, default: false },
    title: { type: String, default: "Modal Title" },
    size: { type: String, default: "md" } // sm, md, lg, full
  })
  
  const emit = defineEmits(["update:modelValue"])
  
  const close = () => emit("update:modelValue", false)
  
  const sizeClass = computed(() => {
    switch (props.size) {
      case "sm": return "modal-sm"
      case "lg": return "modal-lg"
      case "full": return "modal-full"
      default: return "modal-md"
    }
  })
  </script>
  