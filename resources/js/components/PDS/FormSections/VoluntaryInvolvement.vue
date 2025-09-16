<template>
    <h3>Voluntary Involvement</h3>
    <div class="voluntary-form-grid">
        <div class="input-wrapper span-2">
            <label>Organization Name</label>
            <input
            type="text"
            v-model="internalForm.voluntary_works[0].organization_name"
            @input="
                validateField(
                'voluntary_works[0].organization_name',
                internalForm.voluntary_works[0].organization_name
                )
            "
            />
            <span
            v-if="errors['voluntary_works[0].organization_name']"
            class="error input-error-msg"
            >
            {{ errors['voluntary_works[0].organization_name'] }}
            </span>
        </div>

        <div class="input-wrapper span-2">
            <label>Organization Address</label>
            <input type="text" v-model="internalForm.voluntary_works[0].organization_address" />
        </div>

        <div class="inclusive-date span-2">
            <label>Inclusive Date (From - To)</label>
            <div class="date-range">
            <input
                type="date"
                placeholder="From"
                v-model="internalForm.voluntary_works[0].from"
            />
            <input
                type="date"
                placeholder="To"
                v-model="internalForm.voluntary_works[0].to"
            />
            </div>
        </div>

        <div>
            <label>Position</label>
            <input type="text" v-model="internalForm.voluntary_works[0].position" />
        </div>

        <div>
            <label>Number of Hours Rendered</label>
            <input type="text" v-model="internalForm.voluntary_works[0].hours" />
        </div>

        <div class="input-wrapper span-4">
            <label>Nature of Work</label>
            <input type="text" v-model="internalForm.voluntary_works[0].nature_of_work" />
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
