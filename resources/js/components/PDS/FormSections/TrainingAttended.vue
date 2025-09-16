<template>
    <h3>Training Attended</h3>
    <div class="training-form-grid">
        <div class="input-wrapper span-2">
            <label>Title of Learning and Development Program (Write in full)</label>
            <input
            type="text"
            v-model="internalForm.trainings[0].title"
            @input="
                validateField(
                'trainings[0].title',
                internalForm.trainings[0].title
                )
            "
            />
            <span
            v-if="errors['trainings[0].title']"
            class="error input-error-msg"
            >
            {{ errors['trainings[0].title'] }}
            </span>
        </div>

        <div class="inclusive-date span-2">
            <label>Inclusive Date (From - To)</label>
            <div class="date-range">
            <input
                type="date"
                placeholder="From"
                v-model="internalForm.trainings[0].from"
            />
            <input
                type="date"
                placeholder="To"
                v-model="internalForm.trainings[0].to"
            />
            </div>
        </div>

        <div class="input-wrapper span-2">
            <label>Type of L&amp;D (Managerial, Supervisory, Technical, etc)</label>
            <input type="text" v-model="internalForm.trainings[0].type" />
        </div>

        <div class="input-wrapper span-2">
            <label>Conducted Sponsored By</label>
            <input type="text" v-model="internalForm.trainings[0].conducted_by" />
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
