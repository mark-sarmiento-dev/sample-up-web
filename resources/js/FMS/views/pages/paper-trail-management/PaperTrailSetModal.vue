<template>
  <VDialog
    v-model="isOpen"
    max-width="900"
    persistent
  >
    <VCard class="pa-5">
      <VCardTitle class="text-h6 font-weight-medium mb-2">
        {{ isEditMode ? 'Edit Paper Trail Set' : 'Add New Paper Trail Set' }}
      </VCardTitle>
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

          <div class="d-flex justify-space-between align-center mb-4">
            <h6 class="text-h6">Steps</h6>
            <VBtn
              color="primary"
              variant="tonal"
              size="small"
              @click="addStep"
            >
              <VIcon icon="bx-plus" /> Add Step
            </VBtn>
          </div>

          <div
            v-if="form.steps.length > 0"
            class="d-flex flex-column gap-4"
          >
            <VCard
              v-for="(step, stepIndex) in form.steps"
              :key="stepIndex"
              variant="outlined"
            >
              <VCardTitle class="bg-grey-lighten-4 d-flex justify-space-between align-center py-2 text-body-1">
                <span>Step {{ stepIndex + 1 }}</span>
                <div>
                  <VBtn
                    icon
                    variant="text"
                    size="small"
                    @click="moveStep(stepIndex, -1)"
                    :disabled="stepIndex === 0"
                  >
                    <VIcon icon="bx-up-arrow-alt" />
                  </VBtn>
                  <VBtn
                    icon
                    variant="text"
                    size="small"
                    @click="moveStep(stepIndex, 1)"
                    :disabled="stepIndex === form.steps.length - 1"
                  >
                    <VIcon icon="bx-down-arrow-alt" />
                  </VBtn>
                  <VBtn
                    icon
                    variant="text"
                    size="small"
                    color="error"
                    @click="removeStep(stepIndex)"
                  >
                    <VIcon icon="bx-x" />
                  </VBtn>
                </div>
              </VCardTitle>
              <VCardText class="pa-4">
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
                />
                <VDivider />
                <div class="d-flex justify-space-between align-center my-3">
                  <span class="text-subtitle-1">Internal Steps</span>
                  <VBtn
                    size="x-small"
                    variant="tonal"
                    @click="addInternalStep(step)"
                  >
                    <VIcon icon="bx-plus" /> Add
                  </VBtn>
                </div>
                <div class="d-flex flex-column gap-3">
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
              </VCardText>
            </VCard>
          </div>
          <div
            v-else
            class="text-center py-6 text-grey-darken-1"
          >
            No steps added yet.
          </div>
        </VForm>
      </VCardText>
      <VCardActions class="justify-end mt-4">
        <VBtn
          color="grey-darken-1"
          @click="close"
          :disabled="isSaving"
        >
          Cancel
        </VBtn>
        <VBtn
          color="primary"
          @click="save"
          :loading="isSaving"
          elevation="2"
        >
          {{ isEditMode ? 'Save Changes' : 'Create Set' }}
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

// *** MODIFIED SAVE FUNCTION ***
const save = () => {
  isSaving.value = true;
  
  // Create a deep copy to avoid modifying the form state directly
  const payload = JSON.parse(JSON.stringify(form.value));

  // If we are creating a NEW set, remove the set_no from the payload.
  // The backend should be responsible for assigning the final number.
  if (!isEditMode.value) {
    delete payload.set_no;
  }
  
  emit('save', payload, (success) => {
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