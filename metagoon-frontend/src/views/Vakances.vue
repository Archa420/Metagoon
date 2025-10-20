<template>
  <div class="min-h-screen w-full bg-[#0b0c10] text-gray-100">
    <div class="mx-auto max-w-7xl px-6 py-16 space-y-16">
      <!-- HERO -->
      <section class="text-center space-y-4">
        <h1 class="text-5xl font-extrabold bg-gradient-to-r from-indigo-400 via-fuchsia-400 to-cyan-400 bg-clip-text text-transparent">
          Atrodi savu nākamo darbu
        </h1>
        <p class="text-gray-400 text-lg max-w-2xl mx-auto">
          Pārlūko jaunākās vakances, izmanto filtrus un atrodi darba iespējas, kas atbilst tev.
        </p>
      </section>

      <!-- FILTERS -->
      <section class="rounded-3xl border border-indigo-900/30 bg-gray-900/60 shadow-xl p-6 backdrop-blur-lg space-y-6">
        <h2 class="text-xl font-semibold text-gray-100">Filtrēšana</h2>
        <div class="flex flex-col md:flex-row gap-4">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="🔍 Meklē pēc amata nosaukuma..."
            class="flex-1 rounded-xl border border-gray-700 bg-gray-800/60 px-4 py-2 text-sm text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
          />
          <select
            v-model="selectedCategory"
            class="flex-1 rounded-xl border border-gray-700 bg-gray-800/60 px-4 py-2 text-sm text-gray-100 focus:ring-2 focus:ring-indigo-500"
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
            class="flex-1 rounded-xl border border-gray-700 bg-gray-800/60 px-4 py-2 text-sm text-gray-100 focus:ring-2 focus:ring-indigo-500"
          >
            <option value="">Visi novadi / pilsētas</option>
            <option value="Rīga">Rīga</option>
            <option value="Liepāja">Liepāja</option>
            <option value="Jelgava">Jelgava</option>
            <option value="Daugavpils">Daugavpils</option>
            <option value="Valmiera">Valmiera</option>
            <option value="Ogre">Ogre</option>
            <option value="Ventspils">Ventspils</option>
            <option value="Rēzekne">Rēzekne</option>
          </select>
          <button
            @click="selectedCategory='';selectedCounty='';searchQuery=''"
            class="rounded-xl border border-gray-700 bg-gray-800/60 px-4 py-2 text-sm text-gray-300 hover:bg-gray-800/80 transition"
          >
            Notīrīt
          </button>
        </div>
      </section>

      <!-- CREATE BUTTON -->
      <div class="flex justify-end">
        <button
          v-if="user && user.role === 'uzņēmējs'"
          @click="showModal = true"
          class="rounded-xl bg-gradient-to-r from-indigo-600 via-fuchsia-500 to-cyan-500 px-5 py-2.5 text-sm font-semibold text-white shadow-lg hover:opacity-90 transition"
        >
          + Izveidot vakanci
        </button>
      </div>

      <!-- VACANCY LIST -->
      <section>
        <div v-if="filteredJobs.length" class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
          <JobCard
            v-for="job in filteredJobs"
            :key="job.id"
            v-bind="job"
            :currentUserId="user?.id"
            :role="user?.role"
          />
        </div>
        <div v-else class="text-gray-400 text-center py-20">
          Nav atrasta neviena vakance pēc izvēlētajiem filtriem.
        </div>
      </section>
    </div>

    <!-- MODAL -->
    <div
      v-if="showModal"
      class="fixed inset-0 bg-black/70 flex items-center justify-center p-4 z-50"
    >
      <div class="bg-gray-900 rounded-3xl border border-indigo-900/40 p-8 shadow-2xl w-full max-w-lg space-y-4">
        <h2 class="text-2xl font-extrabold text-gray-100">
          Izveidot jaunu vakanci
        </h2>

        <form @submit.prevent="createVacancy" class="space-y-4">
          <input v-model="newVacancy.title" type="text" placeholder="Nosaukums" required class="input-style" />
          <input v-model="newVacancy.salary" type="text" placeholder="Alga" required class="input-style" />
          <select v-model="newVacancy.category" required class="input-style">
            <option value="" disabled>Izvēlies kategoriju</option>
            <option value="IT & Programmēšana">IT & Programmēšana</option>
            <option value="Pārdošana">Pārdošana</option>
            <option value="Mārketings">Mārketings</option>
            <option value="Finanses">Finanses</option>
            <option value="Loģistika">Loģistika</option>
            <option value="Ražošana">Ražošana</option>
            <option value="Klientu atbalsts">Klientu atbalsts</option>
            <option value="Veselība">Veselība</option>
          </select>
          <select v-model="newVacancy.county" required class="input-style">
            <option value="" disabled>Izvēlies novadu / pilsētu</option>
            <option value="">Visi novadi / pilsētas</option>
            <option value="Rīga">Rīga</option>
            <option value="Liepāja">Liepāja</option>
            <option value="Jelgava">Jelgava</option>
            <option value="Daugavpils">Daugavpils</option>
            <option value="Valmiera">Valmiera</option>
            <option value="Ogre">Ogre</option>
            <option value="Ventspils">Ventspils</option>
            <option value="Rēzekne">Rēzekne</option>
          </select>
          <textarea v-model="newVacancy.description" placeholder="Apraksts" required class="input-style"></textarea>

          <div class="space-y-2">
            <input type="file" accept="image/*" @change="handleFileChange" class="text-sm text-gray-300" />
            <img v-if="logoPreview" :src="logoPreview" class="mt-2 w-32 h-32 object-contain border border-gray-700 rounded-lg" />
          </div>

          <button type="submit" class="w-full rounded-xl bg-gradient-to-r from-indigo-600 via-fuchsia-500 to-cyan-500 py-2.5 font-semibold text-white shadow-lg hover:opacity-90 transition">
            Saglabāt vakanci
          </button>

          <div v-if="error" class="text-red-500 text-sm mt-2">{{ error }}</div>
        </form>

        <button @click="showModal = false" class="w-full mt-2 rounded-xl bg-gray-800/50 py-2 text-gray-200 hover:bg-gray-700 transition">
          Aizvērt
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useRoute, useRouter } from "vue-router";
import { ref, computed, onMounted, watch } from "vue";
import api from "@/services/api";
import JobCard from "@/components/JobCard.vue";

