<script setup>
import api from "@/services/api";
import { ref } from "vue";

const props = defineProps({
  id: Number,
  logo: String, // "vacancy_logos/filename.png"
  title: String,
  company: String,
  salary: String,
  description: String,
  user_id: Number, // vacancy creator
  currentUserId: Number, // logged-in user
  role: String, // logged-in user role
});

// Optional loading state for delete
const deleting = ref(false);

const deleteVacancy = async () => {
  if (!confirm("Vai tiešām vēlies dzēst šo vakanci?")) return;

  try {
    deleting.value = true;
    await api.delete(`/vacancies/${props.id}`);
    alert("Vakance veiksmīgi dzēsta!");
    // Refresh the page or emit global update
    window.location.reload();
  } catch (err) {
    console.error("Dzēšana neizdevās:", err);
    alert(err.response?.data?.message || "Neizdevās dzēst vakanci");
  } finally {
    deleting.value = false;
  }
};
</script>

<template>
  <div
    class="relative flex items-start gap-4 p-6 bg-white rounded-2xl shadow-md hover:shadow-lg transition"
  >
    <!-- Logo -->
    <img
      :src="logo ? `http://127.0.0.1:8000/storage/${logo}` : '/default-logo.png'"
      alt="company logo"
      class="w-16 h-16 rounded-xl object-cover border"
    />

    <!-- Vacancy Info -->
    <div class="flex flex-col flex-1">
      <h2 class="text-xl font-semibold text-gray-800">{{ title }}</h2>
      <p class="text-sm text-gray-500">{{ company }}</p>
      <p class="mt-2 text-sm text-gray-700">{{ description }}</p>
      <p class="mt-3 font-medium text-indigo-600">Likme: {{ salary }}</p>
    </div>

    <!-- Delete Button (visible only for owner) -->
    <button
      v-if="role === 'uzņēmējs' && currentUserId === user_id"
      @click="deleteVacancy"
      :disabled="deleting"
      class="absolute top-3 right-3 bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 disabled:opacity-60"
    >
      {{ deleting ? "Dzēš..." : "Dzēst" }}
    </button>
  </div>
</template>
