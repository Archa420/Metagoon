<script setup>
import { ref, computed, onMounted } from "vue";
import api from "@/services/api";
import JobCard from "@/components/JobCard.vue";

const jobs = ref([]);
const user = ref(null);
const showModal = ref(false);
const logoPreview = ref(null);
const error = ref(null);

const newVacancy = ref({
  title: "",
  salary: "",
  description: "",
  category: "",
  county: "",
  logo: null,
});

// Filtri
const selectedCategory = ref("");
const selectedCounty = ref("");
const searchQuery = ref("");

// Filtrētas vakances
const filteredJobs = computed(() => {
  return jobs.value.filter((job) => {
    const matchCategory = selectedCategory.value
      ? job.category === selectedCategory.value
      : true;
    const matchCounty = selectedCounty.value
      ? job.county === selectedCounty.value
      : true;
    const matchSearch = searchQuery.value
      ? job.title.toLowerCase().includes(searchQuery.value.toLowerCase())
      : true;

    return matchCategory && matchCounty && matchSearch;
  });
});

// Ielādē visas vakances
const fetchJobs = async () => {
  try {
    const res = await api.get("/vacancies");
    jobs.value = res.data;
  } catch (err) {
    console.error("Failed to fetch jobs:", err);
  }
};

// Ielādē lietotāju
const fetchUser = async () => {
  try {
    const res = await api.get("/user");
    user.value = res.data;
  } catch (err) {
    console.error("Failed to fetch user:", err);
    user.value = null;
  }
};

// Attēla augšupielāde
const handleFileChange = (e) => {
  const file = e.target.files[0];
  if (!file) return;
  newVacancy.value.logo = file;

  const reader = new FileReader();
  reader.onload = (event) => (logoPreview.value = event.target.result);
  reader.readAsDataURL(file);
};

