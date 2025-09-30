<script setup>
import api from "@fms/utils/api";
import { computed, onMounted, ref } from 'vue'
const requests = ref([])
const loading = ref(true)
const activeRequestIds = ref([])
const activeGroupIds = ref([])

const searchQuery = ref('')
const sortOrder = ref('desc') // default newest first

async function fetchRequests() {
  loading.value = true
  try {
    const response = await api.get('/pao-requests')
    requests.value = response.data
  } catch (error) {
    console.error('Failed to fetch requests:', error)
  } finally {
    loading.value = false
  }
}
onMounted(fetchRequests)

function formatDate(dateStr) {
  const d = new Date(dateStr)
  return d.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  })
}

function togglePanel(list, id) {
  const idx = list.indexOf(id)
  if (idx === -1) list.push(id)
  else list.splice(idx, 1)
}
function isActive(list, id) {
  return list.includes(id)
}

/* --- smooth expand/collapse --- */
function beforeEnter(el) {
  el.style.height = '0'
  el.style.opacity = '0'
  el.style.overflow = 'hidden'
}
function enter(el, done) {
  const height = el.scrollHeight + 'px'
  el.style.transition = 'height 300ms ease, opacity 200ms ease'
  requestAnimationFrame(() => {
    el.style.height = height
    el.style.opacity = '1'
  })
  const onEnd = (e) => {
    if (e.target !== el) return
    el.style.height = ''
    el.style.transition = ''
    el.style.overflow = ''
    el.removeEventListener('transitionend', onEnd)
    done()
  }
  el.addEventListener('transitionend', onEnd)
}
function leave(el, done) {
  el.style.height = el.scrollHeight + 'px'
  el.style.opacity = '1'
  el.style.overflow = 'hidden'
  el.getBoundingClientRect()
  requestAnimationFrame(() => {
    el.style.transition = 'height 300ms ease, opacity 200ms ease'
    el.style.height = '0'
    el.style.opacity = '0'
  })
  const onEnd = (e) => {
    if (e.target !== el) return
    el.style.height = ''
    el.style.transition = ''
    el.style.overflow = ''
    el.removeEventListener('transitionend', onEnd)
    done()
  }
  el.addEventListener('transitionend', onEnd)
}

/* --- computed filtered & sorted requests --- */
const filteredRequests = computed(() => {
  let result = requests.value

  if (searchQuery.value.trim() !== '') {
    const q = searchQuery.value.toLowerCase()
    result = result.filter((req) =>
      req.name?.toLowerCase().includes(q) ||
      req.office_code_description?.toLowerCase().includes(q) ||
      req.tracking?.toLowerCase().includes(q)
    )
  }

  result = result.sort((a, b) => {
    const da = new Date(a.created_at)
    const db = new Date(b.created_at)
    return sortOrder.value === 'asc' ? da - db : db - da
  })

  return result
})
</script>

