<template>
  <div class="min-h-screen bg-[#0b0c10] text-gray-100 flex flex-col px-4">
    <main class="max-w-4xl mx-auto w-full py-12 space-y-10">
      <!-- Vacancy Info -->
      <section
        v-if="vacancy"
        class="rounded-2xl border border-gray-800 bg-[#111318]/90 shadow-xl backdrop-blur-sm p-8 space-y-6"
      >
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
          <div class="space-y-1">
            <h1 class="text-4xl font-bold text-white">{{ vacancy.title }}</h1>
            <p class="text-gray-300">{{ vacancy.company }}</p>
            <p class="text-gray-400 text-sm">Atrašanās vieta: {{ vacancy.county }}</p>
          </div>

          <div class="flex flex-wrap gap-3">
            <!-- Favorite -->
            <button
              @click="toggleFavorite"
              class="px-5 py-2 rounded-lg border border-gray-700 text-sm text-gray-300 hover:bg-gray-800 transition"
            >
              {{ isFavorited ? "Noņemt no favorītiem" : "Pievienot favorītiem" }}
            </button>

            <!-- Edit -->
            <button
              v-if="user && (vacancy.user_id === user.id || role === 'admin')"
              @click="showEditModal = true; prepareEditData();"
              class="px-5 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium transition"
            >
              Rediģēt
            </button>

            <!-- Delete -->
            <button
              v-if="user && (vacancy.user_id === user.id || role === 'admin')"
              @click="deleteVacancy"
              class="px-5 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white text-sm font-medium transition"
            >
              Dzēst
            </button>
          </div>
        </div>

        <!-- Logo -->
        <div v-if="vacancy.logo_url" class="mt-4">
          <img
            :src="vacancy.logo_url"
            alt="Company Logo"
            class="w-32 h-32 object-cover rounded-xl border border-gray-700"
          />
        </div>

        <!-- Description -->
        <div class="space-y-3 mt-4">
          <p class="leading-relaxed text-gray-300">{{ vacancy.description }}</p>
          <p class="font-semibold text-indigo-400 text-lg">
            Alga: {{ vacancy.salary }} €
            <span class="text-sm font-normal text-gray-400">({{ vacancy.salary_type }})</span>
          </p>
        </div>

        <!-- Apply Button -->
        <div v-if="isLoggedIn && role !== 'uzņēmējs'" class="pt-6">
          <button
            @click="showApplicationModal = true"
            class="px-6 py-2 rounded-xl bg-gradient-to-r from-indigo-600 via-fuchsia-500 to-cyan-500 text-white font-semibold shadow hover:opacity-90 transition"
          >
            Pieteikties
          </button>
        </div>
      </section>

      <!-- Comments -->
      <section
        v-if="vacancy"
        class="rounded-2xl border border-gray-800 bg-[#111318]/90 shadow-md backdrop-blur-sm p-8 space-y-6"
      >
        <h2 class="text-2xl font-semibold text-white border-b border-gray-800 pb-3">
          Komentāri
        </h2>

        <div v-if="isLoggedIn" class="space-y-3">
          <textarea
            v-model="newComment.comment_text"
            placeholder="Raksti savu komentāru..."
            class="w-full rounded-lg border border-gray-700 bg-gray-900/70 text-gray-100 p-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none resize-none"
          ></textarea>
          <button
            @click="addComment"
            class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition"
          >
            Publicēt
          </button>
        </div>

        <div v-if="comments.length > 0" class="space-y-4">
          <div
            v-for="(comment, index) in comments"
            :key="index"
            class="p-4 rounded-xl border border-gray-800 bg-gray-900/50"
          >
            <p class="text-gray-200">{{ comment.comment_text }}</p>
            <p class="text-xs text-gray-500 mt-1">
              {{ comment.user?.username || "Anonīms" }} • {{ formatDate(comment.created_at) }}
            </p>
            <button
              v-if="comment.user?.id === user?.id"
              @click="deleteComment(comment.id)"
              class="text-red-500 text-sm hover:underline mt-2"
            >
              Dzēst
            </button>
          </div>
        </div>

        <p v-else class="text-sm text-gray-500">Vēl nav komentāru.</p>
      </section>

      <div v-else class="text-center text-gray-500 py-20">Ielādē vakanci...</div>
    </main>

    <!-- Application Modal -->
    <div
      v-if="showApplicationModal"
      class="fixed inset-0 bg-black/60 flex items-center justify-center z-50"
    >
      <div
        class="bg-[#111318] rounded-2xl border border-gray-800 shadow-2xl p-8 w-full max-w-lg relative"
      >
        <button
          @click="showApplicationModal = false"
          class="absolute top-3 right-4 text-gray-400 hover:text-gray-200 text-xl"
        >
          &times;
        </button>

        <h2 class="text-2xl font-semibold text-white mb-4">
          Pieteikties vakancei:
          <span class="text-indigo-400">{{ vacancy.title }}</span>
        </h2>

        <textarea
          v-model="coverLetter"
          placeholder="Raksti motivācijas vēstuli..."
          class="w-full rounded-lg border border-gray-700 bg-gray-900/70 text-gray-100 p-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none mb-3"
        ></textarea>

        <input
          type="file"
          @change="handleFile"
          accept="application/pdf"
          class="text-sm text-gray-300 mb-4"
        />

        <button
          @click="submitApplication"
          class="w-full px-5 py-2.5 bg-gradient-to-r from-indigo-600 via-fuchsia-500 to-cyan-500 text-white rounded-lg text-sm font-semibold hover:opacity-90 transition"
        >
          Nosūtīt pieteikumu
        </button>
      </div>
    </div>

    <!-- Edit Modal -->
    <div
      v-if="showEditModal"
      class="fixed inset-0 bg-black/60 flex items-center justify-center z-50"
    >
      <div
        class="bg-[#111318] rounded-2xl border border-gray-800 shadow-2xl p-8 w-full max-w-lg relative space-y-4"
      >
        <button
          @click="showEditModal = false"
          class="absolute top-3 right-4 text-gray-400 hover:text-gray-200 text-xl"
        >
          &times;
        </button>

        <h2 class="text-2xl font-semibold text-white mb-4">
          Rediģēt vakanci:
          <span class="text-indigo-400">{{ vacancy.title }}</span>
        </h2>

        <form @submit.prevent="updateVacancy" class="space-y-4">
          <input
            v-model="editVacancyData.title"
            type="text"
            placeholder="Nosaukums"
            required
            class="input-style"
          />

          <div class="flex gap-4">
            <input
              v-model.number="editVacancyData.salary"
              type="number"
              placeholder="Alga"
              required
              min="0"
              class="input-style flex-grow"
            />
            <select
              v-model="editVacancyData.salary_type"
              required
              class="input-style w-1/3"
            >
              <option value="Brutto">Brutto</option>
              <option value="Neto">Neto</option>
            </select>
          </div>

          <select v-model="editVacancyData.category" required class="input-style">
            <option disabled value="">Izvēlies kategoriju</option>
            <option>IT & Programmēšana</option>
            <option>Pārdošana</option>
            <option>Mārketings</option>
            <option>Finanses</option>
            <option>Loģistika</option>
            <option>Ražošana</option>
            <option>Klientu atbalsts</option>
            <option>Veselība</option>
          </select>

          <select v-model="editVacancyData.county" required class="input-style">
            <option disabled value="">Izvēlies novadu / pilsētu</option>
            <option>Rīga</option>
            <option>Liepāja</option>
            <option>Jelgava</option>
            <option>Daugavpils</option>
            <option>Valmiera</option>
            <option>Ogre</option>
            <option>Ventspils</option>
            <option>Rēzekne</option>
          </select>

          <textarea
            v-model="editVacancyData.description"
            placeholder="Apraksts"
            required
            class="input-style"
          ></textarea>

          <button
            type="submit"
            class="w-full px-5 py-2.5 bg-gradient-to-r from-indigo-600 via-fuchsia-500 to-cyan-500 text-white rounded-lg text-sm font-semibold hover:opacity-90 transition"
          >
            Saglabāt izmaiņas
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import api from "@/services/api";

