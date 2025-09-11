import { reactive } from "vue";

export function useValidation() {
    const errors = reactive({});

    // Rules per field
    const fieldRules = {
        // Personal Information
        first_name: [
            (v) => !!v || "First name is required.", 
            (v) => (v && v.length >= 2) || "First name must be at least 2 characters."
        ],
        last_name: [(v) => !!v || "Last name is required."],
        middle_name: [],
        name_extension: [],
        birth_date: [(v) => !!v || "Birthdate is required."],
        place_of_birth: [(v) => !!v || "Place of birth is required."],
        sex: [(v) => !!v || "Sex is required."],
        civil_status: [(v) => !!v || "Civil status is required."],
        citizenship: [(v) => !!v || "Citizenship is required."],
        height: [
            (v) => !!v || "Height is required.", 
            (v) => !isNaN(v) || "Height must be numeric."
        ],
        weight: [
            (v) => !!v || "Weight is required.", 
            (v) => !isNaN(v) || "Weight must be numeric."
        ],
        blood_type: [],
        gsis_id_no: [],
        pagibig_id_no: [(v) => !!v || "Pag-IBIG ID is required."],
        philhealth_no: [
            (v) => !!v || "PhilHealth number is required.", 
            (v) => /^\d{12}$/.test(v) || "PhilHealth must be 12 digits."
        ],
        sss_no: [
            (v) => !!v || "SSS number is required.", 
            (v) => /^\d{10}$/.test(v) || "SSS must be 10 digits."
        ],
        tin_no: [
            (v) => !!v || "TIN is required.", 
            (v) => /^\d{9}$/.test(v) || "TIN must be 9 digits."
        ],
        agency_employee_no: [],
        residential_address: [(v) => !!v || "Residential address is required."],
        residential_zip: [],
        permanent_address: [],
        permanent_zip: [],
        telephone_no: [],
        mobile_no: [
            (v) => !!v || "Mobile number is required.", 
            (v) => /^[0-9]{10,11}$/.test(v) || "Mobile number must be 10–11 digits."
        ],
        email: [
            (v) => !!v || "Email is required.", 
            (v) => /\S+@\S+\.\S+/.test(v) || "Email must be valid."
        ],
        ctc_number: [],
        ctc_place_of_issuance: [],
        ctc_date_of_issuance: [],

        // Family Background
        "spouse.name": [(v) => !!v || "Spouse's name is required."],
        "spouse.birth_date": [],
        "spouse.occupation": [],
        "spouse.relationship": [],
        "spouse.employer": [],
        "spouse.business_address": [],
        "spouse.telephone_no": [],
        "father.name": [(v) => !!v || "Father's name is required."],
        "mother.name": [(v) => !!v || "Mother's name is required."],
        "children[0].full_name": [],
        "children[0].birth_date": [],

        // Education
        "educations[0].school_name": [(v) => !!v || "School name is required."],
        "educations[0].highest_educational_attainment": [(v) => !!v || "Highest educational attainment is required."],
        "educations[0].degree_course": [],
        "educations[0].highest_level_units": [],
        "educations[0].year_graduated": [],
        "educations[0].highest_units_earned": [],
        "educations[0].attendance_from": [],
        "educations[0].attendance_to": [],
        "educations[0].scholarships": [],

        // Eligibilities
        "eligibilities[0].career_service": [(v) => !!v || "Career service eligibility is required."],
        "eligibilities[0].rating": [],
        "eligibilities[0].date_of_examination": [],
        "eligibilities[0].place_of_examination": [],
        "eligibilities[0].license_no": [],
        "eligibilities[0].date_of_validity": [],

        // Work Experience
        "work_experiences[0].inclusive_from": [],
        "work_experiences[0].inclusive_to": [],
        "work_experiences[0].position_title": [(v) => !!v || "Position title is required."],
        "work_experiences[0].department_agency": [],
        "work_experiences[0].monthly_salary": [],
        "work_experiences[0].agency": [],
        "work_experiences[0].salary_job_grade": [],
        "work_experiences[0].status_of_appointment": [],

        // Voluntary Works
        "voluntary_works[0].organization_name": [(v) => !!v || "Organization name is required."],
        "voluntary_works[0].organization_address": [],
        "voluntary_works[0].from": [],
        "voluntary_works[0].to": [],
        "voluntary_works[0].hours": [],
        "voluntary_works[0].position": [],
        "voluntary_works[0].nature_of_work": [],

        // Trainings
        "trainings[0].title": [(v) => !!v || "Title is required."],
        "trainings[0].from": [],
        "trainings[0].to": [],
        "trainings[0].type": [],
        "trainings[0].conducted_by": [],

        // Other Info
        "other_infos[0].special_skills": [],
        "other_infos[0].distinctions": [],
        "other_infos[0].membership": [(v) => !!v || "Membership is required."],
        "other_infos[0].sponsored_by": [],

        // References
        "references[0].fullname": [],
        "references[0].address": [],
        "references[0].telephone_no": [],
    };

    // Rules grouped by tab
    const rulesPerTab = {
        personal: [
            "first_name", 
            "last_name", 
            "birth_date", 
            "place_of_birth", 
            "sex", 
            "civil_status", 
            "citizenship", 
            "height", 
            "weight", 
            "pagibig_id_no", 
            "philhealth_no", 
            "sss_no", 
            "tin_no", 
            "residential_address", 
            "mobile_no", 
            "email"
        ],
        family: [
            "spouse.name", 
            "father.name", 
            "mother.name"
        ],
        education: [
            "educations[0].school_name", 
            "educations[0].highest_educational_attainment"
        ],
        eligibility: [
            "eligibilities[0].career_service"
        ],
        work: [
            "work_experiences[0].position_title"
        ],
        voluntary: [
            "voluntary_works[0].organization_name"
        ],
        training: [
            "trainings[0].title"
        ],
        other: [
            "other_infos[0].membership"
        ],
    };

    // Validate a single field
    function validateField(name, value) {
        const rules = fieldRules[name];
        if (!rules || rules.length === 0) return true;

        for (const rule of rules) {
            const result = rule(value);
            if (result !== true) {
                errors[name] = result;
                return false;
            }
        }

        errors[name] = "";
        return true;
    }

    // Validate all fields in a tab
    function validateTab(tabKey, formData) {
        const requiredFields = rulesPerTab[tabKey] || [];
        let isValid = true;

        requiredFields.forEach((field) => {
            const value = field.split(".").reduce((acc, key) => {
                // Check theres is a [number] (e.g. educations[0])
                if (/\[\d+\]/.test(key)) {
                    const [arrKey, index] = key.split(/\[|\]/).filter(Boolean);
                    return acc && acc[arrKey] ? acc[arrKey][+index] : null;
                }
                return acc ? acc[key] : null;
            }, formData);

            const ok = validateField(field, value);
            if (!ok) isValid = false;
        });

        return isValid;
    }

    return {
        errors,
        validateField,
        validateTab,
        rulesPerTab
    };
}
