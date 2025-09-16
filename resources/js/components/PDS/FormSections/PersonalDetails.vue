<template>
    <h3>Personal Details</h3>
    <div class="personal-form-grid">
        <div class="personal-info">
        <div>
            <label>Lastname</label>
            <input type="text" v-model="internalForm.last_name" />
            <span v-if="errors.last_name" class="error input-error-msg">{{ errors.last_name }}</span>
        </div>
        <div>
            <label>Firstname</label>
            <input type="text" v-model="internalForm.first_name" />
            <span v-if="errors.first_name" class="error input-error-msg">{{ errors.first_name }}</span>
        </div>
        <div>
            <label>Middlename</label>
            <input type="text" v-model="internalForm.middle_name" />
            <span v-if="errors.middle_name" class="error input-error-msg">{{ errors.middle_name }}</span>
        </div>
        <div>
            <label>Suffix (e.g., Jr., Sr., II)</label>
            <input type="text" v-model="internalForm.name_extension" />
            <span v-if="errors.name_extension" class="error input-error-msg">{{ errors.name_extension }}</span>
        </div>
        <div>
            <label>Date of Birth</label>
            <input type="date" v-model="internalForm.birth_date" />
            <span v-if="errors.birth_date" class="error input-error-msg">{{ errors.birth_date }}</span>
        </div>
        <div class="input-wrapper span-3">
            <label>Place of Birth</label>
            <input type="text" v-model="internalForm.place_of_birth" />
            <span v-if="errors.place_of_birth" class="error input-error-msg">{{ errors.place_of_birth }}</span>
        </div>
        <div>
            <label>Sex</label>
            <select v-model="internalForm.sex">
            <option value="">Select</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            </select>
            <span v-if="errors.sex" class="error input-error-msg">{{ errors.sex }}</span>
        </div>
        <div>
            <label>Civil Status</label>
            <input type="text" v-model="internalForm.civil_status" />
            <span v-if="errors.civil_status" class="error input-error-msg">{{ errors.civil_status }}</span>
        </div>
        <div>
            <label>Height (cm)</label>
            <input type="text" v-model="internalForm.height" />
            <span v-if="errors.height" class="error input-error-msg">{{ errors.height }}</span>
        </div>
        <div>
            <label>Weight (kg)</label>
            <input type="text" v-model="internalForm.weight" />
            <span v-if="errors.weight" class="error input-error-msg">{{ errors.weight }}</span>
        </div>
        <div>
            <label>Blood Type</label>
            <input type="text" v-model="internalForm.blood_type" />
            <span v-if="errors.blood_type" class="error input-error-msg">{{ errors.blood_type }}</span>
        </div>
        </div>

        <div class="govt-info">
        <div>
            <label>GSIS ID No.</label>
            <input type="text" v-model="internalForm.gsis_id_no" />
            <span v-if="errors.gsis_id_no" class="error input-error-msg">{{ errors.gsis_id_no }}</span>
        </div>
        <div>
            <label>Pag-Ibig ID No.</label>
            <input type="text" v-model="internalForm.pagibig_id_no" />
            <span v-if="errors.pagibig_id_no" class="error input-error-msg">{{ errors.pagibig_id_no }}</span>
        </div>
        <div>
            <label>Phil-Health No.</label>
            <input type="text" v-model="internalForm.philhealth_no" />
            <span v-if="errors.philhealth_no" class="error input-error-msg">{{ errors.philhealth_no }}</span>
        </div>
        <div>
            <label>SSS No.</label>
            <input type="text" v-model="internalForm.sss_no" />
            <span v-if="errors.sss_no" class="error input-error-msg">{{ errors.sss_no }}</span>
        </div>
        <div>
            <label>Tin No.</label>
            <input type="text" v-model="internalForm.tin_no" />
            <span v-if="errors.tin_no" class="error input-error-msg">{{ errors.tin_no }}</span>
        </div>
        <div>
            <label>Agency Employee No.</label>
            <input type="text" v-model="internalForm.agency_employee_no" />
            <span v-if="errors.agency_employee_no" class="error input-error-msg">{{ errors.agency_employee_no }}</span>
        </div>
        <div>
            <label>Citizenship</label>
            <input type="text" v-model="internalForm.citizenship" />
            <span v-if="errors.citizenship" class="error input-error-msg">{{ errors.citizenship }}</span>
        </div>
        </div>

        <div class="contact-address-info">
        <div class="input-wrapper span-3">
            <label>Residential Address</label>
            <input type="text" v-model="internalForm.residential_address" />
            <span v-if="errors.residential_address" class="error input-error-msg">{{ errors.residential_address }}</span>
        </div>
        <div>
            <label>Residential Zip</label>
            <input type="text" v-model="internalForm.residential_zip" />
            <span v-if="errors.residential_zip" class="error input-error-msg">{{ errors.residential_zip }}</span>
        </div>
        <div class="input-wrapper span-3">
            <label>Permanent Address</label>
            <input type="text" v-model="internalForm.permanent_address" />
            <span v-if="errors.permanent_address" class="error input-error-msg">{{ errors.permanent_address }}</span>
        </div>
        <div>
            <label>Permanent Zip</label>
            <input type="text" v-model="internalForm.permanent_zip" />
            <span v-if="errors.permanent_address" class="error input-error-msg">{{ errors.permanent_address }}</span>
        </div>
        <div class="input-wrapper span-2">
            <label>Email Address</label>
            <input type="text" v-model="internalForm.email" />
            <span v-if="errors.email" class="error input-error-msg">{{ errors.email }}</span>
        </div>
        <div>
            <label>Telephone No.</label>
            <input type="text" v-model="internalForm.telephone_no" />
            <span v-if="errors.telephone_no" class="error input-error-msg">{{ errors.telephone_no }}</span>
        </div>
        <div>
            <label>Mobile No.</label>
            <input type="text" v-model="internalForm.mobile_no" />
            <span v-if="errors.mobile_no" class="error input-error-msg">{{ errors.mobile_no }}</span>
        </div>
        <div class="input-wrapper span-2">
            <label>CTC Place of Issuance</label>
            <input type="text" v-model="internalForm.ctc_place_of_issuance" />
            <span v-if="errors.ctc_place_of_issuance" class="error input-error-msg">{{ errors.ctc_place_of_issuance }}</span>
        </div>
        <div>
            <label>CTC No.</label>
            <input type="text" v-model="internalForm.ctc_number" />
            <span v-if="errors.ctc_number" class="error input-error-msg">{{ errors.ctc_number }}</span>
        </div>
        <div>
            <label>CTC Date of Issuance</label>
            <input type="date" v-model="internalForm.ctc_date_of_issuance" />
            <span v-if="errors.ctc_date_of_issuance" class="error input-error-msg">{{ errors.ctc_date_of_issuance }}</span>
        </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
  internalForm: { type: Object, required: true },
  errors: { type: Object, required: true }
});
</script>
