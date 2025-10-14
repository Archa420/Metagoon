<template>
  <div class="p-6 max-w-5xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Saņemtie pieteikumi</h1>

    <div v-if="applications.length === 0" class="text-gray-500">
      Nav neviena pieteikuma Jūsu vakancēm.
    </div>

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
          <td class="p-2 border-b font-medium">{{ app.vacancy.title }}</td>
          <td class="p-2 border-b">{{ app.user?.name || '–' }}</td>
          <td class="p-2 border-b">{{ app.user?.email || '–' }}</td>
          <td class="p-2 border-b">
            <button
              v-if="app.cv_path"
              @click="openCv(app.id)"
              class="text-blue-600 underline hover:text-blue-800"
            >
              Skatīt CV
            </button>
            <span v-else>-</span>
          </td>
          <td class="p-2 border-b whitespace-pre-wrap">{{ app.cover_letter || "-" }}</td>
        </tr>
      </tbody>
    </table>

    <!-- PDF Modal -->
    <div
      v-if="showCvModal"
      class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50"
    >
      <div class="bg-white rounded-2xl p-4 w-full max-w-5xl relative">
        <button
          @click="showCvModal = false"
          class="absolute top-2 right-3 text-gray-600 hover:text-gray-900 text-2xl"
        >
          &times;
        </button>
        <iframe
          v-if="pdfUrl"
          :src="pdfUrl"
          class="w-full h-[80vh] border rounded-lg"
        ></iframe>
        <div v-else class="text-gray-500 text-center py-10">Loading CV...</div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import api from "../services/api.js";

const applications = ref([]);
const showCvModal = ref(false);
const pdfUrl = ref(null);

const openCv = async (id) => {
  const app = applications.value.find(a => a.id === id);
  if (!app || !app.cv_path) {
    alert("CV not found");
    return;
  }
  pdfUrl.value = `http://127.0.0.1:8000/storage/${app.cv_path}`;
  showCvModal.value = true;
};


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
