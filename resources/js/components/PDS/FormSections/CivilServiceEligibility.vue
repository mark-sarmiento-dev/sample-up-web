<template>
    <h3>Civil Service Eligibility</h3>
    <div class="eligibility-form-grid">
        <div class="input-wrapper span-2">
            <label>Career Service/Eligibility</label>
            <input
            type="text"
            v-model="internalForm.eligibilities[0].career_service"
            @input="
                validateField(
                'eligibilities[0].career_service',
                internalForm.eligibilities[0].career_service
                )
            "
            />
            <span
            v-if="errors['eligibilities[0].career_service']"
            class="error input-error-msg"
            >
            {{ errors['eligibilities[0].career_service'] }}
            </span>
        </div>

        <div>
            <label>Rating</label>
            <input type="text" v-model="internalForm.eligibilities[0].rating" />
        </div>

        <div>
            <label>Date of Examination</label>
            <input type="date" v-model="internalForm.eligibilities[0].date_of_examination" />
        </div>

        <div class="input-wrapper span-2">
            <label>Place of Examination</label>
            <input type="text" v-model="internalForm.eligibilities[0].place_of_examination" />
        </div>

        <div>
            <label>License No.</label>
            <input type="text" v-model="internalForm.eligibilities[0].license_no" />
        </div>

        <div>
            <label>Date of Validity</label>
            <input type="date" v-model="internalForm.eligibilities[0].date_of_validity" />
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
