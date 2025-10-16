<template>
  <VDialog
    v-model="isOpen"
    max-width="800"
    transition="dialog-bottom-transition"
    persistent
    scrollable
  >
    <VCard class="custom-modal-shadow rounded-lg pa-5">
      <VCardTitle class="d-flex align-center text-h6 font-weight-medium mb-2">
        <VIcon icon="bx-sitemap" class="me-3" color="primary" size="28" />
        {{ isEditMode ? 'Edit Paper Trail Flow' : 'Add New Paper Trail Flow' }}
      </VCardTitle>

      <VCardSubtitle class="text-body-2 text-grey-darken-1 mb-5 description-text">
        {{ isEditMode
          ? 'Modify the flow steps and owners. Changes will affect new documents using this flow.'
          : 'Create a new sequence of steps for a document paper trail.'
        }}
      </VCardSubtitle>

      <VCardText>
        <VForm>
          <VRow>
            <VCol
              cols="12"
              md="6"
            >
              <VTextField
                v-model="form.set_no"
                label="Set Number"
                variant="outlined"
                density="comfortable"
                :readonly="true"
                :loading="isFetchingCount"
              />
            </VCol>
            <VCol
              cols="12"
              md="6"
            >
              <VSelect
                v-model="form.office_code"
                label="Office Code (Group)"
                :items="officeCodes"
                item-title="description"
                item-value="office_code"
                variant="outlined"
                density="comfortable"
                :loading="isLoadingOfficeCodes"
              />
            </VCol>
          </VRow>

          <VDivider class="my-6" />

          <div class="d-flex justify-space-between align-center mb-5">
            <h6 class="text-h6">
              Flow Steps
            </h6>
            <VBtn
              color="primary"
              variant="tonal"
              @click="addStep"
            >
              <VIcon icon="bx-plus" class="me-1" /> Add Step
            </VBtn>
          </div>

          <div v-if="form.steps.length > 0" class="steps-list-container">
            <div
              v-for="(step, stepIndex) in form.steps"
              :key="stepIndex"
              class="step-item"
            >
              <div class="line-container">
                <div class="dot" />
              </div>

              <div class="content-container">
                <div class="step-header">
                  <div class="d-flex align-center">
                    <VIcon icon="bx-grid-vertical" class="drag-handle" />
                    <span class="font-weight-bold">Step {{ stepIndex + 1 }}</span>
                  </div>
                  <div class="step-actions">
                    <VBtn icon variant="text" size="small" @click="moveStep(stepIndex, -1)" :disabled="stepIndex === 0">
                      <VIcon icon="bx-up-arrow-alt" />
                    </VBtn>
                    <VBtn icon variant="text" size="small" @click="moveStep(stepIndex, 1)" :disabled="stepIndex === form.steps.length - 1">
                      <VIcon icon="bx-down-arrow-alt" />
                    </VBtn>
                    <VBtn icon variant="text" size="small" color="error" @click="removeStep(stepIndex)">
                      <VIcon icon="bx-x" />
                    </VBtn>
                  </div>
                </div>

                <div class="step-body">
                  <VSelect
                    v-model="step.office_code_step_owner"
                    label="Office Code (Step Owner)"
                    :items="officeCodes.filter(oc => oc.office_code !== 'All')"
                    item-title="description"
                    item-value="office_code"
                    variant="outlined"
                    density="comfortable"
                    class="mb-4"
                    :loading="isLoadingOfficeCodes"
                    hide-details
                  />
                  <VDivider class="my-4" />
                  <div class="d-flex justify-space-between align-center mb-3">
                    <span class="text-subtitle-1 font-weight-medium">Internal Approvals</span>
                    <VBtn size="small" variant="tonal" @click="addInternalStep(step)">
                      <VIcon icon="bx-plus" size="small" class="me-1" /> Add
                    </VBtn>
                  </div>
                  <div v-if="step.internal_steps.length > 0" class="d-flex flex-column gap-3">
                    <VTextField
                      v-for="(internalStep, internalIndex) in step.internal_steps"
                      :key="internalIndex"
                      v-model="internalStep.approval_title"
                      label="Approval Title"
                      variant="outlined"
                      density="compact"
                      hide-details
                      append-inner-icon="bx-trash"
                      @click:append-inner="removeInternalStep(step, internalIndex)"
                    />
                  </div>
                  <div v-else class="text-center text-caption text-grey py-2">
                    No internal approvals for this step.
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div v-else class="steps-empty-state">
            <VIcon icon="bx-list-plus" size="48" />
            <p class="mt-4 text-h6">No steps in this flow yet.</p>
            <p class="text-grey-darken-1">Click "Add Step" to get started.</p>
          </div>
        </VForm>
      </VCardText>

      <VCardActions class="justify-end mt-6">
        <VBtn
          color="grey-darken-1"
          class="me-2 px-4"
          variant="text"
          @click="close"
          :disabled="isSaving"
        >
          <VIcon icon="bx-x" class="me-1" />
          Cancel
        </VBtn>
        <VBtn
          color="primary"
          class="px-5"
          elevation="2"
          :loading="isSaving"
          @click="save"
        >
          <VIcon :icon="isEditMode ? 'bx-save' : 'bx-plus'" class="me-1" />
          {{ isEditMode ? 'Save Changes' : 'Create Flow' }}
        </VBtn>
      </VCardActions>
    </VCard>
  </VDialog>
