<template>
    <form class="form-section">
        <div v-if="activeTab === 'personal'">
            <h3>Personal Details</h3>
            <div class="personal-form-grid">
                <div class="personal-info">
                    <div>
                        <label>Lastname</label>
                        <input type="text" value="Montenegro" />
                    </div>
                    <div>
                        <label>Firstname</label>
                        <input type="text" value="Alvin" />
                    </div>
                    <div>
                        <label>Middlename</label>
                        <input type="text" value="Laurel" />
                    </div>
                    <div>
                        <label>Suffix (e.g., Jr., Sr., II)</label>
                        <input type="text" value="Sr" />
                    </div>
                    <div>
                        <label>Date of Birth</label>
                        <input type="date" value="" />
                    </div>
                    <div class="input-wrapper span-3">
                        <label>Place of Birth</label>
                        <input type="text" value="Sampaloc Apalit Pampanga" />
                    </div>
                    <div>
                        <label>Sex</label>
                        <select>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div>
                        <label>Civil Status</label>
                        <input type="text" value="Married" />
                    </div>
                    <div>
                        <label>Height (cm)</label>
                        <input type="text" value="167.3" />
                    </div>
                    <div>
                        <label>Weight (kg)</label>
                        <input type="text" value="68" />
                    </div>
                    <div>
                        <label>Blood Type</label>
                        <input type="text" value="O+" />
                    </div>
                </div>
                <div class="govt-info">
                    <div>
                        <label>GSIS ID No.</label>
                        <input type="text" value="00012345678" />
                    </div>
                    <div>
                        <label>Pag-Ibig ID No.</label>
                        <input type="text" value="1210-1234-5678" />
                    </div>
                    <div>
                        <label>Phil-Health No.</label>
                        <input type="text" value="12-345678901-2" />
                    </div>
                    <div>
                        <label>SSS No.</label>
                        <input type="text" value="34-123456789-0" />
                    </div>
                    <div>
                        <label>Tin No.</label>
                        <input type="text" value="123-456-789-000" />
                    </div>
                    <div>
                        <label>Agency Employee No.</label>
                        <input type="text" value="EMP-001234" />
                    </div>
                    <div>
                        <label>Citizenship</label>
                        <input type="text" value="Filipino" />
                    </div>
                </div>
                <div class="contact-address-info">
                    <div class="input-wrapper span-3">
                        <label>Residential Address</label>
                        <input type="text" value="123 Block 5 Lot 12" />
                    </div>
                    <div>
                        <label>Residential Zip</label>
                        <input type="text" value="2016" />
                    </div>
                    <div class="input-wrapper span-3">
                        <label>Permanent Address</label>
                        <input type="text" value="123 Block 5 Lot 12" />
                    </div>
                    <div>
                        <label>Permanent Zip</label>
                        <input type="text" value="34-123456789-0" />
                    </div>
                    <div class="input-wrapper span-2">
                        <label>Email Address</label>
                        <input type="text" value="sample@gmail.com" />
                    </div>
                    <div>
                        <label>Telephone No.</label>
                        <input type="text" value="(045) 123-4567" />
                    </div>
                    <div>
                        <label>Mobile No.</label>
                        <input type="text" value="09087656766" />
                    </div>
                    <div class="input-wrapper span-2">
                        <label>CTC Place of Issuance</label>
                        <input type="text" value="Sampaloc Apalit Pampanga" />
                    </div>
                    <div>
                        <label>CTC No.</label>
                        <input type="text" value="2025-0001234" />
                    </div>
                    <div>
                        <label>CTC Date of Issuance</label>
                        <input type="date" value="09087656766" />
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
                                <input type="text" value="John Doe Alvarez" />
                            </div>
                            <div>
                                <label>Birth Date</label>
                                <input type="date" value="Jogging and Singing" />
                            </div>
                            <div>
                                <label>Relationship</label>
                                <input type="text" value="Nephew" />
                            </div>
                            <div>
                                <label>Occupation</label>
                                <input type="text" value="Programmer" />
                            </div>
                            <div class="input-wrapper span-2">
                                <label>Business Address</label>
                                <input type="text" value="Sampaloc Apalit Pampanga" />
                            </div>
                            <div>
                                <label>Telephone No.</label>
                                <input type="text" value="(045) 123-4567" />
                            </div>
                            <div>
                                <label>Employer/Business Name</label>
                                <input type="text" value="Mc Donald" />
                            </div>
                        </div>
                    </div>
                    <div class="input-wrapper">
                        <label>Father</label>
                        <div class="father-info">
                            <div>
                                <label>Name</label>
                                <input type="text" value="John Doe Alvarez" />
                            </div>
                            <div>
                                <label>Birth Date</label>
                                <input type="date" value="Jogging and Singing" />
                            </div>
                            <div>
                                <label>Relationship</label>
                                <input type="text" value="Nephew" />
                            </div>
                            <div>
                                <label>Occupation</label>
                                <input type="text" value="Programmer" />
                            </div>
                            <div class="input-wrapper span-2">
                                <label>Business Address</label>
                                <input type="text" value="Sampaloc Apalit Pampanga" />
                            </div>
                            <div>
                                <label>Telephone No.</label>
                                <input type="text" value="(045) 123-4567" />
                            </div>
                            <div>
                                <label>Employer/Business Name</label>
                                <input type="text" value="Mc Donald" />
                            </div>
                        </div>
                    </div>
                    <div class="input-wrapper">
                        <label>Mother</label>
                        <div class="mother-info">
                            <div>
                                <label>Name (Maiden's Name)</label>
                                <input type="text" value="John Doe Alvarez" />
                            </div>
                            <div>
                                <label>Birth Date</label>
                                <input type="date" value="Jogging and Singing" />
                            </div>
                            <div>
                                <label>Relationship</label>
                                <input type="text" value="Nephew" />
                            </div>
                            <div>
                                <label>Occupation</label>
                                <input type="text" value="Programmer" />
                            </div>
                            <div class="input-wrapper span-2">
                                <label>Business Address</label>
                                <input type="text" value="Sampaloc Apalit Pampanga" />
                            </div>
                            <div>
                                <label>Telephone No.</label>
                                <input type="text" value="(045) 123-4567" />
                            </div>
                            <div>
                                <label>Employer/Business Name</label>
                                <input type="text" value="Mc Donald" />
                            </div>
                        </div>
                    </div>
                    <div class="input-wrapper">
                        <label>Children's</label>
                        <div class="children-info">
                            <div class="input-wrapper span-2">
                                <label>Full Name</label>
                                <input type="text" value="John Doe Alvarez" />
                            </div>
                            <div class="input-wrapper span-2">
                                <label>Date of Birth</label>
                                <input type="date" value="" />
                            </div>
                        </div>
                        <Button class="btn-add-children" variant="secondary"><img src="images/icons/plus.png"></Button>
                    </div>
                    
                </div>
            </div>
        </div>

        <div v-else-if="activeTab === 'education'">
            <h3>Educational Background</h3>
            <div class="education-form-grid">
                <div class="input-wrapper span-2">
                    <label>Highest Educational Attainment</label>
                    <select>
                        <option value="elementary">Elementary</option>
                        <option value="secondary">Secondary</option>
                        <option value="vocational">Vocational/Trade Course</option>
                        <option value="college">College</option>
                        <option value="graduate">Graduate Studies</option>
                    </select>
                </div>
                <div class="input-wrapper span-2">
                    <label>Name of School</label>
                    <input type="text" value="University of the Philippines – Diliman" />
                </div>
                <div class="attendance span-2">
                    <label>Period of  Attendance (From - To)</label>
                    <div class="date-range">
                        <input type="date" placeholder="From" />
                        <input type="date" placeholder="To" />
                    </div>
                </div>
                <div class="input-wrapper span-2">
                    <label>Scholarships/Academic Honors Received</label>
                    <input type="text" value="Academic Excellence Award" />
                </div>
                <div>
                    <label>Year Graduated</label>
                    <input type="text" value="1996" />
                </div>
                <div>
                    <label>Highest Level/Units Earned</label>
                    <input type="text" value="3rd Year Level" />
                </div>
                <div class="input-wrapper span-2">
                    <label>Basic Educational Degree/Course</label>
                    <input type="text" value="BS Computer Science" />
                </div>
            </div>
        </div>

        <div v-else-if="activeTab === 'eligibility'">
            <h3>Civil Service Eligibility</h3>
            <div class="eligibility-form-grid">
                <div class="input-wrapper span-2">
                    <label>Career Service/Eligibility</label>
                    <input type="text" value="PRC License – Teacher (LET Passer)" />
                </div>
                <div>
                    <label>Rating</label>
                    <input type="text" value="89.00%" />
                </div>
                <div>
                    <label>Date of Examination</label>
                    <input type="date" value=""/>
                </div>
                <div class="input-wrapper span-2">
                    <label>Place of Examination</label>
                    <input type="text" value="Pampanga (CSC Regional Office III, San Fernando)" />
                </div>
                <div>
                    <label>License No.</label>
                    <input type="text" value="99-123456" />
                </div>
                <div>
                    <label>Date of Validity</label>
                    <input type="date" value=""/>
                </div>
            </div>
        </div>

        <div v-else-if="activeTab === 'work'">
            <h3>Work Experience</h3>
            <div class="work-form-grid">
                <div class="input-wrapper span-2">
                    <label>Position Title (Write in full -  no abbreviation)</label>
                    <input type="text" value="Secondary School Teacher I" />
                </div>
                <div class="input-wrapper span-2">
                    <label>Department/Agency/Office/Company</label>
                    <input type="text" value="Department of Education – Apalit District Office" />
                </div>
                <div>
                    <label>Monthly Salary</label>
                    <select>
                        <option value="male">15,000 - 25,000</option>
                        <option value="female">25,000 - 35,0000</option>
                    </select>
                </div>
                <div>
                    <label>Status of Appointment</label>
                    <input type="text" value="Permanent" />
                </div>
                <div class="inclusive-date span-2">
                    <label>Inclusive Date (From - To)</label>
                    <div class="date-range">
                        <input type="date" placeholder="From" />
                        <input type="date" placeholder="To" />
                    </div>
                </div>
                <div class="input-wrapper span-2">
                    <label>Salary/Job/Pay Grade & Step (if government) </label>
                    <input type="text" value="SG 10 – Step 1 - ₱26,052.00" />
                </div>
            </div>
        </div>

        <div v-else-if="activeTab === 'voluntary'">
            <h3>Voluntary Involvement</h3>
            <div class="voluntary-form-grid">
                <div class="input-wrapper span-2">
                    <label>Organization Name</label>
                    <input type="text" value="Department of Health, Jollibee Foods Corporation" />
                </div>
                <div class="input-wrapper span-2">
                    <label>Organization Address</label>
                    <input type="text" value="Capitol Compound, Brgy. Sto. Niño, City of San Fernando, Pampanga" />
                </div>
                <div class="inclusive-date span-2">
                    <label>Inclusive Date (From - To)</label>
                    <div class="date-range">
                        <input type="date" placeholder="From" />
                        <input type="date" placeholder="To" />
                    </div>
                </div>
                <div>
                    <label>Position</label>
                    <input type="text" value="Administrative Aide III" />
                </div>
                <div>
                    <label>Number of Hours Rendered</label>
                    <input type="text" value="10" />
                </div>
                <div class="input-wrapper span-4">
                    <label>Nature of Work</label>
                    <input type="text" value="Handles clerical tasks, prepares reports, assists in records management." />
                </div>
            </div>
        </div>

        <div v-else-if="activeTab === 'training'">
            <h3>Training Attended</h3>
            <div class="training-form-grid">
                <div class="input-wrapper span-2">
                    <label>Title of Learning and Development Program (Write in full)</label>
                    <input type="text" value="Effective Communication and Leadership Training" />
                </div>
                <div class="inclusive-date span-2">
                    <label>Inclusive Date (From - To)</label>
                    <div class="date-range">
                        <input type="date" placeholder="From" />
                        <input type="date" placeholder="To" />
                    </div>
                </div>
                <div class="input-wrapper span-2">
                    <label>Type of L&D (Managerial, Supervisory, Technical, etc)</label>
                    <input type="text" value="Technical" />
                </div>
                <div class="input-wrapper span-2">
                    <label>Conducted Sponsored By</label>
                    <input type="text" value="Department of Labor and Employment (DOLE)" />
                </div>
            </div>
        </div>

        <div v-else-if="activeTab === 'other'">
            <h3>Other Relevant Information</h3>
            <div class="other-form-grid">
                <div class="input-wrapper span-2">
                    <label>Special Skill/Hobbies</label>
                    <input type="text" value="Jogging and Singing" />
                </div>
                <div class="input-wrapper span-2">
                    <label>None-Academic Distinctions/Recognition</label>
                    <input type="text" value="Employee of the Month" />
                </div>
                <div class="input-wrapper span-2">
                    <label>Membership in Association/Organization</label>
                    <input type="text" value="Philippine Institute of Civil Engineers (PICE)" />
                </div>
                <div class="input-wrapper span-2">
                    <label>Conducted Sponsored By</label>
                    <input type="text" value="Department of Labor and Employment (DOLE)" />
                </div>
                <div class="references span-2">
                    <label>References (Not related by blood or affinity)</label>
                    <div class="ref-inputs">
                        <div>
                            <label>Fullname</label>
                            <input type="text" value="John Doe" />
                        </div>
                        <div>
                            <label>Telephone No.</label>
                            <input type="text" value="007788876677" />
                        </div>
                        <div class="address-wrapper">
                            <label>Address</label>
                            <input type="text" value="Sampaloc Apalit Pampanga" />
                        </div>
                    </div>
                    <Button class="btn-add-reference" variant="secondary"><img src="images/icons/plus.png"></Button>
                </div>
            </div>
        </div>
    </form>
</template>
<script setup>
    import Button from "@/components/Common/Button.vue";

    defineProps({
        activeTab: {
            type: String,
            required: true
        }
    });
</script>