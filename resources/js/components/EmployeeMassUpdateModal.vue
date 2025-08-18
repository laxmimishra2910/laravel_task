<template>
  <div v-if="show" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-lg w-[400px]">
      <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">Mass Update Employees</h2>
      <form @submit.prevent="submitUpdate">
        <!-- Select Column -->
        <div class="mb-4">
          <label class="block mb-2 font-semibold">Select Column</label>
          <select v-model="column" class="w-full border p-2 rounded">
            <option value="position">Position</option>
            <option value="salary">Salary</option>
          </select>
        </div>

        <!-- Position Input -->
        <div class="mb-4" v-if="column === 'position'">
          <label class="block mb-2 font-semibold">Position</label>
          <input v-model="value" type="text" class="w-full border p-2 rounded" placeholder="Enter new position">
        </div>

        <!-- Salary Input -->
        <div class="mb-4" v-if="column === 'salary'">
          <label class="block mb-2 font-semibold">Salary</label>
          <input v-model="value" type="number" step="0.01" class="w-full border p-2 rounded" placeholder="Enter new salary">
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end">
          <button type="button" @click="closeModal" class="px-4 py-2 bg-gray-500 text-white rounded mr-2">Cancel</button>
          <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { ref } from "vue";

const props = defineProps({
  show: Boolean,
  selectedIds: {
    type: Array,
    default: () => []
  }
});
const emits = defineEmits(["close", "updated"]);

const column = ref("");
const value = ref("");

function closeModal() {
  emits("close");
}

async function submitUpdate() {
  if (!column.value || !value.value) {
    alert("Please select a column and provide a value.");
    return;
  }

  try {
    const response = await axios.post("/employees/mass-update", {
      ids: props.selectedIds,
      column: column.value,  // send which column
      value: value.value     // send the new value
    });

    if (response.data.success) {
     
      emits("updated"); // reload DataTable
      emits("close");
    } else {
      alert("Failed: " + response.data.message);
    }
  } catch (error) {
    alert("Error: " + error.response?.data?.message || error.message);
  }
}
</script>
