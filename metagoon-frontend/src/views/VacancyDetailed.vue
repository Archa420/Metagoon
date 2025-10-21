<template>
  <div class="min-h-screen bg-[#0b0c10] text-gray-100 flex flex-col px-4">

    <main class="max-w-4xl mx-auto w-full py-12 space-y-10">
      <!-- Vacancy Card -->
      <section
        v-if="vacancy"
        class="rounded-2xl border border-gray-800 bg-[#111318]/90 shadow-xl backdrop-blur-sm p-8 space-y-6"
      >
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
          <div class="space-y-1">
            <h1 class="text-4xl font-bold text-white">{{ vacancy.title }}</h1>
            <p class="text-gray-300">{{ vacancy.company }}</p>
            <p class="text-gray-400 text-sm">Atrašanās vieta: {{ vacancy.county }}</p>
          </div>

          <div class="flex flex-wrap gap-3">
            <button
              @click="toggleFavorite"
              class="px-5 py-2 rounded-lg border border-gray-700 text-sm text-gray-300 hover:bg-gray-800 transition"
            >
              {{ isFavorited ? "Noņemt no favorītiem" : "Pievienot favorītiem" }}
            </button>

            <button
              v-if="user && vacancy.user_id === user.id || role === 'admin'"
              @click="deleteVacancy"
              class="px-5 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white text-sm font-medium transition"
            >
              Dzēst
            </button>
          </div>
        </div>

        <!-- Company Logo -->
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

        <!-- Add Comment -->
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

        <!-- Comment List -->
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
          </div>
        </div>

        <p v-else class="text-sm text-gray-500">Vēl nav komentāru.</p>
      </section>

      <!-- Loading -->
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
  </div>
</template>

<script setup>
import Header from "@/components/Header.vue";
import { ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import api from "@/services/api";

const route = useRoute();
const router = useRouter();
const isFavorited = ref(false);
const vacancy = ref(null);
const user = ref(null);
const comments = ref([]);
const newComment = ref({ comment_text: "", vacancy_id: route.params.id });
const showApplicationModal = ref(false);
const coverLetter = ref("");
const cvFile = ref(null);
const token = localStorage.getItem("token");
const isLoggedIn = !!token;
const role = localStorage.getItem("role");

const fetchVacancy = async () => {
  try {
    const res = await api.get(`/vacancies/${route.params.id}`);
    vacancy.value = res.data.data || res.data;
  } catch (err) {
    console.error("Failed to fetch vacancy:", err);
  }
};
const fetchUser = async () => {
  if (!token) return;
  try {
    const res = await api.get("/user", { headers: { Authorization: `Bearer ${token}` } });
    user.value = res.data;
  } catch {
    user.value = null;
  }
};
const fetchComments = async () => {
  try {
    const res = await api.get(`/vacancies/${route.params.id}/comments`);
    comments.value = res.data.data || res.data;
  } catch (err) {
    console.error("Failed to load comments:", err);
  }
};
const deleteVacancy = async () => {
  if (!confirm("Vai tiešām vēlies dzēst šo vakanci?")) return;
  try {
    await api.delete(`/vacancies/${vacancy.value.id}`, { headers: { Authorization: `Bearer ${token}` } });
    alert("Vakance dzēsta veiksmīgi");
    router.push("/vakances");
  } catch (err) {
    console.error(err);
    alert(err.response?.data?.message || "Dzēšana neizdevās");
  }
};
const addComment = async () => {
  if (!newComment.value.comment_text.trim()) return alert("Ieraksti komentāru!");
  try {
    await api.post("/comments", newComment.value, { headers: { Authorization: `Bearer ${token}` } });
    newComment.value.comment_text = "";
    await fetchComments();
  } catch (err) {
    console.error(err);
    alert(err.response?.data?.message || "Neizdevās pievienot komentāru");
  }
};
const handleFile = (e) => (cvFile.value = e.target.files[0]);
const formatDate = (d) => (d ? new Date(d).toLocaleString() : "");
const submitApplication = async () => {
  if (!coverLetter.value && !cvFile.value) return alert("Pievieno motivācijas vēstuli vai CV.");
  const formData = new FormData();
  formData.append("cover_letter", coverLetter.value);
  if (cvFile.value) formData.append("cv", cvFile.value);
  try {
    await api.post(`/vacancies/${vacancy.value.id}/apply`, formData, {
      headers: { Authorization: `Bearer ${token}`, "Content-Type": "multipart/form-data" },
    });
    alert("Pieteikums nosūtīts!");
    coverLetter.value = "";
    cvFile.value = null;
    showApplicationModal.value = false;
  } catch (err) {
    console.error(err);
    alert(err.response?.data?.message || "Neizdevās nosūtīt pieteikumu");
  }
};
const fetchFavorites = async () => {
  if (!isLoggedIn) return;
  try {
    const res = await api.get("/favorites", { headers: { Authorization: `Bearer ${token}` } });
    isFavorited.value = res.data.some((f) => f.job_vacancy_id === vacancy.value.id);
  } catch {}
};
const toggleFavorite = async () => {
  if (!isLoggedIn) return alert("Lūdzu pieslēdzies, lai pievienotu favorītiem");
  try {
    const res = await api.post(`/favorites/toggle/${vacancy.value.id}`, null, {
      headers: { Authorization: `Bearer ${token}` },
    });
    isFavorited.value = res.data.favorited;
  } catch (err) {
    console.error(err);
    alert(err.response?.data?.message || "Neizdevās veikt darbību");
  }
};
onMounted(async () => {
  await fetchVacancy();
  await fetchComments();
  await fetchUser();
  await fetchFavorites();
});
</script>

<style scoped>
textarea {
  resize: vertical;
  min-height: 80px;
}
</style>
