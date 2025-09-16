<template>
    <h3>Other Relevant Info</h3>
    <div class="other-form-grid">
        <div class="input-wrapper span-2">
            <label>Special Skill/Hobbies</label>
            <input type="text" v-model="internalForm.other_infos[0].special_skills" />
        </div>

        <div class="input-wrapper span-2">
            <label>None-Academic Distinctions/Recognition</label>
            <input type="text" v-model="internalForm.other_infos[0].distinctions" />
        </div>

        <div class="input-wrapper span-2">
            <label>Membership in Association/Organization</label>
            <input
            type="text"
            v-model="internalForm.other_infos[0].membership"
            @input="
                validateField(
                'other_infos[0].membership',
                internalForm.other_infos[0].membership
                )
            "
            />
            <span
            v-if="errors['other_infos[0].membership']"
            class="error input-error-msg"
            >
            {{ errors['other_infos[0].membership'] }}
            </span>
        </div>

        <div class="input-wrapper span-2">
            <label>Conducted Sponsored By</label>
            <input type="text" v-model="internalForm.other_infos[0].sponsored_by" />
        </div>

        <div class="references span-2">
            <label>References (Not related by blood or affinity)</label>

            <div
            v-for="(ref, idx) in internalForm.references"
            :key="`ref-${idx}`"
            class="ref-inputs"
            >
            <div>
                <label>Fullname</label>
                <input type="text" v-model="ref.fullname" />
            </div>
            <div>
                <label>Telephone No.</label>
                <input type="text" v-model="ref.telephone_no" />
            </div>
            <div class="address-wrapper">
                <label>Address</label>
                <input type="text" v-model="ref.address" />
            </div>
            <img
                class="remove-ref-icon"
                src="images/icons/close.png"
                @click.prevent="removeReference(idx)"
            />
            </div>

            <Button
            class="btn-add-reference"
            variant="secondary"
            @click.prevent="addReference"
            >
            <img src="images/icons/plus.png" />
            </Button>
        </div>
    </div>
</template>

<script setup>
import Button from "@/components/Common/Button.vue";

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
  addReference: {
    type: Function,
    required: true,
  },
  removeReference: {
    type: Function,
    required: true,
  },
});
</script>
