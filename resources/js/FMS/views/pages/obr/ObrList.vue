<script setup>
import api from "@fms/utils/api";
import { onMounted, ref, computed } from 'vue'
import DeleteObrModal from './DeleteObrModal.vue'
import ObrModal from './ObrModal.vue'

const obrs = ref([])
const loading = ref(true)

const showEditModal = ref(false)
const showDeleteModal = ref(false)
const selectedObr = ref(null)

// Pagination state
const currentPage = ref(1)
const lastPage = ref(1)
const totalItems = ref(0)

// Fetch OBRs with pagination
const fetchObrs = async (page = 1) => {
  loading.value = true
  try {
    const response = await api.get(`/obr-requests?page=${page}`)
    obrs.value = response.data.data
    currentPage.value = response.data.current_page
    lastPage.value = response.data.last_page
    totalItems.value = response.data.total
  } catch (error) {
    console.error('Failed to fetch OBRs:', error)
  } finally {
    loading.value = false
  }
}

const formatDate = (dateStr) => {
  return new Date(dateStr).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}

const formatCurrency = (value) => {
    return new Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format(value);
}

// Calculate total amount for an OBR
const calculateTotal = (obrObjects) => {
    if (!obrObjects || obrObjects.length === 0) return 0;
    return obrObjects.reduce((sum, item) => sum + parseFloat(item.amount), 0);
}

const handleEdit = (obr) => {
  // Deep clone to prevent unintended reactivity issues in the table
  selectedObr.value = obr ? JSON.parse(JSON.stringify(obr)) : null
  showEditModal.value = true
}

const handleSave = async (updatedObr, done) => {
  try {
    if (updatedObr.id) {
      await api.put(`/obr-requests/${updatedObr.id}`, updatedObr)
    } else {
      await api.post(`/obr-requests`, updatedObr)
    }
    await fetchObrs(currentPage.value)
    done(true) // Signal success to modal
  } catch (error) {
    console.error('Failed to save OBR:', error)
    done(false) // Signal failure to modal
  }
}

const handleDelete = (obr) => {
  selectedObr.value = obr
  showDeleteModal.value = true
}

const confirmDelete = async (done) => {
  if (!selectedObr.value) return
  try {
    await api.delete(`/obr-requests/${selectedObr.value.id}`)
    // Refresh to the current page, or previous if it becomes empty
    if (obrs.value.length === 1 && currentPage.value > 1) {
        await fetchObrs(currentPage.value - 1)
    } else {
        await fetchObrs(currentPage.value)
    }
    done(true)
  } catch (error) {
    console.error('Failed to delete OBR:', error)
    done(false)
  }
}

const goToPage = (page) => {
  if (page < 1 || page > lastPage.value) return
  fetchObrs(page)
}

onMounted(() => {
  fetchObrs()
})
</script>

<template>
  <div class="d-flex justify-end mb-4 responsive-add">
    <VBtn variant="outlined" color="primary" @click="handleEdit(null)">+ Add OBR</VBtn>
  </div>

  <div class="rounded-lg shadow-sm border border-grey-lighten-3 overflow-x-auto">
    <VTable class="bg-grey-lighten-5 text-body-2 min-w-full" style="border-collapse: separate; border-spacing: 0">
      <thead>
        <tr class="bg-grey-lighten-3 text-grey-darken-4 font-weight-medium">
          <th class="text-left px-6 py-3">OBR Number</th>
          <th class="text-left px-6 py-3">Office Address</th>
          <th class="text-left px-6 py-3">Total Amount</th>
          <th class="text-left px-6 py-3">Created At</th>
          <th class="text-left px-6 py-3">Actions</th>
        </tr>
      </thead>
      <tbody v-if="!loading">
        <tr v-for="(obr, index) in obrs" :key="obr.id" :class="['hover-row', index % 2 === 0 ? 'bg-grey-lighten-5' : '']" @click="handleEdit(obr)">
          <td class="px-6 py-3">{{ obr.obr_no }}</td>
          <td class="px-6 py-3">{{ obr.office_address }}</td>
          <td class="px-6 py-3 font-weight-medium">{{ formatCurrency(calculateTotal(obr.obr_objects)) }}</td>
          <td class="px-6 py-3">{{ formatDate(obr.created_at) }}</td>
          <td class="px-6 py-3 whitespace-nowrap">
            <VBtn variant="text" color="error" size="small" @click.stop="handleDelete(obr)">
              <VIcon icon="bx-trash" class="me-1" />
            </VBtn>
          </td>
        </tr>
        <tr v-if="obrs.length === 0">
          <td colspan="5" class="text-center py-6 text-grey-darken-2">No OBRs found.</td>
        </tr>
      </tbody>
      <tbody v-else>
        <tr>
          <td colspan="5" class="text-center py-10">
            <VProgressCircular indeterminate color="primary" size="32" width="4" />
            <div class="mt-2 text-grey-darken-2">Loading OBRs...</div>
          </td>
        </tr>
      </tbody>
    </VTable>
  </div>

  <div v-if="!loading && lastPage > 1" class="d-flex flex-wrap justify-between items-center mt-4 gap-4 pagination-wrapper">
    <div class="text-grey-darken-2 text-sm">
      Showing {{ obrs.length }} of {{ totalItems }} results
    </div>
    <div class="d-flex gap-2 items-center ms-auto flex-wrap justify-center">
        <VBtn class="pagination-btn" size="small" :disabled="currentPage === 1" @click="goToPage(currentPage - 1)">‹ Previous</VBtn>
        <VBtn v-for="page in lastPage" :key="page" size="small" :class="page === currentPage ? 'pagination-active' : 'pagination-btn'" @click="goToPage(page)">{{ page }}</VBtn>
        <VBtn class="pagination-btn" size="small" :disabled="currentPage === lastPage" @click="goToPage(currentPage + 1)">Next ›</VBtn>
    </div>
  </div>

  <ObrModal v-model="showEditModal" :obr="selectedObr" @save="handleSave" />
  <DeleteObrModal v-model="showDeleteModal" :obr="selectedObr" @confirm="confirmDelete" />
</template>

<style scoped>
.hover-row {
  transition: background-color 0.2s ease;
  cursor: pointer;
}
.hover-row:hover {
  background-color: #f3f4f6;
}
/* Note: Reuse your pagination styles from OfficeCodes.vue */
.pagination-btn { background-color: #f3f4f6 !important; }
.pagination-active { background-color: #2563eb !important; color: #ffffff !important; }
</style>