<template>
    <!-- Add button row -->
  <div class="d-flex justify-end mb-4 responsive-add">
    <VBtn variant="outlined" color="primary" @click="Alert('asd')">+ Add PAO Request</VBtn>
  </div>

  <div class="accordion-card">
    <!-- Search + Sort Controls -->
    <div class="controls">
      <input
        v-model="searchQuery"
        type="text"
        placeholder="Search by requester, office, or tracking..."
        class="search-input"
      />
      <select v-model="sortOrder" class="sort-select">
        <option value="desc">Newest First</option>
        <option value="asc">Oldest First</option>
      </select>
    </div>

    <!-- Loader -->
    <div v-if="loading" class="py-10 text-center">
      <VProgressCircular indeterminate color="primary" size="32" width="4" />
      <div class="mt-2 text-grey-darken-2 loader-text">
        Loading requests...
      </div>
    </div>

    <!-- Accordion -->
    <div v-else>
      <div
        v-for="req in filteredRequests"
        :key="req.request_id"
        class="accordion-item"
      >
        <!-- Request Header -->
        <button
          class="accordion-header"
          type="button"
          :aria-expanded="isActive(activeRequestIds, req.request_id)"
          @click="togglePanel(activeRequestIds, req.request_id)"
        >
          <div class="header-left">
            <div class="group-title">{{ req.office_code_description }}</div>
            <div class="subheader">{{ formatDate(req.created_at) }}</div>
            <div class="subheader">Requested By: {{ req.name }}</div>
          </div>
          <div class="header-right">
            <span v-if="req.tracking" class="tracking">{{ req.tracking }}</span>
            <span v-else class="tracking text-grey-darken-1">No tracking</span>
            <VIcon
              :class="['caret', { rotated: isActive(activeRequestIds, req.request_id) }]"
              icon="bx-chevron-down"
            />
          </div>
        </button>

        <!-- Request Body (Groups Accordion) -->
        <transition @before-enter="beforeEnter" @enter="enter" @leave="leave">
          <div
            v-if="isActive(activeRequestIds, req.request_id)"
            class="accordion-body"
          >
            <div
              v-for="grp in req.groups"
              :key="`${req.request_id}-${grp.group_id}`"
              class="accordion-item group-accordion"
            >
              <!-- Group Header -->
              <button
                class="accordion-header group-header"
                type="button"
                :aria-expanded="isActive(activeGroupIds, `${req.request_id}-${grp.group_id}`)"
                @click="togglePanel(activeGroupIds, `${req.request_id}-${grp.group_id}`)"
              >
                <div class="group-title">{{ grp.group_name }}</div>
                <VIcon
                  :class="['caret', { rotated: isActive(activeGroupIds, `${req.request_id}-${grp.group_id}`) }]"
                  icon="bx-chevron-down"
                />
              </button>

              <!-- Group Body (Objects Table) -->
              <transition @before-enter="beforeEnter" @enter="enter" @leave="leave">
                <div
                  v-if="isActive(activeGroupIds, `${req.request_id}-${grp.group_id}`)"
                  class="accordion-body"
                >
                  <VTable class="accordion-table">
                    <thead>
                      <tr class="bg-grey-lighten-4 text-grey-darken-3 text-sm">
                        <th>Account Code</th>
                        <th>Object Expenditure</th>
                        <th class="text-right">Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="obj in grp.objects" :key="obj.object_expenditure_id">
                        <td>{{ obj.account_code }}</td>
                        <td>{{ obj.object_expenditure_name }}</td>
                        <td class="text-right">{{ obj.amount }}</td>
                      </tr>
                    </tbody>
                  </VTable>
                </div>
              </transition>
            </div>
          </div>
        </transition>
      </div>

      <!-- Empty state -->
      <div v-if="!loading && filteredRequests.length === 0" class="text-center py-6 text-grey-darken-2">
        No requests found.
      </div>
    </div>
  </div>
</template>

<style scoped>
.loader-text {
  font-size: 0.875rem;
}
.accordion-card {
  background: #fff;
  border-radius: 10px;
  border: 1px solid #e6e9ee;
  box-shadow: 0 6px 18px rgba(12, 20, 40, 0.04);
  overflow: hidden;
  padding: 16px;
}
.controls {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 14px;
  gap: 10px;
}
.search-input {
  flex: 1;
  padding: 8px 12px;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  font-size: 0.875rem;
}
.search-input:focus {
  outline: none;
  border-color: #2563eb;
  box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.15);
}
.sort-select {
  padding: 8px 10px;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  font-size: 0.875rem;
  background: #fff;
  color: #334155;
}
.accordion-item + .accordion-item {
  border-top: 1px solid #eef2f6;
}
.accordion-header {
  width: 100%;
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: #f9f9f9;
  padding: 14px 18px;
  border: none;
  cursor: pointer;
  text-align: left;
  transition: background 0.25s ease;
}
.accordion-header:hover {
  background: #f3f4f6;
}
.header-left {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}
.header-right {
  display: flex;
  align-items: center;
  gap: 10px;
}
.group-title {
  font-weight: 600;
  font-size: 1rem;
  color: #12263b;
}
.subheader {
  font-size: 0.875rem;
  color: #64748b;
  margin-top: 2px;
}
.tracking {
  font-size: 0.875rem;
  color: #2563eb;
  font-weight: 500;
}
.caret {
  transition: transform 260ms ease;
}
.caret.rotated {
  transform: rotate(180deg);
}
.accordion-body {
  padding: 12px 18px 20px 18px;
  background: #fff;
}
.group-accordion {
  border: 1px solid #eef2f6;
  margin-top: 8px;
  border-radius: 6px;
}
.group-header {
  background: #fdfdfd;
}
.accordion-table {
  width: 100%;
  border-collapse: collapse;
  table-layout: fixed; /* makes all columns same width across tables */
}

.accordion-table th,
.accordion-table td {
  font-size: 0.875rem;
  color: #334155;
  padding: 10px 14px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.accordion-table th {
  font-weight: 600;
  background: #f9fafb;
  text-align: left;
  border-bottom: 1px solid #e5e7eb;
}

/* enforce consistent widths */
.accordion-table th:nth-child(1),
.accordion-table td:nth-child(1) {
  width: 25%;
}

.accordion-table th:nth-child(2),
.accordion-table td:nth-child(2) {
  width: 50%;
}

.accordion-table th:nth-child(3),
.accordion-table td:nth-child(3) {
  width: 25%;
  text-align: right;
}
</style>