const jobs = ref([]);
const user = ref(null);
const showModal = ref(false);
const logoPreview = ref(null);
const error = ref(null);
const route = useRoute();
const router = useRouter();

const newVacancy = ref({
  title: "",
  salary: "",
  description: "",
  category: "",
  county: "",
  logo: null,
});

const selectedCategory = ref("");
const selectedCounty = ref("");
const searchQuery = ref("");

if (route.query.category && typeof route.query.category === "string") {
  selectedCategory.value = route.query.category;
}

watch(() => route.query.category, (newCategory) => {
  selectedCategory.value = typeof newCategory === "string" ? newCategory : "";
});

const filteredJobs = computed(() => {
  return jobs.value.filter((job) => {
    const matchCategory = selectedCategory.value ? job.category === selectedCategory.value : true;
    const matchCounty = selectedCounty.value ? job.county === selectedCounty.value : true;
    const matchSearch = searchQuery.value ? job.title.toLowerCase().includes(searchQuery.value.toLowerCase()) : true;
    return matchCategory && matchCounty && matchSearch;
  });
});

const fetchJobs = async () => {
  try {
    const res = await api.get("/vacancies");
    jobs.value = res.data;
  } catch (err) {
    console.error("Failed to fetch jobs:", err);
  }
};

const fetchUser = async () => {
  try {
    const res = await api.get("/user");
    user.value = res.data;
  } catch {
    user.value = null;
  }
};

const handleFileChange = (e) => {
  const file = e.target.files[0];
  if (!file) return;
  newVacancy.value.logo = file;

  const reader = new FileReader();
  reader.onload = (event) => (logoPreview.value = event.target.result);
  reader.readAsDataURL(file);
};

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
    await api.post("/vacancies", { ...newVacancy.value, logo: logoPath });
    newVacancy.value = { title: "", salary: "", description: "", category: "", county: "", logo: null };
    logoPreview.value = null;
    showModal.value = false;
    fetchJobs();
  } catch (err) {
    error.value = err.response?.data?.message || "Neizdevās izveidot vakanci";
  }
};

onMounted(() => {
  fetchUser();
  fetchJobs();
});
</script>

<style scoped>
.input-style {
  width: 100%;
  padding: 0.5rem 0.75rem;
  border-radius: 0.75rem;
  border: 1px solid rgb(55 65 81);
  background-color: rgba(31, 41, 55, 0.6);
  color: #f3f4f6;
  font-size: 0.875rem;
}
.input-style:focus {
  outline: none;
  border-color: rgb(99, 102, 241);
  box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.4);
}
</style>
