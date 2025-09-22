<script setup>
import { ref, onMounted } from "vue";
import api from "@/services/api";
import JobCard from "@/components/JobCard.vue";

const jobs = ref([]);
const user = ref(null);
const showModal = ref(false);
const newVacancy = ref({
  title: "",
  salary: "",
  description: "",
  logo: "", // filename only
});
const error = ref(null);

// Example predefined logos (must exist in public/images)
const availableLogos = ["logo1.png", "logo2.png", "logo3.png"];

const fetchJobs = async () => {
  try {
    const res = await api.get("/vacancies");
    jobs.value = res.data;
  } catch (err) {
    console.error(err);
  }
};

const fetchUser = async () => {
  try {
    const res = await api.get("/user");
    user.value = res.data;
  } catch (err) {
    console.error(err);
  }
};

const createVacancy = async () => {
  error.value = null;
  try {
    await api.post("/vacancies", {
      title: newVacancy.value.title,
      salary: newVacancy.value.salary,
      description: newVacancy.value.description,
      logo: newVacancy.value.logo, // just filename
    });

    newVacancy.value = { title: "", salary: "", description: "", logo: "" };
    showModal.value = false;
    fetchJobs();
  } catch (err) {
    console.error(err);
    if (err.response) {
      error.value =
        err.response.data?.message ||
        JSON.stringify(err.response.data?.errors || err.response.data) ||
        `Server error: ${err.response.status}`;
    } else {
      error.value = err.message || "Unknown error";
    }
  }
};

onMounted(() => {
  fetchUser();
  fetchJobs();
});
</script>

<template>
  <div class="max-w-4xl mx-auto p-6 space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <h1 class="text-3xl font-bold text-gray-800">Vakances</h1>
      <button
        v-if="user"
        @click="showModal = true"
        class="bg-indigo-600 text-white px-4 py-2 rounded-lg shadow hover:bg-indigo-700 transition-colors"
      >
        Izveidot jaunu vakanci
      </button>
    </div>

    <!-- Vacancies list -->
    <div class="space-y-4">
      <JobCard v-for="(job, index) in jobs" :key="index" v-bind="job" />
    </div>
  </div>

  <!-- Create Vacancy Modal -->
  <div
    v-if="showModal"
    class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center p-4 z-50"
  >
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-gray-800">Izveidot vakanci</h2>
        <button @click="showModal = false" class="text-gray-500 hover:text-gray-800">✖</button>
      </div>

      <form @submit.prevent="createVacancy" class="space-y-4">
        <!-- Title -->
        <div>
          <label class="block text-gray-700">Vakances nosaukums</label>
          <input
            type="text"
            v-model="newVacancy.title"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
            required
          />
        </div>

        <!-- Salary -->
        <div>
          <label class="block text-gray-700">Alga</label>
          <input
            type="text"
            v-model="newVacancy.salary"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
            required
          />
        </div>

        <!-- Description -->
        <div>
          <label class="block text-gray-700">Apraksts</label>
          <textarea
            v-model="newVacancy.description"
            rows="4"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
            required
          ></textarea>
        </div>

        <!-- Logo selection -->
        <div>
          <label class="block text-gray-700">Logo</label>
          <select v-model="newVacancy.logo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            <option disabled value="">Izvēlies logo</option>
            <option v-for="logo in availableLogos" :key="logo" :value="logo">
              {{ logo }}
            </option>
          </select>
          <img
            v-if="newVacancy.logo"
            :src="`/images/${newVacancy.logo}`"
            class="mt-2 w-32 h-32 object-contain border rounded"
            alt="Logo Preview"
          />
        </div>

        <!-- Submit -->
        <button
          type="submit"
          class="w-full bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700"
        >
          Saglabāt
        </button>

        <!-- Error message -->
        <div v-if="error" class="text-red-500 text-sm mt-2">{{ error }}</div>
      </form>
    </div>
  </div>
</template>
