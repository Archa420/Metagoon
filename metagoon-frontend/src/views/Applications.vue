<template>
  <div class="p-6 max-w-5xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Pieteikumi</h1>

    <div v-if="applications.length === 0" class="text-gray-500">Nav neviena pieteikuma.</div>

    <table v-else class="w-full border border-gray-200 rounded-lg">
      <thead class="bg-gray-100">
        <tr>
          <th class="p-2 border-b">Vietas nosaukums</th>
          <th class="p-2 border-b">Vārds</th>
          <th class="p-2 border-b">E-pasts</th>
          <th class="p-2 border-b">CV</th>
          <th class="p-2 border-b">Pavadzīme</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="app in applications" :key="app.id">
          <td class="p-2 border-b">{{ app.vacancy.title }}</td>
          <td class="p-2 border-b">{{ app.full_name }}</td>
          <td class="p-2 border-b">{{ app.email }}</td>
          <td class="p-2 border-b">
            <a v-if="app.cv_path" :href="`/storage/${app.cv_path}`" target="_blank" class="text-blue-600 underline">PDF</a>
            <span v-else>-</span>
          </td>
          <td class="p-2 border-b">{{ app.cover_letter || "-" }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import api from "../services/api.js";

const applications = ref([]);

onMounted(async () => {
  try {
    const res = await api.get("/applications", {
      headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
    });
    applications.value = res.data;
  } catch (err) {
    console.error("Failed to fetch applications:", err);
  }
});
</script>
