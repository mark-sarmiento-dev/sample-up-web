    <template>
        <form class="form-section">
            <div v-if="activeTab === 'personal'">
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
            </div>

            <div v-else-if="activeTab === 'family'">
                <h3>Family Background</h3>
                <div class="family-form-grid">
                    <div class="family span-2">
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
                                    <span v-if="errors['spouse.name']" class="error input-error-msg">{{ errors['spouse.name'] }}</span>
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
                                    <span v-if="errors['father.name']" class="error input-error-msg">{{ errors['father.name'] }}</span>
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
                                    <span v-if="errors['mother.name']" class="error input-error-msg">{{ errors['mother.name'] }}</span>
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
                        <div class="input-wrapper">
                            <label>Children's</label>
                            <div v-for="(child, idx) in internalForm.children" :key="`child-${idx}`" class="children-info">
                                <div class="input-wrapper span-2">
                                    <label>Full Name</label>
                                    <input type="text" v-model="child.full_name" />
                                </div>
                                <div class="input-wrapper span-1">
                                    <label>Date of Birth</label>
                                    <input type="date" v-model="child.birth_date" />
                                </div>
                                <img class="remove-children-icon" src="images/icons/close.png" @click.prevent="removeChild(idx)" />
                            </div>
                            <Button class="btn-add-children" variant="secondary" @click.prevent="addChild"><img src="images/icons/plus.png"></Button>
                        </div>
                        
                    </div>
                </div>
            </div>

            <div v-else-if="activeTab === 'education'">
                <h3>Educational Background</h3>
                <div v-for="(educations, idx) in internalForm.educations" :key="`child-${idx}`" class="education-form-grid">
                    <div class="input-wrapper span-2">
                        <label>Highest Educational Attainment</label>
                        <select 
                            v-model="educations.highest_educational_attainment"
                            @change="validateField(`educations[${idx}].highest_educational_attainment`, educations.highest_educational_attainment)"
                        >
                            <option value="">Select</option>
                            <option value="elementary">Elementary</option>
                            <option value="secondary">Secondary</option>
                            <option value="vocational">Vocational/Trade Course</option>
                            <option value="college">College</option>
                            <option value="graduate">Graduate Studies</option>
                        </select>
                        <span v-if="errors[`educations[${idx}].highest_educational_attainment`]" class="error input-error-msg">
                            {{ errors[`educations[${idx}].highest_educational_attainment`] }}
                        </span>
                    </div>
                    <div class="input-wrapper span-2">
                        <label>Name of School</label>
                        <input 
                            type="text" 
                            v-model="educations.school_name" 
                            @input="validateField(`educations[${idx}].school_name`, educations.school_name)"
                        />
                        <span v-if="errors[`educations[${idx}].school_name`]" class="error input-error-msg">
                            {{ errors[`educations[${idx}].school_name`] }}
                        </span>
                    </div>
                    <div class="attendance span-2">
                        <label>Period of  Attendance (From - To)</label>
                        <div class="date-range">
                            <input type="date" placeholder="From" v-model="educations.attendance_from" />
                            <input type="date" placeholder="To" v-model="educations.attendance_to" />
                        </div>
                    </div>
                    <div class="input-wrapper span-2">
                        <label>Scholarships/Academic Honors Received</label>
                        <input type="text" v-model="educations.scholarships" />
                    </div>
                    <div>
                        <label>Year Graduated</label>
                        <input type="text" v-model="educations.year_graduated" />
                    </div>
                    <div>
                        <label>Highest Level/Units Earned</label>
                        <input type="text" v-model="educations.highest_level_units" />
                    </div>
                    <div class="input-wrapper span-2">
                        <label>Basic Educational Degree/Course</label>
                        <input type="text" v-model="educations.degree_course" />
                    </div>
                    <img src="images/icons/close.png" @click.prevent="removeEducation(idx)"/>
                </div>
                <Button class="btn-add-education" variant="secondary" @click.prevent="addEducation">
                    <img src="images/icons/plus.png"/>
                </Button>
            </div>

            <div v-else-if="activeTab === 'eligibility'">
                <h3>Civil Service Eligibility</h3>
                <div class="eligibility-form-grid">
                    <div class="input-wrapper span-2">
                        <label>Career Service/Eligibility</label>
                        <input 
                            type="text" 
                            v-model="internalForm.eligibilities[0].career_service"
                            @input="validateField('eligibilities[0].career_service', internalForm.eligibilities[0].career_service)"
                        />
                        <span v-if="errors['eligibilities[0].career_service']" class="error input-error-msg">
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
            </div>

            <div v-else-if="activeTab === 'work'">
                <h3>Work Experience</h3>
                <div class="work-form-grid">
                    <div class="input-wrapper span-2">
                        <label>Position Title (Write in full -  no abbreviation)</label>
                        <input 
                            type="text" 
                            v-model="internalForm.work_experiences[0].position_title"
                            @input="validateField('work_experiences[0].position_title', internalForm.work_experiences[0].position_title)"
                        />
                        <span v-if="errors['work_experiences[0].position_title']" class="error input-error-msg">
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
                            <input type="date" placeholder="From" v-model="internalForm.work_experiences[0].inclusive_from" />
                            <input type="date" placeholder="To" v-model="internalForm.work_experiences[0].inclusive_to" />
                        </div>
                    </div>
                    <div class="input-wrapper span-2">
                        <label>Salary/Job/Pay Grade & Step (if government) </label>
                        <input type="text" v-model="internalForm.work_experiences[0].salary_job_grade" />
                    </div>
                </div>
            </div>

            <div v-else-if="activeTab === 'voluntary'">
                <h3>Voluntary Involvement</h3>
                <div class="voluntary-form-grid">
                    <div class="input-wrapper span-2">
                        <label>Organization Name</label>
                        <input 
                            type="text" 
                            v-model="internalForm.voluntary_works[0].organization_name"
                            @input="validateField('voluntary_works[0].organization_name', internalForm.voluntary_works[0].organization_name)"
                        />
                        <span v-if="errors['voluntary_works[0].organization_name']" class="error input-error-msg">
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
                            <input type="date" placeholder="From" v-model="internalForm.voluntary_works[0].from" />
                            <input type="date" placeholder="To" v-model="internalForm.voluntary_works[0].to" />
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
            </div>

            <div v-else-if="activeTab === 'training'">
                <h3>Training Attended</h3>
                <div class="training-form-grid">
                    <div class="input-wrapper span-2">
                        <label>Title of Learning and Development Program (Write in full)</label>
                        <input 
                            type="text" 
                            v-model="internalForm.trainings[0].title"
                            @input="validateField('trainings[0].title', internalForm.trainings[0].title)"
                        />
                        <span v-if="errors['trainings[0].title']" class="error input-error-msg">
                            {{ errors['trainings[0].title'] }}
                        </span>
                    </div>
                    <div class="inclusive-date span-2">
                        <label>Inclusive Date (From - To)</label>
                        <div class="date-range">
                            <input type="date" placeholder="From" v-model="internalForm.trainings[0].from" />
                            <input type="date" placeholder="To" v-model="internalForm.trainings[0].to" />
                        </div>
                    </div>
                    <div class="input-wrapper span-2">
                        <label>Type of L&D (Managerial, Supervisory, Technical, etc)</label>
                        <input type="text" v-model="internalForm.trainings[0].type" />
                    </div>
                    <div class="input-wrapper span-2">
                        <label>Conducted Sponsored By</label>
                        <input type="text" v-model="internalForm.trainings[0].conducted_by" />
                    </div>
                </div>
            </div>

            <div v-else-if="activeTab === 'other'">
                <h3>Other Relevant Information</h3>
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
                            @input="validateField('other_infos[0].membership', internalForm.other_infos[0].membership)"
                        />
                        <span v-if="errors['other_infos[0].membership']" class="error input-error-msg">
                            {{ errors['other_infos[0].membership'] }}
                        </span>
                    </div>
                    <div class="input-wrapper span-2">
                        <label>Conducted Sponsored By</label>
                        <input type="text" v-model="internalForm.other_infos[0].sponsored_by" />
                    </div>
                    <div class="references span-2">
                        <label>References (Not related by blood or affinity)</label>
                        <div v-for="(ref, idx) in internalForm.references" :key="`ref-${idx}`" class="ref-inputs">
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
                            <img class="remove-ref-icon" src="images/icons/close.png" @click.prevent="removeReference(idx)"/>
                        </div>
                        <Button class="btn-add-reference" variant="secondary" @click.prevent="addReference"><img src="images/icons/plus.png"></Button>
                    </div>
                </div>
            </div>
        </form>
    </template>
    <script setup>
        import Button from "@/components/Common/Button.vue";
        import { useValidation } from "../../Composables/useValidation";
        import { reactive, watch } from "vue";

        const { fieldRules, rulesPerTab } = useValidation();

        defineProps({
            activeTab: {
                type: String,
                required: true
            },
            formData: {
                type: Object,
                default: () => ({})
            },
            errors: Object,
            validateField: Function
        });

        const emit = defineEmits(['update:formData']);

        const internalForm = reactive({
            // Personal
            last_name: (typeof formData !== 'undefined' && formData.last_name) ? formData.last_name : "",
            first_name: (typeof formData !== 'undefined' && formData.first_name) ? formData.first_name : "",
            middle_name: (typeof formData !== 'undefined' && formData.middle_name) ? formData.middle_name : "",
            name_extension: (typeof formData !== 'undefined' && formData.name_extension) ? formData.name_extension : "",
            birth_date: (typeof formData !== 'undefined' && formData.birth_date) ? formData.birth_date : "",
            place_of_birth: (typeof formData !== 'undefined' && formData.place_of_birth) ? formData.place_of_birth : "",
            sex: (typeof formData !== 'undefined' && formData.sex) ? formData.sex : "",
            civil_status: (typeof formData !== 'undefined' && formData.civil_status) ? formData.civil_status : "",
            height: (typeof formData !== 'undefined' && formData.height) ? formData.height : "",
            weight: (typeof formData !== 'undefined' && formData.weight) ? formData.weight : "",
            blood_type: (typeof formData !== 'undefined' && formData.blood_type) ? formData.blood_type : "",
            gsis_id_no: (typeof formData !== 'undefined' && formData.gsis_id_no) ? formData.gsis_id_no : "",
            pagibig_id_no: (typeof formData !== 'undefined' && formData.pagibig_id_no) ? formData.pagibig_id_no : "",
            philhealth_no: (typeof formData !== 'undefined' && formData.philhealth_no) ? formData.philhealth_no : "",
            sss_no: (typeof formData !== 'undefined' && formData.sss_no) ? formData.sss_no : "",
            tin_no: (typeof formData !== 'undefined' && formData.tin_no) ? formData.tin_no : "",
            agency_employee_no: (typeof formData !== 'undefined' && formData.agency_employee_no) ? formData.agency_employee_no : "",
            citizenship: (typeof formData !== 'undefined' && formData.citizenship) ? formData.citizenship : "",
            residential_address: (typeof formData !== 'undefined' && formData.residential_address) ? formData.residential_address : "",
            residential_zip: (typeof formData !== 'undefined' && formData.residential_zip) ? formData.residential_zip : "",
            permanent_address: (typeof formData !== 'undefined' && formData.permanent_address) ? formData.permanent_address : "",
            permanent_zip: (typeof formData !== 'undefined' && formData.permanent_zip) ? formData.permanent_zip : "",
            email: (typeof formData !== 'undefined' && formData.email) ? formData.email : "",
            telephone_no: (typeof formData !== 'undefined' && formData.telephone_no) ? formData.telephone_no : "",
            mobile_no: (typeof formData !== 'undefined' && formData.mobile_no) ? formData.mobile_no : "",
            ctc_place_of_issuance: (typeof formData !== 'undefined' && formData.ctc_place_of_issuance) ? formData.ctc_place_of_issuance : "",
            ctc_number: (typeof formData !== 'undefined' && formData.ctc_number) ? formData.ctc_number : "",
            ctc_date_of_issuance: (typeof formData !== 'undefined' && formData.ctc_date_of_issuance) ? formData.ctc_date_of_issuance : "",

            // Family
            spouse: (typeof formData !== 'undefined' && formData.spouse) ? formData.spouse : { name: "", birth_date: "", relationship: "", occupation: "", business_address: "", telephone_no: "", employer: "" },
            father: (typeof formData !== 'undefined' && formData.father) ? formData.father : { name: "", birth_date: "", relationship: "", occupation: "", business_address: "", telephone_no: "", employer: "" },
            mother: (typeof formData !== 'undefined' && formData.mother) ? formData.mother : { name: "", birth_date: "", relationship: "", occupation: "", business_address: "", telephone_no: "", employer: "" },
            children: (typeof formData !== 'undefined' && Array.isArray(formData.children) && formData.children.length) ? formData.children : [{ full_name: "", birth_date: "" }],

            // Education (single entry as default; backend accepts array)
            educations: (typeof formData !== 'undefined' && Array.isArray(formData.educations) && formData.educations.length) ? formData.educations : [{
                highest_educational_attainment: "",
                school_name: "",
                attendance_from: "",
                attendance_to: "",
                scholarships: "",
                year_graduated: "",
                highest_level_units: "",
                degree_course: ""
            }],

            // Eligibility
            eligibilities: (typeof formData !== 'undefined' && Array.isArray(formData.eligibilities) && formData.eligibilities.length) ? formData.eligibilities : [{
                career_service: "",
                rating: "",
                date_of_examination: "",
                place_of_examination: "",
                license_no: "",
                date_of_validity: ""
            }],

            // Work
            work_experiences: (typeof formData !== 'undefined' && Array.isArray(formData.work_experiences) && formData.work_experiences.length) ? formData.work_experiences : [{
                position_title: "",
                agency: "",
                monthly_salary: "",
                status_of_appointment: "",
                inclusive_from: "",
                inclusive_to: "",
                salary_job_grade: ""
            }],

            // Voluntary
            voluntary_works: (typeof formData !== 'undefined' && Array.isArray(formData.voluntary_works) && formData.voluntary_works.length) ? formData.voluntary_works : [{
                organization_name: "",
                organization_address: "",
                from: "",
                to: "",
                position: "",
                hours: "",
                nature_of_work: ""
            }],

            // Trainings
            trainings: (typeof formData !== 'undefined' && Array.isArray(formData.trainings) && formData.trainings.length) ? formData.trainings : [{
                title: "",
                from: "",
                to: "",
                type: "",
                conducted_by: ""
            }],

            // Other infos
            other_infos: (typeof formData !== 'undefined' && Array.isArray(formData.other_infos) && formData.other_infos.length) ? formData.other_infos : [{
                special_skills: "",
                distinctions: "",
                membership: "",
                sponsored_by: ""
            }],

            // References
            references: (typeof formData !== 'undefined' && Array.isArray(formData.references) && formData.references.length) ? formData.references : [{ fullname: "", telephone_no: "", address: "" }]
        });

        watch(internalForm, (newVal) => {
            // emit a deep-cloned copy so parent receives a plain object
            emit('update:formData', JSON.parse(JSON.stringify(newVal)));
        }, { deep: true });

        function addChild() {
            internalForm.children.push({ full_name: "", birth_date: "" });
        }
        function removeChild(index) {
            internalForm.children.splice(index, 1);
        }

        function addEducation() {
            const index = internalForm.educations.length;
            internalForm.educations.push({
                highest_educational_attainment: "",
                school_name: "",
                attendance_from: "",
                attendance_to: "",
                scholarships: "",
                year_graduated: "",
                highest_level_units: "",
                degree_course: ""
            });

            console.log(index)

            const schoolKey = `educations[${index}].school_name`;
            const attainmentKey = `educations[${index}].highest_educational_attainment`;

            fieldRules[schoolKey] = [(v) => !!v || "School name is required."];
            fieldRules[attainmentKey] = [(v) => !!v || "Highest educational attainment is required."];

            rulesPerTab.education.push(schoolKey);
            rulesPerTab.education.push(attainmentKey);

            console.log(fieldRules)
            console.log(rulesPerTab)
            console.log(internalForm.educations)

        }
        function removeEducation(index) {
            internalForm.educations.splice(index, 1)
        }

        function addReference() {
            internalForm.references.push({ fullname: "", telephone_no: "", address: "" });
        }
        function removeReference(index) {
            internalForm.references.splice(index, 1);
        }
    </script>
