import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

import './chart';
import './employee-Datatable';

import { createApp } from "vue";
import EmployeeMassUpdate from "./components/EmployeeMassUpdate.vue";

const app = createApp({});
app.component("employee-mass-update", EmployeeMassUpdate);
app.mount("#app");
