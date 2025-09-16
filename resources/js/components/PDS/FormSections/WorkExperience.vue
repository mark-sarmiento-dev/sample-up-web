<template>
    <h3>Work Experience</h3>
    <div class="work-form-grid">
        <div class="input-wrapper span-2">
            <label>Position Title (Write in full - no abbreviation)</label>
            <input
            type="text"
            v-model="internalForm.work_experiences[0].position_title"
            @input="
                validateField(
                'work_experiences[0].position_title',
                internalForm.work_experiences[0].position_title
                )
            "
            />
            <span
            v-if="errors['work_experiences[0].position_title']"
            class="error input-error-msg"
            >
            {{ errors['work_experiences[0].position_title'] }}
            </span>
        </div>

        <div class="input-wrapper span-2">
            <label>Department/Agency/Office/Company</label>
            <input type="text" v-model="internalForm.work_experiences[0].agency" />
        </div>

        <div>
            <label>Monthly Salary</label>
            <select v-model="internalForm.work_experiences[0].monthly_salary">
            <option value="">Select</option>
            <option value="15000-25000">15,000 - 25,000</option>
            <option value="25000-35000">25,000 - 35,000</option>
            </select>
        </div>

        <div>
            <label>Status of Appointment</label>
            <input type="text" v-model="internalForm.work_experiences[0].status_of_appointment" />
        </div>

        <div class="inclusive-date span-2">
            <label>Inclusive Date (From - To)</label>
            <div class="date-range">
            <input
                type="date"
                placeholder="From"
                v-model="internalForm.work_experiences[0].inclusive_from"
            />
            <input
                type="date"
                placeholder="To"
                v-model="internalForm.work_experiences[0].inclusive_to"
            />
            </div>
        </div>

        <div class="input-wrapper span-2">
            <label>Salary/Job/Pay Grade & Step (if government)</label>
            <input type="text" v-model="internalForm.work_experiences[0].salary_job_grade" />
        </div>
    </div>
</template>

<script setup>
defineProps({
  internalForm: {
    type: Object,
    required: true,
  },
  errors: {
    type: Object,
    required: true,
  },
  validateField: {
    type: Function,
    required: true,
  },
});
</script>
