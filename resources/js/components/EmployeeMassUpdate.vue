<template>
  <div>
    <!-- Mass Update button (only visible if employees are selected) -->
    <button 
      v-if="selectedEmployees.length > 0"
      @click="openMassUpdate" 
      class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700"
    >
      Mass Update ({{ selectedEmployees.length }})
    </button>

    <!-- Modal -->
    <EmployeeMassUpdateModal 
      :show="showModal" 
      :selected-ids="selectedEmployees" 
      @close="showModal = false" 
      @updated="handleUpdated" 
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import EmployeeMassUpdateModal from "@/components/EmployeeMassUpdateModal.vue";

const showModal = ref(false);
const selectedEmployees = ref([]);

function openMassUpdate() {
  if (!selectedEmployees.value.length) return;
  showModal.value = true;
}

function handleUpdated() {
  reloadTable();
  selectedEmployees.value = []; // reset after update
  showModal.value = false;
}

function reloadTable() {
  const table = $("#employeeTable").DataTable();
  if (table) {
    table.ajax.reload(null, false);
  }
}

onMounted(() => {
  // Checkbox change tracking
  document.addEventListener("change", (e) => {
    if (e.target.classList.contains("employee-checkbox") || e.target.id === "selectAll") {
      const checked = Array.from(document.querySelectorAll(".employee-checkbox:checked"))
        .map(cb => cb.value);
      selectedEmployees.value = checked;
    }
  });

  // Reset selections on table redraw (e.g., after filter/pagination)
  $("#employeeTable").on("draw.dt", function () {
    selectedEmployees.value = [];
    $("#selectAll").prop("checked", false); // reset "select all"
  });
});
</script>
