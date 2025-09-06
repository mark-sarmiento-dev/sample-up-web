<script setup>
import { ref, computed, onMounted } from "vue";
import Button from "@/components/Common/Button.vue";
import employeeService from "@/services/employeeService";
import PDSFormModal from '@/components/PDSForm/PDSFormModal.vue';

const employees = ref([]);
const search = ref("");
const pdsModalRef = ref(null);

async function fetchEmployees() {
  try {
    const response = await employeeService.getAll();
    employees.value = response.data;
  } catch (error) {
    console.error("Error fetching employees:", error);
  }
}

function openAddEmployee() {
  if (pdsModalRef.value) {
    console.log("Opening Add Employee modal");
    pdsModalRef.value.open();
  }
}


onMounted(() => {
  fetchEmployees();
});

const filteredEmployees = computed(() =>
  employees.value.filter(emp =>
    `${emp.first_name} ${emp.last_name}`
      .toLowerCase()
      .includes(search.value.toLowerCase())
  )
);
</script>

<template>
  <section id="employee">
    <div class="employee-header">
      <input
        type="text"
        v-model="search"
        placeholder="Search employee ..."
        class="search-bar"
      />
      <Button variant="primary" @click="openAddEmployee">
        <img class="icon" src="images/icons/plus.png"/> Add Employee
      </Button>
    </div>

    <div class="employee-table-wrapper">
      <table class="employee-table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Date of Birth</th>
            <th>Agency Employee No.</th>
            <th>Sex</th>
            <th>Civil Status</th>
            <th>Citizenship</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="emp in filteredEmployees" :key="emp.id">
            <td>{{ emp.first_name }} {{ emp.last_name }}</td>
            <td>{{ emp.birth_date }}</td>
            <td>{{ emp.agency_employee_no }}</td>
            <td>{{ emp.sex }}</td>
            <td>{{ emp.civil_status }}</td>
            <td>{{ emp.citizenship }}</td>
            <td>
              <Button variant="secondary" size="xs">
                <img class="icon" src="images/icons/view.png"/>
              </Button>
              <Button variant="secondary" size="xs">
                <img class="icon" src="images/icons/edit.png"/>
              </Button>
              <Button variant="secondary" size="xs">
                <img class="icon" src="images/icons/delete.png"/>
              </Button>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Modal for Add Employee -->
      <PDSFormModal ref="pdsModalRef" @saved="fetchEmployees" />
    </div>
  </section>
</template>