const route = useRoute();
const router = useRouter();

const vacancy = ref(null);
const user = ref(null);
const role = localStorage.getItem("role");
const token = localStorage.getItem("token");
const isLoggedIn = !!token;

const isFavorited = ref(false);
const comments = ref([]);
const newComment = ref({ comment_text: "", vacancy_id: route.params.id });

const showApplicationModal = ref(false);
const showEditModal = ref(false);
const coverLetter = ref("");
const cvFile = ref(null);

const editVacancyData = ref({
  title: "",
  salary: "",
  salary_type: "Brutto",
  description: "",
  category: "",
  county: "",
});

// ====== FETCHING ======
const fetchUser = async () => {
  if (!token) return;
  try {
    const res = await api.get("/user", {
      headers: { Authorization: `Bearer ${token}` },
    });
    user.value = res.data;
  } catch (err) {
    console.error("Failed to fetch user:", err);
  }
};

const fetchVacancy = async () => {
  try {
    const res = await api.get(`/vacancies/${route.params.id}`);
    vacancy.value = res.data.data || res.data;
  } catch (err) {
    console.error("Failed to fetch vacancy:", err);
  }
};

// ====== EDIT & DELETE ======
const prepareEditData = () => {
  if (!vacancy.value) return;
  editVacancyData.value = {
    title: vacancy.value.title,
    salary: vacancy.value.salary,
    salary_type: vacancy.value.salary_type || "Brutto",
    description: vacancy.value.description,
    category: vacancy.value.category,
    county: vacancy.value.county,
  };
};

const updateVacancy = async () => {
  try {
    const res = await api.put(
      `/vacancies/${vacancy.value.id}`,
      { ...editVacancyData.value },
      { headers: { Authorization: `Bearer ${token}` } }
    );
    vacancy.value = res.data.data;
    showEditModal.value = false;
    alert("✅ Vakance veiksmīgi atjaunota!");
  } catch (err) {
    console.error("Update error:", err);
    alert(err.response?.data?.message || "❌ Neizdevās atjaunot vakanci");
  }
};

const deleteVacancy = async () => {
  if (!confirm("Vai tiešām vēlies dzēst šo vakanci?")) return;
  try {
    await api.delete(`/vacancies/${vacancy.value.id}`, {
      headers: { Authorization: `Bearer ${token}` },
    });
    alert("Vakance dzēsta!");
    router.push("/vacancies");
  } catch (err) {
    console.error("Delete error:", err);
    alert("❌ Neizdevās dzēst vakanci");
  }
};

// ====== PLACEHOLDER METHODS ======
const toggleFavorite = () => {};
const fetchComments = () => {};
const addComment = () => {};
const deleteComment = () => {};
const formatDate = (date) => new Date(date).toLocaleString();
const handleFile = (e) => (cvFile.value = e.target.files[0]);
const submitApplication = () => {};
const fetchFavorites = () => {};

onMounted(async () => {
  await fetchUser();
  await fetchVacancy();
  await fetchComments();
  await fetchFavorites();
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
  border-color: rgb(99 102 241);
  box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.4);
}
</style>
