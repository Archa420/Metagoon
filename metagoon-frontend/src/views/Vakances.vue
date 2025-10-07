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
  logo: null, // File object
});
const logoPreview = ref(null);
const error = ref(null);

// Fetch all vacancies
const fetchJobs = async () => {
  try {
    const res = await api.get("/vacancies");
    jobs.value = res.data;
    jobs.value.forEach(j => console.log("Fetched image URL:", j.logo_url));
  } catch (err) {
    console.error("Failed to fetch jobs:", err);
  }
};

// Fetch authenticated user
const fetchUser = async () => {
  try {
    const res = await api.get("/user");
    user.value = res.data;
    console.log("Logged-in user:", user.value);
  } catch (err) {
    console.error("Failed to fetch user:", err);
    user.value = null;
  }
};

// Handle file selection and preview
const handleFileChange = (e) => {
  const file = e.target.files[0];
  if (!file) return;
  newVacancy.value.logo = file;

  const reader = new FileReader();
  reader.onload = (event) => {
    logoPreview.value = event.target.result;
  };
  reader.readAsDataURL(file);
};

// Create a new vacancy
const createVacancy = async () => {
  error.value = null;
  try {
    let logoPath = null;

    if (newVacancy.value.logo) {
      const formData = new FormData();
      formData.append("file", newVacancy.value.logo);

      const uploadRes = await api.post("/upload", formData, {
        headers: { "Content-Type": "multipart/form-data" },
      });

      logoPath = uploadRes.data.path; // "vacancy_logos/filename.png"
    }

    await api.post("/vacancies", {
      title: newVacancy.value.title,
      salary: newVacancy.value.salary,
      description: newVacancy.value.description,
      logo: logoPath,
    });

    // Reset form
    newVacancy.value = { title: "", salary: "", description: "", logo: null };
    logoPreview.value = null;
    showModal.value = false;
    fetchJobs();
  } catch (err) {
    console.error("Create vacancy error:", err);
    error.value =
      err.response?.data?.message ||
      JSON.stringify(err.response?.data?.errors) ||
      "Unknown error";
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

      <!-- Button visible only for employers -->
      <button
        v-if="user && user.role === 'uzņēmējs'"
        @click="showModal = true"
        class="bg-indigo-600 text-white px-4 py-2 rounded-lg shadow hover:bg-indigo-700 transition-colors"
      >
        Create Vacancy
      </button>
    </div>

    <!-- Vacancy list -->
    <div class="space-y-4">
  <JobCard
    v-for="job in jobs"
    :key="job.id"
    v-bind="job"
    :currentUserId="user?.id"
    :role="user?.role"
  />
</div>
  </div>

  <!-- Create Vacancy Modal (for employers only) -->
  <div
    v-if="showModal"
    class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center p-4 z-50"
  >
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6">
      <h2 class="text-2xl font-bold mb-4">Create Vacancy</h2>

      <form @submit.prevent="createVacancy" class="space-y-4">
        <input type="text" v-model="newVacancy.title" placeholder="Title" required class="w-full p-2 border rounded" />
        <input type="text" v-model="newVacancy.salary" placeholder="Salary" required class="w-full p-2 border rounded" />
        <textarea v-model="newVacancy.description" placeholder="Description" required class="w-full p-2 border rounded"></textarea>

        <div>
          <input type="file" accept="image/*" @change="handleFileChange" />
          <img v-if="logoPreview" :src="logoPreview" class="mt-2 w-32 h-32 object-contain border rounded" />
        </div>

        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">
          Save Vacancy
        </button>

        <div v-if="error" class="text-red-500 text-sm mt-2">{{ error }}</div>
      </form>

      <button @click="showModal = false" class="mt-4 px-4 py-2 bg-gray-300 rounded">Close</button>
    </div>
  </div>
</template>