// Vakances izveide
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
      logoPath = uploadRes.data.path;
    }

    await api.post("/vacancies", {
      ...newVacancy.value,
      logo: logoPath,
    });

    newVacancy.value = {
      title: "",
      salary: "",
      description: "",
      category: "",
      county: "",
      logo: null,
    };
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
  <div class="max-w-5xl mx-auto p-6 space-y-8">
    <!-- Header -->
    <div class="flex items-center justify-between flex-wrap gap-4">
      <h1 class="text-3xl font-bold text-gray-900">Vakances</h1>

      <!-- Create button for employers -->
      <button
        v-if="user && user.role === 'uzņēmējs'"
        @click="showModal = true"
        class="bg-indigo-600 text-white px-5 py-2 rounded-xl shadow hover:bg-indigo-700 transition"
      >
        Izveidot vakanci
      </button>
    </div>

    <!-- FILTRĒŠANA -->
    <div
      class="flex flex-col md:flex-row items-center gap-4 bg-white border border-gray-200 shadow-sm p-4 rounded-2xl"
    >
      <input
        type="text"
        v-model="searchQuery"
        placeholder="🔍 Meklē pēc amata nosaukuma..."
        class="flex-1 p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
      />

      <select
        v-model="selectedCategory"
        class="flex-1 p-2 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-indigo-500"
      >
        <option value="">Visas kategorijas</option>
        <option value="IT & Programmēšana">IT & Programmēšana</option>
        <option value="Pārdošana">Pārdošana</option>
        <option value="Mārketings">Mārketings</option>
        <option value="Finanses">Finanses</option>
        <option value="Loģistika">Loģistika</option>
        <option value="Ražošana">Ražošana</option>
        <option value="Klientu atbalsts">Klientu atbalsts</option>
        <option value="Veselība">Veselība</option>
      </select>

      <select
        v-model="selectedCounty"
        class="flex-1 p-2 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-indigo-500"
      >
        <option value="">Visi novadi / pilsētas</option>
        <option value="Daugavpils">Daugavpils</option>
        <option value="Jēkabpils">Jēkabpils</option>
        <option value="Jelgava">Jelgava</option>
        <option value="Jūrmala">Jūrmala</option>
        <option value="Liepāja">Liepāja</option>
        <option value="Ogre">Ogre</option>
        <option value="Rēzekne">Rēzekne</option>
        <option value="Rīga">Rīga</option>
        <option value="Valmiera">Valmiera</option>
        <option value="Ventspils">Ventspils</option>
      </select>

      <button
        @click="selectedCategory = ''; selectedCounty = ''; searchQuery = ''"
        class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition"
      >
        Notīrīt
      </button>
    </div>

    <!-- Vacancy list -->
    <div v-if="filteredJobs.length" class="space-y-4">
      <JobCard
        v-for="job in filteredJobs"
        :key="job.id"
        v-bind="job"
        :currentUserId="user?.id"
        :role="user?.role"
      />
    </div>
    <div v-else class="text-gray-500 text-center py-10">
      Nav atrasta neviena vakance pēc izvēlētajiem filtriem.
    </div>
  </div>

  <!-- CREATE VACANCY MODAL -->
  <div
    v-if="showModal"
    class="fixed inset-0 bg-gray-700 bg-opacity-50 flex items-center justify-center p-4 z-50"
  >
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6">
      <h2 class="text-2xl font-bold mb-4 text-gray-900">
        Izveidot jaunu vakanci
      </h2>

      <form @submit.prevent="createVacancy" class="space-y-4">
        <input
          type="text"
          v-model="newVacancy.title"
          placeholder="Nosaukums"
          required
          class="w-full p-2 border rounded-lg"
        />

        <input
          type="text"
          v-model="newVacancy.salary"
          placeholder="Alga"
          required
          class="w-full p-2 border rounded-lg"
        />

        <select
          v-model="newVacancy.category"
          required
          class="w-full p-2 border rounded-lg bg-white"
        >
          <option value="" disabled selected>Izvēlies kategoriju</option>
          <option value="IT & Programmēšana">IT & Programmēšana</option>
          <option value="Pārdošana">Pārdošana</option>
          <option value="Mārketings">Mārketings</option>
          <option value="Finanses">Finanses</option>
          <option value="Loģistika">Loģistika</option>
          <option value="Ražošana">Ražošana</option>
          <option value="Klientu atbalsts">Klientu atbalsts</option>
          <option value="Veselība">Veselība</option>
        </select>

        <select
          v-model="newVacancy.county"
          required
          class="w-full p-2 border rounded-lg bg-white"
        >
          <option value="" disabled selected>Izvēlies novadu / pilsētu</option>
          <option value="Daugavpils">Daugavpils</option>
          <option value="Jēkabpils">Jēkabpils</option>
          <option value="Jelgava">Jelgava</option>
          <option value="Jūrmala">Jūrmala</option>
          <option value="Liepāja">Liepāja</option>
          <option value="Ogre">Ogre</option>
          <option value="Rēzekne">Rēzekne</option>
          <option value="Rīga">Rīga</option>
          <option value="Valmiera">Valmiera</option>
          <option value="Ventspils">Ventspils</option>
        </select>

        <textarea
          v-model="newVacancy.description"
          placeholder="Apraksts"
          required
          class="w-full p-2 border rounded-lg"
        ></textarea>

        <div>
          <input type="file" accept="image/*" @change="handleFileChange" />
          <img
            v-if="logoPreview"
            :src="logoPreview"
            class="mt-2 w-32 h-32 object-contain border rounded-lg"
          />
        </div>

        <button
          type="submit"
          class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition"
        >
          Saglabāt vakanci
        </button>

        <div v-if="error" class="text-red-500 text-sm mt-2">{{ error }}</div>
      </form>

      <button
        @click="showModal = false"
        class="mt-4 px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300"
      >
        Aizvērt
      </button>
    </div>
  </div>
</template>
