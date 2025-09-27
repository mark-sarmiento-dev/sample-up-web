<template>
    <section id="deptdiv">
        <div class="deptdiv-table-container">
            <!-- Left Table -->
            <div class="deptdiv-table-wrapper">
                <h4>DEPARTMENT</h4>
                <div class="deptdiv-header">
                    <Input class="search-inp" name="search-left" placeholder="Search ..." size="md" />
                    <Button variant="primary" @click="openAddDeptModal"><img class="icon-add" src="images/icons/plus.png" /> Add Department</Button>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Office A</td>
                            <td>
                                <!-- <Tooltip text="View Details" placement="top">
                    <Button class="btn-action" variant="secondary" size="xs">
                      <img class="icon" src="images/icons/view.png"/>
                    </Button>
                  </Tooltip> -->
                                <Button class="btn-action" variant="secondary" size="xs">
                                    <img class="icon" src="images/icons/edit.png" />
                                </Button>
                                <Button class="btn-action" variant="secondary" size="xs">
                                    <img class="icon" src="images/icons/delete.png" />
                                </Button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Right Table -->
            <div class="deptdiv-table-wrapper">
                <h4>DIVISION</h4>
                <div class="deptdiv-header">
                    <Input class="search-inp" name="search-right" placeholder="Search ..." size="md" />
                    <Button variant="primary" @click="openAddDivModal"><img class="icon-add" src="images/icons/plus.png" /> Add Division</Button>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Plantilla Management</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Division 1</td>
                            <td>
                                <Button class="btn-action" variant="secondary" size="sm">
                                    Download Template
                                </Button>
                                <Button class="btn-action" variant="secondary" size="sm">
                                    Upload Template
                                </Button>
                                <Button class="btn-action" variant="secondary" size="sm" @click="openAddPlantillaModal">
                                    Add Plantilla
                                </Button>
                            </td>
                            <td>
                                <!-- <Tooltip text="View Details" placement="top">
                    <Button class="btn-action" variant="secondary" size="xs">
                      <img class="icon" src="images/icons/view.png"/>
                    </Button>
                  </Tooltip> -->
                                <Button class="btn-action" variant="secondary" size="xs">
                                    <img class="icon" src="images/icons/edit.png" />
                                </Button>
                                <Button class="btn-action" variant="secondary" size="xs">
                                    <img class="icon" src="images/icons/delete.png" />
                                </Button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <AddDeptModal v-model="showAddDeptModal" />
        <AddDivisionModal v-model="showAddDivModal" />
        <AddPlantillaModal v-model="showAddPlantillaModal" />
    </section>
</template>

<script setup>
    import { ref } from "vue";
    import Button from "@/Components/Common/Button.vue";
    import Input from "@/Components/Common/Input.vue";
    import Tooltip from "@/Components/Common/Tooltip.vue";
    import AddDeptModal from "../Modals/AddDeptModal.vue";
    import AddDivisionModal from "../Modals/AddDivisionModal.vue";
    import AddPlantillaModal from "../Modals/AddPlantillaModal.vue";

    const showAddDeptModal = ref(false);
    const showAddDivModal = ref(false);
    const showAddPlantillaModal = ref(false);

    const openAddDeptModal = () => {
        showAddDeptModal.value = true;
    };

    const openAddDivModal = () => {
        showAddDivModal.value = true;
    };

    const openAddPlantillaModal = () => {
        showAddPlantillaModal.value = true;
    };
</script>
