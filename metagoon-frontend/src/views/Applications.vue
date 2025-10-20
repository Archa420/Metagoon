<template>
  <div class="min-h-screen bg-[#0b0c10] text-gray-100 py-16 px-6">
    <div class="max-w-6xl mx-auto rounded-3xl border border-indigo-900/30 bg-gradient-to-br from-gray-950 via-gray-900 to-gray-950 p-8 shadow-2xl relative overflow-hidden">
      <!-- Glow overlay -->
      <div
        class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_left,_var(--tw-gradient-stops))] from-indigo-700/20 via-fuchsia-700/10 to-transparent pointer-events-none"
      ></div>

      <!-- Header -->
      <div class="relative z-10 mb-8 flex items-center justify-between">
        <h1 class="text-4xl font-extrabold bg-gradient-to-r from-indigo-400 via-fuchsia-400 to-cyan-400 bg-clip-text text-transparent">
          Saņemtie pieteikumi
        </h1>
      </div>

      <!-- No Applications -->
      <div
        v-if="applications.length === 0"
        class="text-gray-400 text-center py-16 bg-gray-900/40 border border-gray-800 rounded-2xl"
      >
        Nav neviena pieteikuma Jūsu vakancēm.
      </div>

      <!-- Applications Table -->
      <div v-else class="relative z-10 overflow-x-auto rounded-2xl border border-gray-800 shadow-lg">
        <table class="w-full text-sm text-gray-300">
          <thead class="bg-gray-900/70 border-b border-gray-800">
            <tr>
              <th class="px-4 py-3 text-left font-semibold text-indigo-300">Vietas nosaukums</th>
              <th class="px-4 py-3 text-left font-semibold text-indigo-300">Vārds</th>
              <th class="px-4 py-3 text-left font-semibold text-indigo-300">E-pasts</th>
              <th class="px-4 py-3 text-left font-semibold text-indigo-300">CV</th>
              <th class="px-4 py-3 text-left font-semibold text-indigo-300">Pavadzīme</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="app in applications"
              :key="app.id"
              class="hover:bg-gray-800/50 transition"
            >
              <td class="px-4 py-3 border-b border-gray-800 font-medium text-gray-100">
                {{ app.vacancy?.title || "–" }}
              </td>
              <td class="px-4 py-3 border-b border-gray-800">
                {{ app.user?.firstname }} {{ app.user?.lastname }}
              </td>
              <td class="px-4 py-3 border-b border-gray-800">
                {{ app.user?.email || "–" }}
              </td>
              <td class="px-4 py-3 border-b border-gray-800">
                <button
                  v-if="app.cv_path"
                  @click="openCv(app.id)"
                  class="text-indigo-400 hover:text-indigo-300 font-semibold underline transition"
                >
                  Skatīt CV
                </button>
                <span v-else class="text-gray-500">–</span>
              </td>
              <td class="px-4 py-3 border-b border-gray-800 text-gray-300 whitespace-pre-wrap">
                {{ app.cover_letter || "–" }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- PDF Modal -->
      <div
        v-if="showCvModal"
        class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 backdrop-blur-sm"
      >
        <div class="bg-gray-900 rounded-2xl border border-gray-700 w-full max-w-5xl relative shadow-2xl">
          <button
            @click="showCvModal = false"
            class="absolute top-3 right-4 text-gray-400 hover:text-white text-3xl font-bold"
          >
            &times;
          </button>
          <div class="p-4">
            <iframe
              v-if="pdfUrl"
              :src="pdfUrl"
              class="w-full h-[80vh] border border-gray-700 rounded-lg bg-gray-950"
            ></iframe>
            <div v-else class="text-gray-400 text-center py-10">Notiek CV ielāde...</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import api from "@/services/api.js";

const applications = ref([]);
const showCvModal = ref(false);
const pdfUrl = ref(null);

const openCv = (id) => {
  const app = applications.value.find((a) => a.id === id);
  if (!app || !app.cv_path) {
    alert("CV nav atrasts");
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

<style scoped>
table {
  border-collapse: collapse;
}
</style>
