<template>
  <div>
    <!-- Add Button -->
    <div class="d-flex justify-end mb-4">
      <VBtn
        variant="outlined"
        color="primary"
        @click="openModal(null)"
      >
        + Add Paper Trail Set
      </VBtn>
    </div>

    <!-- Main Table -->
    <div class="rounded-lg shadow-sm border border-grey-lighten-3 overflow-x-auto">
      <VTable class="text-body-2">
        <thead>
          <tr class="bg-grey-lighten-3 text-grey-darken-4 font-weight-medium">
            <th class="text-left px-6 py-3">Set No.</th>
            <th class="text-left px-6 py-3">Office Code</th>
            <th class="text-left px-6 py-3">No. of Steps</th>
            <th class="text-right px-6 py-3">Actions</th>
          </tr>
        </thead>
        <tbody v-if="!loading">
          <tr v-if="sets.length === 0">
            <td
              colspan="4"
              class="text-center py-6 text-grey-darken-2"
            >
              No paper trail sets found.
            </td>
          </tr>
          <tr
            v-for="set in sets"
            :key="set.id"
            class="hover-row"
            @click="openModal(set)"
          >
            <td class="px-6 py-3">{{ set.set_no }}</td>
            <td class="px-6 py-3">{{ set.office_code }}</td>
            <td class="px-6 py-3">{{ set.steps.length }}</td>
            <td class="px-6 py-3 text-right">
              <VBtn
                variant="text"
                color="error"
                size="small"
                @click.stop="openDeleteModal(set)"
              >
                <VIcon
                  icon="bx-trash"
                  class="me-1"
                />
              </VBtn>
            </td>
          </tr>
        </tbody>
        <tbody v-else>
          <tr>
            <td
              colspan="4"
              class="text-center py-10"
            >
              <VProgressCircular
                indeterminate
                color="primary"
              />
              <div class="mt-2 text-grey-darken-2">Loading...</div>
            </td>
          </tr>
        </tbody>
      </VTable>
    </div>

    <!-- Modals -->
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
import api from '@fms/utils/api'; // This API instance is assumed to be configured for Sanctum
import PaperTrailSetModal from './PaperTrailSetModal.vue'; // Import the Add/Edit Modal
import DeletePaperTrailSetModal from './DeletePaperTrailSetModal.vue'; // Import the Delete Modal

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
      // Update existing set
      await api.put(`/paper-trail-sets/${setData.id}`, setData);
    } else {
      // Create new set
      await api.post('/paper-trail-sets', setData);
    }
    await fetchSets();
    done(true); // Signal to the modal that save was successful
  } catch (error) {
    console.error("Failed to save set:", error);
    done(false); // Signal that save failed
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
  selectedSet.value = set;
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
.hover-row {
  cursor: pointer;
  transition: background-color 0.2s ease;
}
.hover-row:hover {
  background-color: #f3f4f6;
}
</style>

