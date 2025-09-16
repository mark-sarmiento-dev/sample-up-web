<template>
  <h3>Educational Background</h3>
  <div class="education-form-grid">
    <div class="input-wrapper span-2">
      <label>Highest Educational Attainment</label>
      <select
        v-model="internalForm.educations[0].highest_educational_attainment"
        @change="
          validateField(
            'educations[0].highest_educational_attainment',
            internalForm.educations[0].highest_educational_attainment
          )
        "
      >
        <option value="">Select</option>
        <option value="elementary">Elementary</option>
        <option value="secondary">Secondary</option>
        <option value="vocational">Vocational/Trade Course</option>
        <option value="college">College</option>
        <option value="graduate">Graduate Studies</option>
      </select>
      <span
        v-if="errors['educations[0].highest_educational_attainment']"
        class="error input-error-msg"
      >
        {{ errors['educations[0].highest_educational_attainment'] }}
      </span>
    </div>

    <div class="input-wrapper span-2">
      <label>Name of School</label>
      <input
        type="text"
        v-model="internalForm.educations[0].school_name"
        @input="
          validateField(
            'educations[0].school_name',
            internalForm.educations[0].school_name
          )
        "
      />
      <span
        v-if="errors['educations[0].school_name']"
        class="error input-error-msg"
      >
        {{ errors['educations[0].school_name'] }}
      </span>
    </div>

    <div class="attendance span-2">
      <label>Period of Attendance (From - To)</label>
      <div class="date-range">
        <input
          type="date"
          placeholder="From"
          v-model="internalForm.educations[0].attendance_from"
        />
        <input
          type="date"
          placeholder="To"
          v-model="internalForm.educations[0].attendance_to"
        />
      </div>
    </div>

    <div class="input-wrapper span-2">
      <label>Scholarships/Academic Honors Received</label>
      <input type="text" v-model="internalForm.educations[0].scholarships" />
    </div>

    <div>
      <label>Year Graduated</label>
      <input type="text" v-model="internalForm.educations[0].year_graduated" />
    </div>

    <div>
      <label>Highest Level/Units Earned</label>
      <input
        type="text"
        v-model="internalForm.educations[0].highest_level_units"
      />
    </div>

    <div class="input-wrapper span-2">
      <label>Basic Educational Degree/Course</label>
      <input type="text" v-model="internalForm.educations[0].degree_course" />
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