</template>

<script setup>
import { ref, watch, computed, onMounted } from 'vue';
import api from '@fms/utils/api';

const props = defineProps({
  modelValue: Boolean,
  setData: {
    type: Object,
    default: null,
  },
});

const emit = defineEmits(['update:modelValue', 'save']);

const isOpen = ref(props.modelValue);
const isSaving = ref(false);
const officeCodes = ref([]);
const isLoadingOfficeCodes = ref(false);
const isFetchingCount = ref(false);

const defaultForm = {
  id: null,
  set_no: '',
  office_code: 'All',
  steps: [],
};
const form = ref({ ...defaultForm });

const isEditMode = computed(() => !!form.value.id);

const fetchNextSetNumber = async () => {
  isFetchingCount.value = true;
  try {
    const response = await api.get('/paper-trail-sets?per_page=1');
    const totalSets = response.data.total || 0;
    form.value.set_no = totalSets + 1;
  } catch (error) {
    console.error("Failed to fetch paper trail set count:", error);
    form.value.set_no = 'Error';
  } finally {
    isFetchingCount.value = false;
  }
};

const fetchOfficeCodes = async () => {
  isLoadingOfficeCodes.value = true;
  try {
    const response = await api.get('/office-codes');
    const data = Array.isArray(response.data.data) ? response.data.data : response.data;
    officeCodes.value = [{ office_code: 'All', description: 'All Offices' }, ...data];
  } catch (error) {
    console.error("Failed to fetch office codes:", error);
    officeCodes.value = [{ office_code: 'All', description: 'All Offices' }];
  } finally {
    isLoadingOfficeCodes.value = false;
  }
};

const save = () => {
  isSaving.value = true;
  emit('save', form.value, (success) => {
    isSaving.value = false;
    if (success) {
      close();
    }
  });
};

const close = () => {
  isOpen.value = false;
};

const addStep = () => {
  form.value.steps.push({
    office_code_step_owner: '',
    internal_steps: [{ approval_title: '' }],
  });
};

const removeStep = (index) => {
  form.value.steps.splice(index, 1);
};

const addInternalStep = (step) => {
  if (!step.internal_steps) {
    step.internal_steps = [];
  }
  step.internal_steps.push({ approval_title: '' });
};

const removeInternalStep = (step, internalIndex) => {
  step.internal_steps.splice(internalIndex, 1);
};

const moveStep = (index, direction) => {
  const newIndex = index + direction;
  if (newIndex < 0 || newIndex >= form.value.steps.length) return;
  
  const element = form.value.steps.splice(index, 1)[0];
  form.value.steps.splice(newIndex, 0, element);
};

watch(() => props.modelValue, (val) => {
  isOpen.value = val;
  if (val) {
    if (props.setData) {
      form.value = JSON.parse(JSON.stringify(props.setData));
    } else {
      form.value = { ...defaultForm, steps: [] };
      fetchNextSetNumber();
    }
  }
});

watch(isOpen, (val) => {
  emit('update:modelValue', val);
});

onMounted(() => {
  fetchOfficeCodes();
});
</script>

<style scoped>
.custom-modal-shadow {
  box-shadow: 0 12px 28px rgba(0, 0, 0, 0.18) !important;
}

.description-text {
  white-space: normal !important;
  overflow: visible !important;
  text-overflow: unset !important;
}

.steps-list-container {
  display: flex;
  flex-direction: column;
}

.step-item {
  display: flex;
  position: relative;
  gap: 1rem; /* Space between line and content */
}

/* --- Vertical Line and Dot --- */
.line-container {
  position: relative;
  width: 12px; /* Width of the dot */
  flex-shrink: 0;
}

/* The line is now a pseudo-element of the container */
.line-container::before {
  content: '';
  position: absolute;
  width: 2px;
  background-color: #e0e0e0;
  left: 50%;
  transform: translateX(-50%);
  /* Default to full height */
  top: 0;
  bottom: 0;
}

.dot {
  width: 12px;
  height: 12px;
  border: 2px solid #e0e0e0; /* <-- COLOR CHANGED HERE */
  background-color: white;
  border-radius: 50%;
  position: absolute;
  top: 18px; /* Vertically align with header text */
  left: 50%;
  transform: translateX(-50%);
  z-index: 1;
}

/* --- Adjusting Line Endpoints --- */
/* For the first item, start the line at the dot's center */
.step-item:first-child .line-container::before {
  top: 18px;
}
/* For the last item, end the line at the dot's center */
.step-item:last-child .line-container::before {
  bottom: calc(100% - 18px);
}

/* --- Step Content --- */
.content-container {
  flex-grow: 1;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  margin-bottom: 1.5rem; /* Space between items */
  background-color: #fff;
}
.step-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.5rem 0.5rem 0.5rem 1rem;
  background-color: #f9f9f9;
  border-bottom: 1px solid #e0e0e0;
  border-radius: 8px 8px 0 0;
}
.drag-handle {
  cursor: grab;
  color: #9e9e9e;
  margin-right: 0.75rem;
}
.step-actions .v-btn {
  color: #757575;
}
.step-body {
  padding: 1.25rem;
}

/* --- Empty State --- */
.steps-empty-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 3rem 1rem;
  border: 2px dashed #e0e0e0;
  border-radius: 8px;
  color: #757575;
  margin-top: 1rem;
}
</style>