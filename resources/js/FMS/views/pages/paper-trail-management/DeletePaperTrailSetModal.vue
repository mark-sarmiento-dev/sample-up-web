<template>
  <VDialog
    v-model="isOpen"
    max-width="400"
    persistent
  >
    <VCard>
      <VCardTitle>Confirm Deletion</VCardTitle>
      <VCardText>
        Are you sure you want to delete set "{{ setData?.set_no }}"? This action cannot be undone.
      </VCardText>
      <VCardActions>
        <VSpacer />
        <VBtn
          text
          @click="close"
          :disabled="isDeleting"
        >
          Cancel
        </VBtn>
        <VBtn
          color="error"
          @click="confirm"
          :loading="isDeleting"
        >
          Delete
        </VBtn>
      </VCardActions>
    </VCard>
  </VDialog>
</template>

<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
  modelValue: Boolean,
  setData: {
    type: Object,
    required: true,
  },
});

const emit = defineEmits(['update:modelValue', 'confirm']);

const isOpen = ref(props.modelValue);
const isDeleting = ref(false);

const close = () => {
  isOpen.value = false;
};

const confirm = () => {
  isDeleting.value = true;
  emit('confirm', (success) => {
    isDeleting.value = false;
    if (success) {
      close();
    }
  });
};

watch(() => props.modelValue, (val) => {
  isOpen.value = val;
});

watch(isOpen, (val) => {
  emit('update:modelValue', val);
});
</script>
