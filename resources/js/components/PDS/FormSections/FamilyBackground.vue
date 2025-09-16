<template>
    <h3>Family Background</h3>
    <div class="family-form-grid">
        <div class="family span-2">
            <!-- SPOUSE -->
            <div class="input-wrapper">
            <label>Spouse</label>
            <div class="spouse-info">
                <div>
                <label>Name</label>
                <input
                    type="text"
                    v-model="internalForm.spouse.name"
                    @input="validateField('spouse.name', internalForm.spouse.name)"
                />
                <span
                    v-if="errors['spouse.name']"
                    class="error input-error-msg"
                    >{{ errors['spouse.name'] }}</span
                >
                </div>
                <div>
                <label>Birth Date</label>
                <input type="date" v-model="internalForm.spouse.birth_date" />
                </div>
                <div>
                <label>Relationship</label>
                <input type="text" v-model="internalForm.spouse.relationship" />
                </div>
                <div>
                <label>Occupation</label>
                <input type="text" v-model="internalForm.spouse.occupation" />
                </div>
                <div class="input-wrapper span-2">
                <label>Business Address</label>
                <input type="text" v-model="internalForm.spouse.business_address" />
                </div>
                <div>
                <label>Telephone No.</label>
                <input type="text" v-model="internalForm.spouse.telephone_no" />
                </div>
                <div>
                <label>Employer/Business Name</label>
                <input type="text" v-model="internalForm.spouse.employer" />
                </div>
            </div>
            </div>

            <!-- FATHER -->
            <div class="input-wrapper">
            <label>Father</label>
            <div class="father-info">
                <div>
                <label>Name</label>
                <input
                    type="text"
                    v-model="internalForm.father.name"
                    @input="validateField('father.name', internalForm.father.name)"
                />
                <span
                    v-if="errors['father.name']"
                    class="error input-error-msg"
                    >{{ errors['father.name'] }}</span
                >
                </div>
                <div>
                <label>Birth Date</label>
                <input type="date" v-model="internalForm.father.birth_date" />
                </div>
                <div>
                <label>Relationship</label>
                <input type="text" v-model="internalForm.father.relationship" />
                </div>
                <div>
                <label>Occupation</label>
                <input type="text" v-model="internalForm.father.occupation" />
                </div>
                <div class="input-wrapper span-2">
                <label>Business Address</label>
                <input type="text" v-model="internalForm.father.business_address" />
                </div>
                <div>
                <label>Telephone No.</label>
                <input type="text" v-model="internalForm.father.telephone_no" />
                </div>
                <div>
                <label>Employer/Business Name</label>
                <input type="text" v-model="internalForm.father.employer" />
                </div>
            </div>
            </div>

            <!-- MOTHER -->
            <div class="input-wrapper">
            <label>Mother</label>
            <div class="mother-info">
                <div>
                <label>Name (Maiden's Name)</label>
                <input
                    type="text"
                    v-model="internalForm.mother.name"
                    @input="validateField('mother.name', internalForm.mother.name)"
                />
                <span
                    v-if="errors['mother.name']"
                    class="error input-error-msg"
                    >{{ errors['mother.name'] }}</span
                >
                </div>
                <div>
                <label>Birth Date</label>
                <input type="date" v-model="internalForm.mother.birth_date" />
                </div>
                <div>
                <label>Relationship</label>
                <input type="text" v-model="internalForm.mother.relationship" />
                </div>
                <div>
                <label>Occupation</label>
                <input type="text" v-model="internalForm.mother.occupation" />
                </div>
                <div class="input-wrapper span-2">
                <label>Business Address</label>
                <input type="text" v-model="internalForm.mother.business_address" />
                </div>
                <div>
                <label>Telephone No.</label>
                <input type="text" v-model="internalForm.mother.telephone_no" />
                </div>
                <div>
                <label>Employer/Business Name</label>
                <input type="text" v-model="internalForm.mother.employer" />
                </div>
            </div>
            </div>

            <!-- CHILDREN -->
            <div class="input-wrapper">
            <label>Children's</label>
            <div
                v-for="(child, idx) in internalForm.children"
                :key="`child-${idx}`"
                class="children-info"
            >
                <div class="input-wrapper span-2">
                <label>Full Name</label>
                <input type="text" v-model="child.full_name" />
                </div>
                <div class="input-wrapper span-1">
                <label>Date of Birth</label>
                <input type="date" v-model="child.birth_date" />
                </div>
                <img
                class="remove-children-icon"
                src="images/icons/close.png"
                @click.prevent="removeChild(idx)"
                />
            </div>
            <Button
                class="btn-add-children"
                variant="secondary"
                @click.prevent="addChild"
            >
                <img src="images/icons/plus.png" />
            </Button>
            </div>
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
  addChild: {
    type: Function,
    required: true,
  },
  removeChild: {
    type: Function,
    required: true,
  },
});
</script>