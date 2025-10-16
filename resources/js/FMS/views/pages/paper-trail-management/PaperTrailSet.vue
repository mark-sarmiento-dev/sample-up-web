<template>
  <div>
    <div class="d-flex justify-end mb-4 responsive-add">
        <VBtn variant="outlined" color="primary" @click="openModal(null)">+ Add New Flow</VBtn>
    </div>

    <div v-if="loading" class="text-center py-10">
      <VProgressCircular indeterminate color="primary" size="64" />
      <div class="mt-4 text-grey-darken-2">Fetching flows...</div>
    </div>

    <div v-else-if="sets.length === 0" class="text-center py-10 border rounded-lg">
      <VIcon icon="bx-file-find" size="64" class="text-grey-lighten-1 mb-4" />
      <h3 class="text-h6">No Flows Found</h3>
      <p class="text-grey-darken-2">Click "Add New Flow" to get started.</p>
    </div>

    <VRow v-else>
      <VCol
        v-for="set in sets"
        :key="set.id"
        cols="12"
        md="6"
        lg="4"
      >
        <VCard
          variant="outlined"
          class="flow-card"
          :style="{ '--set-number': `'${set.set_no}'` }"
          @click="openModal(set)"
        >
          <div class="card-content-wrapper">
            <VCardTitle class="d-flex align-center text-body-1 font-weight-bold pt-4">
              <VSpacer /> <VChip
                v-if="set.is_default"
                color="success"
                variant="elevated"
                size="small"
                prepend-icon="bx-check-circle"
              >
                Default
              </VChip>
            </VCardTitle>

            <VCardText>
              <div class="d-flex align-center mb-3">
                <VIcon icon="bx-buildings" class="text-grey-darken-1 me-2" />
                <span class="text-body-2">Office: <strong>{{ set.office_code }}</strong></span>
              </div>
              <div class="d-flex align-center">
                <VIcon icon="bx-git-branch" class="text-grey-darken-1 me-2" />
                <span class="text-body-2">Contains <strong>{{ set.steps.length }}</strong> step(s)</span>
              </div>
            </VCardText>
          </div>

          <VSpacer />

          <VCardActions class="pa-2 card-actions-wrapper">
            <VBtn
              variant="text"
              color="error"
              size="small"
              @click.stop="openDeleteModal(set)"
            >
              <VIcon icon="bx-trash" />
              Delete
            </VBtn>
            <VSpacer />
          </VCardActions>
        </VCard>
      </VCol>
    </VRow>

    <PaperTrailSetModal
      v-model="showModal"
      :set-data="selectedSet"
      @save="handleSave"
    />
    <DeletePaperTrailSetModal
      v-model="showDeleteModal"
      :set-data="selectedSet"
      @confirm="handleConfirmDelete"
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import api from '@fms/utils/api';
import PaperTrailSetModal from './PaperTrailSetModal.vue';
import DeletePaperTrailSetModal from './DeletePaperTrailSetModal.vue';

const sets = ref([]);
const loading = ref(true);

const showModal = ref(false);
const showDeleteModal = ref(false);
const selectedSet = ref(null);

// --- API Calls ---
const fetchSets = async () => {
  loading.value = true;
  try {
    const response = await api.get('/paper-trail-sets');
    sets.value = response.data.data;
  } catch (error) {
    console.error("Failed to fetch sets:", error);
  } finally {
    loading.value = false;
  }
};

const handleSave = async (setData, done) => {
  try {
    if (setData.id) {
      await api.put(`/paper-trail-sets/${setData.id}`, setData);
    } else {
      await api.post('/paper-trail-sets', setData);
    }
    await fetchSets();
    done(true);
  } catch (error) {
    console.error("Failed to save set:", error);
    done(false);
  }
};

const handleConfirmDelete = async (done) => {
  if (!selectedSet.value) return;
  try {
    await api.delete(`/paper-trail-sets/${selectedSet.value.id}`);
    await fetchSets();
    done(true);
  } catch (error) {
    console.error("Failed to delete set:", error);
    done(false);
  }
};

// --- Modal Controls ---
const openModal = (set = null) => {
  selectedSet.value = set ? { ...set } : null; // Use a copy for editing
  showModal.value = true;
};

const openDeleteModal = (set) => {
  selectedSet.value = set;
  showDeleteModal.value = true;
};

// --- Lifecycle Hooks ---
onMounted(() => {
  fetchSets();
});
</script>

<style scoped>
.flow-card {
  position: relative; /* Crucial for positioning the ::before pseudo-element */
  overflow: hidden; /* Hides the part of the number that goes outside the card */
  cursor: pointer;
  transition: all 0.2s ease-in-out;
  border-width: 1px;
  display: flex;
  flex-direction: column;
  height: 100%;
}

.flow-card::before {
  content: var(--set-number); /* Uses the CSS variable passed from the template */
  position: absolute;
  top: 10px;   /* Adjusted for padding */
  right: 15px; /* Adjusted for padding */
  font-size: 8rem; /* Large font size for the background number */
  font-weight: 900;
  line-height: 1;
  /* Uses Vuetify's theme color for better theme compatibility */
  color: rgba(var(--v-theme-on-surface), 0.06);
  z-index: 0; /* Puts the number in the background */
  transition: all 0.2s ease-in-out;
}

/* These wrappers ensure the content stays above the background number */
.card-content-wrapper, .card-actions-wrapper {
  position: relative;
  z-index: 1;
  background-color: transparent; /* Ensures background is not solid */
}

.flow-card:hover {
  border-color: rgba(var(--v-theme-primary), 0.8);
  box-shadow: 0 8px 24px rgba(var(--v-theme-primary), 0.2);
  transform: translateY(-4px);
}

.flow-card:hover::before {
  transform: scale(1.1) rotate(-5deg); /* Adds a little flair on hover */
}
</style>