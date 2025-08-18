<template>
  <div>
    <button 
      @click="openMassUpdate" 
       class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700"
    >
      Mass Update
    </button>

   <EmployeeMassUpdateModal 
  :show="showModal" 
  :selected-ids="selectedEmployees" 
  @close="showModal = false" 
  @updated="reloadTable" 
/>

  </div>
</template>

<script setup>
import { ref } from "vue";
import EmployeeMassUpdateModal from "@/components/EmployeeMassUpdateModal.vue";

const showModal = ref(false);
const selectedEmployees = ref([]);

function openMassUpdate() {
  selectedEmployees.value = Array.from(document.querySelectorAll(".employee-checkbox:checked"))
    .map(cb => cb.value);

  if (!selectedEmployees.value.length) {
    alert("Please select at least one employee.");
    return;
  }

  showModal.value = true;
}

function reloadTable() {
  window.LaravelDataTables["employeeTable"].ajax.reload();
}
</script>
