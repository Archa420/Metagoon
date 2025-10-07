<script setup>
import { ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import api from "@/services/api";

const route = useRoute();
const router = useRouter();

const vacancy = ref(null);
const user = ref(null);
const comments = ref([]);
const commentText = ref("");

// Modal state
const showApplicationModal = ref(false);

// Application form data
const coverLetter = ref("");
const cvFile = ref(null);

// Auth info
const isLoggedIn = !!localStorage.getItem("token");
const role = localStorage.getItem("role");

// Fetch vacancy
const fetchVacancy = async () => {
  try {
    const res = await api.get(`/vacancies/${route.params.id}`);
    vacancy.value = res.data;
  } catch (err) {
    console.error("Failed to fetch vacancy:", err);
  }
};

// Fetch current user
const fetchUser = async () => {
  try {
    const res = await api.get("/user", {
      headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
    });
    user.value = res.data;
  } catch {
    user.value = null;
  }
};

// Delete vacancy
const deleteVacancy = async () => {
  if (!confirm("Do you really want to delete this vacancy?")) return;
  try {
    await api.delete(`/vacancies/${vacancy.value.id}`, {
      headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
    });
    alert("Vacancy deleted successfully");
    router.push("/vakances");
  } catch (err) {
    console.error(err);
    alert(err.response?.data?.message || "Deletion failed");
  }
};

// Comments
const addComment = () => {
  if (!commentText.value.trim()) return;
  comments.value.push({
    text: commentText.value,
    user: user.value?.username || "Anonymous",
    created_at: new Date().toLocaleString(),
  });
  commentText.value = "";
};

// Handle file upload
const handleFile = (e) => {
  cvFile.value = e.target.files[0];
};

// Submit application
const submitApplication = async () => {
  if (!coverLetter.value && !cvFile.value) {
    alert("Please add a cover letter or attach your CV.");
    return;
  }

  const formData = new FormData();
  formData.append("cover_letter", coverLetter.value);
  if (cvFile.value) formData.append("cv", cvFile.value);

  try {
    await api.post(`/vacancies/${vacancy.value.id}/apply`, formData, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`,
        "Content-Type": "multipart/form-data",
      },
    });
    alert("Application submitted!");
    coverLetter.value = "";
    cvFile.value = null;
    showApplicationModal.value = false;
  } catch (err) {
    console.error(err);
    alert(err.response?.data?.message || "Failed to submit application");
  }
};

onMounted(() => {
  fetchVacancy();
  if (isLoggedIn) fetchUser();
});
</script>

<template>
  <div v-if="vacancy" class="max-w-3xl mx-auto p-6 space-y-6 bg-white rounded-2xl shadow-lg">

    <!-- Vacancy Header -->
    <div class="flex justify-between items-start">
      <div>
        <h1 class="text-4xl font-bold text-gray-800">{{ vacancy.title }}</h1>
        <p class="text-gray-500 mt-1">{{ vacancy.company }}</p>
      </div>
      <button
        v-if="user && vacancy.user_id === user.id"
        @click="deleteVacancy"
        class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition"
      >
        Delete
      </button>
    </div>

    <!-- Company Logo -->
    <div class="flex items-center mt-4">
      <img
        v-if="vacancy.logo_url"
        :src="vacancy.logo_url"
        alt="Company Logo"
        class="w-32 h-32 object-cover rounded-xl border"
      />
    </div>

    <!-- Description & Salary -->
    <p class="mt-4 text-gray-700 leading-relaxed">{{ vacancy.description }}</p>
    <p class="mt-3 font-semibold text-indigo-600 text-lg">Salary: {{ vacancy.salary }}</p>

    <!-- Apply Button -->
    <div v-if="isLoggedIn && role !== 'uzņēmējs'" class="mt-6">
      <button
        @click="showApplicationModal = true"
        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition"
      >
        Apply Now
      </button>
    </div>

    <!-- Comments Section -->
    <div class="mt-8">
      <h2 class="text-2xl font-semibold mb-4">Comments</h2>

      <div v-if="isLoggedIn" class="mb-6">
        <textarea
          v-model="commentText"
          placeholder="Write a comment..."
          class="w-full p-3 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
        ></textarea>
        <button
          @click="addComment"
          class="mt-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition"
        >
          Post Comment
        </button>
      </div>

      <div class="space-y-4">
        <div
          v-for="(comment, index) in comments"
          :key="index"
          class="p-4 bg-gray-100 rounded-lg"
        >
          <p class="text-gray-800">{{ comment.text }}</p>
          <p class="text-gray-500 text-sm mt-1">
            By {{ comment.user }} • {{ comment.created_at }}
          </p>
        </div>
        <div v-if="comments.length === 0" class="text-gray-400 text-sm">No comments yet.</div>
      </div>
    </div>
  </div>

  <!-- Loading -->
  <div v-else class="text-center text-gray-500 mt-10">Loading...</div>

  <!-- Modal -->
  <div
    v-if="showApplicationModal"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
  >
    <div class="bg-white rounded-2xl p-6 w-full max-w-lg relative">
      <button @click="showApplicationModal = false" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800">&times;</button>
      <h2 class="text-2xl font-semibold mb-4">Apply for {{ vacancy.title }}</h2>
      <textarea
        v-model="coverLetter"
        placeholder="Write your cover letter..."
        class="w-full border rounded-lg p-2 mb-2 focus:ring-indigo-500 focus:border-indigo-500"
      ></textarea>
      <input type="file" @change="handleFile" accept="application/pdf" class="mb-2" />
      <button
        @click="submitApplication"
        class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition"
      >
        Submit Application
      </button>
    </div>
  </div>
</template>

<style scoped>
textarea { resize: vertical; min-height: 80px; }
</style>
